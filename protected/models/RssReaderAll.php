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
 * @property string $id
 */
class RssReaderAll extends CActiveRecord
{
	//use for model seach
	public $pubDateot;
	public $pubDatedo;
	public $s_text;
	public $tags;
	public $text_news2;

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
			array('text_news, pubDateot, pubDatedo,tags', 'length', 'max'=>2255),
			array('language', 'length', 'max'=>4),
			array('description, pubDate, yandex_full_text, text_news, date_add, date_edit, pubDateot, pubDatedo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('link,id,tags, title, description, pubDate, pubDateot, pubDatedo, guid, category, author, yandex_full_text, text_news, language, date_add, date_edit, enclosure,text_news,id_sources', 'safe', 'on'=>'search'),
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
			'categories'=>array(self::MANY_MANY, 'RssReaderSourcesCatalog',
                'RssReaderSources(catalog_id)'),
			//'flag_read' =>  array(self::HAS_ONE , 'RssReaderAllUserFlagRead','news_id','on'=>'user_id='.Yii::app()->user->id,'joinType'=>'INNER JOIN'),
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
			'tags' => 'Тэги',
			'id' => 'id',
			'flag_read' => 'Флаг прочтенного',
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

		//$criteria->compare('link',$this->link,true);
		//$criteria->compare('title',$this->title,true);
		//$criteria->compare('description',$this->description,true);
	//	$criteria->compare('pubDate',$this->pubDateOt,true);
		if (!isset($this->pubDateot))
		{
			$this->pubDateot=date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d")-3,   date("Y")));
		}
		if (!isset($this->pubDatedo))
		{
			$this->pubDatedo=date('Y-m-j',mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));
		}
			
		//$criteria->addBetweenCondition("pubDate", $this->pubDateot." 00:00", $this->pubDatedo." 23:59");
		
		//$criteria->compare('guid',$this->guid,true);
		//$criteria->compare('category',$this->category,true);
		//$criteria->compare('author',$this->author,true);
		//$criteria->compare('yandex_full_text',$this->yandex_full_text,true);
		//$criteria->compare('text_news',$this->text_news,true);
		//$criteria->compare('language',$this->language,true);
		//$criteria->compare('date_add',$this->date_add,true);
		//$criteria->compare('date_edit',$this->date_edit,true);
		//$criteria->compare('enclosure',$this->enclosure,true);
		//$criteria->compare('id_sources',$this->id_sources,true);
		//$criteria->compare('text_news',$this->s_text,true);
		$sql=array();
		$sql2=array();
		$sql4=array();
		
		$sql3[]= 't.pubDate >= \''.$this->pubDateot.' 00:00\'';
		$sql3[]= 't.pubDate <= \''.$this->pubDatedo.' 23:59\'';
		if ($this->id_sources)
		{
			
			$sql3[]= 't.id_sources in ('.implode(', ',$this->id_sources).')';
		}
		if ($this->categories)
		{
			
			$sql3[]= 't.categories ss in ('.implode(', ',$this->id_sources).')';
			
		}
		//categories

		if (isset($_REQUEST['only_not_read']) and 1)
		{
			if ($_REQUEST['only_not_read'] == '1'){
				
				$criteria2=new CDbCriteria; 
				$criteria2->select='news_id'; // выбираем только поле 'title' 
				$criteria2->condition='user_id=:userID'; 
				$criteria2->params=array(':userID'=>Yii::app()->user->id);
				$model_read=RssReaderAllUserFlagRead::model()->findall($criteria2);
				$mas_news=array();
				$count=0;
				foreach ($model_read as $value) {
					$count++;
					$mas_news[] = $value->news_id;
					
				}
				if ($count > 0)
				{
					//Далле можно изменить условие при помощи селекта
					$sql3[]="id NOT IN (".implode(', ', $mas_news).")";
				}
			
			}
			
		}	
		
		if (isset($_REQUEST['categories']))
		{
			//	$sql3[]="--";
			$choosed_categories = $_REQUEST['categories'];
			if(!empty($choosed_categories)) {
					$sql3[]="t.id_sources in (select id from ".RssReaderSources::tableName_my()." where catalog_id in (".implode(', ', $choosed_categories)." ))";
              }
		}		
			
		if (isset($_REQUEST['tags']))
		{
			$choosed_tags = array($_REQUEST['tags']);

			//$choosed_ids = self::getChoosed($tags_tree, str_replace('_', ' ', $_REQUEST['tags']));
            if(empty($choosed_tags[0])) {


               }
			else {
				$count_tags=0;
				foreach ($choosed_tags[0] as $value) {
					if (strlen($value)>0)
				   {
				   		$count_tags++;
					   	foreach (split(':', $value) as $key) {
					   		if ($key[0] == '-')	{
								$key=mb_substr($key, 1);
								$sql[]= 't.text_news NOT LIKE \'%'.$key.'%\'';
							}
							else {
								$sql[]= 't.text_news like \'%'.$key.'%\'';
							}
						 }
						
						$sql2[]= implode(' and ', $sql);
						
				   }
					$sql=array();
				   }
				if ($count_tags > 0)
				{
					 $sql3[] = '('.implode(' or ', $sql2).')';
				}
				
			}
			   //			   echo implode(' and ', $sql3);  
				$criteria->condition = implode(' and ', $sql3);
		//	exit;
		}
		$criteria->order = 't.pubDate desc';
		
		//echo "DDDDDDDDDDDDDDDDDDDDDDDDDDDD view".$this->text_news;



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
                'defaultOrder'=>'pubDate DESC',),
		));
	}
	
	

}