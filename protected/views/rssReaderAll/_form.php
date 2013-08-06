<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rss-reader-all-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pubDate'); ?>
		<?php echo $form->textField($model,'pubDate'); ?>
		<?php echo $form->error($model,'pubDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'guid'); ?>
		<?php echo $form->textField($model,'guid',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'guid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'category'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'yandex_full_text'); ?>
		<?php echo $form->textArea($model,'yandex_full_text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'yandex_full_text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_news'); ?>
		<?php echo $form->textArea($model,'text_news',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_news'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->textField($model,'language',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'language'); ?>
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
		<?php echo $form->labelEx($model,'enclosure'); ?>
		<?php echo $form->textField($model,'enclosure',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'enclosure'); ?>
	</div>
		<div class="row">
		<?php echo $form->labelEx($model,'sources'); ?>
		<?php echo $form->DropDownList($model,'sources',RssReaderSources::All()); ?>
		<?php echo $form->error($model,'sources'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->