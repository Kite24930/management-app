import '../common.js';
import hljs from 'highlight.js';
import Quill from 'quill';
import axios from 'axios';
import 'flowbite';

let quill;

window.addEventListener('load', () => {
    quill = new Quill('#note', {
        // debug: 'info',
        modules: {
            toolbar: '#toolbar',
            syntax: {
                hljs,
            },
            clipboard: {

            }
        },
        placeholder: 'Let\'s write something awesome!',
        theme: 'snow'
    });

    quill.on('text-change', function(delta, oldDelta, source) {
        console.log(quill.getContents());
    });

    document.getElementById('note').addEventListener('paste', (e) => {
        console.log('paste', e.clipboardData.getData('text/plain'));
        const urlRegex = /(https?:\/\/[^\s\n]+)/g; // URLを検出するための正規表現
        const text = e.clipboardData.getData('text/plain');
        if (urlRegex.test(text)) {
            const range = quill.getSelection();
            if (range) {
                const [line, offset] = quill.getLine(range.index);
                const contents = quill.getContents(range.index - offset, line.length() - 1);
                if (contents.ops.length === 1 && contents.ops[0].insert === text) {
                    quill.formatText(range.index - offset, line.length() - 1, {
                        link: text,
                    });
                }
            }
        }
    });

    setNotes();
    setLink();
    // getFavicon();
});

document.querySelector('#toolbar .ql-index-item').addEventListener('click', () => {
    const range = quill.getSelection();
    if (range) {
        if (range.length === 0) {
            const [line, offset] = quill.getLine(range.index);

            quill.formatText(range.index - offset, line.length() - 1, {
                font: false,
                color: false,
                background: false,
                bold: true,
                italic: false,
                underline: true,
                strike: false,
                link: false,
            });
            quill.formatLine(range.index - offset, line.length(), {
                header: 3,
                list: false,
                indent: false,
                code: false,
                blockquote: false,
            });
        } else {
            const [startLine, startLineOffset] = quill.getLine(range.index);
            const endLine = quill.getLine(range.index + range.length)[0];

            if (startLine === endLine) {
                quill.formatText(range.index - startLineOffset, startLine.length() - 1, {
                    font: false,
                    color: false,
                    background: false,
                    bold: true,
                    italic: false,
                    underline: true,
                    strike: false,
                    link: false,
                });
                quill.formatLine(range.index - startLineOffset, startLine.length(), {
                    header: 3,
                    list: false,
                    indent: false,
                    code: false,
                    blockquote: false,
                });
            } else {
                window.alert('インデックスは単一行に制限されています。');
            }
        }
    }
});

const getFavicon = (url) => {
    const links = document.querySelectorAll('.ql-editor a');
    let hrefs = [];
    if (links.length > 0) {
        links.forEach((link) => {
            const href = link.getAttribute('href');
            const favicon = document.querySelector('#note a[href="' + href + '"] img');
            if (favicon === null && link.innerHTML === href) {
                hrefs.push(href);
            }
        });
    }
    console.log('links', links);
    console.log('hrefs', hrefs);
    if (hrefs.length > 0) {
        axios.post('/api/notes/fetch/url', { url: hrefs })
            .then((response) => {
                console.log('response', response.data);
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
        console.log('el', el);
        setIndex(index, el);
    });
}

const setLink = () => {
    const links = document.querySelectorAll('.ql-editor a');
    let hrefs = [];
    if (links.length > 0) {
        links.forEach((link) => {
            const linkData = Laravel.links.find(({url}) => url === link.getAttribute('href'));
            if (typeof linkData !== 'undefined') {
                if (linkData.favicon !== null || linkData.title !== null) {
                    link.innerHTML = '';
                    link.classList.add('px-2', 'border', 'border-gray-300', 'rounded', 'shadow', 'mb-2', 'inline-block');
                }
                if (linkData.favicon !== null) {
                    const favicon = document.createElement('img');
                    favicon.src = linkData.favicon;
                    favicon.classList.add('favicon-img', 'w-4', 'h-4', 'object-contain', 'inline-block', 'mr-2');
                    link.appendChild(favicon);
                }
                if (linkData.title !== null) {
                    link.innerHTML += linkData.title;
                }
            }
        });
    }
}

document.getElementById('updateBtn').addEventListener('click', (e) => {
    linkReset();
    const noteId = e.target.getAttribute('data-id');
    const contents = quill.getContents().ops;
    let sendContents = [];
    let sendLinks = [];
    contents.forEach((content) => {
        sendContents.push({
            insert: JSON.stringify(content.insert),
            attributes: content.attributes,
        });
        if (content.attributes !== undefined) {
            if (content.attributes.link !== undefined) {
                if (Laravel.links.find(({url}) => url === content.attributes.link) === undefined) {
                    sendLinks.push(content.attributes.link);
                }
            }
        }
    });
    const sendData = {
        id: noteId,
        contents: sendContents,
    }
    console.log('sendData', sendData);
    console.log('sendLinks', sendLinks);
    if (sendLinks.length > 0) {
        axios.post('/api/notes/fetch/url', {url: sendLinks})
            .then((response) => {
                console.log('response', response.data);
            });
    }
    axios.post('/api/notes/update', sendData)
        .then((response) => {
            console.log('response', response.data);
            window.location.href = '/notes/view/' + noteId;
        })
        .catch((error) => {
            console.error('error', error);
        });
});

const linkReset = () => {
    const links = document.querySelectorAll('.ql-editor a');
    links.forEach((link) => {
        link.innerHTML = link.getAttribute('href');
    });
}

document.getElementById('linkAppearance').addEventListener('change', (e) => {
    console.log('e', e.target.checked);
    if (e.target.checked) {
        setLink();
    } else {
        linkReset();
    }
});

document.getElementById('indexBtn').addEventListener('click', () => {
    const indexContainer = document.getElementById('indexContainer');
    indexContainer.classList.remove('-right-60');
    indexContainer.classList.add('right-0');
});

const indexCloseBtn = document.getElementById('closeIndexBtn');
indexCloseBtn.addEventListener('click', () => {
    const indexContainer = document.getElementById('indexContainer');
    indexContainer.classList.remove('right-0');
    indexContainer.classList.add('-right-60');
});


function setIndex(index, el) {
    const indexWrapper = document.getElementById('indexWrapper');
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
    indexWrapper.appendChild(indexBtn);
}

function moveToIndex(index) {
    const target = document.getElementById(index);
    target.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
    });
}
