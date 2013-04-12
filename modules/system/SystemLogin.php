<?php
/**
 * Menu Left
 * @author longhoangvnn
 *
 */
class SystemLogin extends CgsModules{
	function execute() {
		if (Page::getRequest('IS_LOGIN_SYSTEM','def',false,'SESSION')) {
			Page::goLink(null,'page','system');
		}
		
		if (SYSTEM_LOGIN_IS_AUTH === TRUE) {
			return $this->loginByAuth();
		} else {
			return $this->loginByForm();
		}
	}
	
	/**
	 * Kiem tra login
	 */
	function loginByForm() {
		Page::header('Login System CGS');
		Page::reg('css', $this->pathMod().'SystemLogin.css');
		Page::reg('js', $this->pathMod().'SystemLogin.js', 'footer');
		Page::reg('js', CGS_WEBSKINS_PATH.'plugins/jshash-2.2/md5-min.js', 'footer');
		Page::regValidateForm();
		
		$form = new CgsFormsView('system'.DS.'SystemLogin.xml');
		$view = $form->getView('SystemLoginView');
		$view->setValidate(false);
		
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('login_btn_OK', 		$view->getHtml('login_btn_OK'));
		$this->assign('login_btn_RESET', 	$view->getHtml('login_btn_RESET'));
		
		$this->assign('username', 		$view->getHtml('username'));
		$this->assign('password', 		$view->getHtml('password'));
		$this->assign('save_password', 	$view->getHtml('save_password'));
		$this->assign('msg', '');
		
		$this->assign('link_register', Page::link(null,'register','system'));
		$this->assign('link_forgot_password', Page::link(null,'forgot_password','system'));
		
		$this->assign('this_year', date('Y'));
		return $this->output();
	}
	
	function loginByAuth() {
		while (!$this->isAuthenticated()) {
			Page::setRequest('IS_AUTH',true,'SESSION');
			
			header('WWW-Authenticate: Basic realm="Login system CGS"');
			header('HTTP/1.1 401 Unauthorized');
			die('Authorization Required');
		}
		
		Page::goLink(null,'page','system');
	}
	
	/**
	 * Authenticate
	 */
	function isAuthenticated() {
		if (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] != '' && isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] != '') {
			if (!Page::getRequest('IS_AUTH','def',false,'SESSION')) return FALSE;
			
			$httpd_username = filter_var($_SERVER['PHP_AUTH_USER'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW);
			$httpd_password = filter_var($_SERVER['PHP_AUTH_PW'], FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH|FILTER_FLAG_ENCODE_LOW);
			
			require_once CGS_MODEL_PATH.'db'.DS.'DbUserPeer.php';
			$dbObj = new DbUserPeer();
			$rs = $dbObj->getUser($httpd_username);

			if (!empty($rs) && $this->convergeAuthenticateMember($rs['password'],$httpd_username,md5($httpd_password),$rs['password_salt'])) {
				Page::setRequest('IS_LOGIN_SYSTEM',true,'SESSION');
				Page::clearRequest('IS_AUTH','SESSION');
				return TRUE;
			} else {
				$_SERVER['PHP_AUTH_USER'] = '';
				$_SERVER['PHP_AUTH_PW'] = '';
				return FALSE;
			}
		}
		return FALSE;
	}
 
	
	/*-------------------------------------------------------------------------*/
	// Authenticate password
	/*-------------------------------------------------------------------------*/
	/**
	* Check supplied password with converge DB row
	*
	* @param	string	MD5 of entered password
	* @return	boolean
	*/
	function convergeAuthenticateMember($pass_hash = NULL, $user=NULL, $pw = NULL, $pass_salt = NULL){
		if (!$pass_hash){
			return FALSE;
		}
		
		if ($pass_hash == $this->generateCompiledPasshash($user, $pw, $pass_salt)){
			return TRUE;
		}
		
		return FALSE;
	}
	
	/*-------------------------------------------------------------------------*/
	// Generate password
	/*-------------------------------------------------------------------------*/
	/**
	* Generates a compiled passhash
	*
	* Returns a new MD5 hash of the supplied salt and MD5 hash of the password
	*
	* @param	string	User's salt (5 random chars)
	* @param	string	User's MD5 hash of their password
	* @return	string	MD5 hash of compiled salted password
	*/
	function generateCompiledPassHash($user, $pass, $salt){
		return md5(md5($user) . md5($pass) . md5( $salt ));
	}
}