<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Категории страниц'=>array('index'),
	'Создание',
);

$this->menu=array(
	array('label'=>'Показать категории', 'url'=>array('index')),
	
);
?>

<h1>Создать категорию страницы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>