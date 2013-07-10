<?php
$this->breadcrumbs=array(
	'Rss Reader Alls'=>array('index'),
	$model->title=>array('view','id'=>$model->link),
	'Update',
);

$this->menu=array(
	array('label'=>'List RssReaderAll', 'url'=>array('index')),
	array('label'=>'Create RssReaderAll', 'url'=>array('create')),
	array('label'=>'View RssReaderAll', 'url'=>array('view', 'id'=>$model->link)),
	array('label'=>'Manage RssReaderAll', 'url'=>array('admin')),
);
?>

<h1>Update RssReaderAll <?php echo $model->link; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>