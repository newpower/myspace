<?php
$this->breadcrumbs=array(
	'Rss Man Ttls',
);

$this->menu=array(
	array('label'=>'Create RssManTtl', 'url'=>array('create')),
	array('label'=>'Manage RssManTtl', 'url'=>array('admin')),
);
?>

<h1>Rss Man Ttls</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
