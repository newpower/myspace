<?php

class RssReaderAllController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/columnnews2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','ReadNews','check_shingls'),
				'users'=>array('*'),
				'roles'=>array('1'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$my_news_model = $this->loadModel($id);
		
		$count_link=RssReaderAllUserFlagRead::model()->count(array('condition'=>'user_id=:userID and news_id =:newsID', 'params'=>array(':userID'=>Yii::app()->user->id,'newsID'=>$my_news_model->id), ));
		if ($count_link == 0){
			$mod= new RssReaderAllUserFlagRead;
			$mod->news_id=$my_news_model->id;
			//$mod->user_id=1;
			$mod->user_id=Yii::app()->user->id;
			
			if (!$mod->save())
			{
				echo "error 100203".rand(10, 1000);
				exit;
			}
		}
		
		$this->render('view',array(
			'model'=>$my_news_model,
	//		'model_read'=> ,
		));
	}

	public function actioncheck_shingls($id)
	{
		$model = $this->loadModel($id);
		if(isset($_POST['RssReaderAll']))
		{
			$model->attributes=$_POST['RssReaderAll'];
		}
		
	
			if (!isset($_POST['RssReaderAll']['text_news2'])) {
				$model->text_news2=$model->text_news;
			}
			else {
				$model->text_news2=$_POST['RssReaderAll']['text_news2'];
			
		}
		$this->render('check_shingls',array(
			'model'=>$model,
	//		'model_read'=> ,
		));
	}
	/**
	 * Функция отображения картинок, выбирает необходимые
	 * @param string json format utf
	 * @return text
	 */
	public function actionViewImage($url_link_json)
	{
		$text_img='';
		if ($url_link_json)
		{
			$mas=json_decode($url_link_json,TRUE);
				//CHtml::link($data->title,array('controller/action',  'param1'=>'value1'))
			foreach ($mas as $key => $value) {
				if ((substr_count($value["src"],'24x24')> 0) or (substr_count($value["src"],'captcha')> 0) or (substr_count($value["src"],'share-lj')> 0) or (substr_count($value["src"],'/ne_/ne_')> 0))
				{
	//share-lj
				}
				else {
					$text_img=$text_img.CHtml::image($value["src"],$value["alt"], array('align'=>'left','width'=>'150',)).'';
				}
			}
		}
		return $text_img;
	}
	
	public function actionViewSmallNews($data)
	{
		$new_link=CHtml::link('Продолжение Открыть в новом окне', Yii::app()->controller->createUrl("view", array("id" => $data->link)),array("target"=>"_blank"));
		$text="<font size='+2'>".CHtml::link(CHtml::encode($data->title), Yii::app()->controller->createUrl("view", array("id" => $data->link)))."</font><br>".$data->pubDate." ".$new_link."  ".CHtml::encode($data->link)."<br><br>";
		
		$text=$text.RssReaderAllController::actionViewImage($data->url_link_json);

		
		$text=$text.substr($data->text_news,0,1500).$new_link."<br><br>";
		return $text;
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RssReaderAll;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RssReaderAll']))
		{
			$model->attributes=$_POST['RssReaderAll'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->link));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RssReaderAll']))
		{
			$model->attributes=$_POST['RssReaderAll'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->link));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RssReaderAll');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		//if (isset($_POST['set_user']))
		//{
		//	$model=new RssReaderAll('search_smal_seach');
		//	$model->unsetAttributes();  // clear any default values
		//	
		//}
		//else {
			$model=new RssReaderAll('search');
			$model->unsetAttributes();  // clear any default values
		//}
		
		

		if(isset($_GET['RssReaderAll']))
			$model->attributes=$_GET['RssReaderAll'];
	if (isset($_GET['RssReaderAll']))
	{
		echo $_GET['RssReaderAll'];
	}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionReadNews()
	{
		$model=new RssReaderAll('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['RssReaderAll']))
			$model->attributes=$_GET['RssReaderAll'];
		if (isset($_GET['RssReaderAll']))
		{
			echo $_GET['RssReaderAll'];
		}

		$choosed_tags = array();
		$tags_tree = Tag::newsTree();
		

		$this->render('ReadNews',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=RssReaderAll::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']==='rss-reader-all-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public static function getChoosed($tree, $tag) {
	$result = null;
	
	foreach ($tree as $el){
			if ($el->name == $tag) 	{
				$result = array($el->id);
				break;
			} elseif ($el->childrenCount > 0) {
				$children = self::getChoosed($el->children, $tag);
				if ($children != null) {
					$children [] = $el->id;
					$result = $children;
					break;
				}
			}
		}
		return $result;
	}
}
