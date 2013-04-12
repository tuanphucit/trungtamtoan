<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class EditDistrictViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "EditDistrictView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['location_id']	= array("type" => "hidden","name" => "location_id","id" => "location_id","value" => "","display" => "ID",);
		self::$_property['provinceID']	= array("type" => "hidden","name" => "provinceID","id" => "provinceID","value" => "","display" => "ID",);
		self::$_property['name']	= array("type" => "text","name" => "name","id" => "name","value" => "","display" => "Tên quận/huyện","required" => "true","style" => "width:300px;",);
		self::$_property['description']	= array("type" => "text","name" => "description","id" => "description","value" => "","display" => "Mô tả","style" => "width:300px;",);
		self::$_property['status']	= array("type" => "select","name" => "status","id" => "status","value" => "","display" => "Tình trạng","option" => "0: Ẩn| 1: Hiện","style" => "width:140px;",);
		// run format and filter data input
		self::filterInput();
	}
	/**
	 * Validate form by javascript
	 * @param unknown_type $is
	 */
	function setValidate($is=false){
		$this->validate = ($is?true:false);
	}
	
	function getValidate(){
		return $this->validate;
	}
	
	function getFormBegin($prop=array()){
		if (is_array($prop)){
			$prop = $prop + $this->form;
		} else {
			$prop = $this->form;
		}
	
		//$form_name = get_called_class();
		$form_name = get_class($this);
		if (!is_array($prop)) return '<form name="'.$form_name.'" id="'.$form_name.'">';
		
		if (!isset($prop['name'])){
			$prop['name'] = $form_name;
		}
		if (!isset($prop['id'])){
			$prop['id'] = $form_name;
		}
		
		// add property of form
		$this->form = $prop;
		
		// build html of form tag
		$html = '<form';
		foreach ($prop as $key => $val){
			$html.= ' '.$key.'="'.$val.'"';
		}
		$html.= '>';
		return $html;
	}
	//////////////////////////////////
	function getFormEnd(){
		$html = '</form>';
		if ($this->validate){
			if (isset($this->form['id'])){
				$form_name = $this->form['id'];
			} else {
				//$form_name = get_called_class();
				$form_name = get_class($this);
			}
			$html.= "\n";
			$html.= '<script type="text/javascript" charset="UTF-8" language="JavaScript">';
			$html.= '$(document).ready(function(){jQuery("#'.$form_name.'").validationEngine();});';
			$html.= '</script>';
			$html.= "\n";
		}
		return $html;
	}

	function setLocationId($value=null) {
		return (self::$_property['location_id']['value'] = $value);
	}
	
	function getLocationId() {
		return $this->getHtml('location_id');
	}
	
	function getHtmlOfLocationId() {
		return $this->getHtml('location_id');
	}
	
	function getHiddenOfLocationId() {
		return $this->getHidden('location_id');
	}
	
	function getDisplayOfLocationId() {
		return $this->getDisplay('location_id');
	}
	////////////

	function setProvinceID($value=null) {
		return (self::$_property['provinceID']['value'] = $value);
	}
	
	function getProvinceID() {
		return $this->getHtml('provinceID');
	}
	
	function getHtmlOfProvinceID() {
		return $this->getHtml('provinceID');
	}
	
	function getHiddenOfProvinceID() {
		return $this->getHidden('provinceID');
	}
	
	function getDisplayOfProvinceID() {
		return $this->getDisplay('provinceID');
	}
	////////////

	function setName($value=null) {
		return (self::$_property['name']['value'] = $value);
	}
	
	function getName() {
		return $this->getHtml('name');
	}
	
	function getHtmlOfName() {
		return $this->getHtml('name');
	}
	
	function getHiddenOfName() {
		return $this->getHidden('name');
	}
	
	function getDisplayOfName() {
		return $this->getDisplay('name');
	}
	////////////

	function setDescription($value=null) {
		return (self::$_property['description']['value'] = $value);
	}
	
	function getDescription() {
		return $this->getHtml('description');
	}
	
	function getHtmlOfDescription() {
		return $this->getHtml('description');
	}
	
	function getHiddenOfDescription() {
		return $this->getHidden('description');
	}
	
	function getDisplayOfDescription() {
		return $this->getDisplay('description');
	}
	////////////

	function setStatus($value=null) {
		return (self::$_property['status']['value'] = $value);
	}
	
	function getStatus() {
		return $this->getHtml('status');
	}
	
	function getHtmlOfStatus() {
		return $this->getHtml('status');
	}
	
	function getHiddenOfStatus() {
		return $this->getHidden('status');
	}
	
	function getDisplayOfStatus() {
		return $this->getDisplay('status');
	}
	////////////

} // end class
