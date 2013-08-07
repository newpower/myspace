<?php
$this->breadcrumbs=array(
	'Rss Reader Parse Texts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RssReaderParseText','url'=>array('index')),
	array('label'=>'Manage RssReaderParseText','url'=>array('admin')),
);
?>

<h1>Create RssReaderParseText</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>