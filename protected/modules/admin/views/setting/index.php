<?php
/* @var $this SettingController */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Setting',
);
?>
<h1>Настройки</h1>

<?php if(Yii::app()->user->hasFlash('Setting')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('Setting'); ?>
</div>

<?php endif; ?>
	
	
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'page-Setting-form',
	'enableAjaxValidation'=>false,
)); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'defaultStatusComent'); ?>
		<?php echo $form->checkBox($model,'defaultStatusComent'); ?>
		<?php echo $form->error($model,'defaultStatusComent'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'defaultStatusUser'); ?>
		<?php echo $form->checkBox($model,'defaultStatusUser'); ?>
		<?php echo $form->error($model,'defaultStatusUser'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->