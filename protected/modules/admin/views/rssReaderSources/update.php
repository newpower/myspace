<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Новостные Источники'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Список Источника новосей', 'url'=>array('index')),
	array('label'=>'Создать ИН', 'url'=>array('create')),
	array('label'=>'Показать Источники новостей', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Поиск и управление', 'url'=>array('admin')),
);
?>

<h1>Update RssReaderSources <?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Основное', 'url'=>'#', 'active'=>true),
        array('label'=>'Парсинг', 'url'=>array('updateParse', 'id'=>$model->id)),
        array('label'=>'прочее', 'url'=>'#'),
    ),
)); ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

	

