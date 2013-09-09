<div class="wide form">
<table border=0>
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<tr><td>
	<input type="text" name="tags[]" value="агро"><br>
	<input type="checkbox" name="tags[]" value="сельхоз:-дайджест">Сельхоз направленость<br>
	<input type="checkbox" name="tags[]" value="животноводство:-дайджест">Животноводство<br>
</td><td>
	<input type="radio" name="only_not_read" value="0" checked="">Показывать прочитанные 
	<input type="radio" name="only_not_read" value="1">Не Показывать прочитанные
</td></tr>

<tr><td>
		<?php 

		echo $form->labelEx($model,'pubDateot'); 
		
			$this->widget('zii.widgets.jui.CJuiDatePicker', array
	        (
	            'name'=>'RssReaderAll[pubDateot]', // the name of the field
	            'language'=>'ru',
				'value'=>(date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d")-3,   date("Y")))),  // pre-fill the value  
	            'options'=>array
	            (
	                'showAnim'=>'fold',
	                'debug'=>false,
	                'dateFormat' => 'yy-mm-dd',
	            ),
	            'htmlOptions'=>array(
	            'style'=>'height:20px;'),
	        ));

		echo "</td><td> До <br>"; 
		
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
		
</td></tr>
<tr><td>
	
<div class="row">
		<?php echo $form->label($model,'categories'); ?>

	<select multiple="multiple" size="10" spellcheck="false" name="categories[]" id="RssReaderAll_categories">
	<?php 	
		$variable=RssReaderSourcesCatalog::model()->findAllByAttributes(array());
         foreach ($variable as $key => $value) {
             echo "<option value=".$variable[$key]['id'].">".$variable[$key]['text']."</option>";
         }
		   ?>
          </select> 
	</div>	
	</td><td>	
	
	<div class="row">
		<?php echo $form->label($model,'id_sources'); ?>


	<?php 	echo $form->dropDownList(
            $model,
            'id_sources',
          CHtml::listData(RssReaderSources::model()->findAllByAttributes(array()),'id','name'), array('multiple' => "multiple","size"=>"10","spellcheck"=>"false"));
		   ?>
           
	</div>
	
	
</td></tr>
<tr><td>
		
		
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>
</td><td></td>
</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->