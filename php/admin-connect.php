<?php
if (isset($_POST['go_admins'])) { // кнопка авторизации в систему администрирования

  $access_code = clean($con_li,$_POST['access_code']); // очищаем переменную
  $errors = array(); // массив для вывода ошибок

  if (empty($access_code)) { // проверка на пустоту
    $errors[] = 'Ошибка! Поле не заполнено!';
  } else if (!preg_match("/^[0-9a-z]+$/i ", $access_code)) { // проверка на англисскую раскладку
    $errors[] = 'Используйте только буквы латинского алфавита и цифры';
  } else { // если ошибок не найдено то
    $hash_accesscode = password_hash($access_code, PASSWORD_BCRYPT, ['salt' => SALT]); // шифруем пароль используя соль

    $search_code = $con_li->prepare( "SELECT id FROM admin_info WHERE secret_pass = ?" ); // подготавливаем наш запрос
    $search_code->bind_param( "s", $hash_accesscode); // подготовка переменных
    $search_code->execute(); // выполняем подготовленный запрос
    $result_code = $search_code->get_result(); // получаем результат из подготовленного запроса

    if (mysqli_num_rows($result_code) != 0) { // если введен верный пароль
      $_SESSION['admin_good'] = 1; // присваиваем ссесию авторизации
      $events = 'Выполнен успешный вход в систему администрирования'; // подготовка текста события
      $ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
      $today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
      newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
      header('Location:'.$_SERVER['PHP_SELF'].''); // исключаем повторную отправку формы и запускаем функцию
    } else { // если введен неверный пароль
      $errors[]= 'Ошибка! Неверный пароль';
    }
  }
}
?>