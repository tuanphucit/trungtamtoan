<?php
defined('IN_CGS') or die ('Restricted Access');
/**
 * @desc Process of Ajax
 * @author longhoangvnn
 *
 */
class CgsAjaxProcess {
	private $status = array(
				'SUCC'		=> 'Thực hiện Thành công',
				'NOT_SUCC'	=> 'Thực hiện không thành công',
				'NOT_TODO'	=> 'Không làm gì cả',
				'PROCESSING'	=> 'Đang xử lý',
				'NOT_PROCESSING'=> 'Không xử lý gì',
				'ERROR'	=> 'Thực hiện bị Lỗi',
				'MSG'	=> 'Messenger'
			);
	function __construct() {
		
	}
	
	function response($status='NOT_TODO',$data='',$type='string') {
		$xml = '<response type="true">';
		
		// status
		if (!isset($this->status[$status])) {
			$xml.= '<status value="NOT_TODO">NOT_TODO</status>';
			$xml.= '<data type="string"></data>';
		} else {
			$xml.= '<status value="'.$this->status[$status].'">'.$status.'</status>';
			$xml.= '<data type="'.gettype($data).'">'.json_encode($data).'</data>';
			$xml.= $this->_getTagOfStatus($status);
		}
		
		$xml.= '</response>';
		
		echo $xml;
		die();
		return $xml;
	}
	
	/**
	 * return other tag
	 * @param unknown_type $status
	 */
	private function _getTagOfStatus($status='NOT_TODO') {
		$xml = '';
		if ((CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_SQL_QUERY')) || CGS_DEBUG) {
			$dataSql = CgsGlobal::get('debug-sql');
			if (is_array($dataSql)) {
				$strSql = '';
				foreach ($dataSql as $rs){
					$strSql.= '<sqlrow>';
					$strSql.= '<query>'.$rs['sql'].'</query>';
					$strSql.= '<time>'.($rs['time_end']-$rs['time_begin']).'</time>';
					$strSql.= '</sqlrow>'."\n";
				}
				$xml.= '<sql>'.$strSql.'</sql>';
			}
		}
		return $xml;
	}
}