<?php

/**
 * This is the model class for table "{{_page_comments}}".
 *
 * The followings are the available columns in table '{{_page_comments}}':
 * @property string $id
 * @property string $content
 * @property string $page_id
 * @property string $date_add
 * @property string $date_edit
 * @property string $user_id
 * @property string $guest
 * @property string $status
 */
class PageComments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PageComments the static model class
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
		return '{{_page_comments}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, user_id', 'length', 'max'=>10),
			array('guest', 'length', 'max'=>255),
			array('content, date_add, date_edit', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, content, date_add, date_edit, user_id, guest', 'safe', 'on'=>'search'),
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
			'user' =>  array(self::BELONGS_TO , 'Users','user_id'),
			'page' =>  array(self::BELONGS_TO , 'Page','page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'content' => 'Текст',
			'page_id' => 'Страницы',
			'date_add' => 'Дата создания',
			'date_edit' => 'Дата редактирования',
			'user_id' => 'User',
			'guest' => 'Guest',
			'status' => 'Статус',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('guest',$this->guest,true);
		$criteria->compare('status',$this->status,true);

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
}