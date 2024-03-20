import '../common.js';
import axios from "axios";

const indicator = document.getElementById('indicator');
const container = document.getElementById('container');

window.addEventListener('load', () => {
    document.querySelectorAll('.update-user').forEach((element) => {
        element.addEventListener('click', () => {
            userUpdate(element.getAttribute('data-id'));
        });
    });
    document.querySelectorAll('.delete-user').forEach((element) => {
        element.addEventListener('click', () => {
            userDelete(element.getAttribute('data-id'));
        });
    });
    document.getElementById('createBtn').addEventListener('click', () => {
        userAdd();
    });
});

const userUpdate = (id) => {
    const userName = document.querySelector('.user[data-id="' + id + '"]').value;
    const userMail = document.querySelector('.email[data-id="' + id + '"]').value;
    const userBelong = document.querySelector('.department[data-id="' + id + '"]').value;
    const sendData = {
        token: Laravel.csrfToken,
        id: id,
        name: userName,
        email: userMail,
        belong_to: userBelong,
    };
    console.log(sendData);
    axios.post('/api/admin/user/edit', sendData)
        .then((response) => {
            console.log(response);
            if (response.data.status === 'success') {
                indicator.classList.remove('text-red-500');
                indicator.classList.add('text-green-500');
                indicator.textContent = '更新しました';
            } else {
                indicator.classList.remove('text-green-500');
                indicator.classList.add('text-red-500');
                indicator.textContent = '更新に失敗しました';
            }
        })
        .catch((error) => {
            console.log(error);
            indicator.classList.remove('text-green-500');
            indicator.classList.add('text-red-500');
            indicator.textContent = '更新に失敗しました';
        });
}

const userDelete = (id) => {
    const userName = document.querySelector('.user[data-id="' + id + '"]').value;
    if (!confirm(userName + 'さんを本当に削除しますか？')) {
        return;
    }
    if (!confirm(userName + 'を削除すると元に戻せません。本当に削除しますか？')) {
        return;
    }
    const sendData = {
        token: Laravel.csrfToken,
        id: id,
    };
    console.log(sendData);
    axios.post('/api/admin/user/delete', sendData)
        .then((response) => {
            console.log(response);
            if (response.data.status === 'success') {
                indicator.classList.remove('text-red-500');
                indicator.classList.add('text-green-500');
                indicator.textContent = '削除しました';
                location.reload();
            } else {
                indicator.classList.remove('text-green-500');
                indicator.classList.add('text-red-500');
                indicator.textContent = '削除に失敗しました';
            }
        })
        .catch((error) => {
            console.log(error);
            indicator.classList.remove('text-green-500');
            indicator.classList.add('text-red-500');
            indicator.textContent = '削除に失敗しました';
        });
}

const userAdd = () => {
    const wrapper = document.createElement('div');
    wrapper.classList.add('flex', 'gap-2', 'items-center');
    const iconWrapper = document.createElement('div');
    iconWrapper.classList.add('flex', 'items-center', 'justify-center', 'w-10', 'h-10', 'rounded-full', 'border');
    const icon = document.createElement('i');
    icon.classList.add('bi', 'bi-person-badge', 'text-2xl');
    iconWrapper.appendChild(icon);
    wrapper.appendChild(iconWrapper);
    const nameInput = document.createElement('input');
    nameInput.setAttribute('type', 'text');
    nameInput.setAttribute('placeholder', '名前');
    nameInput.classList.add('text-base', 'p-2', 'flex-1', 'user', 'create-name');
    wrapper.appendChild(nameInput);
    const mailInput = document.createElement('input');
    mailInput.setAttribute('type', 'email');
    mailInput.setAttribute('placeholder', 'メールアドレス');
    mailInput.classList.add('text-base', 'p-2', 'flex-1', 'email', 'create-email');
    wrapper.appendChild(mailInput);
    const belongSelect = document.createElement('select');
    belongSelect.classList.add('department', 'create-department');
    const selectOption = document.createElement('option');
    selectOption.setAttribute('value', '0');
    selectOption.classList.add('hidden');
    selectOption.innerText = 'Select Department';
    belongSelect.appendChild(selectOption);
    Laravel.departments.forEach((department) => {
        const option = document.createElement('option');
        option.setAttribute('value', department.id);
        option.innerText = department.name;
        belongSelect.appendChild(option);
    });
    wrapper.appendChild(belongSelect);
    const createButton = document.createElement('button');
    createButton.classList.add('create-button', 'bg-green-500', 'text-white', 'p-2', 'rounded-lg', 'hover:bg-green-800');
    createButton.innerText = 'Create';
    createButton.addEventListener('click', () => {
        userCreate();
    });
    wrapper.appendChild(createButton);
    container.appendChild(wrapper);
    document.getElementById('createBtn').classList.add('hidden');
}

const userCreate = () => {
    const name = document.querySelector('.create-name').value;
    const email = document.querySelector('.create-email').value;
    const belong = document.querySelector('.create-department').value;
    const sendData = {
        token: Laravel.csrfToken,
        name: name,
        email: email,
        belong_to: belong,
    };
    console.log(sendData);
    axios.post('/api/admin/user/create', sendData)
        .then((response) => {
            console.log(response);
            if (response.data.status === 'success') {
                indicator.classList.remove('text-red-500');
                indicator.classList.add('text-green-500');
                indicator.textContent = '追加しました';
                location.reload();
            } else {
                indicator.classList.remove('text-green-500');
                indicator.classList.add('text-red-500');
                indicator.textContent = '追加に失敗しました';
            }
        })
        .catch((error) => {
            console.log(error);
            indicator.classList.remove('text-green-500');
            indicator.classList.add('text-red-500');
            indicator.textContent = '追加に失敗しました';
        });
}
