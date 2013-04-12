<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class CgsHandling {
	private $code;
	private $msg;
	private $file;
	private $line;
	private $errortype = array (
            E_ERROR           => "Error",			//code = 1
            E_WARNING         => "Warning",			//code = 2
            E_PARSE           => "Parsing Error",	//code = 4
            E_NOTICE          => "Notice",			//code = 8
            E_CORE_ERROR      => "Core Error",		//code = 16
            E_CORE_WARNING    => "Core Warning",	//code = 32
            E_COMPILE_ERROR   => "Compile Error",	//code = 64
            E_COMPILE_WARNING => "Compile Warning",	//code = 128
            E_USER_ERROR      => "User Error",		//code = 256
            E_USER_WARNING    => "User Warning",	//code = 512
            E_USER_NOTICE     => "User Notice",		//code = 1024
            E_ALL			  => "All errors and warnings",		//code = 1047
           	E_STRICT          => "Runtime Notice"	//code = 2048
            );
    static private $handling = array();
    
	function CgsHandling($errCode,$errMessage,$errFile,$errLine){
		$this->setCode($errCode);
		$this->setFile($errFile);
		$this->setLine($errLine);
		$this->setMsg($errMessage);
	}
	
	function outputHandling(){
		if (isset($this->errortype[$this->getCode()])){
			array_push(self::$handling, array(
											'type'		=> $this->getTypeCode(),
											'code'		=> $this->getCode(),
											'message'	=> $this->getMsg(),
											'file'		=> $this->getFile(),
											'line'		=> $this->getLine(),
										));
			if (CGS_LOG_ERROR 
				&& (is_null(CgsGlobal::getSetting('LOG_ENABLE')) || CgsGlobal::getSetting('LOG_ENABLE')) 
				&& (is_null(CgsGlobal::getSetting('LOG_ERROR')) || CgsGlobal::getSetting('LOG_ERROR'))) {
				$error = $this->getTypeCode();
				$error.= '(' . $this->getCode() . ') ';
				$error.= '{' . $this->getMsg() . '}' . "\n";
				$error.= 'File: [' . $this->getFile() . '(' . $this->getLine() . ')]' . "\n";
				$error.= "\n";
				CgsLog::log('ERROR_'.date('Y-m-d_H', time()), $error);
			}
		}
	}
	
	
	function printError(){
		if (isset($this->errortype[$this->getCode()])){
			$str = "<b>" . $this->getTypeCode() . "</b>(" . $this->getCode() . "): ";
			$str.= "{message:" . $this->getMsg() . "} ";
			$str.= "{file:" . $this->getFile() . "(" . $this->getLine() . ")} ";
			
			echo "<span style='color:red;background:#f1f1f1;'>".$str."</span>\n";
			//cgsConfig::push('cgs_error', $str);
		}
	}
	
	function setCode($val = NULL){
		$this->code = $val;
	}
	function getCode(){
		return $this->code;
	}
	function getTypeCode(){
		return isset($this->errortype[$this->code])?$this->errortype[$this->code]:NULL;
	}
	
	function setMsg($val = NULL){
		$this->msg = $val;
	}
	function getMsg(){
		return $this->msg;
	}
	
	function setFile($val = NULL){
		$this->file = $val;
	}
	function getFile(){
		return $this->file;
	}
	
	function setLine($val = NULL){
		$this->line = $val;
	}
	function getLine(){
		return $this->line;
	}
	
	function getTraceAsString(){
		$tr = debug_backtrace();
		$str = "";
		for ($i=3; $i<count($tr); $i++){
			$str .= "#" . ($i-3) .":\n";
			$str .= isset($tr[$i]["file"])? "file:" . $tr[$i]["file"] . "\n":"";
			$str .= isset($tr[$i]["line"])? "line:" . $tr[$i]["line"] . "\n":"";
			$str .= isset($tr[$i]["function"])? "function:" . $tr[$i]["function"] . "\n":"";
			$str .= isset($tr[$i]["class"])? "class:" . $tr[$i]["class"] . "\n":"";
			$str .= isset($tr[$i]["type"])? "type:" . $tr[$i]["type"] . "\n":"";
		}
		return $str;
	}
	
	static function getHandling(){
		return self::$handling;
	}
}
//error handler function
function cusErr($error_level,$error_message,$error_file,$error_line) {
	if (!defined("CGS_DEBUG") OR CGS_DEBUG){
		$CgsHandling = new CgsHandling($error_level,$error_message,$error_file,$error_line);
		//$cgsHandling->printError();
		$CgsHandling->outputHandling();
	}
}
//set error handler
set_error_handler("cusErr"); //trigger error
?>