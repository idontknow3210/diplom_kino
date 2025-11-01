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
confStepAll[4].children[1].children[1].addEventListener('click', () => {
  if (confStepAll[4].children[1].children[1].textContent === 'Открыть продажу билетов') {
    confStepAll[4].children[1].children[1].textContent = 'Приостановить продажу билетов';
  } else if (confStepAll[4].children[1].children[1].textContent === 'Приостановить продажу билетов') {
    confStepAll[4].children[1].children[1].textContent = 'Открыть продажу билетов';
  }
});
