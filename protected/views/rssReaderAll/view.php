<?php
$this->breadcrumbs=array(
	'БД сборщик новостей'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Список новостей', 'url'=>array('index')),
	array('label'=>'Добавить новость а БД', 'url'=>array('create')),
	array('label'=>'Изменить новость', 'url'=>array('update', 'id'=>$model->link)),
	array('label'=>'Удалить новость', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->link),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Поиск и администрирование БД', 'url'=>array('admin')),
);
?>

<h1>View RssReaderAll #<?php echo $model->link; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'link',
		'title',
		'description',
		'pubDate',
		'guid',
		'category',
		'author',
		'yandex_ful_text',
		'text_news',
		'language',
		'date_add',
		'date_edit',
		'enclosure',
		'id_sources',
	),
)); ?>
