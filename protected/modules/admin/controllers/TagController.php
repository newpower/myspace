<?php
 
class TagController extends AdminController
{

	public $defaultAction = 'tree';
	
	public function actionView($id)
	{  
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tag;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
				$this->redirect(array('tree','open'=>$model->parent_id));
		}
		$data = $this->getTree( (int)$_REQUEST['open'] );
		$data = array_merge(array('model'=>$model), $data);
		$this->render('create', $data);
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

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
				$this->redirect(array('tree','open'=>$model->parent_id));
		}
		$data = array();
		if ($model) {
			$data = $this->getTree( (int)$model->id );
		} else {
			$data = $this->getTree( (int)$_REQUEST['open'] );
		}
		$data = array_merge(array('model'=>$model), $data);
		$this->render('update', $data);
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
		$dataProvider=new CActiveDataProvider('Tag');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tag('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tag']))
			$model->attributes=$_GET['Tag'];

		$this->render('admin',array(
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
		$model=Tag::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tag-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionTree() {
		$data = $this->getTree( (int)$_REQUEST['open'] );
		$this->render('tree', $data);
	}
	
	public function actionLoadTree() {
		$list = Tag::model()->findAll('parent_id = ' . (int)$_REQUEST['parent_id']);
		$this->renderPartial('_tree',array(
			'tree' => $list,
			'expanded_ids' => array(),
		));
	}
	
	public function getTree($open_id) {
		$list = Tag::model()->with('childrenCount')->findAll('parent_id is null');
		
		$expanded_ids = array();
		if ($open_id > 0) {
			$div = Tag::model()->findByPk($open_id);
			if ($div) {
				$expanded_ids = $div->getParentsIds(false);
			}
		}
		return array(
			'tree' => $list,
			'expanded_ids' => $expanded_ids,
		);
	}
}
