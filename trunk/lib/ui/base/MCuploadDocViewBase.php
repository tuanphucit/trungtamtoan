<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class MCuploadDocViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "MCuploadDocView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['name']	= array("type" => "text","name" => "name","id" => "name","value" => "","display" => "Name","required" => "true","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['description']	= array("type" => "textarea","name" => "description","id" => "description","value" => "","display" => "description","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['classID']	= array("type" => "select","name" => "classID","id" => "classID","value" => "","display" => "classID","style" => "width:140px;",);
		self::$_property['CateID']	= array("type" => "select","name" => "CateID","id" => "CateID","value" => "","display" => "CateID","style" => "width:140px;",);
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

	function setClassID($value=null) {
		return (self::$_property['classID']['value'] = $value);
	}
	
	function getClassID() {
		return $this->getHtml('classID');
	}
	
	function getHtmlOfClassID() {
		return $this->getHtml('classID');
	}
	
	function getHiddenOfClassID() {
		return $this->getHidden('classID');
	}
	
	function getDisplayOfClassID() {
		return $this->getDisplay('classID');
	}
	////////////

	function setCateID($value=null) {
		return (self::$_property['CateID']['value'] = $value);
	}
	
	function getCateID() {
		return $this->getHtml('CateID');
	}
	
	function getHtmlOfCateID() {
		return $this->getHtml('CateID');
	}
	
	function getHiddenOfCateID() {
		return $this->getHidden('CateID');
	}
	
	function getDisplayOfCateID() {
		return $this->getDisplay('CateID');
	}
	////////////

} // end class
