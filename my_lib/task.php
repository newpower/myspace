<?php
/*
 * Библиотека обработки задач
 */
function get_agent($arr_param)
{
			//Блокируем таблицы
		$arr_agent = $arr_param["db1"]->selectRow('SELECT * FROM ?_task_manager_executor WHERE id=?', $arr_param["executor_id"]);
		$arr_agent["role"] = $arr_param["db1"]->selectCol('SELECT ?# FROM ?_task_manager_executor_role WHERE `executor_id` =?', 'name',$arr_param["executor_id"]);
	
	return $arr_agent;
	
}
function get_task($arr_param)
{

	if (($arr_param["db1"]) and ($arr_param["executor_id"])){
		$arr_param["db1"]->query('LOCK TABLES ?_task_manager_base WRITE, ?_task_manager_executor WRITE,?_task_manager_executor_role WRITE;');
		
		$arr_agent=get_agent($arr_param);
		
		$a=0;
		$arr_task=array();
		$arr_task_id=array('0'=>'0');
		//echo "run get task".$a."-".$arr_param["max_time"];
		while (($a < $arr_param["max_time"]) and ($arr_agent["active"])) {
						
			$sql='SELECT *
				FROM ?_task_manager_base
				WHERE (
				DATE_ADD( `date_task_start` , INTERVAL `task_run_minute_planned`
				MINUTE ) <
				CURRENT_TIMESTAMP OR `date_task_start` = \'0000-00-00 00:00\'
				)
				AND `start_date` <
				CURRENT_TIMESTAMP AND `task_code` =0 
				and id not in (?a)
				and task_type in (?a)
				';

			$arr_task_one= $arr_param["db1"]->selectRow($sql, $arr_task_id, $arr_agent["role"]);
			 if (count($arr_task_one)>0){
			 	$arr_task_id[]=$arr_task_one["id"];
				//echo $arr_task_one["id"]."string";
				$arr_update=array(
					
					'date_edit'=>date("Y-m-d H:i:s"),
					'start_executor_id'=>$arr_param["executor_id"],
					'task_attempt'=>$arr_task_one["task_attempt"]+1,
				);
				if ($arr_task_one["task_attempt"] > 5){
					$arr_update["task_code"]=500;
				}
				$arr_param["db1"]->query('UPDATE ?_task_manager_base SET ?a , `date_task_start`=CURRENT_TIMESTAMP where id=?', $arr_update, $arr_task_one["id"]);
				$arr_param["db1"]->query('UPDATE ?_task_manager_executor SET executor_count_task_set=executor_count_task_set+1 where id=?', $arr_param["executor_id"]);
				
				
				$arr_task[]=$arr_task_one;
				$a=$a+$arr_task_one["task_run_minute_planned"];
			 }
			 else {
				 $a = $arr_param["max_time"];
			 }
		}
	}
$arr_param["db1"]->query('UNLOCK TABLES;');
	return $arr_task;
}

function set_task($arr_param,$arr_task_param)
{
	if (($arr_param["db1"]) and ($arr_param["executor_id"]) and ($arr_task_param["id"])){
		$arr_param["db1"]->query('LOCK TABLES ?_task_manager_base WRITE, ?_task_manager_executor WRITE,?_task_manager_executor_role WRITE;');
		
		
		$arr_agent=get_agent($arr_param);
		$sql='SELECT *
				FROM ?_task_manager_base
				WHERE (
				DATE_ADD( `date_task_start` , INTERVAL `task_run_minute_planned`
				MINUTE ) <
				CURRENT_TIMESTAMP 
				)
				and start_executor_id=?
				and id = ?
				';

			$arr_task_one= $arr_param["db1"]->selectRow($sql, $arr_param["executor_id"],$arr_task_param["id"]);
			 if (count($arr_task_one)>0){

				$arr_param["db1"]->query('UPDATE ?_task_manager_base SET ?a , `date_task_end`=CURRENT_TIMESTAMP where id=?', $arr_task_param, $arr_task_one["id"]);
				
			 	$arr_param["db1"]->query('UPDATE ?_task_manager_executor SET executor_count_task_end=executor_count_task_end+1 where id=?', $arr_param["executor_id"]);
				
				
			 }
		
		
		
		}
		else {
			echo "При установке задачи не все параметры заполнены";
		}
		$arr_param["db1"]->query('UNLOCK TABLES;');
}

?>