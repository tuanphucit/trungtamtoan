<?php
/**
 * @desc Connection DataBase
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'database.mysqli.php';
class CgsDatabase {
	protected static $conn=array();
	protected static $config=array();
	private static $Obj;
	private static $_result;
	protected static $is_cache = false;
	protected static $property;
	
	function __construct(){
		//echo 1;
	}
	
	/**
	 * @desc set Property connection
	 * @param $name
	 */
	function setProperty($name=''){
		if ($name == '') return false;
		self::$config = CgsGlobal::getConnDB($name);
		self::$property = $name;
	}
	
	function getConfig() {
		return self::$config;
	}
	
	function query($sql=''){
		if($sql == '')
			throw new CgsException('Không tồn tại câu lệnh sql');
		else {
			$result = self::Obj()->query($sql);
			return $result;
		}
	}
	
	function getLastId(){
		return self::Obj()->insert_id;
	}
	
	static function &Obj() {
		try {
			if (!isset(self::$Obj) || !is_object(self::$Obj)) {
				self::$Obj = new EMySQLi(self::$config);
			}
		} catch (CgsException $ex) {
			if (CGS_DEBUG) {
				echo $ex->print_error ();
				exit();
			} else {
				exit();
			}
		}
		return self::$Obj;
	}
	
	function conn() {
		return self::Obj();
	}
	
	function fetch(){
		return self::Obj()->fetch();
	}
	
	function fetchAll(){
		return self::Obj()->fetchAll();
	}
	
	function insert($table, $data){
		return self::Obj()->insert($table, $data);
	}
	public function insertMulti($table, $datas){
		return self::Obj()->insertMulti($table, $datas);
	}
	
	function update($table, $data, $where){
		return self::Obj()->update($table, $data, $where);
	}
	
	function selectOne($table='',$fields='*',$where=''){
		return self::Obj()->selectOne($table, $fields, $where);
	}
	
	public function select($table, $fields, $where = null, $order = null, $limit = null, $key = ''){
		return self::Obj()->select($table, $fields, $where, $order, $limit, $key);
	}
	
	function delete($table, $where, $limit = null){
		return self::Obj()->delete($table, $where, $limit);
	}
	
	function count($table, $condition, $field){
		return self::Obj()->count($table, $condition,$field);
	}
}