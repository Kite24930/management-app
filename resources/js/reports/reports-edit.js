import '../common.js';
import Quill from 'quill';
import axios from 'axios';

let detailQuill = {};
let problemQuill = {};
let announcementQuill = {};
const reportWrapper = document.getElementById('reportWrapper');

const createArrayUpTo = (num) => {
    return Array.from(Array(num).keys());
}
let reportTaskNum = createArrayUpTo(Laravel.report_tasks.length);

// 初期Quillエディタの初期化
const initializeQuillEditor = (selector, quillArray, contents = null) => {
    quillArray[selector] = new Quill(selector, {
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
        theme: 'bubble'
    });
    if (contents) {
        quillArray[selector].setContents(JSON.parse(contents));
    }
};

// 初期エディタの初期化
Laravel.report_tasks.forEach((task, i) => {
    initializeQuillEditor(`#detail_${i}`, detailQuill, task.details);
    initializeQuillEditor(`#problem_${i}`, problemQuill, task.problems);
    document.getElementById(`removeBtn_${i}`).addEventListener('click', (e) => {
        const target = e.currentTarget;
        const targetId = target.getAttribute('data-target');
        taskRemove(targetId, i);
    });
});
initializeQuillEditor('#announcement', announcementQuill, Laravel.report.announcement);

document.getElementById('taskAddBtn').addEventListener('click', () => {
    const reportNum = Math.max(...reportTaskNum);
    const sendData = {
        'tasks': Laravel.tasks,
        'num': reportNum,
        '_token': Laravel.csrfToken,
    }
    console.log(sendData);
    axios.post(Laravel.taskAddUrl, sendData)
        .then((res) => {
            console.log(res.data);
            const parser = new DOMParser();
            const doc = parser.parseFromString(res.data.view, 'text/html');
            const newElement = doc.body.firstChild;

            // 新しいタスクコンポーネントを追加
            reportWrapper.appendChild(newElement);

            const targetNum = res.data.num;
            // 新しいエディタの初期化
            initializeQuillEditor(`#detail_${targetNum}`, detailQuill);
            initializeQuillEditor(`#problem_${targetNum}`, problemQuill);

            // 新しいタスクの削除ボタンにイベントリスナーを追加
            document.getElementById(`removeBtn_${targetNum}`).addEventListener('click', (e) => {
                const target = e.currentTarget;
                const targetId = target.getAttribute('data-target');
                taskRemove(targetId, targetNum);
            });

            // data-report-numの更新
            reportTaskNum.push(targetNum);
        })
        .catch((error) => {
            console.log(error);
        });
});

const taskRemove = (targetId, targetNum) => {
    const targetEl = document.getElementById(targetId);
    if (targetEl) {
        targetEl.remove();
        reportTaskNum = reportTaskNum.filter((num) => num !== targetNum);
        delete detailQuill[`#detail_${targetNum}`];
        delete problemQuill[`#problem_${targetNum}`];
    } else {
        console.log(`Element with ID ${targetId} not found.`);
    }
}

document.getElementById('saveBtn').addEventListener('click', () => {
    const reportId = Laravel.report.id;
    const reportDate = document.getElementById('date').value;
    let reportTasks = [];
    reportTaskNum.forEach((num) => {
        const task = document.getElementById(`task_${num}`).value;
        const hours = document.getElementById(`hours_${num}`).value;
        const progress = document.getElementById(`progress_${num}`).value;
        const detail = detailQuill[`#detail_${num}`].getContents();
        const problem = problemQuill[`#problem_${num}`].getContents();
        reportTasks.push({
            task: task,
            hours: hours,
            progress: progress,
            details: JSON.stringify(detail.ops),
            problems: JSON.stringify(problem.ops)
        });
    });
    const announcement = announcementQuill['#announcement'].getContents();
    const sendData = {
        'report_id': reportId,
        'date': reportDate,
        'tasks': reportTasks,
        'announcement': JSON.stringify(announcement.ops),
        '_token': Laravel.csrfToken,
    }
    console.log(sendData);
    axios.patch(Laravel.saveUrl, sendData)
        .then((res) => {
            console.log(res.data);
            if (res.data.status === 'success') {
                alert('Report has been saved successfully.');
                window.location.href = Laravel.redirectUrl;
            } else {
                alert('Failed to save the report.');
            }
        })
        .catch((error) => {
            console.log(error);
        });
});
