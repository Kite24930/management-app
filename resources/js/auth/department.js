import '../common.js';
import axios from 'axios';

const indicator = document.getElementById('indicator');
let wrapper = document.createElement('div');
wrapper.classList.add('flex', 'flex-col', 'justify-between', 'items-center', 'w-full', 'ml-6', 'gap-2');
let container = document.createElement('div');
container.classList.add('flex', 'w-full', 'items-center');
let icon = document.createElement('i');
icon.classList.add('bi', 'bi-building', 'mr-2');
let input = document.createElement('input');
input.type = 'text';
input.classList.add('text-sm', 'p-2', 'border-none', 'rounded-lg', 'flex-1', 'department');

window.addEventListener('load', () => {
    Laravel.departments.forEach((department) => {
        if(department.parent_department !== 0) {
            const departmentWrapper = wrapper.cloneNode(true);
            departmentWrapper.id = `department-${department.id}`;
            const departmentContainer = container.cloneNode(true);
            const departmentIcon = icon.cloneNode(true);
            const departmentInput = input.cloneNode(true);
            departmentInput.setAttribute('data-id', department.id);
            departmentInput.setAttribute('data-parent', department.parent_department);
            departmentInput.value = department.name;
            departmentContainer.appendChild(departmentIcon);
            departmentContainer.appendChild(departmentInput);
            departmentWrapper.appendChild(departmentContainer);
            document.getElementById(`department-${department.parent_department}`).appendChild(departmentWrapper);
        }
    });

    departmentEdit();
});


const departmentEdit = () => {
    document.querySelectorAll('.department').forEach((department) => {
        department.addEventListener('focusout', (e) => {
            const id = e.target.getAttribute('data-id');
            const parent = e.target.getAttribute('data-parent');
            const name = e.target.value;
            if(name !== '') {
                const sendData = {
                    token: Laravel.csrfToken,
                    id: id,
                    parent_department: parent,
                    name: name
                };
                axios.post('/api/admin/department', sendData)
                    .then((response) => {
                        console.log(response);
                        if (response.data.status === 'success') {
                            indicator.classList.remove('text-red-500');
                            indicator.classList.add('text-green-500');
                            indicator.innerHTML = 'Department name updated successfully';
                        } else {
                            indicator.classList.remove('text-green-500');
                            indicator.classList.add('text-red-500');
                            indicator.innerHTML = 'An error occurred while updating department name';
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        indicator.classList.remove('text-green-500');
                        indicator.classList.add('text-red-500');
                        indicator.innerHTML = 'An error occurred while updating department name';
                    });
            } else {
                indicator.innerHTML = 'Please enter a valid department name';
            }
        });
    });
}
