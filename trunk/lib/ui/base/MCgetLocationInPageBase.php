<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class MCgetLocationInPageBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "MCgetLocationInPage","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['provinceChange']	= array("type" => "select","name" => "provinceChange","id" => "provinceChange","value" => "","display" => "provinceChange","style" => "width:100px;",);
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

	function setProvinceChange($value=null) {
		return (self::$_property['provinceChange']['value'] = $value);
	}
	
	function getProvinceChange() {
		return $this->getHtml('provinceChange');
	}
	
	function getHtmlOfProvinceChange() {
		return $this->getHtml('provinceChange');
	}
	
	function getHiddenOfProvinceChange() {
		return $this->getHidden('provinceChange');
	}
	
	function getDisplayOfProvinceChange() {
		return $this->getDisplay('provinceChange');
	}
	////////////

} // end class
