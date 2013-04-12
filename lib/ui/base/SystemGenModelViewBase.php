<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemGenModelViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemGenModelView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['connection']	= array("type" => "select","name" => "connection","value" => "","display" => "connection","required" => "true",);
		self::$_property['customTable']	= array("type" => "checkbox","name" => "customTable","id" => "customTable","value" => "1","display" => "Chọn bảng",);
		self::$_property['checkall']	= array("type" => "checkbox","name" => "checkall","id" => "checkall","value" => "1","class" => "itemCheckall","rel" => "itemLs",);
		self::$_property['item']	= array("type" => "checkbox","name" => "item","id" => "item","value" => "1","class" => "itemLs",);
		self::$_property['gen_btn_OK']	= array("type" => "button-submit","name" => "gen_btn_OK","id" => "gen_btn_OK","value" => "","display" => "General MODEL","class" => "submit",);
		self::$_property['gen_btn_RESET']	= array("type" => "button-reset","name" => "gen_btn_RESET","id" => "gen_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setConnection($value=null) {
		return (self::$_property['connection']['value'] = $value);
	}
	
	function getConnection() {
		return $this->getHtml('connection');
	}
	
	function getHtmlOfConnection() {
		return $this->getHtml('connection');
	}
	
	function getHiddenOfConnection() {
		return $this->getHidden('connection');
	}
	
	function getDisplayOfConnection() {
		return $this->getDisplay('connection');
	}
	////////////

	function setCustomTable($value=null) {
		return (self::$_property['customTable']['value'] = $value);
	}
	
	function getCustomTable() {
		return $this->getHtml('customTable');
	}
	
	function getHtmlOfCustomTable() {
		return $this->getHtml('customTable');
	}
	
	function getHiddenOfCustomTable() {
		return $this->getHidden('customTable');
	}
	
	function getDisplayOfCustomTable() {
		return $this->getDisplay('customTable');
	}
	////////////

	function setCheckall($value=null) {
		return (self::$_property['checkall']['value'] = $value);
	}
	
	function getCheckall() {
		return $this->getHtml('checkall');
	}
	
	function getHtmlOfCheckall() {
		return $this->getHtml('checkall');
	}
	
	function getHiddenOfCheckall() {
		return $this->getHidden('checkall');
	}
	
	function getDisplayOfCheckall() {
		return $this->getDisplay('checkall');
	}
	////////////

	function setItem($value=null) {
		return (self::$_property['item']['value'] = $value);
	}
	
	function getItem() {
		return $this->getHtml('item');
	}
	
	function getHtmlOfItem() {
		return $this->getHtml('item');
	}
	
	function getHiddenOfItem() {
		return $this->getHidden('item');
	}
	
	function getDisplayOfItem() {
		return $this->getDisplay('item');
	}
	////////////

	function setGenBtnOK($value=null) {
		return (self::$_property['gen_btn_OK']['value'] = $value);
	}
	
	function getGenBtnOK() {
		return $this->getHtml('gen_btn_OK');
	}
	
	function getHtmlOfGenBtnOK() {
		return $this->getHtml('gen_btn_OK');
	}
	
	function getHiddenOfGenBtnOK() {
		return $this->getHidden('gen_btn_OK');
	}
	
	function getDisplayOfGenBtnOK() {
		return $this->getDisplay('gen_btn_OK');
	}
	////////////

	function setGenBtnRESET($value=null) {
		return (self::$_property['gen_btn_RESET']['value'] = $value);
	}
	
	function getGenBtnRESET() {
		return $this->getHtml('gen_btn_RESET');
	}
	
	function getHtmlOfGenBtnRESET() {
		return $this->getHtml('gen_btn_RESET');
	}
	
	function getHiddenOfGenBtnRESET() {
		return $this->getHidden('gen_btn_RESET');
	}
	
	function getDisplayOfGenBtnRESET() {
		return $this->getDisplay('gen_btn_RESET');
	}
	////////////

} // end class
