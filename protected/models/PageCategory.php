<?php

/**
 * This is the model class for table "{{_page_category}}".
 *
 * The followings are the available columns in table '{{_page_category}}':
 * @property string $id
 * @property string $title
 * @property string $position
 * @property string $date_add
 * @property string $date_edit
 */
class PageCategory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PageCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_page_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,position', 'required'),
			array('title', 'length', 'max'=>255),
			array('position', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'category' =>  array(self::BELONGS_TO , 'PageCategory','category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'position' => 'Позиция',
			'date_add' => 'Дата добавления',
			'date_edit' => 'Дата изменения',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('position',$this->position,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function all()
	{
		$models = self::model()->findAll();
		return CHtml::listData($models, 'id', 'title');
	}
	public static function menu($position)
	{
		
		$models = self::model()->findAllByAttributes(array('position'=>$position));
		$array = array();
		foreach ($models as $one) 
		{
			//$array[]=array('label'=>$one->title, 'url'=>array('/page/index/id/'.$one->id),);
		}
		if ($position == 'top')
		{
			$array[]=array('label'=>'Главная', 'url'=>array('/site/index'),);
			
		}
		if ($position == 'top')
		{
			$array[]=array('label'=>'Новости ', 'url'=>array('/RssReaderAll/admin'),);
			
			$array[]=array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest);
			$array[]=array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest);
			$array[]=array('label'=>'Регистрация', 'url'=>array('/site/registration'), 'visible'=>Yii::app()->user->isGuest);
			
			
			if((Yii::app()->user->checkAccess('2')) or (Yii::app()->user->checkAccess('3'))){
    			$array[]=array('label'=>'Панель администратора', 'url'=>array('/admin'),);
			}
		}
		return $array;
	}
}