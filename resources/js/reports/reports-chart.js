import '../common.js';
import 'flowbite';
import Chart from 'chart.js/auto';
import axios from 'axios';

let taskList = [];
let taskData = [];
let taskChart = null;
const taskChartEl = document.getElementById('taskChart');
let userList = [];
let userData = [];
let userChart = null;
const userChartEl = document.getElementById('userChart');

const chartSet = () => {
    Laravel.summary.tasks.forEach((task) => {
        taskList.push(task.title);
        let userHours = [];
        Laravel.users.forEach((user) => {
            userHours.push(Laravel.summary.task_base_hours[task.title][user.name]);
        });
        userData.push({
            name: task.title,
            data: userHours,
        });
    });
    Laravel.users.forEach((user) => {
        userList.push(user.name);
        let taskHours = [];
        Laravel.tasks.forEach((task) => {
            taskHours.push(Laravel.summary.user_base_hours[user.name][task.title]);
        });
        taskData.push({
            name: user.name,
            data: taskHours,
        });
    });

    const options = {
        scales: {
            y: {
                beginAtZero: true,
                stacked: true,
            },
            x: {
                stacked: true,
            },
        }
    };

    userChart = new Chart(userChartEl, {
        type: 'bar',
        data: {
            labels: userList,
            datasets: userData.map((data) => {
                return {
                    label: data.name,
                    data: data.data,
                };
            }),
        },
        options: options,
    });

    taskChart = new Chart(taskChartEl, {
        type: 'bar',
        data: {
            labels: taskList,
            datasets: taskData.map((data) => {
                return {
                    label: data.name,
                    data: data.data,
                };
            }),
        },
        options: options,
    });
}

if (Laravel.tasks.length !== 0 && Laravel.users.length !== 0 && Laravel.summary.task_base_hours.length !== 0 && Laravel.summary.user_base_hours.length !== 0) {
    chartSet();
}

document.getElementById('targetMonth').addEventListener('change', (e) => {
    axios.get('/reports/chart/data/' + e.target.value)
        .then((res) => {
            Laravel.summary = res.data;
            if (taskChart !== null) {
                taskChart.destroy();
            }
            if (userChart !== null) {
                userChart.destroy();
            }
            taskList = [];
            taskData = [];
            userList = [];
            userData = [];
            chartSet();
        })
        .catch((error) => {
            console.log(error);
        });
});
