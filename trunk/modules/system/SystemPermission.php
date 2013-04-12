<?php
/**
 * Box login
 * @author longhoangvnn
 *
 */
class SystemPermission extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		if (!Page::getRequest('IS_LOGIN_SYSTEM','def',false,'SESSION')) {
			Page::goLink(null,'login','system');
		}
		return;
	}
}