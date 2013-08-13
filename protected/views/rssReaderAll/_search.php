<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
		<?php 

		echo $form->labelEx($model,'pubDateot'); 
		
			$this->widget('zii.widgets.jui.CJuiDatePicker', array
	        (
	            'name'=>'RssReaderAll[pubDateot]', // the name of the field
	            'language'=>'ru',
				'value'=>(date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d")-7,   date("Y")))),  // pre-fill the value  
	            'options'=>array
	            (
	                'showAnim'=>'fold',
	                'debug'=>false,
	                'dateFormat' => 'yy-mm-dd',
	            ),
	            'htmlOptions'=>array(
	            'style'=>'height:20px;'),
	        ));

		echo " До "; 
		
			$this->widget('zii.widgets.jui.CJuiDatePicker', array
	        (
	            'name'=>'RssReaderAll[pubDatedo]', // the name of the field
	            'language'=>'ru',
				'value'=>(date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")))),  // pre-fill the value  
	            'options'=>array
	            (
	                'showAnim'=>'fold',
	                'debug'=>false,
	                'dateFormat' => 'yy-mm-dd',
	            ),
	            'htmlOptions'=>array(
	            'style'=>'height:20px;'),
	        ));


 ?>
		
	<div class="row">
		<?php echo $form->label($model,'id_sources'); ?>


	<?php 	echo $form->dropDownList(
            $model,
            'id_sources',
          CHtml::listData(RssReaderSources::model()->findAllByAttributes(array()),'id','name'), array('multiple' => "multiple","size"=>"10")); ?>
           
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->