<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Пользователи'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменение',
);

$this->menu=array(
	array('label'=>'Журнал Users', 'url'=>array('index')),
	array('label'=>'Создать Users', 'url'=>array('create')),
	array('label'=>'Показать Users', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Изменить пароль', 'url'=>array('password', 'id'=>$model->id)),

);
?>

<h1>Update Users <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>