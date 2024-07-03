import '../common.js';

document.getElementById('file').addEventListener('change', (e) => {
    const file = e.target.files[0];
    document.getElementById('file_name').value = file.name;
})
