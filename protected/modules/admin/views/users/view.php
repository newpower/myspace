<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Пользователи'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Журнал Users', 'url'=>array('index')),
	array('label'=>'Создать Users', 'url'=>array('create')),
	array('label'=>'Ищменить Users', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить Users', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Изменить пароль', 'url'=>array('password', 'id'=>$model->id)),
	);
?>

<h1>View Users #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'date_add',
		'date_edit',
		'flag_ban',
		'role',
		'email',
	),
)); ?>
