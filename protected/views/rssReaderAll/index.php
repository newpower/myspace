<?php
$this->breadcrumbs=array(
	'БД Сборщик новостей',
);

$this->menu=array(
	array('label'=>'Create RssReaderAll', 'url'=>array('create')),
	array('label'=>'Manage RssReaderAll', 'url'=>array('admin')),
);
?>

<h1>Rss Reader Alls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
