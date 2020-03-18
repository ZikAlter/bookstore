<?php
session_start();
require_once('php/li-connect.php'); // соединение с БД
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container-fluid">
  <div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
      <li data-target="#carousel-example-1z" data-slide-to="1"></li>
      <li data-target="#carousel-example-1z" data-slide-to="2"></li>
      <li data-target="#carousel-example-1z" data-slide-to="3"></li>
      <li data-target="#carousel-example-1z" data-slide-to="4"></li>
      <li data-target="#carousel-example-1z" data-slide-to="5"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
      <div class="carousel-item active view overlay zoom">
        <img class="d-block w-100 img-fluid" src="img/slider/1.jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text"><strong>Государственное автономное образовательное учреждения Республики Хакасия</strong> дополнительного профессионального образования "Хакасский институт развития образования и повышения квалификации".</p>
        </div>
      </div>
      <div class="carousel-item view overlay zoom">
        <img class="d-block w-100 img-fluid" src="img/slider/2.jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text">Институт оказывает услуги в сфере дополнительного профессионального образования: повышение профессиональных знаний специалистов, совершенствование их деловых качеств, подготовка их к выполнению новых трудовых функций.</p>
        </div>
      </div>
      <div class="carousel-item view overlay zoom">
        <img class="d-block w-100 img-fluid" src="img/slider/3.jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text">Дата создания: 1944 год - Институт усовершенствования учителей, в 2011 г. получил статус государственного автономного образовательного учреждения Республики Хакасия дополнительного профессионального образования "Хакасский институт развития образования и повышения квалификации" (ГАОУ РХ ДПО «ХакИРОиПК»)</p>
        </div>
      </div>
      <div class="carousel-item view overlay zoom">
        <img class="d-block w-100 img-fluid" src="img/slider/4.jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text">
            <strong>Предлагаем направления:</strong>
            <br>
            - Дистанционное обучение.
            <br>
            - Повышение квалификации и профессиональная переподготовка. 
            <br>
            - Экзамен для иностранных граждан. 
            <br>
            <strong>Услуги:</strong>
            <br>
            - Типография.
            <br>
            - Общежитие.
            <br>
            - Магазин «Учебники». 
          </p>
        </div>
      </div>
      <div class="carousel-item view overlay zoom">
        <img class="d-block w-100 img-fluid" src="img/slider/5.jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text">
            <strong>Учредители:</strong>
            <br>
            Правительство Республики Хакасия
            <br>
            Министерство образования и науки Республики Хакасия
            <br>
            Министерство имущественных  и земельных отношений Республики Хакасия
        </p>
        </div>
      </div>
      <div class="carousel-item view overlay zoom">
        <img class="d-block w-100 img-fluid" src="https://mdbootstrap.com/img/Photos/Slides/img%20(141).jpg" alt="First slide">
        <div class="mask flex-center waves-effect waves-light rgba-blue-light text-center">
          <p class="white-text">Руководитель: ректор <strong>Дмитриева Светлана Тихоновна</strong>, кандидат психологических наук, доцент</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<div class="container">
  <div class="row mt-3">
    <div class="col-md-6 mb-4 wow slideInLeft">
      <div class="card card-cascade narrower">
        <div class="view view-cascade gradient-card-header blue-gradient text-center">
          <h3 class="m-2 text-white font-comfort">Мы находимся</h3>
        </div>
        <div class="card-body card-body-cascade text-center">
          <div id="map-container-google-8" class="z-depth-1-half map-container-5 h-330">
            <iframe src="<?php echo $cord['google_maps']; ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4 wow slideInRight">
      <div class="card card-cascade narrower">
        <div class="view view-cascade gradient-card-header peach-gradient text-center">
          <h3 class="m-2 text-white font-comfort">Наши партнеры</h3>
        </div>
        <div class="card-body card-body-cascade text-center">
          <?php require_once('php/list_partners.php'); // подключение верстки с иконками ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row text-center wow fadeIn" data-wow-duration="2s">
    <div class="col-md-4">
      <a class="btn-floating btn-success btn-lg" title="Телефон"><i class="fas fa-phone-volume fa-2x text-white"></i></a>
      <p class="font-philos"><strong><?php echo $cord['phone_mag']; ?></strong></p>
    </div>
    <div class="col-md-4">
      <a class="btn-floating btn-danger btn-lg" title="Адрес"><i class="fas fa-map-marker-alt fa-2x text-white"></i></a>
      <p class="font-philos"><strong><?php echo $cord['fact_address']; ?></strong></p>
    </div>
    <div class="col-md-4">
      <a class="btn-floating btn-primary btn-lg" title="Электронная почта"><i class="fas fa-envelope-open fa-2x text-white"></i></a>
      <p class="font-philos"><strong><?php echo $cord['email_mag']; ?></strong></p>
    </div>
  </div>
  <div class="row text-center wow fadeIn" data-wow-duration="2s">
    <div class="col-md-4">
      <a href="<?php echo $cord['social_vk']; ?>" title="VK" target="_blank" class="btn-floating btn-mdb-color btn-lg"><i class="fab fa-vk fa-fw fa-2x text-white"></i></a>
      <p><strong><a href="<?php echo $cord['social_vk']; ?>" target="_blank">Посетить ресурс</a></strong></p>
    </div>
    <div class="col-md-4">
      <a href="<?php echo $cord['social_facebook']; ?>" title="Facebook" target="_blank" class="btn-floating btn-indigo btn-lg"><i class="fab fa-facebook-f fa-fw fa-2x text-white"></i></a>
      <p><strong><a href="<?php echo $cord['social_facebook']; ?>" target="_blank">Посетить ресурс</a></strong></p>
    </div>
    <div class="col-md-4">
      <a href="<?php echo $cord['social_web']; ?>" title="Web-site" target="_blank" class="btn-floating btn-elegant btn-lg"><i class="fab fa-weebly fa-fw fa-2x text-white"></i></a>
      <p><strong><a href="<?php echo $cord['social_web']; ?>" target="_blank">Посетить ресурс</a></strong></p>
    </div>
  </div>
  <div class="row wow fadeIn" data-wow-duration="2s">
    <div class="col text-center">
      <p><?php echo $cord['text_glossary']; ?></p>
    </div>
  </div>
</div>
</main>
<?php
require_once('php/footer.php'); // верстка footer
?>
</body>

</html>
