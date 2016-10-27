<?
class Chance
{
	public $ip, $cur_time1;
	
	function __construct($ip)
    {
	$this -> ip = $ip; // ip текущего пользователя
	$this -> cur_time1 = date("Y-m-d H:i:s"); // текущее время
    }
   
   function proof() // функция проверки возможности регистрации
   {
	   if(!isset($_SESSION[strval($this -> ip)]))// если регистрация возможна, то в переменную сессии устанавливаем время текузей регистрации
	   {
		   $_SESSION[strval($this -> ip)] = $this -> cur_time1;
		   return true;
	   }
	   else
	   {
		   if(strtotime(($this -> cur_time1)) - strtotime($_SESSION[strval($this -> ip)]) < 600) // проверка на пройденное время (10 минут)
			   return false;
		   else
		   {
			   $_SESSION[strval($this -> ip)] = $this -> cur_time1; // если прошло больше 10 минут, устанавливаем новое время при регистрации
			   return true;
		   }
	   }
   }
}
?>