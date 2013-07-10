<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>
<p>
Доступные справочники <tt> <br />
	
	
	<?php echo CHtml::link('Парсер новостей/Источники новостей',array('/admin/RssReaderSources')); 
echo "<br />";
echo CHtml::link('Парсер новостей/Новости',array('/RssReaderAll')); 

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