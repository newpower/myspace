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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descrition'); ?>
		<?php echo $form->textArea($model,'descrition',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link_main'); ?>
		<?php echo $form->textField($model,'link_main',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link_rss'); ?>
		<?php echo $form->textField($model,'link_rss',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link_image'); ?>
		<?php echo $form->textField($model,'link_image',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lang'); ?>
		<?php echo $form->textField($model,'lang',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'managing_editor_name'); ?>
		<?php echo $form->textField($model,'managing_editor_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'managing_editor_mail'); ?>
		<?php echo $form->textField($model,'managing_editor_mail',array('size'=>60,'maxlength'=>255)); ?>
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
		<?php echo $form->label($model,'date_rss_read'); ?>
		<?php echo $form->textField($model,'date_rss_read'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ttl_time'); ?>
		<?php echo $form->textField($model,'ttl_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->