<?php
class HtmlFormBuild {
	static protected $html_rq = " <span style='color:red;font-weight: bold;'>*</span>";
	static private $validate = false;
	static private $form = array();
	static protected $_property = array();
	static protected $_type = array('hidden','text','textarea','password','select','checkbox','checkboxlist','radio','file','button','button-submit','button-reset','button-image');
	static protected $_tag = array(
		'hidden'	=> array(),
		'text'		=> array('disabled','maxlength','readonly','size','autocomplete'),
		'password'	=> array('disabled','maxlength','readonly','size','autocomplete'),
		'file'		=> array('accept','disabled'),
		'image'		=> array('align','alt','disabled','src'),
		'checkbox'	=> array('disabled'),
		'checkboxlist'	=> array('disabled'),
		'radio'		=> array('disabled'),
		'textarea'	=> array('disabled','readonly','cols','rows'),
		'select'	=> array('disabled','multiple','size'),
		'button'		=> array('disabled'),
		'button-submit'	=> array('disabled'),
		'button-reset'	=> array('disabled'),
	);
	static protected $_require 	= array('name','value','id','display');
	static protected $_standard = array('accesskey','class','style','dir','lang','tabindex','title','xml:lang','rel');
	static protected $_event 	= array('onblur','onchange','onclick','ondblclick','onfocus','onmousedown','onmousemove',
										'onmouseout','onmouseover','onmouseup','onkeydown','onkeypress','onkeyup','onselect');
	static protected $_more_ext = array('option','optgroup','label','codeDef','model','required',
										'editor','calendar','maxsize','minsize','validate-type');
	/**
	 * @desc Validate form by javascript
	 * @param unknown_type $is
	 */
	function setValidate($is=false) {
		self::$validate = ($is?true:false);
	}
	
	/**
	 * @desc Tra ve trang thai Validate of Form
	 * @return $validate
	 */
	function getValidate() {
		return self::$validate;
	}
	/////////////////////////////
	
	/**
	 * @desc Khoi tao mot field moi
	 * @param string $type Field Type
	 * @param string $name Field Name
	 * @param array $property Field Property
	 */
	static function create($type='hidden', $name='', $property=array()) {
		if (!in_array($type, self::$_type)) $type='hidden';
		if ($name == '') return false;
		if (!is_array($property)) $property = array();
		
		self::$_property[$name] = array('type'=>$type, 'name'=>$name, 'id'=>$name);
		self::setProperty($name, $property);
		
		return true;
	}
	
	/**
	 * @desc Set value cho Field
	 * @param string $name
	 * @param string/number/array $value
	 */
	static function set($name='', $value=NULL) {
		self::$_property[$name]['value'] = $value;
		return self::$_property[$name];
	}
	
	/**
	 * @desc Lay gia tri thuc cua field
	 * @param string $name
	 * @return value
	 */
	static function get($name){
		return self::$_property[$name]['value'];
	}
	
	/**
	 * @desc Set property cho field
	 * @param string $name
	 * @param array $property
	 */
	static function setProperty($name, $property=array()){
		// Khong cho doi ten thuoc tinh
		if (isset($property['name'])) unset($property['name']); 
		
		self::$_property[$name] = $property + self::$_property[$name];
		// Loc dau vao property
		self::filterInput();
	}
	
	/**
	 * @desc Tra ve tat ca cac thuoc tinh cua Field
	 * @param unknown_type $name
	 * @return property of Field
	 */
	static function getProperty($name){
		return self::$_property[$name];
	}
	
	/**
	 * @desc Xoa Field khoi form
	 */
	static function del($name=''){
		if (isset(self::$_property[$name])) {
			unset(self::$_property[$name]);
			return true;
		} 
		return false;
	}
	
	/**
	 * @desc Tra ve HTML tuong ung voi moi type cua Field
	 * @param $name
	 * @return HTML of Field
	 */
	static function getHtml($name=''){
		$prop = self::$_property[$name];
		switch ($prop['type']){
			case 'hidden':
				$html = self::getHtmlHidden($name);
				break;
			case 'text':
				$html = self::getHtmlText($name);
				break;
			case 'password':
				$html = self::getHtmlPassword($name);
				break;
			case 'textarea':
				$html = self::getHtmlTextarea($name);
				break;
			case 'radio':
				$html = self::getHtmlRadio($name);
				break;
			case 'checkbox':
				$html = self::getHtmlCheckbox($name);
				break;
			case 'checkboxlist':
				$html = self::getHtmlCheckboxList($name);
				break;
			case 'select':
				$html = self::getHtmlSelect($name);
				break;
			case 'button':
				$html = self::getHtmlButton($name);
				break;
			case 'button-submit':
				$html = self::getHtmlButtonSubmit($name);
				break;
			case 'button-reset':
				$html = self::getHtmlButtonReset($name);
				break;
			default:
				$html = NULL;
				break;
		}
		if (isset($prop['required']) && $prop['required']=='true'){
			$html.= self::$html_rq;
		}
		return $html;
	}
	
	
	///////////////////////////////
	// getHtml()
	static function getHtmlHidden($name=''){
		$prop = self::$_property[$name];
		$html = '<input type="hidden" name="'.$prop['name'].'" id="'.$prop['id'].'" value="'.self::specialChars($prop['value']).'"/>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlText($name=''){
		$prop = self::$_property[$name];
		$html = '<input type="text" name="'.$prop['name'].'" id="'.$prop['id'].'" value="'.self::specialChars($prop['value']).'"';
		$html.= self::getExtention($prop);
		$html.= '/>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlPassword($name=''){
		$prop = self::$_property[$name];
		$html = '<input type="password" name="'.$prop['name'].'" id="'.$prop['id'].'" value="'.self::specialChars($prop['value']).'"';
		$html.= self::getExtention($prop);
		$html.= '/>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlTextarea($name=''){
		$prop = self::$_property[$name];
		$html = '<textarea name="'.$prop['name'].'" id="'.$prop['id'].'"';
		$html.= self::getExtention($prop);
		$html.= '>' . $prop['value'] . '</textarea>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlRadio($name=''){
		$prop = self::$_property[$name];
		$html = '';
		$i=0;
		foreach ($prop['list_data'] as $key => $dis){
			$checked = ( $key==$prop['value'] ? ' checked="checked"' :'' );
			$html.= '<label><input type="radio" name="'.$prop['name'].'" id="'.$prop['id'].'-'.($i++).'" value="'.self::specialChars($key).'"'.$checked
						. self::getExtention($prop).'/>'.self::specialChars($dis).'</label>';
		}
		$html.= '';
		if (isset($prop['label']) && $prop['label']) $html = '<label>'.$prop['label'].' '.$html.'</label>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlCheckbox($name=''){
		$prop = self::$_property[$name];
		$ext = '';
		if (isset($prop['list_data'][$prop['value']])){
			$ext.= ' checked="checked"';
		}
		$ext.= self::getExtention($prop);
		
		$value = array_keys($prop['list_data']);
		$display = array_values($prop['list_data']);
		
		$html = '<label><input type="checkbox" name="'.$prop['name'].'" id="'.$prop['id'].'" value="'.self::specialChars($value[0]).'"'.$ext.'/> '.$display[0].'</label>';
		return  $html;
	}
	
		static function getHtmlCheckboxList($name=''){
			$prop = self::$_property[$name];
			$html = '<table style="background: #DDDDDD; border: 1px solid white;"><tr>';
			$i=0;
			$b = 0;
			$valueChecks = explode(',',$prop['value']);			
			foreach ($prop['list_data'] as $key => $dis){	
				$checked = '';		
				foreach ($valueChecks as $isChecked){					
					if($key == $isChecked){
						$checked = ' checked="checked"';
					}
				}
				$html.= '<td style="border: 1px solid #DDDDDD;"><input type="checkbox" name="'.$prop['name'].'[]" id="'.$prop['id'].'-'.($i++).'" value="'.self::specialChars($key).'"'.$checked
							. self::getExtention($prop).'/>'.self::specialChars($dis).'</td>';
			
				if($b%3 == 2){
					$html .='</tr><tr>';
				}
				$b++;
			}
			$html.= '</tr></table>';
			if (isset($prop['label']) && $prop['label']) $html = '<label>'.$prop['label'].' '.$html.'</label>';
			return $html;
	}
	//-----------------------------
	
	static function getHtmlSelect($name=''){
		$prop = self::$_property[$name];
		$html = '<select name="'.$prop['name'].'" id="'.$prop['id'].'"'
					. self::getExtention($prop) .'">';
		if (isset($prop['list_data']) && !empty($prop['list_data'])) {
			foreach ($prop['list_data'] as $key => $dis){
				$selected = ( $key==$prop['value'] ? ' selected="selected"' :'' );
				$html.= '<option value="'.$key.'"'.$selected.'>'.$dis.'</option>';
			}
		}
		$html.= '</select>';
		if (isset($prop['label']) && $prop['label']) $html = '<label>'.$prop['label'].' '.$html.'</label>';
		return $html;
	}
	//-----------------------------
	
	static function getHtmlButton($name=''){
		$prop = self::$_property[$name];
		$html = '<button type="button" name="'.$prop['name'].'" id="'.$prop['id'].'"';
		$html.= self::getExtention($prop);
		$html.= '>'.$prop['display'];
		$html.= '</button>';
		return $html;
	}
	//------------------------------
	static function getHtmlButtonSubmit($name=''){
		$prop = self::$_property[$name];
		$html = '<button type="submit" name="'.$prop['name'].'" id="'.$prop['id'].'"';
		$html.= self::getExtention($prop);
		$html.= '>'.$prop['display'];
		$html.= '</button>';
		return $html;
	}
	//-----------------------------
	static function getHtmlButtonReset($name=''){
		$prop = self::$_property[$name];
		$html = '<button type="reset" name="'.$prop['name'].'" id="'.$prop['id'].'"';
		$html.= self::getExtention($prop);
		$html.= '>'.$prop['display'];
		$html.= '</button>';
		return $html;
	}
	///////////////////////////////////
	/**
	 * @desc Tra ve HTML of Hidden Tag
	 * @param unknown_type $name
	 * @return getHtmlHidden()
	 */
	static function getHidden($name=''){
		return self::getHtmlHidden($name);
	}
	
	/**
	 * @desc Dung cho Hien thi tren man hinh
	 * @param string $name Field name
	 * @return value display on PAGE
	 */
	static function getDisplay($name=''){
		if (self::$_property[$name]['type'] == 'textarea'){
			//return self::$_property[$name]['value'];
			return nl2br(self::specialChars(self::$_property[$name]['value']));
		}
		return self::specialChars(self::$_property[$name]['value']);
	}
	
	/**
	 * @
	 * @param $prop Field property
	 * @return Begin FORM tag
	 */
	function getFormBegin($prop=array()){
		//$form_name = get_called_class();
		$form_name = get_class($this);
		if (!is_array($prop)) return '<form name="'.$form_name.'" id="'.$form_name.'">';
		
		if (!isset($prop['name'])){
			$prop['name'] = $form_name;
		}
		if (!isset($prop['id'])){
			$prop['id'] = $form_name;
		}
		
		// add property for form
		self::$form = $prop;
		
		// Build html of form
		$html = '<form';
		foreach ($prop as $key => $val){
			$html.= ' '.$key.'="'.$val.'"';
		}
		$html.= '>';
		return $html;
	}
	/**
	 * @return End FORM tag
	 */
	function getFormEnd(){
		$html = '</form>';
		if (self::$validate){
			if (isset(self::$form['id'])){
				$form_name = self::$form['id'];
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
	
	/**
	 * set View from database
	 * @param unknown_type $rs
	 * @param unknown_type $alias
	 */
	static function mapData($rs=array(), $alias=array()){
		if (!is_array($rs) || empty($rs)) return;		
	
		foreach (self::$_property as $name => $prop){
			if (isset($rs[$name])){
				self::set($name, $rs[$name]);
			}
		}
		
		if (is_array($alias) && !empty($alias)) {
			foreach ($alias as $map => $is){
				if (isset(self::$_property[$map]) && isset($rs[$is])){
					self::set($map, $rs[$is]);
				}
			}
		}
	}
	
	/**
	 * set View from form
	 * @param unknown_type $action
	 */
	static function mapReq($action='REQUEST'){
		// Clear request
		self::secureInput();
		
		switch ($action){
			case 'REQUEST':
				$input = $_REQUEST;
				break;
			case 'POST':
				$input = $_POST;
				break;
			case 'GET':
				$input = $_GET;
				break;
			case 'COOKIE':
				$input = $_COOKIE;
				break;
			case 'SESSION':
				$input = $_SESSION;
				break;
			default:
				return;
		}
		
		foreach (self::$_property as $name => $p){
			if (isset($input[$name])){
				self::$_property[$name]['value'] = $input[$name];
			}
		}
		
		return true;
	}

	/**
	 * @filter input
	 */
	static function filterInput(){
		foreach (self::$_property as $name => $p){
			if (!isset($p['type']) || !in_array($p['type'], self::$_type)){
				unset(self::$_property[$name]);
				continue;
			}
			if (!isset($p['display'])) {
				$p['display'] = '';
			}
			if (!isset($p['id']) || $p['id'] == ''){
				$p['id'] = $p['name'];
			}
			if (!isset($p['value'])) {
				$p['value'] = NULL;
			}
			
			// checkbox
			if ($p['type'] == 'checkbox'){
				if (!isset($p['option']) || $p['option'] == '') {
					$p['option'] = '1:'.$p['display'];
					$p['list_data'] = array('1'=>$p['display']);
				} else {
					list($key, $dis) = explode(':', $p['option'], 2);
					$p['list_data'] = array($key => $dis);
				}
				
				self::$_property[$name] = $p;
			}
			
			// use select
			if ($p['type'] == 'select'){
				if (!isset($p['option']) || $p['option'] == '') {
					$p['option'] = ':-';
					$p['list_data'] = array(''=>'-');
				} else {
					$p['list_data'] = array();
					$options = explode('|', $p['option']);
					foreach ($options as $option){
						list($key, $dis) = explode(':', $option, 2);
						$p['list_data'][$key] = $dis;
					}
				}
				
				self::$_property[$name] = $p;
			}
			
			// use radio
			if ($p['type'] == 'radio'){
				if (!isset($p['option']) || $p['option'] == '') {
					$p['option'] = ':-';
					$p['list_data'] = array(''=>'-');
				} else {
					$p['list_data'] = array();
					$options = explode('|', $p['option']);
					foreach ($options as $option){
						list($key, $dis) = explode(':', $option, 2);
						$p['list_data'][$key] = $dis;
					}
				}
				
				
			}
			
			
				// use checkboxlist
			if ($p['type'] == 'checkboxlist'){
				if (!isset($p['option']) || $p['option'] == '') {
					$p['option'] = ':-';
					$p['list_data'] = array(''=>'-');
				} else {
					$p['list_data'] = array();
					$options = explode('|', $p['option']);
					foreach ($options as $option){
						list($key, $dis) = explode(':', $option, 2);
						$p['list_data'][$key] = $dis;
					}
				}
				
				
			}
			
			// set new value
			self::$_property[$name] = $p;
		}
	}
	
	//map data select to the list
	static function mapListData($name='', $data = '',$map=''){
		if (empty($data)) return;
		self::$_property[$name]['value'] = $data;			
		return true;		
	}
	
	/**
	 * @desc Trich xuat du lieu tu $data vao property[list_data] tuong ung voi $map
	 * @param string $name Field name
	 * @param array $data data of select db
	 * @param string $map = $data[key1],$data[key2]
	 * @return true
	 */
	static function setListData($name='', $data=array(), $map=NULL){
		$prop = self::$_property;
		
		if (!is_array($data) || empty($data)) return;
		
		if (is_null($map)){
			self::$_property[$name]['list_data'] = $data;
		} else {
			list($key_name, $value_name) = explode(',', $map, 2);
			$_tmp = array();
			foreach ($data as $rs){
				if (!isset($rs[$key_name]) || !isset($rs[$key_name])) return;
				$_tmp[$rs[$key_name]] = $rs[$value_name];				
			}
			self::$_property[$name]['list_data'] = $_tmp;			
		}
		
		return true;
	}
	
	/**
	 * @desc Print phan mo rong cua tag form
	 * @param array $property
	 */
	static function getExtention($property=array()){
		$html = '';
		$tag = self::$_tag[$property['type']];
		foreach ($tag as $optional){
			if (isset($property[$optional])) {
				$html.= ' ' . $optional . '="'.$property[$optional].'"';
			}
		}
		
		foreach ( self::$_standard as $standard){
			if (isset($property[$standard])) {
				$html.= ' ' . $standard . '="'.$property[$standard].'"';
			}
		}
		
		foreach (self::$_event as $event){
			if (isset($property[$event])) {
				$html.= ' ' . $event . '="'.$property[$event].'"';
			}
		}
		
		
		return $html;
	}
	
	////////////////////////////////
	/**
	 * @desc Convert a string $str to a good string to display on the page
	 * @param string $str
	 * @return $str after converted
	 */
	static function specialChars($str){
		$char = array(	"&"	=> "&amp;",
						"<"	=> "&lt;",
						">"	=> "&gt;",
						"\""=> "&quot;",
						"'"=> "&#039;"
					);
		$str = strtr($str, $char);
		return $str;
	}
}