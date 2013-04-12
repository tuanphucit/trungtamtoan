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
defined('IN_CGS') or die('Restricted Access');
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultArticlePeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultUniversityPeer.php';

class MCcrawl extends CgsModules {
	function __construct() {
	}

	function execute() {	
	Page :: reg('js', Page :: pathMod() . 'MCcrawl.js');
	
	include_once (CGS_LIB_PATH.'crawls/infoEducation.php');
		$educrawl = new InfoEducation();
		$arrData = $educrawl->getNewArticle();
		$data = array();
		for($i=sizeof($arrData)-1;$i>=0;$i--){		
			$data = $arrData[$i];
			$data['category_id'] = 1;	
			$data['status'] = 1;					
			$data['updatetime'] = current();
			$subject = $data['subject'];
			$dbObj = new DefaultArticlePeer();	
			$select = $dbObj->select('article','*',"subject = '".$subject."'",null,'0,1');
			sleep(1);
			$mesage = "thất bại";
			if(!$select){		
				$id = $dbObj->insert("article",$data);
				$mesage = "thành công";
			}	
		}
		
		$arrUni = $educrawl->getListUniversity();
		$data = array();
		foreach($arrUni as $uni){	
			$data = $uni;
			if(trim($data['name'])!='' && trim($data['code'])!=''){
				$dbObj = new DefaultUniversityPeer();	
				$select = $dbObj->select('university','*',"name = '".$data['name']."'",null,'0,1');				
				if(!$select){		
					$id = $dbObj->insert("university",$data);
				}
			}	
		}
		$this->assign('status',$mesage);
		$html = $this->output();
		return $html;
	}
}