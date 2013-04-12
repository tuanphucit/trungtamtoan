<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		switch ($act){
			case 'scan':
				$this->scanAndAddProcess();
				break;
				
			case 'reload':
				$this->reloadProcess();
				break;
				
			default:
				$this->response('NOT_TODO');
				break;
		}
	}

	function scanAndAddProcess(){
		$files = $this->_getFile(CGS_LAYOUT_PATH, '.htm');
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbLayoutPeer.php';
		$dbObj = new DbLayoutPeer();
		
		// Danh sach cac layout da ton tai
		$rs = $dbObj->select('layout', 'id,layout_name', null, null, null, 'layout_name');
		
		$msg = '';
		
		$data_del = array();	// Danh sach file layout khong ton tai, phai xoa khoi he thong
		foreach ($rs as $file=>$r){
			if (isset($files[$file])){
				// Neu ton tai thi ghi nho va loai bo khoi danh sach can insert 
				unset($files[$file]);
			} else {
				// Neu khong ton tai thi dua vao danh sach xoa
				$data_del[] = $file;
				$msg.= '- [ DEL ] : "' . $file . "\"\n";
			}
		}
		
		$data = array();		// Danh sach file can insert moi
		foreach ($files as $file){
			$data[] = array('layout_name'=>$file);
			$msg.= '- [ INSERT ] : "' . $file . "\"\n";
		}
	
		// Neu khong phat sinh them thi tra ve khong xu ly
		if (empty($data) && empty($data_del)) {
			$this->response('NOT_PROCESSING');
		}
		
		// Xóa các bản ghi thừa, không còn tồn tại
		if (!empty($data_del)) {
			$str_del = "'".implode("','",$data_del)."'";
			$result = $dbObj->delete('module','`path` IN ('.$str_del.')');
		}
		
		if (!empty($data)){
			$id = $dbObj->insertMulti('layout',$data);
		}
		
		if ($msg != '') $this->response('MSG',$msg);
		
		$this->response('NOT_SUCC');
	}
	
	function reloadProcess(){
		return $this->scanAndAddProcess();
	}
	
	
	/**
	 * get content file
	 * @param $dir string
	 * @param $extention string
	 */
	private function _getFile($dir="", $extention=""){
		$f = array();
		if (file_exists($dir)){
			if ($handle = opendir($dir)) {
			    
			    while (false !== ($file = readdir($handle))) {
			        if (substr($file,-strlen($extention)) === $extention){
			        	$f[$file] = $file;
			        }
			    }
			    closedir($handle);
			}
		}
		return $f;
	}

}