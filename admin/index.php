<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Access-Control-Allow-Origin: http://localhost:8000');
header('Content-Type: text/html; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');

if(isset($_GET['email'])) {
  $password = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/pass/password.json'));

  if($_GET['email']==='aaa@aaa.ru' && password_verify($_GET['password'], $password)) {
    header("Location: http://localhost:8000/php/admin.php");
  } else {
    echo 'Error password or email';
  }
} else {

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

  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторррская</span>
  </header>
  
  <main>
    <section class="login">
      <header class="login__header">
        <h2 class="login__title">Авторизация</h2>
      </header>
      <div class="login__wrapper">
        <form class="login__form" id="loginForm">
          <label class="login__label" for="email">
            E-mail
            <input class="login__input" id="email" type="email" placeholder="example@domain.xyz" name="email" autocomplete="on" required>
          </label>
          <label class="login__label" for="pwd">
            Пароль
            <input class="login__input" id="pwd" type="password" placeholder="password" name="password" autocomplete="off" required>
          </label>
          <div class="text-center">
            <input value="Авторизоваться" type="submit" class="login__button">
          </div>
        </form>
        <div style="color: red; text-align: center;"></div>
      </div>
      
    </section>
  </main>
  <script>
const form = document.querySelector(".login__form");
function ReplaceContent(newContent) { 
    document.open(); 
    document.write(newContent); 
    document.close(); 
}
form.addEventListener("submit", (e)=>{
    e.preventDefault();
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    
    fetch(`http://localhost:8000?${params}`).then(response => response.text()).then(data=>{
        if(data==="Error password or email") {
            document.querySelector(".login__wrapper").children[1].innerHTML=data;    
        } else {
            ReplaceContent(data); 
        }
    });
});
  </script>
</body>
</html>';
}
