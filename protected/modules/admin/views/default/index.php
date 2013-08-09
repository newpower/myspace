<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>



Доступные справочники и разделы <tt> <br />
	
	
	<?php 
	
	echo CHtml::link('Парсер новостей/Источники новостей',array('/admin/RssReaderSources')); 

echo "<br />";
echo CHtml::link('Парсер новостей/Новости',array('/RssReaderAll/admin')); 

echo "<br />";
echo CHtml::link('Страницы сайта',array('/admin/page')); 

echo "<br />-----";
echo CHtml::link('Коментарии страниц сайта',array('/admin/PageComments')); 

echo "<br />-----";
echo CHtml::link('Справочник категории',array('/admin/pageCategory')); 
echo "<br />";
	
	echo CHtml::link('Пользователи',array('/admin/Users')); 
	echo "<br />";
	echo CHtml::link('Настройки',array('/admin/setting')); 
	echo "<br />";
	
	if (Yii::app()->user->checkAccess('3')){
		echo CHtml::link('PhpMy_admin','http://agro2b.nawww.ru/phpMyAdmin/index.php',array('target'=>'_blank')); 
		echo "<br />";
		echo CHtml::link('Хостинг MIRAHUB','https://shared2.mirahub.com/manager/ispmgr',array('target'=>'_blank')); 
		echo "<br />";
		echo CHtml::link('Парсер страниц, обработки',array('/admin/rssReaderParseText')); 
		echo "<br />";
	}
	
	 ?> |<br />
	
	
	</tt>
</p>