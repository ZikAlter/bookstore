<?php
session_start();
require_once('php/li-connect.php'); // соединение с БД
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container-fluid fon-doodles-pattern">
  <div class="container">
    <div class="row pb-2 pt-2">
        <div class="col text-center">
            <h1 class="green-text font-play textshad-greenzone"><i class="fas fa-angle-double-left"></i>Список семинаров<i class="fas fa-angle-double-right" aria-hidden="true"></i></h1>
            <p>
              <strong>Мы постоянно проводим семинары на различные тематики. Благодаря ним вы сможете получить новый опыт и знания. А в этом вам помогут ведущие специалисты.</strong>
            </p>
        </div>
    </div>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
        <?php
        $load_seminar = mysqli_query($con_li, "SELECT `id` , `title_seminar` , `date_seminar` , `time_start_seminar` , `time_finish_seminar` , `location_seminar` , `price_seminar` , `icon_seminar` FROM `seminar` ORDER BY (`date_seminar`) DESC"); // sql запрос на вывод семинаров из базы
        $whileseminar = mysqli_num_rows($load_seminar); // подсчет числа семинаров
        if ($whileseminar){ // если число больше нуля
          while( $seminars = mysqli_fetch_assoc($load_seminar) ){ // формируем массив для вывода семинаров
        ?>
        <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
          <div class="card align-items-center cell-topbook">
            <div class="view overlay" class="pad-top10">
              <?php
              switch ($seminars['icon_seminar']) {
              case "earth":
                  echo '<i class="fas fa-globe-europe fa-10x col-blackblue"></i>';
                  break;
              case "atom":
                  echo '<i class="fas fa-atom fa-10x col-blackblue"></i>';
                  break;
              case "book":
                  echo '<i class="fas fa-book-open fa-10x col-blackblue"></i>';
                  break;
              case "comp":
                  echo '<i class="fas fa-desktop fa-10x col-blackblue"></i>';
                  break;
              }
              ?>
              <a href="/seminar.php?id=<?php echo $seminars['id'];?>"">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body text-center font-jura">
              <h5>
                <strong>
                  <a href="/seminar.php?id=<?php echo $seminars['id'];?>"" class="dark-grey-text"><?php echo $seminars['title_seminar']; ?></a>
                </strong>
              </h5>
              <h5 class="grey-text"><i class="far fa-calendar-alt col-black" ></i>&nbsp; <?php echo date("d/m/Y", strtotime($seminars['date_seminar'])); ?></h5>
              <h5 class="grey-text"><i class="far fa-clock col-black"></i>&nbsp; с <?php echo date("H:i", strtotime($seminars['time_start_seminar'])); ?> по <?php echo date("H:i", strtotime($seminars['time_finish_seminar'])); ?></h5>
              <h5 class="grey-text">Место проведения: <?php echo $seminars['location_seminar']; ?></h5>
              <?php
              $dbyear = date("Y", strtotime($seminars['date_seminar'])); // год из базы
              $dbmon = date("m", strtotime($seminars['date_seminar'])); // месяц из базы
              $dbday = date("d", strtotime($seminars['date_seminar'])); // день из базы
              $nowyear = date("Y"); // текущий год
              $nowmon = date("m"); // текущий месяц
              $nowday = date("d"); // текущий день
              if($dbyear >= $nowyear && (($dbmon == $nowmon && $dbday > $nowday) || ($dbmon > $nowmon))){ // если год из базы больше или равен нынешнему и месяц равен нынешнему и день больше нынешнеого или месяц больше нынешнего то выводим стоимость
              ?>
              <h5 class="font-weight-bold color-green">
                <strong>Стоимость: <?php echo $seminars['price_seminar']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong>
              </h5>
              <?php
              }
              else{ // иначе приемок заявок завершен
              ?>
              <h5 class="text-danger txtshad-dangers"><strong>Прием заявок на семинар завершен!</strong></h5>
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
              <a href="/seminar.php?id=<?php echo $seminars['id'];?>">
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
