<?php
session_start(); // объявление сессии
require_once('php/li-connect.php'); // соединение с БД
require_once('php/loadspisok-categorbook.php'); 
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container-fluid fon-doodles-pattern">
  <div class="container">
    <div class="row pb-2 pt-2">
    <?php
    if(mysqli_num_rows($result) <= 0 ){ // если страница не найдена выводим сообщение что контент не найден
    ?>
      <div class="col p-5 text-center wow fadeIn" style="height: 300px;">
        <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
        <h1>Ошибка! Контент не найден...</h1>
      </div>
    <?php
    }
    else{ // если страница найдена
      $info_categ_book = mysqli_fetch_assoc($result); // присваиваем информацию в переменную
    ?>
      <div class="col text-center">
        <h1 class="green-text font-play textshad-greenzone"><i class="fas fa-angle-double-left"></i><?php echo $info_categ_book['categories']; ?><i class="fas fa-angle-double-right" aria-hidden="true"></i></h1>
      </div>
    </div>
    <section class="text-center mb-2">
      <div class="row wow fadeIn d-flex justify-content-center">
       <?php
        $load_podcategor_book = mysqli_query($con_li, "SELECT `id` , `name_book` , `author` , `price_book` , `photo_book` , `top_book` FROM `books` WHERE `categ` = ".$info_categ_book['id']." ORDER BY(`id`) DESC"); // sql запрос на вывод книг из базы
        $whilebook = mysqli_num_rows($load_podcategor_book); // подсчет числа книг
        if ($whilebook > 0){ // если число больше нуля
          while( $book = mysqli_fetch_assoc($load_podcategor_book) ){ // формируем массив для вывода книг
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
                  <a href="/book.php?id=<?php echo $book['id'];?>" class="dark-grey-text"><?php echo $book['name_book']; ?>
                    <?php 
                    if($book['top_book'] == 1){ 
                    ?> 
                   <span class="badge badge-pill badge-primary danger-color" title="Популярный товар"><i class="far fa-star"></i></span>
                   <?php
                    }
                   ?>
                   </a>
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
    <?php
    }  
    ?>
  </div>
</div>
</main>
<?php
require_once('php/footer.php'); // верстка footer
?>
</body>

</html>