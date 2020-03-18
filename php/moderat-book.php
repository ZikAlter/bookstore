<?php
if (isset($_POST['del_book'])) { // кнопка удаление книги

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом

    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $ip_address = $_SERVER['REMOTE_ADDR'];  // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Из каталога товаров была удалена книга '.$infa['name_book'].''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию

    $dell = $con_li->prepare( "DELETE FROM books WHERE id = ?" ); // подготавливаем наш запрос
    $dell->bind_param( "i", $infa['id'] ); // подготовка переменных
    $dell->execute(); // выполняем подготовленный запрос
    header("Location: index.php"); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }

} else if (isset($_POST['not_topbook'])) { // кнопка убрать из списка популярных книг

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Книга '.$infa['name_book'].' была убрана из списка популярных книг'; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию

    mysqli_query($con_li, "UPDATE `books` SET `top_book` = '0' WHERE `id` = ".(int) $infa['id']); // выполняем sql запрос на обновление данных
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infa['id'].''); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }

} else if (isset($_POST['go_topbook'])) { // кнопка добавления в список популярных книг

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Книга '.$infa['name_book'].' добавлена в список популярных книг'; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию

    mysqli_query($con_li, "UPDATE `books` SET `top_book` = '1' WHERE `id` = ".(int) $infa['id']); // выполняем sql запрос на обновление данных
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infa['id'].''); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }

} else if (isset($_POST['dell_comment'])) { // кнопка для удаления отзыва

  if (isset($_SESSION['admin_good']) && $_SESSION['admin_good'] == 1) { // проверка является ли пользователь админом
    $infa = mysqli_fetch_assoc($result); // получаем результат из базы о книге
    $numphone_comment = $_POST['numeric_dell_comm']; // получаем данные из формы
    $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
    $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
    $events = 'Администратор удалил отзыв пользователя '.$numphone_comment.' на книгу '.$infa['name_book'].''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $razdel_book = 1;

    $dell = $con_li->prepare( "DELETE FROM comments WHERE log_comment = ? AND id_content = ? AND num_razdel = ?" ); // подготавливаем наш запрос
    $dell->bind_param( "sii", $numphone_comment, $infa['id'], $razdel_book ); // подготовка переменных
    $dell->execute(); // выполняем подготовленный запрос
    header('Location:'.$_SERVER['PHP_SELF'].'?id='.$infa['id'].''); // исключаем повторную отправку формы и запускаем функцию
  } else { // если пользователь не админ
    exit('Ошибка доступа!!!');
  }

}
?>