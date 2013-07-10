<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Пользователи'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Журнал Users', 'url'=>array('index')),

);
?>

<h1>Create Users</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>