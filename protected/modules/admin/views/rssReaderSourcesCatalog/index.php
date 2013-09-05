<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Группы источников новостей',
);

$this->menu=array(
	array('label'=>'Создание группы источников новостей','url'=>array('create')),
	array('label'=>'Manage группы источников новостей','url'=>array('admin')),
);
?>

<h1>Группы источников новостей</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
