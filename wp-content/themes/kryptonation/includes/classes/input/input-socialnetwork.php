<?php

class Padd_Input_SocialNetwork {

	protected $keyword;
	protected $value;
	protected $name;
	protected $description;
	protected $properties;

	function __construct($keyword,$name,$description='',$properties=array('type'=>'textfield','width'=>250,'height'=>100)) {
		$this->keyword = $keyword;
		$this->value = unserialize(get_option($this->keyword));
		$this->name = $name;
		$this->description = $description;
		$this->properties = $properties;
	}

	public function get_keyword() {
		return $this->keyword;
	}

	public function set_keyword($keyword) {
		$this->keyword = $keyword;
	}

	public function get_value() {
		return $this->value;
	}

	public function set_value($value) {
		$this->value = $value;
	}

	public function get_name() {
		return $this->name;
	}

	public function set_name($name) {
		$this->name = $name;
	}

	public function get_type() {
		return $this->type;
	}

	public function set_type($type) {
		$this->type = $type;
	}

	public function get_description() {
		return $this->description;
	}

	public function set_description($description) {
		$this->description = $description;
	}

	public function get_properties() {
		return $this->properties;
	}

	public function set_properties($properties) {
		$this->properties = $properties;
	}

	public function __toString() {
		$strHTML  = '';
		$strHTML .= '<tr valign="top">';
		$strHTML .= '	<th scope="row"><label for="' . $this->keyword . '">' . $this->name . '</label></th>';
		$strHTML .= '	<td>';
		switch ($this->properties['type']) {
			default:
			case 'textfield':
				$strHTML .= '<input name="' . $this->keyword . '" type="text" id="' . $this->keyword . '" value="' . $this->value->get_username() . '" style="width: ' . (!empty($this->properties['width']) ? $this->properties['width'] : 500) . 'px" />';
				break;
		}
		$strHTML .= '		<br /><small>' . $this->description . '</small>';
		$strHTML .= '	</td>';
		$strHTML .= '</tr>';
		return $strHTML;
	}

}

?>
