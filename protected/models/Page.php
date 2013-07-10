<?php

/**
 * This is the model class for table "{{_page}}".
 *
 * The followings are the available columns in table '{{_page}}':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $date_add
 * @property string $date_edit
 * @property integer $status
 * @property string $category_id
 */
class Page extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Page the static model class
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
		return '{{_page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('category_id', 'length', 'max'=>10),
			array('content, date_add, date_edit', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, date_add, date_edit, status, category_id', 'safe', 'on'=>'search'),
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
			'title' => 'Заголовок',
			'content' => 'Содержание',
			'date_add' => 'Дата создания',
			'date_edit' => 'Дата редактирования',
			'status' => 'Статус',
			'category_id' => 'Категория',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function BeforeSave()
	{
		if ($this->isNewRecord)
		{

			$this->date_add=date("Y-m-d H:i:s");
		}
		$this->date_edit=date("Y-m-d H:i:s");
		
		return parent::BeforeSave();
		
	}
	
	
	public static function all()
	{
		$models = self::model()->findAll();
		return CHtml::listData($models, 'id', 'title');
	}
	
}