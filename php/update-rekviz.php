<?php
$ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
$today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
$ups_now = array(); // массив для вывода сообщения
$sogood_now = array(); // массив для вывода сообщения

if (isset($_POST['new_rekviz_magaz'])) { // кнопка для обновления названия магазина
  $rekviz_magaz = clean($con_li, $_POST['rekviz_magaz']); // очищаем переменную

  if (empty($rekviz_magaz)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET name_magaz = ? WHERE id = 1" ); // подготавливаем наш запрос
    $rek->bind_param( "s", $rekviz_magaz); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлено наименование магазина: '.$rekviz_magaz.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Наименование магазина успешно обновлено!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_factaddress'])) { // кнопка для обновления фактического адреса
  $factaddress_magaz = clean($con_li, $_POST['factaddress_magaz']); // очищаем переменную

  if (empty($factaddress_magaz)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET fact_address = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $factaddress_magaz); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлен фактический адрес магазина: '.$factaddress_magaz.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Фактический адрес успешно обновлен!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_uraddress'])) { // кнопка для обновления юридического адреса
  $uraddress_magaz = clean($con_li, $_POST['uraddress_magaz']); // очищаем переменную

  if (empty($uraddress_magaz)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET ur_address = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $uraddress_magaz); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлен юридический адрес магазина: '.$uraddress_magaz.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Юридический адрес успешно обновлен!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_phone'])) { // кнопка для обновления номера телефона
  $phone_magaz = clean($con_li, $_POST['phone_magaz']); // очищаем переменную

  if (empty($phone_magaz)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET phone_mag = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $phone_magaz); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлена контактная информация, телефонный номер: '.$phone_magaz.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Телефоный номер/факс успешно обновлен!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_email'])) { // кнопка для обновления email адреса
  $email_magaz = clean($con_li, $_POST['email_magaz']); // очищаем переменную

  if (empty($email_magaz)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET email_mag = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $email_magaz); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлена контактная информация, email-адрес: '.$email_magaz.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Email-адрес успешно обновлен!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_vk'])) { // кнопка для обновления vk
  $vk_group = clean($con_li, $_POST['vk_group']); // очищаем переменную

  if (empty($vk_group)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET social_vk = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $vk_group); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлен адрес группы VK: '.$vk_group.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Ссылка на группу VK успешно обновлена!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_facebook'])) { // кнопка для обновления facebook
  $facebook_group = clean($con_li, $_POST['facebook_group']); // очищаем переменную

  if (empty($facebook_group)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET social_facebook = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $facebook_group); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлен адрес группы Facebook: '.$facebook_group.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Ссылка на группу Facebook успешно обновлена!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_web'])) { // кнопка для обновления web ссылки
  $web_site = clean($con_li, $_POST['web_site']); // очищаем переменную

  if (empty($web_site)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET social_web = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $web_site); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлена ссылка на WEB-ресурс: '.$web_site.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Ссылка на WEB-ресурс успешно обновлена!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_google'])) { // кнопка для обновления web ссылки
  $google_maps = clean($con_li, $_POST['google_maps']); // очищаем переменную

  if (empty($google_maps)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET google_maps = ? WHERE id = 1" ); // подготавливаем наш запрос 
    $rek->bind_param( "s", $google_maps); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлены координаты карты Google Maps: '.$google_maps.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Координаты Google Maps успешно обновлены!'; // вывод сообщения
  }

} else if (isset($_POST['new_rekviz_glosary'])) { // кнопка для обновления текста описания деятельности
  $magaz_glosary = clean($con_li, $_POST['magaz_glosary']); // очищаем переменную

  if (empty($magaz_glosary)) { // проверка на пустоту полей
    $ups_now[] = 'Ошибка! Поле не заполнено!';
  } else { // если ошибок не найдено выполняем запрос к базе
    $rek = $con_li->prepare( "UPDATE cordinat SET text_glossary = ? WHERE id = 1" );  // подготавливаем наш запрос 
    $rek->bind_param( "s", $magaz_glosary); // подготовка переменных
    $rek->execute(); // выполняем подготовленный запрос
    $events = 'Обновлено описание деятельности: '.$magaz_glosary.''; // подготовка текста события
    newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
    $sogood_now[] = 'Описание деятельности успешно обновлено!'; // вывод сообщения
  }
  
}
?>