import './common.js';
import Sortable from 'sortablejs';
import axios from "axios";
import { initFlowbite } from "flowbite";

const todo = document.getElementById('todo');
const progress = document.getElementById('progress');
const pending = document.getElementById('pending');
const completed = document.getElementById('completed');
const other = document.getElementById('other');
const indicator = document.getElementById('indicator');
const indicatorIcon = document.getElementById('indicatorIcon');
const indicatorText = document.getElementById('indicatorText');

window.addEventListener('load', () => {
    new Sortable(todo, {
        group: 'tasks',
        animation: 150,
        onEnd: (event) => {
            taskOrderPost();
        },
    });

    new Sortable(progress, {
        group: 'tasks',
        animation: 150,
        onEnd: (event) => {
            taskOrderPost();
        },
    });

    new Sortable(pending, {
        group: 'tasks',
        animation: 150,
        onEnd: (event) => {
            taskOrderPost();
        },
    });

    new Sortable(completed, {
        group: 'tasks',
        animation: 150,
        onEnd: (event) => {
            taskOrderPost();
        },
    });

    new Sortable(other, {
        group: 'tasks',
        animation: 150,
        onEnd: (event) => {
            taskOrderPost();
        },
    });

    document.querySelectorAll('.task-item').forEach((el) => {
        const target = el.getAttribute('data-id');
        initFunctions(target);
    });

    indicator.classList.remove('bg-white');
    indicator.classList.add('bg-green-50');
    indicatorIcon.innerHTML = '<i class="bi bi-check2-circle"></i>'
    indicatorText.innerHTML = 'Loaded';
});

function initFunctions(target) {
    document.querySelector('.edit-btn[data-id="' + target + '"]').addEventListener('click', () => {
        taskEdit(target);
    });
    document.querySelector('.task-title[data-id="' + target + '"]').addEventListener('change', (e) => {
        titleEdit(target, e.target);
    });
    document.querySelectorAll('.task-type[data-id="' + target + '"]').forEach((el) => {
        el.addEventListener('click', (e) => {
            projectChange(target, e.target);
        });
    });
    document.querySelectorAll('.task-priority[data-id="' + target + '"]').forEach((el) => {
        el.addEventListener('click', (e) => {
            priorityChange(target, e.target);
        });
    });
    document.querySelectorAll('.task-person[data-id="' + target + '"]').forEach((el) => {
        el.addEventListener('click', (e) => {
            personChange(target, e.target);
        });
    });
    document.querySelector('.start_date[data-id="' + target + '"]').addEventListener('change', (e) => {
        startDateChange(target, e.target);
    });
    document.querySelector('.end_date[data-id="' + target + '"]').addEventListener('change', (e) => {
        endDateChange(target, e.target);
    });
}

function taskEdit(target) {
    const sendData = {
        task_id: target,
    };
    axios.post('/api/taskEdit', sendData)
        .then((res) => {
            console.log(res.data);
            const parser = new DOMParser();
            const doc = parser.parseFromString(res.data.view, 'text/html');
            const targetEl = document.getElementById('modalWrapper');
            targetEl.innerHTML = doc.body.innerHTML;
            targetEl.classList.toggle('hidden');
            targetEl.classList.toggle('flex');
            document.getElementById('modalClose').addEventListener('click', () => {
                window.location.reload();
            });
            document.getElementById('modal-title').addEventListener('change', (e) => {
                modalTitleEdit(target, e.target.value);
            });
            document.querySelectorAll('.modal-priority').forEach((el) => {
                el.addEventListener('click', (e) => {
                    let priorityEl = e.target;
                    while (priorityEl.tagName !== 'LI') {
                        priorityEl = priorityEl.parentNode;
                    }
                    modalPriorityChange(target, priorityEl.getAttribute('data-priority'));
                });
            });
            document.querySelectorAll('.modal-status').forEach((el) => {
                el.addEventListener('click', (e) => {
                    let statusEl = e.target;
                    while (statusEl.tagName !== 'LI') {
                        statusEl = statusEl.parentNode;
                    }
                    modalStatusChange(target, statusEl.getAttribute('data-status'));
                });
            });
            document.querySelectorAll('.modal-type').forEach((el) => {
                el.addEventListener('click', (e) => {
                    let typeEl = e.target;
                    while (typeEl.tagName !== 'LI') {
                        typeEl = typeEl.parentNode;
                    }
                    modalTypeChange(target, typeEl.getAttribute('data-type'));
                });
            });
            initFlowbite();
        })
        .catch((error) => {
            console.log(error);
        });
}

function modalTitleEdit(target, value) {
    const sendData = {
        task_id: target,
        title: value,
    };
    axios.post('/api/taskTitleEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
            } else {
                window.alert('タイトルの変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalPriorityChange(target, value) {
    const sendData = {
        task_id: target,
        priority: value,
    };
    console.log(sendData);
    axios.post('/api/taskPriorityEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const targetEl = document.getElementById('modal-priority');
                targetEl.innerHTML = doc.body.innerHTML;
                targetEl.setAttribute('data-priority', value);
                document.getElementById('modal-priority-list').classList.toggle('hidden');
                indicatorSuccess();
            } else {
                window.alert('優先度の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalStatusChange(target, value) {
    const sendData = {
        task_id: target,
        status: value,
    };
    axios.post('/api/taskStatusEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const targetEl = document.getElementById('modal-status');
                targetEl.innerHTML = doc.body.innerHTML;
                targetEl.setAttribute('data-status', value);
                document.getElementById('modal-status-list').classList.toggle('hidden');
                indicatorSuccess();
            } else {
                window.alert('ステータスの変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalTypeChange(target, value) {
    const sendData = {
        task_id: target,
        type: value,
    };
    axios.post('/api/taskTypeEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const targetEl = document.getElementById('modal-type');
                targetEl.innerHTML = doc.body.innerHTML;
                targetEl.setAttribute('data-type', value);
                document.getElementById('modal-type-list').classList.toggle('hidden');
                indicatorSuccess();
            } else {
                window.alert('プロジェクトの変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalStartDateChange(target, value) {
    const sendData = {
        task_id: target,
        start_date: value,
    };
    axios.post('/api/taskStartDateEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
            } else {
                window.alert('開始日の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalEndDateChange(target, value) {
    const sendData = {
        task_id: target,
        end_date: value,
    };
    axios.post('/api/taskEndDateEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
            } else {
                window.alert('終了日の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalMainPersonChange(target, value) {
    const sendData = {
        task_id: target,
        member_id: value,
    };
    axios.post('/api/taskMainMemberEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                document.getElementById('modal-person').innerHTML = doc.body.innerHTML;
                indicatorSuccess();
            } else {
                window.alert('担当者の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalPersonChange(target, value) {
    let members = [];
    document.querySelectorAll('.modal-member').forEach((el) => {
        if (el.checked) {
            members.push(el.value);
        }
    });
    const sendData = {
        task_id: target,
        members: members,
    };
    axios.post('/api/taskMemberEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const targetEl = document.getElementById('modal-member');
                targetEl.innerHTML = '';
                res.data.members.forEach((member) => {
                    const memberEl = document.createElement('div');
                    memberEl.classList.add('flex', 'items-center');
                    if (member.icon !== null) {
                        const icon = document.createElement('img');
                        icon.src = '/storage/' + member.icon;
                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                        icon.alt = member.name;
                    } else {
                        const icon = document.createElement('i');
                        icon.classList.add('bi', 'bi-person-circle', 'text-gray-400', 'text-2xl', 'mr-2');
                    }
                    memberEl.append(icon);
                    memberEl.innerHTML += member.name;
                    targetEl.append(memberEl);
                });
                indicatorSuccess();
            } else {
                window.alert('担当者の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function titleEdit(target, el) {
    indicatorPost();
    const sendData = {
        task_id: target,
        title: el.value,
    };
    axios.post('/api/taskTitleEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
            } else {
                window.alert('タイトルの変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function projectChange(target, el) {
    indicatorPost();
    let typeEl = el;
    while (typeEl.tagName !== 'LI') {
        typeEl = typeEl.parentNode;
    }
    const sendData = {
        task_id: target,
        type: typeEl.getAttribute('data-type'),
    };
    axios.post('/api/taskTypeEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const targetEl = document.getElementById('type-' + target);
                targetEl.innerHTML = doc.body.innerHTML;
                document.getElementById('type-list-' + target).classList.toggle('hidden');
                initFlowbite();
            } else {
                window.alert('プロジェクトの変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function priorityChange(target, el) {
    indicatorPost();
    let priorityEl = el;
    while (priorityEl.tagName !== 'LI') {
        priorityEl = priorityEl.parentNode;
    }
    const sendData = {
        task_id: target,
        priority: priorityEl.getAttribute('data-type'),
    };
    axios.post('/api/taskPriorityEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const targetEl = document.getElementById('priority-' + target);
                targetEl.innerHTML = doc.body.innerHTML;
                document.getElementById('priority-list-' + target).classList.toggle('hidden');
                initFlowbite();
            } else {
                window.alert('優先度の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function personChange(target, el) {
    indicatorPost();
    let personEl = el;
    while (personEl.tagName !== 'LI') {
        personEl = personEl.parentNode;
    }
    const sendData = {
        task_id: target,
        member_id: personEl.getAttribute('data-type'),
    };
    console.log(sendData);
    axios.post('/api/taskMainMemberEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
                const mainPerson = document.getElementById('main-person-' + target);
                if (res.data.user.icon !== null) {
                    const icon = document.createElement('img');
                    icon.src = '/storage/' + res.data.user.icon;
                    icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                    icon.alt = res.data.user.name;
                    mainPerson.innerHTML = '';
                    mainPerson.append(icon);
                } else {
                    const icon = document.createElement('i');
                    icon.classList.add('bi', 'bi-person-circle', 'text-gray-400', 'text-3xl', 'mr-2');
                    mainPerson.innerHTML = '';
                    mainPerson.append(icon);
                }
                mainPerson.innerHTML += res.data.user.name;
                document.getElementById('person-list-' + target).classList.toggle('hidden');
                initFlowbite();
            } else {
                window.alert('担当者の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function startDateChange(target) {
    indicatorPost();

}

function endDateChange(target) {
    indicatorPost();

}

const statusList = ['todo', 'progress', 'pending', 'completed', 'other', 'cancel'];
document.querySelectorAll('.task-add').forEach((el) => {
    el.addEventListener('click', () => {
        taskAdd(el);
    });
});
function taskAdd(el) {
    const existRegister = document.querySelector('.register');
    if (existRegister) {
        window.alert('登録中のタスクがあります。\nタスクを登録してから追加してください。');
    } else {
        const status = el.getAttribute('data-status');
        axios.get('/api/addTask?status=' + status)
            .then((res) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(res.data.view, 'text/html');
                const statusId = el.getAttribute('data-status');
                const target = document.getElementById(statusList[statusId]);
                el.before(doc.body.firstChild);
                initFlowbite();
                document.getElementById('register-' + res.data.target).addEventListener('click', () => {
                    taskCreatePost(res.data.target);
                });
                const targetId = res.data.target;
                document.querySelectorAll('.task-type[data-id="' + targetId + '"]').forEach((el) => {
                    el.addEventListener('click', (e) => {
                        indicatorPost();
                        let typeEl = e.target;
                        while (typeEl.tagName !== 'LI') {
                            typeEl = typeEl.parentNode;
                        }
                        const sendData = {
                            type: typeEl.getAttribute('data-type'),
                        };
                        axios.post('/api/taskTypeChange', sendData)
                            .then((res) => {
                                console.log(res);
                                if (res.data.status === 'success') {
                                    indicatorSuccess();
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(res.data.view, 'text/html');
                                    const targetEl = document.getElementById('type-' + targetId);
                                    targetEl.innerHTML = doc.body.innerHTML;
                                    targetEl.setAttribute('data-type', sendData.type);
                                    document.getElementById('type-list-' + targetId).classList.toggle('hidden');
                                    initFlowbite();
                                } else {
                                    window.alert('プロジェクトの変更に失敗しました。');
                                    indicatorError();
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                                indicatorError();
                            });
                    });
                });
                document.querySelectorAll('.task-priority[data-id="' + targetId + '"]').forEach((el) => {
                    el.addEventListener('click', (e) => {
                        indicatorPost();
                        let priorityEl = e.target;
                        while (priorityEl.tagName !== 'LI') {
                            priorityEl = priorityEl.parentNode;
                        }
                        const sendData = {
                            priority: priorityEl.getAttribute('data-type'),
                        };
                        axios.post('/api/taskPriorityChange', sendData)
                            .then((res) => {
                                console.log(res);
                                if (res.data.status === 'success') {
                                    indicatorSuccess();
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(res.data.view, 'text/html');
                                    const targetEl = document.getElementById('priority-' + targetId);
                                    targetEl.innerHTML = doc.body.innerHTML;
                                    targetEl.setAttribute('data-priority', priorityEl.getAttribute('data-type'));
                                    document.getElementById('priority-list-' + targetId).classList.toggle('hidden');
                                    initFlowbite();
                                } else {
                                    window.alert('優先度の変更に失敗しました。');
                                    indicatorError();
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                                indicatorError();
                            });
                    });
                });
                document.querySelectorAll('.task-person[data-id="' + targetId + '"]').forEach((el) => {
                    el.addEventListener('click', (e) => {
                        indicatorPost();
                        let personEl = e.target;
                        while (personEl.tagName !== 'LI') {
                            personEl = personEl.parentNode;
                        }
                        const sendData = {
                            member_id: personEl.getAttribute('data-type'),
                        };
                        console.log(sendData);
                        axios.post('/api/taskMainMemberChange', sendData)
                            .then((res) => {
                                console.log(res);
                                if (res.data.status === 'success') {
                                    indicatorSuccess();
                                    const mainPerson = document.getElementById('main-person-' + targetId);
                                    if (res.data.user.icon !== null) {
                                        const icon = document.createElement('img');
                                        icon.src = '/storage/' + res.data.user.icon;
                                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                                        icon.alt = res.data.user.name;
                                        mainPerson.innerHTML = '';
                                        mainPerson.append(icon);
                                    } else {
                                        const icon = document.createElement('i');
                                        icon.classList.add('bi', 'bi-person-circle', 'text-gray-400', 'text-3xl', 'mr-2');
                                        mainPerson.innerHTML = '';
                                        mainPerson.append(icon);
                                    }
                                    mainPerson.innerHTML += res.data.user.name;
                                    mainPerson.setAttribute('data-person', res.data.user.id);
                                    document.getElementById('person-list-' + targetId).classList.toggle('hidden');
                                    initFlowbite();
                                } else {
                                    window.alert('担当者の変更に失敗しました。');
                                    indicatorError();
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                                indicatorError();
                            });
                    });
                });
            })
            .catch((error) => {
                console.log(error);
            });
    }

}

function taskCreatePost(target) {
    indicatorPost();
    const title = document.querySelector('.task-title[data-id="' + target + '"]').value;
    const type = document.getElementById('type-' + target).getAttribute('data-type');
    const priority = document.getElementById('priority-' + target).getAttribute('data-priority');
    const mainPerson = document.getElementById('main-person-' + target).getAttribute('data-person');
    const startDate = document.querySelector('.start_date[data-id="' + target + '"]').value;
    const endDate = document.querySelector('.end_date[data-id="' + target + '"]').value;
    const parentId = document.getElementById('targetId').value;
    const loginUser = document.getElementById('loginUser').value;
    const status = document.querySelector('.add-task[data-id="' + target + '"]').getAttribute('data-status');
    let check = true;
    let msg = '';
    if (title === '') {
        msg += 'タスク名が入力されていません。\n';
        check = false;
    }
    const sendData = {
        title: title,
        type: type,
        priority: priority,
        main_person_id: mainPerson,
        start_date: startDate,
        end_date: endDate,
        parent_id: parentId,
        login_user: loginUser,
        status: status,
    };
    console.log(sendData);
    if (check) {
        axios.post('/api/addTask', sendData)
            .then((res) => {
                console.log(res);
                if (res.data.status === 'success') {
                    const target = document.querySelector('.add-task[data-status="' + status + '"]');
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(res.data.view, 'text/html');
                    console.log(res.data);
                    target.before(doc.body.firstChild);
                    target.remove();
                    initFunctions(res.data.target);
                    initFlowbite();
                    indicatorSuccess();
                } else {
                    window.alert('タスクの登録に失敗しました。');
                    indicatorError();
                }
            })
            .catch((error) => {
                console.log(error);
                indicatorError();
            });
    } else {
        window.alert(msg);
        indicatorError();
    }
}

function taskOrderPost() {

}

function inputUpdate(el) {

}

function indicatorPost() {
    indicator.classList.remove('bg-white', 'bg-green-50', 'bg-red-50');
    indicator.classList.add('bg-yellow-50');
    indicatorIcon.innerHTML = '<i class="bi bi-arrow-repeat"></i>';
    indicatorText.innerHTML = 'updating...';
}

function indicatorSuccess() {
    indicator.classList.remove('bg-white', 'bg-yellow-50', 'bg-red-50');
    indicator.classList.add('bg-green-50');
    indicatorIcon.innerHTML = '<i class="bi bi-check2-circle"></i>'
    indicatorText.innerHTML = 'success';
}

function indicatorError() {
    indicator.classList.remove('bg-white', 'bg-green-50', 'bg-yellow-50');
    indicator.classList.add('bg-red-50');
    indicatorIcon.innerHTML = '<i class="bi bi-x-circle"></i>'
    indicatorText.innerHTML = 'failed';
}
