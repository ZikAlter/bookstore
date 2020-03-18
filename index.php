<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container-fluid fon-doodles-pattern">
  <div class="container">
    <div class="row justify-content-center pad-bot50 pad-top50 text-center">
      <div class="col-md-3 ml-2 mr-2 mt-3 col-sm-2 blog-profit-content wow fadeInLeft" data-wow-duration="2s">
        <i class="fas fa-book-open fa-4x col-redbook"></i>
        <ul class="smooth-scroll list-unstyled">
        <h2><a href="#block1" class="text-white">Книги</a></h2>
        </ul>
        <p>
          У нас огромное разнообразие художественной и научной литературы, самых популярных авторов. Вы сможете приобрести товар по самой выгодной и доступной цене, не выходя из дома.
        </p>
      </div>
      <div class="col-md-3 ml-2 mr-2 mt-3 col-sm-2 blog-profit-content wow fadeInLeft" data-wow-duration="2s" data-wow-delay="1s">
         <i class="fas fa-school fa-4x col-maps"></i>
          <ul class="smooth-scroll list-unstyled">
          <h2><a href="#block2" class="text-white">Семинары</a></h2>
          </ul>
          <p>
            Мы постоянно проводим семинары на различные тематики. Благодаря ним вы сможете получить новый опыт и знания. А в этом вам помогут ведущие специалисты.
          </p>
      </div>
      <div class="col-md-3 ml-2 mr-2 mt-3 col-sm-2 blog-profit-content wow fadeInLeft" data-wow-duration="2s" data-wow-delay="2s">
        <i class="fas fa-globe fa-4x col-world"></i>
        <ul class="smooth-scroll list-unstyled">
        <h2><a href="#block3" class="text-white">Курсы</a></h2>
        </ul>
        <p>
          Для всех у нас предусмотренны интересные и интерактивные курсы. Вы сможете ознакомиться с программой курса, приобрести посещение курса.
        </p>
      </div>
    </div>
    <h1 class="oglav-topbook wow fadeInRight" data-wow-duration="2s" id="block1"><i class="fas fa-angle-double-right" aria-hidden="true"></i>&nbsp;Популярные книги</h1>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
       <?php
        $top_book = mysqli_query($con_li, "SELECT `id` , `name_book` , `author` , `price_book` , `photo_book` FROM `books` WHERE `top_book` = '1' ORDER BY RAND() LIMIT 4"); // sql запрос на популярные книги
        $whilebook = mysqli_num_rows($top_book); // подсчет числа книг
        if ($whilebook > 0){ // если книг более нуля
          while( $book = mysqli_fetch_assoc($top_book) ){ // формируем массив для вывода популярных книг
        ?>
        <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
          <div class="card align-items-center cell-topbook">
            <div class="view overlay">
              <img src="img/book/<?php echo $book['photo_book']; ?>" alt="" height="200px" width="160px" class="pad-top10">
              <a href="/book.php?id=<?php echo $book['id'];?>">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <div class="card-body text-center font-philos">
              <h5>
                <strong>
                  <a href="/book.php?id=<?php echo $book['id'];?>" class="dark-grey-text"><?php echo $book['name_book']; ?> <span class="badge badge-pill badge-primary danger-color" title="Популярный товар"><i class="far fa-star"></i></span></a>
                </strong>
              </h5>
              <h5 class="grey-text"><?php echo $book['author']; ?></h5>
              <h5 class="font-weight-bold color-green">
                <strong><?php echo $book['price_book']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong>
              </h5>
            </div>
            <div class="card-footer">
              <button type="button" class="btn butt-buybook"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить</button>
              <a href="/book.php?id=<?php echo $book['id'];?>">
                <button type="button" class="btn btn-outline-dark bord-rad5">Подробнее</button>
              </a>
            </div>
          </div>
        </div>
        <?php
          }
        }
        else{ // если ничего нет то выводим сообщение
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
    <div class="row">
      <div class="col text-center">
        <a href="spisok-book.php">
          <button type="button" class="btn button-moregoods text-white"><i class="fas fa-plus-square fa-fw" aria-hidden="true"></i>&nbsp;Показать больше</button>
        </a>
      </div>
    </div>
    <h1 class="oglav-topbook wow fadeInRight" data-wow-duration="2s" id="block2"><i class="fas fa-angle-double-right" aria-hidden="true"></i>&nbsp;Ближайшие семинары</h1>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
        <?php
        $nowyear_sem = date("Y"); // текущий год
        $nowmon_sem = date("m"); // текущий месяц
        $nowday_sem = date("d"); // текущий день
        $top_seminar = mysqli_query($con_li, "SELECT `id` , `title_seminar` , `date_seminar` , `time_start_seminar` , `time_finish_seminar` , `location_seminar` , `price_seminar` , `icon_seminar` FROM `seminar` WHERE YEAR(`date_seminar`) = '$nowyear_sem' AND MONTH(`date_seminar`) = $nowmon_sem AND DAY(`date_seminar`) > '$nowday_sem' ORDER BY RAND() LIMIT 4"); // sql запрос на выбор семинаров
        $whileseminar = mysqli_num_rows($top_seminar); // подсчет числа семинаров
        if ($whileseminar){ // если семинаров более нуля
          while( $seminars = mysqli_fetch_assoc($top_seminar) ){ // формируем массив с ближайшими семинарами
        ?>
        <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
          <div class="card align-items-center cell-topbook">
            <div class="view overlay" class="pad-top10">
              <?php
              switch ($seminars['icon_seminar']) { // поиск нужной иконки
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
              <h5 class="font-weight-bold color-green">
                <strong>Стоимость: <?php echo $seminars['price_seminar']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong>
              </h5>
            </div>
            <div class="card-footer">
              <button type="button" class="btn butt-buybook"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить</button>
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
    <div class="row">
      <div class="col text-center mb-4">
        <a href="spisok-seminar.php">
          <button type="button" class="btn button-moregoods text-white"><i class="fas fa-plus-square fa-fw" aria-hidden="true"></i>&nbsp;Показать больше</button>
        </a>
      </div>
    </div>
    <h1 class="oglav-topbook wow fadeInRight" data-wow-duration="2s" id="block3"><i class="fas fa-angle-double-right" aria-hidden="true"></i>&nbsp;Ближайшие курсы</h1>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
      <?php
        $nowyear_cour = date("Y"); // текущий год
        $nowmon_cour = date("m"); // текущий месяц
        $nowday_cour = date("d"); // текущий день
        $top_course = mysqli_query($con_li, "SELECT `id` , `title_course` , `numb_hours_course` , `date_start_course` , `date_finish_course` , `form_study_course` , `lektor_fio_course` , `price_course` , `icon_course` FROM `courses` WHERE YEAR(`date_start_course`) = '$nowyear_cour' AND MONTH(`date_start_course`) = '$nowmon_cour' AND DAY(`date_start_course`) > '$nowday_cour' ORDER BY RAND() LIMIT 4"); // sql запрос на выбор курсов
        $whilecourse = mysqli_num_rows($top_course); // подсчет числа курсов
        if ($whilecourse){ // если курсов более нуля
          while( $course = mysqli_fetch_assoc($top_course) ){ // формируем массив для вывода ближайших курсов
      ?>
        <div class="col-lg-3 col-md-6 mb-4 d-flex align-items-stretch">
          <div class="card align-items-center cell-topbook">
            <div class="view overlay" class="pad-top10">
              <?php
              switch ($course['icon_course']) { // поиск нужной иконки
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
              <h5 class="font-weight-bold color-green">
                <strong>Стоимость: <?php echo $course['price_course']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong>
              </h5>
            </div>
            <div class="card-footer">
              <button type="button" class="btn butt-buybook"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить</button>
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
    <div class="row">
      <div class="col text-center mb-4">
        <a href="spisok-course.php">
          <button type="button" class="btn button-moregoods text-white"><i class="fas fa-plus-square fa-fw" aria-hidden="true"></i>&nbsp;Показать больше</button>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col text-center wow flash" data-wow-duration="3s" data-wow-iteration="2">
        <h1 class="coord-google-txt">Мы находимся&nbsp;<i class="fas fa-map-marker-alt col-seaandshadow"></i></h1>
      </div>
    </div>
  </div>
</div>
</main>
  <iframe src="<?php echo $cord['google_maps']; ?>" width="100%" height="400px" frameborder="0" style="border: 0; " allowfullscreen></iframe>
<?php
require_once('php/footer.php'); // верстка footer
?>
</body>

</html>
