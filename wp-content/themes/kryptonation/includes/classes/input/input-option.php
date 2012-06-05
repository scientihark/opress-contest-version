<?php

class Padd_Input_Option {

	protected $keyword;
	protected $value;
	protected $name;
	protected $description;
	protected $properties;

	function __construct($keyword,$name,$description='',$properties=array('type'=>'textfield','width'=>500,'height'=>100)) {
		$this->keyword = $keyword;
		$this->value = '';
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
				$strHTML .= '<input name="' . $this->keyword . '" type="text" id="' . $this->keyword . '" value="' . $this->value . '" style="width: ' . (!empty($this->properties['width']) ? $this->properties['width'] : 500) . 'px" />';
				break;
			case 'textarea':
				$strHTML .= '<textarea name="' . $this->keyword . '" id="' . $this->keyword . '" style="width: ' . (!empty($this->properties['width']) ? $this->properties['width'] : 500) . 'px; height: ' . (!empty($this->properties['height']) ? $this->properties['height'] : 100) . 'px;">' . stripslashes($this->value). '</textarea>';
				break;
			case 'category':
				$strHTML .= wp_dropdown_categories('name=' . $this->keyword . '&echo=0&selected=' . $this->value . '&class=');
				break;
			case 'page':
				$strHTML .= wp_dropdown_pages("name=" . $this->keyword . "&echo=0&show_option_none=".__('- Select -')."&selected=" . $this->value);
				break;
			case 'dropdown':
				$strHTML .= '<select name="' . $this->keyword . '" id="' . $this->keyword . '">';
				foreach ($this->properties['choices'] as $k => $v) {
					if ($this->value === $k) {
						$strHTML .= '<option selected="selected" value="' . $k . '">' . $v . '</option>';
					} else {
						$strHTML .= '<option value="' . $k . '">' . $v . '</option>';
					}
				}
				$strHTML .= '</select>';
				break;
			case 'checkbox':
				$strHTML .= '<input name="' . $this->keyword . '" type="checkbox" id="' . $this->keyword . '" value="1"' . ($this->value === '1' ? ' checked="checked"': '') . ' />';
				break;
		}
		$strHTML .= '		<br /><small>' . $this->description . '</small>';
		$strHTML .= '	</td>';
		$strHTML .= '</tr>';
		return $strHTML;
	}

}

?>
