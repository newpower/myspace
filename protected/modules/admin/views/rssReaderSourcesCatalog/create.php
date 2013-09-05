<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Группы источников новостей'=>array('index'),
	'Создание группы',
);

$this->menu=array(
	array('label'=>'Список группы источников новостей','url'=>array('index')),
	array('label'=>'Manage групп источников новостей','url'=>array('admin')),
);
?>

<h1>Создание группы источников новостей. </h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>