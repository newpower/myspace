<?php
$this->breadcrumbs=array(
	'Divisions',
);

$this->menu=array(
	array('label'=>'Create Division', 'url'=>array('create')),
);
?> 
<style type="text/css">
	.expand_btn {
		display: none;
	}
	.tree-column ul {
		list-style: none;
		padding: 0;
		margin: 0;
	}
</style>
<h1>Tags</h1>
<div class='tree-column'>
	<?php echo $this->renderPartial('_tree', array('tree'=>$tree, 'expanded_ids' => $expanded_ids)); ?>
</div>

<script>
	jQuery(function() {
		jQuery('.load_tree').live('click', function(e) {
			e.preventDefault();
			var $this = jQuery(this);
			var id = $this.data('itemId');
			jQuery.get('<?php echo $this->createUrl('tag/loadTree')?>?parent_id=' + id, function(data) {
				$this.parent().append(data);
				$this.remove();
			});
		})
	});
</script>