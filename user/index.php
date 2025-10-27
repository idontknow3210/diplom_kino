<?php
header('Access-Control-Allow-Origin: http://localhost:8001');
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

$frontSeances = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/films/seance.json'), true);
$frontInfofilm = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/films/infofilm.json'), true);

$result = '';
foreach($frontInfofilm as $key=>$value) {
  if($frontSeances[$key]!==null) {
    ksort($frontSeances[$key]);
  }
  $frontHalls = '';
  foreach($frontSeances[$key] as $k=>$v) {
    $timeFilm = '';
    sort($v);
    for($i = 0; $i<count($v); $i++) {
      $timeFilm.='<li class="movie-seances__time-block"><a class="movie-seances__time" href="http://localhost:8001/">' . $v[$i] . '</a></li>';
    }
    $frontHalls.= '<div class="movie-seances__hall">
          <h3 class="movie-seances__hall-title">' . $k . '</h3>
          <ul class="movie-seances__list">' . $timeFilm . '</ul>
        </div>';
  }
  
  $result.='<section class="movie">
      <div class="movie__info">
        <div class="movie__poster">
          <img class="movie__poster-image" alt="' . $key . ' постер" src="' . $frontInfofilm[$key]['image'] . '">
        </div>
        <div class="movie__description">
          <h2 class="movie__title">' . $key . '</h2>
          <p class="movie__synopsis">' . $frontInfofilm[$key]['description'] . '</p>
          <p class="movie__data">
            <span class="movie__data-duration">' . $frontInfofilm[$key]['duration'] . ' мин</span>
            <span class="movie__data-origin">' . $frontInfofilm[$key]['country'] . '</span>
          </p>
        </div>
      </div>' . $frontHalls . '</section>';
}



echo '<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  
  <nav class="page-nav">
    <a class="page-nav__day page-nav__day_today" href="#">
      <span class="page-nav__day-week">Пн</span><span class="page-nav__day-number">31</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Вт</span><span class="page-nav__day-number">1</span>
    </a>
    <a class="page-nav__day page-nav__day_chosen" href="#">
      <span class="page-nav__day-week">Ср</span><span class="page-nav__day-number">2</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Чт</span><span class="page-nav__day-number">3</span>
    </a>
    <a class="page-nav__day" href="#">
      <span class="page-nav__day-week">Пт</span><span class="page-nav__day-number">4</span>
    </a>
    <a class="page-nav__day page-nav__day_weekend" href="#">
      <span class="page-nav__day-week">Сб</span><span class="page-nav__day-number">5</span>
    </a>
    <a class="page-nav__day page-nav__day_next" href="#">
    </a>
  </nav>
  
  <main>' . $result . '</main>
  <script type="text/javascript" src="http://localhost:8001/js/loader.js"></script>
  
</body>
</html>';