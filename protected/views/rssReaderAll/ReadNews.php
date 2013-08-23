<?php
$this->breadcrumbs=array(
	'Просмотр скаченных новостей'=>array('index'),
	'Чтение новостей',
);

$this->menu=array(
	array('label'=>'Список всех новостей1', 'url'=>array('index')),
	array('label'=>'Создать новость вручную', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rss-reader-all-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>




<h1>Просмотр скаченных новостей </h1>



<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form">
<!--<div class="search-form" style="display:none">-->
	
	
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>


</div><!-- search-form -->


<?php
echo CHtml::form();
?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rss-reader-all-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'link',
			//'value'=>'CHtml::encode(substr($data->link, 7,25)."    		\n".$data->pubDate)',
			'value'=>'CHtml::link(substr($data->link, 7,25)."    		\n".$data->pubDate,$data->link)',
			'headerHtmlOptions'=> array(
				'width'=>40,
			)),
		'title',
		'description',
		/*		'pubDate',

		'author',
		'yandex_full_text',
		'text_news',
		'language',
		'date_add',
		'date_edit',
		'enclosure',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
