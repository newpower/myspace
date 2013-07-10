<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Комментарии к страницам'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Журнал Комментариев страниц', 'url'=>array('index')),

);
?>

<h1>Create PageComments</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>