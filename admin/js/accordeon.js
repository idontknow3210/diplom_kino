const confStepAll = document.querySelectorAll('.conf-step');
const headers = Array.from(document.querySelectorAll('.conf-step__header'));
headers.forEach(header => header.addEventListener('click', () => {
  header.classList.toggle('conf-step__header_closed');
  header.classList.toggle('conf-step__header_opened');
}));

const popupAll = document.querySelectorAll('.popup');
Array.from(popupAll).forEach(el => {
  el.querySelector('.popup__dismiss').addEventListener('click', (e) => {
    e.preventDefault();
    el.classList.remove('active');
  });
  el.querySelector('.conf-step__button-regular').addEventListener('click', () => {
    el.classList.remove('active');
  });
});
function controlerWorkSeanse(control) {
  fetch('http://localhost:8000/controler/controler.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8'
    },
    body: JSON.stringify(control)
  }).then(response => {
    if (response.ok) {
      fetch('http://localhost:8001/controler/controler.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json;charset=utf-8'
        },
        body: JSON.stringify(control)
      })
    }
  });
}
confStepAll[4].children[1].children[1].addEventListener('click', () => {
  if (confStepAll[4].children[1].children[1].textContent === 'Открыть продажу билетов') {
    controlerWorkSeanse(1);
    confStepAll[4].children[1].children[1].textContent = 'Приостановить продажу билетов';
  } else if (confStepAll[4].children[1].children[1].textContent === 'Приостановить продажу билетов') {
    controlerWorkSeanse(2);
    confStepAll[4].children[1].children[1].textContent = 'Открыть продажу билетов';
  }
});

