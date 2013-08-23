
<?php
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        
        $cs->registerScriptFile($baseUrl.'/js/jquery-1.7.js');
        $cs->registerScriptFile($baseUrl.'/js/jquery.tmpl.js');
        $cs->registerScriptFile($baseUrl.'/js/underscore.js');
        $cs->registerScriptFile('/js/admin/jquery.ba-bbq.js');
    ?>
    <?php Yii::app()->clientScript->registerScriptFile('/js/jquery-1.7.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/fujs/vendor/jquery.ui.widget.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/fujs/jquery.iframe-transport.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/fujs/jquery.fileupload.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/fujs/locale.js') ?>


<?php Yii::app()->clientScript->registerScriptFile('/js/multimedia.js') ?>
<?php Yii::app()->clientScript->registerCssFile('/css/multimedia.css') ?>
<?php Yii::app()->clientScript->registerScriptFile('/img/swfupload/swfupload.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/img/swfupload/swfupload.cookies.js') ?>

<?php Yii::app()->clientScript->registerCssFile('/css/fancybox/jquery.fancybox-1.3.4.css') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.fancybox-1.3.4.js') ?>

<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.cookies.2.1.0.min.js') ?>

<?php Yii::app()->clientScript->registerScriptFile('/js/jquery-ui-1.8.20.custom.min.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.checkboxtree.min.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/date-format-strange.js') ?>
<?php Yii::app()->clientScript->registerScriptFile('/js/translation.js') ?>



<link rel="stylesheet" type="text/css" href="/css/admin/common.css" />
    <link rel="stylesheet" type="text/css" href="/js/admin/jQueryRTE/jquery.rte.css" />
    
	<script type="text/javascript" src="/js/tiny_mce/jquery.tinymce.js"></script>
    <script src='/js/admin/common.js' type='text/javascript' ></script>
    <script src='/js/admin/jQueryRTE/jquery.rte.js' type='text/javascript' ></script> 
    <script src='/js/admin/jQueryRTE/jquery.rte.tb.js' type='text/javascript' ></script> 
    <script src='/js/admin/jQueryRTE/jquery.getattributes.js' type='text/javascript' ></script> 
    <script src='/js/admin/jQueryRTE/jquery.ocupload-1.1.4.js' type='text/javascript' ></script> 
    <script src="/js/jquery_ui_datepicker/jquery_ui_datepicker.js" type="text/javascript"></script>
    <script src="/js/jquery_ui_datepicker/i18n/ui.datepicker-ru.js" type="text/javascript"></script>
    <script src="/js/jquery_ui_datepicker/timepicker_plug/timepicker.js" type="text/javascript"></script>

    <link rel="stylesheet" type="text/css" href="/js/jquery_ui_datepicker/timepicker_plug/css/style.css">
    <link rel="stylesheet" type="text/css" href="/js/jquery_ui_datepicker/smothness/jquery_ui_datepicker.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery.checkboxtree.css">

	<script src='/js/address.js' type='text/javascript' ></script>

    <script>
    	
    	function user_profile () {
            <?php if(false && $this->user): ?>
	    	var user = <?php echo CJSONUTF8::encode($this->user->toJson()); ?>;
            var currency = '<?php echo $this->user->currency; ?>';
            <?php else: ?>
            var user = {currency: 'RUB'}
            var currency = 'RUB'
            <?php endif; ?>

	    	var current_currency = $('#model_general_price_currency').val();
	    	user.currency = currency;
	    	if (current_currency != '') {
		    	user.currency = current_currency;
	    	}
	    	return user;
    	}
    	
    	function get_rate_for_currency (currency_code) {
	    	var data = <?php 
	    	//echo CJSONUTF8::encode(CurrencyRateHistory::getRates()); 
	    	?>;
	    	return data[ currency_code ];
    	}
    	
    	var datetime_params = {
            userLang    : 'ru',
            americanMode: false
            //,
        };

        function user_profile () {
            var user = {currency: 'RUB'}
            var currency = 'RUB'

            var current_currency = $('#model_general_price_currency').val();
            user.currency = currency;
            if (current_currency != '') {
                user.currency = current_currency;
            }
            return user;
        }

        function get_rate_for_currency (currency_code) {
            var data = <?php 
           	//echo CJSONUTF8::encode(CurrencyRateHistory::getRates()); 
            ?>;
            return data[ currency_code ];
        }
        
        $(function() {
           
            if($(".datetimepicker").size() > 0)
				jQuery('.datetimepicker').datetime(datetime_params);
        })
    </script>
    

<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-19">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Доступные операции',
			));
			$this->widget('zii.widgets.CMenu', array(
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'operations'),
			));
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>

<?php
$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();


$cs->registerScriptFile($baseUrl.'/js/main.js');

?>
