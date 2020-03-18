<?php
session_start();
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/new-user.php'); // скрипт для регистрации пользователя
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
  else{  // если пользователь не авторизован то отображаем форму регистрации         
  ?>
  <div class="card mt-5 mb-5 bordrad-30">
    <h4 class="card-header special-color white-text text-center py-4 bordrad-oglav-reg">
      <strong>Регистрация пользователя</strong>
    </h4>
    <div class="card-body px-lg-5">
      <form id="form-registr" method="post" action="registr.php" style="color: #757575; display:<?php echo show_confirmation() ? 'none' : 'block'; ?>">
        <?php if (!empty($errors)) // если найдена ошибка
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
        <p class="text-center">
          Приветствуем! Пройдите быструю регистрацию на нашем сайте, которая займет не более 5 минут вашего времени. Для успешной регистраций заполните все поля и следуйте подсказкам при необходимости.
        </p>
        <?php
        }
        ?>
        <hr>
        <p class="text-center col-mork">
            <i class="fas fa-info-circle light-green-text"></i>&nbsp;У меня уже есть аккаунт <a href="autorization.php">войти</a>
        </p>
        <hr>
        <div class="form-group row">
          <label for="phone" class="col-sm-2 col-form-label">Введите ваш номер телефона:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-mobile-alt prefix blue-grey-text txtshad-phone"></i>
              <input type="text" name="numb_phone" class="form-control validate" id="phone" placeholder="Номер телефона..." value="<?=$numb_phone ?>">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="user_name" class="col-sm-2 col-form-label">Введите ваше имя:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-user-edit prefix deep-orange-text txtshad-name"></i>
              <input type="text" name="user_name" class="form-control validate" id="user_name" placeholder="Имя пользователя..." value="<?=$user_name ?>">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="email" class="col-sm-2 col-form-label">Введите ваш email-адрес:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-envelope-square prefix green-text txtshad-mail"></i>
              <input type="text" name="email" class="form-control validate" id="email" placeholder="Email-адрес..." value="<?=$email ?>">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="pswd" class="col-sm-2 col-form-label">Придумайте пароль:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-lock prefix red-text txtshad-pass"></i>
              <input type="password" name="pass" class="form-control validate" id="pswd" placeholder="Пароль...">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="repeat_pass" class="col-sm-2 col-form-label">Подтвердите пароль:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-lock prefix red-text txtshad-pass"></i>
              <input type="password" name="repeat_pass" class="form-control validate" id="repeat_pass" placeholder="Подтверждение пароля...">
            </div>
          </div>
        </div>
        <button class="btn btn-mdb-color btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit" name="go_registr">Зарегистироваться&nbsp;<i class="fas fa-paper-plane"></i></button>
      </form>
      <div style="display:<?php echo show_confirmation() ? 'block' : 'none'; ?>">
        <p class="text-center text-success">
            <i class="fas fa-check-circle fa-6x col-green txtshad-goodrega"></i>
        </p>
        <p class="text-center red-text"><b>Поздравляю, вы успешно зарегистрировались на нашем сайте! Теперь вы можете <a href="autorization.php" class="col-sea"><u>авторизоваться</u></a></b></p>
      </div>
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
<script type="text/javascript" src="js/jquery.validate.min.js">
</script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js">
</script>
<script type="text/javascript" src="js/validate.js">
</script>
</body>

</html>