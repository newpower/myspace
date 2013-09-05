<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Группы источников новостей'=>array('index'),
	$model->name,
);


$this->menu=array(
	array('label'=>'Список групп источников новостей','url'=>array('index')),
	array('label'=>'Создать группу источников новостей','url'=>array('create')),
	array('label'=>'Изменить группу источников новостей','url'=>array('update','id'=>$model->id)),
	array('label'=>'Удалить группу источников новостей','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage группу источников новостей','url'=>array('admin')),
);
?>

<h1>Отображение группы: #<?php echo $model->text; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'parent_id',
		'text',
		'date_add',
		'date_edit',
	),
)); ?>

К этой группе относится:<br>
<?php 
$count=1;
foreach ($model->sources_all as $key1) {
	echo "<br />".$count.'. ';
	$count++;
	echo chtml::link($key1->name,array('/admin/RssReaderSources/view','id'=> $key1->id )) ;
}
?>