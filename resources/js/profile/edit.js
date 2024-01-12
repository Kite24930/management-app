document.getElementById('icon').addEventListener('change', (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    const iconWrapper = document.getElementById('iconWrapper');
    reader.addEventListener('load', (e) => {
        const img = document.createElement('img');
        img.classList.add('w-10', 'h-10', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
        img.src = e.target.result;
        iconWrapper.innerHTML = '';
        iconWrapper.appendChild(img);
    });
    reader.readAsDataURL(file);
})
