import '../common.js';
import Quill from "quill";

let quill = null;

// 初期Quillエディタの初期化
const initializeQuillEditor = (selector, contents = null) => {
    quill = new Quill(selector, {
        modules: {
            toolbar: [
                [{ size: [] }, { 'font': [] }],
                ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' },
                    { 'indent': '-1' }, { 'indent': '+1' }],
                ['link'],
                ['clean']
            ]
        },
        placeholder: 'Let\'s write something awesome!',
        theme: 'snow'
    });
    if (contents) {
        quill.setContents(JSON.parse(contents));
    }
};

const editor = document.getElementById('editor');
if (Laravel.target) {
    initializeQuillEditor(editor, Laravel.target.target_description);
} else {
    initializeQuillEditor(editor);
}

document.getElementById('registerBtn').addEventListener('click', (e) => {
    const userId = Laravel.user.id;
    const targetMonth = document.getElementById('targetMonth').value;
    const targetDescription = JSON.stringify(quill.getContents()['ops']);
    const sendData = {
        user_id: userId,
        target_month: targetMonth + '-01',
        target_description: targetDescription,
        _token: Laravel.csrfToken,
    };
    axios.post('/monthly/targets/edit', sendData)
        .then((res) => {
            if (res.data.status === 'success') {
                window.location.href = '/monthly/targets';
            } else {
                alert('更新に失敗しました');
                console.log(res.data);
            }
        })
        .catch((error) => {
            console.error(error);
        });
})
