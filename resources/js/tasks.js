import './common.js';
import Sortable from 'sortablejs';
import axios from "axios";
import { initFlowbite } from "flowbite";
import Editor from "@toast-ui/editor";
import codeSyntaxHighlight from "@toast-ui/editor-plugin-code-syntax-highlight";
import tableMergedCellPlugin from "@toast-ui/editor-plugin-table-merged-cell";
import colorSyntax from "@toast-ui/editor-plugin-color-syntax";

const todo = document.getElementById('todo');
const progress = document.getElementById('progress');
const pending = document.getElementById('pending');
const completed = document.getElementById('completed');
const other = document.getElementById('other');
const cancel = document.getElementById('cancel');
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

    new Sortable(cancel, {
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

    const currentTask = document.getElementById('current-task');
    if (currentTask) {
        const currentTaskId = currentTask.getAttribute('data-id');
        const currentPriority = document.getElementById('current-priority');
        const currentPriorityItem = document.querySelectorAll('.current-task-priority');
        currentPriorityItem.forEach((el) => {
            el.addEventListener('click', () => {
                indicatorPost();
                let priorityEl = el;
                while (priorityEl.tagName !== 'LI') {
                    priorityEl = priorityEl.parentNode;
                }
                const sendData = {
                    task_id: currentTaskId,
                    priority: priorityEl.getAttribute('data-type'),
                };
                axios.post('/api/taskPriorityEdit', sendData)
                    .then((res) => {
                        console.log(res);
                        if (res.data.status === 'success') {
                            indicatorSuccess();
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(res.data.view, 'text/html');
                            const targetEl = document.getElementById('current-priority');
                            targetEl.innerHTML = doc.body.innerHTML;
                            document.getElementById('current-priority-list').classList.toggle('hidden');
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
        const currentStatus = document.getElementById('current-status');
        const currentStatusItem = document.querySelectorAll('.current-task-type');
        currentStatusItem.forEach((el) => {
            el.addEventListener('click', () => {
                indicatorPost();
                let statusEl = el;
                while (statusEl.tagName !== 'LI') {
                    statusEl = statusEl.parentNode;
                }
                const sendData = {
                    task_id: currentTaskId,
                    status: statusEl.getAttribute('data-type'),
                };
                axios.post('/api/taskStatusEdit', sendData)
                    .then((res) => {
                        console.log(res);
                        if (res.data.status === 'success') {
                            indicatorSuccess();
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(res.data.view, 'text/html');
                            const targetEl = document.getElementById('current-status');
                            targetEl.innerHTML = doc.body.innerHTML;
                            document.getElementById('current-status-list').classList.toggle('hidden');
                            initFlowbite();
                        } else {
                            window.alert('ステータスの変更に失敗しました。');
                            indicatorError();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                        indicatorError();
                    });
            });
        });
        const currentDescriptionMd = document.getElementById('current-description');
        const currentDescriptionViewerEl = document.getElementById('current-viewer');
        const currentDescriptionEditorEl = document.getElementById('current-editor');
        const currentDescriptionRegister = document.getElementById('current-editor-register');
        const currentDescriptionViewer = new Editor.factory({
            el: currentDescriptionViewerEl,
            viewer: true,
            initialValue: currentDescriptionMd.value,
        });
        currentDescriptionViewerEl.addEventListener('dblclick', () => {
            currentDescriptionViewerEl.classList.toggle('hidden');
            currentDescriptionEditorEl.classList.toggle('hidden');
            currentDescriptionRegister.classList.toggle('hidden');
            currentDescriptionRegister.classList.toggle('flex');
        });
        const currentDescriptionEditor = new Editor({
            el: currentDescriptionEditorEl,
            initialEditType: 'wysiwyg',
            height: '300px',
            plugins: [codeSyntaxHighlight, tableMergedCellPlugin, colorSyntax],
            usageStatistics: false,
            initialValue: currentDescriptionMd.value,
            placeholder: 'タスクの詳細を入力してください。',
        });
        currentDescriptionRegister.addEventListener('click', () => {
            const sendData = {
                task_id: currentTaskId,
                description: currentDescriptionEditor.getMarkdown(),
            };
            axios.post('/api/taskDescriptionEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const modalViewer = document.getElementById('current-viewer');
                        modalViewer.innerHTML = '';
                        const viewer = new Editor.factory({
                            el: modalViewer,
                            viewer: true,
                            initialValue: sendData.description,
                        });
                        currentDescriptionViewerEl.classList.toggle('hidden');
                        currentDescriptionEditorEl.classList.toggle('hidden');
                        currentDescriptionRegister.classList.toggle('hidden');
                        currentDescriptionRegister.classList.toggle('flex');
                        indicatorSuccess();
                    } else {
                        window.alert('詳細の変更に失敗しました。');
                        indicatorError();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    indicatorError();
                });
        });
    }

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
        login_user: document.getElementById('loginUser').value,
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
                document.getElementById('modal').classList.toggle('hidden');
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
            document.getElementById('modal-start-date').addEventListener('change', (e) => {
                modalStartDateChange(target, e.target.value);
            });
            document.getElementById('modal-start-date-clear').addEventListener('click', () => {
                modalStartDateClear(target);
            });
            document.getElementById('modal-end-date').addEventListener('change', (e) => {
                modalEndDateChange(target, e.target.value);
            });
            document.getElementById('modal-end-date-clear').addEventListener('click', () => {
                modalEndDateClear(target);
            });
            document.querySelectorAll('.modal-main-person').forEach((el) => {
                el.addEventListener('click', (e) => {
                    let personEl = e.target;
                    while (personEl.tagName !== 'LI') {
                        personEl = personEl.parentNode;
                    }
                    modalMainPersonChange(target, personEl.getAttribute('data-person'));
                });
            });
            document.querySelectorAll('.modal-member').forEach((el) => {
                el.addEventListener('change', (e) => {
                    modalPersonChange(target);
                });
            });
            modalDescriptionSet();
            modalProgressBarSet();
            modalSubTaskFunctionSet();
            modalCommentFunctionSet();
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

function modalStartDateClear(target) {
    const sendData = {
        task_id: target,
    };
    axios.post('/api/taskStartDateClear', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                document.getElementById('modal-start-date').value = '';
                indicatorSuccess();
            } else {
                window.alert('開始日の削除に失敗しました。');
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

function modalEndDateClear(target) {
    const sendData = {
        task_id: target,
    };
    axios.post('/api/taskEndDateClear', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                document.getElementById('modal-end-date').value = '';
                indicatorSuccess();
            } else {
                window.alert('終了日の削除に失敗しました。');
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
                const mainPerson = document.getElementById('modal-main-person');
                if (res.data.user.icon !== null) {
                    const icon = document.createElement('img');
                    icon.src = '/storage/' + res.data.user.id + '/' + res.data.user.icon;
                    icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                    icon.alt = res.data.user.name;
                    mainPerson.innerHTML = '';
                    mainPerson.append(icon);
                } else {
                    const iconWrapper = document.createElement('div');
                    iconWrapper.classList.add('inline-block');
                    const icon = document.createElement('div');
                    icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                    icon.innerHTML = res.data.user.name.slice(0, 1);
                    iconWrapper.append(icon);
                    mainPerson.innerHTML = '';
                    mainPerson.append(iconWrapper);
                }
                mainPerson.innerHTML += res.data.user.name;
                const modalMember = document.getElementById('modal-member');
                modalMember.innerHTML = '';
                res.data.members.forEach((member) => {
                    const memberEl = document.createElement('div');
                    memberEl.classList.add('flex', 'items-center');
                    if (member.icon !== null) {
                        const icon = document.createElement('img');
                        icon.src = '/storage/' + member.id + '/' + member.icon;
                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                        icon.alt = member.name;
                        memberEl.append(icon);
                    } else {
                        const iconWrapper = document.createElement('div');
                        iconWrapper.classList.add('inline-block');
                        const icon = document.createElement('div');
                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                        icon.innerHTML = member.name.slice(0, 1);
                        iconWrapper.append(icon);
                        memberEl.append(iconWrapper);
                    }
                    memberEl.innerHTML += member.name;
                    modalMember.append(memberEl);
                });
                document.getElementById('modal-main-person-list').classList.toggle('hidden');
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

function modalPersonChange(target) {
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
                        icon.src = '/storage/' + member.id + '/' + member.icon;
                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                        icon.alt = member.name;
                        memberEl.append(icon);
                    } else {
                        const iconWrapper = document.createElement('div');
                        iconWrapper.classList.add('inline-block');
                        const icon = document.createElement('div');
                        icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                        icon.innerHTML = member.name.slice(0, 1);
                        iconWrapper.append(icon);
                        memberEl.append(iconWrapper);
                    }
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

function modalDescriptionSet() {
    const descriptionMd = document.getElementById('modal-editor-md');
    const descriptionEditor = new Editor({
        el: document.getElementById('modal-editor'),
        initialEditType: 'wysiwyg',
        height: '300px',
        plugins: [codeSyntaxHighlight, tableMergedCellPlugin, colorSyntax],
        usageStatistics: false,
        initialValue: descriptionMd.value,
        placeholder: 'タスクの詳細を入力してください。',
    });
    const descriptionViewer = new Editor.factory({
        el: document.getElementById('modal-viewer'),
        viewer: true,
        initialValue: descriptionMd.value,
    });
    document.getElementById('modal-editor-open').addEventListener('click', () => {
        document.getElementById('modal-editor').classList.toggle('hidden');
        document.getElementById('modal-viewer').classList.toggle('hidden');
        document.getElementById('modal-editor-open').classList.toggle('hidden');
        document.getElementById('modal-editor-open').classList.toggle('flex');
        document.getElementById('modal-editor-register').classList.toggle('hidden');
        document.getElementById('modal-editor-register').classList.toggle('flex');
    });
    document.getElementById('modal-editor-register').addEventListener('click', (e) => {
        modalDescriptionEdit(e.target.getAttribute('data-id'), descriptionEditor.getMarkdown());
    });
}

function modalDescriptionEdit(target, description) {
    const sendData = {
        task_id: target,
        description: description,
    };
    axios.post('/api/taskDescriptionEdit', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                const modalViewer = document.getElementById('modal-viewer');
                modalViewer.innerHTML = '';
                const viewer = new Editor.factory({
                    el: modalViewer,
                    viewer: true,
                    initialValue: description,
                });
                document.getElementById('modal-editor').classList.toggle('hidden');
                document.getElementById('modal-viewer').classList.toggle('hidden');
                document.getElementById('modal-editor-open').classList.toggle('hidden');
                document.getElementById('modal-editor-open').classList.toggle('flex');
                document.getElementById('modal-editor-register').classList.toggle('hidden');
                document.getElementById('modal-editor-register').classList.toggle('flex');
                indicatorSuccess();
            } else {
                window.alert('詳細の変更に失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
}

function modalProgressBarSet() {
    const allVal = document.getElementById('modal-sub-all').value;
    const todoVal = document.getElementById('modal-sub-todo').value;
    const progressVal = document.getElementById('modal-sub-progress').value;
    const pendingVal = document.getElementById('modal-sub-pending').value;
    const completedVal = document.getElementById('modal-sub-completed').value;
    const otherVal = document.getElementById('modal-sub-other').value;
    const cancelVal = document.getElementById('modal-sub-cancel').value;
    const ctx = document.getElementById('modal-progress-bar');
    const todoBar = document.getElementById('modal-todo-bar');
    const progressBar = document.getElementById('modal-progress-bar');
    const pendingBar = document.getElementById('modal-pending-bar');
    const completedBar = document.getElementById('modal-completed-bar');
    const otherBar = document.getElementById('modal-other-bar');
    const cancelBar = document.getElementById('modal-cancel-bar');
    const todoRatio = document.getElementById('modal-todo-ratio');
    const progressRatio = document.getElementById('modal-progress-ratio');
    const pendingRatio = document.getElementById('modal-pending-ratio');
    const completedRatio = document.getElementById('modal-completed-ratio');
    const otherRatio = document.getElementById('modal-other-ratio');
    const cancelRatio = document.getElementById('modal-cancel-ratio');
    if (allVal === '0') {
        todoBar.style.width = '100%';
        todoRatio.innerHTML = 'サブタスクなし';
        progressBar.classList.add('hidden');
        pendingBar.classList.add('hidden');
        completedBar.classList.add('hidden');
        otherBar.classList.add('hidden');
        cancelBar.classList.add('hidden');
    } else {
        if (todoVal === '0') {
            todoBar.style.width = '0%';
            todoRatio.innerHTML = '0/0 (0%)';
            todoBar.classList.add('hidden');
        } else {
            const todoRatioVal = (todoVal / allVal * 100).toFixed(1);
            todoBar.style.width = todoRatioVal + '%';
            todoRatio.innerHTML = todoVal + '/' + allVal + ' (' + todoRatioVal + '%)';
            todoBar.classList.remove('hidden');
        }
        if (progressVal === '0') {
            progressBar.style.width = '0%';
            progressRatio.innerHTML = '0/0 (0%)';
            progressBar.classList.add('hidden');
        } else {
            const progressRatioVal = (progressVal / allVal * 100).toFixed(1);
            progressBar.style.width = progressRatioVal + '%';
            progressRatio.innerHTML = progressVal + '/' + allVal + ' (' + progressRatioVal + '%)';
            progressBar.classList.remove('hidden');
        }
        if (pendingVal === '0') {
            pendingBar.style.width = '0%';
            pendingRatio.innerHTML = '0/0 (0%)';
            pendingBar.classList.add('hidden');
        } else {
            const pendingRatioVal = (pendingVal / allVal * 100).toFixed(1);
            pendingBar.style.width = pendingRatioVal + '%';
            pendingRatio.innerHTML = pendingVal + '/' + allVal + ' (' + pendingRatioVal + '%)';
            pendingBar.classList.remove('hidden');
        }
        if (completedVal === '0') {
            completedBar.style.width = '0%';
            completedRatio.innerHTML = '0/0 (0%)';
            completedBar.classList.add('hidden');
        } else {
            const completedRatioVal = (completedVal / allVal * 100).toFixed(1);
            completedBar.style.width = completedRatioVal + '%';
            completedRatio.innerHTML = completedVal + '/' + allVal + ' (' + completedRatioVal + '%)';
            completedBar.classList.remove('hidden');
        }
        if (otherVal === '0') {
            otherBar.style.width = '0%';
            otherRatio.innerHTML = '0/0 (0%)';
            otherBar.classList.add('hidden');
        } else {
            const otherRatioVal = (otherVal / allVal * 100).toFixed(1);
            otherBar.style.width = otherRatioVal + '%';
            otherRatio.innerHTML = otherVal + '/' + allVal + ' (' + otherRatioVal + '%)';
            otherBar.classList.remove('hidden');
        }
        if (cancelVal === '0') {
            cancelBar.style.width = '0%';
            cancelRatio.innerHTML = '0/0 (0%)';
            cancelBar.classList.add('hidden');
        } else {
            const cancelRatioVal = (cancelVal / allVal * 100).toFixed(1);
            cancelBar.style.width = cancelRatioVal + '%';
            cancelRatio.innerHTML = cancelVal + '/' + allVal + ' (' + cancelRatioVal + '%)';
            cancelBar.classList.remove('hidden');
        }
    }
}

function modalSubTaskFunctionSet() {
    modalSubTaskFunction();
    modalSubTaskAddFunction();
}

function modalSubTaskFunction() {
    document.querySelectorAll('.modal-sub-priority').forEach((el) => {
        el.addEventListener('click', (e) => {
            let priorityEl = e.target;
            while (priorityEl.tagName !== 'LI') {
                priorityEl = priorityEl.parentNode;
            }
            const sendData = {
                task_id: priorityEl.getAttribute('data-id'),
                priority: priorityEl.getAttribute('data-priority'),
            };
            axios.post('/api/taskPriorityEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(res.data.view, 'text/html');
                        const targetEl = document.getElementById('modal-sub-priority-' + sendData.task_id);
                        targetEl.innerHTML = doc.body.innerHTML;
                        targetEl.setAttribute('data-priority', sendData.priority);
                        document.getElementById('modal-sub-priority-list-' + sendData.task_id).classList.toggle('hidden');
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
        });
    });
    document.querySelectorAll('.modal-sub-title-edit').forEach((el) => {
        el.addEventListener('click', (e) => {
            const target = e.target.getAttribute('data-id');
            document.getElementById('modal-sub-link-' + target).classList.toggle('hidden');
            document.getElementById('modal-sub-title-' + target).classList.toggle('hidden');
            document.getElementById('modal-sub-title-' + target).focus();
        });
    });
    document.querySelectorAll('.modal-sub-title').forEach((el) => {
        el.addEventListener('change', (e) => {
            const sendData = {
                task_id: e.target.getAttribute('data-id'),
                title: e.target.value,
            };
            axios.post('/api/taskTitleEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        document.querySelector('#modal-sub-link-' + sendData.task_id + ' a').innerHTML = sendData.title;
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
        });
        el.addEventListener('focusout', (e) => {
            const target = e.target.getAttribute('data-id');
            document.getElementById('modal-sub-link-' + target).classList.toggle('hidden');
            document.getElementById('modal-sub-title-' + target).classList.toggle('hidden');
        });
    });
    document.querySelectorAll('.modal-sub-person').forEach((el) => {
        el.addEventListener('click', (e) => {
            let personEl = e.target;
            while (personEl.tagName !== 'LI') {
                personEl = personEl.parentNode;
            }
            const sendData = {
                task_id: personEl.getAttribute('data-id'),
                member_id: personEl.getAttribute('data-person'),
            };
            axios.post('/api/taskMainMemberEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const mainPerson = document.getElementById('modal-sub-main-' + sendData.task_id);
                        if (res.data.user.icon !== null) {
                            const icon = document.createElement('img');
                            icon.src = '/storage/' + res.data.user.icon;
                            icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                            icon.alt = res.data.user.name;
                            mainPerson.innerHTML = '';
                            mainPerson.append(icon);
                        } else {
                            const iconWrapper = document.createElement('div');
                            iconWrapper.classList.add('inline-block');
                            const icon = document.createElement('div');
                            icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                            icon.innerHTML = res.data.user.name.slice(0, 1);
                            iconWrapper.append(icon);
                            mainPerson.innerHTML = '';
                            mainPerson.append(iconWrapper);
                        }
                        document.getElementById('modal-sub-main-list-' + sendData.task_id).classList.toggle('hidden');
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
        });
    });
    document.querySelectorAll('.modal-sub-status').forEach((el) => {
        el.addEventListener('click', (e) => {
            let statusEl = e.target;
            while (statusEl.tagName !== 'LI') {
                statusEl = statusEl.parentNode;
            }
            const sendData = {
                task_id: statusEl.getAttribute('data-id'),
                status: statusEl.getAttribute('data-status'),
            };
            axios.post('/api/taskStatusEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(res.data.view, 'text/html');
                        const targetEl = document.getElementById('modal-sub-status-' + sendData.task_id);
                        targetEl.innerHTML = doc.body.innerHTML;
                        targetEl.setAttribute('data-status', sendData.status);
                        document.getElementById('modal-sub-status-list-' + sendData.task_id).classList.toggle('hidden');
                        axios.post('/api/subTaskCount', {task_id: document.getElementById('modal').getAttribute('data-id')})
                            .then((res) => {
                                console.log(res);
                                if (res.data.status === 'success') {
                                    document.getElementById('modal-sub-all').value = res.data.sub_tasks.all;
                                    document.getElementById('modal-sub-todo').value = res.data.sub_tasks.todo;
                                    document.getElementById('modal-sub-progress').value = res.data.sub_tasks.progress;
                                    document.getElementById('modal-sub-pending').value = res.data.sub_tasks.pending;
                                    document.getElementById('modal-sub-completed').value = res.data.sub_tasks.completed;
                                    document.getElementById('modal-sub-other').value = res.data.sub_tasks.other;
                                    document.getElementById('modal-sub-cancel').value = res.data.sub_tasks.cancel;
                                    modalProgressBarSet();
                                    initFlowbite();
                                    indicatorSuccess();
                                } else {
                                    window.alert('サブタスクの取得に失敗しました。');
                                    indicatorError();
                                }
                            })
                            .catch((error) => {
                                console.log(error);
                                indicatorError();
                            });
                    } else {
                        window.alert('ステータスの変更に失敗しました。');
                        indicatorError();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    indicatorError();
                });
        });
    });
}

function modalSubTaskAddFunction() {
    document.querySelectorAll('.modal-sub-add-priority').forEach((el) => {
        el.addEventListener('click', (e) => {
            let priorityEl = e.target;
            while (priorityEl.tagName !== 'LI') {
                priorityEl = priorityEl.parentNode;
            }
            const sendData = {
                priority: priorityEl.getAttribute('data-priority'),
            };
            axios.post('/api/taskPriorityChange', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(res.data.view, 'text/html');
                        const targetEl = document.getElementById('modal-sub-priority-0');
                        targetEl.innerHTML = doc.body.innerHTML;
                        targetEl.setAttribute('data-priority', sendData.priority);
                        document.getElementById('modal-sub-priority-list-0').classList.toggle('hidden');
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
        });
    });
    document.querySelectorAll('.modal-sub-add-person').forEach((el) => {
        el.addEventListener('click', (e) => {
            let personEl = e.target;
            while (personEl.tagName !== 'LI') {
                personEl = personEl.parentNode;
            }
            const sendData = {
                member_id: personEl.getAttribute('data-person'),
            };
            axios.post('/api/taskMainMemberChange', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const mainPerson = document.getElementById('modal-sub-main-0');
                        if (res.data.user.icon !== null) {
                            const icon = document.createElement('img');
                            icon.src = '/storage/' + res.data.user.icon;
                            icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                            icon.alt = res.data.user.name;
                            mainPerson.innerHTML = '';
                            mainPerson.append(icon);
                        } else {
                            const iconWrapper = document.createElement('div');
                            iconWrapper.classList.add('inline-block');
                            const icon = document.createElement('div');
                            icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                            icon.innerHTML = res.data.user.name.slice(0, 1);
                            iconWrapper.append(icon);
                            mainPerson.innerHTML = '';
                            mainPerson.append(iconWrapper);
                        }
                        mainPerson.setAttribute('data-person', sendData.member_id);
                        document.getElementById('modal-sub-main-list-0').classList.toggle('hidden');
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
        });
    });
    document.querySelectorAll('.modal-sub-add-status').forEach((el) => {
        el.addEventListener('click', (e) => {
            let statusEl = e.target;
            while (statusEl.tagName !== 'LI') {
                statusEl = statusEl.parentNode;
            }
            const sendData = {
                status: statusEl.getAttribute('data-status'),
            };
            axios.post('/api/taskStatusChange', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(res.data.view, 'text/html');
                        const targetEl = document.getElementById('modal-sub-status-0');
                        targetEl.innerHTML = doc.body.innerHTML;
                        targetEl.setAttribute('data-status', sendData.status);
                        document.getElementById('modal-sub-status-list-0').classList.toggle('hidden');
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
        });
    });
    document.getElementById('modal-title-edit-0').addEventListener('click', () => {
        indicatorPost();
        const modalSubtask = document.getElementById('modal-subtask');
        const priority = document.getElementById('modal-sub-priority-0').getAttribute('data-priority');
        const title = document.getElementById('modal-sub-title-0').value;
        const mainPerson = document.getElementById('modal-sub-main-0').getAttribute('data-person');
        const status = document.getElementById('modal-sub-status-0').getAttribute('data-status');
        const parentId = modalSubtask.getAttribute('data-id');
        const loginUser = document.getElementById('loginUser').value;
        const sendData = {
            priority: priority,
            title: title,
            main_person_id: mainPerson,
            status: status,
            parent_id: parentId,
            login_user: loginUser,
        };
        axios.post('/api/subTaskAdd', sendData)
            .then((res) => {
                console.log(res);
                if (res.data.status === 'success') {
                    modalSubtask.innerHTML = '';
                    res.data.views.forEach((view) => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(view, 'text/html');
                        const taskEl = document.createElement('li');
                        taskEl.classList.add('w-full', 'flex', 'items-center', 'gap-2', 'px-2', 'py-2');
                        taskEl.innerHTML += doc.body.firstChild.innerHTML;
                        modalSubtask.append(taskEl);
                    });
                    modalSubTaskFunctionSet();
                    modalProgressBarSet();
                    initFlowbite();
                    indicatorSuccess();
                } else {
                    window.alert('サブタスクの追加に失敗しました。');
                    indicatorError();
                }
            })
            .catch((error) => {
                console.log(error);
                indicatorError();
            });
    });
}

function modalCommentFunctionSet() {
    modalCommentFunction();
    modalCommentAddFunction();
}

function modalCommentFunction() {
    document.querySelectorAll('.modal-comment-editor').forEach((el) => {
        const commentId = el.getAttribute('data-id');
        const commentMd = document.getElementById('modal-comment-md-' + commentId);
        const commentEditor = new Editor({
            el: el,
            initialEditType: 'wysiwyg',
            height: '200px',
            plugins: [codeSyntaxHighlight, tableMergedCellPlugin, colorSyntax],
            usageStatistics: false,
            initialValue: commentMd.value,
            placeholder: 'コメントを入力してください。',

        });
        const commentViewerEl = document.getElementById('modal-comment-viewer-' + commentId);
        const commentViewer = new Editor.factory({
            el: commentViewerEl,
            viewer: true,
            initialValue: commentMd.value,
        });
        document.getElementById('modal-comment-edit-' + commentId).addEventListener('click', (e) => {
            document.getElementById('modal-comment-editor-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-viewer-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('flex');
            e.target.classList.toggle('hidden');
            document.getElementById('modal-comment-delete-' + commentId).classList.toggle('hidden');
        });
        document.getElementById('modal-comment-register-' + commentId).addEventListener('click', (e) => {
            const comment = commentEditor.getMarkdown();
            const commentId = e.target.getAttribute('data-id');
            const sendData = {
                comment: comment,
                comment_id: commentId,
            };
            axios.post('/api/modalCommentEdit', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        commentViewer.setMarkdown(comment);
                        document.getElementById('modal-comment-editor-' + commentId).classList.toggle('hidden');
                        document.getElementById('modal-comment-viewer-' + commentId).classList.toggle('hidden');
                        document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('hidden');
                        document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('flex');
                        document.getElementById('modal-comment-edit-' + commentId).classList.toggle('hidden');
                        document.getElementById('modal-comment-delete-' + commentId).classList.toggle('hidden');
                        indicatorSuccess();
                    } else {
                        window.alert('コメントの変更に失敗しました。');
                        indicatorError();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    indicatorError();
                });
        });
        document.getElementById('modal-comment-delete-' + commentId).addEventListener('click', (e) => {
            const commentId = e.target.getAttribute('data-id');
            const sendData = {
                comment_id: commentId,
            };
            axios.post('/api/modalCommentDelete', sendData)
                .then((res) => {
                    console.log(res);
                    if (res.data.status === 'success') {
                        const commentEl = document.getElementById('modal-comment-' + commentId);
                        commentEl.remove();
                        indicatorSuccess();
                    } else {
                        window.alert('コメントの削除に失敗しました。');
                        indicatorError();
                    }
                })
                .catch((error) => {
                    console.log(error);
                    indicatorError();
                });
        });
        document.getElementById('modal-comment-cancel-' + commentId).addEventListener('click', (e) => {
            document.getElementById('modal-comment-editor-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-viewer-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-register-wrapper-' + commentId).classList.toggle('flex');
            document.getElementById('modal-comment-edit-' + commentId).classList.toggle('hidden');
            document.getElementById('modal-comment-delete-' + commentId).classList.toggle('hidden');
        });
    });
}

function modalCommentAddFunction() {
    const commentEditor = new Editor({
        el: document.getElementById('modal-comment-editor-0'),
        initialEditType: 'wysiwyg',
        height: '200px',
        plugins: [codeSyntaxHighlight, tableMergedCellPlugin, colorSyntax],
        usageStatistics: false,
        placeholder: 'コメントを入力してください。',
    });
    document.getElementById('modal-new-comment').addEventListener('click', (e) => {
        document.getElementById('modal-comment-wrapper').classList.toggle('hidden');
        e.target.classList.toggle('hidden');
    });
    document.getElementById('modal-comment-register-0').addEventListener('click', () => {
        const comment = commentEditor.getMarkdown();
        const taskId = document.getElementById('modal').getAttribute('data-id');
        const loginUser = document.getElementById('loginUser').value;
        const sendData = {
            comment: comment,
            task_id: taskId,
            login_user: loginUser,
        };
        axios.post('/api/modalCommentAdd', sendData)
            .then((res) => {
                console.log(res);
                if (res.data.status === 'success') {
                    const modalComment = document.getElementById('modal-comment');
                    modalComment.innerHTML = '';
                    res.data.views.forEach((view) => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(view, 'text/html');
                        const commentEl = document.createElement('div');
                        commentEl.classList.add('w-full', 'flex', 'flex-col', 'p-2', 'rounded-lg');
                        commentEl.innerHTML += doc.body.firstChild.innerHTML;
                        modalComment.append(commentEl);
                    });
                    modalCommentFunction();
                    commentEditor.setMarkdown('');
                    document.getElementById('modal-comment-wrapper').classList.toggle('hidden');
                    document.getElementById('modal-new-comment').classList.toggle('hidden');
                    indicatorSuccess();
                } else {
                    window.alert('コメントの追加に失敗しました。');
                    indicatorError();
                }
            })
            .catch((error) => {
                console.log(error);
                indicatorError();
            });
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
                    icon.src = '/storage/' + res.data.user.id + '/' + res.data.user.icon;
                    icon.classList.add('w-8', 'h-8', 'rounded-full', 'object-cover', 'inline-block', 'mr-2');
                    icon.alt = res.data.user.name;
                    mainPerson.innerHTML = '';
                    mainPerson.append(icon);
                } else {
                    const iconWrapper = document.createElement('div');
                    iconWrapper.classList.add('inline-block');
                    const icon = document.createElement('div');
                    icon.classList.add('w-8', 'h-8', 'rounded-full', 'text-lg', 'flex', 'items-center', 'justify-center', 'mr-2', 'bg-latte', 'text-white', 'font-semibold', 'border');
                    icon.innerHTML = res.data.user.name.slice(0, 1);
                    iconWrapper.append(icon);
                    mainPerson.innerHTML = '';
                    mainPerson.append(iconWrapper);
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

function startDateChange(target, el) {
    indicatorPost();
    const sendData = {
        task_id: target,
        start_date: el.value,
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

function endDateChange(target, el) {
    indicatorPost();
    const sendData = {
        task_id: target,
        end_date: el.value,
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
                                        icon.src = '/storage/' + res.data.user.id + '/' + res.data.user.icon;
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
                document.querySelector('.task-title[data-id="' + targetId + '"]').focus();
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
indicatorPost();
    const todoList = [];
    const progressList = [];
    const pendingList = [];
    const completedList = [];
    const otherList = [];
    const cancelList = [];
    const allList = [];
    todo.querySelectorAll('.task-item').forEach((el) => {
        todoList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    progress.querySelectorAll('.task-item').forEach((el) => {
        progressList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    pending.querySelectorAll('.task-item').forEach((el) => {
        pendingList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    completed.querySelectorAll('.task-item').forEach((el) => {
        completedList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    other.querySelectorAll('.task-item').forEach((el) => {
        otherList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    cancel.querySelectorAll('.task-item').forEach((el) => {
        cancelList.push(el.getAttribute('data-id'));
        allList.push(el.getAttribute('data-id'));
    });
    const sendData = {
        todo: todoList,
        progress: progressList,
        pending: pendingList,
        completed: completedList,
        other: otherList,
        cancel: cancelList,
        all: allList,
    }
    axios.post('/api/taskOrderPost', sendData)
        .then((res) => {
            console.log(res);
            if (res.data.status === 'success') {
                indicatorSuccess();
            } else {
                window.alert('タスクの並び替えに失敗しました。');
                indicatorError();
            }
        })
        .catch((error) => {
            console.log(error);
            indicatorError();
        });
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
