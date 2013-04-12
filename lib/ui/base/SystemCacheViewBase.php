<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemCacheViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemCacheView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['cache_enable']	= array("type" => "checkbox","name" => "cache_enable","value" => "","display" => "Cho phép sử dụng CACHE",);
		self::$_property['cache_sql']	= array("type" => "checkbox","name" => "cache_sql","value" => "","display" => "Cache SQL",);
		self::$_property['cache_sql_time']	= array("type" => "text","name" => "cache_sql_time","value" => "","display" => "Time (s)","validateType" => "Number","size" => "7",);
		self::$_property['cache_uri']	= array("type" => "checkbox","name" => "cache_uri","value" => "","display" => "Cache URI",);
		self::$_property['cache_uri_time']	= array("type" => "text","name" => "cache_uri_time","value" => "","display" => "Time","validateType" => "Number","size" => "7",);
		self::$_property['cache_module']	= array("type" => "checkbox","name" => "cache_module","value" => "","display" => "Cache Module",);
		self::$_property['cache_module_time']	= array("type" => "text","name" => "cache_module_time","value" => "","display" => "Time","validateType" => "Number","size" => "7",);
		self::$_property['cache_js']	= array("type" => "checkbox","name" => "cache_js","value" => "","display" => "Cache JS",);
		self::$_property['cache_js_time']	= array("type" => "text","name" => "cache_js_time","value" => "","display" => "Time","validateType" => "Number","size" => "7",);
		self::$_property['cache_css']	= array("type" => "checkbox","name" => "cache_css","value" => "","display" => "Cache CSS",);
		self::$_property['cache_css_time']	= array("type" => "text","name" => "cache_css_time","value" => "","display" => "Time","validateType" => "Number","size" => "7",);
		self::$_property['cache_btn_OK']	= array("type" => "button-submit","name" => "cache_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['cache_btn_RESET']	= array("type" => "button-reset","name" => "cache_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setCacheEnable($value=null) {
		return (self::$_property['cache_enable']['value'] = $value);
	}
	
	function getCacheEnable() {
		return $this->getHtml('cache_enable');
	}
	
	function getHtmlOfCacheEnable() {
		return $this->getHtml('cache_enable');
	}
	
	function getHiddenOfCacheEnable() {
		return $this->getHidden('cache_enable');
	}
	
	function getDisplayOfCacheEnable() {
		return $this->getDisplay('cache_enable');
	}
	////////////

	function setCacheSql($value=null) {
		return (self::$_property['cache_sql']['value'] = $value);
	}
	
	function getCacheSql() {
		return $this->getHtml('cache_sql');
	}
	
	function getHtmlOfCacheSql() {
		return $this->getHtml('cache_sql');
	}
	
	function getHiddenOfCacheSql() {
		return $this->getHidden('cache_sql');
	}
	
	function getDisplayOfCacheSql() {
		return $this->getDisplay('cache_sql');
	}
	////////////

	function setCacheSqlTime($value=null) {
		return (self::$_property['cache_sql_time']['value'] = $value);
	}
	
	function getCacheSqlTime() {
		return $this->getHtml('cache_sql_time');
	}
	
	function getHtmlOfCacheSqlTime() {
		return $this->getHtml('cache_sql_time');
	}
	
	function getHiddenOfCacheSqlTime() {
		return $this->getHidden('cache_sql_time');
	}
	
	function getDisplayOfCacheSqlTime() {
		return $this->getDisplay('cache_sql_time');
	}
	////////////

	function setCacheUri($value=null) {
		return (self::$_property['cache_uri']['value'] = $value);
	}
	
	function getCacheUri() {
		return $this->getHtml('cache_uri');
	}
	
	function getHtmlOfCacheUri() {
		return $this->getHtml('cache_uri');
	}
	
	function getHiddenOfCacheUri() {
		return $this->getHidden('cache_uri');
	}
	
	function getDisplayOfCacheUri() {
		return $this->getDisplay('cache_uri');
	}
	////////////

	function setCacheUriTime($value=null) {
		return (self::$_property['cache_uri_time']['value'] = $value);
	}
	
	function getCacheUriTime() {
		return $this->getHtml('cache_uri_time');
	}
	
	function getHtmlOfCacheUriTime() {
		return $this->getHtml('cache_uri_time');
	}
	
	function getHiddenOfCacheUriTime() {
		return $this->getHidden('cache_uri_time');
	}
	
	function getDisplayOfCacheUriTime() {
		return $this->getDisplay('cache_uri_time');
	}
	////////////

	function setCacheModule($value=null) {
		return (self::$_property['cache_module']['value'] = $value);
	}
	
	function getCacheModule() {
		return $this->getHtml('cache_module');
	}
	
	function getHtmlOfCacheModule() {
		return $this->getHtml('cache_module');
	}
	
	function getHiddenOfCacheModule() {
		return $this->getHidden('cache_module');
	}
	
	function getDisplayOfCacheModule() {
		return $this->getDisplay('cache_module');
	}
	////////////

	function setCacheModuleTime($value=null) {
		return (self::$_property['cache_module_time']['value'] = $value);
	}
	
	function getCacheModuleTime() {
		return $this->getHtml('cache_module_time');
	}
	
	function getHtmlOfCacheModuleTime() {
		return $this->getHtml('cache_module_time');
	}
	
	function getHiddenOfCacheModuleTime() {
		return $this->getHidden('cache_module_time');
	}
	
	function getDisplayOfCacheModuleTime() {
		return $this->getDisplay('cache_module_time');
	}
	////////////

	function setCacheJs($value=null) {
		return (self::$_property['cache_js']['value'] = $value);
	}
	
	function getCacheJs() {
		return $this->getHtml('cache_js');
	}
	
	function getHtmlOfCacheJs() {
		return $this->getHtml('cache_js');
	}
	
	function getHiddenOfCacheJs() {
		return $this->getHidden('cache_js');
	}
	
	function getDisplayOfCacheJs() {
		return $this->getDisplay('cache_js');
	}
	////////////

	function setCacheJsTime($value=null) {
		return (self::$_property['cache_js_time']['value'] = $value);
	}
	
	function getCacheJsTime() {
		return $this->getHtml('cache_js_time');
	}
	
	function getHtmlOfCacheJsTime() {
		return $this->getHtml('cache_js_time');
	}
	
	function getHiddenOfCacheJsTime() {
		return $this->getHidden('cache_js_time');
	}
	
	function getDisplayOfCacheJsTime() {
		return $this->getDisplay('cache_js_time');
	}
	////////////

	function setCacheCss($value=null) {
		return (self::$_property['cache_css']['value'] = $value);
	}
	
	function getCacheCss() {
		return $this->getHtml('cache_css');
	}
	
	function getHtmlOfCacheCss() {
		return $this->getHtml('cache_css');
	}
	
	function getHiddenOfCacheCss() {
		return $this->getHidden('cache_css');
	}
	
	function getDisplayOfCacheCss() {
		return $this->getDisplay('cache_css');
	}
	////////////

	function setCacheCssTime($value=null) {
		return (self::$_property['cache_css_time']['value'] = $value);
	}
	
	function getCacheCssTime() {
		return $this->getHtml('cache_css_time');
	}
	
	function getHtmlOfCacheCssTime() {
		return $this->getHtml('cache_css_time');
	}
	
	function getHiddenOfCacheCssTime() {
		return $this->getHidden('cache_css_time');
	}
	
	function getDisplayOfCacheCssTime() {
		return $this->getDisplay('cache_css_time');
	}
	////////////

	function setCacheBtnOK($value=null) {
		return (self::$_property['cache_btn_OK']['value'] = $value);
	}
	
	function getCacheBtnOK() {
		return $this->getHtml('cache_btn_OK');
	}
	
	function getHtmlOfCacheBtnOK() {
		return $this->getHtml('cache_btn_OK');
	}
	
	function getHiddenOfCacheBtnOK() {
		return $this->getHidden('cache_btn_OK');
	}
	
	function getDisplayOfCacheBtnOK() {
		return $this->getDisplay('cache_btn_OK');
	}
	////////////

	function setCacheBtnRESET($value=null) {
		return (self::$_property['cache_btn_RESET']['value'] = $value);
	}
	
	function getCacheBtnRESET() {
		return $this->getHtml('cache_btn_RESET');
	}
	
	function getHtmlOfCacheBtnRESET() {
		return $this->getHtml('cache_btn_RESET');
	}
	
	function getHiddenOfCacheBtnRESET() {
		return $this->getHidden('cache_btn_RESET');
	}
	
	function getDisplayOfCacheBtnRESET() {
		return $this->getDisplay('cache_btn_RESET');
	}
	////////////

} // end class
