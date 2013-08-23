<?php

/**
 * This is the model class for table "{{_rss_reader_all}}".
 *
 * The followings are the available columns in table '{{_rss_reader_all}}':
 * @property string $link
 * @property string $title
 * @property string $description
 * @property string $pubDate
 * @property string $guid
 * @property string $category
 * @property string $author
 * @property string $yandex_full_text
 * @property string $text_news
 * @property string $language
 * @property string $date_add
 * @property string $date_edit
 * @property string $enclosure
 */
class RssReaderAll extends CActiveRecord
{
	//use for model seach
	public $pubDateot;
	public $pubDatedo;
	public $s_text;
	/**
	 * Returns the static model of the specified AR class.
	 * @return RssReaderAll the static model class
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
		return '{{_rss_reader_all}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */ 
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, title', 'required'),
			array('link, title, guid, category, author, enclosure', 'length', 'max'=>255),
			array('text_news, pubDateot, pubDatedo,s_text', 'length', 'max'=>2255),
			array('language', 'length', 'max'=>4),
			array('description, pubDate, yandex_full_text, text_news, date_add, date_edit, pubDateot, pubDatedo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('link,s_text, title, description, pubDate, pubDateot, pubDatedo, guid, category, author, yandex_full_text, text_news, language, date_add, date_edit, enclosure,text_news,id_sources', 'safe', 'on'=>'search'),
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
			'sources' =>  array(self::BELONGS_TO , 'RssReaderSources','id_sources'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'link' => 'Link',
			'title' => 'Заголовок',
			'description' => 'Описание',
			'text_news' => 'Текст новости с официального сайта',
			'pubDate' => 'Дата публикации',
			'pubDateOt' => 'Дата публикации с',
			'pubDateDo' => 'Дата публикации до',
			'guid' => 'Guid',
			'category' => 'Category',
			'author' => 'Author',
			'yandex_full_text' => 'Yandex Ful Text',
			'text_news' => 'Text News',
			'language' => 'Language',
			'date_add' => 'Date Add',
			'date_edit' => 'Date Edit',
			'enclosure' => 'Enclosure',
			'id_sources' => 'Источник',
			'sources' => 'Источник новостей',
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

		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
	//	$criteria->compare('pubDate',$this->pubDateOt,true);
		if (!isset($this->pubDateot))
		{
			$this->pubDateot=date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d")-7,   date("Y")));
		}
		if (!isset($this->pubDatedo))
		{
			$this->pubDatedo=date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		}
			
			$criteria->addBetweenCondition("pubDate", $this->pubDateot." 00:00", $this->pubDatedo." 23:59");
			//compare('pubDate',$this->pubDateot,true);
		//}
		

		
		$criteria->compare('guid',$this->guid,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('yandex_full_text',$this->yandex_full_text,true);
		$criteria->compare('text_news',$this->text_news,true);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('date_add',$this->date_add,true);
		$criteria->compare('date_edit',$this->date_edit,true);
		$criteria->compare('enclosure',$this->enclosure,true);
		$criteria->compare('id_sources',$this->id_sources,true);
		$criteria->compare('text_news',$this->s_text,true);
		
echo "DDDDDDDDDDDDDDDDDDDDDDDDDDDD view".$this->text_news;
//foreach ($this->id_sources as $key => $value) {
	//echo "$key => $value <br>";
//}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                'defaultOrder'=>'pubDate DESC',),
		));
	}
	
	

}