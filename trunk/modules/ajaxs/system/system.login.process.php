<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		switch ($act){
			case 'login':
				$this->loginProcess();
				break;
				
			case 'register':
				$this->registerProcess();
				break;
				
			case 'forgot_password':
				$this->forgotPassProcess();
				break;
				
			default:
				$this->response('NOT_TODO');
				break;
		}
	}
	
	function loginProcess(){
		$username = Page::getRequest('username','str','','POST');
		$password = Page::getRequest('password','str','','POST');
		$save_password = Page::getRequest('save_password','int',0,'POST');

		if ($username && $password){
			require_once CGS_MODEL_PATH.'db'.DS.'DbUserPeer.php';
			$dbObj = new DbUserPeer();
			
			$rs = $dbObj->getUser($username);
			if (!empty($rs) && $this->convergeAuthenticateMember($rs['password'],$username,$password,$rs['password_salt'])) {
				if ($save_password === 1) {
					// set cookie
					Page::setRequest('IS_LOGIN_SYSTEM_SAVE_PW',true,'COOKIE');
				}
				
				Page::setRequest('IS_LOGIN_SYSTEM',true,'SESSION');
				$this->response('SUCC','Đăng nhập thành công');
			}
			
		}
		
		$this->response('NOT_SUCC');
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
		return md5($user.md5($pass));
	}
	
	/*-------------------------------------------------------------------------*/
	// Generate SALT
	/*-------------------------------------------------------------------------*/
	
	/**
	* Generates a password salt
	*
	* Returns n length string of any char except backslash
	*
	* @param	integer	Length of desired salt, 5 by default
	* @return	string	n character random string
	*/
	
	function generatePasswordSalt($len=5){
		$salt = '';
		
		//srand( (double)microtime() * 1000000 );
		// PHP 4.3 is now required ^ not needed
		
		for ( $i = 0; $i < $len; $i++ )	{
			$num   = rand(33, 126);
			
			if ( $num == '92' ){
				$num = 93;
			}
			
			$salt .= chr( $num );
		}
		
		return $salt;
	}

}