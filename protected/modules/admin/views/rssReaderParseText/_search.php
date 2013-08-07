<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

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
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
