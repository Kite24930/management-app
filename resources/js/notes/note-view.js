import '../common.js';
import { Linkify } from "quill-linkify";
import hljs from 'highlight.js';
import Quill from 'quill';
import axios from 'axios';

Quill.register('modules/linkify', Linkify);
const quill = new Quill('#note', {
    // debug: 'info',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'color': [] }, { 'background': [] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, {'list' : 'check'}],
            ['link'],
            ['code-block', 'blockquote'],
            ['clean']
        ],
        linkify: true,
        syntax: {
            hljs,
        },
    },
    theme: 'snow',
    readOnly: true
});

window.addEventListener('load', () => {
    document.querySelector('.ql-toolbar').remove();

    setNotes();

    const links = document.querySelectorAll('.ql-editor a');
    // console.log('links', links);
    if (links.length > 0) {
        links.forEach((link) => {
            const href = link.getAttribute('href');
            // console.log('href', href);
            const favicon = document.querySelector('#note a[href="' + href + '"] img');
            // console.log('favicon', favicon);
            if (favicon === null) {
                getFavicon(href);
            }
        });
    }
})

const setNotes = () => {
    let contents = [];
    Laravel.notes.forEach((note) => {
        contents.push({
            insert: JSON.parse(note.insert),
            attributes: JSON.parse(note.attributes),
        })
    });
    quill.setContents(contents);
}

const getFavicon = (url) => {
    axios.post('/api/notes/fetch/url', { url: url })
        .then((response) => {
            console.log('response', response.data);
            const link = document.querySelector('#note a[href="' + url + '"]');
            if (response.data.favicon !== null || response.data.title !== null) {
                link.innerHTML = '';
                link.classList.add('px-2', 'border', 'border-gray-300', 'rounded', 'shadow', 'mb-2', 'inline-block');
            }
            if (response.data.favicon !== null) {
                const favicon = document.createElement('img');
                favicon.src = response.data.favicon;
                favicon.classList.add('favicon-img', 'w-4', 'h-4', 'object-contain', 'inline-block', 'mr-2');
                link.appendChild(favicon);
            }
            if (response.data.title !== null) {
                link.innerHTML += response.data.title;
            }
        });
}
