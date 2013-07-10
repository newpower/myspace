 <?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>
<?php if(Yii::app()->user->hasFlash('registration')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>

<?php else: ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля отмеченные значком<span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
        <?php echo $form->error($model,'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'realname'); ?>
        <?php echo $form->textField($model,'realname',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'realname'); ?>
    </div>
    
    <?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Регистрация' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>
<?php endif; ?>

</div><!-- form --> 