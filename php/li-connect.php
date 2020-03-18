<?php
$con_li = new mysqli('127.0.0.1', 'root', '', 'bookstore'); // данные для соединения с базой
mysqli_query($con_li,"SET NAMES utf8mb4");

/* проверка подключения */
if (mysqli_connect_errno()) {
    printf("Не удалось подключиться: %s\n", mysqli_connect_error());
    exit();
}

DEFINE('SALT', 'f13%14rdxd2$g29*q#hjk8'); // символы для шифровки пароля
?>