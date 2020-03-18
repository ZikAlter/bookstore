<?php
if (isset($_POST['del_course'])) { // кнопка удаление книги

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $ip_address = $_SERVER['REMOTE_ADDR'];  // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Из каталога товаров был удален курс '.$infa['title_course'].''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию

    $dell = $con_li->prepare( "DELETE FROM courses WHERE id = ?" ); // подготавливаем наш запрос
    $dell->bind_param( "i", $infa['id'] ); // подготовка переменных
    $dell->execute(); // выполняем подготовленный запрос
    header("Location: index.php"); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }

} else if (isset($_POST['dell_comment'])) { // кнопка для удаления отзыва

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $numphone_comment = $_POST['numeric_dell_comm']; // получаем данные из формы
    $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Администратор удалил отзыв пользователя '.$numphone_comment.' на курс '.$infa['title_course'].''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $razdel_book = 3;

    $dell = $con_li->prepare( "DELETE FROM comments WHERE log_comment = ? AND id_content = ? AND num_razdel = ?" ); // подготавливаем наш запрос
    $dell->bind_param( "sii", $numphone_comment, $infa['id'], $razdel_book ); // подготовка переменных
    $dell->execute(); // выполняем подготовленный запрос
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infa['id'].''); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }
  
}
?>