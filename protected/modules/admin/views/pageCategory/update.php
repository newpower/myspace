<?php
$this->breadcrumbs=array(
	'Page Categories'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Показать категории страниц', 'url'=>array('index')),
	array('label'=>'Создать категорию страниц', 'url'=>array('create')),
	);

?>

<h1>Изменение категории <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>