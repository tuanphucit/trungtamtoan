<?php
include_once CGS_SYSTEM_PATH . 'system.html.form.build.php';
class MCwebTeacherViewBase extends HtmlFormBuild {

	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	private $validate = false;
	private $form = array("name" => "MCwebTeacherView","method" => "post","onsubmit" => "return true;",);
	function __construct(){
		self::$_property['username']	= array("type" => "text","name" => "username","value" => "","display" => "Username","required" => "true","maxsize" => "255","validateType" => "Text","maxlength" => "255","class" => "validate[required,custom[onlyLetterNumber]]","style" => "width:140px;",);
		self::$_property['password']	= array("type" => "password","name" => "password","value" => "","display" => "Password","required" => "true","maxsize" => "255","validateType" => "Text","maxlength" => "255","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['birthday']	= array("type" => "text","name" => "birthday","id" => "birthday","value" => "","display" => "Birthday","required" => "true","class" => "validate[required,custom[date]]","style" => "width:140px;",);
		self::$_property['firstname']	= array("type" => "text","name" => "firstname","id" => "firstname","value" => "","display" => "Firstname","required" => "true","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['lastname']	= array("type" => "text","name" => "lastname","id" => "lastname","value" => "","display" => "Lastname","required" => "true","class" => "validate[required]","style" => "width:140px;",);
		self::$_property['email']	= array("type" => "text","name" => "email","id" => "email","value" => "","display" => "Email","required" => "true","class" => "validate[required,custom[email]]","style" => "width:140px;",);
		self::$_property['mobile']	= array("type" => "text","name" => "mobile","id" => "mobile","value" => "","display" => "Mobile","required" => "true","class" => "validate[required,custom[phone]]","style" => "width:140px;",);
		self::$_property['gender']	= array("type" => "radio","name" => "gender","value" => "1","display" => "Gender","option" => "0:Nữ|1:Nam",);
		self::$_property['address']	= array("type" => "text","name" => "address","id" => "address","value" => "","display" => "Address","required" => "true","class" => "validate[required]","style" => "width:200px;",);
		self::$_property['location']	= array("type" => "select","name" => "location","value" => "","display" => "Location","style" => "width:140px;",);
		self::$_property['level']	= array("type" => "select","name" => "level","value" => "","display" => "level","option" => "0:Cao đẳng|1:Đại học|2:Đã ra trường|3:Giáo viên","style" => "width:140px;",);
		self::$_property['teachat']	= array("type" => "checkboxlist","name" => "teachat","id" => "teachat","value" => "","display" => "teachat",);
		self::$_property['sessions']	= array("type" => "checkboxlist","name" => "sessions","id" => "sessions","value" => "","display" => "Sessions",);
		self::$_property['classes']	= array("type" => "checkboxlist","name" => "classes","id" => "classes","value" => "","display" => "Classes",);
		self::$_property['school']	= array("type" => "text","name" => "school","id" => "school","value" => "","display" => "School","style" => "width:200px;",);
		self::$_property['faculty']	= array("type" => "text","name" => "faculty","id" => "faculty","value" => "","display" => "Faculty","style" => "width:140px;",);
		self::$_property['fee']	= array("type" => "text","name" => "fee","id" => "fee","value" => "","display" => "Fee","style" => "width:200px;",);
		self::$_property['introduction']	= array("type" => "textarea","name" => "introduction","id" => "introduction","value" => "","display" => "Introduction","style" => "width:300px;","rows" => "3","cols" => "50",);
		self::$_property['isNeedValid']	= array("type" => "radio","name" => "isNeedValid","value" => "1","display" => "isNeedValid","option" => "1:Có | 0:Không",);
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

	function setBirthday($value=null) {
		return (self::$_property['birthday']['value'] = $value);
	}
	
	function getBirthday() {
		return $this->getHtml('birthday');
	}
	
	function getHtmlOfBirthday() {
		return $this->getHtml('birthday');
	}
	
	function getHiddenOfBirthday() {
		return $this->getHidden('birthday');
	}
	
	function getDisplayOfBirthday() {
		return $this->getDisplay('birthday');
	}
	////////////

	function setFirstname($value=null) {
		return (self::$_property['firstname']['value'] = $value);
	}
	
	function getFirstname() {
		return $this->getHtml('firstname');
	}
	
	function getHtmlOfFirstname() {
		return $this->getHtml('firstname');
	}
	
	function getHiddenOfFirstname() {
		return $this->getHidden('firstname');
	}
	
	function getDisplayOfFirstname() {
		return $this->getDisplay('firstname');
	}
	////////////

	function setLastname($value=null) {
		return (self::$_property['lastname']['value'] = $value);
	}
	
	function getLastname() {
		return $this->getHtml('lastname');
	}
	
	function getHtmlOfLastname() {
		return $this->getHtml('lastname');
	}
	
	function getHiddenOfLastname() {
		return $this->getHidden('lastname');
	}
	
	function getDisplayOfLastname() {
		return $this->getDisplay('lastname');
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

	function setTeachat($value=null) {
		return (self::$_property['teachat']['value'] = $value);
	}
	
	function getTeachat() {
		return $this->getHtml('teachat');
	}
	
	function getHtmlOfTeachat() {
		return $this->getHtml('teachat');
	}
	
	function getHiddenOfTeachat() {
		return $this->getHidden('teachat');
	}
	
	function getDisplayOfTeachat() {
		return $this->getDisplay('teachat');
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

	function setClasses($value=null) {
		return (self::$_property['classes']['value'] = $value);
	}
	
	function getClasses() {
		return $this->getHtml('classes');
	}
	
	function getHtmlOfClasses() {
		return $this->getHtml('classes');
	}
	
	function getHiddenOfClasses() {
		return $this->getHidden('classes');
	}
	
	function getDisplayOfClasses() {
		return $this->getDisplay('classes');
	}
	////////////

	function setSchool($value=null) {
		return (self::$_property['school']['value'] = $value);
	}
	
	function getSchool() {
		return $this->getHtml('school');
	}
	
	function getHtmlOfSchool() {
		return $this->getHtml('school');
	}
	
	function getHiddenOfSchool() {
		return $this->getHidden('school');
	}
	
	function getDisplayOfSchool() {
		return $this->getDisplay('school');
	}
	////////////

	function setFaculty($value=null) {
		return (self::$_property['faculty']['value'] = $value);
	}
	
	function getFaculty() {
		return $this->getHtml('faculty');
	}
	
	function getHtmlOfFaculty() {
		return $this->getHtml('faculty');
	}
	
	function getHiddenOfFaculty() {
		return $this->getHidden('faculty');
	}
	
	function getDisplayOfFaculty() {
		return $this->getDisplay('faculty');
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

	function setIsNeedValid($value=null) {
		return (self::$_property['isNeedValid']['value'] = $value);
	}
	
	function getIsNeedValid() {
		return $this->getHtml('isNeedValid');
	}
	
	function getHtmlOfIsNeedValid() {
		return $this->getHtml('isNeedValid');
	}
	
	function getHiddenOfIsNeedValid() {
		return $this->getHidden('isNeedValid');
	}
	
	function getDisplayOfIsNeedValid() {
		return $this->getDisplay('isNeedValid');
	}
	////////////

} // end class
