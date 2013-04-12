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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultProvincePeer.php';

class MClistClass extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: header('Danh sách lớp');
		Page :: reg('js', Page :: pathMod() . 'MClistClass.js');
		$zone = Page :: getRequest('zone', 'str', '0', 'SESSION');	
		$this->createLoctionForm($zone);	
		$html = $this->output();
		return $html;
	}
	
	private function createLoctionForm($zone){
		$provinceObj = new DefaultProvincePeer();
		$allprovince 	= $provinceObj->getListAll('*');
		$form = new CgsFormsView('mcweb' . DS . 'MCgetLocation.xml');
		$view = $form->getView('MCgetLocationInPage');
		$view->setListData('provinceChange', $allprovince, 'id,name');
		$view->mapListData('provinceChange', $zone, '');
		$this->assign('provinceName',"Khu vực: ".$view->getHtml('provinceChange'));
	}
}