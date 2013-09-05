<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Группы источников новостей'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Список группы источников новостей','url'=>array('index')),
	array('label'=>'Создание группы источников новостей','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rss-reader-sources-catalog-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
группы источников новостейRss Reader Sources Catalogs</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'rss-reader-sources-catalog-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'parent_id',
		'text',
		'date_add',
		'date_edit',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
