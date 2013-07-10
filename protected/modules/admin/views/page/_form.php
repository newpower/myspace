<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные значком<span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php $this->widget('application.extensions.ckeditor.CKEditor', array(
		'model'=>$model, 
		'attribute'=>'content',
		 'language'=>'ru', 
		 'editorTemplate'=>'full', 
		 )); ?> 
		 
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_add'); ?>
		<?php echo $form->textField($model,'date_add'); ?>
		<?php echo $form->error($model,'date_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_edit'); ?>
		<?php echo $form->textField($model,'date_edit'); ?>
		<?php echo $form->error($model,'date_edit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', array('0' => 'Не публиковать', '1'=>'Опубликовать', )); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->DropDownList($model,'category_id',PageCategory::All()); ?>	
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->