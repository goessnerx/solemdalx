<?
        
    try
	{
		$dbh = new PDO("mysql:host=sql204.rf.gd;port=3306;dbname=rfgd_18827983_solemdalx;charset=utf8", 'rfgd_18827983', 'a345bh78');
	} catch(PDOException $e)
	{
		echo 'Подключение не удалось connect_to_db: ' . $e->getMessage();// отлов ошибки подключения к базе и вывод ее
	}
          
?>
