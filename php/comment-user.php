<?php
if (isset($_POST['go_comment_book'])) { // кнопка для отправки отзыва

  $infors = mysqli_fetch_assoc($result); // получаем результат из базы о книге
  $otmetka = clean($con_li, $_POST['otmetka']); // очистка переменной
  $text_otziv = clean($con_li, $_POST['text_otziv']); // очистка переменной
  $num_razdel = 1; // приравниваем раздел книги
  $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
  $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)

  $search = $con_li->prepare( "SELECT id FROM comments WHERE log_comment = ? AND  id_content = ? AND  num_razdel = ?" ); // подготавливаем наш запрос
  $search->bind_param( "sii", $_SESSION['numb_phone'], $infors['id'], $num_razdel ); // подготовка переменных
  $search->execute(); // выполняем подготовленный запрос
  $result = $search->get_result(); // получаем результат из подготовленного запроса
  $search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
  $search_ban->bind_param( "s", $_SESSION['numb_phone'] ); // подготовка переменных
  $search_ban->execute(); // выполняем подготовленный запрос
  $result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

  if (mysqli_num_rows($result) != 0) { // если пользователь оставлял отзыв на книгу
    exit('<meta charset="utf-8">
      <b style="color: red;">Вы уже оставляли свой отзыв на данную книгу....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if (mysqli_num_rows($result_ban) != 0) { // если пользователь заблокирован
    exit('<meta charset="utf-8">
      <b style="color: red;">Ваша учетная запись заблокирована!</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if (empty($text_otziv)) { // проверка на пустоту полей
    exit('<meta charset="utf-8">
      <b style="color: red;">Ошибка! Вы не написали свой отзыв....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else {
    if (empty($otmetka)) { // если не выбрана отметка
      $otmetka = 'neutral'; // присваиваем нейтральную оценку
    }

    $events = 'Пользователь '.$_SESSION['numb_phone'].' оставил свой отзыв на книгу '.$infors['name_book'].', текст отзыва: '.$text_otziv.''; // подготовка текста события
    $stmt = $con_li->prepare( "INSERT INTO comments (log_comment , id_content , num_razdel , date_comment , otmetka , text_comment) VALUES (?, ?, ?, ?, ?, ?)" ); // подготавливаем наш запрос
    $stmt->bind_param( "siisss", $_SESSION['numb_phone'], $infors['id'], $num_razdel, $today, $otmetka, $text_otziv ); // подготовка переменных
    $stmt->execute(); // выполняем подготовленный запрос
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infors['id'].''); // исключаем повторную отправку формы и запускаем функцию

  }
} else if (isset($_POST['go_comment_seminar'])) { // кнопка для отправки отзыва

  $infors = mysqli_fetch_assoc($result); // получаем результат из базы о книге
  $otmetka = clean($con_li, $_POST['otmetka']); // очистка переменной
  $text_otziv = clean($con_li, $_POST['text_otziv']); // очистка переменной
  $num_razdel = 2; // приравниваем раздел книги
  $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
  $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)

  $search = $con_li->prepare( "SELECT id FROM comments WHERE log_comment = ? AND  id_content = ? AND  num_razdel = ?" ); // подготавливаем наш запрос
  $search->bind_param( "sii", $_SESSION['numb_phone'], $infors['id'], $num_razdel ); // подготовка переменных
  $search->execute(); // выполняем подготовленный запрос
  $result = $search->get_result(); // получаем результат из подготовленного запроса
  $search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
  $search_ban->bind_param( "s", $_SESSION['numb_phone'] ); // подготовка переменных
  $search_ban->execute(); // выполняем подготовленный запрос
  $result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

  if (mysqli_num_rows($result) != 0) { // если пользователь оставлял отзыв на книгу
    mb_internal_encoding("UTF-8");
    exit('<meta charset="utf-8">
      <b style="color: red;">Вы уже оставляли свой отзыв на данный семинар....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if(mysqli_num_rows($result_ban) != 0) { // если пользователь заблокирован
    mb_internal_encoding("UTF-8");
    exit('<meta charset="utf-8">
      <b style="color: red;">Ваша учетная запись заблокирована!</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if (empty($text_otziv)) { // проверка на пустоту полей
    exit('<meta charset="utf-8">
      <b style="color: red;">Ошибка! Вы не написали свой отзыв....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else {
    if (empty($otmetka)) { // если не выбрана отметка
      $otmetka = 'neutral'; // присваиваем нейтральную оценку
    }

    $events = 'Пользователь '.$_SESSION['numb_phone'].' оставил свой отзыв на семинар '.$infors['title_seminar'].', текст отзыва: '.$text_otziv.''; // подготовка текста события
    $stmt = $con_li->prepare( "INSERT INTO comments (log_comment , id_content , num_razdel , date_comment , otmetka , text_comment) VALUES (?, ?, ?, ?, ?, ?)" ); // подготавливаем наш запрос
    $stmt->bind_param( "siisss", $_SESSION['numb_phone'], $infors['id'], $num_razdel, $today, $otmetka, $text_otziv ); // подготовка переменных
    $stmt->execute(); // выполняем подготовленный запрос
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infors['id'].''); // исключаем повторную отправку формы и запускаем функцию

  }
} else if (isset($_POST['go_comment_course'])) { // кнопка для отправки отзыва

  $infors = mysqli_fetch_assoc($result); // получаем результат из базы о книге
  $otmetka = clean($con_li, $_POST['otmetka']); // очистка переменной
  $text_otziv = clean($con_li, $_POST['text_otziv']); // очистка переменной
  $num_razdel = 3; // приравниваем раздел книги
  $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
  $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)

  $search = $con_li->prepare( "SELECT id FROM comments WHERE log_comment = ? AND  id_content = ? AND  num_razdel = ?" ); // подготавливаем наш запрос
  $search->bind_param( "sii", $_SESSION['numb_phone'], $infors['id'], $num_razdel ); // подготовка переменных
  $search->execute(); // выполняем подготовленный запрос
  $result = $search->get_result(); // получаем результат из подготовленного запроса
  $search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
  $search_ban->bind_param( "s", $_SESSION['numb_phone'] ); // подготовка переменных
  $search_ban->execute(); // выполняем подготовленный запрос
  $result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

  if (mysqli_num_rows($result) != 0) { // если пользователь оставлял отзыв на книгу
    mb_internal_encoding("UTF-8");
    exit('<meta charset="utf-8">
      <b style="color: red;">Вы уже оставляли свой отзыв на данный курс....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if (mysqli_num_rows($result_ban) != 0) { // если пользователь заблокирован
    mb_internal_encoding("UTF-8");
    exit('<meta charset="utf-8">
      <b style="color: red;">Ваша учетная запись заблокирована!</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else if (empty($text_otziv)) { // проверка на пустоту полей
    exit('<meta charset="utf-8">
      <b style="color: red;">Ошибка! Вы не написали свой отзыв....</b>
      <p>
      <a href="index.php">Вернуться на основной ресурс</a>
      </p>');
  } else {
    if (empty($otmetka)) { // если не выбрана отметка
      $otmetka = 'neutral'; // присваиваем нейтральную оценку
    }

    $events = 'Пользователь '.$_SESSION['numb_phone'].' оставил свой отзыв на курс '.$infors['title_course'].', текст отзыва: '.$text_otziv.''; // подготовка текста события
    $stmt = $con_li->prepare( "INSERT INTO comments (log_comment , id_content , num_razdel , date_comment , otmetka , text_comment) VALUES (?, ?, ?, ?, ?, ?)" ); // подготавливаем наш запрос
    $stmt->bind_param( "siisss", $_SESSION['numb_phone'], $infors['id'], $num_razdel, $today, $otmetka, $text_otziv ); // подготовка переменных
    $stmt->execute(); // выполняем подготовленный запрос
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infors['id'].''); // исключаем повторную отправку формы и запускаем функцию
  }
}
?>