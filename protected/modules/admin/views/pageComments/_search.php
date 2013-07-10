<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array(''=>'','0' => 'Не публиковать', '1'=>'Опубликовать', )); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'page_id'); ?>
		<?php echo $form->dropDownList($model,'page_id',Page::all(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_add'); ?>
		<?php echo $form->textField($model,'date_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_edit'); ?>
		<?php echo $form->textField($model,'date_edit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->dropDownList($model,'user_id',Users::all(),array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'guest'); ?>
		<?php echo $form->textField($model,'guest',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->