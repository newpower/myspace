<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Комментарии к страницам'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Журнал комментарий', 'url'=>array('index')),
	array('label'=>'Создать комментарий', 'url'=>array('create')),
	array('label'=>'Ищменить комментарий', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить комментарий', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),

	);
?>

<h1>View PageComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'content',
		'page_id',
		'date_add',
		'date_edit',
		'user_id',
		'guest',
	),
)); ?>
