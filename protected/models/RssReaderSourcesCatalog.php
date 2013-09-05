<?php

/**
 * This is the model class for table "{{_rss_reader_sources_catalog}}".
 *
 * The followings are the available columns in table '{{_rss_reader_sources_catalog}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $text
 * @property string $date_add
 * @property string $date_edit 
 */
class RssReaderSourcesCatalog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RssReaderSourcesCatalog the static model class
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
		return '{{_rss_reader_sources_catalog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('text', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, parent_id, text, date_add, date_edit', 'safe', 'on'=>'search'),
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
			'sources_all' =>  array(self::HAS_MANY , 'RssReaderSources','catalog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Parent',
			'text' => 'Text',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('text',$this->text,true);
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
		//Выподающий список для ттл
	public static function all()
	{
		$models = self::model()->findAll();
	//	echo "ooooooooooooooooooooooooooooooooooooooooo";
		return CHtml::listData($models, 'id', 'text');
	}
	public static function tableName_my()
	{
		return '{{_rss_reader_sources_catalog}}';
	}
	
}