<?error_reporting(E_ALL);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Обработка получения данных </title>

</head>
<body style="font-family: Tahoma;">


	<p>
<?php

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

	include 'my_lib/rest_client.php';
	
		downloads_and_parse(); 
	

function functionName($value='')
{
	$url="http://agro2b.ru/admin/api/offer";
	
	$cl = new RestClient();
	
	$data_param=array(
		"division_id"=>"45111",
		"user_id"=>"2145",
		"type"=>"1",
		"status"=>"1",
		"external_url"=>"http://www.hh.ru/id/33333",
		"general[region][]"=>"272177",
		"general[actual_end_at]"=>"2013-08-05 20:20:11",
		"job[74]"=>"VJDD7Q Пример должности",
		"job[64][min]"=>"10000",
		"job[64][max]"=>"12000",
		"job[64][min_in_rub]"=>"10000",
		"job[64][max_in_rub]"=>"12000",
		"job[64][price]"=>"12000",
		"job[64][currency]"=>"RUB",
		"job[70]"=>"D7DОписание новой вакансии",
		"job[65]"=>"74",
		
	);
	echo "Состояние до<br>";
	$resp=$cl->put($url."/51f8980deea4fe9728000000?user_id=2145",$data_param);
	//$resp=$cl->post($url,$data_param);
	echo $resp."<br><br><br><br>";
	

	//51f20e0eeea4fe8537000000
	

	$resp=$cl->get($url."/51f24666eea4fee938000000",$data_param);
	echo $resp."<br><br><br><br>";
}
	
	/**
	 * function transformate format data rss rfc2822 in time sql
	 * @param string data rfc2822
	 * @return date format time sql
	 */
function Rfc2822ToTimestamp($date){
	 $aMonth = array(
	             "Jan"=>"1", "Feb"=>"2", "Mar"=>"3", "Apr"=>"4", "May"=>"5",
	             "Jun"=>"6", "Jul"=>"7", "Aug"=>"8", "Sep"=>"9", "Oct"=>"10",
	             "Nov"=>"11", "Dec"=>"12",
	             "янв"=>"1", "фев"=>"2", "мар"=>"3", "апр"=>"4", "май"=>"5",
	             "июн"=>"6", "июл"=>"7", "авг"=>"8", "сен"=>"9", "окт"=>"10",
	             "ноя"=>"11", "дек"=>"12",
				 );
		//26 Jul 2013 10:51:00 +0400
	if (strlen($date) <= 27)
		{
			//list($day, $month, $year, $time) = explode(" ", $date);
			$date="Fri, ".$date;
			
		}
		
	list( , $day, $month, $year, $time) = explode(" ", $date);
	list($hour, $min, $sec) = explode(":", $time);
	$month = $aMonth[$month];

	$returndate=$year."-".$month."-".$day." ".$hour.":".$min.":".$sec;
	//	 echo "СТАРОЕ ".$date." НОВОЕ".$returndate."<br>";
	return  $returndate;
}




/**
 * function remove tags
 * @param text string
 * @return text string
 */
function remove_tag($text)
{
	$search = array ("'<script***91;^>***93;*?>.*?</script>'si",  // Вырезает javaScript
                 "'<***91;\/\!***93;*?***91;^<>***93;*?>'si",           // Вырезает HTML-теги
                 "'(***91;\r\n***93;)***91;\s***93;+'",                 // Вырезает пробельные символы
                 "'&(quot|#34);'i",                 // Заменяет HTML-сущности
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // интерпретировать как php-код

	$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

	return str_replace($search, $replace, $text); 
}


//main_test();

function main_test()
{
	$text2=get_page("http://www.komitet2-20.km.duma.gov.ru/rss.xp");
			
		
	$xml= simplexml_load_string($text2);
	$count_new=0;

	foreach ($xml->channel->item as $news)
	{
		//link, title, description, pubDate, guid, category, author, yandex_full_text, text_news, language, date_add, date_edit, enclosure, id_sources, comments
		
		$arraymodelnews["pubDate"]=Rfc2822ToTimestamp($news->pubDate);
		$arraymodelnews["title"]=$news->title;
		$arraymodelnews["description"]=$news->description;
		echo "Заголовок:".$arraymodelnews["title"]."текст <hr>";
		echo $arraymodelnews["description"]." КОНЕЦ ТЕКСТА <br><hr><hr>";

echo $news->link."<br>";
		$text=get_news_text_from_site($news->link);
		

exit;
	}
}


/**
 * Set news text in table rss_reader_all
 */
function set_news_text()
{
	get_connect_db(1);
	$query = "SELECT * FROM `agro2b_rss_reader_all` `all` left join `agro2b_rss_reader_sources` `sources` on `all`.`id_sources`= `sources`.`id` where `text_news` is null limit 0,100;";
	
	$result_all = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	
  	while ($line = mysql_fetch_array($result_all, MYSQL_ASSOC)) 
	{
		echo "Страница новости:".$line["link"]."<br />";
		$count=0;
		$arr_fields=get_news_text_from_site($line);
		

		set_news($arr_fields,array("id"=> "link","value"=>$line["link"]));
		echo "<meta http-equiv=\"refresh\" content=\"1\">";
		echo "<iframe src=\"".$line["link"]."\" height='900' width='1200'></iframe> ";
	exit;
	}
}
set_news_text();
//get_news_text_from_site("http://www.admlr.lipetsk.ru/rus/news/index.php?idxShowNew=71e8f1e0f7ef6381d9b6be671e1b0ac8");

function get_news_text_from_site($model_parse)
{
	$url=$model_parse["link"];
	$arr_arg=array("active"=>"0");

	if ($model_parse["parse_active"])
	{
		$arr_arg=array(
			"active"=>"1",
			"method"=>$model_parse["parse_method"],
			"per_begin"=>$model_parse["parse_per_begin"],
			"per_argument"=>$model_parse["parse_per_argument"],
			"per_end"=>$model_parse["parse_per_end"],
			);
		//echo $model_parse["parse_per_begin"];
	}

	/*if (strpos("HH".$url, "zol.ru/z-news/") > 0)
	{
		$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class=news_content]",
			"per_argument"=>"0",
			"per_end"=>"",
			);

	}
	elseif (strpos("HH".$url, "agronews.ru/news") > 0)
		{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class=text-block]",
			"per_argument"=>"0",
			"per_end"=>"Количество просмотров материала",
			);
	}
	elseif (strpos("HH".$url, "regnum.ru/") > 0)
	{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class=newsbody]",
			"per_argument"=>"0",
			"per_end"=>"",
			);
		
	}
	elseif (strpos("HH".$url, "admlr.lipetsk.ru/rus/news/") > 0)
	{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class=nbody]",
			"per_argument"=>"0",
			"per_end"=>"",
			);
	}
		elseif (strpos("HH".$url, "fsvps.ru/fsvps/news/") > 0)
	{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class='newsitem']",
			"per_argument"=>"0",
			"per_end"=>"",
			); //newsitem
	}
	elseif (strpos("HH".$url, "komitet2-20.km.duma.gov.ru/") > 0)
	{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class='st']",
			"per_argument"=>"0",
			"per_end"=>"",
			);
	}
	elseif (strpos("HH".$url, "dairynews.ru/news/") > 0)
	{
			$arr_arg=array(
			"active"=>"1",
			"method"=>"div_and",
			"per_begin"=>"div[class='nnew-detail']",
			"per_argument"=>"0",
			"per_end"=>"",
			);
	}
	else*/
	
	if (strpos("HH".$url, "yandex.ru/") > 0)
	{
		$arr_param = array("text_news" => "yandex_text",);
			return $arr_param;
		
	}

		if ($arr_arg["active"])
		{
			include_once 'my_lib/simple_html_dom.php';
			
			$html = str_get_html(to_utf8(get_page($url)));
				
			$per_begin=$arr_arg["per_begin"];
			$per_argument=$arr_arg["per_argument"];
			$per_end=$arr_arg["per_end"];	
				
			if ($arr_arg["method"] == "div_and")
			{
				$ret = $html->find($per_begin);
				$text= $ret["$per_argument"];	
				
				
				
				
			}
			
			
			if ($per_end)
			{
				$prmat='# (.*)'.$per_end.'#isU';
				preg_match($prmat, $text, $b);
				$text = (isset($b["0"])) ? trim($b["0"]) : "" ;
				//$text = trim($b["0"]);
			}
			
			
			$html = str_get_html($text);
			$arr_img_url=array();
			
			$cl = new RestClient();
			foreach($html->find('img') as $div)
			{
				echo $cl->url_to_absolute($url, $div->src)."<br>";
				
				array_push($arr_img_url,array("src"=> $cl->url_to_absolute($url, $div->src),"alt"=>$div->alt,"title"=>$div->title));
			}
 

			
			$text=delete_adv_list($text);
			
			
			$text=strip_tags($text);
			$text=preg_replace("'\n'isu", "<br />\n", $text);
			echo $url."<br>uu"."$text";
			//echo "<br />";
			// preg_replace("'\n'isu", "<br />", $text);
		
			
			$newparam = (sizeof($arr_img_url) > 0) ? $cl->json_encode_cyr($arr_img_url) : "" ;
			//$newparam="";
			$arr_param = array("text_news" => $text,"url_link_json"=>$newparam);
			return $arr_param;
		}
	
}
function delete_adv_list($document)
{
	
	/* $prmat="'<noindex[^>]*?>.*?</noindex>'isu";
	preg_match($prmat, $document, $b);

				$text= trim($b["0"]);
				echo $text; */
				

		$search = array (
			"'<noindex[^>]*?>.*?</noindex>'isu",  // Вырезает noindex
			"'<h1[^>]*?>.*?</h1>'isu",  
			"#\$\(document\).*?\}\)\;#isu",  
			"'</div>'isu",  
			"'</p>'isu",  
			"'<br>'isu",  
			"'<br />'isu",  
		);                    
	
	$replace = array (" ",
	" ",
	" ",
	"\n",
	"\n",
	"\n",
	"\n",
	 );
	
	return preg_replace($search, $replace, $document);
	
}
function to_utf8($text_html)
{
	preg_match("#.*meta.*(?:charset=(?:\b|\"|\'|\s)(.{3,})(?:\"|\'|\s|>|;))#isU", $text_html, $a);
	$kodirovka = trim($a["1"]);
	//echo $kodirovka;
	strstr($kodirovka, '1251') ? $text_html = iconv($kodirovka, 'UTF-8', $text_html) : ''; 
	return $text_html;
}

function downloads_and_parse()
{
	get_connect_db(1);
	$query = "SELECT *,DATE_ADD(`date_rss_read`, INTERVAL `ttl_time` minute) as `date_new_read` from `agro2b_rss_reader_sources` where DATE_ADD(`date_rss_read`, INTERVAL `ttl_time` minute) < CURRENT_TIMESTAMP limit 0,1000;";
	
	$result_all = mysql_query($query) or die("Query failed : " . mysql_error().$query);
	
  	while ($line = mysql_fetch_array($result_all, MYSQL_ASSOC)) 
	{
		$count=0;
  		if ($line["link_rss"]) 
  		{
			$count=reader_rss_my($line);
		}
		else 
		{
			
		}
		echo "Ресурс:".$line["link_rss"]." NEWS NEW:".$count."<br>";
		$query = "UPDATE `agro2b_rss_reader_sources` SET `date_rss_read`=CURRENT_TIMESTAMP where `id` = '".$line["id"]."' limit 1;";
	
		$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
		
		$query = "INSERT INTO `agro2b_rss_new_statistics` (`id_rss_cources`, `count_new`, `date_add`, `date_edit`) values ('".$line["id"]."', '".$count."',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP);";
		$result = mysql_query($query) or die("Query failed : " . mysql_error().$query);
  
    }
}
function reader_rss_my($arraydata)
{
	$arraymodelnews=array();
		//id, name, descrition, link_main, link_rss, link_image, lang, managing_editor_name, managing_editor_mail, date_add, date_edit, date_rss_read, ttl_time
	$bodytag = str_replace("yandex:full-text", "yandex_full_text", get_page($arraydata["link_rss"]));
	
	$xml= simplexml_load_string($bodytag);
	$count_new=0;
	 
	//foreach ($xml->channel as $news)
	//{
	//	echo '<B><u>'.$news->title.'</u></b> ';
		//echo '('.$sort->lastBuildDate.')<BR><BR>';
	//}

	foreach ($xml->channel->item as $news)
	{
		//link, title, description, pubDate, guid, category, author, yandex_full_text, text_news, language, date_add, date_edit, enclosure, id_sources, comments
		
		$arraymodelnews["pubDate"]=Rfc2822ToTimestamp($news->pubDate);
		$arraymodelnews["yandex_full_text"]=$news->yandex_full_text;
		$arraymodelnews["description"]=$news->description;
		$arraymodelnews["title"]=$news->title;
		$arraymodelnews["link"]=$news->link;
		$arraymodelnews["guid"]=$news->guid;
		$arraymodelnews["category"]=$news->category;
		$arraymodelnews["author"]=$news->author;
		$arraymodelnews["language"]=$arraydata["lang"];
		$arraymodelnews["id_sources"]=$arraydata["id"];
		$arraymodelnews["date_add"]=date("Y-m-d H:i:s");
		$arraymodelnews["date_edit"]=date("Y-m-d H:i:s");
		


		//echo $news->title.' - '.Rfc2822ToTimestamp($news->pubDate).$arraydata["link_rss"].'<BR><hr>';

		//foreach ($news as $key=>$value)
		//foreach ($arraymodelnews as $key=>$value)
		//{ 
			//	echo $key.' - '.$value.'<BR><BR>';
		//}
		$count_new=$count_new+set_news($arraymodelnews);
		
		
	}
return $count_new;
	//exit;
	
}

function set_news($news=array(),$iddata=array())
{
	$my_str1="";
	$my_str2="";
	$my_str3="";
	$query ="";
	$count=0;
	$srparat="";
	
	foreach ($news as $key => $value)
	{
			$count=$count+1;
			if ($count >1){	$srparat=",";}
			if (strlen($value) > 0)
			{
				$my_str1=$my_str1.$srparat."`".addslashes($key)."`";
				$my_str2=$my_str2.$srparat."'".addslashes($value)."'";
				$my_str3=$my_str3.$srparat."`".addslashes($key)."`='".addslashes($value)."'";
			}
			
		if (isset($iddata["id"]) and  isset($iddata["value"]))
		{
			
			$query = "UPDATE `agro2b_rss_reader_all` SET $my_str3 where `".$iddata["id"]."` = '".$iddata["value"]."';";
		}
		else {
			$query = "INSERT INTO `agro2b_rss_reader_all` ($my_str1) values ($my_str2);";
		}
	}
	$count_new=1;
	//echo $query;
	$result = mysql_query($query) or $count_new=0;
	return $count_new;
}


function get_main2()
{

	$feed = 'http://agro2b.ru/ru/rss/yandex';
	
	$bodytag = str_replace("yandex:full-text", "yandex_full_text", get_page($feed));
	
	$xml= simplexml_load_string($bodytag);
	 
	 
	foreach ($xml->channel as $news)
	{
		echo '<B><u>'.$news->title.'</u></b> ';
		//echo '('.$sort->lastBuildDate.')<BR><BR>';
	}
		 echo "PPPPPPPPPPPPPPPPPPPPPPP<br>";
	foreach ($xml->channel->item as $news)
	{
		echo $news->title.' - '.Rfc2822ToTimestamp($news->pubDate).'<BR><hr>';
		
		foreach ($news as $key=>$value)
		{ 
				echo $key.' - '.$value.'<BR><BR>';
		}
			
		echo $news["description"].'<BR><BR>';
		echo $news["yandex:full-text"].'<BR><BR>';
	}
	
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
?>