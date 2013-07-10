<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rss-man-ttl-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->