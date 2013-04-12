<?php 
/**
 * Write Log
 */
class CgsLog {
	static private $_is_log = true;
	static private $_log_sql = array();
	function __construct() {
		
	}
	
	static function log($fileName, $content) {
		$fileName = $fileName . '.log';
		$handle = fopen(CGS_LOG_PATH . $fileName, 'a');
		$content = '['.date('Y/m/d H:i:s').']['.$_SERVER['REQUEST_URI'] . "]\n" . $content;
		fwrite($handle, $content);
		fclose($handle);
	}
	
	static function pushLogSql($sql='', $time_begin=0, $time_end=0) {
		self::$_log_sql[] = array('sql'=>$sql, 'time_begin'=>$time_begin, 'time_end'=>$time_end);
	}
	
	static function writeLogSql() {
		foreach (self::$_log_sql as $rs) {
			$time = $rs['time_end'] - $rs['time_begin'];
			
			$content = $rs['sql'] . ";\n";
			$content.= "--[" . date('Y/m/d H:i:s', $rs['time_begin']) . ']' . "\n";
			$content.= '--Run time (s): ' . $time . "\n\n";
			
			self::log('SQL_'.date('Y-m-d_H', $rs['time_end']), $content);
		}
	}
}