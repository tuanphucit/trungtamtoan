<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class SystemLogViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "SystemLogView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['log_enable']	= array("type" => "checkbox","name" => "log_enable","value" => "","display" => "LOG ENABLE",);
		self::$_property['log_error']	= array("type" => "checkbox","name" => "log_error","value" => "","display" => "LOG ERROR",);
		self::$_property['log_sql']	= array("type" => "checkbox","name" => "log_sql","value" => "","display" => "LOG SQL",);
		self::$_property['log_sql_view']	= array("type" => "checkbox","name" => "log_sql_view","value" => "","display" => "LOG VIEW",);
		self::$_property['log_sql_add']	= array("type" => "checkbox","name" => "log_sql_add","value" => "","display" => "LOG ADD",);
		self::$_property['log_sql_edit']	= array("type" => "checkbox","name" => "log_sql_edit","value" => "","display" => "LOG EDIT",);
		self::$_property['log_sql_delete']	= array("type" => "checkbox","name" => "log_sql_delete","value" => "","display" => "LOG DELETE",);
		self::$_property['log_sql_other']	= array("type" => "checkbox","name" => "log_sql_other","value" => "","display" => "LOG OTHER",);
		self::$_property['log_sql_slow']	= array("type" => "checkbox","name" => "log_sql_slow","value" => "","display" => "LOG SQL SLOW",);
		self::$_property['log_sql_slow_time']	= array("type" => "text","name" => "log_sql_slow_time","value" => "","display" => "Time","validateType" => "Number","size" => "7",);
		self::$_property['log_btn_OK']	= array("type" => "button-submit","name" => "log_btn_OK","value" => "","display" => "lang.submit","class" => "submit",);
		self::$_property['log_btn_RESET']	= array("type" => "button-reset","name" => "log_btn_RESET","value" => "","display" => "lang.reset","class" => "submit",);
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

	function setLogEnable($value=null) {
		return (self::$_property['log_enable']['value'] = $value);
	}
	
	function getLogEnable() {
		return $this->getHtml('log_enable');
	}
	
	function getHtmlOfLogEnable() {
		return $this->getHtml('log_enable');
	}
	
	function getHiddenOfLogEnable() {
		return $this->getHidden('log_enable');
	}
	
	function getDisplayOfLogEnable() {
		return $this->getDisplay('log_enable');
	}
	////////////

	function setLogError($value=null) {
		return (self::$_property['log_error']['value'] = $value);
	}
	
	function getLogError() {
		return $this->getHtml('log_error');
	}
	
	function getHtmlOfLogError() {
		return $this->getHtml('log_error');
	}
	
	function getHiddenOfLogError() {
		return $this->getHidden('log_error');
	}
	
	function getDisplayOfLogError() {
		return $this->getDisplay('log_error');
	}
	////////////

	function setLogSql($value=null) {
		return (self::$_property['log_sql']['value'] = $value);
	}
	
	function getLogSql() {
		return $this->getHtml('log_sql');
	}
	
	function getHtmlOfLogSql() {
		return $this->getHtml('log_sql');
	}
	
	function getHiddenOfLogSql() {
		return $this->getHidden('log_sql');
	}
	
	function getDisplayOfLogSql() {
		return $this->getDisplay('log_sql');
	}
	////////////

	function setLogSqlView($value=null) {
		return (self::$_property['log_sql_view']['value'] = $value);
	}
	
	function getLogSqlView() {
		return $this->getHtml('log_sql_view');
	}
	
	function getHtmlOfLogSqlView() {
		return $this->getHtml('log_sql_view');
	}
	
	function getHiddenOfLogSqlView() {
		return $this->getHidden('log_sql_view');
	}
	
	function getDisplayOfLogSqlView() {
		return $this->getDisplay('log_sql_view');
	}
	////////////

	function setLogSqlAdd($value=null) {
		return (self::$_property['log_sql_add']['value'] = $value);
	}
	
	function getLogSqlAdd() {
		return $this->getHtml('log_sql_add');
	}
	
	function getHtmlOfLogSqlAdd() {
		return $this->getHtml('log_sql_add');
	}
	
	function getHiddenOfLogSqlAdd() {
		return $this->getHidden('log_sql_add');
	}
	
	function getDisplayOfLogSqlAdd() {
		return $this->getDisplay('log_sql_add');
	}
	////////////

	function setLogSqlEdit($value=null) {
		return (self::$_property['log_sql_edit']['value'] = $value);
	}
	
	function getLogSqlEdit() {
		return $this->getHtml('log_sql_edit');
	}
	
	function getHtmlOfLogSqlEdit() {
		return $this->getHtml('log_sql_edit');
	}
	
	function getHiddenOfLogSqlEdit() {
		return $this->getHidden('log_sql_edit');
	}
	
	function getDisplayOfLogSqlEdit() {
		return $this->getDisplay('log_sql_edit');
	}
	////////////

	function setLogSqlDelete($value=null) {
		return (self::$_property['log_sql_delete']['value'] = $value);
	}
	
	function getLogSqlDelete() {
		return $this->getHtml('log_sql_delete');
	}
	
	function getHtmlOfLogSqlDelete() {
		return $this->getHtml('log_sql_delete');
	}
	
	function getHiddenOfLogSqlDelete() {
		return $this->getHidden('log_sql_delete');
	}
	
	function getDisplayOfLogSqlDelete() {
		return $this->getDisplay('log_sql_delete');
	}
	////////////

	function setLogSqlOther($value=null) {
		return (self::$_property['log_sql_other']['value'] = $value);
	}
	
	function getLogSqlOther() {
		return $this->getHtml('log_sql_other');
	}
	
	function getHtmlOfLogSqlOther() {
		return $this->getHtml('log_sql_other');
	}
	
	function getHiddenOfLogSqlOther() {
		return $this->getHidden('log_sql_other');
	}
	
	function getDisplayOfLogSqlOther() {
		return $this->getDisplay('log_sql_other');
	}
	////////////

	function setLogSqlSlow($value=null) {
		return (self::$_property['log_sql_slow']['value'] = $value);
	}
	
	function getLogSqlSlow() {
		return $this->getHtml('log_sql_slow');
	}
	
	function getHtmlOfLogSqlSlow() {
		return $this->getHtml('log_sql_slow');
	}
	
	function getHiddenOfLogSqlSlow() {
		return $this->getHidden('log_sql_slow');
	}
	
	function getDisplayOfLogSqlSlow() {
		return $this->getDisplay('log_sql_slow');
	}
	////////////

	function setLogSqlSlowTime($value=null) {
		return (self::$_property['log_sql_slow_time']['value'] = $value);
	}
	
	function getLogSqlSlowTime() {
		return $this->getHtml('log_sql_slow_time');
	}
	
	function getHtmlOfLogSqlSlowTime() {
		return $this->getHtml('log_sql_slow_time');
	}
	
	function getHiddenOfLogSqlSlowTime() {
		return $this->getHidden('log_sql_slow_time');
	}
	
	function getDisplayOfLogSqlSlowTime() {
		return $this->getDisplay('log_sql_slow_time');
	}
	////////////

	function setLogBtnOK($value=null) {
		return (self::$_property['log_btn_OK']['value'] = $value);
	}
	
	function getLogBtnOK() {
		return $this->getHtml('log_btn_OK');
	}
	
	function getHtmlOfLogBtnOK() {
		return $this->getHtml('log_btn_OK');
	}
	
	function getHiddenOfLogBtnOK() {
		return $this->getHidden('log_btn_OK');
	}
	
	function getDisplayOfLogBtnOK() {
		return $this->getDisplay('log_btn_OK');
	}
	////////////

	function setLogBtnRESET($value=null) {
		return (self::$_property['log_btn_RESET']['value'] = $value);
	}
	
	function getLogBtnRESET() {
		return $this->getHtml('log_btn_RESET');
	}
	
	function getHtmlOfLogBtnRESET() {
		return $this->getHtml('log_btn_RESET');
	}
	
	function getHiddenOfLogBtnRESET() {
		return $this->getHidden('log_btn_RESET');
	}
	
	function getDisplayOfLogBtnRESET() {
		return $this->getDisplay('log_btn_RESET');
	}
	////////////

} // end class
