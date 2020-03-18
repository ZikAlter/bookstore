<?php
if (isset($_POST['exit'])) { // кнопка выйти с аккаунта
  session_destroy(); // уничтожение ссесий
  unset($_SESSION['user_auto']); // обнуление авторизации
  header("Location: index.php"); // переброска на главную страницу
}
require_once('php/load-recviz.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <!-- Кодировка символов UFT-8 -->
  <meta charset="utf-8">
  <!-- Активация мобильной версии -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Наименование сайта -->
  <title>Интернет магазин "ХакИРОиПК"</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="style.css" rel="stylesheet">
  <!-- Animate CSS -->
  <link href="css/animate.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond|Pacifico|Play|Marck+Script|Marmelad|Jura|Ubuntu|Philosopher|Comfortaa|Caveat|Poiret+One" rel="stylesheet">
  <!-- Иконка сайта -->
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon">
</head>
<body>
<header class="fon-header" >
<div class="container-fluid color-fonsrgba">
  <div class="container">
    <div class="row pt-5 pb-5">
      <div class="col">
        <img src="img/hakirolog.jpg" width="200px" height="200px" class="img-fluid logo-hakiro wow zoomIn" data-wow-duration="2s">
      </div>
      <div class="col-9 text-center txtshad-black wow fadeInDown">
        <h2><i class="fab fa-phoenix-framework fa-2x col-fenix wow lightSpeedIn" data-wow-delay="1s"></i>&nbsp;<?php echo $cord['name_magaz']; ?></h2>
        <h4 class="pt-3 text-center"><i class="fas fa-map-marked-alt col-maps"></i>&nbsp;<?php echo $cord['fact_address']; ?></h4>
        <h4 class="pb-3 text-center"><i class="fas fa-phone-square col-phone"></i>&nbsp;<?php echo $cord['phone_mag']; ?></h4>
        <i>"Великая цель образования —  не только знания, но и прежде всего действия" - <u>Н.И. Мирон</u></i>
      </div>
    </div>
  </div>
</div>
</header>
<nav class="navbar navbar-expand-lg navbar-dark glavmenu-fon">
  <div class="container ">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">   
      <span class="navbar-toggler-icon"></span>
      Меню
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav mr-4 ">
        <li class="nav-item pr-xl-5 pr-sm-0">
          <a class="nav-link" href="index.php"><i class="fas fa-home fa-fw" aria-hidden="true"></i>&nbsp;Главная</a>
        </li>
        <li class="nav-item dropdown pr-xl-5 pr-sm-0">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp;Книги</a>
          <div class="dropdown-menu">
            <a class="dropdown-item elemt-book-menu" href="spisok-book.php"><i class="fab fa-battle-net col-redbook"></i>&nbsp;Полный список</a>
            <?php
            $menu_cat = mysqli_query($con_li, "SELECT * FROM `categor-book`"); // sql запрос на выбор категории книг
            $whilecategor = mysqli_num_rows($menu_cat); // подсчет категории из запроса
            if ($whilecategor) { // если массив не пуст то отобразить
              while ($art = mysqli_fetch_assoc($menu_cat)) {
            ?>
              <a class="dropdown-item elemt-book-menu" href="/spisok-categorbook.php?id=<?php echo $art['id'];?>"><i class="fab fa-battle-net col-redbook"></i>&nbsp;<?php echo $art['categories']; ?></a>
            <?php
              }
            }  
            ?>
          </div>
        </li>
        <li class="nav-item dropdown pr-xl-5 pr-sm-0">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-globe-americas fa-fw" aria-hidden="true"></i>&nbsp;Мероприятия</a>
          <div class="dropdown-menu">
            <a class="dropdown-item elemt-book-menu" href="spisok-seminar.php"><i class="fab fa-battle-net col-redbook"></i>&nbsp;Семинары</a>
            <a class="dropdown-item elemt-book-menu" href="spisok-course.php"><i class="fab fa-battle-net col-redbook"></i>&nbsp;Курсы</a>
          </div>
        </li>
        <li class="nav-item dropdown pr-xl-5 pr-sm-0">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><i class="fas fa-address-card fa-fw" aria-hidden="true"></i>&nbsp;Личный кабинет</a>
          <div class="dropdown-menu">
            <?php
            if (isset($_SESSION['user_auto']) && $_SESSION['user_auto']  == 1) { // проверка авторизован ли пользователь
            ?>
            <a href="#" class="dropdown-item elemt-book-menu text-center wow zoomIn">
              <img src="img/avatar/ava.jpg" width="80px" height="80px" class="bordrad-90">
              <p class="pt-3"><?php echo $_SESSION['user_name']; ?></p>
            </a>
            <a href="profile.php" class="dropdown-item elemt-book-menu text-center wow fadeIn" data-wow-duration="2s">
              <button type="button" class="btn btn-indigo">Моя страница</button>
            </a>
            <a href="#" class="dropdown-item elemt-book-menu text-center wow fadeIn" data-wow-duration="2s">
              <form action="index.php" method="POST">
              <button type="submit" name="exit" class="btn btn-danger"><i class="fas fa-sign-out-alt mr-3"></i>Выйти</button>
              </form>
            </a>
            <?php
            } else { // если пользователь не авторизован выводим другие пункты в меню           
            ?>
            <a class="dropdown-item elemt-book-menu" href="autorization.php"><i class="fas fa-user-circle fa-2x col-fenix"></i>&nbsp;Войти в личный кабинет</a>
            <a class="dropdown-item elemt-book-menu" href="registr.php"><i class="fa fa-user-secret fa-2x col-world"></i>&nbsp;Регистрация пользователя</a>
            <?php
            }
            ?>            
          </div>
        </li>
        <li class="nav-item pr-xl-5 pr-sm-0">
          <a class="nav-link " href="#"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Корзина(0)</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="contact.php"><i class="fa fa-info fa-fw" aria-hidden="true"></i>&nbsp;О нас</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
