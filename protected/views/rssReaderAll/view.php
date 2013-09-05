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

<h1><?php echo $model->title; ?></h1>
<?php 

echo CHtml::link('Опубликовать новость на agro2b',array('/RssReaderAll/check_shingls', 'id'=>$model->link)); 
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'link',
		
			  array(
            'label'=>'link',
            'type'=>'raw',
            'value'=> CHtml::link(CHtml::encode($model->link),CHtml::encode($model->link),array('target'=>'_blank')).' ID:'.$model->id.' lang:'.$model->language,
        ),	
		  array(
            'label'=>'text_news',
            'type'=>'raw',
            'value'=> $this->actionViewImage($model->url_link_json).$model->text_news,
        ),
         array(
            'label'=>'pubDate',
            'type'=>'raw',
            'value'=> $model->pubDate.', Дата скачивания: '.$model->date_add.', Edit: '.$model->date_edit,
        ),
	//	'pubDate',
		'category',
		'author',
	//	'yandex_full_text',
	//	'language',
	//	'date_add',
	//	'date_edit',
	//	'enclosure',
		'id_sources',
	//	'id',
	),
)); ?>
