<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Комментарии к страницам'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Журнал PageComments', 'url'=>array('index')),
	array('label'=>'Создать PageComments', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#page-comments-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление Page Comments</h1>

<p>
Вы можете использовать спец символы для быстрого поиска(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) .
</p>

<?php echo CHtml::link('Расшириный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'page-comments-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id'=>array(
			'name'=>'id',
			'headerHtmlOptions'=> array(
				'width'=>20,
			)),
		'status' => array(
			'name'=> 'status',
			'value'=> '($data->status==1)?"Опубликовать":"Не публиковать"',
						'filter' => array('0' => 'Не публиковать', '1'=>'Опубликовать', ),
		),
		'content',
		'page_id'=> array(
			'name'=> 'page_id',
			'value'=>'$data->page->title',
			'filter'=>Page::all(),
			),
		'date_add',
		'date_edit',
		'user_id' => array(
			'name'=> 'user_id',
			'value'=>'$data->user->username',
			'filter'=>Users::all(),
			),
		/*
		'guest',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
