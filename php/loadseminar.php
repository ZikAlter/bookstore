<?php
$num_str = (int) $_GET['id']; // полученный id является числом
$num_str = trim($num_str); // удаляем лишние пробелы
$num_str = strip_tags($num_str); // удаляем html теги
$num_str = stripslashes($num_str); // удаляем экранирование
$num_str = htmlspecialchars($num_str); // преобразуем html теги в символы

$stmt = $con_li->prepare( "SELECT * FROM seminar WHERE id = ?" ); // подготавливаем наш запрос
$stmt->bind_param( "i", $num_str );// подготовка переменных
$stmt->execute(); // выполняем подготовленный запрос
$result = $stmt->get_result(); // получаем результат из подготовленного запроса
?>