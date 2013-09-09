<?php ## Главный конфигурационный файл сайта.
// Подключается ко всем сценариям (автоматически или вручную)
if (!defined("PATH_SEPARATOR"))
  define("PATH_SEPARATOR", getenv("COMSPEC")? ";" : ":");
ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.dirname(__FILE__));

//Устанавливаем префикс для таблиц
define(TABLE_PREFIX, 'agro2b_'); // с подчерком!

require_once dirname(__FILE__)."/DbSimple/Generic.php";
require_once dirname(__FILE__)."/task.php";
require_once "/Debug/HackerConsole/Main.php";

$arr_ident=array(
			'executor_id'=>115544,
			'max_time'=>60,
			);


?>
