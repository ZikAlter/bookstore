<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/loadseminar.php'); // загрузка информации о книге
require_once('php/comment-user.php'); // скрипт обработки отзывов
require_once('php/moderat-seminar.php'); // скрипт для администрирования книг
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
        <form action="/seminar.php?id=<?php echo $num_str;?>" method="post">
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
          <button type="submit" name="go_comment_seminar" class="btn btn-outline-dark">Отправить</button>
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
    else{ // если страница найдена
      $info_seminar = mysqli_fetch_assoc($result); // присваиваем информацию в переменную
    ?>
      <div class="col m-3 fonsiz-18">
        <a href="spisok-seminar.php" class="txtshad-sea">Семинары</a> <i class="fas fa-angle-double-right"></i> <b><?php echo $info_seminar['title_seminar']; ?></b>
      </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <h1>
            <?php
              switch ($info_seminar['icon_seminar']) { // поиск иконки
              case "earth":
                  echo '<i class="fas fa-globe-europe fa-5x col-blackblue"></i>';
                  break;
              case "atom":
                  echo '<i class="fas fa-atom fa-5x col-blackblue"></i>';
                  break;
              case "book":
                  echo '<i class="fas fa-book-open fa-5x col-blackblue"></i>';
                  break;
              case "comp":
                  echo '<i class="fas fa-desktop fa-5x col-blackblue"></i>';
                  break;
              }
              ?>
            </h1>
            <hr/>
            <h2><strong><?php echo $info_seminar['title_seminar']; ?></strong></h2>
            <hr/>
            <p>
              <?php echo $info_seminar['description_seminar']; ?>
            </p>
            <h3><i class="fas fa-file-word fa-3x text-dark"></i></h3>
            <a href="files/seminar/<?php echo $info_seminar['file_seminar'];?>" download="Информационное письмо"><strong>Скачать информационное письмо</strong></a>
            <?php
            if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
            ?>
            <hr class="unique-color">
            <h3 class="text-danger txtshad-dangers">Администрирование
            </h3>
            <form method="post" action="/seminar.php?id=<?php echo $info_seminar['id'];?>">
              <button type="submit" name="del_seminar" class="btn btn-outline-danger waves-effect"><i class="fas fa-trash"></i>&nbsp;Удалить</button>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="jumbotron text-center special-color lighten-2 white-text mx-2 mb-5 mt-3">
      <div class="row d-flex justify-content-center">
        <div class="col-xl-3 col-sm-6 pb-2">
          <h3 class="h3 text-default">Руководитель семинара:</h3>
          <h4 class="h4"><?php echo $info_seminar['leader_fio_seminar']; ?></h4>  
          <p class="card-text">Должность: <?php echo $info_seminar['leader_position_seminar']; ?></p>
          <h5 class="h5"><i class="fas fa-phone-square mr-2 text-primary" title="Телефон"></i><?php echo $info_seminar['leader_phone_seminar']; ?></h5>
          <h5 class="h5"><i class="fas fa-envelope-square mr-2 text-danger" title="Электронная почта"></i><?php echo $info_seminar['leader_mail_seminar']; ?></h5>
        </div>
        <div class="col-xl-3 col-sm-6 pb-2">
          <h3 class="h3 text-default">Место проведения:</h3>
          <p class="card-text"><?php echo $info_seminar['location_seminar']; ?></p>
          <hr class="my-4 rgba-white-light">
          <h3 class="h3 text-default">Цель проведения:</h3>
          <p class="card-text"><?php echo $info_seminar['target_seminar']; ?></p>
          <hr class="my-4 rgba-white-light">
          <h3 class="h3 text-default">Участники:</h3>
          <p class="card-text"><?php echo $info_seminar['people_seminar']; ?></p>
        </div>
        <div class="col-xl-3 col-sm-6 pb-2">
          <h3 class="h3 text-default">Дата проведения:</h3>
          <p class="card-text"><strong><?php echo date("d.m.Y", strtotime($info_seminar['date_seminar'])); ?><i class="fas fa-calendar-alt ml-2 text-secondary" title="Дата семинара"></i></strong></p>
          <p class="card-text"><strong>Начало занятий в <?php echo date("H:i", strtotime($info_seminar['time_start_seminar'])); ?><i class="fas fa-clock ml-1 text-secondary" title="Время начало"></i></strong></p>
          <p class="card-text"><strong>Завершение занятий в <?php echo date("H:i", strtotime($info_seminar['time_finish_seminar'])); ?><i class="fas fa-clock ml-1 text-secondary" title="Время завершения"></i></strong></p>
        </div>
      </div>
    </div>
    <div class="jumbotron text-center success-color-dark lighten-2 white-text mx-2 mb-5">
      <?php
      $dbyear = date("Y", strtotime($info_seminar['date_seminar'])); // год из базы
      $dbmon = date("m", strtotime($info_seminar['date_seminar'])); // месяц из базы
      $dbday = date("d", strtotime($info_seminar['date_seminar'])); // день из базы
      $nowyear = date("Y"); // текущий год
      $nowmon = date("m"); // текущий месяц
      $nowday = date("d"); // текущий день
      if($dbyear >= $nowyear && (($dbmon == $nowmon && $dbday > $nowday) || ($dbmon > $nowmon))){ // если год из базы больше или равен нынешнему и месяц равен нынешнему и день больше нынешнеого или месяц больше нынешнего то выводим стоимость
      ?>
      <h2 class="card-title h2">Стоимость семинара: <?php echo $info_seminar['price_seminar']; ?> <i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i></h2>
      <div class="pt-2">
        <button type="button" class="btn btn-outline-white">Купить<i class="fas fa-shopping-cart fa-fw ml-1"></i></button>
      </div>
      <?php
      }
      else{ // если не равно то выводим сообщение
      ?>
      <h3 class="card-title h2 text-white txtshad-dangers"><strong>Прием заявок на семинар завершен!</strong></h3>
      <?php
      }
      ?>
    </div>
    <h1 class="oglav-topbook text-center">Программа семинара</h1>
    <table class="table table-hover text-center table-bordered">
      <thead class="unique-color-dark white-text">
        <tr>
          <th scope="col"><h5 class="h5">Время</h5></th>
          <th scope="col"><h5 class="h5">Мероприятие</h5></th>
        </tr>
      </thead>
      <tbody>
        <?php
        $lock_programm = mysqli_query($con_li, "SELECT prog_time_start , prog_time_finish , prog_meropr FROM programm_seminar WHERE num_seminar = ".(int) $info_seminar['id']); // sql запрос на выбор информации о программе семинара
        $whileprogramm = mysqli_num_rows($lock_programm); // подсчет результата запроса
        if ($whileprogramm > 0){ // если число больше нуля
          while($info_seminar_progr = mysqli_fetch_assoc($lock_programm)){ // формируем массив для вывода программы семинара
        ?>
        <tr>
          <th scope="row"><?php echo date("H:i", strtotime($info_seminar_progr['prog_time_start'])); ?> - <?php echo date("H:i", strtotime($info_seminar_progr['prog_time_finish'])); ?></th>
          <td><strong><?php echo $info_seminar_progr['prog_meropr']; ?></strong></td>
        </tr>
        <?php
          }
        }else{ // если ничего не найдено то выводим сообщение
        ?>
        <tr>
          <td colspan="2"><strong>Программа не найдена!</strong></td>
        </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <div class="row m-2">
      <div class="col">
        <h1><i class="far fa-comments"></i>&nbsp;Отзывы Пользователей</h1>
        <!-- Кнопка по открытию окна -->
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
    $numeric_book = (int) $info_seminar['id']; // приравниваем к переменной id страницы
    $lock_comment = mysqli_query($con_li, "SELECT user.numb_phone , user.user_name , comments.log_comment , comments.date_comment , comments.otmetka , comments.text_comment FROM comments INNER JOIN user ON comments.log_comment = user.numb_phone WHERE comments.num_razdel = '2' AND comments.id_content = $numeric_book ORDER BY (comments.date_comment) DESC"); // sql запрос на вывод отзывов пользователей
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
          switch ($info_comment['otmetka']) { // поиск иконки
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
          <form action="/seminar.php?id=<?php echo $info_seminar['id'];?>" method="post">
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
      else{ // если отзывы не найдены то выводим сообщение
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