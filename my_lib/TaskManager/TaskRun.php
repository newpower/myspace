<?php
/*
 * Библиотека обработчика задач
 * @input array data connection
 */
class TaskManager_TaskRun {

 function get_page($arr_param)
 {
 	$page=new GetPage_Main();
		echo json_encode($arr_param)."<br><br>";
		echo $arr_param['target_url'];
		
	
	
	if (isset($arr_param["http_options"]))
	{
		$page->set_http_options($arr_param["http_options"]);
	}
	if (isset($arr_param["target_url"]))
	{
		echo $page->get_page_run($arr_param["target_url"]);
	}

	echo json_encode(array('target'=>'ww','http_options'=> array('id'=>'2')));
	
 }
 