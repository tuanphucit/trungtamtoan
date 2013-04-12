<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemSettingViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemSettingView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['rewrite_url']	= array("type" => "checkbox","name" => "rewrite_url","value" => "","display" => "Cho phép sử dụng REWRITE URL",);
		self::$_property['setting_btn_OK']	= array("type" => "button-submit","name" => "setting_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['setting_btn_RESET']	= array("type" => "button-reset","name" => "setting_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setRewriteUrl($value=null) {
		return (self::$_property['rewrite_url']['value'] = $value);
	}
	
	function getRewriteUrl() {
		return $this->getHtml('rewrite_url');
	}
	
	function getHtmlOfRewriteUrl() {
		return $this->getHtml('rewrite_url');
	}
	
	function getHiddenOfRewriteUrl() {
		return $this->getHidden('rewrite_url');
	}
	
	function getDisplayOfRewriteUrl() {
		return $this->getDisplay('rewrite_url');
	}
	////////////

	function setSettingBtnOK($value=null) {
		return (self::$_property['setting_btn_OK']['value'] = $value);
	}
	
	function getSettingBtnOK() {
		return $this->getHtml('setting_btn_OK');
	}
	
	function getHtmlOfSettingBtnOK() {
		return $this->getHtml('setting_btn_OK');
	}
	
	function getHiddenOfSettingBtnOK() {
		return $this->getHidden('setting_btn_OK');
	}
	
	function getDisplayOfSettingBtnOK() {
		return $this->getDisplay('setting_btn_OK');
	}
	////////////

	function setSettingBtnRESET($value=null) {
		return (self::$_property['setting_btn_RESET']['value'] = $value);
	}
	
	function getSettingBtnRESET() {
		return $this->getHtml('setting_btn_RESET');
	}
	
	function getHtmlOfSettingBtnRESET() {
		return $this->getHtml('setting_btn_RESET');
	}
	
	function getHiddenOfSettingBtnRESET() {
		return $this->getHidden('setting_btn_RESET');
	}
	
	function getDisplayOfSettingBtnRESET() {
		return $this->getDisplay('setting_btn_RESET');
	}
	////////////

} // end class
