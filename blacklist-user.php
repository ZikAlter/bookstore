<?php
session_start();
require_once('php/li-connect.php'); // соединение с БД
require_once('php/header.php'); // верстка header
?>
<main>
<div class="container">
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
  <hr>
  <h2 class="text-center font-ubuntu">Список заблокированных пользователей</h2>
  <hr>
  <table class="table table-hover text-center table-bordered">
    <thead class="unique-color white-text">
      <tr>
        <th scope="col"><strong>Дата блокировки</strong></th>
        <th scope="col"><strong>Номер пользователя</strong></th>
        <th scope="col"><strong>Причина блокировки</strong></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $lock_blockuser = mysqli_query($con_li, "SELECT * FROM `black_list` ORDER BY (`date_block`) DESC "); // sql запрос на список заблокированных пользователей
      $whileblockuser = mysqli_num_rows($lock_blockuser); // подсчет заблокированных учеток
      if ($whileblockuser > 0){ // если заблокировано больше нуля
        while($info_blockuser = mysqli_fetch_assoc($lock_blockuser)){ // формируем массив для вывода в таблице
      ?>
      <tr>
        <th scope="row"><strong><?php echo $info_blockuser['date_block']; ?></strong></th>
        <td><strong><?php echo $info_blockuser['numb_block']; ?></strong></td>
        <td><strong><?php echo $info_blockuser['reason_block']; ?></strong></td>
      </tr>
      <?php
        }
      }else{ // если пусто то выводим сообщение
      ?>
      <tr>
        <td colspan="3"><strong>Таблица пуста!</strong></td>
      </tr>
      <?php
      }
      ?>
    </tbody>
  </table>
  <?php
  }
  else{ // если не авторизован под админом выводим сообщение
  ?>
  <div class="row">
    <div class="col mt-5 mb-5 text-center wow fadeIn" style="height: 500px;">
      <i class="fas fa-exclamation-circle fa-4x col-redbook"></i>
      <h1>Ошибка! Доступ ограничен...</h1>
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
<script type="text/javascript" src="js/jquery.validate.min.js">
</script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js">
</script>
<script type="text/javascript" src="js/validate.js">
</script>
</body>

</html>