<?php
require_once CGS_SYSTEM_PATH.'error.profiler.php';
class EDatabase {
	const TYPE_MYSQL = 1;
	const TYPE_MYSQLI = 2;
	const TYPE_PDO = 3;
	const TYPE_OCI = 4;
	
	protected $_log = array ();
	
	/**
	 * Config
	 * mang config
	 *
	 * @var Array
	 */
	protected static $config = array();
	
	/**
	 * Instances
	 * mang cac doi tuong khoi Data Object
	 *
	 * @var Array
	 */
	protected static $instances = array();
	
	/**
	 * Use Transaction
	 *
	 * @var boolean
	 */
	private $_transaction;
	
	protected function __construct() {
		$this->_transaction = isset($config['transaction']) ? (boolean) $config['transaction'] : false;
		if (CGS_DEBUG)
			Profiler::getInstance()->mark('Connection to Database', 'system.database.' . get_class($this));
	}
	
	/**
	 * Log
	 *
	 * @param string $sql
	 * @param float $time
	 * @return void	 
	 */
	public function log($sql, $begin, $end) {
		$time = $end - $begin;
		$this->_log[] = array ('sql' => $sql, 'time' => $time );
		
		$content = $sql . ";\n";
		$content.= "--Start time [" . date('Y/m/d H:i:s', $begin) . ']' . "\n";
		$content.= '--Run time(s): ' . $time . "\n\n";
		
		// Log sql slow
		if (CGS_LOG && CgsGlobal::getSetting('LOG_ENABLE') && CgsGlobal::getSetting('LOG_SQL_SLOW')) {
			$slow_time = ((float)CgsGlobal::getSetting('LOG_SQL_SLOW_TIME') > 0) 
							? (float)CgsGlobal::getSetting('LOG_SQL_SLOW_TIME')
							: CGS_LOG_SLOW_TIME;
			if ($time >= $slow_time) {
				CgsLog::log('SQL_SLOW_'.date('Y-m-d_H', $end), $content);
			}
		}
		
		// Log sql
		if (CGS_LOG && CgsGlobal::getSetting('LOG_ENABLE') && CgsGlobal::getSetting('LOG_SQL')) {
			$sql = strtoupper($sql);
			$is_other = true;
			//VIEW
			if (CgsGlobal::getSetting('LOG_SQL_VIEW') && preg_match('/^(.*)SELECT(.*)FROM(.*)+$/', $sql)) {
				CgsLog::log('SQL_VIEW_'.date('Y-m-d', $end), $content);
				$is_other = false;
			}
			//ADD
			if (CgsGlobal::getSetting('LOG_SQL_ADD') && preg_match('/^(.*)INSERT(.*)INTO(.*)+$/', $sql)) {
				CgsLog::log('SQL_ADD_'.date('Y-m-d', $end), $content);
				$is_other = false;
			}
			//EDIT
			if (CgsGlobal::getSetting('LOG_SQL_EDIT') && (preg_match('/^(.*)UPDATE(.*)SET(.*)+$/', $sql) || preg_match( '/^(.*)REPLACE(.*)INTO(.*)+$/', $sql))) {
				CgsLog::log('SQL_EDIT_'.date('Y-m-d', $end), $content);
				$is_other = false;
			}
			//DELETE
			if (CgsGlobal::getSetting('LOG_SQL_DELETE') && preg_match('/^(.*)DELETE(.*)FROM(.*)+$/', $sql)) {
				CgsLog::log('SQL_DELETE_'.date('Y-m-d', $end), $content);
				$is_other = false;
			}
			//OTHER
			if (CgsGlobal::getSetting('LOG_SQL_OTHER') && $is_other && (
						!preg_match('/^(.*)SELECT(.*)FROM(.*)+$/', $sql) 
						&& !preg_match('/^(.*)INSERT(.*)INTO(.*)+$/', $sql)
						&& !preg_match('/^(.*)UPDATE(.*)SET(.*)+$/', $sql)
						&& !preg_match( '/^(.*)REPLACE(.*)INTO(.*)+$/', $sql)
						&& !preg_match('/^(.*)DELETE(.*)FROM(.*)+$/', $sql)
					)
				) {
				CgsLog::log('SQL_OTHER_'.date('Y-m-d', $end), $content);
			}
		}
	}
	
	/**
	 * Get Log query
	 *
	 * @return Array
	 */
	public function getLog() {
		return $this->_log;
	}
	
	/**
	 * Get Database Object
	 *
	 * @return Array
	 */
	public static function getDBO() {
		return self::$instances;
	}
	
	/**
	 * Get Microtime
	 *
	 * @return float
	 */
	public function getMicrotime() {
		list ( $usec, $sec ) = explode ( ' ', microtime () );
		return (( float ) $usec + ( float ) $sec);
	}
	
	/**
	 * Initialize Configuration
	 * 
	 * @return void
	 */
	public static function initConfig() {
		//self::$config = require_once CGS_CONFIG . 'db.config.php';
	}
	
	/**
	 * Get Database
	 *
	 * @param string $name
	 * @throws SystemException
	 */
	public static function getConnection($name = null) {
		if (sizeof ( self::$config ) === 0) {
			self::initConfig ();
		}
		
		if ($name === null || ! isset ( self::$config ['database'] [$name] )) { // Neu khong chi dinh ro ten hoac ten khong nam trong config thi se load ra doi tuong default
			$name = self::getDefault ();
		}
		
		if (! isset ( self::$config ['database'] [$name] )) { // Neu khong co config nao co ten nhu vay
			throw new CgsException ( 'Config not found!' );
		}
		
		$dsn = self::$config ['database'] [$name] ['username'] . ':' . self::$config ['database'] [$name] ['password'] . '@' . self::$config ['database'] [$name] ['host'];
		
		$object = self::$config ['database'] [$name] ['object'];
		if (! isset ( self::$instances [$dsn] )) {
			require_once dirname ( __FILE__ ) . DS . 'database.' . strtolower ( $object ) . '.php';
			$object = 'E' . $object;
			self::$instances [$dsn] = new $object ( self::$config ['database'] [$name] );
		} else {
			self::$instances [$dsn]->selectDb ( self::$config ['database'] [$name] ['dbname'] );
		}
		
		return self::$instances [$dsn];
	}
	
	public static function getDefault() {
		return self::$config ['default'];
	}
} // End Class Database