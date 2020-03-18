<?php
if (isset($_POST['go_autor'])) { // кнопка для авторизации пользователя

	$numb_phone = clean($con_li, $_POST['numb_phone']); // очищаем переменную
	$pass = clean($con_li, $_POST['pass']); // очищаем переменную
	$errors = array(); // массив для вывода ошибок

    $search_log = $con_li->prepare( "SELECT id FROM user WHERE numb_phone = ?" ); // подготавливаем наш запрос
	$search_log->bind_param( "s", $numb_phone ); // подготовка переменных
	$search_log->execute(); // выполняем подготовленный запрос
	$result = $search_log->get_result(); // получаем результат из подготовленного запроса
	$search_ban = $con_li->prepare( "SELECT id FROM black_list WHERE numb_block = ?" ); // подготавливаем наш запрос
	$search_ban->bind_param( "s", $numb_phone ); // подготовка переменных
	$search_ban->execute(); // выполняем подготовленный запрос
	$result_ban = $search_ban->get_result(); // получаем результат из подготовленного запроса

	if (mysqli_num_rows($result) == 0) { // если аккаунт не найден в базе данных
		$errors[] = 'Ваш аккаунт не зарегистрирован!';
	} else if ((empty($numb_phone)) || (empty($pass))) { // проверка на пустоту полей
		$errors[] = 'Ошибка! Все поля должны быть заполнены...';
	}
	else if (!preg_match("/^[0-9a-z]+$/i ", $pass)) { // проверка на англисскую раскладку
		$errors[] = 'Пароль должен содержать только буквы латинского алфавита и цифры';
	} else {

		$hash_pass = password_hash($pass, PASSWORD_BCRYPT, ['salt' => SALT]); // шифруем пароль используя соль
		$search_pass = $con_li->prepare( "SELECT id FROM user WHERE numb_phone = ? AND password = ?" ); // подготавливаем наш запрос
		$search_pass->bind_param( "ss", $numb_phone, $hash_pass); // подготовка переменных
		$search_pass->execute(); // выполняем подготовленный запрос
		$result_pass = $search_pass->get_result(); // получаем результат из подготовленного запроса

		if (mysqli_num_rows($result_pass) != 0) { // если введен верный пароль
			if (mysqli_num_rows($result_ban) != 0) { // если аккаунт заблокирован
				$errors[] = 'Ваша учетная запись заблокирована!';
			} else { // если не заблокирован достаем данные из базы

				$stmt = $con_li->prepare( "SELECT * FROM user WHERE numb_phone = ? AND password = ?" ); // подготавливаем наш запрос
				$stmt->bind_param( "ss", $numb_phone, $hash_pass); // подготавливаем наш запрос
				$stmt->execute(); // выполняем подготовленный запрос
				$row=$stmt->get_result(); // получаем результат из подготовленного запроса
				$row = mysqli_fetch_assoc($row); // приравниваем данные из бд к массиву

				foreach ($row as $key => $value) {
				    $_SESSION[$key] = $value;
				}
				$_SESSION['user_auto'] = 1; // активируем ссесию для авторизации
				header("Location: profile.php"); // исключаем повторную отправку формы и запускаем функцию
			}
		} else { // если пароль неверный
			$errors[] = 'Ошибка! Введен неверный пароль...';
		}
	}
}
?>