<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'rss-reader-parse-text-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'domain',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'parse_text_active',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'parse_method',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'parse_text_per_begin',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'parse_text_per_end',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'parse_text_per_argument',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'parse_img_per_begin',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'parse_img_per_end',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'parse_img_per_argument',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'comment',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'date_add',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'date_edit',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
