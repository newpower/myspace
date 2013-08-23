<style>

	.tree-column {
		float: left;
		width: 205px;
		height: 100%;
		border-right: 1px solid #B0B0B0;
		padding-right: 10px;
		margin: 0 10px 10px -6px;
	}

	.tree-column ul {
		padding-left: 0px;
		margin-top: 0;
		list-style: none;
	}

	.tree-column ul li {
		padding: 0 0 2px 16px;
		position: relative;
		
	}

	.tree-column ul ul {
		padding-top: 3px;
		padding-bottom: 1px;
	}

	.tree-column span.bullet {
		display: block;
		position: absolute;
		top: 0.4em;
		left: 4px;
		width: 5px;
		height: 5px;
		background: #555;
		border-radius: 2.5px;
		-moz-border-radius: 2.5px;
		-webkit-border-radius: 2.5px;
	}

	.tree-column ul li a + span.bullet {
		display: none;
	}

	.tree-column a {
		display: inline-block;
	}

	.tree-column a+a {

	}

	.tree-column a.expand_btn {
		display: block;
		position: absolute;
		top: 2px;
		left: 0px;
		width: 12px;
		height: 12px;
		background: #F2F2F2;
		text-align: center;
		line-height: 12px;
		text-decoration: none;
		color: #555;
	}

	.tree-column a.expand_btn.hide_tree {
		display: none;
		margin-left: 0;
	}

	.form {
		overflow: hidden;
	}

	.col {
		display: inline-block;
		margin-right: 10px;
	}
		.row {
		margin-left: 10px;
	}

</style>

<?php
	Yii::app()->clientScript->registerScriptFile('/js/jquery-1.7.js');

	Yii::app()->clientScript->registerCssFile('/css/admin/jPicker/jPicker-1.1.6.css');
	Yii::app()->clientScript->registerScriptFile('/js/admin/jpicker-1.1.6.min.js');
?>

<div class="division-edit">
<div class='tree-column'>
	<?php echo $this->renderPartial('_tree', array('tree'=>$tree, 'expanded_ids' => $expanded_ids)); ?>
</div>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tag-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>
	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'name_en'); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id', Tag::parentsList($model->id), array('encode' => false, 'style'=>'width:249px;')); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'color'); ?>
        <?php echo $form->hiddenField($model,'color',array('size'=>60,'maxlength'=>20)); ?>
        <?php echo $form->error($model,'color'); ?>
    </div>


	<div class="row">
		<div class="col">
			<?php echo $form->checkBox($model,'show_in_menu'); ?>
			<?php echo $form->labelEx($model,'show_in_menu'); ?>
			<?php echo $form->error($model,'show_in_menu'); ?>
		</div>

		<div class="col">
			<?php echo $form->labelEx($model,'_order'); ?>
			<?php echo $form->textField($model,'_order',array('size'=>10,'maxlength'=>10, 'style'=>'width:30px;')); ?>
			<?php echo $form->error($model,'_order'); ?>
		</div>
	</div>

	<div class="row">
		<?php echo $form->checkBox($model,'hide_if_not_last'); ?>
		<?php echo $form->labelEx($model,'hide_if_not_last'); ?>
		<?php echo $form->error($model,'hide_if_not_last'); ?>
	</div>
    <div class="row">
    	<?php echo $form->checkBox($model, 'is_bolded'); ?>
    	<?php echo $form->labelEx($model, 'is_bolded'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'publication_period'); ?>
		<?php echo $form->dropDownList($model, 'publication_period', array(
			'' => '',
			'year' => 'Год',
			'month' => 'Месяц',
			'week' => 'Неделя',
			'day' => 'День',
		)); ?>
		<?php echo $form->error($model,'publication_period'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

<div style="clear: left;"></div>
</div>

<script>
	jQuery(function() {
		jQuery('.load_tree').live('click', function(e) {
			e.preventDefault();
			var $this = jQuery(this);
			var id = $this.data('itemId');
			jQuery.get('<?php echo $this->createUrl('tag/loadTree')?>&parent_id=' + id, function(data) {
				$this.parent().append(data);
				$this.parent().find('ul').hide().slideDown(300);
				$this.hide().next('.hide_tree').show();
			});
		});
		
		jQuery('.hide_tree').live('click', function (e) {
			e.preventDefault();
			var $this = jQuery(this);
			$this.parent().find('ul').slideUp(300, function () {
				jQuery(this).remove();
			});
			$this.hide().prev('.load_tree').show();
		});

		$('#Tag_color').jPicker(
        {
			window:
			{
				expandable: true,
//				alphaSupport: true,
				position: {
					y: 'center'
				},
				effects:{
					speed: {
						show: 300,
						hide: 300
					}
				}
			},
			images: {
				clientPath: '/img/jPicker/'
			}
        });
	});
</script>
