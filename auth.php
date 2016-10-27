<?php

    header('Content-Type: text/html; charset=UTF8');
	require_once('connect_to_db.php'); // файл с подключение к бд
	
	if(isset($_POST["login"])) $login = $_POST["login"];
	if(isset($_POST["password"])) $password = $_POST["password"];
 
	if(isset($login) && isset($password))
	{
	
		$password = md5($password);
			
		$sql = "select *from users where login = :login and password = :password;";
		$stmt = $dbh->prepare($sql); // подготовленный запрос
		$stmt -> execute(array('login' => $login, 
							 'password' => $password
							));
		$row = $stmt -> fetch();

		if(!$row['login']) // неверный логин или пароль
			echo 1;
		else // при успешном вводе создается сессия
		{
			$_SESSION['login'] = $login;
			$_SESSION['password'] = $password;
			echo 0;
		}
	}else // редирект на страницу логина при прямом заходе на этот файл
		header('Location: login.php');
 
?>