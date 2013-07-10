<?php
$this->breadcrumbs=array(
	'Rss Man Ttls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RssManTtl', 'url'=>array('index')),
	array('label'=>'Create RssManTtl', 'url'=>array('create')),
	array('label'=>'View RssManTtl', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage RssManTtl', 'url'=>array('admin')),
);
?>

<h1>Update RssManTtl <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>