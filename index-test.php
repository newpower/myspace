<?php ## Подключение к БД.

//$base_dir=dirname(__FILE__);
require_once "./my_lib/config.php";

new Debug_HackerConsole_Main(true);
// Output to default group.
Debug_HackerConsole_Main::out("Usual message");
// Dump random structure.
//Debug_HackerConsole_Main::out($_SERVER, "Input");


// Подключаемся к БД.
$arr_ident["db1"] = DbSimple_Generic::connect('mysql://user2324_nawww:1234567aA@93.171.202.18/user2324_main');
//$DATABASE =  DbSimple_Generic::connect('mysql://user2324_nawww:1234567aA@93.171.202.18/user2324_main');
$arr_ident["db1"]->setIdentPrefix(TABLE_PREFIX); 

// Устанавливаем обработчик ошибок.
//$DATABASE->setErrorHandler('databaseErrorHandler');
$arr_ident["db1"]->setLogger('myLogger');
function myLogger($db, $sql)
{
  // Находим контекст вызова этого запроса.
  $caller = $db->findLibraryCaller();
  $tip = "at ".@$caller['file'].' line '.@$caller['line'];
  // Печатаем запрос (конечно, Debug_HackerConsole лучше).
   call_user_func(array('Debug_HackerConsole_Main', 'out'), "<xmp title=\"$tip\">\n\n".$sql."\n\n</xmp>");
  //echo "<xmp title=\"$tip\">"; 
 // print_r($sql); 
  //echo "</xmp>";
}

$arr_task=get_task($arr_ident);






echo "vse ok";
?>
