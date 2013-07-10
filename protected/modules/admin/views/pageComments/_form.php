<?php
/* @var $this PageCommentsController */
/* @var $model PageComments */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-comments-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные значком<span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array('0' => 'Не публиковать', '1'=>'Опубликовать', )); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'page_id'); ?>
		<?php echo $form->textField($model,'page_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'page_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'date_edit'); ?>
		<?php echo CHtml::encode($model->date_add); ?>|
		
		<?php echo $form->labelEx($model,'date_add'); ?>
		<?php echo CHtml::encode($model->date_add); ?>

	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'guest'); ?>
		<?php echo $form->textField($model,'guest',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'guest'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->