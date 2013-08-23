<?php
/**
 * JSON extension class.
 *
 *
 * @package    Extension
 * @author     Emanuele Ricci
 * @copyright  (c) 2010 Emanuele Ricci
 * @license    http://www.designfuture.it
 */
class CArJSON {
	
	private $owner;
	private $relations;
	private $relations_allowed;
	private $attributes;
	private $jsonString;
	
	/*
	 * array ( 
	 * 		'root'=> array of attributes,
	 * 		'relation_name' => array of attributes,
	 * )
	 * 
	 * if a relation_name is not setted or defined we will take all attributes
	 * 
	 */
	
	public function toJSON( $model, $relations, $attributesAllowed=array()){
		$this->owner = $model;
		$this->relations_allowed = $relations;
		$this->attributes = $attributesAllowed;
		$this->jsonString = '';
		if ( !is_array($this->owner) ) {
			$this->owner = array();
			$this->owner[] = $model;
		}
		return $this->getJSON();
	}
	
	private function getJSON() {
		foreach ( $this->owner as $o ) {
			$result = $this->getJSONModel( $o );
			if ( !$result ) return false; 
			else $this->jsonString .= $result . ',';
		}
		$this->jsonString = substr($this->jsonString, 0, -1);
		if (count($this->owner) > 1) {
			$this->jsonString = '['.$this->jsonString.']';
		}
		return $this->jsonString;
	}
	
	private function getJSONModel( $obj ) {
		if (is_subclass_of($obj,'CActiveRecord')){
			$attributes = $obj->getAttributes( $this->attributes['root'] );
			try {
				$obj->prepareJSON($attributes);
			} catch(Exception $e) {};
			$this->relations = $this->getRelated( $obj );
			$jsonDataSource = array(array_merge($attributes, $this->relations));
			$result = CJSONUTF8::encode($jsonDataSource);
			$result = substr($result, 1, -1);
			return $result;
		}
		return false;
	}
	
	private function getRelated( $m )
	{	
		$related = array();
		$obj = null;
		$md=$m->getMetaData();
		foreach($md->relations as $name=>$relation){
			if ( !in_array($name, $this->relations_allowed ) )
				continue;
			$obj = $m->getRelated($name);
			$attrToTake = empty($this->attributes[$name]) ? NULL : $this->attributes[$name];
			if ($obj instanceof CActiveRecord) {
				$related[$name] = $obj->getAttributes($attrToTake);
				try {
					$obj->prepareJSON($related[$name]);
				} catch(Exception $e) {};
			} else {
				if (is_array($obj) && count($obj) > 0 && $obj[0] instanceof CActiveRecord) {
					$related[$name] = array();
					foreach($obj as $_obj) {
						$_obj_ = $_obj->getAttributes($attrToTake);
						try {
							$_obj->prepareJSON($_obj_);
						} catch(Exception $e) {};
						$related[$name] []= $_obj_;
					}
				} else {
					$related[$name] = $obj;
				}
			}
		}
		return $related;
	}
}