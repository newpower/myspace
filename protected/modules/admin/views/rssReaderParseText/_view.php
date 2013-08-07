<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::encode($data->domain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_text_active')); ?>:</b>
	<?php echo CHtml::encode($data->parse_text_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_method')); ?>:</b>
	<?php echo CHtml::encode($data->parse_method); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_text_per_begin')); ?>:</b>
	<?php echo CHtml::encode($data->parse_text_per_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_text_per_end')); ?>:</b>
	<?php echo CHtml::encode($data->parse_text_per_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_text_per_argument')); ?>:</b>
	<?php echo CHtml::encode($data->parse_text_per_argument); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_img_per_begin')); ?>:</b>
	<?php echo CHtml::encode($data->parse_img_per_begin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_img_per_end')); ?>:</b>
	<?php echo CHtml::encode($data->parse_img_per_end); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_img_per_argument')); ?>:</b>
	<?php echo CHtml::encode($data->parse_img_per_argument); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_edit')); ?>:</b>
	<?php echo CHtml::encode($data->date_edit); ?>
	<br />

	*/ ?>

</div>