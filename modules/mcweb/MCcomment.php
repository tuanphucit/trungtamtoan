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
class MCcomment extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: reg('js', Page :: pathMod() . 'MCcomment.js');
		$username = '';
		$disable = '';
		if (Page :: isLogIn()) {
			$username = Page :: getRequest('username', 'str', NULL, 'SESSION');
			$disable = 'disabled = "true"';
		}	
		$this->assign('disable',$disable);
		$this->assign('username',$username);
		$this->assign('currentLink',$currentLink = $this->curPageURL());
		$html = $this->output();
		return $html;
	}	
}