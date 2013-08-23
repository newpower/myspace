<ul>
	<?php foreach($tree as $i): ?>
	<li>
		<label><input type="checkbox" name="" <?php if (in_array($i->id, $choosed_ids)) echo 'checked="checked"';?>><?php echo $i->name; ?></label>
		<?php if ($i->childrenCount > 0): ?>
			<?php echo $this->renderPartial('/tag/_full_tree', array('tree'=>$i->children, 'choosed_ids' => $choosed_ids)); ?>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
 