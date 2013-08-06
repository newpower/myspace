<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->link), array('view', 'id'=>$data->link)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>|
		<b><?php echo CHtml::encode($data->getAttributeLabel('pubDate')); ?>:</b>
	<?php echo CHtml::encode($data->pubDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('text_news')); ?>:</b>
	<?php echo $data->text_news; ?> 
	<br />




	<b><?php echo CHtml::encode($data->getAttributeLabel('guid')); ?>:</b>
	<?php echo CHtml::encode($data->guid); ?>|

	<b><?php echo CHtml::encode($data->getAttributeLabel('category')); ?>:</b>
	<?php echo CHtml::encode($data->category); ?>|
	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />





	<b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<?php echo CHtml::encode($data->language); ?> |
		<b><?php echo CHtml::encode($data->getAttributeLabel('date_add')); ?>:</b>
	<?php echo CHtml::encode($data->date_add); ?>|
		<b><?php echo CHtml::encode($data->getAttributeLabel('date_edit')); ?>:</b>
	<?php echo CHtml::encode($data->date_edit); ?>|
			<b><?php echo CHtml::encode($data->getAttributeLabel('sources')); ?>:</b>
	<?php echo CHtml::encode($data->sources->name); ?>
	
		<b><?php echo CHtml::encode($data->getAttributeLabel('enclosure')); ?>:</b>
	<?php echo CHtml::encode($data->enclosure); ?>
	
	<br /> 
	<hr />



	<br />

	<br />
	
	
	
	<?php /*
	*/ ?>

</div>