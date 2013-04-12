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

class MCgetLocation extends CgsModules {
	function __construct() {
	}

	function execute() {
		if($_POST['locationsubmit']){
			$provinceID = Page :: getRequest('province', 'int', 1, 'POST');
			Page::setRequest('zone', $provinceID, 'SESSION');
		}
		$zoneID = Page :: getRequest('zone', 'str', '0', 'SESSION');		
		$dbObj = new DefaultProvincePeer();
		$datas = $dbObj->getListAvailable('*');
		Page :: reg('js', Page :: pathMod() . 'MCgetLocation.js');
		Page::reg('css', CGS_WEBSKINS_PATH.'plugins/dialog/dialog.css', 'footer');
			
		$form = new CgsFormsView('mcweb' . DS . 'MCgetLocation.xml');
		$view = $form->getView('MCgetLocationView');
		$view->setListData('province', $datas, 'id,name');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('province', $view->getHtml('province'));
		$this->assign('zoneID', $zoneID);
		$html = $this->output();
		return $html;
	}
}