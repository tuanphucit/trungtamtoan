<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemLoginViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemLoginView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['username']	= array("type" => "text","name" => "username","value" => "","display" => "Username","required" => "true","maxsize" => "255","validateType" => "Text","maxlength" => "255","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['password']	= array("type" => "password","name" => "password","value" => "","display" => "Password","required" => "true","maxsize" => "255","validateType" => "Text","maxlength" => "255","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['save_password']	= array("type" => "checkbox","name" => "save_password","value" => "","display" => "Nhớ Pass","required" => "false",);
		self::$_property['login_btn_OK']	= array("type" => "button-submit","name" => "login_btn_OK","value" => "","display" => "Đăng nhập","class" => "submit",);
		self::$_property['login_btn_RESET']	= array("type" => "button-reset","name" => "login_btn_RESET","value" => "","display" => "Hủy","class" => "submit",);
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

	function setUsername($value=null) {
		return (self::$_property['username']['value'] = $value);
	}
	
	function getUsername() {
		return $this->getHtml('username');
	}
	
	function getHtmlOfUsername() {
		return $this->getHtml('username');
	}
	
	function getHiddenOfUsername() {
		return $this->getHidden('username');
	}
	
	function getDisplayOfUsername() {
		return $this->getDisplay('username');
	}
	////////////

	function setPassword($value=null) {
		return (self::$_property['password']['value'] = $value);
	}
	
	function getPassword() {
		return $this->getHtml('password');
	}
	
	function getHtmlOfPassword() {
		return $this->getHtml('password');
	}
	
	function getHiddenOfPassword() {
		return $this->getHidden('password');
	}
	
	function getDisplayOfPassword() {
		return $this->getDisplay('password');
	}
	////////////

	function setSavePassword($value=null) {
		return (self::$_property['save_password']['value'] = $value);
	}
	
	function getSavePassword() {
		return $this->getHtml('save_password');
	}
	
	function getHtmlOfSavePassword() {
		return $this->getHtml('save_password');
	}
	
	function getHiddenOfSavePassword() {
		return $this->getHidden('save_password');
	}
	
	function getDisplayOfSavePassword() {
		return $this->getDisplay('save_password');
	}
	////////////

	function setLoginBtnOK($value=null) {
		return (self::$_property['login_btn_OK']['value'] = $value);
	}
	
	function getLoginBtnOK() {
		return $this->getHtml('login_btn_OK');
	}
	
	function getHtmlOfLoginBtnOK() {
		return $this->getHtml('login_btn_OK');
	}
	
	function getHiddenOfLoginBtnOK() {
		return $this->getHidden('login_btn_OK');
	}
	
	function getDisplayOfLoginBtnOK() {
		return $this->getDisplay('login_btn_OK');
	}
	////////////

	function setLoginBtnRESET($value=null) {
		return (self::$_property['login_btn_RESET']['value'] = $value);
	}
	
	function getLoginBtnRESET() {
		return $this->getHtml('login_btn_RESET');
	}
	
	function getHtmlOfLoginBtnRESET() {
		return $this->getHtml('login_btn_RESET');
	}
	
	function getHiddenOfLoginBtnRESET() {
		return $this->getHidden('login_btn_RESET');
	}
	
	function getDisplayOfLoginBtnRESET() {
		return $this->getDisplay('login_btn_RESET');
	}
	////////////

} // end class
