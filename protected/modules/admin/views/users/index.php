<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
	'Админ панель'=>array('/admin'),
	'Пользователи'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Журнал Users', 'url'=>array('index')),
	array('label'=>'Создать Users', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#users-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Журнал пользователей</h1>

<p>
Вы можете использовать спец символы для быстрого поиска(<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) .
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php
echo CHtml::form();
echo CHtml::submitButton('Разбанить',array('name'=>'noban'));
echo CHtml::submitButton('Забанить',array('name'=>'ban'));
if((Yii::app()->user->checkAccess('2')) or (Yii::app()->user->checkAccess('3'))){
	echo "<br />";	
   echo CHtml::submitButton('Сделать администратором',array('name'=>'set_admin'));
   echo CHtml::submitButton('Сделать Пользователем',array('name'=>'set_user'));

}


?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'users-grid',
	'selectableRows'=>2,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		array('class'=>'CCheckBoxColumn',
			'id'=>'user_id',
		),
		'username',
		'password',
		'date_add',
		'date_edit',
		'flag_ban'=> array(
			'name'=> 'flag_ban',
			'value'=> '($data->flag_ban==1)?"Не заблокирован":"Заблокирован"',
						'filter' => array('1' => 'Нет', '0'=>'да', ),
		),
		
		'role'=> array(
			'name'=> 'role',
			'value'=> '($data->role==1)?"Пользователь":"Администратор"',
						'filter' => array('1' => 'Пользователь', '2'=>'Администратор', ),

		),
		'email',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<?php
echo CHtml::endForm();


?>
