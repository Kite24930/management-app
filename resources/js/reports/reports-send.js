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



window.addEventListener('DOMContentLoaded', () => {
    Laravel.tasks.forEach((task) => {
        initializeQuillViewer(`#detail_${task.task_id}`, task.details);
        initializeQuillViewer(`#problem_${task.task_id}`, task.problems);
    });
    initializeQuillViewer('#announcement', Laravel.report.announcement);

    setTimeout(() => {
        document.getElementById('header').remove();
        const htmlContents = document.documentElement.outerHTML;
        axios.post(Laravel.sendUrl, {
            'reporter': Laravel.user.name,
            'date': Laravel.report.date,
            'html': htmlContents,
            '_token': Laravel.csrfToken,
        })
            .then((res) => {
                console.log(res.data);
                if (res.data.status === 'success') {
                    window.location.href = Laravel.redirectUrl;
                } else {
                    alert('Failed to send the report.');
                }
            })
            .catch((err) => {
                console.error(err);
            });
    }, 0);
});
