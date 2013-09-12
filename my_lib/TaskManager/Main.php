<?php
/*
 * Библиотека обработки задач
 * @input array data connection
 */
class TaskManager_Main {
	private $arr_agent;
	private $arr_task=array();
	private $arr_ident;

	function get_agent()
	{
			//Блокируем таблицы
			$this->arr_agent = $this->arr_ident["db1"]->selectRow('SELECT * FROM ?_task_manager_executor WHERE id=?', $this->arr_ident["executor_id"]);
			$this->arr_agent["role"] = $this->arr_ident["db1"]->selectCol('SELECT ?# FROM ?_task_manager_executor_role WHERE `executor_id` =?', 'name',$this->arr_agent["id"]);
	
	}

	//Конструктор класа, задаем переменные для подключения и идентификации
	function __construct($arr_param)
	{
		$this->arr_ident=$arr_param;
		if (!isset($this->arr_ident["max_time"])){
			$this->arr_ident["max_time"]=60;
		}
	}


function get_agent_as_array()
{
		if (!isset($this->arr_agent))  {
			$this->get_agent();
		}
		return $this->arr_agent;
}
function get_task()
{

	if (($this->arr_ident["db1"]) and ($this->arr_ident["executor_id"])){
		$this->arr_ident["db1"]->query('LOCK TABLES ?_task_manager_base WRITE, ?_task_manager_executor WRITE,?_task_manager_executor_role WRITE;');
		
		if (!isset($this->arr_agent))  {
			$this->get_agent();
		}

		$a=0;

		$arr_task_id=array('0'=>'0');
		while (($a < $this->arr_ident["max_time"]) and ($this->arr_agent["active"])) {
						
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

			$arr_task_one= $this->arr_ident["db1"]->selectRow($sql, $arr_task_id, $this->arr_agent["role"]);
			 if (count($arr_task_one)>0){
			 	$arr_task_id[]=$arr_task_one["id"];
				//echo $arr_task_one["id"]."string";
				$arr_update=array(
					
					'date_edit'=>date("Y-m-d H:i:s"),
					'start_executor_id'=>$this->arr_ident["executor_id"],
					'task_attempt'=>$arr_task_one["task_attempt"]+1,
				);
				if ($arr_task_one["task_attempt"] > 5){
					$arr_update["task_code"]=500;
				}
				$this->update_task_executor(array('executor_count_task_set'=> $this->arr_agent["executor_count_task_set"]+1));
				//$this->update_task($arr_update, $arr_task_one["id"]);
				
				$this->arr_task[]=$arr_task_one;
				$a=$a+$arr_task_one["task_run_minute_planned"];
			 }
			 else {
				 $a = $this->arr_ident["max_time"];
			 }
		}
	}
	$this->arr_ident["db1"]->query('UNLOCK TABLES;');
	return $this->arr_task;
}

	function update_task($arr_update,$id_task)
	{
		$this->arr_ident["db1"]->query('UPDATE ?_task_manager_base SET ?a , `date_task_start`=CURRENT_TIMESTAMP where id=?', $arr_update, $id_task);
		
	}
	function update_task_executor($arr_update)
	{
		$this->arr_ident["db1"]->query('UPDATE ?_task_manager_executor SET ?a where id=?', $arr_update, $this->arr_agent["id"]);
	}






}



?>