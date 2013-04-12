<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		if ($act == 'scan_all'){
			$this->scanAndAddAllProcess();
		} else if ($act == 'scan_custom'){
			$this->scanAndAddCustomProcess();
		} else {
			$this->response('NOT_TODO');
		}
	}
	
	/**
	 * get module
	 */
	function scanAndAddCustomProcess() {
		$this->response('MSG','Chua lam!!!');
	}
	
	/**
	 * get all Module
	 */
	function scanAndAddAllProcess(){
		$mod_reading = array();
		$this->readingModule($mod_reading);
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbModulePeer.php';
		$dbObj = new DbModulePeer();
		
		// Danh sach cac module da ton tai
		$rs = $dbObj->select('module', 'id,path', null, null, null, 'path');
		
		$msg = '';
		
		$data_del = array();	// Danh sach file module khong ton tai, phai xoa khoi he thong
		foreach ($rs as $file=>$r){
			if (isset($mod_reading[$file])){
				// Neu ton tai thi ghi nho va loai bo khoi danh sach can insert 
				unset($mod_reading[$file]);
			} else {
				// Neu khong ton tai thi dua vao danh sach xoa
				$data_del[] = $file;
				$msg.= '- [ DEL ] : "' . $file . "\"\n";
			}
		}
		
		
		$data = array();		// Danh sach file can insert moi
		foreach ($mod_reading as $file){
			$data[] = array('name'=>$file,'path'=>$file);
			$msg.= '- [ INSERT ] : "' . $file . "\"\n";
		}
	
		// Neu khong phat sinh them thi tra ve khong xu ly
		if (empty($data) && empty($data_del)) $this->response('NOT_PROCESSING');
		
		// Xóa các bản ghi thừa, không còn tồn tại
		if (!empty($data_del)) {
			$str_del = "'".implode("','",$data_del)."'";
			$result = $dbObj->delete('module','`path` IN ('.$str_del.')');
		}
		
		if (!empty($data)){
			$id = $dbObj->insertMulti('module',$data);
		}
		
		if ($msg != '') $this->response('MSG',$msg);
		
		$this->response('NOT_SUCC');
	}
	
	// Doc tat ca cac file trong MODULE action
	function readingModule(&$mod_reading,$dir="",$extention='.php'){
		$none_inc = array('.','..','ajaxs','debug','includes','config','config.php','define.php');
		if (!is_array($mod_reading)) $mod_reading = array();
		
		if (file_exists(CGS_MODULES_PATH.$dir)){
			if ($handle = opendir(CGS_MODULES_PATH.$dir)) {
			    
			    while (false !== ($file = readdir($handle))) {
			    	if (in_array($file, $none_inc)) continue;
			    	
			    	if (is_dir(CGS_MODULES_PATH.$dir.$file.DS)){
			    		$this->readingModule($mod_reading,$dir.$file.DS);
			    		
			    	} else if (substr($file,-strlen($extention)) === $extention){
			        	$mod_reading[$dir.$file] = $dir.$file;
			        }
			    }
			    closedir($handle);
			}
		}
		return;
	}
}