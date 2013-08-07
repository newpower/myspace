<?php
$this->breadcrumbs=array(
	'Rss Reader Parse Texts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RssReaderParseText','url'=>array('index')),
	array('label'=>'Create RssReaderParseText','url'=>array('create')),
	array('label'=>'Update RssReaderParseText','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete RssReaderParseText','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RssReaderParseText','url'=>array('admin')),
);
?>

<h1>View RssReaderParseText #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'domain',
		'parse_text_active',
		'parse_method',
		'parse_text_per_begin',
		'parse_text_per_end',
		'parse_text_per_argument',
		'parse_img_per_begin',
		'parse_img_per_end',
		'parse_img_per_argument',
		'comment',
		'date_add',
		'date_edit',
	),
)); ?>
