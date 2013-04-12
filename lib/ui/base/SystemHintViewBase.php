<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemHintViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemHintView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['hint_layout_enable']	= array("type" => "checkbox","name" => "hint_layout_enable","value" => "1","display" => "Bật hint Layout","required" => "false","field" => "setting.layout_publish","option" => "1:Bật Hint Layout",);
		self::$_property['hint_layout_color']	= array("type" => "text","name" => "hint_layout_color","value" => "","display" => "Border-Color","field" => "setting.layout_color","validateType" => "Text","size" => "7","readonly" => "readonly",);
		self::$_property['hint_layout_style']	= array("type" => "select","name" => "hint_layout_style","value" => "dotted","display" => "Border-Style","option" => "none:none|hidden:hidden|dotted:dotted|dashed:dashed|solid:solid|double:double|groove:groove|ridge:ridge|inset:inset|outset:outset|inherit:inherit",);
		self::$_property['hint_layout_width']	= array("type" => "radio","name" => "hint_layout_width","value" => "1px","display" => "Border-Width","option" => "0px:0px|1px:1px|2px:2px|3px:3px",);
		self::$_property['hint_block_enable']	= array("type" => "checkbox","name" => "hint_block_enable","value" => "1","display" => "Bật hint Block","required" => "false","field" => "setting.block_publish",);
		self::$_property['hint_block_color']	= array("type" => "text","name" => "hint_block_color","value" => "","display" => "Border-Color","field" => "setting.block_color","validateType" => "Text","size" => "7","readonly" => "readonly",);
		self::$_property['hint_block_style']	= array("type" => "select","name" => "hint_block_style","value" => "dashed","display" => "Border-Style","option" => "none:none|hidden:hidden|dotted:dotted|dashed:dashed|solid:solid|double:double|groove:groove|ridge:ridge|inset:inset|outset:outset|inherit:inherit",);
		self::$_property['hint_block_width']	= array("type" => "radio","name" => "hint_block_width","value" => "1px","display" => "Border-Width","option" => "0px:0px|1px:1px|2px:2px|3px:3px",);
		self::$_property['hint_system_module_enable']	= array("type" => "checkbox","name" => "hint_system_module_enable","value" => "","display" => "Cho phép tác dụng system",);
		self::$_property['hint_btn_OK']	= array("type" => "button-submit","name" => "hint_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['hint_btn_RESET']	= array("type" => "button-reset","name" => "hint_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setHintLayoutEnable($value=null) {
		return (self::$_property['hint_layout_enable']['value'] = $value);
	}
	
	function getHintLayoutEnable() {
		return $this->getHtml('hint_layout_enable');
	}
	
	function getHtmlOfHintLayoutEnable() {
		return $this->getHtml('hint_layout_enable');
	}
	
	function getHiddenOfHintLayoutEnable() {
		return $this->getHidden('hint_layout_enable');
	}
	
	function getDisplayOfHintLayoutEnable() {
		return $this->getDisplay('hint_layout_enable');
	}
	////////////

	function setHintLayoutColor($value=null) {
		return (self::$_property['hint_layout_color']['value'] = $value);
	}
	
	function getHintLayoutColor() {
		return $this->getHtml('hint_layout_color');
	}
	
	function getHtmlOfHintLayoutColor() {
		return $this->getHtml('hint_layout_color');
	}
	
	function getHiddenOfHintLayoutColor() {
		return $this->getHidden('hint_layout_color');
	}
	
	function getDisplayOfHintLayoutColor() {
		return $this->getDisplay('hint_layout_color');
	}
	////////////

	function setHintLayoutStyle($value=null) {
		return (self::$_property['hint_layout_style']['value'] = $value);
	}
	
	function getHintLayoutStyle() {
		return $this->getHtml('hint_layout_style');
	}
	
	function getHtmlOfHintLayoutStyle() {
		return $this->getHtml('hint_layout_style');
	}
	
	function getHiddenOfHintLayoutStyle() {
		return $this->getHidden('hint_layout_style');
	}
	
	function getDisplayOfHintLayoutStyle() {
		return $this->getDisplay('hint_layout_style');
	}
	////////////

	function setHintLayoutWidth($value=null) {
		return (self::$_property['hint_layout_width']['value'] = $value);
	}
	
	function getHintLayoutWidth() {
		return $this->getHtml('hint_layout_width');
	}
	
	function getHtmlOfHintLayoutWidth() {
		return $this->getHtml('hint_layout_width');
	}
	
	function getHiddenOfHintLayoutWidth() {
		return $this->getHidden('hint_layout_width');
	}
	
	function getDisplayOfHintLayoutWidth() {
		return $this->getDisplay('hint_layout_width');
	}
	////////////

	function setHintBlockEnable($value=null) {
		return (self::$_property['hint_block_enable']['value'] = $value);
	}
	
	function getHintBlockEnable() {
		return $this->getHtml('hint_block_enable');
	}
	
	function getHtmlOfHintBlockEnable() {
		return $this->getHtml('hint_block_enable');
	}
	
	function getHiddenOfHintBlockEnable() {
		return $this->getHidden('hint_block_enable');
	}
	
	function getDisplayOfHintBlockEnable() {
		return $this->getDisplay('hint_block_enable');
	}
	////////////

	function setHintBlockColor($value=null) {
		return (self::$_property['hint_block_color']['value'] = $value);
	}
	
	function getHintBlockColor() {
		return $this->getHtml('hint_block_color');
	}
	
	function getHtmlOfHintBlockColor() {
		return $this->getHtml('hint_block_color');
	}
	
	function getHiddenOfHintBlockColor() {
		return $this->getHidden('hint_block_color');
	}
	
	function getDisplayOfHintBlockColor() {
		return $this->getDisplay('hint_block_color');
	}
	////////////

	function setHintBlockStyle($value=null) {
		return (self::$_property['hint_block_style']['value'] = $value);
	}
	
	function getHintBlockStyle() {
		return $this->getHtml('hint_block_style');
	}
	
	function getHtmlOfHintBlockStyle() {
		return $this->getHtml('hint_block_style');
	}
	
	function getHiddenOfHintBlockStyle() {
		return $this->getHidden('hint_block_style');
	}
	
	function getDisplayOfHintBlockStyle() {
		return $this->getDisplay('hint_block_style');
	}
	////////////

	function setHintBlockWidth($value=null) {
		return (self::$_property['hint_block_width']['value'] = $value);
	}
	
	function getHintBlockWidth() {
		return $this->getHtml('hint_block_width');
	}
	
	function getHtmlOfHintBlockWidth() {
		return $this->getHtml('hint_block_width');
	}
	
	function getHiddenOfHintBlockWidth() {
		return $this->getHidden('hint_block_width');
	}
	
	function getDisplayOfHintBlockWidth() {
		return $this->getDisplay('hint_block_width');
	}
	////////////

	function setHintSystemModuleEnable($value=null) {
		return (self::$_property['hint_system_module_enable']['value'] = $value);
	}
	
	function getHintSystemModuleEnable() {
		return $this->getHtml('hint_system_module_enable');
	}
	
	function getHtmlOfHintSystemModuleEnable() {
		return $this->getHtml('hint_system_module_enable');
	}
	
	function getHiddenOfHintSystemModuleEnable() {
		return $this->getHidden('hint_system_module_enable');
	}
	
	function getDisplayOfHintSystemModuleEnable() {
		return $this->getDisplay('hint_system_module_enable');
	}
	////////////

	function setHintBtnOK($value=null) {
		return (self::$_property['hint_btn_OK']['value'] = $value);
	}
	
	function getHintBtnOK() {
		return $this->getHtml('hint_btn_OK');
	}
	
	function getHtmlOfHintBtnOK() {
		return $this->getHtml('hint_btn_OK');
	}
	
	function getHiddenOfHintBtnOK() {
		return $this->getHidden('hint_btn_OK');
	}
	
	function getDisplayOfHintBtnOK() {
		return $this->getDisplay('hint_btn_OK');
	}
	////////////

	function setHintBtnRESET($value=null) {
		return (self::$_property['hint_btn_RESET']['value'] = $value);
	}
	
	function getHintBtnRESET() {
		return $this->getHtml('hint_btn_RESET');
	}
	
	function getHtmlOfHintBtnRESET() {
		return $this->getHtml('hint_btn_RESET');
	}
	
	function getHiddenOfHintBtnRESET() {
		return $this->getHidden('hint_btn_RESET');
	}
	
	function getDisplayOfHintBtnRESET() {
		return $this->getDisplay('hint_btn_RESET');
	}
	////////////

} // end class
