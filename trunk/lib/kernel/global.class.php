<?php
defined('IN_CGS') or die ('Restricted Access');
/**
 * @filename	Config.class.php
 * @since		Created on Oct 4, 2007
 * @package		fwk
 * @subpackage	lib/cgp/config
 * @author		longhoangvnn
 * @author		longhoangvnn@gmail.com
 * @copyright	Copyright &copy; 2007, CGP
 * @version		CodeGenProject: $Id: cgsConfig.class.php,v 1.1 2009/04/27 11:46:29 longhoangvnn Exp $
 * Description:
 */
class CgsGlobal {
	const G_SESSION = 'session';
	const G_GLOBAL = 'global';
	const G_DEBUG = 'debug';
	const G_COOKIE = 'cookie';
	const G_CONFIG = 'config';
	const G_USER_TYPE = 'user_type';
	
  	private static $config = array();

	/**
	 * Retrieve a config parameter.
	 *
	 * @param string A config parameter name.
	 * @param mixed  A default config parameter value.
	 *
	 * @return mixed A config parameter value, if the config parameter exists, otherwise null.
	 */
	public static function get ($name, $default = null){
    	return isset(self::$config[$name]) ? self::$config[$name] : $default;
	}

  /**
   * Set a config parameter.
   *
   * If a config parameter with the name already exists the value will be overridden.
   *
   * @param string A config parameter name.
   * @param mixed  A config parameter value.
   *
   * @return void
   */
  	public static function set ($name, $value){
    	self::$config[$name] = $value;
  	}

  /**
   * Set an array of config parameters.
   *
   * If an existing config parameter name matches any of the keys in the supplied
   * array, the associated value will be overridden.
   *
   * @param array An associative array of config parameters and their associated values.
   *
   * @return void
   */
  	public static function add ($parameters = array()){
    	self::$config = array_merge(self::$config, $parameters);
  	}

  /**
   * Retrieve all configuration parameters.
   *
   * @return array An associative array of configuration parameters.
   */
  	public function getAll (){
    	return self::$config;
  	}

  /**
   * Clear all current config parameters.
   *
   * @return void
   */
  	public static function clear (){
    	self::$config = null;
    	self::$config = array();
  	}
  	
  	/**
   * Set a config parameter.
   *
   * If a config parameter with the name already exists the value will be overridden.
   *
   * @param string A config parameter name.
   * @param mixed  A config parameter value.
   *
   * @return void
   */
  	public static function push($name=NULL, $value=NULL){
  		if (isset(self::$config[$name]) && is_array(self::$config[$name])){
  			array_push(self::$config[$name], $value);
  		} else {
  			self::$config[$name] = array();
  			array_push(self::$config[$name], $value);
  		}
  	}
  	
  	/////////////////////////////////////////////////////////
/**
	 * Retrieve a config parameter.
	 *
	 * @param string A config parameter name.
	 * @param mixed  A default config parameter value.
	 *
	 * @return mixed A config parameter value, if the config parameter exists, otherwise null.
	 */
	public static function getSession ($name, $default = null){
    	return isset(self::$config[self::G_SESSION][$name]) ? self::$config[self::G_SESSION][$name] : $default;
	}

  /**
   * Set a config parameter.
   *
   * If a config parameter with the name already exists the value will be overridden.
   *
   * @param string A config parameter name.
   * @param mixed  A config parameter value.
   *
   * @return void
   */
  	public static function setSession ($name, $value){
    	self::$config[self::G_SESSION][$name] = $value;
  	}

  /**
   * Set an array of config parameters.
   *
   * If an existing config parameter name matches any of the keys in the supplied
   * array, the associated value will be overridden.
   *
   * @param array An associative array of config parameters and their associated values.
   *
   * @return void
   */
  	public static function addSession ($parameters = array()){
    	self::$config[self::G_SESSION] = array_merge(self::$config[self::G_SESSION], $parameters);
  	}

  /**
   * Retrieve all configuration parameters.
   *
   * @return array An associative array of configuration parameters.
   */
  	public function getAllSession (){
    	return self::$config[self::G_SESSION];
  	}

  /**
   * Clear all current config parameters.
   *
   * @return void
   */
  	public static function clearSession (){
    	self::$config[self::G_SESSION] = array();
  	}
  	
  	/**
   * Set a config parameter.
   *
   * If a config parameter with the name already exists the value will be overridden.
   *
   * @param string A config parameter name.
   * @param mixed  A config parameter value.
   *
   * @return void
   */
  	public static function pushSession($name=NULL, $value=NULL){
  		if (isset(self::$config[self::G_SESSION][$name]) && is_array(self::$config[self::G_SESSION][$name])){
  			array_push(self::$config[self::G_SESSION][$name], $value);
  		} else {
  			self::$config[self::G_SESSION][$name] = array();
  			array_push(self::$config[self::G_SESSION][$name], $value);
  		}
  	}
  	
  	/////////////////////////////////////////////
  	/**
  	 * @desc set Config connection database
  	 */
  	public static function setConnDB() {
  		if (file_exists(CGS_CONFIG . 'db.config.php')) {
  			$config = require_once CGS_CONFIG . 'db.config.php';
  			if (isset($config['database'])) {
  				$conn_db =  $config['database'];
  			} else {
  				die ('<span style="color:red;">Config database is FALSE !!!</span>');
  				return false;
  			}
  			
  			if (isset($config['default']) && isset($conn_db[$config['default']])) {
  				$conn_db = array('default' => $conn_db[$config['default']]) + $conn_db;
  			}
  			
  			// set connection
  			foreach ($conn_db as $key => $conn) {
  				$conn_db[$key] = array('connection' => $key) + $conn;
  			}
  			self::set('conn_db', $conn_db);
  			return true;
  		} else {
  			die ('<span style="color:red;">Not found file Config database!</span>');
  			return false;
  		}
  	}
  	
  	/**
  	 * @desc get Connection DataBase
  	 * @param string $name Name DB config
  	 */
  	public static function getConnDB($name='default') {
  		if ($name=='' || !is_string($name)) $name = 'default';
  		
  		$conn_db = self::get('conn_db');
  		if (isset($conn_db[$name])) {
  			return $conn_db[$name];
  		} else {
	  		try {
				throw new CgsException('Không tồn tại connection '.$name);
			} catch (CgsException $ex){
				$ex->print_error();
				die();
			}
  		}
  	}
  	
  	public static function getConnAllDB() {
  		return self::get('conn_db');
  	}
  	////////////////////////////////////////////////////
  	
  	/**
  	 * print html include files
  	 */
  	public static function printInc(){
  		$header = 'INCLUDES FILE';
  		$vars = get_included_files();
  		return self::getHtml($header,$vars);
  	}
  	
  	public static function printGeneral(){
  		$portal = self::get('debug-portal');
  		$page = self::get('debug-page');
  		$layout = self::get('debug-layout');
  		$header = 'GENERAL Information';
  		$vars = array('PORTAL: '. $portal, 'PAGE: '. $page, 'LAYOUT PATH: '. (isset($layout[0])?CGS_LAYOUT_PATH.$layout[0]:null));
  		return self::getHtml($header,$vars);
  	}
  	
  	/**
	 * Print SQL query
  	 */
	public static function printSql(){
		require_once CGS_SYSTEM_PATH.'highlightSql.php';
		$hlSqlObj = new highlightSQL();
					
  		$vars = self::get('debug-sql');
  		if (!is_array($vars) || empty($vars)) return ;
  		
  		$header = 'SQL Query (<b>'.sizeof($vars).'</b>)';
  		$html = '<span class="debug-header1">'.strtoupper($header).'</span>'."\n<hr/>";
  		
  		$html .= "<ol>";
  		foreach ($vars as $rs){
			$html .= '<li>'.'<span style="font-size:0.9em">&raquo; ' . $hlSqlObj->highlight($rs['sql']).'<br /> &nbsp;&nbsp;&nbsp;Time: <strong>' . ($rs['time_end']-$rs['time_begin']) . '</strong></li>';
		}
		$html .= "</ol>\n";
		
  		return nl2br($html);
  	}

  	/**
  	 * Print to screen modules flugin 
  	 */
	public static function printLayout(){
  		$mod_flugin = self::get('debug-mod_flugin');
  		$vars = array();
  		if (is_array($mod_flugin)){
	  		foreach ($mod_flugin as $key => $val){
	  			$rs = $key . ':';
	  			if (!empty($val)){
	  				$rs.= '<ul>';
	  				foreach ($val as $k=>$v){
	  					$rs.= '<li>' . $v . '</li>';
	  				}
	  				$rs.= '</ul>';
	  			}
	  			$vars[] = $rs;
	  		}
  		}
  		$header = 'Layout position flugin';
  		return self::getHtml($header,$vars);
  	}
  	
  	private static function printVar(){
  		$vars = Page::getAssign();
  		if (!is_array($vars) || empty($vars)) return ;
  		
  		$count = 0;
  		$html  = '';
  		$html .= "<ol>";
  		foreach ($vars as $mod=>$rs){
  			$html.= '<li style="clear:both;">';
  			$html.= '	<div style="font-weight:bold;color:red;">'.$mod.' ( '.count($rs).' )</div>';
  			$html.= '	<div style="border: solid #c3c3c3 0px; padding-left: 10px;height:auto;">';
  			foreach ($rs as $param=>$value){
	  			$html.= '	<ul style="clear:both;width:100%;height:auto;padding-left:5px;">';
	  			$html.= '		<li style="width:150px; float:left; font-weight:bold;">'.$param.'</li>';
	  			$html.= '		<li style="font-weight:bold; list-style-type: none;height:auto;color:blue;"><div style="width:100%; text-alight: left;">= ';
	  			$html.= 			htmlspecialchars(self::getPropertyVar($value), ENT_QUOTES);
				$html.= '		</div></li>';
	  			$html.= '	</ul>';
	  			$count++;
  			}
  			$html.= '	</div>';
  			$html.= '</li>';
		}
		$html .= "</ol>\n";
		
		$header = 'VARS (<b>'.$count.'</b>)';
		$header = '<span class="debug-header1">'.strtoupper($header).'</span>'."\n<hr/>";
		
		return $header.$html;
  	}
  	
  	private static function printRequest(){
  		$vars = Page::getParamRequest();
  		if (!is_array($vars) || empty($vars)) return ;
  		
  		$count = 0;
  		$html  = '';
  		$html .= "<ol>";
  		foreach ($vars as $method=>$rs){
			foreach ($rs as $param=>$value){
				$html.= '<li>';
				$html.= '	<ul style="color:#000000;height:auto;padding-left:5px;">';
				$html.= '		<li style="width:160px; float:left; list-style-type: none;">_'.strtoupper($method).'[ "<span style="color:red;">'.$param.'</span>" ]</li>';
				$html.= '		<li style="list-style-type: none; color:blue;"> = ';
				$html.= 			nl2br(htmlspecialchars(self::getPropertyVar($value), ENT_QUOTES));
				$html.= '		</li>';
				$html.= '	</ul>';
				$html.= '</li>';
				$count++;
			}
		}
		$html .= "</ol>\n";
		
		$header = 'REQUEST (<b>'.$count.'</b>)';
		$header = '<span class="debug-header1">'.strtoupper($header).'</span>'."\n<hr/>";
		
		return $header.$html;
  	}
  	
  	private static function printError(){
  		$vars = cgsHandling::getHandling();
  		if (!is_array($vars) || empty($vars)) return ;
  		
  		$header = 'ERRORS (<b>'.sizeof($vars).'</b>)';
  		$html = '<span class="debug-header1">'.strtoupper($header).'</span>'."\n<hr/>";
  		
  		$html .= "<ol>";
  		foreach ($vars as $rs){
			$html.= '<li><div style="color:red;padding-left:10px;">';
			$html.= '<span style="font-weight:bold;margin-right:10px;">'.$rs['type'].'('.$rs['code'].')</span>';
			$html.= '<span style="margin-right:10px;">{ '.$rs['message'].' }</span>';
			$html.= '<span style="margin-right:10px;">'.$rs['file'].' (<b>'.$rs['line'].'</b>)</span>';
			$html.= '</div></li>';
		}
		$html .= "</ol>\n";
		return $html;
  	}

  	private static function getHtml($header='',$vars=array()){
  		if (!is_array($vars) || empty($vars)) return ;
  		
  		$header .= ' (<b>'.sizeof($vars).'</b>)';
  		$html = '<span class="debug-header1">'.strtoupper($header).'</span>'."\n<hr/>";
  		
  		$html .= "<ol>";
  		foreach ($vars as $rs){
			$html .= '<li>'.$rs."</li>";
		}
		$html .= "</ol>\n";
		return nl2br($html);
  	}
  	
  	public static function printDebug(){
  		$setting = self::get('config_setting');
  		if (CGS_DEBUG && self::getSetting('DEBUG_ENABLE')){
	  		echo '<div id="system-debug" style="text-align:left;">';
	  		if (self::getSetting('DEBUG_ERROR'))
	  			echo self::printError();
	  		if (self::getSetting('DEBUG_GENERAL_INFORMATION'))
	  			echo self::printGeneral();
	  		if (self::getSetting('DEBUG_REQUEST'))
	  			echo self::printRequest();
	  		if (self::getSetting('DEBUG_LAYOUT_POSITION_FLUGIN'))
	  			echo self::printLayout();
	  		if (self::getSetting('DEBUG_SQL_QUERY'))
	  			echo self::printSql();
	  		if (self::getSetting('DEBUG_VAR'))
	  			echo self::printVar();
	  		if (self::getSetting('DEBUG_INCLUDES_FILE'))
	  			echo self::printInc();
	  		
	  		echo '</div>';
	  	}
	  	
  	}
  	
  	/**
  	 * use global config setting
  	 * @param string $name
  	 */
  	public static function getSetting($name=null){
  		if (is_null($name)) return null;
  		
  		$name = strtoupper($name);
  		if (isset(self::$config['config_setting'][$name])){
  			return self::$config['config_setting'][$name];
  		}
  		return null;
  	}
  	/**
  	 * use global config setting
  	 * @param string $name
  	 * @param $value
  	 */
	public static function setSetting($name=null, $value=null){
  		if (!isset(self::$config['config_setting']) || !is_array(self::$config['system_setting'])){
  			self::$config['config_setting'] = array();
  		}
  		$name = strtoupper($name);
  		self::$config['config_setting'][$name] = $value;
  		return self::$config['config_setting'][$name];
  	}
  	
  	/**
  	 * Output value detail
  	 * @param nothing $value
  	 */
  	private static function getPropertyVar($value){
  		return var_export($value, true);
  	}
  	
  	//////////////////////////////////
  	// Config UserSystem
  	public static function getSystemPermistion() {
  		
  	}
}
?>