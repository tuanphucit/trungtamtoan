<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class EditArticleViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "EditArticleView","method" => "post","onsubmit" => "return false;",);
	function __construct(){
		self::$_property['article_id']	= array("type" => "hidden","name" => "article_id","id" => "article_id","value" => "","display" => "Article ID",);
		self::$_property['subject']	= array("type" => "text","name" => "subject","id" => "subject","value" => "","display" => "Tên bài","required" => "true","style" => "width:500px;",);
		self::$_property['headImage']	= array("type" => "text","name" => "headImage","id" => "headImage","value" => "","display" => "Ảnh đại diện","style" => "width:500px;",);
		self::$_property['content']	= array("type" => "textarea","name" => "content","id" => "content","value" => "","display" => "Nội dung","style" => "width:500px;","rows" => "3","cols" => "50",);
		self::$_property['introduction']	= array("type" => "textarea","name" => "introduction","id" => "introduction","value" => "","display" => "Giới thiệu","style" => "width:500px;","rows" => "3","cols" => "50",);
		self::$_property['category_id']	= array("type" => "select","name" => "category_id","id" => "category_id","value" => "","display" => "Chuyên mục","style" => "width:140px;",);
		self::$_property['status']	= array("type" => "select","name" => "status","id" => "status","value" => "","display" => "Tình trạng","option" => "0: Ẩn| 1: Hiện","style" => "width:200px;",);
		self::$_property['article_btn_OK']	= array("type" => "button-submit","name" => "article_btn_OK","id" => "article_btn_OK","value" => "","display" => "Sửa","class" => "submit",);
		self::$_property['article_btn_RESET']	= array("type" => "button-reset","name" => "article_btn_RESET","id" => "article_btn_RESET","value" => "","display" => "Làm lại","class" => "submit",);
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

	function setArticleId($value=null) {
		return (self::$_property['article_id']['value'] = $value);
	}
	
	function getArticleId() {
		return $this->getHtml('article_id');
	}
	
	function getHtmlOfArticleId() {
		return $this->getHtml('article_id');
	}
	
	function getHiddenOfArticleId() {
		return $this->getHidden('article_id');
	}
	
	function getDisplayOfArticleId() {
		return $this->getDisplay('article_id');
	}
	////////////

	function setSubject($value=null) {
		return (self::$_property['subject']['value'] = $value);
	}
	
	function getSubject() {
		return $this->getHtml('subject');
	}
	
	function getHtmlOfSubject() {
		return $this->getHtml('subject');
	}
	
	function getHiddenOfSubject() {
		return $this->getHidden('subject');
	}
	
	function getDisplayOfSubject() {
		return $this->getDisplay('subject');
	}
	////////////

	function setHeadImage($value=null) {
		return (self::$_property['headImage']['value'] = $value);
	}
	
	function getHeadImage() {
		return $this->getHtml('headImage');
	}
	
	function getHtmlOfHeadImage() {
		return $this->getHtml('headImage');
	}
	
	function getHiddenOfHeadImage() {
		return $this->getHidden('headImage');
	}
	
	function getDisplayOfHeadImage() {
		return $this->getDisplay('headImage');
	}
	////////////

	function setContent($value=null) {
		return (self::$_property['content']['value'] = $value);
	}
	
	function getContent() {
		return $this->getHtml('content');
	}
	
	function getHtmlOfContent() {
		return $this->getHtml('content');
	}
	
	function getHiddenOfContent() {
		return $this->getHidden('content');
	}
	
	function getDisplayOfContent() {
		return $this->getDisplay('content');
	}
	////////////

	function setIntroduction($value=null) {
		return (self::$_property['introduction']['value'] = $value);
	}
	
	function getIntroduction() {
		return $this->getHtml('introduction');
	}
	
	function getHtmlOfIntroduction() {
		return $this->getHtml('introduction');
	}
	
	function getHiddenOfIntroduction() {
		return $this->getHidden('introduction');
	}
	
	function getDisplayOfIntroduction() {
		return $this->getDisplay('introduction');
	}
	////////////

	function setCategoryId($value=null) {
		return (self::$_property['category_id']['value'] = $value);
	}
	
	function getCategoryId() {
		return $this->getHtml('category_id');
	}
	
	function getHtmlOfCategoryId() {
		return $this->getHtml('category_id');
	}
	
	function getHiddenOfCategoryId() {
		return $this->getHidden('category_id');
	}
	
	function getDisplayOfCategoryId() {
		return $this->getDisplay('category_id');
	}
	////////////

	function setStatus($value=null) {
		return (self::$_property['status']['value'] = $value);
	}
	
	function getStatus() {
		return $this->getHtml('status');
	}
	
	function getHtmlOfStatus() {
		return $this->getHtml('status');
	}
	
	function getHiddenOfStatus() {
		return $this->getHidden('status');
	}
	
	function getDisplayOfStatus() {
		return $this->getDisplay('status');
	}
	////////////

	function setArticleBtnOK($value=null) {
		return (self::$_property['article_btn_OK']['value'] = $value);
	}
	
	function getArticleBtnOK() {
		return $this->getHtml('article_btn_OK');
	}
	
	function getHtmlOfArticleBtnOK() {
		return $this->getHtml('article_btn_OK');
	}
	
	function getHiddenOfArticleBtnOK() {
		return $this->getHidden('article_btn_OK');
	}
	
	function getDisplayOfArticleBtnOK() {
		return $this->getDisplay('article_btn_OK');
	}
	////////////

	function setArticleBtnRESET($value=null) {
		return (self::$_property['article_btn_RESET']['value'] = $value);
	}
	
	function getArticleBtnRESET() {
		return $this->getHtml('article_btn_RESET');
	}
	
	function getHtmlOfArticleBtnRESET() {
		return $this->getHtml('article_btn_RESET');
	}
	
	function getHiddenOfArticleBtnRESET() {
		return $this->getHidden('article_btn_RESET');
	}
	
	function getDisplayOfArticleBtnRESET() {
		return $this->getDisplay('article_btn_RESET');
	}
	////////////

} // end class
