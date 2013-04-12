<?php
/**
 * Menu Left
 * @author longhoangvnn
 *
 */
class SystemLogout extends CgsModules{
	function execute() {
		Page::header('Logout System CGS');
		
		// Xoa session
		Page::clearRequest('IS_LOGIN_SYSTEM','SESSION');
		session_destroy();
		
		// Xoa Authenticated
		if (isset($_SERVER['PHP_AUTH_USER'])) $_SERVER['PHP_AUTH_USER'] = '';
		if (isset($_SERVER['PHP_AUTH_PW'])) $_SERVER['PHP_AUTH_PW'] = '';
		
		$url = Page::link(null,'login','system');
		header( "refresh:1;url={$url}" ); 
		return 'You\'ll be redirected in about 1 secs. If not, click <a href="'.$url.'">here</a>.';
	}
}