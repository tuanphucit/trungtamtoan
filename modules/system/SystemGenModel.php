<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPage.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'cgs.database.php';
class SystemGenModel extends CgsModules{
	private $config = null;
	function __construct(){
		
	}
	
	function execute(){		
		$this->tpl(Page::pathTpl().'SystemGenModel.htm');
		Page::reg('js', Page::pathMod().'SystemGenModel.js');
		
		$conn = Page::getRequest('conn','str','default','GET');
		$conns = CgsGlobal::getConnAllDB();
		
		// Khoi tao con tro db
		$dbObj = new CgsDatabase();
		if (isset($conns[$conn])) {
			$dbObj->setProperty($conn);
		} else {
			$conn = 'default';
			$dbObj->setProperty($conns['default']);
		}
		$this->config = $dbObj->getConfig();
		
		// output data infomation
		$data_info = 'Alias database: ' . $conn;
		$data_info.= ' => ' . json_encode($this->config);
		$this->assign('data_info', $data_info);
		
		$tblList = $this->getTables($dbObj);
		
		$form = new CgsFormsView('system'.DS.'SystemGenModel.xml');
		$view = $form->getView('SystemGenModelView');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('gen_btn_OK', 	$view->getHtml('gen_btn_OK'));
		$this->assign('gen_btn_RESET', 	$view->getHtml('gen_btn_RESET'));
		
		$view->setProperty('connection', array('value'=>$conn,'rel'=>Page::link(array('conn'=>''),'gen_model','system')));
		
		// Get option of databases
		$list_data = array();
		$conns_key = array_keys($conns);
		foreach ($conns_key as $key) {
			$list_data[$key] = $key;
		}
		$view->setListData('connection',$list_data);
		
		$this->assign('connection', $view->getHtml('connection'));
		$this->assign('customTable', $view->getHtml('customTable'));
		$this->assign('checkall', $view->getHtml('checkall'));
		
		
		$this->block('BlockList');
		$stt = 0;
		$key = 'Tables_in_'.$this->config['dbname'];
		foreach ($tblList as $row){
			$this->assign('stt', ++$stt);
			$this->assign('chk_tbl', $view->getHtml('item'));
			$this->assign('table_name', $row[$key]);
			$this->add_block('BlockList');
		}
		
		// general model
		$this->assign('msg', $this->generalModel($tblList));
		
		$html = $this->output();
		return $html;
	}
	
	public function getTables(&$dbObj){
	   	$sql = "SHOW TABLES FROM @DATABASE";

		$sql = str_replace('@DATABASE',$this->config['dbname'],$sql);
		$result = $dbObj->query($sql);
		return $dbObj->fetchAll();
    }
    
    function generalModel($tblList=array()) {
    	$conn = Page::getRequest('connection','str','','POST');
    	if ($conn == '') return ;
    	
    	$msg = '';
    	include_once CGS_CODEGEN_PATH.'ModelReader.php';
    	$modelReader = new ModelReader();
    	$modelReader->out_path = CGS_MODEL_PATH.$conn.DS;
    	$modelReader->db_config = $this->config;
    	
    	// Táº¡o Ä‘Æ°á»�ng dáº«n thÆ° má»¥c
    	CgsFunc::createDir($modelReader->out_path, true, '777', $msg);
    	
    	// Generate
    	$modelReader->generateBean($tblList);
    	$msg.= $modelReader->getMsg();
    	
    	// Output messenger in screen
    	if ($msg != '') {
    		$msg = '<div class="notice">'.nl2br($msg).'</div>';
    	}
    	return $msg;
    }
}