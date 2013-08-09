<?error_reporting(E_ALL);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Обработка получения данных </title>

</head>
<body style="font-family: Tahoma;">

<div id="container" style="margin: 0 auto; width: 95%;">


	<div style="float: right; width: 48%;">
	Введите RSS adress

	<p>
	<?php
//$rss = isset($_POST['text1']) ? $_POST['text1']:'http://agro2b.ru/ru/news/rss?source=7';
//echo "$rss";



function get_page($target_url='https://api.hh.ru/specializations')
{
	//$target_url='http://agro2b.ru/ru/news/rss?source=7';
	
	$userAgent='API BOT/2.1 (600541@mail.ru)';
	
	$ch = curl_init($target_url);
	if (strtolower((substr($target_url,0,5))=='https'))
	{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
	}
	   
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);

	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	return curl_exec($ch); 

}

function get_connect_db($id=1)
{
	if ($id==1)
	{
		$data_host="93.171.202.18"; 
		$database="user2324_main"; 

		$data_user="user2324_nawww"; 
		$data_user_pass="1234567aA"; 	
	}
	
			
			
    $link = mysql_connect($data_host, $data_user, $data_user_pass)
        or die("Could not connect : " . mysql_error());
    print "Connected successfully";
    mysql_select_db("user2324_main") or die("Could not select database");
	
    $query = "SET NAMES utf8";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
}	
	
	
function get_hh_api_cpecializations()
{
	get_connect_db(1);
	$resp=get_page('https://api.hh.ru/specializations');
	$arrayName = json_decode($resp,TRUE);
	foreach ($arrayName as $one)
	{
	//	echo json_encode($arrayName)." - ".$arrayName[0]['specializations'][1]['name']." - ".$str_per;
		echo sizeof($arrayName)."KOL <br />";
		echo $one['id']." - ".$one['name']." <br /> ";
		$query = "INSERT INTO `agro2b_api_hh_specializations` (`id`,`name`,`parent_id`) values ('".$one['id']."','".$one['name']."','')";
	    $result = mysql_query($query) or print_r("Query failed : " . mysql_error().$query);
		
		foreach ($one['specializations'] as $two)
		{
			$query = "INSERT INTO `agro2b_api_hh_specializations` (`id`,`name`,`parent_id`) values ('".$two['id']."','".$two['name']."','".$one['id']."')";
		    $result = mysql_query($query) or print_r("Query failed : " . mysql_error().$query);
				echo $two['id']." ID ".$two['name']." <br /> ";
		
			
		}
	//	echo $one[0]['specializations']['id']." ".$one[specializations][name]."  $arrayName";   
	}
}



/**
 * view recursive function areas hh.ru from table api_hh_areas
 * @param hash data areas
 * 
 */


function recurs_view_areas($arrayName=array())
	{
		echo "-".$arrayName['id']." - ".$arrayName['name']." <br /> ";
			$query = "INSERT INTO `agro2b_api_hh_areas` (`id`,`name`,`parent_id`) values ('".$arrayName['id']."','".$arrayName['name']."',".$arrayName['parent_id'].")";
	  	    $result = mysql_query($query) or print_r("Query failed : " . mysql_error().$query);
		if (sizeof($arrayName['areas']) > 0)
		{
			foreach ($arrayName['areas'] as $one)
			{
				recurs_view_areas($one);
			}
			
		}
		
	}
	
/**
 * function view hash in tree
 * @params 1. Data hash 2. Separate (razdelitel)
 */
function recurs_view_tree_areas($arrayName=array(),$separator='-')
{
		foreach ($arrayName as $key => $one)
		{
			echo $separator."-".$key." = ";
			if (is_array($one))
			{
				echo " VALUES :  <br /> ";
				recurs_view_tree_areas($one,'-'.$separator);
			}
			else
			{
				echo "   $one <br /> ";
				}
		}
}
/**
 * Get data areas from api.hh.ru
 * @params noparam
 */
		
function get_hh_api_areas()
{

	get_connect_db(1);
	$resp=get_page('https://api.hh.ru/areas/113');
	$arrayName = json_decode($resp,TRUE);
	echo "Size All".sizeof($arrayName['areas'])."KOL <br />";
	echo $arrayName['id']." - ".$arrayName['name']." <br /> ";
	recurs_view_areas($arrayName);
}

function get_hh_api_dictionaries()
{

	get_connect_db(1);
	$resp=get_page('https://api.hh.ru/dictionaries');
	
	$arrayName = json_decode($resp,TRUE);
	
	foreach ($arrayName as $key => $one)
	{
			
		foreach ($one as $key2 => $value2) 
		{
			echo "key: $key $value2[id] $value2[name] <br>";
			$query = "INSERT INTO `agro2b_api_hh_dictionaries` (`hh_type`,`hh_id`,`hh_name`) values ('".$key."','".$value2[id]."','".$value2[name]."')";
	  	   	$result = mysql_query($query) or print_r("Query failed : " . mysql_error().$query);
			
		}
	}
}

/**
 * function return data from hash
 */
function my_get_id($arrayName,$id_param='id')
{
	return $arrayName[$id_param];	
}

/**
 * Save model hh.ru vacancy in table api_hh_vacansi
 * @param 1. Hash data, 2. kew for modify (array("id"=>"id","value"=>"11"))
 * @return no return result
 */
function f_hh_save_model_vac_list($arrayName,$iddata=array())
{
	$my_str1="";
	$my_str2="";
	$my_str3="";
	$query ="";
	$count=0;
	$srparat="";
	$query = "";
	foreach ($arrayName as $key => $value)
	{

		
		
			$count=$count+1;
			if ($count >1)
			{
				$srparat=",";
			}
		
			$my_str1=$my_str1.$srparat."`".$key."`";
			$my_str2=$my_str2.$srparat."'".$value."'";
			$my_str3=$my_str3.$srparat."`".$key."`='".$value."'";
		

		
		if (isset($iddata["id"]) and  isset($iddata["value"]))
		{
			
			$query = "UPDATE `agro2b_api_hh_vacancies` SET $my_str3 where `".$iddata["id"]."` = '".$iddata["value"]."';";
		}
		else {
			$query = "INSERT INTO `agro2b_api_hh_vacancies` ($my_str1) values ($my_str2);";
		}
		
		
	  
	}
	//echo $iddata["id"].$iddata["value"].$query;
	
	$result = mysql_query($query) or print_r("Query failed : Запись вставлена в  БД<br>");
	
}

/**
 *  getting the vacancies in the posts
 * 
 */
function get_hh_api_vacansy_list_po_specif($arrayName,$specif_id)
{
	
	$arra_exception="0";
	foreach ($arrayName as $key => $one)
	{
		$data_arr=array();
	//	url, salary_to, salary_from, currency, name, area_id, created_at, employer_url, employer_name, employer_id, 
	//type_id, id, description, schedule, accept_handicapped, experience, employment, archived
		$arra_exception=$arra_exception.",".$one["id"];
		$id_array_list[]=$one["id"];
		
		$data_arr["id"]=$one["id"];
		$data_arr["name"]=$one["name"];
		$data_arr["salary_to"]=my_get_id($one["salary"],'to');
		$data_arr["salary_from"]=my_get_id($one["salary"],'from');
		$data_arr["currency"]=my_get_id($one["salary"],'currency');
		$data_arr["area_id"]=my_get_id($one["area"],'id');
		$data_arr["created_at"]=$one["created_at"];
		$data_arr["employer_url"]=my_get_id($one["employer"],'url');
		$data_arr["employer_name"]=my_get_id($one["employer"],'name');
		$data_arr["employer_id"]=my_get_id($one["employer"],'id');
		$data_arr["type_id"]=my_get_id($one["type"],'id');
		$data_arr["specialization_id"]=$specif_id;
		
		f_hh_save_model_vac_list($data_arr);
		echo "Элемент: ".$one["id"]." обновлен. <br>";
		
		#echo "ID: $one[id] type: ".my_get_id($one[type],'id');
		#echo "<br /><br />";

	}
	return $arra_exception;
	
}


/*
 *  getting a vacancy for the position based on time of last visit
 * @param no params
 * @return no return, all informations is saved in the database
 */
function get_hh_api_vacansy_list_read()
{
	get_connect_db(1);
	//get professions that are not loaded more than 24 hours
	$query = "SELECT * FROM agro2b_api_hh_specializations where `agro2b_id` is NOT NULL and DATE_ADD(`datedownload`, INTERVAL 1440 minute) < CURRENT_TIMESTAMP limit 0,1000;";
	$result3 = mysql_query($query) or die("Query failed : " . mysql_error().$query);
  	while ($line = mysql_fetch_array($result3)) 
  	{
		
       $spec_id= $line["id"];
	   echo "SSPPCC[$spec_id]";
		$url_str='https://api.hh.ru/vacancies?areas=113&per_page=500&specialization='.$line["id"];
		
		$resp=get_page($url_str);

		$arrayName = json_decode($resp,TRUE);
		$arra_exception = get_hh_api_vacansy_list_po_specif($arrayName["items"],$line["id"]);
		
		$page=1;
		
		#Download the rest of the pages except the first
		while ($page < $arrayName["pages"])
		{

			$url_str2=$url_str."&page=".$page;
			$resp=get_page($url_str2);

			$arrayName = json_decode($resp,TRUE);
			$arra_exception = $arra_exception.get_hh_api_vacansy_list_po_specif($arrayName["items"],$line["id"]);
			$page=$page+1;
		}



		
		//echo "TTTTEEEEEEEEEEEEEEEEEEEEEEESSSSSSSSSSSSSSTTTTTTTTTT";
		$query = "update `agro2b_api_hh_vacancies` set `type_id`='closed', `need_resive`=1 where `id` not in (".$arra_exception.") and `specialization_id` = '$spec_id';";
		$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
		echo $query;
		
  		$query = "update `agro2b_api_hh_specializations` set `datedownload`=CURRENT_TIMESTAMP where `id` = '$spec_id';";
		$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
		//echo "TTTTEEEEEEEEEEEEEEEEEEEEEEESSSSSSSSSSSSSSTTTTTTTTTT".$query ;
 
   	}
	
}



	
function get_hh_api_vacansy_list_count()
{
	get_connect_db(1);
	$query = "SELECT * FROM agro2b_api_hh_specializations where 1";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
  	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
  	{
		$url_str='https://api.hh.ru/vacancies?areas=113&per_page=1&specialization='.$line["id"];
		$resp=get_page($url_str);
		$arrayName = json_decode($resp,TRUE);
		echo "\n <br />".$line["id"].";".$line["name"].";".$arrayName["found"].";";
   	}
}

get_hh_api_vacansy_list_read();
get_hh_api_vacansy_element_read();
//exit;
	
function get_hh_api_vacansy_element_read()
{
	
	
	$query = "SELECT * FROM agro2b_api_hh_vacancies where `url` is NULL limit 0,100000";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
  	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
  	{

        #print "ID $line[id] <br>\n";
		$url_str='https://api.hh.ru/vacancies/'.$line["id"];
		$resp=get_page($url_str);
		echo $url_str;
		$arrayName = json_decode($resp,TRUE);
		
		
		$data_arr=array();
		$data_arr["description"]=$arrayName["description"];
		$data_arr["url"]=$arrayName["alternate_url"];
		$data_arr["need_resive"]="1";
		
		$data_arr["dictionaries_schedule_id"]=my_get_id($arrayName["schedule"],'id');
		$data_arr["dictionaries_experience_id"]=my_get_id($arrayName["experience"],'id');
		$data_arr["dictionaries_employment_id"]=my_get_id($arrayName["employment"],'id');

		$data_arr["url"]=$arrayName["alternate_url"];
		//$data_arr["response_json"]=addslashes($resp);
		f_hh_save_model_vac_list($data_arr,array('id'=>'id','value'=>$line["id"]));
	//echo $data_arr["description"];
		//exit;
   	}
	
}
put_data_to_agro2b("http://agro2b.ru/admin/api/offer");
//exit;

function get_parent_region($id,$masret)
{
	$query = "SELECT * FROM agro2b_api_hh_vacancies where `url` is NULL limit 0,100000";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	
}
function put_data_to_agro2b($url="http://agro2b.ru/admin/api/offer")
{
	
	include_once 'my_lib/rest_client.php';
	
	get_connect_db(1);
	$cl = new RestClient();
	
	
	$query = "SELECT `id`,`agro2b_id`,`agro2b_mas_parent` FROM agro2b_api_hh_areas a;";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	$arr_areas=array();
  	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
  	{
  		$id=$line["id"];
		$arr_areas["$id"]=json_decode($line["agro2b_mas_parent"],TRUE);
		#echo $arr_areas["$id"][0]."-".$arr_areas["$id"][1]."<br>".$line["agro2b_mas_parent"].json_encode(array("5","6"))."<br>";
	}
	#exit;

	#poluchaem specializ
	$query = "SELECT * FROM agro2b_api_hh_specializations where `agro2b_id` is not null;";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	$arr_spec=array();
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		$id=$line["id"];
		$arr_spec[$id]=$line["agro2b_id"];
	}
	
	#poluchaem massiv opit
	$arr_experience=array();
	$arr_experience["noExperience"]="74";
	$arr_experience["between1And3"]="75";
	$arr_experience["between3And6"]="76";
	$arr_experience["moreThan6"]="77";
	
	#poluchaem massiv opit
	$arr_schedule=array();
	$arr_schedule["fullDay"]="71";
	$arr_schedule["shift"]="72";
	$arr_schedule["flexible"]="72";
	$arr_schedule["remote"]="73";

	#poluchaem education level
	$query = "SELECT * FROM agro2b_api_hh_dictionaries where `hh_type`='education_level';";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	$arr_educ=array();
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		$id=$line["hh_id"];
		$arr_educ[$id]=$line["hh_name"];
	}
	
	
	$query = "SELECT * FROM agro2b_api_hh_vacancies where `url` is NOT NULL and  `need_resive` = '1' ORDER BY `created_at` DESC limit 0,100000";
	$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
  	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
  	{
  		#Peremennie obnovlyaem
  		$data_param=array();
		$data_arr=array();
		
					$id_area=$line["area_id"];
  		//if (($line["type_id"]=="closed") or (isset($arr_areas["$id_area"]) === FALSE))
  		if ($line["type_id"]=="closed")
		{
			if ($line["agro2b_id"])
			{
				$url2=$url."/".$line["agro2b_id"];
				$resp=$cl->delete($url2);
				$arrayName = json_decode($resp,TRUE);
				echo $arrayName.$arrayName["status"].$arrayName["message"]."++".$resp."++";
	
				$data_arr["need_resive"]=(($arrayName["status"] == 'succcess') or ($arrayName["message"] == 'not found'))?'0':'1';
			}
			else
			{
				$data_arr["need_resive"]='0';
				
			}
		}
		else
		{

			

			$id_spec=$line["specialization_id"];
			//$data_param["division_id"]=$arr_spec["$id_spec"];	
			$id_area=$line["area_id"];
			//$data_param["region_id"]=$arr_areas["$id_area"];
			$id_experience=$line["dictionaries_experience_id"];
			//$json_arr["param_65"]=$arr_experience["$id_experience"];
			$id_dictionaries=$line["dictionaries_schedule_id"];
			//$json_arr["param_66"]=$arr_schedule["$id_dictionaries"];
	$data_param=array(	
		"division_id"=>$arr_spec["$id_spec"], //
		"user_id"=>"2145", //
		"type"=>"2",
		"status"=>"0",
		"external_url"=>$line["url"], //
		//"general[region]"=>$arr_areas["$id_area"], //
		
		"general[actual_end_at]"=>date('Y-m-j h:i:s',mktime(0, 0, 0, date("m"),   date("d")+7,   date("Y"))), //
		"created_at"=>$line["created_at"], //
		"opened_at"=>$line["created_at"], //
		
		"job[74]"=>$line["name"]." в компанию ".$line["employer_name"],//
		"job[64][min]"=>$line["salary_from"],//
		"job[64][max]"=>$line["salary_to"],//
		"job[64][min_in_rub]"=>$line["salary_from"],//
		"job[64][max_in_rub]"=>$line["salary_to"],//
		"job[64][price]"=>$line["salary_to"],//
		"job[64][currency]"=>"RUB",
		"job[66]"=>$arr_schedule["$id_dictionaries"], //
		"job[70]"=>addslashes($line["employer_name"]." приглашает <br>".$line["description"]), //
		"job[65]"=>$arr_experience["$id_experience"], //
		"job[69][textarea_contact_person]"=>$line["employer_name"], //
	);	
//echo $line["employer_name"];
	foreach ($arr_areas["$id_area"] as $key => $value) {

		if ($key > 0)
		{
			$key="general[region][".($key-1)."]";
			$data_param[$key]=$value;	
			
		}
		//echo $key."ключ и значение ".$value."<br>";
	}
//exit;

			if (!$line["agro2b_id"])
			{
				$resp=$cl->post($url,$data_param);
				//echo $resp;
				$arrayName = json_decode($resp,TRUE);
				if ($arrayName["status"] == "error")
				{
					echo "Ошибка:".$arrayName["message"]." Podr^".$resp;
					$data_param["job[70]"]="---";
					$data_arr["error"]="Ошибка:".$arrayName["message"]." Podr^".$resp."Запрос".$cl->json_encode_cyr($data_param);
					echo $cl->json_encode_cyr($data_param);
					//exit;
					
				}

				//$data_arr["need_resive"]=($arrayName["status"] == 'succcess')?'0':'1';
				$data_arr["need_resive"]='0';
				$line["agro2b_id"]=$arrayName["_id"];
				$data_arr["agro2b_id"]=$arrayName["_id"];
			}
		else
			{
				$data_arr["need_resive"]='0';
			}
			//else {
			//	$url=$url."/".$line["agro2b_id"]."?";
			//	$resp=$cl->put($url,$data_param);
			//	echo $resp;
			//	$arrayName = json_decode($resp,TRUE);
			//	$data_arr["need_resive"]=($arrayName["status"] == 'succcess')?'0':'1';
			//}


		}
		
					#echo $cl->json_encode_cyr($data_param)."<br><br><br>";
					echo $line["id"]." <br>".$cl->json_encode_cyr($data_arr)."<br><br><br>";
					
		f_hh_save_model_vac_list($data_arr,array("id"=> "id","value"=>$line["id"],));
	//	exit;
	}
}


//put_data_to_afro2b();


	?>
	</p>
	</div>
</div>
	
</body>
</html>