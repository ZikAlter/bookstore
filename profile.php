<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
if(isset($_POST['goodbye_user'])){ // кнопка выхода с кабинета
  session_destroy(); // уничтожение сессии
  unset($_SESSION['user_auto']); // обнуляем авторизацию
  header("Location: index.php"); // перекидываем на главную страницу
}
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container">
  <?php
  if (isset($_SESSION['user_auto']) && $_SESSION['user_auto']  == 1) { // проверка авторизован ли пользователь
  ?>
  <!--Modal: modalConfirmDelete-->
  <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
      <!--Content-->
      <div class="modal-content text-center">
        <!--Header-->
        <div class="modal-header d-flex justify-content-center">
          <p class="heading">Вы действительно хотите выйти из личного кабинета?</p>
        </div>
        <!--Body-->
        <div class="modal-body">
          <i class="fas fa-times fa-4x animated rotateIn"></i>
        </div>
        <!--Footer-->
        <div class="modal-footer flex-center">
          <form action="profile.php" method="POST">
          <button type="submit" class="btn btn-outline-danger" name="goodbye_user">Да</button>
          </form>
          <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Нет</button>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>
  <!--Modal: modalConfirmDelete-->
  <div class="row mt-5 mb-5">
    <div class="col-sm-10 col-xl-5 text-center">
      <img src="img/avatar/ava.jpg" width="200px" height="200px" class="rounded-circle">
      <div class="nav flex-column nav-pills text-center mt-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
          <strong>Обо мне</strong>
        </a>
        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
          <strong>История покупок</strong>
        </a>
        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
          <strong>Связь с администрацией</strong>
        </a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
          <strong>Поменять имя пользователя</strong>
        </a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
          <strong>Сменить пароль</strong>
        </a>
        <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
          <strong>Сменить email-адрес</strong>
        </a>
        <form action="index.php" method="POST">
        <button type="button" name="exit" class="btn btn-danger btn btn-block" data-toggle="modal" data-target="#modalConfirmDelete"><i class="fas fa-sign-out-alt mr-3"></i>Выйти</button>
        </form>
      </div>
    </div>
    <div class="col-sm-10 col-xl-6">
      <h1 class="lk-info-username">
          <?php echo $_SESSION['user_name']; ?>
      </h1>
      <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <p>
            <b class="lk-info-vseouser">Дата регистрации:</b> 
            <strong><?php echo date("d-m-Y в H:i", strtotime($_SESSION['date_registr'])); ?></strong>
          </p>
          <p>
            <b class="lk-info-vseouser">Количество ваших отзывов:</b>
            <strong>
            <?php
              $numeric = $_SESSION['numb_phone']; // номер телефона пользователя
              $res = mysqli_query($con_li,"SELECT COUNT(1) FROM `comments` WHERE `log_comment` = '$numeric'"); // sql запрос на подсчет отзывов
              if($res) // если что то найдено
                $row = mysqli_fetch_array($res); // формируем подсчет
                $kolvo_otziv = !empty($row[0]) ? $row[0] : 0; 
              echo $kolvo_otziv;
            ?>
            </strong>
          </p>
          <p>
            <b class="lk-info-vseouser">Ваш email-адрес:</b> 
            <strong><?php echo $_SESSION['email']; ?></strong>
          </p>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">В разработке</div>
        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">В разработке</div>
        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">В разработке</div>
      </div>
    </div>
  </div>
  <?php
  }
  else{ // если не авторизован то выводим сообщение об этом      
  ?>
  <div class="col mt-5 mb-5 text-center wow fadeIn" style="height: 500px;">
    <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
    <h1>Ошибка! Вы не авторизовались как пользователь...</h1>
    <p>
      <strong><a href="autorization.php">Перейти к авторизации</a></strong>
    </p>
    <hr>
    <p>
      <strong><a href="registr.php">Зарегистрироваться на сайте</a></strong>
    </p>
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