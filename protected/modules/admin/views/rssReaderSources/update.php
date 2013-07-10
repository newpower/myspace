<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Новостные Источники'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список Источника новосей', 'url'=>array('index')),
	array('label'=>'Создать ИН', 'url'=>array('create')),
	array('label'=>'Показать Источники новостей', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Поиск и управление', 'url'=>array('admin')),
);
?>

<h1>Update RssReaderSources <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>