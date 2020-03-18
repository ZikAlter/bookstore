<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container-fluid fon-doodles-pattern">
  <div class="container">
    <div class="row pb-2 pt-2">
        <div class="col text-center">
            <h1 class="green-text font-play textshad-greenzone"><i class="fas fa-angle-double-left"></i>Список курсов<i class="fas fa-angle-double-right" aria-hidden="true"></i></h1>
            <p>
              <strong>Для всех у нас предусмотренны интересные и интерактивные курсы. Вы сможете ознакомиться с программой курса, приобрести посещение курса.</strong>
            </p>
        </div>
    </div>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
      <?php
        $load_course = mysqli_query($con_li, "SELECT `id` , `title_course` , `numb_hours_course` , `date_start_course` , `date_finish_course` , `form_study_course` , `lektor_fio_course` , `price_course` , `icon_course` FROM `courses` ORDER BY (`date_start_course`) DESC"); // sql запрос на вывод курсов из базы
        $whilecourse = mysqli_num_rows($load_course ); // подсчет числа курсов
        if ($whilecourse){ // если число больше нуля
          while( $course = mysqli_fetch_assoc($load_course) ){ // формируем массив для вывода курсов
      ?>
        <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
          <div class="card align-items-center cell-topbook">
            <div class="view overlay" class="pad-top10">
              <?php
              switch ($course['icon_course']) {
              case "earth":
                  echo '<i class="fas fa-globe-europe fa-10x green-text"></i>';
                  break;
              case "atom":
                  echo '<i class="fas fa-atom fa-10x green-text"></i>';
                  break;
              case "book":
                  echo '<i class="fas fa-book-open fa-10x green-text"></i>';
                  break;
              case "comp":
                  echo '<i class="fas fa-desktop fa-10x green-text"></i>';
                  break;
              }
              ?>
              <a href="/course.php?id=<?php echo $course['id'];?>">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body text-center font-play">
              <h5>
                <strong>
                  <a href="/course.php?id=<?php echo $course['id'];?>" class="dark-grey-text"><?php echo $course['title_course']; ?></a>
                </strong>
              </h5>
              <hr class="mdb-color lighten-2">
              <h5 class="grey-text"><i class="fas fa-user-graduate deep-orange-text"></i>&nbsp;Ведущий лектор: <strong class="text-primary"><?php echo $course['lektor_fio_course']; ?></strong></h5>
              <h5 class="grey-text"><i class="fas fa-school deep-orange-text"></i>&nbsp;Форма обучения: <strong class="text-primary"><?php echo $course['form_study_course']; ?></strong></h5>
              <h5 class="grey-text"><i class="far fa-calendar-alt deep-orange-text" ></i>&nbsp;Дата проведения: <strong class="text-primary"><?php echo date("d/m/Y", strtotime($course['date_start_course'])); ?> - <?php echo date("d/m/Y", strtotime($course['date_finish_course'])); ?></strong></h5>
              <h5 class="grey-text">Количество часов: <strong class="text-primary"><?php echo $course['numb_hours_course']; ?></strong>&nbsp;<i class="far fa-clock deep-orange-text"></i></h5>
              <hr class="mdb-color lighten-2">
              <?php
              $dbyear = date("Y", strtotime($course['date_start_course'])); // год из базы
              $dbmon = date("m", strtotime($course['date_start_course'])); // месяц из базы
              $dbday = date("d", strtotime($course['date_start_course'])); // день из базы
              $nowyear = date("Y"); // текущий год
              $nowmon = date("m"); // текущий месяц
              $nowday = date("d"); // текущий день
              if($dbyear >= $nowyear && (($dbmon == $nowmon && $dbday > $nowday) || ($dbmon > $nowmon))){ // если год из базы больше или равен нынешнему и месяц равен нынешнему и день больше нынешнеого или месяц больше нынешнего то выводим стоимость
              ?>
              <h5 class="font-weight-bold color-green">
                <strong>Стоимость: <?php echo $course['price_course']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong>
              </h5>
              <?php
              }
              else{ // иначе приемок заявок завершен
              ?>
              <h5 class="text-danger txtshad-dangers"><strong>Прием заявок на курс завершен!</strong></h5>
              <?php
              }
              ?>
            </div>
            <div class="card-footer">
              <?php
              if($dbyear >= $nowyear && (($dbmon == $nowmon && $dbday > $nowday) || ($dbmon > $nowmon))){ // если год из базы больше или равен нынешнему и месяц равен нынешнему и день больше нынешнеого или месяц больше нынешнего то выводим стоимость
              ?>
              <button type="button" class="btn butt-buybook"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить</button>
              <?php
              }
              ?>
              <a href="/course.php?id=<?php echo $course['id'];?>">
                <button type="button" class="btn btn-outline-dark bord-rad5">Подробнее</button>
              </a>
            </div>
          </div>
        </div>
        <?php
          }
        }
        else{ // если ничего не найдено то выводим сообщение
        ?>
        <div class="col">
          <div class="alert alert-info alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5><strong>Ничего не найдено!</strong></h5>
          </div>
        </div>
        <?php
        } 
        ?>
      </div>
    </section>
  </div>
</div>
</main>
<?php
require_once('php/footer.php'); // верстка footer
?>
</body>
</html>
