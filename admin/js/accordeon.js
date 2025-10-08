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
