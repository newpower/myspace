<?php
$this->breadcrumbs=array(
	'Rss Reader Parse Texts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List RssReaderParseText','url'=>array('index')),
	array('label'=>'Create RssReaderParseText','url'=>array('create')),
	array('label'=>'View RssReaderParseText','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage RssReaderParseText','url'=>array('admin')),
);
?>

<h1>Update RssReaderParseText <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>