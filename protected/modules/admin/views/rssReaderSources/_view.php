<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descrition')); ?>:</b>
	<?php echo CHtml::encode($data->descrition); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_main')); ?>:</b>
	<?php echo CHtml::encode($data->link_main); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_rss')); ?>:</b>
	<?php echo CHtml::encode($data->link_rss); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_image')); ?>:</b>
	<?php echo CHtml::encode($data->link_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lang')); ?>:</b>
	<?php echo CHtml::encode($data->lang); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('managing_editor_name')); ?>:</b>
	<?php echo CHtml::encode($data->managing_editor_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('managing_editor_mail')); ?>:</b>
	<?php echo CHtml::encode($data->managing_editor_mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_edit')); ?>:</b>
	<?php echo CHtml::encode($data->date_edit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_rss_read')); ?>:</b>
	<?php echo CHtml::encode($data->date_rss_read); ?>
	<br />
	*/ ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('ttl_time')); ?>:</b>
	<?php echo CHtml::encode($data->ttl_time); ?>
	<br />



</div>