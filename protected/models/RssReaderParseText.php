<?php

/**
 * This is the model class for table "{{_rss_reader_parse_text}}".
 *
 * The followings are the available columns in table '{{_rss_reader_parse_text}}':
 * @property integer $id
 * @property string $domain
 * @property integer $parse_text_active
 * @property string $parse_method
 * @property string $parse_text_per_begin
 * @property string $parse_text_per_end
 * @property integer $parse_text_per_argument
 * @property string $parse_img_per_begin
 * @property string $parse_img_per_end
 * @property integer $parse_img_per_argument
 * @property string $comment
 * @property string $date_add
 * @property string $date_edit
 */
class RssReaderParseText extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RssReaderParseText the static model class
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
		return '{{_rss_reader_parse_text}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain', 'required'),
			array('parse_text_active, parse_text_per_argument, parse_img_per_argument', 'numerical', 'integerOnly'=>true),
			array('domain, parse_text_per_begin, parse_text_per_end, parse_img_per_begin, parse_img_per_end, comment', 'length', 'max'=>255),
			array('parse_method', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, domain, parse_text_active, parse_method, parse_text_per_begin, parse_text_per_end, parse_text_per_argument, parse_img_per_begin, parse_img_per_end, parse_img_per_argument, comment, date_add, date_edit', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'domain' => 'Домен',
			'parse_text_active' => 'Parse Text Active',
			'parse_method' => 'Parse Method',
			'parse_text_per_begin' => 'Parse Text Per Begin',
			'parse_text_per_end' => 'Parse Text Per End',
			'parse_text_per_argument' => 'Parse Text Per Argument',
			'parse_img_per_begin' => 'Parse Img Per Begin',
			'parse_img_per_end' => 'Parse Img Per End',
			'parse_img_per_argument' => 'Parse Img Per Argument',
			'comment' => 'Comment',
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
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('parse_text_active',$this->parse_text_active);
		$criteria->compare('parse_method',$this->parse_method,true);
		$criteria->compare('parse_text_per_begin',$this->parse_text_per_begin,true);
		$criteria->compare('parse_text_per_end',$this->parse_text_per_end,true);
		$criteria->compare('parse_text_per_argument',$this->parse_text_per_argument);
		$criteria->compare('parse_img_per_begin',$this->parse_img_per_begin,true);
		$criteria->compare('parse_img_per_end',$this->parse_img_per_end,true);
		$criteria->compare('parse_img_per_argument',$this->parse_img_per_argument);
		$criteria->compare('comment',$this->comment,true);
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