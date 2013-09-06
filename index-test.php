<?php ## Подключение к БД.

//$base_dir=dirname(__FILE__);
require_once "./my_lib/config.php";
require_once "./my_lib/DbSimple/Generic.php";

// Подключаемся к БД.
$DATABASE = DbSimple_Generic::connect('mysql://user2324_nawww:1234567aA@93.171.202.18/user2324_main');

// Устанавливаем обработчик ошибок.
$DATABASE->setErrorHandler('databaseErrorHandler');




// Код обработчика ошибок SQL.
function databaseErrorHandler($message, $info)
{
	// Если использовалась @, ничего не делать.
	if (!error_reporting()) return;
	// Выводим подробную информацию об ошибке.
	echo "SQL Error: $message<br><pre>"; 
	print_r($info);
	echo "</pre>";
	exit();
}




echo "vse ok";
?>
