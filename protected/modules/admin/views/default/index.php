<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>



Доступные справочники <tt> <br />
	
	
	<?php echo CHtml::link('Парсер новостей/Источники новостей',array('/admin/RssReaderSources')); 
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
	
	
	
	 ?> |<br />
	
	
	</tt>
</p>