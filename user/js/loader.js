const seance = document.querySelectorAll('.movie-seances__time');
const days = document.querySelectorAll('.page-nav__day');
let day = '31';
days.forEach(el => {
  el.addEventListener('click', () => {
    days.forEach(e => e.classList.remove('page-nav__day_chosen'));
    el.classList.add('page-nav__day_chosen');
    day = el.children[1].textContent;
  });
});

seance.forEach(el => {
  el.addEventListener('click', (e) => {
    e.preventDefault();
    const nameFilm = el.parentNode.parentNode.parentNode.parentNode.children[0].children[1].children[0].textContent;
    const hallTimeChairs = { hall: el.parentNode.parentNode.previousElementSibling.textContent, time: el.textContent, day: day };
    const params = new URLSearchParams(hallTimeChairs).toString();
    fetch(`http://localhost:8001/php/hall.php?${params}`).then(response => response.json()).then(data => {
      const arrData = JSON.parse(JSON.stringify(data));
      document.querySelector('body').innerHTML = `<header class="page-header">
        <h1 class="page-header__title">Идём<span>в</span>кино</h1>
      </header>
      <main>
        <section class="buying">
          <div class="buying__info">
            <div class="buying__info-description">
              <h2 class="buying__info-title">${nameFilm}</h2>
              <p class="buying__info-start">Начало сеанса: ${el.textContent}</p>
              <p class="buying__info-hall">${el.parentNode.parentNode.previousElementSibling.textContent}</p>          
            </div>
            <div class="buying__info-hint">
              <p>Тапните дважды,<br>чтобы увеличить</p>
            </div>
          </div>
          <div class="buying-scheme">
            <div class="buying-scheme__wrapper">${arrData[1]}</div>
            <div class="buying-scheme__legend">
              <div class="col">
                <p class="buying-scheme__legend-price"><span class="conf-step__chair conf-step__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">${arrData[0]['standart']}</span> руб)</p>
                <p class="buying-scheme__legend-price"><span class="conf-step__chair conf-step__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">${arrData[0]['vip']}</span> руб)</p>            
              </div>
              <div class="col">
                <p class="buying-scheme__legend-price"><span class="conf-step__chair buying-scheme__chair_taken"></span> Занято</p>
                <p class="buying-scheme__legend-price"><span class="conf-step__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
              </div>
            </div>
          </div>
          <button class="acceptin-button">Забронировать</button>
        </section>     
      </main>`;
      const booking = document.querySelector('.acceptin-button');
      const chairs = document.querySelector('.buying-scheme__wrapper');
      const prices = [+arrData[0]['standart'], +arrData[0]['vip']];

      let buyingChairs = '';
      Array.from(chairs.children).forEach(row => {
        Array.from(row.children).forEach((chair, index) => {
          if (!chair.classList.contains('conf-step__chair_disabled') && !chair.classList.contains('buying-scheme__chair_taken')) {
            chair.addEventListener('click', () => {
              chair.classList.toggle('buying-scheme__chair_selected');
              if (buyingChairs.length !== 0) {
                buyingChairs += ', ' + (index + 1);
              } else {
                buyingChairs += index + 1;
              }

            });
          }
        });
      });
      booking.addEventListener('click', () => {
        if (document.querySelectorAll('.buying-scheme__chair_selected').length > 1) {
          let sumPrices = 0;
          Array.from(chairs.children).forEach(row => {
            Array.from(row.children).forEach(chair => {
              if (chair.classList.contains('buying-scheme__chair_selected')) {
                if (chair.classList.contains('conf-step__chair_standart')) {
                  sumPrices += prices[0];
                } else if (chair.classList.contains('conf-step__chair_vip')) {
                  sumPrices += prices[1];
                }
                chair.classList.remove('buying-scheme__chair_selected');
                chair.classList.remove('conf-step__chair_standart');
                chair.classList.remove('conf-step__chair_vip');
                chair.classList.add('buying-scheme__chair_taken');
              }
            });
          });
          const chairsTaken = chairs.innerHTML;
          document.querySelector('body').innerHTML = `<header class="page-header">
            <h1 class="page-header__title">Идём<span>в</span>кино</h1>
          </header>
          <main>
            <section class="ticket">
              <header class="tichet__check">
                <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
              </header>
              <div class="ticket__info-wrapper">
                <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">${nameFilm}</span></p>
                <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">${buyingChairs}</span></p>
                <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">${el.parentNode.parentNode.previousElementSibling.textContent}</span></p>
                <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">${el.textContent}</span></p>
                <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">${sumPrices}</span> руб.</p>

                <button class="acceptin-button">Получить код бронирования</button>

                <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
                <p class="ticket__hint">Приятного просмотра!</p>
              </div>
            </section>     
          </main>`;
          const receiveBooking = document.querySelector('.acceptin-button');
          receiveBooking.addEventListener('click', () => {
            fetch('http://localhost:8001/php/hall.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json;charset=utf-8'
              },
              body: JSON.stringify([hallTimeChairs, chairsTaken])
            }).then(response => {
              if (response.ok) {
                const dataQR = {
                  'Фильм': nameFilm,
                  'Места': buyingChairs,
                  'Зал': el.parentNode.parentNode.previousElementSibling.textContent,
                  'Начало': el.textContent,
                  'Стоимость': sumPrices
                }
                fetch('http://localhost:8001/php/qr.php', {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                  },
                  body: JSON.stringify(dataQR)
                }).then(response => response.blob()).then(qr => {
                  document.querySelector('body').innerHTML = `<header class="page-header">
                      <h1 class="page-header__title">Идём<span>в</span>кино</h1>
                    </header>
                    
                    <main>
                      <section class="ticket">
                        
                        <header class="tichet__check">
                          <h2 class="ticket__check-title">Электронный билет</h2>
                        </header>
                        
                        <div class="ticket__info-wrapper">
                          <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">${dataQR['Фильм']}</span></p>
                          <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">${dataQR['Места']}</span></p>
                          <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">${dataQR['Зал']}</span></p>
                          <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">${dataQR['Начало']}</span></p>

                          <img class="ticket__info-qr" src="${URL.createObjectURL(qr)}">

                          <p class="ticket__hint">Покажите QR-код нашему контроллеру для подтверждения бронирования.</p>
                          <p class="ticket__hint">Приятного просмотра!</p>
                        </div>
                      </section>     
                    </main>`;
                });
              }
            });
          });
        } else {
          alert('Вы не выбрали место!');
        }


      });
    });
  });
});
