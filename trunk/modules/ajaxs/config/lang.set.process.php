<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$data = Page::getRequest('data','str','','POST');
		$val = Page::getRequest('val','str','','POST');
		
		list($dir, $filename, $key) = explode('|',$data,3);
		
		$file = CGS_LANG_PATH . $dir . $filename . '.php';
				
		if (file_exists($file)){
			require_once $file;
		}
		
		if (!isset($lang) || !is_array($lang)){
			$lang = array();
		}
		
		$lang[$key] = $val;
		
		$strOut = '<?php'."\n";
		$strOut.= 'if (!isset($lang) || !is_array($lang)) $lang = array();'."\n";
		foreach ($lang as $l_key => $l_val){
			$strOut.= "\n\$lang['{$l_key}']\t= '{$l_val}';";
		}
		
		$handle  = @fopen($file, 'w');
		if ($handle){
			fwrite($handle, $strOut);
			fclose($handle);
			echo 'SUCC';
		} else {
			echo 'Không có quyền ghi file '.$file;
		}

	}
}