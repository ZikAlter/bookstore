<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/loadcourse.php'); // загрузка информации о книге
require_once('php/comment-user.php'); // скрипт обработки отзывов
require_once('php/moderat-course.php'); // скрипт для администрирования книг
require_once('php/header.php'); // верстка header
?>
<main>
  <!-- Модальное окно -->
  <div class="modal" id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="exampleModalCenteredLabel">Ваш отзыв</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="/course.php?id=<?php echo $num_str;?>" method="post">
        <div class="modal-body">
          <h5>Выберите оценку (положительную или отрицательную):</h5>
          <div class="btn-group btn-group-toggle p-3" data-toggle="buttons">
            <label class="btn btn-primary bordrad-10" title="Нравится!">
              <input type="radio" name="otmetka" id="option1" autocomplete="off" value="like"> <i class="far fa-thumbs-up fa-2x col-like"></i>
            </label>
            <label class="btn btn-primary ml-4 bordrad-10" title="Не нравится!">
              <input type="radio" name="otmetka" id="option2" autocomplete="off" value="dislike"> <i class="far fa-thumbs-down fa-2x col-dislike"></i>
            </label>
          </div>
          <textarea class="form-control" placeholder="Напишите что нибудь..." name="text_otziv" rows="4" autofocus>
          </textarea>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="submit" name="go_comment_course" class="btn btn-outline-dark">Отправить</button>
          <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Закрыть</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
    <?php
    if(mysqli_num_rows($result) <= 0 ){ // если страница не найдена выводим сообщение что контент не найден
    ?>
      <div class="col m-5 text-center wow fadeIn" style="height: 300px;">
        <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
        <h1>Ошибка! Контент не найден...</h1>
      </div>
    <?php
    }
    else{
      $info_course = mysqli_fetch_assoc($result); // присваиваем информацию в переменную
    ?>
      <div class="col m-3 fonsiz-18">
        <a href="spisok-course.php" class="txtshad-sea">Курсы</a> <i class="fas fa-angle-double-right"></i> <b><?php echo $info_course['title_course']; ?></b>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-xl-5 col-sm-10 card align-items-center ml-2 pb-4 mb-2">
        <h1>
          <?php
            switch ($info_course['icon_course']) {
            case "earth":
                echo '<i class="fas fa-globe-europe fa-5x green-text" style="text-shadow: 0 0 10px #4CAF50;"></i>';
                break;
            case "atom":
                echo '<i class="fas fa-atom fa-5x green-text" style="text-shadow: 0 0 10px #4CAF50;"></i>';
                break;
            case "book":
                echo '<i class="fas fa-book-open fa-5x green-text" style="text-shadow: 0 0 10px #4CAF50;"></i>';
                break;
            case "comp":
                echo '<i class="fas fa-desktop fa-5x green-text" style="text-shadow: 0 0 10px #4CAF50;"></i>';
                break;
            }
          ?>
        </h1>
        <?php
        $dbyear = date("Y", strtotime($info_course['date_start_course'])); // год из базы
        $dbmon = date("m", strtotime($info_course['date_start_course'])); // месяц из базы
        $dbday = date("d", strtotime($info_course['date_start_course'])); // день из базы
        $nowyear = date("Y"); // текущий год
        $nowmon = date("m"); // текущий месяц
        $nowday = date("d"); // текущий день
        if($dbyear >= $nowyear && (($dbmon == $nowmon && $dbday > $nowday) || ($dbmon > $nowmon))){ // если год из базы больше или равен нынешнему и месяц равен нынешнему и день больше нынешнеого или месяц больше нынешнего то выводим стоимость
        ?>
        <h3><strong class="color-green">Стоимость курса: <?php echo $info_course['price_course']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></strong></h3>
        <button type="button" class="btn butt-buybook waves-effect"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить курс</button>
        <?php
        }
        else{ // иначе приемок заявок завершен
        ?>
        <h3 class="text-danger txtshad-dangers"><strong>Прием заявок на курс завершен!</strong></h3>
        <?php
        }
        ?>
        <a href="files/course/<?php echo $info_course['file_course'];?>" download="Информационное письмо">
          <button type="button" class="btn btn-outline-primary waves-effect"><i class="fas fa-file-word fa-fw" aria-hidden="true"></i>&nbsp;Скачать информационное письмо</button>
        </a>
        <?php
        if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
        ?>
        <hr class="unique-color">
        <h3 class="text-danger txtshad-dangers">Администрирование
        </h3>
        <form method="post" action="/course.php?id=<?php echo $info_course['id'];?>">
          <button type="submit" name="del_course" class="btn btn-outline-danger waves-effect"><i class="fas fa-trash"></i>&nbsp;Удалить</button>
        </form>
        <?php
        }
        ?>
      </div>
      <div class="col-xl-6 col-sm-10 card align-items-center ml-xl-5 mb-2">
        <h2 class="h2 text-center text-primary pt-2 txtshad-titlecour"><?php echo $info_course['title_course']; ?></h2>
        <div class="card-body text-left font-play">
          <h5 class="grey-text"><i class="fas fa-user-graduate deep-orange-text txtshad-orang-iconcours"></i>&nbsp;Ведущий лектор: <strong class="text-primary"><?php echo $info_course['lektor_fio_course']; ?></strong></h5>
          <hr class="blue darken-1">
          <h5 class="grey-text"><i class="fas fa-school deep-orange-text txtshad-orang-iconcours"></i>&nbsp;Форма обучения: <strong class="text-primary"><?php echo $info_course['form_study_course']; ?></strong></h5>
          <hr class="blue darken-1">
          <h5 class="grey-text"><i class="fas fa-users deep-orange-text txtshad-orang-iconcours"></i>&nbsp;Категория слушателей: <strong class="text-primary"><?php echo $info_course['people_course']; ?></strong></h5>
          <hr class="blue darken-1">
          <h5 class="grey-text"><i class="fas fa-map-signs deep-orange-text txtshad-orang-iconcours"></i>&nbsp;Место проведения занятий: <strong class="text-primary"><?php echo $info_course['location_course']; ?></strong></h5>
          <hr class="blue darken-1">
          <h5 class="grey-text"><i class="far fa-calendar-alt deep-orange-text txtshad-orang-iconcours" ></i>&nbsp;Дата проведения: <strong class="text-primary"><?php echo date("d/m/Y", strtotime($info_course['date_start_course'])); ?> - <?php echo date("d/m/Y", strtotime($info_course['date_finish_course'])); ?></strong></h5>
          <hr class="blue darken-1">
          <h5 class="grey-text">Количество часов: <strong class="text-primary"><?php echo $info_course['numb_hours_course']; ?></strong>&nbsp;<i class="far fa-clock deep-orange-text txtshad-orang-iconcours"></i></h5>
        </div>
      </div>
    </div>
    <div class="jumbotron text-center special-color lighten-2 white-text mx-2 mb-5 mt-3"> 
      <p class="card-text"><?php echo $info_course['description_course']; ?></p>
    </div>
    <div class="row m-2">
      <div class="col">
        <h1><i class="far fa-comments"></i>&nbsp;Отзывы Пользователей</h1>
        <?php
        if (isset($_SESSION['user_auto']) && $_SESSION['user_auto']  == 1) { // проверка авторизован ли пользователь
        ?>
        <!-- Кнопка по открытию окна -->
        <button type="button" class="btn btn-primary ml-5" data-toggle="modal" data-target="#exampleModalCentered"><i class="fas fa-pen-nib"></i>&nbsp;Написать отзыв</button>
        <?php
        }
        else{ // если пользователь не авторизован выводим сообщение об этом
        ?>
        <p class="ml-2 red-text"><strong>Отзывы могут оставлять только авторизованные пользователи!!!</strong></p>
        <strong class="mb-2 ml-2"><a href="autorization.php">Перейти к авторизации</a></strong>
        <?php
        }
        ?>
      </div>
    </div>
    <?php
    $numeric_book = (int) $info_course['id']; // приравниваем к переменной id страницы
    $lock_comment = mysqli_query($con_li, "SELECT user.numb_phone , user.user_name , comments.log_comment , comments.date_comment , comments.otmetka , comments.text_comment FROM comments INNER JOIN user ON comments.log_comment = user.numb_phone WHERE comments.num_razdel = '3' AND comments.id_content = $numeric_book ORDER BY (comments.date_comment) DESC"); // sql запрос на вывод отзывов пользователей
    $whilecomment = mysqli_num_rows($lock_comment); // подсчет отзывов
    if ($whilecomment > 0){ // если отзывов больше 0
      while($info_comment = mysqli_fetch_assoc($lock_comment)){ // выводим отзывы через while
    ?>
    <div class="row mb-5 ml-2 wow fadeIn">
      <div class="col">
        <img src="img/avatar/ava.jpg" width="150px" height="150px" class="bordrad-90">
      </div>
      <div class="col-10 card font-philos">
        <div class="card-header bg-primary text-white bordrad-20">
          <h3><?php echo $info_comment['user_name']; ?></h3>
          <h6><?php echo date("d.m.Y в H:i", strtotime($info_comment['date_comment'])); ?></h6> 
        </div>
        <div class="card-body">
          <h6>Оценка пользователя:
          <?php
          switch ($info_comment['otmetka']) {
          case "like":
              echo '<i class="far fa-thumbs-up fa-2x col-like" title="Нравится!"></i>';
              break;
          case "dislike":
              echo '<i class="far fa-thumbs-down fa-2x col-dislike" title="Не нравится!"></i>';
              break;
          case "neutral":
              echo '<i class="fas fa-fist-raised fa-2x textshad-neutral" title="Нейтрально"></i>';
              break;
          }
          ?> </h6>
          <p><?php echo $info_comment['text_comment']; ?></p>
          <?php
          if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
          ?>
          <form action="/course.php?id=<?php echo $info_course['id'];?>" method="post">
            <input type="text" name="numeric_dell_comm" value="<?=$info_comment['log_comment']; ?>" style="display: none;" class="disabled">
            <button type="submit" name="dell_comment" class="btn btn-danger btn-rounded">Удалить отзыв</button>
          </form>
          <?php
          }
          ?>
        </div>
      </div>        
    </div>
    <?php
        }
      }
      else{ // иначе выводим информацию о том что отзывов нет
    ?>
    <div class="row">
      <div class="col text-center m-5 font-philos">
        <h3>Никто еще не оставил отзыв. Будь первым, оставь свой отзыв :)</h3>
      </div>
    </div>
    <?php
      }
    }  
    ?>
  </div>
</main>
<?php
require_once('php/footer.php'); // верстка footer
?>
</body>

</html>