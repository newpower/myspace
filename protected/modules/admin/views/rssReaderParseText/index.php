<?php
$this->breadcrumbs=array(
	'Rss Reader Parse Texts',
);

$this->menu=array(
	array('label'=>'Create RssReaderParseText','url'=>array('create')),
	array('label'=>'Manage RssReaderParseText','url'=>array('admin')),
);
?>

<h1>Rss Reader Parse Texts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
