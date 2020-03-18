<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/functions.php'); // подключение функции для работы скриптов
require_once('php/loadbook.php'); // загрузка информации о книге
require_once('php/comment-user.php'); // скрипт обработки отзывов
require_once('php/moderat-book.php'); // скрипт для администрирования книг
require_once('php/header.php'); // верстка header
?>
<main>
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
      $info_book = mysqli_fetch_assoc($result); // присваиваем информацию в переменную
      $resear_categ = mysqli_query($con_li, "SELECT * FROM `categor-book` WHERE `id` =".$info_book['categ']); // поиск категории книги
      $one_cat_book = mysqli_fetch_assoc($resear_categ); // присваиваем информацию в переменную
    ?>
      <!-- Модальное окно для отправки отзыва -->
      <div class="modal" id="exampleModalCentered" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalCenteredLabel">Ваш отзыв</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="/book.php?id=<?php echo $num_str;?>" method="post">
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
              <button type="submit" name="go_comment_book" class="btn btn-outline-dark">Отправить</button>
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Закрыть</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Вывод категории книг из базы -->
      <div class="col m-3 fonsiz-18">
        <a href="/spisok-categorbook.php?id=<?php echo $one_cat_book['id'];?>" class="txtshad-sea"><?php echo $one_cat_book['categories']; ?></a> <i class="fas fa-angle-double-right"></i> <b><?php echo $info_book['name_book']; ?></b>
      </div>
    </div>
    <!-- Вывод информации о книге -->
    <div class="row">
      <div class="col text-center">
        <div class="card align-items-center">
          <img src="img/book/<?php echo $info_book['photo_book']; ?>" width="240px" height="260px" class="img-fluid">
          <div class="card-body text-center">
            <h3>Цена: <?php echo $info_book['price_book']; ?><i class="fas fa-ruble-sign fa-fw" aria-hidden="true"></i>
            </h3>
            <button type="button" class="btn butt-buybook waves-effect"><i class="fas fa-shopping-cart fa-fw" aria-hidden="true"></i>&nbsp;Купить книгу</button>
            <a href="files/book/<?php echo $info_book['file_book']; ?>" target="_blank">
              <button type="button" class="btn btn-outline-default waves-effect"><i class="fas fa-book" aria-hidden="true"></i>&nbsp;Читать отрывок</button>
            </a>
            <?php
            if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
            ?>
            <hr class="unique-color">
            <h3 class="text-danger txtshad-dangers">Администрирование
            </h3>
            <form method="post" action="/book.php?id=<?php echo $info_book['id'];?>">
              <?php
              if($info_book['top_book'] == 1){ // проверка является ли книга популярной
              ?>
              <button type="submit" name="not_topbook" class="btn btn-outline-secondary waves-effect"><i class="far fa-star"></i>&nbsp;Убрать из популярных</button>
              <?php
              }
              else{
              ?> 
              <button type="submit" name="go_topbook" class="btn btn-outline-secondary waves-effect"><i class="far fa-star"></i>&nbsp;Сделать популярным</button>
              <?php
              }
              ?>
              <button type="submit" name="del_book" class="btn btn-outline-danger waves-effect"><i class="fas fa-trash"></i>&nbsp;Удалить</button>
            </form>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
      <div class="col-6">
        <h1><?php echo $info_book['name_book'];
          if($info_book['top_book'] == 1){ // проверка является ли книга популярной ?> 
          <span class="badge badge-pill badge-primary danger-color" title="Популярный товар"><i class="far fa-star"></i></span>
          <?php
          }
          ?>
        </h1>
        <p><?php echo $info_book['descript_book']; ?> </p>
      </div>
      <div class="col-2 mt-5 pt-5">
        <div class="block-kratko-book">
          <h5><u>Автор:</u> <?php echo $info_book['author']; ?></h5>
          <h5><u>Издательство:</u> <?php echo $info_book['edition']; ?></h5>
          <h5><u>Год выпуска:</u> <?php echo $info_book['year_release']; ?></h5>
          <h5><u>Кол-во страниц:</u> <?php echo $info_book['pages']; ?></h5>
        </div>
      </div>
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
    $numeric_book = (int) $info_book['id']; // приравниваем к переменной id страницы
    $lock_comment = mysqli_query($con_li, "SELECT user.numb_phone , user.user_name , comments.log_comment , comments.date_comment , comments.otmetka , comments.text_comment FROM comments INNER JOIN user ON comments.log_comment = user.numb_phone WHERE comments.num_razdel = '1' AND comments.id_content = $numeric_book ORDER BY (comments.date_comment) DESC"); // sql запрос на вывод отзывов пользователей
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
          <h6><?php echo date("d.m.Y в H:i", strtotime($info_comment['date_comment'])); // вывод даты в формате дата/месяц/год в часов:минут?></h6> 
        </div>
        <div class="card-body">
          <h6>Оценка пользователя:
          <?php
          switch ($info_comment['otmetka']) { // определяем оценку пользователя
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
          <form action="/book.php?id=<?php echo $info_book['id'];?>" method="post">
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
      else{ // если отзывы не найдены выводим сообщение об этом
    ?>
    <div class="row">
      <div class="col text-center m-5 font-philos">
        <h3>Никто еще не оставил отзыв. Будь первым, оставь свой отзыв :)</h3>
      </div>
    </div>
    <?php
      }
    ?>
    <div class="row">
      <div class="col p-3 text-dark">
        <h6><i class="fas fa-eye"></i>&nbsp;<?php echo $info_book['views']; ?></h6>
        <?php
        if (isset($_SESSION['user_auto']) && $_SESSION['user_auto'] == 1) { // проверка авторизован ли пользователь
          mysqli_query($con_li, "UPDATE `books` SET `views` = `views` + 1 WHERE `id` = ".(int) $info_book['id']); // прибавляем просмотры к странице книги
        }
        if($info_book['views'] == 100){ // если число просмотров равно 100
          mysqli_query($con_li, "UPDATE `books` SET `top_book` = '1' WHERE `top_book` != '1' AND `id` = ".(int) $info_book['id']); // выводим в топ категорию
        }
        ?>
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
</body>

</html>