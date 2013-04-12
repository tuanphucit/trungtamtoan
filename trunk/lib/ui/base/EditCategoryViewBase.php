<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class EditCategoryViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "EditCategoryView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['id']	= array("type" => "hidden","name" => "id","id" => "id","value" => "","display" => "ID",);
		self::$_property['name']	= array("type" => "text","name" => "name","id" => "name","value" => "","display" => "Tên danh mục","required" => "true","style" => "width:300px;",);
		self::$_property['description']	= array("type" => "text","name" => "description","id" => "description","value" => "","display" => "Mô tả","style" => "width:300px;",);
		self::$_property['parentID']	= array("type" => "select","name" => "parentID","id" => "parentID","value" => "","display" => "Danh mục cha","style" => "width:200px;",);
		self::$_property['status']	= array("type" => "select","name" => "status","id" => "status","value" => "","display" => "Tình trạng","option" => "0: Ẩn| 1: Hiện","style" => "width:200px;",);
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

	function setId($value=null) {
		return (self::$_property['id']['value'] = $value);
	}
	
	function getId() {
		return $this->getHtml('id');
	}
	
	function getHtmlOfId() {
		return $this->getHtml('id');
	}
	
	function getHiddenOfId() {
		return $this->getHidden('id');
	}
	
	function getDisplayOfId() {
		return $this->getDisplay('id');
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

	function setParentID($value=null) {
		return (self::$_property['parentID']['value'] = $value);
	}
	
	function getParentID() {
		return $this->getHtml('parentID');
	}
	
	function getHtmlOfParentID() {
		return $this->getHtml('parentID');
	}
	
	function getHiddenOfParentID() {
		return $this->getHidden('parentID');
	}
	
	function getDisplayOfParentID() {
		return $this->getDisplay('parentID');
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
