const createHall = document.querySelector("#createHall");

const popupHall = document.querySelector("#hall");
const addingHall = popupHall.querySelector(".conf-step__button-accent");

const hallsSessionGrid = document.querySelector('.conf-step__seances');// Работает так же в файле sessionGrid

createHall.addEventListener('click', () => {
  popupHall.classList.toggle('active');
});

const halls = document.querySelector('.conf-step__list');
const popupRemoveHall = document.querySelector('#removeHall');
const configurationsHallsPrice = document.querySelectorAll('.conf-step__selectors-box');



function reloadConfigurations() {
  let configurations = ``;
  Array.from(halls.children).forEach((el) => {
    console.log(el.textContent)
    configurations += `<li><input type="radio" class="conf-step__radio" name="chairs-hall" value="${el.textContent}"><span class="conf-step__selector">${el.textContent}</span></li>`;

  })
  configurationsHallsPrice[0].innerHTML = configurations;
  configurationsHallsPrice[1].innerHTML = configurations;
}

function deleteHall() {
  Array.from(halls.querySelectorAll('.conf-step__button-trash')).forEach((el, id) => {
    el.addEventListener('click', () => {
      console.log("hi");
      popupRemoveHall.classList.toggle('active');
      popupRemoveHall.querySelector('span').textContent = el.parentNode.textContent;
      popupRemoveHall.querySelector('.conf-step__button-accent').addEventListener('click', (e) => {
        e.preventDefault();
        popupRemoveHall.classList.toggle('active');
        fetch('http://localhost:8001/php/back.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(['deleteHall', el.parentNode.textContent])
        });
        el.parentNode.remove();
        hallsSessionGrid.children[id].remove();
        reloadConfigurations();
        fetch('http://localhost:8000/php/backAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(['halls', halls.innerHTML, configurationsHallsPrice[0].innerHTML, hallsSessionGrid.innerHTML])
        });
      }, { once: true });


    });
  });
}

deleteHall();
addingHall.addEventListener('click', (e) => {
  e.preventDefault();
  popupHall.classList.toggle('active');
  halls.innerHTML += `<li>${popupHall.querySelector('.conf-step__input').value}<button class="conf-step__button conf-step__button-trash"></button></li>`;
  hallsSessionGrid.innerHTML += `<div class="conf-step__seances-hall"><h3 class="conf-step__seances-title">${popupHall.querySelector('.conf-step__input').value}</h3><div class="conf-step__seances-timeline"></div></div>`;
  reloadConfigurations();
  fetch('http://localhost:8000/php/backAdmin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(['halls', halls.innerHTML, configurationsHallsPrice[0].innerHTML, hallsSessionGrid.innerHTML])
  });
  deleteHall();
});











