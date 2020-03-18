<?php
session_start();
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/aut-user.php'); // скрипт для авторизации пользователя
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container">
  <?php
  if (isset($_SESSION['user_auto']) && $_SESSION['user_auto']  == 1) { // проверка авторизован ли пользователь
  ?>
  <div class="col mt-5 mb-5 text-center wow fadeIn" style="height: 500px;">
    <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
    <h1>Вы уже авторизованы на сайте!</h1>
    <p>
      <strong><a href="profile.php">Перейти к личный кабинет</a></strong>
    </p>
  </div>
  <?php
  }
  else{           
  ?>
  <div class="card mt-5 mb-5 bordrad-30">
    <h4 class="card-header special-color white-text text-center py-4 bordrad-oglav-reg">
      <strong><i class="fas fa-user-tie"></i>&nbsp;Авторизация пользователя</strong>
    </h4>
    <div class="card-body px-lg-5">
      <form id="form-autor" method="post" action="autorization.php" style="color: #757575;">
        <?php if (!empty($errors)) // если найдена ошибка в процессе выполнения скрипта
        {
        ?>
        <p class="text-center text-danger">
          <i class="fas fa-exclamation-triangle fa-5x txtshad-errors"></i>
        </p>
        <p class="text-center red-text"><?php echo array_shift($errors); ?></p>
        <?php
        }
        else{
        ?>
        <?php
        }
        ?>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">Ваш Номер:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-mobile-alt prefix blue-grey-text txtshad-phone"></i>
              <input type="text" name="numb_phone" class="form-control validate" id="phone" placeholder="Номер телефона...">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="pswd" class="col-sm-2 col-form-label">Ваш Пароль:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-lock prefix red-text txtshad-pass"></i>
              <input type="password" name="pass" class="form-control validate" id="pswd" placeholder="Пароль...">
            </div>
          </div>
        </div>
        <button class="btn btn-mdb-color btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit" name="go_autor">Войти в личный кабинет&nbsp;<i class="fas fa-paper-plane"></i></button>
        <hr>
        <p class="text-center">
          <a href="#">Забыли пароль?</a>
        </p>
        <hr>
      </form>
    </div>
  </div>
  <?php
  }
  ?>
</div>
</main>
<?php
require_once('php/footer.php'); // верстка footer
?>
<!-- Валидация JS -->
<script type="text/javascript" src="js/jquery.validate.min.js">
</script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js">
</script>
<script type="text/javascript" src="js/validate.js">
</script>
</body>

</html>