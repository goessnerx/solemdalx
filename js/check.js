$(document).ready(function()
{
	$("#form_reg").submit(reg);


function reg()
{

	$.post("register.php",
					{
					act: "send",
					login: $("#username").val(),
					password: $("#pas1").val(),
					password1: $("#pas2").val(),
					email: $("#email").val()
					},
					function (result)
					{ 
						obj = JSON.parse(result);
						//$("#msg_u").html('');
						$("#msg_p1").html('');
						$("#msg_p2").html('');
						$("#msg_e").html('');
						$("#msg_t").html('');
						if(obj.length == 0){
							$("#msg_u").html('');
							$("#username").val("");
							$("#pas1").val("");
							$("#pas2").val("");
							$("#email").val("");
							$("#msg_t").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html("Аккаунт успешно зарегестрирован").removeClass().addClass('messageboxok').fadeTo(900,1);
											});
						}
						
						
						for (var key in obj){
							if(key == '#msg_u')
								$("#msg_u").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html(obj['#msg_u']).addClass('messageboxerror').fadeTo(900,1);
											}); 
							else if(key == '#msg_p1')				
								$("#msg_p1").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html(obj['#msg_p1']).addClass('messageboxerror').fadeTo(900,1);
											}); 
							else if(key == '#msg_p2')
								$("#msg_p2").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html(obj['#msg_p2']).addClass('messageboxerror').fadeTo(900,1);
											}); 
							else if(key == '#msg_e')
								$("#msg_e").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html(obj['#msg_e']).addClass('messageboxerror').fadeTo(900,1);
											}); 
							else if(key == '#msg_t')
								$("#msg_t").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html(obj['#msg_t']).addClass('messageboxerror').fadeTo(900,1);
											});
					}
					
					
					
					
						return false;
					}); 

    return false; 
}
		
		
		
	$("#username").blur(function()
	{
		if($("#username").val() != "")
		{
			$("#msg_u").removeClass().addClass('messagebox').text('Проверка...').fadeIn("slow");
					//Проверить существует ли имя
			$.post("register.php",
								{ 
								act:"check",
								login:$(this).val()												
								} ,function(data)
									{
			
										if(data== 0) //если имя не доступно
										{
											$("#msg_u").fadeTo(200,0.1,function() //начнет появляться сообщение
											{ 
												$(this).html('Этот логин занят').addClass('messageboxerror').fadeTo(900,1);
											}); 
										}
										else if(data == 1)
										{
											$("#msg_u").fadeTo(200,0.1,function() 
											{ 
									//тут прописывается сообщение о доступности имени
												$(this).html('Логин доступен для регистрации').addClass('messageboxok').fadeTo(900,1); 
											});
										}

									});

		} else $("#msg_u").html('');
	});
});	