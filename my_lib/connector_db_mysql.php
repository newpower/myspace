<?php
/*
 * Бибилтека работы с базой mysql все работы ведуться с кодировкой utf-8
 * @param array of 
 */


 
function get_connect_db($arr_param)
{
	if (!is_array($arr_param))
	{	
		$arr_param=array(
			'id'=> '1',
			'data_host'=>'93.171.202.18',
			'database'=>'user2324_main',
			'data_user'=>'user2324_nawww',
			'data_user_pass'=>'1234567aA',
		);
	}
	
	if (!$arr_param["db_connect"])
	{	
	     $db_connect = mysql_connect($arr_param["data_host"], $$arr_param["data_user"], $$arr_param["data_user_pass"])
	        or die("Could not connect : " . mysql_error());
	    //print "Connected successfully";
	   	mysql_select_db($arr_param["database"],$db_connect) or die("Could not select database");
		
	    $query = "SET NAMES utf8";
	    $result = mysql_query($query,$db_connect) or die("Query failed : " . mysql_error());
	}
	$arr_param["db_connect"]=$db_connect;
	return $arr_param;
}



?>