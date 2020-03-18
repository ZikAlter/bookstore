<?php
if (isset($_POST['block_user'])) { // кнопка для блокировки пользователя

	$numban_user = clean($con_li, $_POST['numban_user']); // очищаем переменную
	$reason_ban = clean($con_li, $_POST['reason_ban']); // очищаем переменную

	$search_user = $con_li->prepare( "SELECT id FROM user WHERE numb_phone = ?" ); // подготавливаем наш запрос
	$search_user->bind_param( "s", $numban_user ); // подготовка переменных
	$search_user->execute(); // выполняем подготовленный запрос
	$result_user=$search_user->get_result(); // получаем результат из подготовленного запроса
	$search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
	$search_ban->bind_param( "s", $numban_user ); // подготовка переменных
	$search_ban->execute(); // выполняем подготовленный запрос
	$result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

	if (mysqli_num_rows($result_user) == 0) { // если учетка не найдена в базе
		$ups_now [] = 'Учетная запись не найдена в базе данных!';
	} else if (mysqli_num_rows($result_ban) != 0) { // если учетка заблокирована
		$ups_now [] = 'Данный пользователь уже заблокирован!';
	} else if ((empty($numban_user)) || (empty($reason_ban))) { // проверка на пустоту полей
		$ups_now [] = 'Ошибка! Для блокировки пользователя, необходимо заполнить все поля...';
	} else if (strlen($numban_user) > 18) { // проверка на длину номера
		$ups_now [] = 'Длина номера телефона пользователя не должна превышать 18 символов';
	} else { // если ошибок не найдено то блокируем пользоваетля
        $stmt = $con_li->prepare( "INSERT INTO black_list (numb_block , date_block , reason_block) VALUES (?, ?, ?)" ); // подготавливаем наш запрос
		$stmt->bind_param( "sss", $numban_user, $today, $reason_ban ); // подготовка переменных
		$stmt->execute(); // выполняем подготовленный запрос
		$events = 'Администратор заблокировал пользователя '.$numban_user.', по причине: '.$reason_ban.''; // подготовка текста события
		newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
		$sogood_now[] = 'Учетная запись пользователя была успешно заблокирована!'; // сообщение об блокировке
	}
	
} else if (isset($_POST['nullblock_user'])) { // кнопка для разблокировки пользователя
	$num_nullban_user = clean($con_li, $_POST['num_nullban_user']); // очищаем переменную
	$search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
	$search_ban->bind_param( "s", $num_nullban_user ); // подготовка переменных
	$search_ban->execute(); // выполняем подготовленный запрос
	$result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

	if (mysqli_num_rows($result_ban) == 0) { // если учетка не заблокирована
		$ups_now[] = 'Данный пользователь не заблокирован!!!';
	} else if (empty($num_nullban_user)) { // проверка на пустоту полей
		$ups_now[] = 'Для заблокировки необходимо указать номер пользователя...';
	} else if (strlen($num_nullban_user) > 18) { // проверка на длину номера
		$ups_now[] = 'Длина номера телефона пользователя не должна превышать 18 символов';
	} else { // если ошибок не найдено то разблокируем учетку
        $stmt = $con_li->prepare( "DELETE FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
		$stmt->bind_param( "s", $num_nullban_user ); // подготовка переменных
		$stmt->execute(); // выполняем подготовленный запрос
		$events = 'Пользователь: '.$num_nullban_user.'  разблокирован на сайте'; // подготовка текста события
		newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
		$sogood_now[] = 'Пользователь был успешно разблокирован!'; // сообщение об разблокировке
	}
}
?>