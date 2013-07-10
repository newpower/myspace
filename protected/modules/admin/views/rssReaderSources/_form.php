<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rss-reader-sources-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descrition'); ?>
		<?php echo $form->textArea($model,'descrition',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descrition'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link_main'); ?>
		<?php echo $form->textField($model,'link_main',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link_main'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link_rss'); ?>
		<?php echo $form->textField($model,'link_rss',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link_rss'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link_image'); ?>
		<?php echo $form->textField($model,'link_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lang'); ?>
		<?php echo $form->textField($model,'lang',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'lang'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'managing_editor_name'); ?>
		<?php echo $form->textField($model,'managing_editor_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'managing_editor_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'managing_editor_mail'); ?>
		<?php echo $form->textField($model,'managing_editor_mail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'managing_editor_mail'); ?>
	</div>

	/*<div class="row">
		<?php echo $form->labelEx($model,'date_add'); ?>
		<?php echo $form->textField($model,'date_add',array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'date_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_edit'); ?>
		<?php echo $form->textField($model,'date_edit',array('disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'date_edit'); ?>
	</div>
*/
	<div class="row">
		<?php echo $form->labelEx($model,'date_rss_read'); ?>
		<?php echo $form->textField($model,'date_rss_read'); ?>
		<?php echo $form->error($model,'date_rss_read'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ttl_time'); ?>
		<?php echo $form->DropDownList($model,'ttl_time',RssManTtl::All()); ?>
		<?php echo $form->error($model,'ttl_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->