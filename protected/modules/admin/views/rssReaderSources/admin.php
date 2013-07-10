<?php
$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Новостные Источники'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список источника новостей', 'url'=>array('index')),
	array('label'=>'Создать Источник новостей', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rss-reader-sources-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Поиск и управление по источникам новостей. </h1>

<p>
Вы можете использовать специальные операторы поиска(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) .
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rss-reader-sources-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'descrition',
		'link_main',
		'link_rss',
		/*	'link_image',

		'lang',
		'managing_editor_name',
		'managing_editor_mail',
		'date_add',
		'date_edit',
		'date_rss_read',
		'ttl_time',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
