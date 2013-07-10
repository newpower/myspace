<?php

class SettingController extends Controller
{


	public function indexUpdate($id)
	{
		$model=Setting::model()->findByPk($id);
		


		if(isset($_POST['Setting']))
		{
			$model->attributes=$_POST['Setting'];
			if($model->save()) {
				Yii::app()->user->setFlash('Setting','Изменения произведены.');
			}
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array('*'),
				'roles'=>array('2'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{

		return self::indexUpdate(1);
	}
}