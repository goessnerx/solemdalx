$(document).ready(function ()
{
	
	$("#login").submit(auth); // вешаем на форму авторизации событие которое срабатывает когда нажата кнопка "Отправить" или "Enter"
});

function auth()
{
              
    $.post("auth.php",
		{
			login: $("#login_in").val(), // имя пользователя
			password: $("#password_in").val() //  пароль пользователя
		},
		function (result)
		{ 
		
			if(result == 0) // при успехе редирект на домашнюю страницу
				location.href = "index.html";

			if(result == 1) //при неправильном логине или пароле сообщение об ошибке
				$("#wrong").text("Неправильный логин или пароль");
			
			return false;
		}); 

                
	$("#password_in").val("Пароль"); // чистка поля с паролем		
    $("#login_in").focus(); // фокус на поле с логином

    return false; 
}