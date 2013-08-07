<?php
$this->breadcrumbs=array(
	'Rss Reader Parse Texts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List RssReaderParseText','url'=>array('index')),
	array('label'=>'Create RssReaderParseText','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rss-reader-parse-text-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Rss Reader Parse Texts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'rss-reader-parse-text-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'domain',
		'parse_text_active',
		'parse_method',
		'parse_text_per_begin',
		'parse_text_per_end',
		/*
		'parse_text_per_argument',
		'parse_img_per_begin',
		'parse_img_per_end',
		'parse_img_per_argument',
		'comment',
		'date_add',
		'date_edit',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
