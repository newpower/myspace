<?php
$this->breadcrumbs=array(
	'Rss Man Ttls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RssManTtl', 'url'=>array('index')),
	array('label'=>'Manage RssManTtl', 'url'=>array('admin')),
);
?>

<h1>Create RssManTtl</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>