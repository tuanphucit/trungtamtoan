<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		switch ($act){
			case 'plugin_module':
				$this->pluginModule();
				break;
				
			case 'unplugin_module':
				$this->unpluginModule();
				break;
				
			case 'empty_module':
				$this->emptyModule();
				break;
			
			case 'up_module':
				$this->upModule();
				break;
			
			case 'down_module':
				$this->downModule();
				break;
				
			default:
				$this->response('NOT_TODO');
				break;
		}
	}
	
	// Cắm module vào trang
	function pluginModule(){
		$id = Page::getRequest('page_id','int',0,'POST');
		$position = Page::getRequest('position','str','','POST');
		$module = Page::getRequest('module','str','','POST');
		
		if (!$position || !$module){
			$this->response('NOT_SUCC');
		}
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->selectOne('page', 'id,modules', "`id`='{$id}'");
		if (empty($rs)) $this->response('MSG','Không hợp lệ');
		
		$listMod = !empty($rs['modules']) ? json_decode($rs['modules'], true) : array();
		if (!isset($listMod[$position])) {
			$listMod[$position] = array();
		}
		$listMod[$position][] = $module;
		
		
		//update to database
		$data = array();
		$data['modules'] = json_encode($listMod);
		$id = $dbObj->updateId($id,$data);
		if ($id > 0){
			$this->response('SUCC');
		}
		
		$this->response('NOT_SUCC');
	}
	
	// remove module khoi trang
	function unpluginModule(){
		$id = Page::getRequest('page_id','int',0,'POST');
		$data = Page::getRequest('data','str',null,'POST');
		
		if (empty($data)){
			$this->response('NOT_SUCC');
		}
		
		list($position,$key) = explode('|',$data);
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->selectOne('page', 'id,modules', "`id`='{$id}'");
		if (empty($rs)) $this->response('MSG','Không hợp lệ');
		
		$listMod = !empty($rs['modules']) ? json_decode($rs['modules'], true) : array();
		//print_r($listMod[$position]);die;
		if (isset($listMod[$position][$key])) {
			unset($listMod[$position][$key]);
		}
		
		
		//update to database
		$data = array();
		$data['modules'] = json_encode($listMod);
		$id = $dbObj->updateId($id,$data);
		if ($id > 0){
			$this->response('SUCC');
		}
		
		$this->response('NOT_SUCC');
	}
	
	// empty module khoi trang
	function emptyModule(){
		$id = Page::getRequest('page_id','int',0,'POST');
		$position = Page::getRequest('position','str',null,'POST');
		
		if (!$position){
			$this->response('NOT_SUCC');
		}
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->selectOne('page', 'id,modules', "`id`='{$id}'");
		if (empty($rs)) $this->response('MSG','Không hợp lệ');
		
		$listMod = !empty($rs['modules']) ? json_decode($rs['modules'], true) : array();
		if (isset($listMod[$position])) {
			unset($listMod[$position]);
		}
		
		
		//update to database
		$data = array();
		$data['modules'] = json_encode($listMod);
		$id = $dbObj->updateId($id,$data);
		if ($id > 0){
			$this->response('SUCC');
		}
		
		$this->response('NOT_SUCC');
	}
	
	// up module
	function upModule(){
		$id = Page::getRequest('page_id','int',0,'POST');
		$data = Page::getRequest('data','str',null,'POST');
		
		if (empty($data)){
			$this->response('NOT_SUCC');
		}
		
		list($position,$key) = explode('|',$data);
		
		if ($key < 1){
			$this->response('NOT_TODO');
		}
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->selectOne('page', 'id,modules', "`id`='{$id}'");
		if (empty($rs)) $this->response('MSG','Không hợp lệ');
		
		$listMod = !empty($rs['modules']) ? json_decode($rs['modules'], true) : array();
		
		if (isset($listMod[$position][$key])) {
			$_tmp = $listMod[$position][$key];
			$listMod[$position][$key] = $listMod[$position][$key-1];
			$listMod[$position][$key-1] = $_tmp;
		}
		
		
		//update to database
		$data = array();
		$data['modules'] = json_encode($listMod);
		$id = $dbObj->updateId($id,$data);
		if ($id > 0){
			$this->response('SUCC');
		}
		
		$this->response('NOT_SUCC');
	}
	
	// down module
	function downModule(){
		$id = Page::getRequest('page_id','int',0,'POST');
		$data = Page::getRequest('data','str',null,'POST');
		
		if (empty($data)){
			$this->response('NOT_SUCC');
		}
		
		list($position,$key) = explode('|',$data);
		
		require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
		$dbObj = new DbPagePeer();
		$rs = $dbObj->selectOne('page', 'id,modules', "`id`='{$id}'");
		if (empty($rs)) $this->response('MSG','Không hợp lệ');
		
		$listMod = !empty($rs['modules']) ? json_decode($rs['modules'], true) : array();
		
		if (isset($listMod[$position][$key]) && isset($listMod[$position][$key+1])) {
			$_tmp = $listMod[$position][$key+1];
			$listMod[$position][$key+1] = $listMod[$position][$key];
			$listMod[$position][$key] = $_tmp;
		} else {
			$this->response('NOT_TODO');
		}
		
		
		//update to database
		$data = array();
		$data['modules'] = json_encode($listMod);
		$id = $dbObj->updateId($id,$data);
		if ($id > 0){
			$this->response('SUCC');
		}
		
		$this->response('NOT_SUCC');
	}
}