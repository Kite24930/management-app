import '../common.js';
import Quill from 'quill';

const initializeQuillViewer = (selector, contents) => {
    const quill = new Quill(selector, {
        modules: {
            toolbar: false
        },
        theme: 'bubble',
        readOnly: true,
    });
    quill.setContents(JSON.parse(contents));
}

Laravel.tasks.forEach((task) => {
    initializeQuillViewer(`#detail_${task.task_id}`, task.details);
    initializeQuillViewer(`#problem_${task.task_id}`, task.problems);
});
initializeQuillViewer('#announcement', Laravel.report.announcement);
