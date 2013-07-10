<?php
$this->breadcrumbs=array(
	'Rss Reader Alls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RssReaderAll', 'url'=>array('index')),
	array('label'=>'Manage RssReaderAll', 'url'=>array('admin')),
);
?>

<h1>Create RssReaderAll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>