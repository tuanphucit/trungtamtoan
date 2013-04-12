<?php
require_once 'lib/Tag.class.php';
require_once 'lib/RepeatTag.class.php';
require_once 'lib/WriteTag.class.php';
//require_once 'lib/TplReader.php';

class ModelReader {
	public $db_config;
	public $out_path;
	private $msg = '';
	
	function ModelReader() {
		
	}
	
	function generateBean($tblList=array()) {
		if (empty($tblList)) return;
		
		$key = 'Tables_in_'.$this->db_config['dbname'];
    	foreach ($tblList as $row) {
    		$tbl_name = $row[$key];
    		
    		// Gen model
    		$this->createModelPeer($tbl_name);
    		
    		// Gen Base file
    		$this->createModelBase($tbl_name);
    	}
	}
	
	function createModelBase($table) {
		$table_name = $this->filterFilename($table, $this->db_config['prefix']);
		$ClassName = $this->getFilename($this->db_config['connection'].'_'.$table_name);
		$srcFile = $this->out_path . 'base' . DS . $ClassName.'Base.php';
		CgsFunc::createDir($this->out_path . 'base', true, '777', $this->msg);
		
		@$handle = fopen($srcFile,"w");
		if (!$handle){
			$this->msg .= "table[".$table . "] = '".$this->db_config['connection']."/base/{$ClassName}Base.php': <label style=\"color:red;\">SYSTEM CAN NOT CREATE MODEL BASE! Failed to open stream!</label>\n";
			return;
		}
		
		$dom = $this->tplReader('model_function_base.xml');
		$params = array(
			'CLASS_NAME' => $ClassName,
			'CONNECTION' => $this->db_config['connection'],
			'TABLE_NAME' => $table_name,
			'PREFIX' => $this->db_config['prefix']
		);
		$objGen = '';
		foreach($dom->getElementsByTagName("class") as $classElement){
			$objGen.= $this->doClassTag($classElement, $params);
		}
		fwrite($handle,$objGen);
		fclose($handle);
		$this->msg .= "table[".$table . "] = '".$this->db_config['connection']."/base/{$ClassName}Base.php': <label style=\"color:blue;\">CREATE MODEL BASE SUCCESSFUL</label><br>";
		return true;
	}
	
	function createModelPeer($table) {
		$table_name = $this->filterFilename($table, $this->db_config['prefix']);
		$ClassName = $this->getFilename($this->db_config['connection'].'_'.$table_name);
		$srcFile = $this->out_path . $ClassName.'Peer.php';
		
		if (file_exists($srcFile)) {
			$this->msg .= "table[".$table . "] = '".$this->db_config['connection']."/{$ClassName}Peer.php': <label style=\"color:red;\">File is exists!</label>\n";
			return;
		}
		
		CgsFunc::createDir($this->out_path);
		@$handle = fopen($srcFile,"w");
		if (!$handle){
			$this->msg .= "table[".$table . "] = '".$this->db_config['connection']."/{$ClassName}Peer.php': <label style=\"color:red;\">SYSTEM CAN NOT CREATE MODEL BASE! Failed to open stream!</label>\n";
			return;
		}
		
		$dom = $this->tplReader('model_function_peer.xml');
		$params = array(
			'CLASS_NAME' => $ClassName
		);
		$objGen = '';
		foreach($dom->getElementsByTagName("class") as $classElement){
			$objGen.= $this->doClassTag($classElement, $params);
		}
		fwrite($handle,$objGen);
		fclose($handle);
		$this->msg .= "table[".$table . "] = '".$this->db_config['connection']."/{$ClassName}Peer.php': <label style=\"color:blue;\">CREATE MODEL PEER SUCCESSFUL</label><br>";
		return true;
	}
	
	// output file name
	function getFilename ($tbl_name) {
		return $this->convertUnderscoreToUpperFirst($tbl_name);
	}
	
	function filterFilename($tbl='', $prefix='') {
		if ($prefix == '') return $tbl;
		if (substr($tbl , 0, strlen($prefix)) == $prefix) {
			return substr($tbl , strlen($prefix), strlen($tbl));
		}
		return $tbl;
	} 
	
	// Send messenger
	function getMsg() {
		return $this->msg;
	}
	
	////////////////////////////////
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