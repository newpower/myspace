<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Комментарии к страницам'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменение',
);

$this->menu=array(
	array('label'=>'Журнал PageComments', 'url'=>array('index')),
	array('label'=>'Создать PageComments', 'url'=>array('create')),
	array('label'=>'Показать PageComments', 'url'=>array('view', 'id'=>$model->id)),

);
?>

<h1>Update PageComments <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>