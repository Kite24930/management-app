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
    let hrefs = [];
    if (links.length > 0) {
        links.forEach((link) => {
            const href = link.getAttribute('href');
            // console.log('href', href);
            hrefs.push(href);
        });
    }
    if (hrefs.length > 0) {
        getFavicon(hrefs);
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
    document.querySelectorAll('h3').forEach((el, index) => {
        setIndex(index, el);
    });
}

function getFavicon (url) {
    let registered = [];
    let notRegistered = [];
    url.forEach((u) => {
        if (Laravel.links.find(({url}) => url === u) !== undefined) {
            registered.push(u);
        } else {
            notRegistered.push(u);
        }
    });
    if (registered.length > 0) {
        registered.forEach((u) => {
            const linkData = Laravel.links.find(({url}) => url === u);
            if (linkData !== undefined) {
                const link = document.querySelector('#note a[href="' + u + '"]');
                link.innerHTML = '';
                if (linkData.favicon !== null) {
                    const favicon = document.createElement('img');
                    favicon.src = linkData.favicon;
                    favicon.classList.add('favicon-img', 'w-4', 'h-4', 'object-contain', 'inline-block', 'mr-2');
                    link.appendChild(favicon);
                }
                link.innerHTML += linkData.title;
                link.classList.add('px-2', 'border', 'border-gray-300', 'rounded', 'shadow', 'mb-2', 'inline-block');
            }
        });
    }
    if (notRegistered.length > 0) {
        axios.post('/api/notes/fetch/url', {
            url: notRegistered
        })
        .then((response) => {
            response.data.results.forEach((result) => {
                const link = document.querySelector('#note a[href="' + result.url + '"]');
                if (result.favicon !== null || result.title !== null) {
                    link.innerHTML = '';
                    link.classList.add('px-2', 'border', 'border-gray-300', 'rounded', 'shadow', 'mb-2', 'inline-block');
                }
                if (result.favicon !== null) {
                    const favicon = document.createElement('img');
                    favicon.src = result.favicon;
                    favicon.classList.add('favicon-img', 'w-4', 'h-4', 'object-contain', 'inline-block', 'mr-2');
                    link.appendChild(favicon);
                }
                if (result.title !== null) {
                    link.innerHTML += result.title;
                }
            });
        })
        .catch(
            (error) => {
                console.error('error', error);
            }
        );
    }
}

document.getElementById('indexBtn').addEventListener('click', () => {
    const indexContainer = document.getElementById('indexContainer');
    indexContainer.classList.remove('-right-40');
    indexContainer.classList.add('right-0');
});

const indexCloseBtn = document.getElementById('closeIndexBtn');
indexCloseBtn.addEventListener('click', () => {
    const indexContainer = document.getElementById('indexContainer');
    indexContainer.classList.remove('right-0');
    indexContainer.classList.add('-right-40');
});


function setIndex(index, el) {
    const targetId = 'index-' + index;
    el.id = targetId;
    const labelName = el.innerText;
    const indexBtn = document.createElement('button');
    indexBtn.innerText = labelName;
    indexBtn.type = 'button';
    indexBtn.setAttribute('data-target', targetId);
    indexBtn.addEventListener('click', (e) => {
        const target = e.target.getAttribute('data-target');
        moveToIndex(target);
    });
    indexCloseBtn.before(indexBtn);
}

function moveToIndex(index) {
    const target = document.getElementById(index);
    target.scrollIntoView();
}
