<?php 
require_once 'lib/Tag.class.php';
require_once 'lib/RepeatTag.class.php';
require_once 'lib/WriteTag.class.php';

class UiReader {
	public $source_path = null;
	public $out_path = null;
	private $viewer = array();
	private $fields = array();
	
	private $prefix;
	private $validateType;
	private $imeSupport;
	private $fErrorHandle;
	private $screenId;
	
	function UiReader(){
		
	}
	
	/**
	 * Doc file xml lay thuoc tinh
	 */
	function read(){
		if (!file_exists($this->source_path)){
			throw new CgsException('Khong ton tai file <b>' . $this->source_path . '</b>');
		}
		
		// Read xml 
		$dom = new DomDocument();
		$dom->load($this->source_path);
		foreach($dom->getElementsByTagName("bean") as $bean){
			$beanName = $bean->getAttribute("name");
			$form = array();
			
			$form['name'] = $beanName;
			if ($bean->getAttribute("id") != '')
				$form['id'] = $bean->getAttribute("id");
			if ($bean->getAttribute("action") != '')
				$form['action'] = $bean->getAttribute("action");
			if ($bean->getAttribute("method") != '')
				$form['method'] = $bean->getAttribute("method");
			if ($bean->getAttribute("onsubmit") != '')
				$form['onsubmit'] = $bean->getAttribute("onsubmit");
			
			foreach($bean->getElementsByTagName("property") as $element){
				$name = $element->getAttribute("name");
				$property = array();
				
				if ($element->getAttribute("type") != '')
					$property['type'] = $element->getAttribute("type");
				if ($element->getAttribute("name") != '')
					$property['name'] = $element->getAttribute("name");
				if ($element->getAttribute("id") != '')
					$property['id'] = $element->getAttribute("id");
				//if ($element->getAttribute("value") != '')
					$property['value'] = $element->getAttribute("value");
				if ($element->getAttribute("display") != '')
					$property['display'] = $element->getAttribute("display");
				if ($element->getAttribute("required") != '')
					$property['required'] = $element->getAttribute("required");
				if ($element->getAttribute("field") != '')
					$property['field'] = $element->getAttribute("field");
				if ($element->getAttribute("fieldex") != '')
					$property['fieldex'] = $element->getAttribute("fieldex");
				if ($element->getAttribute("maxsize") != '')
					$property['maxsize'] = $element->getAttribute("maxsize");
				if ($element->getAttribute("minsize") != '')
					$property['minsize'] = $element->getAttribute("minsize");
				if ($element->getAttribute("fdata") != '')
					$property['fdata'] = $element->getAttribute("fdata");
				if ($element->getAttribute("option") != '')
					$property['option'] = $element->getAttribute("option");
				if ($element->getAttribute("validateType") != '')
					$property['validateType'] = $element->getAttribute("validateType");
				if ($element->getAttribute("syntax_name") != '')
					$property['syntax_name'] = $element->getAttribute("syntax_name");
				if ($element->getAttribute("size") != '')
					$property['size'] = $element->getAttribute("size");
				if ($element->getAttribute("maxlength") != '')
					$property['maxlength'] = $element->getAttribute("maxlength");
				if ($element->getAttribute("class") != '')
					$property['class'] = $element->getAttribute("class");
				if ($element->getAttribute("style") != '')
					$property['style'] = $element->getAttribute("style");
				if ($element->getAttribute("rows") != '')
					$property['rows'] = $element->getAttribute("rows");
				if ($element->getAttribute("cols") != '')
					$property['cols'] = $element->getAttribute("cols");
				if ($element->getAttribute("alt") != '')
					$property['alt'] = $element->getAttribute("alt");
				if ($element->getAttribute("accept") != '')
					$property['accept'] = $element->getAttribute("accept");
				if ($element->getAttribute("readonly") != '')
					$property['readonly'] = $element->getAttribute("readonly");
				if ($element->getAttribute("disabled") != '')
					$property['disabled'] = $element->getAttribute("disabled");
				if ($element->getAttribute("accesskey") != '')
					$property['accesskey'] = $element->getAttribute("accesskey");
				if ($element->getAttribute("multiple") != '')
					$property['multiple'] = $element->getAttribute("multiple");
				if ($element->getAttribute("tabindex") != '')
					$property['tabindex'] = $element->getAttribute("tabindex");
				if ($element->getAttribute("autocomplete") != '')
					$property['autocomplete'] = $element->getAttribute("autocomplete");
				if ($element->getAttribute("calendar") != '')
					$property['calendar'] = $element->getAttribute("calendar");
				if ($element->getAttribute("calendar_format") != '')
					$property['calendar_format'] = $element->getAttribute("calendar_format");
				if ($element->getAttribute("rel") != '')
					$property['rel'] = $element->getAttribute("rel");
				
				$this->fields[$beanName][$name] = $property;
			}
			$this->viewer[$beanName] = $this->fields[$beanName];
			$this->viewer[$beanName]['form'] = $form;
		}
		
		// Generate
		$this->generateBean();
		
	} // end function read
	
	
	/**
	 * generateBean:
	 * - Read the template (ui_template)
	 * - Parse the array to tempate
	 * - Create the VIEW
	 * - Name of object is specified by the attribute "name" in tag <bean> in XML.
	 * @param string $beanName Name of object.
	 * @param array $properties All <property> of object specified in XML.
	 */
	function generateBean(){
		if(!file_exists($this->out_path)){
			@mkdir($this->out_path);
			@exec("chmod 777 ".$this->out_path);
		}
		if(!file_exists($this->out_path."/base")){
			@mkdir($this->out_path."/base");
			@exec("chmod 777 ".$this->out_path."/base");
		}
		
		$dom_base = $this->tplReader('ui_function_base.xml');
		$dom = $this->tplReader('ui_function.xml');
		
		foreach ($this->viewer as $beanName => $fields){
			$params_base = $this->getParamsOfBase($beanName, $fields);
			
			// create base
			$file_ui_base = $this->out_path.'base'.DS.$beanName.'Base.php';
			$handle_base = fopen($file_ui_base,"w");
			$objGen = '';
			foreach($dom_base->getElementsByTagName("class") as $classElement){
				$objGen.= $this->doClassTag($classElement, $params_base);
			}
			fwrite($handle_base, $objGen);
			fclose($handle_base);
			
			///////////////////////////////////////
			$params = $this->getParamsOfUi($beanName, $fields);
			// create ui
			$file_ui = $this->out_path.$beanName.'.php';
			if (!file_exists($file_ui)) {
				$handle = fopen($file_ui,"w");
				$objGen = '';
				foreach($dom->getElementsByTagName("class") as $classElement){
					$objGen.= $this->doClassTag($classElement, $params);
				}
				fwrite($handle, $objGen);
				fclose($handle);
			}
		}
	}
	
	function getParamsOfBase($beanName = 'Base', $fields=array()){
		$params = array();
		$params['CLASS_NAME']	= $beanName . 'Base';
		$params['BEAN_PROPERTY']	= '';
		$params['FIELD_NAME']	= array();
		$params['FIELD_VALUE']	= array();
		$params['FieldsName']	= array();
		$params['field_name']	= array();
		
		// Build form begin
		if (isset($fields['form'])){
			$form = $fields['form'];
			unset($fields['form']);
			
			$_BEAN_PROPERTY = '';
			foreach($form as $key=>$val){
				$_BEAN_PROPERTY.= '"'.$key.'" => "'.$val.'",';
			}
			$params['BEAN_PROPERTY'] = $_BEAN_PROPERTY;
		}
		
		// Build property of form
		foreach ($fields as $key => $prop){
			$field = '';
			foreach ($prop as $k=>$v) {
				$field.= '"'.$k.'" => "'.$v.'",';
			}
			if (!isset($prop['value'])) {
				$field.= '"value"="",';
			}
			
			$params['FIELD_VALUE'][]	= $field;
			$params['FIELD_NAME'][]	= $prop['name'];
			$params['FieldsName'][]	= $this->convertUnderscoreToUpperFirst($prop['name']);
			$params['field_name'][]	= $prop['name'];
		}
		
		return $params;
	}
	
	function getParamsOfUi($beanName = 'Base', $fields=array()){
		$params = array();
		$params['CLASS_NAME']	= $beanName;
		foreach ($fields as $key => $prop){
			
			
		}
		
		return $params;
	}
	
	
	function tplReader($file=NULL){
		$file = CGS_CODEGEN_PATH . 'templates'.DS.$file;
		$dom = new DomDocument();
		$dom->load($file);
		return $dom;
	}
	
	/** doClassTag:
	 * Process the "class" tag.
	 */
	function doClassTag($classElement, $params=array()){
		$textClass = "";
		foreach( ($classElement->childNodes) as $child){
			switch($child->nodeName){
				case "repeat":
					$repeatTag = new RepeatTag($child,$params);
					$textClass .= $repeatTag->getContent();
					break;
				case "write":
					$writeTag = new WriteTag($child,$params);
					$textClass .= $writeTag->getContent();
					break;
			}
			
		}
		
		return $textClass;
	}
	
	/**
	 * E.g: ab_ecd ---> AbEcd
	 */
	function convertUnderscoreToUpperFirst($str){
		return ucfirst($this->convertUnderscoreToUppercase($str));
	}
	
	/**
	 * Convert underscore name to Camel name.
	 * E.g: abc_mnpq ---> abcMnpq
	 */
	function convertUnderscoreToUppercase($str=NULL){
		if (is_null($str)){
			return;
		}
		$offset = 0;
		while($offset !== FALSE){
			$offset = strpos($str,"_",$offset + 1);
			if ($offset !== FALSE){
				$str = substr($str, 0, $offset).strtoupper(substr($str,$offset + 1,1)).substr($str,$offset+2);
			}
		}
		$str = str_replace("_","",$str);
		return $str;
	}
}

