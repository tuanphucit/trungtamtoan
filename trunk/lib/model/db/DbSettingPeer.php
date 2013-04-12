<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

include_once("base/DbSettingBase.php");
class DbSettingPeer extends DbSettingBase {
	function __construct(){
		parent::__construct();
	}

	/**
	 * Lấy cấu hình hệ thống
	 */
	function getConfig(){
		$result = $this->select($this->getTbl(), 'name,value', null, null, null, 'name');
		$data = array();
		foreach ($result as $rs){
			$data[$rs['name']] = $rs['value'];
		}
		return $data;
	}
} // end class