<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Страницы сайта'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Журнал страниц', 'url'=>array('index')),

);
?>

<h1>Create Page</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>