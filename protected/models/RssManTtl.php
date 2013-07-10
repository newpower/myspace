<?php

/**
 * This is the model class for table "{{_rss_man_ttl}}".
 *
 * The followings are the available columns in table '{{_rss_man_ttl}}':
 * @property string $id
 * @property string $value
 */
class RssManTtl extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RssManTtl the static model class
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
		return '{{_rss_man_ttl}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id,value', 'required'),
			array('value', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, value', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Минуты',
			'value' => 'Значение описание',
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
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	//Выподающий список для ттл
	public static function all()
	{
		$models = self::model()->findAll();
	//	echo "ooooooooooooooooooooooooooooooooooooooooo";
		return CHtml::listData($models, 'id', 'value');
	}
	
	
}