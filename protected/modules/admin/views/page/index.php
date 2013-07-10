<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Страницы сайта'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Журнал страниц', 'url'=>array('index')),
	array('label'=>'Создать страницу', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#page-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление Pages</h1>

<p>
Вы можете использовать спец символы для быстрого поиска(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) .
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id'=>array(
			'name'=>'id',
			'headerHtmlOptions'=> array(
				'width'=>20,
			)),
		'title',
		'date_add',
		'date_edit',
		'status' => array(
			'name'=> 'status',
			'value'=> '($data->status==1)?"Опубликовать":"Не публиковать"',
						'filter' => array('0' => 'Не публиковать', '1'=>'Опубликовать', ),
		),
		'category_id' => array(
		
			'name'=> 'category_id',
			'value'=>'$data->category->title',
			'filter'=>PageCategory::all(),
		),
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
