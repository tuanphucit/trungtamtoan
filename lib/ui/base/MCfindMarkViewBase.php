<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class MCfindMarkViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "MCfindMarkView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['name_search']	= array("type" => "text","name" => "name_search","id" => "name_search","value" => "","style" => "width:300px;",);
		self::$_property['university']	= array("type" => "select","name" => "university","id" => "university","value" => "","display" => "university","style" => "width:300px;",);
		self::$_property['searchType']	= array("type" => "select","name" => "searchType","id" => "searchType","value" => "","option" => "sbd:Số báo danh|ten : Tên","style" => "width:200px;",);
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

	function setNameSearch($value=null) {
		return (self::$_property['name_search']['value'] = $value);
	}
	
	function getNameSearch() {
		return $this->getHtml('name_search');
	}
	
	function getHtmlOfNameSearch() {
		return $this->getHtml('name_search');
	}
	
	function getHiddenOfNameSearch() {
		return $this->getHidden('name_search');
	}
	
	function getDisplayOfNameSearch() {
		return $this->getDisplay('name_search');
	}
	////////////

	function setUniversity($value=null) {
		return (self::$_property['university']['value'] = $value);
	}
	
	function getUniversity() {
		return $this->getHtml('university');
	}
	
	function getHtmlOfUniversity() {
		return $this->getHtml('university');
	}
	
	function getHiddenOfUniversity() {
		return $this->getHidden('university');
	}
	
	function getDisplayOfUniversity() {
		return $this->getDisplay('university');
	}
	////////////

	function setSearchType($value=null) {
		return (self::$_property['searchType']['value'] = $value);
	}
	
	function getSearchType() {
		return $this->getHtml('searchType');
	}
	
	function getHtmlOfSearchType() {
		return $this->getHtml('searchType');
	}
	
	function getHiddenOfSearchType() {
		return $this->getHidden('searchType');
	}
	
	function getDisplayOfSearchType() {
		return $this->getDisplay('searchType');
	}
	////////////

} // end class
