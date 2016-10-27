<?php
	session_start();

	
	header('Content-Type: text/html; charset=UTF8');
	require_once ('connect_to_db.php'); // файл с подключение к бд
	require_once ('Chance.php'); // класс для ограничение регистрации по времени
	date_default_timezone_set('Europe/Moscow');
	// функция проверки аккаунта на существование
	function user_avial()
	{
		global $dbh;
		if(isset($_POST['login']))
		{
			$login = $_POST['login'];
			// запрос в базу на наличие введенного логина в ней
			$sql = "select *from users where login = '$login';";
			$stmt = $dbh->prepare($sql);
			$stmt->execute();
			
			$count_row = $stmt -> rowCount();
			
			if ($count_row > 0) 
				return 0; // пользователь с таким логином уже есть
			else 
				return 1; // логин свободен
		}
		return 0;
	}
	
	
	$cur_time = date("Y-m-d H:i:s");// текущее время
	$object = new Chance($_SERVER["REMOTE_ADDR"]); // создание объекта класса с ip-адресом текузего пользователя

	
	
	if(isset($_POST['act']))
		if($_POST['act'] == 'check') // запрос на проверку свободности логина
			echo user_avial();
		else
		{
			// считывание введенных пользователем данных
			if(isset($_POST['login'])) $login = $_POST['login'];
			if(isset($_POST['password'])) $password = md5($_POST['password']);
			if(isset($_POST['password1'])) $password_rep = md5($_POST['password1']);
			if(isset($_POST['email'])) $email = $_POST['email'];
			
			
			$err = [];
			
			// проверка на длину введенного пароля
			if(strlen($_POST['password']) < 8) $err['#msg_p1'] = $err['#msg_p2'] = "Слишком простой пароль";
			// проверка на корректность введенного логина
			if(!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $login)) $err['#msg_u'] = "Некорректный логин";
			// проверка на совпадение паролей
			if($password != $password_rep) $err['#msg_p1'] = $err['#msg_p2'] = "Пароли не совпадают";
			// проверка корректности e-mail
			if(!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]{2,4}$/", $email)) $err['#msg_e'] = "Некорректный e-mail";
			// проверка на занятость логина
			if(!user_avial()) $err['#msg_u'] = "Этот логин занят другим пользователем";

			if(empty($err))
				// проверка на разрешение регистрации по времени
				if(!($object -> proof())) $err['#msg_t'] = "Превышен лимит создания аккаунта, повторите попытку позже";
				else
				{
						
					$sql = "insert into users (login,password,date_reg,email) values(:login,:password,:date_reg,:email)";
					$stmt = $dbh->prepare($sql);
					// подготовленный запрос
					$stmt->execute(array('login' => $login,
										'password' => $password,
										'date_reg' => $cur_time,
										'email' => $email,
					
										));
				}
			// передача js массива ошибок	
			echo json_encode($err);
			
		}
	
?>