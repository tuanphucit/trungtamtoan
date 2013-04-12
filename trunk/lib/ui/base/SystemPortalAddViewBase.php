<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemPortalAddViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemPortalAddView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['portal_name']	= array("type" => "text","name" => "portal_name","id" => "portal_name","value" => "","display" => "lang.portal_name","required" => "true","class" => "validate[required,custom[onlyLetNumSpec]]","style" => "width:300px;",);
		self::$_property['portal_brief']	= array("type" => "textarea","name" => "portal_brief","id" => "portal_brief","value" => "","display" => "lang.portal_brief","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['portal_publish']	= array("type" => "checkbox","name" => "portal_publish","id" => "portal_publish","value" => "1","display" => "lang.enable",);
		self::$_property['portal_btn_OK']	= array("type" => "button-submit","name" => "portal_btn_OK","id" => "portal_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['portal_btn_RESET']	= array("type" => "button-reset","name" => "portal_btn_RESET","id" => "portal_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setPortalName($value=null) {
		return (self::$_property['portal_name']['value'] = $value);
	}
	
	function getPortalName() {
		return $this->getHtml('portal_name');
	}
	
	function getHtmlOfPortalName() {
		return $this->getHtml('portal_name');
	}
	
	function getHiddenOfPortalName() {
		return $this->getHidden('portal_name');
	}
	
	function getDisplayOfPortalName() {
		return $this->getDisplay('portal_name');
	}
	////////////

	function setPortalBrief($value=null) {
		return (self::$_property['portal_brief']['value'] = $value);
	}
	
	function getPortalBrief() {
		return $this->getHtml('portal_brief');
	}
	
	function getHtmlOfPortalBrief() {
		return $this->getHtml('portal_brief');
	}
	
	function getHiddenOfPortalBrief() {
		return $this->getHidden('portal_brief');
	}
	
	function getDisplayOfPortalBrief() {
		return $this->getDisplay('portal_brief');
	}
	////////////

	function setPortalPublish($value=null) {
		return (self::$_property['portal_publish']['value'] = $value);
	}
	
	function getPortalPublish() {
		return $this->getHtml('portal_publish');
	}
	
	function getHtmlOfPortalPublish() {
		return $this->getHtml('portal_publish');
	}
	
	function getHiddenOfPortalPublish() {
		return $this->getHidden('portal_publish');
	}
	
	function getDisplayOfPortalPublish() {
		return $this->getDisplay('portal_publish');
	}
	////////////

	function setPortalBtnOK($value=null) {
		return (self::$_property['portal_btn_OK']['value'] = $value);
	}
	
	function getPortalBtnOK() {
		return $this->getHtml('portal_btn_OK');
	}
	
	function getHtmlOfPortalBtnOK() {
		return $this->getHtml('portal_btn_OK');
	}
	
	function getHiddenOfPortalBtnOK() {
		return $this->getHidden('portal_btn_OK');
	}
	
	function getDisplayOfPortalBtnOK() {
		return $this->getDisplay('portal_btn_OK');
	}
	////////////

	function setPortalBtnRESET($value=null) {
		return (self::$_property['portal_btn_RESET']['value'] = $value);
	}
	
	function getPortalBtnRESET() {
		return $this->getHtml('portal_btn_RESET');
	}
	
	function getHtmlOfPortalBtnRESET() {
		return $this->getHtml('portal_btn_RESET');
	}
	
	function getHiddenOfPortalBtnRESET() {
		return $this->getHidden('portal_btn_RESET');
	}
	
	function getDisplayOfPortalBtnRESET() {
		return $this->getDisplay('portal_btn_RESET');
	}
	////////////

} // end class
