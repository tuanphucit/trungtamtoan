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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDocumentPeer.php';

class ShowDoc extends CgsModules {
	function __construct() {
	}

	function execute() {
		$id = Page :: getRequest('id', 'int', 0, 'GET');
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		$docObj = new DefaultDocumentPeer();
		$file = $docObj->getRow($id,'*');
			$newStatus = ($file['status']==0)?1:0;
			$data = array (
				'userupdate' => Page::getRequest('username','str','','SESSION'),
				'updatetime'=>current(),
				'status'=>$newStatus,
			);
			$docObj->updateId($id, $data);
			Page::goLink(null,'ManageAllDoc','manager');
	}
}