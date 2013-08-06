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

	<h1 align="center">Сравнение текстов на схожесть</h1>
	<div style="float: left; clear: none; width: 48%;">
	

	Что может произойти если поисковик <a href="http://google.com" target="_top">Google</a> или <a href="http://yandex.ru" target="_top">Яндекс</a> определит, что ваш текст
	"позаимствован" с другого сайта?<br />
	Ваш ресурс может не попасть в результаты поиска.
	</p>
	<p>
	Как же поисковые машины определяют схожесть текстов?<br />
	Существует "<strong>алгоритм шинглов</strong>" (shingles-Шинглы), позволяющий простой <strong>проверкой
	двух текстов</strong> убедиться, что между ними есть связь.
	</p>
	

	<p>
	Для проверки вам необходим оригинал текста и переделанная (реврайт) копия.
	</p>
	
		<p>
После нажатия на кнопку проверить, отоброзится результат 4 проходов:<br />
Необходимо смотреть 2,3 проход (количетсов слов в шингле 2,3) а так же с учетом размера:<br />


Чтобы процент схожести был желательно менше 50.<br>

* Показатель "С учетом процентов", может привышать показатель 100<br />

<br /><b>Как необходимо работать с программой: </b><br />
1. Необходимо, в первое поле ввести исходный текст, во второе измененный текст.
<br /> 2. Нажать кнопку "СРАВНИТЬ"
<br /> 3. Просмотреть результат сравнения:
<br /> 4.Если мы не изменяли размер текста в меньшую сторону (к примеру исходный текст 100 слов, после репоста 50 слов), то необходимо смотреть на процент схожести, если изменяли в меньшую сторону то нужно смотреть на показател "С учетом размеров"

	</p>
	<p>Реализовал алгоритм Е.И.Феофанов
	</p>

	</div>
	<div style="float: right; width: 48%;">
	

	<br />
	<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
	<strong>Оригинальный текст</strong>:<br />
	<textarea id="text1" name="text1" style="width: 100%; height: 200px;"><?=isset($_POST['text1']) ? stripslashes(htmlspecialchars($_POST['text1'])) : ''?></textarea><br />
	<strong>Переделанная (реврайт) копия</strong>:<br />
	<textarea id="text2" name="text2" style="width: 100%; height: 200px;"><?=isset($_POST['text2']) ? stripslashes(htmlspecialchars($_POST['text2'])) : ''?></textarea><br />
	<br />
	<input type="submit" value="Сравнить" style="display: block; margin: 0 auto; font-weight: bold; width: 50%;" />
	</form>
	<p>
	<?php
	function get_shingle($text,$n=3) {
	    $shingles = array();
	    $text = clean_text($text);
	    $elements = explode(" ",$text);
	    for ($i=0;$i<(count($elements)-$n+1);$i++) {
	        $shingle = '';
	        for ($j=0;$j<$n;$j++){
	            $shingle .= mb_strtolower(trim($elements[$i+$j]), 'UTF-8')." ";
	        }
	        if(strlen(trim($shingle)))
	        	$shingles[$i] = trim($shingle, ' -');
	    }
	    return $shingles;    
	}
	
	function clean_text($text) {
	    $new_text = eregi_replace("[\,|\.|\'|\"|\\|\/]","",$text);
	    $new_text = eregi_replace("[\n|\t]"," ",$new_text);
	    $new_text = preg_replace('/(\s\s+)/', ' ', trim($new_text));
	    return $new_text;
	}
	
	function check_it($first, $second) {
		if (!$first || !$second) {
		    echo "Отсутствуют оба или один из текстов!";
		    return 0;
		}
		
		if (strlen($first)>200000 || strlen($second)>200000) {
		    echo "Длина обоих или одного из текстов превысила допустимую!";
		    return 0;
		}
		
		echo "Процент сходимости по методу similar: ".similar_text($first,$second)."<br />";
		for ($i=1;$i<5;$i++) {
		    $first_shingles = array_unique(get_shingle($first,$i));

			
			
		    $second_shingles = array_unique(get_shingle($second,$i));
		
			if(count($first_shingles) < $i-1 || count($second_shingles) < $i-1) {
				echo "Количество слов в тексте меньше чем длинна шинглы<br />";
				continue;
			}
		    
		    $intersect = array_intersect($first_shingles,$second_shingles);

		    
		    $merge = array_unique(array_merge($first_shingles,$second_shingles));
									foreach ( $merge as $one)
			{
			#	echo $one."sdddddddddddddddddddddddddddddddddddddddddddddd<br>\n";	
				
			}
			

		    
		   	$diff = (count($intersect)/count($merge))/0.01;
	
			if (strlen($first) > strlen($second))
			{
				
				$koe=strlen($first)/strlen($second);
			}
			else {
				$koe=strlen($second)/strlen($first);
			}
			
			$new_diff =$koe*$diff;    
			echo "Количество слов в шингле - $i. Процент схожести - <b>".round($diff, 2)."</b>% с учетом размеров <b>".round($new_diff, 2)."</b>у.е.<br />";
		}
	}

	if (isset($_POST['text1']) && isset($_POST['text2'])) {
		check_it(strip_tags($_POST['text1']), strip_tags($_POST['text2']));
	}
	?>
	</p>
	</div>
</div>
	
</body>
</html>