import './app.js';
import '/node_modules/flowbite/dist/flowbite.min.js';

const headerToggleButton = document.getElementById('headerToggleButton');
const toggleHide = document.getElementById('toggleHide');
const toggleShow = document.getElementById('toggleShow');

if (headerToggleButton) {
    headerToggleButton.addEventListener('click', () => {
        document.getElementById('header').classList.toggle('hide');
        toggleHide.classList.toggle('hidden');
        toggleShow.classList.toggle('hidden');
        document.getElementsByTagName('main')[0].classList.toggle('full');
    });
}
