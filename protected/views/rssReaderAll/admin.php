<?php
$this->breadcrumbs=array(
	'Просмотр скаченных новостей'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Список всех новостей', 'url'=>array('index')),
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
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>


</div><!-- search-form -->


<?php
echo CHtml::form();


	echo "<br />Дата поиска после";
$this->widget('zii.widgets.jui.CJuiDatePicker', array
        (
            'name'=>'RssReaderAll[dateot]', // the name of the field
            'language'=>'ru',
			'value'=>(date("Y-m-d")),  // pre-fill the value  
            'options'=>array
            (
                'showAnim'=>'fold',
         	   
                'debug'=>false,
            ),
            'htmlOptions'=>array
            (
            'style'=>'height:20px;'
            ),
        ));
		echo " Поисковое слово№1: ";
		echo CHtml::textField('seach_string1','пшеница');
		echo "<br />Дата поиска до";
 $this->widget('zii.widgets.jui.CJuiDatePicker', array
        (
            'name'=>'RssReaderAll[datedo]', // the name of the field
            'language'=>'ru',
            'value'=>(date("Y-m-d")),  // pre-fill the value
            'options'=>array
            (
                'showAnim'=>'fold',
                'dateFormat'=>'yy.mm.dd',  // optional Date formatting
                'debug'=>false,
            ),
            'htmlOptions'=>array
            (
            'style'=>'height:20px;'
            ),
        ));
		       
			   		echo " Поисковое слово№2: ";
		echo CHtml::textField('seach_string2','');
		
echo CHtml::submitButton('Быстрый поиск',array('name'=>'smal_seach'));


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
		'yandex_ful_text',
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
