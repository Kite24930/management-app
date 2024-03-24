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
    placeholder: 'Let\'s write something awesome!',
    theme: 'snow'
});

quill.on('text-change', function(delta, oldDelta, source) {
    console.log(quill.getContents());
});

window.addEventListener('load', () => {
    setNotes();
})

// const getFavicon = (url) => {
//     axios.post('/api/notes/fetch/url', { url: url })
//         .then((response) => {
//             console.log('response', response.data);
//             const link = document.querySelector('#note a[href="' + url + '"]');
//             if (response.data.favicon !== null || response.data.title !== null) {
//                 link.innerHTML = '';
//                 link.classList.add('px-2', 'border', 'border-gray-300', 'rounded', 'shadow', 'mb-2', 'inline-block');
//             }
//             if (response.data.favicon !== null) {
//                 const favicon = document.createElement('img');
//                 favicon.src = response.data.favicon;
//                 favicon.classList.add('favicon-img', 'w-4', 'h-4', 'object-contain', 'inline-block', 'mr-2');
//                 link.appendChild(favicon);
//             }
//             if (response.data.title !== null) {
//                 link.innerHTML += response.data.title;
//             }
//         });
// }

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

document.getElementById('updateBtn').addEventListener('click', (e) => {
    const noteId = e.target.getAttribute('data-id');
    const contents = quill.getContents().ops;
    let sendContents = [];
    contents.forEach((content) => {
        sendContents.push({
            insert: JSON.stringify(content.insert),
            attributes: content.attributes,
        });
    });
    const sendData = {
        id: noteId,
        contents: sendContents,
    }
    console.log('sendData', sendData);
    axios.post('/api/notes/update', sendData)
        .then((response) => {
            console.log('response', response.data);
            window.location.href = '/notes/view/' + noteId;
        })
        .catch((error) => {
            console.error('error', error);
        });
});
