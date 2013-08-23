<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */ 
class AdminController extends Controller
{
	const PAGE_SIZE = 50;
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	//public $layout='//layouts/column2';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
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
				'actions'=>array('login','logout','loginform'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
 
	public $user = null;
	public $admin_user = null;

/**
 * 

	protected function beforeAction($action) {
 		User::$admin_mode = true;
		if (!Yii::app()->user->isGuest) {
			$this->admin_user = AdminUser::model()->findByPk(Yii::app()->user->id); //Yii::app()->user->model;
		} else {
			$this->admin_user = null;
		}
 		return true;
    }
 */

}