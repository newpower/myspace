<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Группы источников новостей'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RssReaderSourcesCatalog','url'=>array('index')),
	array('label'=>'Create RssReaderSourcesCatalog','url'=>array('create')),
	array('label'=>'View RssReaderSourcesCatalog','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage RssReaderSourcesCatalog','url'=>array('admin')),
);
?>

<h1>Update RssReaderSourcesCatalog <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>