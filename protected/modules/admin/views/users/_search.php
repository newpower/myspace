<?php
/* @var $this UsersController */
/* @var $model Users */
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
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateadd'); ?>
		<?php echo $form->textField($model,'date_add'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dateedit'); ?>
		<?php echo $form->textField($model,'date_edit'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'flag_ban'); ?>
		<?php echo $form->dropDownList($model,'flag_ban',array(''=>'','0' => 'Заблокирован', '1'=>'Не заблокирован', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role',array(''=>'','1' => 'Пользователь', '2'=>'Администратор', )); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->