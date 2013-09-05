<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Добро пожаловать на сайт  '.CHtml::encode(Yii::app()->name),
)); ?>

<p>Для продолжения работы перейдите в соотвествующий раздел (ссылки сверху страницы).</p>
<a href="http://ping-admin.ru/free_uptime/stat/289ecc6186d7990262396f166370e4cd3749.html" target="_blank"><img src="http://ping-admin.ru/i/free_uptime/6b36bfbb7988d21643807165502a1f813749_1.gif" width="88" height="15" border="0" alt="проверка сайта"></a>

<?php $this->endWidget(); ?>

