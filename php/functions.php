<?php
function newevent($con_li, $onepar, $twopar, $freepar) { // функция для записи события в базу данных
	$stmt = $con_li->prepare( "INSERT INTO site_log (date_events , ip_address_events , text_events) VALUES (?, ?, ?)" ); // подготавливаем запрос для записи события
	$stmt->bind_param( "sss", $onepar, $twopar, $freepar ); // подготавливаем переменные записи
	$stmt->execute(); // выполняем подготовленный запрос
}

function clean($con_li, $value) { // функция для очистки данных введенных пользователем
    $value = trim($value); // удаление лишних пробелов
    $value = stripslashes($value); // удаляем экранирование
    $value = strip_tags($value); // удаляем html теги
    $value = htmlspecialchars($value); // преобразуем теги в символы
    $value = mysqli_real_escape_string($con_li, $value);  // очищаем от sql инъекции 
    return $value; // возвращаем очищенную переменную пользователю
}

function show_confirmation() { // функция для вывода сообщения об успеха регистрации
    return isset($_GET['showmsg']) && $_GET['showmsg'] == 'true';
}