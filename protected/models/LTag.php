<?php class LTag { 
	public $id;
	public $name;
	public $show_in_menu;
	public $parent_id;
	public $type_id;
	public $_order;
	public $is_bolded;
	
	public $_children = array();
	public $children;
	
	#public $_properties = array();
	
	function __construct($data = null) {
		if ($data) {
			$this->id = (int)$data['i'];
			$this->parent_id = (int)$data['p'];
			$this->show_in_menu = (int)$data['m'];
			$this->name = $data['n'];
			$this->type_id = (int)$data['t'];
			$this->_order = (int)$data['o'];
			$this->is_bolded = (int)$data['b'];
		}
		$this->children = &$this->_children;
	}
	
	public function toSimple($deep=false) {
        return $this;
    }
    
    public function __get($property) {
	    if (property_exists($this, $property)) {
		    return $this->$property;
	    }
	    if ($property == 'childrenCount') {
		    return count($this->children);
	    }
	}
}
