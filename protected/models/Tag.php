<?php

/**
 * This is the model class for table "Tag".
 *
 * The followings are the available columns in table 'Tag':
 * @property string $id
 * @property string $name
 * @property integer $show_in_menu
 *
 * The followings are the available model relations:
 * @property Analytics[] $analytics
 * @property News[] $news
 * @property TimeLine[] $timeLines 
 */
class Tag extends CActiveRecord
{ 
	
	public $_children = array();
	
	public static $map = array();
	public static $tree = array();

	const ANALYTICS_TYPE_ID = 1;

	public static $_analytics_ids = array();
	public static $_analytics_parent_id = 0;

	public static function analytics_ids() {
		if (count(self::$_analytics_ids) == 0) {
			$m = self::model()->findByAttributes(array('type_id' => self::ANALYTICS_TYPE_ID));
			foreach ($m as $mi) {
				self::$_analytics_ids[] = $mi->id;
			}
		}
		return self::$_analytics_ids;
	}

	public static function analytics_parent_id() {
		if (self::$_analytics_parent_id == 0) {
			$m = self::model()->findByAttributes(array('type_id' => self::ANALYTICS_TYPE_ID));
			self::$_analytics_parent_id = $m->id;
		}
		return self::$_analytics_parent_id;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return Tag the static model class
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
		return '{{_tag}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('show_in_menu, hide_if_not_last, parent_id, type_id, _order, is_bolded', 'numerical', 'integerOnly'=>true),
			array('name, name_en, publication_period', 'length', 'max'=>255),
            array('color', 'length', 'max'=>20),
			array('name', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, show_in_menu, publication_period, _order', 'safe', 'on'=>'search'),
		);
	}
	
	public static function t($name) {
		$lang = Yii::app()->language;
		if ($lang == 'en') {
			$m = self::model()->findByAttributes(array('name' => $name));
			if ($m && (string)$m->name_en != '') {
				return $m->name_en;
			}
			return Helpers::transliterate($name);
		}
		return $name;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			//'analytics' => array(self::MANY_MANY, 'Analytics', 'AnalyticsTag(tag_id, object_id)'),
			//'news' => array(self::MANY_MANY, 'News', 'NewsTag(tag_id, object_id)'),
			//'timeLines' => array(self::MANY_MANY, 'TimeLine', 'TimeLineTag(tag_id, object_id)'),
			'parent' => array(self::BELONGS_TO, 'Tag', 'parent_id'),
			'children' => array(self::HAS_MANY, 'Tag', 'parent_id', 'order' => 'name'),
			'childrenInMenu' => array(self::HAS_MANY, 'Tag', 'parent_id', 'order' => '_order', 'condition' => 'show_in_menu = 1'),
			'childrenCount' => array(self::STAT, 'Tag', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родительский тэг',
			'name' => 'Тэг',
			'name_en' => 'Тэг en',
			'show_in_menu' => 'Показывать в меню',
			'hide_if_not_last' => 'Скрывать если не последний',
            'color' => 'Цвет',
			'publication_period' => 'Период публикации новостей',
			'_order' => 'Сортировка',
			'is_bolded' => 'Выделение полужирным шрифтом',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('show_in_menu',$this->show_in_menu);
		$criteria->compare('hide_if_not_last',$this->hide_if_not_last);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes() {
		return array(
			'menu' => array(
				'condition' => 't.show_in_menu = 1',
			)
		);
	}
	
	public static function firstLevel() {
		$data = self::model()->findAll(array(
			'condition' => 'parent_id is null',
			'order' => 'name',
		));
		return $data;
	}
	
	public static function toList($data) {
		$r = array(''=>'');
		foreach ($data as $i) {
			$r[ $i->name ] = $i->name;
		}
		return $r;
	}

    public static function optionList() {
        $lst = array("" => "");
        $_lst = Tag::firstLevel();
        foreach ($_lst as $elem) {
            $lst[ $elem->id ] = $elem->name;
        }
        return $lst;
    }

	public function getParentsIds() {
        $parents = array();
        $current_el = $this;

    	while($current_el && (int)$current_el->parent_id != 0) {
        	$parents []= (int)$current_el->parent_id;
        	$current_el = $current_el->parent;
        }

        return $parents;
    }
    
    
    public static function parentsList($exclude_id = 0, $extended = false) {
		self::buildTree();
		$result = array(
			'' => '',
		);
		self::parseTree(self::$tree, 0, $result, $exclude_id, $extended);
		return $result;
	}
	
	public static function parseTree($items, $level, &$result, $exclude_id = 0, $extended = false) {
		foreach ($items as $i) {
			if ($i->id == $exclude_id) continue;
			$result[ $i->id ] = $extended ? $i->toSimple(true) : self::getNameWithLevel($i, $level);
			if (count($i->_children) > 0) {
				self::parseTree($i->children, $level + 1, $result, $exclude_id, $extended);
			}
		}
	}
	
	public static function getNameWithLevel($item, $level) {
		$r = "";
		for ($i = 0; $i < $level; $i++) {
			$r .= "&nbsp;&nbsp;&nbsp;";
		}
		$r .= $item->name;
		return $r;
	}
	
	public static function buildTree() {
        if (self::$tree) return self::$tree;
        
        Yii::beginProfile('Tag::buildTree()');
		$data = Yii::app()->db->createCommand("select id as i, parent_id as p, show_in_menu as m, type_id as t, _order as o, name as n, is_bolded as b from agro2b_tag order by name")->queryAll();
		
		self::$map = array();
		foreach( $data as $i ) {
			$o = new LTag($i);
			self::$map[ $o->id ] = $o;
		}

		foreach( self::$map as &$i ) {
			if ($i->parent_id > 0) {
				$el = self::$map[ $i->parent_id ];
				$el->_children []= $i;
			} else {
				self::$tree []= self::$map[ $i->id ];
			}
		}
		Yii::endProfile('Tag::buildTree()');
        return self::$tree;
	}

	public function analyticsTree() {
		$_tree = self::buildTree();
		$analytics_ids = self::analytics_ids();
		$analytics_parent_id = self::analytics_parent_id();
		$tree = array();
		$_p = 0;
		foreach($_tree as $t) {
			if ($t->id == $analytics_parent_id) $_p = $t;
		}
		$tree = $_p->children;
		return $tree;
	}

	public function newsTree() {
		$_tree = self::buildTree();
		$analytics_parent_id = self::analytics_parent_id();
		$tree = array();
		foreach($_tree as $t) {
			if ($t->id != $analytics_parent_id) $tree[] = $t;
		}
		return $tree;
	}
	
	public function beforeSave() {
		if ($this->parent_id == '' or $this->parent_id == 0) {
			$this->parent_id = null;
		}
		return true;
	}

	public static function getTagsInMenu() {
		self::buildTree();
		$items = array_filter(self::$tree, function($el) {
			return ($el->show_in_menu == 1);
		});
		usort($items, function($a, $b) {
			if ($a->_order == $b->_order) return 0;
			return ($a->_order < $b->_order) ? -1 : 1;
		});
		$newItems = array();
		foreach ($items as $i) {
			$parent = $i;
			$children = self::buildMenuTree($i->children);
			$newItems []= array('parent' => $parent , 'children' => $children);
		}
		// raise(count($newItems));
		return $newItems;
	}
	public static function buildMenuTree($tree) {
		$arr = array();
		foreach ($tree as $t) {
			if ($t->show_in_menu == 1) {
				$arr []= $t;
			}
			if ($t->children) {
				$arr = array_merge($arr, self::buildMenuTree($t->children));
			}			
		}
		return $arr;
	}
}
