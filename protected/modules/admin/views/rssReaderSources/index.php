<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Новостные Источники',
);

$this->menu=array(
	array('label'=>'Создавть источник новостей', 'url'=>array('create')),
	array('label'=>'Поиск и управление ИН', 'url'=>array('admin')),
);
?>

<h1>Источники новостей (справочник новостных сайтов)</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
