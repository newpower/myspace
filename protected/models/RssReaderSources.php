<?php

/**
 * This is the model class for table "{{_rss_reader_sources}}".
 *
 * The followings are the available columns in table '{{_rss_reader_sources}}':
 * @property string $id
 * @property string $name
 * @property string $descrition
 * @property string $link_main
 * @property string $link_rss
 * @property string $link_image
 * @property string $lang
 * @property string $managing_editor_name
 * @property string $managing_editor_mail
 * @property string $date_add
 * @property string $date_edit
 * @property string $date_rss_read
 * @property integer $ttl_time
 * @property integer $link_news
 * @property integer $parse_method
 * @property integer $parse_per_begin
 * @property integer $parse_per_end
 * @property integer $parse_active
 * @property integer $parse_per_argument
 * @property integer $catalog_id
 * 
 */
class RssReaderSources extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RssReaderSources the static model class
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
		return '{{_rss_reader_sources}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ttl_time, parse_active, parse_per_argument, catalog_id', 'numerical', 'integerOnly'=>true),
			array('name, link_main, link_rss, link_image, managing_editor_name, managing_editor_mail, link_news, parse_method, parse_per_begin, parse_per_end', 'length', 'max'=>255),
			array('lang', 'length', 'max'=>45),
			array('descrition, date_add, date_edit, date_rss_read', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, descrition, link_main, link_rss, link_image, lang, managing_editor_name, managing_editor_mail, date_add, date_edit, date_rss_read, ttl_time, catalog_id, parse_active', 'safe', 'on'=>'search'),
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
			'sources_news' =>  array(self::HAS_MANY , 'RssReaderAll','id_sources'),
			'manttl' =>  array(self::BELONGS_TO , 'RssManTtl','ttl_time'),
			'catalog' =>  array(self::BELONGS_TO , 'RssReaderSourcesCatalog','catalog_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Наименование',
			'descrition' => 'Описание',
			'link_main' => 'Ссылка на страницу новостей',
			'link_rss' => 'Ссылка RSS',
			'link_image' => 'Ссылка на логотип',
			'lang' => 'Язык',
			'managing_editor_name' => 'Managing Editor Name',
			'managing_editor_mail' => 'Managing Editor Mail',
			'date_add' => 'Date Add',
			'date_edit' => 'Date Edit',
			'date_rss_read' => 'Date Rss Read',
			'ttl_time' => 'Интервал обновление (мин)',
			'catalog_id' => 'Входит в группу',
			'catalog' => 'Входит в группу',
			'sources_news' => 'Источник новостей',
			'link_news'=> 'Ссылка на список новостей',
			'parse_method'=> 'Метод парсера',
			'parse_per_begin'=> 'parse_per_begin',
			'parse_per_end'=> 'parse_per_end',
			'parse_active'=> 'parse_active',
			'parse_per_argument'=> 'parse_per_argument',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	 
	
	public static function all()
	{
		$models = self::model()->findAll();
	//	echo "ooooooooooooooooooooooooooooooooooooooooo";
		return CHtml::listData($models, 'id', 'name');
	}
	
	
	public function BeforeSave()
	{

		if ($this->isNewRecord)
		{
			
			$this->date_add=date("Y-m-d H:i:s");
			$this->date_rss_read='2000-01-01';
		}
		$this->date_edit=date("Y-m-d H:i:s");
		return parent::BeforeSave();
		
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descrition',$this->descrition,true);
		$criteria->compare('link_main',$this->link_main,true);
		$criteria->compare('link_rss',$this->link_rss,true);
		$criteria->compare('link_image',$this->link_image,true);
		$criteria->compare('lang',$this->lang,true);
		$criteria->compare('managing_editor_name',$this->managing_editor_name,true);
		$criteria->compare('managing_editor_mail',$this->managing_editor_mail,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('date_rss_read',$this->date_rss_read,true);
		$criteria->compare('ttl_time',$this->ttl_time);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
		public static function tableName_my()
	{
		return '{{_rss_reader_sources}}';
	}
}