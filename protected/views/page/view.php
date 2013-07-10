<?php
/* @var $this PageController */

$this->breadcrumbs=array(
	'Категория: '.$models->category->title => array('index','id'=>$models->category_id),
	$models->title,
);
?>
<?php



	echo "<h1>".$models->title."</h1><hr />";
	echo "".$models->date_edit."";
	echo $models->content;
	
	echo "<br /> <br /> <hr />";


?>