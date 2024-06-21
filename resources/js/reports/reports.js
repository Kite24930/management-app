import '../common.js';
import Calendar from "@toast-ui/calendar";

const calendar = new Calendar('#calendar', {
    defaultView: 'month',
    timezone: 'Asia/Tokyo',
    gridSelection: false,
});

document.getElementById('previousMonth').addEventListener('click', () => {
    calendar.prev();
    setMonth(false);
});
document.getElementById('nextMonth').addEventListener('click', () => {
    calendar.next();
    setMonth(true);
});
const setMonth = (flag) => {
    console.log(Laravel.month);
    let targetDate = new Date(Laravel.month);
    console.log(targetDate);
    if (flag) {
        targetDate.setMonth(targetDate.getMonth() + 1);
    } else {
        targetDate.setMonth(targetDate.getMonth() - 1);
    }
    Laravel.month = targetDate.getFullYear() + '-' + ('0' + (targetDate.getMonth() + 1)).slice(-2);
    document.getElementById('month').innerText = targetDate.getFullYear() + ' ' + Intl.DateTimeFormat('en', { month: 'short' }).format(targetDate);
}

Laravel.reports.forEach((report) => {
    calendar.createEvents([
        {
            id: report.report_id,
            title: report.user_name,
            category: 'allday',
            isAllday: true,
            start: report.date,
            end: report.date,
            backgroundColor: '#ffc8de',
            borderColor: '#ff73aa',
            color: '#626d71',
        }
    ]);
});

calendar.on('clickEvent', (e) => {
    const reportId = e.event.id;
    window.location.href = '/reports/view/' + reportId;
});
