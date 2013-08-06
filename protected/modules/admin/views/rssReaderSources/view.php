<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Новостные Источники'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Список Источников новостей', 'url'=>array('index')),
	array('label'=>'Создать ИН', 'url'=>array('create')),
	array('label'=>'Изменить ИН', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить ИН', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить?')),
	array('label'=>'Поиск и управлене', 'url'=>array('admin')),
);
?>

<h1>Источник новостей:<?php echo $model->name."(".$model->id.")"; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'descrition',
		'link_main',
		'link_rss',
		'link_image',
		'lang',
		'managing_editor_name',
		'managing_editor_mail',
		'date_add',
		'date_edit',
		'date_rss_read',
		'ttl_time',
		'parse_active',
	),
)); ?>


<h1>Отображение новостей: <?php echo $model->name; ?></h1>



<br />
<?php foreach ($model->sources_news as $key1) {
	echo "<br />";
	echo $key1->pubDate." ";
	echo chtml::link($key1->title,array('RssReaderAll/view','id'=> $key1->link )) ;
	
}