<?php
$this->breadcrumbs=array(
	'Rss Man Ttls'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RssManTtl', 'url'=>array('index')),
	array('label'=>'Create RssManTtl', 'url'=>array('create')),
	array('label'=>'Update RssManTtl', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RssManTtl', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RssManTtl', 'url'=>array('admin')),
);
?>

<h1>View RssManTtl #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'value',
	),
)); ?>
