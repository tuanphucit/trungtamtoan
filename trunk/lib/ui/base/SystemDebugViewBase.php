<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemDebugViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemDebugView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['debug_enable']	= array("type" => "checkbox","name" => "debug_enable","value" => "","display" => "DEBUG ENABLE",);
		self::$_property['debug_error']	= array("type" => "checkbox","name" => "debug_error","value" => "","display" => "ERROR",);
		self::$_property['debug_general_information']	= array("type" => "checkbox","name" => "debug_general_information","value" => "","display" => "GENERAL INFORMATION",);
		self::$_property['debug_layout_position_flugin']	= array("type" => "checkbox","name" => "debug_layout_position_flugin","value" => "","display" => "LAYOUT POSITION FLUGIN",);
		self::$_property['debug_sql_query']	= array("type" => "checkbox","name" => "debug_sql_query","value" => "","display" => "SQL QUERY",);
		self::$_property['debug_includes_file']	= array("type" => "checkbox","name" => "debug_includes_file","value" => "","display" => "INCLUDES FILE",);
		self::$_property['debug_var']	= array("type" => "checkbox","name" => "debug_var","value" => "","display" => "VAR",);
		self::$_property['debug_request']	= array("type" => "checkbox","name" => "debug_request","value" => "","display" => "REQUEST",);
		self::$_property['debug_lang']	= array("type" => "checkbox","name" => "debug_lang","value" => "","display" => "LANG",);
		self::$_property['debug_btn_OK']	= array("type" => "button-submit","name" => "debug_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['debug_btn_RESET']	= array("type" => "button-reset","name" => "debug_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setDebugEnable($value=null) {
		return (self::$_property['debug_enable']['value'] = $value);
	}
	
	function getDebugEnable() {
		return $this->getHtml('debug_enable');
	}
	
	function getHtmlOfDebugEnable() {
		return $this->getHtml('debug_enable');
	}
	
	function getHiddenOfDebugEnable() {
		return $this->getHidden('debug_enable');
	}
	
	function getDisplayOfDebugEnable() {
		return $this->getDisplay('debug_enable');
	}
	////////////

	function setDebugError($value=null) {
		return (self::$_property['debug_error']['value'] = $value);
	}
	
	function getDebugError() {
		return $this->getHtml('debug_error');
	}
	
	function getHtmlOfDebugError() {
		return $this->getHtml('debug_error');
	}
	
	function getHiddenOfDebugError() {
		return $this->getHidden('debug_error');
	}
	
	function getDisplayOfDebugError() {
		return $this->getDisplay('debug_error');
	}
	////////////

	function setDebugGeneralInformation($value=null) {
		return (self::$_property['debug_general_information']['value'] = $value);
	}
	
	function getDebugGeneralInformation() {
		return $this->getHtml('debug_general_information');
	}
	
	function getHtmlOfDebugGeneralInformation() {
		return $this->getHtml('debug_general_information');
	}
	
	function getHiddenOfDebugGeneralInformation() {
		return $this->getHidden('debug_general_information');
	}
	
	function getDisplayOfDebugGeneralInformation() {
		return $this->getDisplay('debug_general_information');
	}
	////////////

	function setDebugLayoutPositionFlugin($value=null) {
		return (self::$_property['debug_layout_position_flugin']['value'] = $value);
	}
	
	function getDebugLayoutPositionFlugin() {
		return $this->getHtml('debug_layout_position_flugin');
	}
	
	function getHtmlOfDebugLayoutPositionFlugin() {
		return $this->getHtml('debug_layout_position_flugin');
	}
	
	function getHiddenOfDebugLayoutPositionFlugin() {
		return $this->getHidden('debug_layout_position_flugin');
	}
	
	function getDisplayOfDebugLayoutPositionFlugin() {
		return $this->getDisplay('debug_layout_position_flugin');
	}
	////////////

	function setDebugSqlQuery($value=null) {
		return (self::$_property['debug_sql_query']['value'] = $value);
	}
	
	function getDebugSqlQuery() {
		return $this->getHtml('debug_sql_query');
	}
	
	function getHtmlOfDebugSqlQuery() {
		return $this->getHtml('debug_sql_query');
	}
	
	function getHiddenOfDebugSqlQuery() {
		return $this->getHidden('debug_sql_query');
	}
	
	function getDisplayOfDebugSqlQuery() {
		return $this->getDisplay('debug_sql_query');
	}
	////////////

	function setDebugIncludesFile($value=null) {
		return (self::$_property['debug_includes_file']['value'] = $value);
	}
	
	function getDebugIncludesFile() {
		return $this->getHtml('debug_includes_file');
	}
	
	function getHtmlOfDebugIncludesFile() {
		return $this->getHtml('debug_includes_file');
	}
	
	function getHiddenOfDebugIncludesFile() {
		return $this->getHidden('debug_includes_file');
	}
	
	function getDisplayOfDebugIncludesFile() {
		return $this->getDisplay('debug_includes_file');
	}
	////////////

	function setDebugVar($value=null) {
		return (self::$_property['debug_var']['value'] = $value);
	}
	
	function getDebugVar() {
		return $this->getHtml('debug_var');
	}
	
	function getHtmlOfDebugVar() {
		return $this->getHtml('debug_var');
	}
	
	function getHiddenOfDebugVar() {
		return $this->getHidden('debug_var');
	}
	
	function getDisplayOfDebugVar() {
		return $this->getDisplay('debug_var');
	}
	////////////

	function setDebugRequest($value=null) {
		return (self::$_property['debug_request']['value'] = $value);
	}
	
	function getDebugRequest() {
		return $this->getHtml('debug_request');
	}
	
	function getHtmlOfDebugRequest() {
		return $this->getHtml('debug_request');
	}
	
	function getHiddenOfDebugRequest() {
		return $this->getHidden('debug_request');
	}
	
	function getDisplayOfDebugRequest() {
		return $this->getDisplay('debug_request');
	}
	////////////

	function setDebugLang($value=null) {
		return (self::$_property['debug_lang']['value'] = $value);
	}
	
	function getDebugLang() {
		return $this->getHtml('debug_lang');
	}
	
	function getHtmlOfDebugLang() {
		return $this->getHtml('debug_lang');
	}
	
	function getHiddenOfDebugLang() {
		return $this->getHidden('debug_lang');
	}
	
	function getDisplayOfDebugLang() {
		return $this->getDisplay('debug_lang');
	}
	////////////

	function setDebugBtnOK($value=null) {
		return (self::$_property['debug_btn_OK']['value'] = $value);
	}
	
	function getDebugBtnOK() {
		return $this->getHtml('debug_btn_OK');
	}
	
	function getHtmlOfDebugBtnOK() {
		return $this->getHtml('debug_btn_OK');
	}
	
	function getHiddenOfDebugBtnOK() {
		return $this->getHidden('debug_btn_OK');
	}
	
	function getDisplayOfDebugBtnOK() {
		return $this->getDisplay('debug_btn_OK');
	}
	////////////

	function setDebugBtnRESET($value=null) {
		return (self::$_property['debug_btn_RESET']['value'] = $value);
	}
	
	function getDebugBtnRESET() {
		return $this->getHtml('debug_btn_RESET');
	}
	
	function getHtmlOfDebugBtnRESET() {
		return $this->getHtml('debug_btn_RESET');
	}
	
	function getHiddenOfDebugBtnRESET() {
		return $this->getHidden('debug_btn_RESET');
	}
	
	function getDisplayOfDebugBtnRESET() {
		return $this->getDisplay('debug_btn_RESET');
	}
	////////////

} // end class
