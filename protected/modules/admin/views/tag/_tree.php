<ul>
	<?php foreach($tree as $i): ?>
	<li <?php if ($i->childrenCount > 0) {echo 'class="contain"';} ?>>
		<?php if ($i->childrenCount > 0 && !in_array($i->id, $expanded_ids)): ?>
			<a href='#' class='load_tree' data-item-id='<?php echo $i->id;?>'>+</a><a href="#" class="hide_tree expand_btn">-</a>
		<?php endif; ?>
		<span class="bullet"></span>
		<?php echo CHtml::link($i->name, array('tag/update', 'id' => $i->id));?>
		<?php if ($i->childrenCount > 0 && in_array($i->id, $expanded_ids)): ?>
			<?php echo $this->renderPartial('_tree', array('tree'=>$i->children, 'expanded_ids' => $expanded_ids)); ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul> 