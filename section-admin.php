<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/admin-connect.php'); // скрипт авторизации администратора
require_once('php/update-rekviz.php'); // скрипт для обновления реквизитов
require_once('php/ban-user.php'); // скрипт для блокировки пользователей
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container">
  <?php
  if (isset($_SESSION['user_auto']) && $_SESSION['user_auto'] == 1) { // проверка авторизован ли пользователь
  ?>
    <?php
    if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    ?>
      <div class="row">
        <div class="col special-color white-text text-center py-4">
          <h1>
            <i class="fas fa-h-square fa-2x col-logo-hakiro"></i>
            <p class="font-ubuntu">Hakiro Control System</p>
          </h1>
        </div>
      </div>
      <?php
      if (!empty($ups_now)){ // если найдена ошибка
      ?>
      <div class="row mt-2">
        <div class="col">
          <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <p class="text-center text-danger">
            <i class="fas fa-exclamation-triangle fa-5x txtshad-errors"></i>
            </p>
            <p class="text-center red-text"><strong><?php echo array_shift($ups_now); ?></strong></p>
          </div>
        </div>
      </div>
      <?php
      }
      else if(!empty($sogood_now)){ // если найдена ошибка
      ?>
      <div class="row mt-2">
        <div class="col">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <p class="text-center text-success">
            <i class="fas fa-check-circle fa-6x col-green txtshad-goodrega"></i>
            </p>
            <p class="text-center"><b><?php echo array_shift($sogood_now); ?></b></p>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
      <div class="row mb-5 justify-content-center">
        <div class="col-sm-10 col-xl-3 text-center">
          <div class="nav flex-column nav-pills text-center mt-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-stats-tab" data-toggle="pill" href="#v-pills-stats" role="tab" aria-controls="v-pills-stats" aria-selected="true">
              <strong><i class="fas fa-info-circle mr-2"></i>Статистика</strong>
            </a>
            <a class="nav-link" id="v-pills-rekviz-tab" data-toggle="pill" href="#v-pills-rekviz" role="tab" aria-controls="v-pills-rekviz" aria-selected="false">
              <strong><i class="fas fa-landmark mr-2"></i>Реквизиты магазина</strong>
            </a>
            <a class="nav-link" id="v-pills-blockuser-tab" data-toggle="pill" href="#v-pills-blockuser" role="tab" aria-controls="v-pills-blockuser" aria-selected="false">
              <strong><i class="fas fa-user-slash mr-2"></i>Блокировка пользователей</strong>
            </a>
            <a class="nav-link" id="v-pills-book-tab" data-toggle="pill" href="#v-pills-book" role="tab" aria-controls="v-pills-book" aria-selected="false">
              <strong><i class="fas fa-book mr-2"></i>Добавить книгу</strong>
            </a>
            <a class="nav-link" id="v-pills-seminar-tab" data-toggle="pill" href="#v-pills-seminar" role="tab" aria-controls="v-pills-seminar" aria-selected="false">
              <strong><i class="fas fa-school mr-2"></i>Добавить семинар</strong>
            </a>
            <a class="nav-link" id="v-pills-course-tab" data-toggle="pill" href="#v-pills-course" role="tab" aria-controls="v-pills-course" aria-selected="false">
              <strong><i class="fas fa-users mr-2"></i>Добавить курс</strong>
            </a>
            <a href="blacklist-user.php" target="_blank">
              <button type="button" class="btn btn-indigo btn btn-block mb-2"><i class="fas fa-address-book mr-2"></i>Список заблокированных пользователей</button>
            </a>
            <a href="sitelog.php" target="_blank">
              <button type="button" class="btn btn-elegant btn btn-block"><i class="fas fa-bullhorn mr-2"></i>Журнал событий</button>
            </a>
          </div>
        </div>
        <div class="col-sm-10 col-xl-8 ml-xl-5 ml-sm-0">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active font-ubuntu" id="v-pills-stats" role="tabpanel" aria-labelledby="v-pills-stats-tab">
              <h1 class="text-center">Статистика данных на <strong class="text-primary"><?php echo date("d/m/Y"); ?></strong></h1>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Количество пользователей:
                      <?php
                      $res_user = mysqli_query($con_li,"SELECT COUNT(1) FROM `user`"); // sql запрос подсчет пользователей
                      if($res_user)
                        $row = mysqli_fetch_array($res_user);
                        $kolvo_user = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_user; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Число заблокированных: 
                      <?php
                      $res_block = mysqli_query($con_li,"SELECT COUNT(1) FROM `black_list`"); // sql запрос подсчет заблокированных
                      if($res_block)
                        $row = mysqli_fetch_array($res_block);
                        $kolvo_block = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_block; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Общее число отзывов: 
                      <?php
                      $res_comment = mysqli_query($con_li,"SELECT COUNT(1) FROM `comments`"); // sql запрос подсчет отзывов
                      if($res_comment)
                        $row = mysqli_fetch_array($res_comment);
                        $kolvo_comment = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_comment; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Всего отзывов на книг: 
                      <?php
                      $res_book_comment = mysqli_query($con_li,"SELECT COUNT(1) FROM `comments` WHERE `num_razdel` = '1'"); // sql запрос подсчет отзывов по книгам
                      if($res_book_comment)
                        $row = mysqli_fetch_array($res_book_comment);
                        $kolvo_book_comment = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_book_comment; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Всего отзывов на семинары: 
                      <?php
                      $res_seminar_comment = mysqli_query($con_li,"SELECT COUNT(1) FROM `comments` WHERE `num_razdel` = '2'"); // sql запрос подсчет отзывов по семинарам
                      if($res_seminar_comment)
                        $row = mysqli_fetch_array($res_seminar_comment);
                        $kolvo_seminar_comment = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_seminar_comment; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Всего отзывов на курсы: 
                      <?php
                      $res_course_comment = mysqli_query($con_li,"SELECT COUNT(1) FROM `comments` WHERE `num_razdel` = '3'"); // // sql запрос подсчет отзывов по курсам
                      if($res_course_comment)
                        $row = mysqli_fetch_array($res_course_comment);
                        $kolvo_course_comment = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_course_comment; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Общее число книг: 
                      <?php
                      $res_book = mysqli_query($con_li,"SELECT COUNT(1) FROM `books`"); // sql запрос подсчет книг
                      if($res_book)
                        $row = mysqli_fetch_array($res_book);
                        $kolvo_book = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_book; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Всего популярных книг: 
                      <?php
                      $res_book = mysqli_query($con_li,"SELECT COUNT(1) FROM `books` WHERE `top_book` = '1'"); // sql запрос подсчет популярных книг
                      if($res_book)
                        $row = mysqli_fetch_array($res_book);
                        $kolvo_book = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_book; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Количество семинаров: 
                      <?php
                      $res_seminar = mysqli_query($con_li,"SELECT COUNT(1) FROM `seminar`"); // sql запрос подсчет семинаров
                      if($res_seminar)
                        $row = mysqli_fetch_array($res_seminar);
                        $kolvo_seminar = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_seminar; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-5 bordbott-black">
                  <div class="spinner-grow text-success float-left" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="float-right">
                    <strong class="text-primary">Количество курсов: 
                      <?php
                      $res_course = mysqli_query($con_li,"SELECT COUNT(1) FROM `courses`"); // sql запрос подсчет курсов
                      if($res_course)
                        $row = mysqli_fetch_array($res_course);
                        $kolvo_course = !empty($row[0]) ? $row[0] : 0; 
                      echo $kolvo_course; 
                      ?>
                    </strong>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade font-ubuntu" id="v-pills-rekviz" role="tabpanel" aria-labelledby="v-pills-rekviz-tab">
              <h1 class="text-center">Изменить реквизиты</h1>
              <form id="new-namemagaz" method="post" action="section-admin.php">
                <div class="form-group row">
                  <label for="rekviz_magaz" class="col-sm-2 col-form-label">Наименование магазина:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="rekviz_magaz" class="form-control validate" id="rekviz_magaz" placeholder="Введите данные..." value="<?=$cord['name_magaz'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_magaz" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-factaddress">
                <div class="form-group row">
                  <label for="factaddress_magaz" class="col-sm-2 col-form-label">Фактический адрес:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="factaddress_magaz" class="form-control validate" id="factaddress_magaz" placeholder="Введите данные..." value="<?=$cord['fact_address'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_factaddress" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-uraddress">
                <div class="form-group row">
                  <label for="uraddress_magaz" class="col-sm-2 col-form-label">Юридический адрес:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="uraddress_magaz" class="form-control validate" id="uraddress_magaz" placeholder="Введите данные..." value="<?=$cord['ur_address'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_uraddress" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-numbphone">
                <div class="form-group row">
                  <label for="phone_magaz" class="col-sm-2 col-form-label">Номер телефона:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="phone_magaz" class="form-control validate" id="phone_magaz" placeholder="Введите данные..." value="<?=$cord['phone_mag'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_phone" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-emailadress">
                <div class="form-group row">
                  <label for="email_magaz" class="col-sm-2 col-form-label">Email-адрес:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="email_magaz" class="form-control validate" id="email_magaz" placeholder="Введите данные..." value="<?=$cord['email_mag'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_email" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-socvk">
                <div class="form-group row">
                  <label for="vk_group" class="col-sm-2 col-form-label">Ссылка на группу vk:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="vk_group" class="form-control validate" id="vk_group" placeholder="Введите данные..." value="<?=$cord['social_vk'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_vk" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-socfacebook">
                <div class="form-group row">
                  <label for="facebook_group" class="col-sm-2 col-form-label">Ссылка на группу facebook:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="facebook_group" class="form-control validate" id="facebook_group" placeholder="Введите данные..." value="<?=$cord['social_facebook'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_facebook" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-socweb">
                <div class="form-group row">
                  <label for="web_site" class="col-sm-2 col-form-label">Ссылка на web-ресурс:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="web_site" class="form-control validate" id="web_site" placeholder="Введите данные..." value="<?=$cord['social_web'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_web" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-googlemaps">
                <div class="form-group row">
                  <label for="google_maps" class="col-sm-2 col-form-label">Google maps:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="google_maps" class="form-control validate" id="google_maps" placeholder="Введите данные..." value="<?=$cord['google_maps'] ?>">
                      <p>
                        <button type="submit" name="new_rekviz_google" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <form method="post" action="section-admin.php" id="new-glosary">
                <div class="form-group row">
                  <label for="magaz_glosary" class="col-sm-2 col-form-label">Описание деятельности:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <textarea class="form-control" placeholder="Напишите что нибудь..." rows="6" name="magaz_glosary" id="magaz_glosary">
                        <?=$cord['text_glossary'] ?>
                      </textarea>
                      <p>
                        <button type="submit" name="new_rekviz_glosary" class="btn btn-mdb-color"><i class="fas fa-feather mr-2"></i>Изменить</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <hr class="mdb-color lighten-2">
              <h1 class="text-center">Действующие реквизиты</h1>
              <p>Наименование магазина: <strong class="indigo-text"><?php echo $cord['name_magaz']; ?></strong></p>
              <p>Фактический адрес: <strong class="indigo-text"><?php echo $cord['fact_address']; ?></strong></p>
              <p>Юридический адрес: <strong class="indigo-text"><?php echo $cord['ur_address']; ?></strong></p>
              <p>Номер телефона: <strong class="indigo-text"><?php echo $cord['phone_mag']; ?></strong></p>
              <p>Email-адрес: <strong class="indigo-text"><?php echo $cord['email_mag']; ?></strong></p>
              <p class="text-break">Ссылка на группу vk: <strong class="indigo-text"><?php echo $cord['social_vk']; ?></strong></p>
              <p class="text-break">Ссылка на группу facebook: <strong class="indigo-text"><?php echo $cord['social_facebook']; ?></strong></p>
              <p class="text-break">Ссылка на web-ресурс: <strong class="indigo-text"><?php echo $cord['social_web']; ?></strong></p>
              <p class="text-break">Google maps: <strong class="indigo-text"><?php echo $cord['google_maps']; ?></strong></p>
              <p>Описание деятельности: <strong class="indigo-text"><?php echo $cord['text_glossary']; ?></strong></p>
            </div>
            <div class="tab-pane fade font-ubuntu" id="v-pills-blockuser" role="tabpanel" aria-labelledby="v-pills-blockuser-tab">
              <h1 class="text-center">Заблокировать пользователя</h1>
              <form method="post" action="section-admin.php" id="block-user">
                <div class="form-group row">
                  <label for="phone" class="col-sm-2 col-form-label">Номер пользователя:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="numban_user" class="form-control validate" id="phone" placeholder="Введите номер телефона...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="reason_ban" class="col-sm-2 col-form-label">Причина блокировки:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <textarea class="form-control" placeholder="Напишите что нибудь..." rows="6" name="reason_ban" id="reason_ban">
                      </textarea>
                      <p>
                        <button type="submit" name="block_user" class="btn btn-outline-danger waves-effect">Заблокировать</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
              <hr class="mdb-color lighten-2">
              <h1 class="text-center">Разблокировать пользователя</h1>
              <form method="post" action="section-admin.php" id="nullblock-user">
                <div class="form-group row">
                  <label for="nullban" class="col-sm-2 col-form-label">Номер пользователя:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="num_nullban_user" class="form-control validate" id="nullban" placeholder="Введите номер телефона...">
                      <p>
                        <button type="submit" name="nullblock_user" class="btn btn-outline-primary waves-effect">Разблокировать</button>
                      </p>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade font-ubuntu" id="v-pills-book" role="tabpanel" aria-labelledby="v-pills-book-tab">
              <h1 class="text-center">Добавление новой книги в каталог товаров</h1>
            </div>
            <div class="tab-pane fade font-ubuntu" id="v-pills-seminar" role="tabpanel" aria-labelledby="v-pills-seminar-tab">
              <h1 class="text-center">Добавление нового семинара в каталог товаров</h1>
              <form method="post" action="section-admin.php" id="new-seminar">
                <div class="form-group row">
                  <label for="name_seminar" class="col-sm-2 col-form-label">Наименование семинара:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="name_seminar" class="form-control validate" id="name_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="date_seminar" class="col-sm-2 col-form-label">Дата проведения:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="date" name="date_seminar" class="form-control validate" id="date_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time_start_seminar" class="col-sm-2 col-form-label">Начало семинара:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="time" name="time_start_seminar" class="form-control validate" id="time_start_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="time_finish_seminar" class="col-sm-2 col-form-label">Завершение семинара:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="time" name="time_finish_seminar" class="form-control validate" id="time_finish_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="place_seminar" class="col-sm-2 col-form-label">Место проведения:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="place_seminar" class="form-control validate" id="place_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="people_seminar" class="col-sm-2 col-form-label">Приглашаем к участию:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="people_seminar" class="form-control validate" id="people_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="target_seminar" class="col-sm-2 col-form-label">Цель проведения:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="target_seminar" class="form-control validate" id="target_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="descript_seminar" class="col-sm-2 col-form-label">Краткое описание:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <textarea class="form-control" placeholder="Напишите что нибудь..." rows="6" name="descript_seminar" id="descript_seminar">
                      </textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="leader_seminar" class="col-sm-2 col-form-label">Руководитель семинара:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="leader_seminar" class="form-control validate" id="leader_seminar" placeholder="Фамилия Имя Отчество...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="position_leader_seminar" class="col-sm-2 col-form-label">Должность руководителя:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="position_leader_seminar" class="form-control validate" id="position_leader_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone_leader_seminar" class="col-sm-2 col-form-label">Телефон руководителя:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="phone_leader_seminar" class="form-control validate" id="phone_leader_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email_leader_seminar" class="col-sm-2 col-form-label">Email-адрес руководителя:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="email_leader_seminar" class="form-control validate" id="email_leader_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price_seminar" class="col-sm-2 col-form-label">Стоимость участия (руб.):</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="number" name="price_seminar" class="form-control validate" id="price_seminar" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="icon_seminar" class="col-sm-2 col-form-label">Выберите иконку:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <div class="btn-group btn-group-toggle p-2" data-toggle="buttons">
                        <label class="btn btn-mdb-color" title="Глобус">
                          <input type="radio" name="icon_seminar" id="option1" autocomplete="off" value="like"> <i class="fas fa-globe-europe fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Атом">
                          <input type="radio" name="icon_seminar" id="option2" autocomplete="off" value="dislike"> <i class="fas fa-atom fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Книга">
                          <input type="radio" name="icon_seminar" id="option2" autocomplete="off" value="dislike"> <i class="fas fa-book-open fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Компьютер">
                          <input type="radio" name="icon_seminar" id="option2" autocomplete="off" value="dislike"> <i class="fas fa-desktop fa-2x"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="file_seminar" class="col-sm-2 col-form-label">Файл информ. письма:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <div class="file-upload-wrapper">
                        <input type="file" id="input-file-now" class="file-upload" />
                        <p class="pt-4">
                          <button type="submit" name="okey_seminar" class="btn btn-deep-orange">Добавить в каталог</button>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="tab-pane fade font-ubuntu" id="v-pills-course" role="tabpanel" aria-labelledby="v-pills-course-tab">
              <h1 class="text-center">Добавление нового курса в каталог товаров</h1>
              <form method="post" action="section-admin.php" id="new-course">
                <div class="form-group row">
                  <label for="name-course" class="col-sm-2 col-form-label">Наименование курса:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="name-course" class="form-control validate" id="name-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="clock-course" class="col-sm-2 col-form-label">Количество часов:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="number" name="clock-course" class="form-control validate" id="clock-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="datestart-course" class="col-sm-2 col-form-label">Дата начало:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="date" name="datestart-course" class="form-control validate" id="datestart-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="datefinish-course" class="col-sm-2 col-form-label">Дата завершения:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="date" name="datefinish-course" class="form-control validate" id="datefinish-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="forms-course" class="col-sm-2 col-form-label">Форма проведения (очное / заочное):</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="forms-course" class="form-control validate" id="forms-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="mesto-course" class="col-sm-2 col-form-label">Место проведения:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="mesto-course" class="form-control validate" id="mesto-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="lektor-course" class="col-sm-2 col-form-label">Ведущий лектор:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="lektor-course" class="form-control validate" id="lektor-course" placeholder="Фамилия Имя Отчество...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="people-course" class="col-sm-2 col-form-label">Приглашаем к участию:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="text" name="people-course" class="form-control validate" id="people-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="txt-course" class="col-sm-2 col-form-label">Краткое описание:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <textarea class="form-control" placeholder="Напишите что нибудь..." rows="6" name="txt-course" id="txt-course">
                      </textarea>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="price-course" class="col-sm-2 col-form-label">Стоимость участия (руб.):</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <input type="number" name="price-course" class="form-control validate" id="price-course" placeholder="Введите данные...">
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="icon-course" class="col-sm-2 col-form-label">Выберите иконку:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <div class="btn-group btn-group-toggle p-2" data-toggle="buttons">
                        <label class="btn btn-mdb-color" title="Глобус">
                          <input type="radio" name="otmetka" id="option1" autocomplete="off" value="earth"> <i class="fas fa-globe-europe fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Атом">
                          <input type="radio" name="otmetka" id="option2" autocomplete="off" value="atom"> <i class="fas fa-atom fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Книга">
                          <input type="radio" name="otmetka" id="option2" autocomplete="off" value="book"> <i class="fas fa-book-open fa-2x"></i>
                        </label>
                        <label class="btn btn-mdb-color ml-4" title="Компьютер">
                          <input type="radio" name="otmetka" id="option2" autocomplete="off" value="comp"> <i class="fas fa-desktop fa-2x"></i>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="file-course" class="col-sm-2 col-form-label">Файл информ. письма:</label>
                  <div class="col-sm-10">
                    <div class="mt-sm-5 mt-xl-0">
                      <div class="file-upload-wrapper">
                        <input type="file" id="input-file-now" class="file-upload" />
                        <p class="pt-4">
                          <button type="submit" name="add-course" class="btn btn-deep-orange">Добавить в каталог</button>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php
    }
    else{ // если пользователь не авторизован под админом то отображаем форму
    ?>
    <div class="card mt-5 mb-5 bordrad-30">
    <h1 class="card-header special-color white-text text-center py-4 bordrad-oglav-reg">
      <i class="fas fa-h-square fa-2x col-logo-hakiro"></i>
      <p class="font-ubuntu">Hakiro Control System</p>
    </h1>
    <div class="card-body px-lg-5">
      <form id="form-admin" method="post" action="section-admin.php" style="color: #757575;">
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
        </p>
        <?php
        }
        ?>
        <div class="form-group row">
          <label for="access_code" class="col-sm-2 col-form-label">Введите код доступа:</label>
          <div class="col-sm-10">
            <div class="md-form mt-sm-5 mt-xl-0">
              <i class="fas fa-shield-alt prefix blue-grey-text txtshad-phone"></i>
              <input type="password" name="access_code" class="form-control validate" id="access_code" placeholder="Код доступа...">
            </div>
          </div>
        </div>
        <button class="btn btn-mdb-color btn-rounded btn-block z-depth-0 my-4 waves-effect" type="submit" name="go_admins">Войти в систему&nbsp;<i class="fas fa-paper-plane"></i></button>
      </form>
    </div>
  </div>
  <?php
    }
  }
  else{ // если пользователь не авторизован то выводим сообщение          
  ?>
  <div class="col mt-5 mb-5 text-center wow fadeIn" style="height: 500px;">
    <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
    <h1>Ошибка! Доступ ограничен...</h1>
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
<script type="text/javascript">
  $('.file-upload').file_upload();
</script>
</body>

</html>