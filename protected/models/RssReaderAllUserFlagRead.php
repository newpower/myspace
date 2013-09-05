<?php

/**
 * This is the model class for table "{{_rss_reader_all_user_flag_read}}".
 *
 * The followings are the available columns in table '{{_rss_reader_all_user_flag_read}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $news_id
 * @property string $date_add
 * @property string $date_edit 
 * @property string $date_edit 
 * @property string $flag_read
 */
class RssReaderAllUserFlagRead extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RssReaderAllUserFlagRead the static model class
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
		return '{{_rss_reader_all_user_flag_read}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, news_id', 'required'),
			array('user_id, news_id, flag_read', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, news_id, date_add, date_edit', 'safe', 'on'=>'search'),
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
	//		'news' =>  array(self::BELONGS_TO , 'RssReaderAll','id',),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		//	'id' => 'ID',
			'user_id' => 'User',
			'news_id' => 'News',
			'date_add' => 'Date Add',
			'date_edit' => 'Date Edit',
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

		//$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);

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