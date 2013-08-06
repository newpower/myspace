<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Добро пожаловать на сайт  '.CHtml::encode(Yii::app()->name),
)); ?>

<p>Для продолжения работы перейдите в соотвествующий раздел (ссылки сверху страницы).</p>

<?php $this->endWidget(); ?>

