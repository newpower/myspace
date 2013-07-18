<?error_reporting(E_ALL);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Сравнение текстов на схожесть - алгоритм шинглов - уникальный контен - реврайт</title>
	<meta name="keywords" content="Сравнение, текстов, схожесть, уникальный, контен, реврайт, алгоритм шингл" />
	<meta name="description" content="Данный сервис позволяет сравнить два текста на уникальность после изменений." />
	<meta name="robots" content="index, follow" />
</head>
<body style="font-family: Tahoma;">

<div id="container" style="margin: 0 auto; width: 95%;">

	<h1 align="center">Получение новостей</h1>
	<div style="float: left; clear: none; width: 48%;">
	
	</div>
	<div style="float: right; width: 48%;">
	Введите RSS adress
	<br />
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<strong>Adress RSS </strong>:<br />
	<textarea id="text1" name="text1" style="width: 100%; height: 200px;"><?=isset($_POST['text1']) ? stripslashes(htmlspecialchars($_POST['url_rss'])) : ''?></textarea><br />
	
	<input type="submit" value="Получить" style="display: block; margin: 0 auto; font-weight: bold; width: 50%;" />
	</form>
	<p>
	<?php
//$rss = isset($_POST['text1']) ? $_POST['text1']:'http://agro2b.ru/ru/news/rss?source=7';
//echo "$rss";


//$target_url='http://agro2b.ru/ru/news/rss?source=7';
$target_url='https://api.hh.ru/specializations';
$userAgent='API BOT/2.1 (600541@mail.ru)';

$ch = curl_init($target_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
$resp= curl_exec($ch);

//echo $resp;


$arrayName = json_decode($resp,TRUE);
//$arrayName = array(array('specializations'=> array(array('id'=>'24.493', 'name'=>'Парикмахер'), array('id'=>'24.492', 'name'=>'Массажист'))));



$database="user2324_main"; 

			
			
    $link = mysql_connect("93.171.202.18", "user2324_nawww", "1234567aA")
        or die("Could not connect : " . mysql_error());
    print "Connected successfully";
    mysql_select_db("user2324_main") or die("Could not select database");


   // $query = "INSERT INTO `agro2b_api_hh_specializations` (`id`,`name`,`parent_id`) values ('1','1','1')";
    $query = "SET NAMES utf8";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
	
	

foreach ($arrayName as $one)
{
//	echo json_encode($arrayName)." - ".$arrayName[0]['specializations'][1]['name']." - ".$str_per;
	echo sizeof($arrayName)."KOL <br />";
	echo $one['id']." - ".$one['name']." <br /> ";
		$query = "INSERT INTO `agro2b_api_hh_specializations` (`id`,`name`,`parent_id`) values ('".$one['id']."','".$one['name']."','')";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
	foreach ($one['specializations'] as $two)
	{
	$query = "INSERT INTO `agro2b_api_hh_specializations` (`id`,`name`,`parent_id`) values ('".$two['id']."','".$two['name']."','".$one['id']."')";
    $result = mysql_query($query) or die("Query failed : " . mysql_error());
		echo $two['id']." ID ".$two['name']." <br /> ";
		
		
	}
//	echo $one[0]['specializations']['id']." ".$one[specializations][name]."  $arrayName";   
}
echo "111111111111111111111";

	?>
	</p>
	</div>
</div>
	
</body>
</html>