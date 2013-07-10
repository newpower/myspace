<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
		'Новостные Источники'=>array('index'),
	'Создать ИН',
);

$this->menu=array(
	array('label'=>'Показать список Источника новостей', 'url'=>array('index')),
	array('label'=>'Поиск и управление ИН', 'url'=>array('admin')),
);
?>

<h1>Создать элемент справочнка источник новостей</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>