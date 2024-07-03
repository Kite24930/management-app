import '../common.js';
import Quill from "quill";

let quills = {};

const initializeAccordion = (details) => {
    const summary = details.querySelector("summary");
    const panel = details.querySelector("summary + *");

    if (!(details && summary && panel)) return; // 必要要素が揃ってない場合は処理をやめる
    let isTransitioning = false; // 連打防止フラグ

    const onOpen = () => {
        if (details.open || isTransitioning) {
            return;
        }
        isTransitioning = true;
        panel.style.gridTemplateRows = "0fr";
        details.setAttribute("open", "");
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                panel.style.gridTemplateRows = "1fr";
            });
        });
        panel.addEventListener(
            "transitionend",
            () => {
                isTransitioning = false;
            },
            { once: true }
        );
    };

    const onClose = () => {
        if (!details.open || isTransitioning) {
            return;
        }
        isTransitioning = true;
        panel.style.gridTemplateRows = "0fr";
        panel.addEventListener(
            "transitionend",
            () => {
                details.removeAttribute("open");
                panel.style.gridTemplateRows = "";
                isTransitioning = false;
            },
            { once: true }
        );
    };

    summary.addEventListener("click", (event) => {
        event.preventDefault();

        if (details.open) {
            onClose();
        } else {
            onOpen();
        }
    });
};

document.querySelectorAll("details").forEach((accordion) => initializeAccordion(accordion));

const initializeQuillViewer = (selector, target) => {
    quills[target] = new Quill(selector, {
        modules: {
            toolbar: false,
        },
        theme: "snow",
        readOnly: true,
    });
}
Laravel.users.forEach((user) => {
    const target = document.getElementById('inner_' + user.id);
    initializeQuillViewer(target, user.id);
})

Laravel.targets.forEach((target) => {
    quills[target.user_id].setContents(JSON.parse(target.target_description));
});

document.getElementById('targetMonth').addEventListener('change', (e) => {
    const sendData = {
        date: e.target.value,
    }
    axios.post('/monthly/targets', sendData)
        .then((res) => {
            console.log(res.data);
            Laravel.users.forEach((user) => {
                const textLength = quills[user.id].getLength();
                quills[user.id].deleteText(0, textLength);
            });
            res.data.targets.forEach((target) => {
                quills[target.user_id].setContents(JSON.parse(target.target_description));
            });
        })
        .catch((error) => {
            console.error(error);
        });
});

document.querySelectorAll('.editBtn').forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const targetMonth = document.getElementById('targetMonth').value;
        const targetUserId = e.currentTarget.getAttribute('data-user-id');
        window.location.href = `/monthly/targets/edit/${targetUserId}/${targetMonth}`;
    });
});
