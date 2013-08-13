<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-5 last">
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Разделы',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>PageCategory::menu('left'),
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
	
		<div class="span-19">
		<div id="content">RRRRRRRR
			<?php echo $content; ?>
		</div><!-- content -->
	</div>

</div>
<?php $this->endContent(); ?>