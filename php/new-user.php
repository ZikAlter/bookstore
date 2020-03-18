<?php
if (isset($_POST['go_registr'])) { // кнопка для регистрации нового пользователя

	$numb_phone = clean($con_li, $_POST['numb_phone']); // очищаем переменную
	$user_name = clean($con_li, $_POST['user_name']);  // очищаем переменную
	$email = clean($con_li, $_POST['email']);  // очищаем переменную
	$pass = clean($con_li, $_POST['pass']);  // очищаем переменную
	$repeat_pass = clean($con_li, $_POST['repeat_pass']); // очищаем переменную
	$ip_address = $_SERVER['REMOTE_ADDR']; // получаем ip адрес
	$today = date("Y-m-d H:i:s"); // 2001-03-10 17:16:18 (the MySQL DATETIME format)
	$errors = array(); // массив для вывода ошибок

	$search = $con_li->prepare( "SELECT id FROM user WHERE numb_phone = ?" ); // подготавливаем наш запрос
	$search->bind_param( "s", $numb_phone ); // подготовка переменных
	$search->execute(); // выполняем подготовленный запрос
	$result = $search->get_result(); // получаем результат из подготовленного запроса

	if (mysqli_num_rows($result) != 0) { // если учетка зарегистрированна
		$errors[] = 'Данный номер телефона уже занят! Пожалуйста используйте другой номер....';
	} else if ((empty($numb_phone)) || (empty($user_name)) || (empty($email)) || (empty($pass)) || (empty($repeat_pass))) { // проверка на пустоту полей
		$errors[] = 'Ошибка! Все поля должны быть заполнены';
	} else if (strlen($numb_phone) > 18) { // проверка на длину номера
		$errors[] = 'Длина номера телефона не должна превышать 18 символов';
	} else if ((strlen($user_name) < 4) || (strlen($user_name) > 40)) { // проверка на длину логина
		$errors[] = 'Длина логина от 4 до 40 символов';
	} else if ((strlen($email) < 6) || (strlen($email) > 64)) { // проверка на длину почты
		$errors[] = 'Длина почты от 6 до 64 символов';
	} else if ((strlen($pass) < 6) || (strlen($pass) > 30)) { // проверка на длину пароля
		$errors[] = 'Длина пароля от 6 до 30 символов';
	} else if (!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email)) { // проверка на допустимые символы в адресе почты
		$errors[] = 'Ошибка! Неверный формат email-адреса';
	} else if (!preg_match("/^[0-9a-z]+$/i ", $pass)) { // проверка на допустимые символы в пароле
		$errors[] = 'Пароль должен содержать только буквы латинского алфавита и цифры';
	} else { // если ошибки не найдены

		if ($pass == $repeat_pass) { // если пароли равны
			$events = 'Новый пользователь '.$numb_phone.' зарегистрировался на сайте'; // подготовка текста события
			$hash_pass = password_hash($pass, PASSWORD_BCRYPT, ['salt' => SALT]); // шифруем пароль используя соль

            $stmt = $con_li->prepare( "INSERT INTO user (numb_phone , user_name , password , email , ip_address , date_registr) VALUES (?, ?, ?, ?, ?, ?)" ); // подготавливаем наш запрос
			$stmt->bind_param( "ssssss", $numb_phone, $user_name, $hash_pass, $email, $ip_address, $today ); // подготовка переменных
			$stmt->execute(); // выполняем подготовленный запрос
			newevent($con_li, $today, $ip_address, $events); // передача данных в функцию
			header('Location:'.$_SERVER['PHP_SELF'].'?showmsg=true'); // исключаем повторную отправку формы и запускаем функцию
		} else { // если пароли не совпадают
			$errors[] = 'Ошибка! Введеные вами пароли не совпадают';
		}

	}
}
?>