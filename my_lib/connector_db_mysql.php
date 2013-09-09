<?php
/*
 * Бибилтека работы с базой mysql все работы ведуться с кодировкой utf-8
 * @param array of 
 */


 /*
  * Функция подключения
  */
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

?>