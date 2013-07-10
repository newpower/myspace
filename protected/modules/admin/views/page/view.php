<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Страницы сайта'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Журнал страниц', 'url'=>array('index')),
	array('label'=>'Создать страницу', 'url'=>array('create')),
	array('label'=>'Ищменить страницу', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить страницу', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Page #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'content',
		'date_add',
		'date_edit',
		'status' => array(
			'name'=> 'status',
			'value'=> '($data->status==1)?"Опубликовано":"Скрыто"',

		),
		'category_id',
	),
)); ?>
