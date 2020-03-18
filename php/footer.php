<footer class="container-fluid fons-footer">
  <div class="container">
    <div class="row">
      <div class="col mt-3 text-center">
        <h2 class="oglav-cell-footer">Меню</h2>
        <nav>
          <ul class="bottom-menu">
            <li><a href="index.php">Главная</a></li>
            <li><a href="spisok-book.php">Книги</a></li>
            <li><a href="spisok-seminar.php">Семинары</a></li>
            <li><a href="spisok-course.php">Курсы</a></li>
            <?php
            if (isset($_SESSION['user_auto']) && $_SESSION['user_auto']  == 1) { // проверка авторизован ли пользователь
            ?>
            <li><a href="profile.php">Личный кабинет</a></li>
            <?php
            } else { // если пользователь не авторизован выводим соответсвующий пункт в меню          
            ?>
            <li><a href="autorization.php">Личный кабинет</a></li>
            <?php
            }
            ?>
            <li><a href="#">Корзина</a></li>
            <li><a href="contact.php">О нас</a></li>
          </ul>
        </nav>     
      </div>
      <div class="col mr-5 mt-3 text-center">
        <h2 class="oglav-cell-footer">Социальные Сети</h2> 
        <nav>
          <ul class="social-menu">
            <li><a href="<?php echo $cord['social_vk']; ?>" target="_blank"><i class="fab fa-vk fa-fw fa-2x" aria-hidden="true"></i></a></li>
            <li class="pad-40"><a href="<?php echo $cord['social_facebook']; ?>" target="_blank"><i class="fab fa-facebook-f fa-fw fa-2x" aria-hidden="true"></i></a></li>
            <li><a href="<?php echo $cord['social_web']; ?>" target="_blank"><i class="fab fa-weebly fa-fw fa-2x" aria-hidden="true"></i></a></li>
          </ul>
        </nav>
      </div>
      <div class="col mr-5 mt-3 text-center text-white font-play">
        <h2 class="oglav-cell-footer">Наши Реквизиты</h2>
        <p class="font-14">
            <b class="col-mork">Юридический адрес:</b> <?php echo $cord['ur_address']; ?>
        </p>
        <p class="font-14">
            <b class="col-mork">Фактический адрес:</b> <?php echo $cord['fact_address']; ?>
        </p>
        <p class="font-14">
            <b class="col-mork">Тел./факс:</b> <?php echo $cord['phone_mag']; ?> <b class="col-mork">mailto:</b> <?php echo $cord['email_mag']; ?>
        </p>
        <hr style="border-color: white;">
        <p>
            Author: Adikaev Nikita  &copy; 2019
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- WOW effect JavaScript -->
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript" src=js/effect-scroll.js></script>
<!-- Scroll -->
<script type="text/javascript" src="js/scroll-up.js"></script>
<a href="#" class="scrollup">Наверх</a>