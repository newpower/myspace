<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Страницы сайта'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Изменение',
);

$this->menu=array(
	array('label'=>'Журнал страниц', 'url'=>array('index')),
	array('label'=>'Создать Страницу', 'url'=>array('create')),
	array('label'=>'Показать Страницу', 'url'=>array('view', 'id'=>$model->id)),

);
?>

<h1>Update Page <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>