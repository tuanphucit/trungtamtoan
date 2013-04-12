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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultUniversityPeer.php';

class MCfindMark extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: header('Tra cứu điểm thi Đại học - Cao đẳng 2012');
		
		$dbObj = new DefaultUniversityPeer();
		include_once (CGS_LIB_PATH.'crawls/infoEducation.php');
		$educrawl = new InfoEducation();
		
		$arrUni = $educrawl->getListUniversity();
		$datas = array();
			
		if($arrUni){
			$data = array();
			foreach($arrUni as $uni){
				$data = $uni;
				if(trim($data['name'])!='' && trim($data['code'])!=''){						
					$datas[] = array('code'=>trim($data['code']), 'name'=>trim($data['name']));
				}	
			}			
			
			$sortArray = array();			
			foreach($datas as $person){
			    foreach($person as $key=>$value){
			        if(!isset($sortArray[$key])){
			            $sortArray[$key] = array();
			        }
			        $sortArray[$key][] = $value;
			    }
			}
			
			$orderby = "name"; //change this to whatever key you want from the array			
			array_multisort($sortArray[$orderby],SORT_ASC,$datas); 
		}
		
		

		Page :: reg('js', Page :: pathMod() . 'MCfindMark.js');
		Page::reg('js', CGS_WEBSKINS_PATH.'plugins/dialog/dialog.js', 'header');
		Page::reg('css', CGS_WEBSKINS_PATH.'plugins/dialog/dialog.css', 'footer');
			
		$form = new CgsFormsView('mcweb' . DS . 'MCfindMark.xml');
		$view = $form->getView('MCfindMarkView');
		$view->setValidate(true);
		$view->setListData('university', $datas, 'code,name');
		$this->assign('count',sizeof($datas));
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('university', $view->getHtml('university'));
		$this->assign('name_search', $view->getHtml('name_search'));
		$this->assign('searchType', $view->getHtml('searchType'));
		$this->assign('currentLink',$currentLink = $this->curPageURL());
		
		$html = $this->output();
		return $html;
	}
}