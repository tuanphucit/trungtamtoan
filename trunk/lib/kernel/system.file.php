<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class CgsFile {
	private $file;
	
	// r, r+, w, w+, a, a+, x, x+
	private $mode = 'r';
	
	private $handle;
	
	function CgsFile() {
		
	}
	
	public static function loadFile($sFilename, $sCharset = 'UTF-8') {
		/*if (floatval(phpversion()) >= 4.3) {
			$sData = file_get_contents($sFilename);
		} else {*/
			if (!file_exists($sFilename)) return -3;
			$rHandle = fopen($sFilename, 'r');
			if (!$rHandle) return -2;
			
			$sData = '';
			while(!feof($rHandle))
				$sData .= fread($rHandle, filesize($sFilename));
			fclose($rHandle);
		//}
		/*if ($sEncoding = mb_detect_encoding($sData, 'auto', true) != $sCharset)
			$sData = mb_convert_encoding($sData, $sCharset, $sEncoding);*/
		return $sData;
	}
	
	public static function data($filename=''){
		try {
			$str = implode ( "", @file ( $filename ) );
			if (empty ( $str )) {
				throw new Exception ( "loadfile: While loading $handle, $filename does not exist or is empty." );
				$this->halt ( "loadfile: While loading $handle, $filename does not exist or is empty." );
				return false;
			}
			
			
			return $str;
		} catch ( Exception $ex ) {
			//$this->print_err_exception ( $ex );
		}
	}
}