<?php
$this->breadcrumbs=array(
	'Tags'=>array('index'),
	'Create',
);
 
$this->menu=array(
	array('label'=>'List Tag', 'url'=>array('index')),
	array('label'=>'Manage Tag', 'url'=>array('admin')),
);
?>

<h1>Создать тэг</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'tree' => $tree, 'expanded_ids' => $expanded_ids)); ?>