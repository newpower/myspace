<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Категории страниц'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Создать категорию', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('page-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление категориями страниц</h1>

<p>
Вы можете использовать след. символы (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>).
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'position',
		array(
			'class'=>'CButtonColumn',
			'viewButtonOptions'=>array('style'=>'display:none'),
			
		),
	),
)); ?>
