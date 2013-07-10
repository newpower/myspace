<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Пользователи'=>array('index'),
	$model->id=>array('password','id'=>$model->id),
	'Изменение пароля',
);

$this->menu=array(
	array('label'=>'Журнал Users', 'url'=>array('index')),
	array('label'=>'Создать Users', 'url'=>array('create')),
	array('label'=>'Показать Users', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Изменить пользователя', 'url'=>array('update', 'id'=>$model->id)),

);
?>

<h1>Изменить пароль пользователя. <?php echo $model->username; ?></h1>
Укажите пароль: <br />
<?php 
echo CHtml::form();
echo CHtml::textField('password');
echo CHtml::submitButton('Изменить пароль');
echo CHtml::endform();

?>