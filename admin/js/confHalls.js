let confStepRow = document.querySelectorAll('.conf-step__row');
let confStepHall = document.querySelector('.conf-step__hall-wrapper');
const chairs = document.querySelector('#chairs');
const rows = document.querySelector('#rows');


rows.addEventListener('change', () => {
    confStepHall.innerHTML = ``;
    let sumChairs = '';
    if (!isNaN(+chairs.value) && chairs.value > 0) {
        for (let i = 0; i < chairs.value; i++) {
            sumChairs+='<span class="conf-step__chair conf-step__chair_standart"></span>';
        }
    }
    for (let i = 0; i < rows.value; i++) {
        confStepHall.innerHTML+=`<div class="conf-step__row">${sumChairs}</div>`;
    }
    restartFor();
});

chairs.addEventListener('change', () => {
    confStepRow.forEach((el) => {
        el.innerHTML = ``;
        for (let i = 0; i < chairs.value; i++) {
            el.innerHTML += `<span class="conf-step__chair conf-step__chair_standart"></span>`
        }
    });
    restartFor();

});

const typeChairs = [document.querySelector('#standart'), document.querySelector('#vip'), document.querySelector('#disabled')];
let type = null;
typeChairs.forEach((el) => {
    el.addEventListener('click', () => {
        type = el.classList[1];
    });
});

function restartFor() {
    confStepRow = document.querySelectorAll('.conf-step__row');
    confStepRow.forEach((el) => {
        Array.from(el.children).forEach((e) => {
            e.addEventListener('click', function idontknow() {
                e.classList.remove('conf-step__chair_standart', 'conf-step__chair_vip', 'conf-step__chair_disabled');
                e.classList.add(type);
            });
        });
    });
}
restartFor();



