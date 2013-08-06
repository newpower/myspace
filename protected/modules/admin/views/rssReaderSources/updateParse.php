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

<h1>Изменение характеристик парсинга источника новостей<?php echo $model->id; ?></h1>



<?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Основное', 'url'=>array('update', 'id'=>$model->id), ),
        array('label'=>'Парсинг', 'url'=>'#','active'=>true),
        array('label'=>'прочее', 'url'=>'#'),
    ),
)); ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rss-reader-sources-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); ?>
    

    

	

	<div class="row">
		<?php echo $form->labelEx($model,'link_news'); ?>
		<?php echo $form->textField($model,'link_news',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link_news'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'parse_method'); ?>
		<?php echo $form->textField($model,'parse_method',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'parse_method'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'parse_per_begin'); ?>
		<?php echo $form->textField($model,'parse_per_begin',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'parse_per_begin'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'parse_per_end'); ?>
		<?php echo $form->textField($model,'parse_per_end',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'parse_per_end'); ?>
	</div>	
	<div class="row">
		<?php echo $form->labelEx($model,'parse_active'); ?>
		<?php echo $form->textField($model,'parse_active',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'parse_active'); ?>
	</div>		
	<div class="row">
		<?php echo $form->labelEx($model,'parse_per_argument'); ?>
		<?php echo $form->textField($model,'parse_per_argument',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'parse_per_argument'); ?>
	</div>		
	
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>
	
</div>


<?php $this->endWidget(); ?>

