<?php
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

$halls = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\halls.json'));
$hallsSection = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\hallsSection.json'));
$hallsSeance = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\hallsSeance.json'));
$films = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\films.json'));
$chairsHall = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '\HTML\chairsHall.json'));

echo '<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="CSS/normalize.css">
  <link rel="stylesheet" href="CSS/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>

  <div class="popup" id="hall">
    <div class="popup__container">
      <div class="popup__content">
        <div class="popup__header">
          <h2 class="popup__title">
            Добавление зала
            <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
          </h2>
        </div>
        <div class="popup__wrapper">
          <form action="add_hall" method="post" accept-charset="utf-8">
            <label class="conf-step__label conf-step__label-fullsize">
              Название зала
              <select class="conf-step__input" name="name" autocomplete="off" required></select>
            </label>
            <div class="conf-step__buttons text-center">
              <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent" data-event="hall_add">
              <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="popup" id="film">
    <div class="popup__container">
      <div class="popup__content">
        <div class="popup__header">
          <h2 class="popup__title">
            Добавление фильма
            <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
          </h2>
        </div>
        <div class="popup__wrapper">
          <form action="add_movie" method="post" accept-charset="utf-8">
            <div class="popup__container">
              <div class="popup__poster"></div>
              <div class="popup__form">
                <label class="conf-step__label conf-step__label-fullsize" for="name">
                  Название фильма
                  <input class="conf-step__input" type="text" placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="name" required>
                </label>
                <label class="conf-step__label conf-step__label-fullsize" for="name">
                  Продолжительность фильма (мин.)
                  <input class="conf-step__input" type="text"  name="duration" data-last-value="" required>
                </label>
                <label class="conf-step__label conf-step__label-fullsize" for="name">
                  Описание фильма
                  <textarea class="conf-step__input" type="text" name="description"  required></textarea>
                </label>
                <label class="conf-step__label conf-step__label-fullsize" for="name">
                  Страна
                  <input class="conf-step__input" type="text"  name="country" data-last-value="" required>
                </label>
                <label class="conf-step__label conf-step__label-fullsize" for="name">
                  Постер фильма
                  <input class="conf-step__input" type="file"  name="file" data-last-value="" required>
                </label>
              </div>
            </div>
            <div class="conf-step__buttons text-center">
              <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent" data-event="film_add">
              <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="popup" id="seance">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление сеанса
          <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form action="add_movie" method="post" accept-charset="utf-8">
          <label class="conf-step__label conf-step__label-fullsize" for="hall">
            Название зала
            <select class="conf-step__input" name="hall" required>
            </select>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="hall">
            Название фильма
            <select class="conf-step__input" name="film" required>
            </select>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="name">
            Время начала
            <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
          </label>
  
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent" data-event="seance_add">
            <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <div class="popup" id="removeHall">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Удаление зала
          <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form action="delete_hall" method="post" accept-charset="utf-8">
          <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span>"Название зала"</span>?</p>
          <!-- В span будет подставляться название зала -->
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <div class="popup" id="removeFilm">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Удаление фильма
          <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form action="delete_hall" method="post" accept-charset="utf-8">
          <p class="conf-step__paragraph">Вы действительно хотите удалить фильм <span>"Название фильма"</span>?</p>
          <!-- В span будет подставляться название фильма -->
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <div class="popup" id="removeSeance">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Снятие с сеанса
          <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form action="delete_hall" method="post" accept-charset="utf-8">
          <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм <span>"Название фильма"</span>?</p>
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>

  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторррская</span>
  </header>
  
  <main class="conf-steps">
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">' . $halls . '</ul>
        <button class="conf-step__button conf-step__button-accent" id="createHall">Создать зал</button>
      </div>
    </section>
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">' . $hallsSection . '</ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
          <label class="conf-step__label">Рядов, шт<input type="text" class="conf-step__input" id="rows" placeholder="10" ></label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">Мест, шт<input type="text" class="conf-step__input" id="chairs" placeholder="8" ></label>
        </div>
        <p class="conf-step__paragraph">Выберите любой тип кресла:</p>
        <div class="conf-step__legend">
          <span class="conf-step__chair conf-step__chair_standart" id="standart"></span> — обычные кресла
          <span class="conf-step__chair conf-step__chair_vip" id="vip"></span> — VIP кресла
          <span class="conf-step__chair conf-step__chair_disabled" id="disabled"></span> — заблокированные (нет кресла)
          <p class="conf-step__hint">Нажмите на место и оно сменит тип.</p>
        </div>  
        
        <div class="conf-step__hall">
          <div class="conf-step__hall-wrapper">' . $chairsHall . '</div>  
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
          <div style="color: red;"></div>
        </fieldset>                 
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">' . $hallsSection . '</ul>
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0"></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input" placeholder="0"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>  
        
        <fieldset class="conf-step__buttons text-center">
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
          <div style="color: red;"></div>
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent" id="addFilm">Добавить фильм</button>
        </p>
        <div class="conf-step__movies">' . $films . '</div>
      
        <div class="conf-step__seances">' . $hallsSeance . '</div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-accent">Добавить сеанс</button>
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph">Всё готово, теперь можно:</p>
        <a href="http://localhost:8001/"><button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button><a/>
      </div>
    </section>    
  </main>

  <script type="text/javascript" src="http://localhost:8000/js/accordeon.js"></script>
  <script type="text/javascript" src="http://localhost:8000/js/add-removeHall.js"></script>
  <script type="text/javascript" src="http://localhost:8000/js/confHalls.js"></script>
  <script type="text/javascript" src="http://localhost:8000/js/sessionGrid.js"></script>
  <script type="text/javascript" src="http://localhost:8000/js/fetch.js"></script>
</body>
</html>';