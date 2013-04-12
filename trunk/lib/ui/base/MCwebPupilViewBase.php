<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class MCwebPupilViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "MCwebPupilView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['mothername']	= array("type" => "text","name" => "mothername","id" => "mothername","value" => "","display" => "mothername","required" => "true","class" => "validate[required]","style" => "width:150px;",);
		self::$_property['gender']	= array("type" => "radio","name" => "gender","value" => "1","display" => "gender","option" => "1:Nam |0:Nữ |2: Nam và Nữ",);
		self::$_property['email']	= array("type" => "text","name" => "email","id" => "email","value" => "","display" => "Email","class" => "validate[custom[email]]","style" => "width:300px;",);
		self::$_property['mobile']	= array("type" => "text","name" => "mobile","id" => "mobile","value" => "","display" => "Mobile","required" => "true","validateType" => "Number","class" => "validate[required,custom[phone]]","style" => "width:150px;",);
		self::$_property['giasu_gender']	= array("type" => "radio","name" => "giasu_gender","value" => "3","display" => "giasu_gender","option" => "3:Nam hoặc Nữ|1:Nam |0:Nữ",);
		self::$_property['starttime']	= array("type" => "text","name" => "starttime","id" => "starttime","value" => "","display" => "starttime","class" => "validate[custom[date]]","style" => "width:140px;",);
		self::$_property['address']	= array("type" => "text","name" => "address","id" => "address","value" => "","display" => "Address","required" => "true","validateType" => "Email","class" => "validate[required]","style" => "width:300px;",);
		self::$_property['location']	= array("type" => "select","name" => "location","value" => "","display" => "Location","required" => "true",);
		self::$_property['level']	= array("type" => "select","name" => "level","value" => "","display" => "level","option" => "0:Cao đẳng|1:Đại học|2:Đã ra trường|3:Giáo viên|4: Không quan trọng","style" => "width:140px;",);
		self::$_property['sessions']	= array("type" => "checkboxlist","name" => "sessions","id" => "sessions","value" => "","display" => "Sessions",);
		self::$_property['class_id']	= array("type" => "select","name" => "class_id","id" => "class_id","value" => "","display" => "class_id","style" => "width:140px;",);
		self::$_property['fee']	= array("type" => "text","name" => "fee","id" => "fee","value" => "","display" => "Fee","style" => "width:140px;",);
		self::$_property['duringtime']	= array("type" => "select","name" => "duringtime","id" => "duringtime","value" => "","display" => "duringtime","option" => "90:90 phút|120:120 phút |150:150 phút |180:180 phút|>180:>180 phút","style" => "width:140px;",);
		self::$_property['pupilnumber']	= array("type" => "select","name" => "pupilnumber","id" => "pupilnumber","value" => "1","display" => "pupilnumber","option" => "1:1|2:2|3:3|4:4|5:5|>5:>5",);
		self::$_property['introduction']	= array("type" => "textarea","name" => "introduction","id" => "introduction","value" => "","display" => "Introduction","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['isNeedGoodTeacher']	= array("type" => "radio","name" => "isNeedGoodTeacher","value" => "1","display" => "isNeedGoodTeacher","option" => "1:Có | 0:Không",);
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

	function setMothername($value=null) {
		return (self::$_property['mothername']['value'] = $value);
	}
	
	function getMothername() {
		return $this->getHtml('mothername');
	}
	
	function getHtmlOfMothername() {
		return $this->getHtml('mothername');
	}
	
	function getHiddenOfMothername() {
		return $this->getHidden('mothername');
	}
	
	function getDisplayOfMothername() {
		return $this->getDisplay('mothername');
	}
	////////////

	function setGender($value=null) {
		return (self::$_property['gender']['value'] = $value);
	}
	
	function getGender() {
		return $this->getHtml('gender');
	}
	
	function getHtmlOfGender() {
		return $this->getHtml('gender');
	}
	
	function getHiddenOfGender() {
		return $this->getHidden('gender');
	}
	
	function getDisplayOfGender() {
		return $this->getDisplay('gender');
	}
	////////////

	function setEmail($value=null) {
		return (self::$_property['email']['value'] = $value);
	}
	
	function getEmail() {
		return $this->getHtml('email');
	}
	
	function getHtmlOfEmail() {
		return $this->getHtml('email');
	}
	
	function getHiddenOfEmail() {
		return $this->getHidden('email');
	}
	
	function getDisplayOfEmail() {
		return $this->getDisplay('email');
	}
	////////////

	function setMobile($value=null) {
		return (self::$_property['mobile']['value'] = $value);
	}
	
	function getMobile() {
		return $this->getHtml('mobile');
	}
	
	function getHtmlOfMobile() {
		return $this->getHtml('mobile');
	}
	
	function getHiddenOfMobile() {
		return $this->getHidden('mobile');
	}
	
	function getDisplayOfMobile() {
		return $this->getDisplay('mobile');
	}
	////////////

	function setGiasuGender($value=null) {
		return (self::$_property['giasu_gender']['value'] = $value);
	}
	
	function getGiasuGender() {
		return $this->getHtml('giasu_gender');
	}
	
	function getHtmlOfGiasuGender() {
		return $this->getHtml('giasu_gender');
	}
	
	function getHiddenOfGiasuGender() {
		return $this->getHidden('giasu_gender');
	}
	
	function getDisplayOfGiasuGender() {
		return $this->getDisplay('giasu_gender');
	}
	////////////

	function setStarttime($value=null) {
		return (self::$_property['starttime']['value'] = $value);
	}
	
	function getStarttime() {
		return $this->getHtml('starttime');
	}
	
	function getHtmlOfStarttime() {
		return $this->getHtml('starttime');
	}
	
	function getHiddenOfStarttime() {
		return $this->getHidden('starttime');
	}
	
	function getDisplayOfStarttime() {
		return $this->getDisplay('starttime');
	}
	////////////

	function setAddress($value=null) {
		return (self::$_property['address']['value'] = $value);
	}
	
	function getAddress() {
		return $this->getHtml('address');
	}
	
	function getHtmlOfAddress() {
		return $this->getHtml('address');
	}
	
	function getHiddenOfAddress() {
		return $this->getHidden('address');
	}
	
	function getDisplayOfAddress() {
		return $this->getDisplay('address');
	}
	////////////

	function setLocation($value=null) {
		return (self::$_property['location']['value'] = $value);
	}
	
	function getLocation() {
		return $this->getHtml('location');
	}
	
	function getHtmlOfLocation() {
		return $this->getHtml('location');
	}
	
	function getHiddenOfLocation() {
		return $this->getHidden('location');
	}
	
	function getDisplayOfLocation() {
		return $this->getDisplay('location');
	}
	////////////

	function setLevel($value=null) {
		return (self::$_property['level']['value'] = $value);
	}
	
	function getLevel() {
		return $this->getHtml('level');
	}
	
	function getHtmlOfLevel() {
		return $this->getHtml('level');
	}
	
	function getHiddenOfLevel() {
		return $this->getHidden('level');
	}
	
	function getDisplayOfLevel() {
		return $this->getDisplay('level');
	}
	////////////

	function setSessions($value=null) {
		return (self::$_property['sessions']['value'] = $value);
	}
	
	function getSessions() {
		return $this->getHtml('sessions');
	}
	
	function getHtmlOfSessions() {
		return $this->getHtml('sessions');
	}
	
	function getHiddenOfSessions() {
		return $this->getHidden('sessions');
	}
	
	function getDisplayOfSessions() {
		return $this->getDisplay('sessions');
	}
	////////////

	function setClassId($value=null) {
		return (self::$_property['class_id']['value'] = $value);
	}
	
	function getClassId() {
		return $this->getHtml('class_id');
	}
	
	function getHtmlOfClassId() {
		return $this->getHtml('class_id');
	}
	
	function getHiddenOfClassId() {
		return $this->getHidden('class_id');
	}
	
	function getDisplayOfClassId() {
		return $this->getDisplay('class_id');
	}
	////////////

	function setFee($value=null) {
		return (self::$_property['fee']['value'] = $value);
	}
	
	function getFee() {
		return $this->getHtml('fee');
	}
	
	function getHtmlOfFee() {
		return $this->getHtml('fee');
	}
	
	function getHiddenOfFee() {
		return $this->getHidden('fee');
	}
	
	function getDisplayOfFee() {
		return $this->getDisplay('fee');
	}
	////////////

	function setDuringtime($value=null) {
		return (self::$_property['duringtime']['value'] = $value);
	}
	
	function getDuringtime() {
		return $this->getHtml('duringtime');
	}
	
	function getHtmlOfDuringtime() {
		return $this->getHtml('duringtime');
	}
	
	function getHiddenOfDuringtime() {
		return $this->getHidden('duringtime');
	}
	
	function getDisplayOfDuringtime() {
		return $this->getDisplay('duringtime');
	}
	////////////

	function setPupilnumber($value=null) {
		return (self::$_property['pupilnumber']['value'] = $value);
	}
	
	function getPupilnumber() {
		return $this->getHtml('pupilnumber');
	}
	
	function getHtmlOfPupilnumber() {
		return $this->getHtml('pupilnumber');
	}
	
	function getHiddenOfPupilnumber() {
		return $this->getHidden('pupilnumber');
	}
	
	function getDisplayOfPupilnumber() {
		return $this->getDisplay('pupilnumber');
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

	function setIsNeedGoodTeacher($value=null) {
		return (self::$_property['isNeedGoodTeacher']['value'] = $value);
	}
	
	function getIsNeedGoodTeacher() {
		return $this->getHtml('isNeedGoodTeacher');
	}
	
	function getHtmlOfIsNeedGoodTeacher() {
		return $this->getHtml('isNeedGoodTeacher');
	}
	
	function getHiddenOfIsNeedGoodTeacher() {
		return $this->getHidden('isNeedGoodTeacher');
	}
	
	function getDisplayOfIsNeedGoodTeacher() {
		return $this->getDisplay('isNeedGoodTeacher');
	}
	////////////

} // end class
