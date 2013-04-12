<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

include_once("base/DbUserBase.php");
class DbUserPeer extends DbUserBase {
	function __construct(){
		parent::__construct();
	}
	
	/**
	 * Lấy thông tin user
	 * @param $username
	 */
	function getUser($username='') {
		$username = mysql_escape_string($username);
		$result = $this->selectOne($this->getTbl(), 'user_id,username,password,password_salt', "`username`='{$username}'");
		return $result;
	}
} // end class