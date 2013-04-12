<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemPageEditViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemPageEditView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['page_id']	= array("type" => "hidden","name" => "page_id","id" => "page_id","value" => "","display" => "Page ID",);
		self::$_property['page_name']	= array("type" => "text","name" => "page_name","id" => "page_name","value" => "","display" => "lang.page_name","required" => "true","class" => "validate[required,custom[onlyLetNumSpec]]","style" => "width:300px;",);
		self::$_property['brief']	= array("type" => "textarea","name" => "brief","id" => "brief","value" => "","display" => "lang.page_brief","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['layout']	= array("type" => "select","name" => "layout","value" => "","display" => "layout","required" => "true",);
		self::$_property['master_page_id']	= array("type" => "text","name" => "master_page_id","id" => "master_page_id","value" => "","display" => "lang.master_page_id","required" => "true","class" => "validate[required,custom[onlyNumberSp]]","style" => "width:100px;",);
		self::$_property['portal_id']	= array("type" => "select","name" => "portal_id","value" => "","display" => "portal_id","required" => "true","class" => "validate[required,custom[onlyNumberSp]]",);
		self::$_property['publish']	= array("type" => "checkbox","name" => "publish","id" => "publish","value" => "1","display" => "lang.enable",);
		self::$_property['page_title']	= array("type" => "text","name" => "page_title","id" => "page_title","value" => "","display" => "lang.page_title","style" => "width:300px;",);
		self::$_property['page_description']	= array("type" => "text","name" => "page_description","id" => "page_description","value" => "","display" => "lang.page_description","style" => "width:300px;",);
		self::$_property['page_keyword']	= array("type" => "textarea","name" => "page_keyword","id" => "page_keyword","value" => "","display" => "lang.page_keyword","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['empty_module']	= array("type" => "checkbox","name" => "empty_module","id" => "empty_module","value" => "","display" => "lang.empty_module","option" => "1:Xóa tất cả các module đã cắm",);
		self::$_property['page_btn_OK']	= array("type" => "button-submit","name" => "page_btn_OK","id" => "page_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['page_btn_RESET']	= array("type" => "button-reset","name" => "page_btn_RESET","id" => "page_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setPageId($value=null) {
		return (self::$_property['page_id']['value'] = $value);
	}
	
	function getPageId() {
		return $this->getHtml('page_id');
	}
	
	function getHtmlOfPageId() {
		return $this->getHtml('page_id');
	}
	
	function getHiddenOfPageId() {
		return $this->getHidden('page_id');
	}
	
	function getDisplayOfPageId() {
		return $this->getDisplay('page_id');
	}
	////////////

	function setPageName($value=null) {
		return (self::$_property['page_name']['value'] = $value);
	}
	
	function getPageName() {
		return $this->getHtml('page_name');
	}
	
	function getHtmlOfPageName() {
		return $this->getHtml('page_name');
	}
	
	function getHiddenOfPageName() {
		return $this->getHidden('page_name');
	}
	
	function getDisplayOfPageName() {
		return $this->getDisplay('page_name');
	}
	////////////

	function setBrief($value=null) {
		return (self::$_property['brief']['value'] = $value);
	}
	
	function getBrief() {
		return $this->getHtml('brief');
	}
	
	function getHtmlOfBrief() {
		return $this->getHtml('brief');
	}
	
	function getHiddenOfBrief() {
		return $this->getHidden('brief');
	}
	
	function getDisplayOfBrief() {
		return $this->getDisplay('brief');
	}
	////////////

	function setLayout($value=null) {
		return (self::$_property['layout']['value'] = $value);
	}
	
	function getLayout() {
		return $this->getHtml('layout');
	}
	
	function getHtmlOfLayout() {
		return $this->getHtml('layout');
	}
	
	function getHiddenOfLayout() {
		return $this->getHidden('layout');
	}
	
	function getDisplayOfLayout() {
		return $this->getDisplay('layout');
	}
	////////////

	function setMasterPageId($value=null) {
		return (self::$_property['master_page_id']['value'] = $value);
	}
	
	function getMasterPageId() {
		return $this->getHtml('master_page_id');
	}
	
	function getHtmlOfMasterPageId() {
		return $this->getHtml('master_page_id');
	}
	
	function getHiddenOfMasterPageId() {
		return $this->getHidden('master_page_id');
	}
	
	function getDisplayOfMasterPageId() {
		return $this->getDisplay('master_page_id');
	}
	////////////

	function setPortalId($value=null) {
		return (self::$_property['portal_id']['value'] = $value);
	}
	
	function getPortalId() {
		return $this->getHtml('portal_id');
	}
	
	function getHtmlOfPortalId() {
		return $this->getHtml('portal_id');
	}
	
	function getHiddenOfPortalId() {
		return $this->getHidden('portal_id');
	}
	
	function getDisplayOfPortalId() {
		return $this->getDisplay('portal_id');
	}
	////////////

	function setPublish($value=null) {
		return (self::$_property['publish']['value'] = $value);
	}
	
	function getPublish() {
		return $this->getHtml('publish');
	}
	
	function getHtmlOfPublish() {
		return $this->getHtml('publish');
	}
	
	function getHiddenOfPublish() {
		return $this->getHidden('publish');
	}
	
	function getDisplayOfPublish() {
		return $this->getDisplay('publish');
	}
	////////////

	function setPageTitle($value=null) {
		return (self::$_property['page_title']['value'] = $value);
	}
	
	function getPageTitle() {
		return $this->getHtml('page_title');
	}
	
	function getHtmlOfPageTitle() {
		return $this->getHtml('page_title');
	}
	
	function getHiddenOfPageTitle() {
		return $this->getHidden('page_title');
	}
	
	function getDisplayOfPageTitle() {
		return $this->getDisplay('page_title');
	}
	////////////

	function setPageDescription($value=null) {
		return (self::$_property['page_description']['value'] = $value);
	}
	
	function getPageDescription() {
		return $this->getHtml('page_description');
	}
	
	function getHtmlOfPageDescription() {
		return $this->getHtml('page_description');
	}
	
	function getHiddenOfPageDescription() {
		return $this->getHidden('page_description');
	}
	
	function getDisplayOfPageDescription() {
		return $this->getDisplay('page_description');
	}
	////////////

	function setPageKeyword($value=null) {
		return (self::$_property['page_keyword']['value'] = $value);
	}
	
	function getPageKeyword() {
		return $this->getHtml('page_keyword');
	}
	
	function getHtmlOfPageKeyword() {
		return $this->getHtml('page_keyword');
	}
	
	function getHiddenOfPageKeyword() {
		return $this->getHidden('page_keyword');
	}
	
	function getDisplayOfPageKeyword() {
		return $this->getDisplay('page_keyword');
	}
	////////////

	function setEmptyModule($value=null) {
		return (self::$_property['empty_module']['value'] = $value);
	}
	
	function getEmptyModule() {
		return $this->getHtml('empty_module');
	}
	
	function getHtmlOfEmptyModule() {
		return $this->getHtml('empty_module');
	}
	
	function getHiddenOfEmptyModule() {
		return $this->getHidden('empty_module');
	}
	
	function getDisplayOfEmptyModule() {
		return $this->getDisplay('empty_module');
	}
	////////////

	function setPageBtnOK($value=null) {
		return (self::$_property['page_btn_OK']['value'] = $value);
	}
	
	function getPageBtnOK() {
		return $this->getHtml('page_btn_OK');
	}
	
	function getHtmlOfPageBtnOK() {
		return $this->getHtml('page_btn_OK');
	}
	
	function getHiddenOfPageBtnOK() {
		return $this->getHidden('page_btn_OK');
	}
	
	function getDisplayOfPageBtnOK() {
		return $this->getDisplay('page_btn_OK');
	}
	////////////

	function setPageBtnRESET($value=null) {
		return (self::$_property['page_btn_RESET']['value'] = $value);
	}
	
	function getPageBtnRESET() {
		return $this->getHtml('page_btn_RESET');
	}
	
	function getHtmlOfPageBtnRESET() {
		return $this->getHtml('page_btn_RESET');
	}
	
	function getHiddenOfPageBtnRESET() {
		return $this->getHidden('page_btn_RESET');
	}
	
	function getDisplayOfPageBtnRESET() {
		return $this->getDisplay('page_btn_RESET');
	}
	////////////

} // end class
