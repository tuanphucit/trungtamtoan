<?php
/**
 * @filename	system.page.php
 * @since		Created on Oct 4, 2010
 * @package		liblary
 * @subpackage	kernel
 * @author		longhoangvnn
 * @author		longhoangvnn@gmail.com
 * @copyright	Copyright &copy; 2007, CGP
 * Description: Lien quan den Page
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class Page {
	// Luu tru cac bien duoc REQUEST tren PAGE
  	private static $_param = array();
  	
  	// Luu tru cac bien duoc assign trong module
  	private static $_assign = array();
  	
  	private static $config = array();
  	private static $header = array();
  	private static $footer = array();
  	private static $currentPath = null;
  	private static $currentPathMod = null;
  	private static $currentPathTpl = null;
  	private static $__langs = array();
  	
  	private static $_MOD_PATH;	// system/
  	private static $_MOD_FILE;	// SystemSide
  	
  	private static $_TPL_PATH;	// system/
  	private static $_TPL_FILE;	// SystemSide

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
  		if (isset(self::$config[$name]) AND is_array(self::$config[$name])){
  			array_push(self::$config[$name], $value);
  		} else {
  			self::$config[$name] = array();
  			array_push(self::$config[$name], $value);
  		}
  	}
  	
  	/**
  	 * @desc Dang ky cac file css/js vao PAGE
  	 * @param string $property = css/js
  	 * @param string $path real Path file
  	 * @param string $position vi tri header/footer
  	 * @param string $ext Phan mo rong
  	 * @return String <link stylesheet... /> OR <script javascript... /> 
  	 */
  	public static function reg($property='js', $path='', $position='header', $ext=''){
  		if ($property != 'css' && $property != 'js') return;
  		if (!file_exists($path)) return;
  		if ($position != 'header' && $position != 'footer') return;
  		
  		$path = self::filterPath($path);
  		
  		if ($property == 'css')
  			$str = '<link rel="stylesheet" type="text/css" href="'.$path.'" charset="utf-8" '.$ext.'/>';
  		else
  			$str = '<script type="text/javascript" src="'.$path.'" charset="utf-8" '.$ext.'></script>';
  		
  		if ($position == 'header' && !in_array($path, self::$header))
  			self::$header[] = $str;
  		if ($position == 'footer' && !in_array($path, self::$footer))
  			self::$footer[] = $str;
  	}
  	
  	
  	/**
  	 * @return array $header
  	 */
  	public static function getHeader(){
  		return self::$header;
  	}
  	/**
  	 * @return array $footer
  	 */
	public static function getFooter(){
  		return self::$footer;
  	}
  	/**
  	 * @return string $header html
  	 */
	public static function getHeaderStr(){
  		$str = '';
  		foreach (self::$header as $rs){
  			$str.= $rs."\n";
  		}
  		return $str;
  	}
  	/**
  	 * @return string $footer html
  	 */
	public static function getFooterStr(){
  		$str = '';
  		foreach (self::$footer as $rs){
  			$str.= $rs."\n";
  		}
  		return $str;
  	}
  	/**
  	 * @desc set header (title,description,keyword) on PAGE
  	 * @param string $title
  	 * @param string $description
  	 * @param string $keyword
  	 */
  	public static function header($title='',$description='', $keyword=''){
  		if ($title) {
  			self::set('header-title', $title);
  		} else if(!self::get('header-title')){
  			self::set('header-title', DEFAULT_TITLE);
  		}
  		
  		if ($description){
  			self::set('header-description', $description);
  		}
  		
  		if ($keyword){
  			self::set('header-keyword', $keyword);
  		}
  	}
  	
  	/**
  	 * @desc get path current module action
  	 */
  	public static function pathMod(){
  		return self::$currentPathMod;
  	}
  	
  	/**
  	 * @desc get path current module template
  	 */
  	public static function pathTpl(){
  		return self::$currentPathTpl;
  	}
  	
  	/**
  	 * @desc set path modules info
  	 * @param string $path
  	 */
  	public static function setPath($path=null){
  		self::$currentPath = $path;
  		self::$currentPathMod = CGS_MODULES_PATH . self::$currentPath;
  		//self::$currentPathTpl = CGS_TPL_PATH . self::$currentPath;
  		self::$currentPathTpl = self::$currentPath;
  	}
  	
  	/**
  	 * get Path of Module
  	 */
  	public static function getPath() {
  		return self::$currentPath;
  	}
  	
  	/**
  	 * @desc set path of modules action
  	 * @param string $path
  	 */
	public static function setPathMod($path=null){
  		self::$currentPathMod = CGS_MODULES_PATH . $path;
  	}
  	
  	/**
  	 * @desc set path of modules template
  	 * @param string $path
  	 */
	public static function setPathTpl($path=null){
  		self::$currentPathTpl = CGS_TPL_PATH . $path;
  	}
  	
  	///////////////////////
  	// Languages
	public static function pushLang($name=null, $value=NULL){
  		if (!is_array(self::$__langs)){
  			self::$__langs = array();
  		}
  		
  		self::$__langs[$name] = $value;
  	}
  	
  	public static function getLang($name=null){
  		if (isset(self::$__langs[$name])) return self::$__langs[$name];
  		
  		return array();
  	}
  	
  	public static function addLang() {
  		
  	}
  	
  	
  	////////////////////////////////////
  	/**
  	 * Register Other Plugin
  	 */

  	/**
  	 * @desc input plugin formValidator.2.2 in system
  	 * @desc using in validate form
  	 */
  	public static function regValidateForm(){
  		self::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		self::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi.js','footer');
  		self::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		self::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
  	}
	/**
  	 * @desc input plugin formValidator.2.2 in system
  	 * @desc using in validate form
  	 */
  	public static function regColorpicker(){
  		self::reg('css',CGS_WEBSKINS_PATH.'plugins/colorpicker/css/colorpicker.css','header');
  		//self::reg('css',CGS_WEBSKINS_PATH.'plugins/colorpicker/css/layout.css','header','media="screen"');
  		self::reg('js',CGS_WEBSKINS_PATH.'plugins/colorpicker/js/colorpicker.js','footer');
  		//self::reg('js',CGS_WEBSKINS_PATH.'plugins/colorpicker/js/eye.js','footer');
  		//self::reg('js',CGS_WEBSKINS_PATH.'plugins/colorpicker/js/utils.js','footer');
  		//self::reg('js',CGS_WEBSKINS_PATH.'plugins/colorpicker/js/layout.js','footer');
  	}
  	
  	/**
  	 * @desc Goto link url of system CGS
  	 * @param array $param
  	 * @param string $page
  	 * @param string $portal
  	 */
	public static function link($param=array(),$page=null,$portal=null){
  		if (empty($portal)){
  			$portal = Page::getRequest('portal','str','main');
  		}
  		if (empty($page)){
  			$page = Page::getRequest('page','str','index');
  		}
  		
  		// Setup link
  		$link = CGS_URL;
  		
  		// Get Filename
  		$root_filename = pathinfo($_SERVER["PHP_SELF"], PATHINFO_FILENAME) ;
  		
  		if (CGS_URL_REWRITE && file_exists(CGS_ROOT_PATH . '.htaccess') && CgsGlobal::getSetting('REWRITE_URL')) {
  			// Neu bat chuc nang rewrite URL
  			if ($root_filename == 'debug') {
  				$link.= 'debug/';
  			}
  			$link.= $portal.'/'.$page;
  			
	  		$str = '';
	  		if (is_array($param) && !empty($param)){
	  			foreach($param as $key=>$val){
	  				$str.= '/'.$key.'/'.$val;
	  			}
	  		}
  			$link.= $str;
  			if (defined('CGS_URL_EXTENTION')){
  				$link.= CGS_URL_EXTENTION;
  			}
  		} else {
  			// Neu khong bat chuc nang rewrite URL
  			if ($root_filename == 'debug') {
  				$link.= 'debug.php';
  			}
  			$link.= '?portal='.$portal.'&page='.$page;
  			
	  		$str = '';
	  		if (is_array($param) && !empty($param)){
	  			foreach($param as $key=>$val){
	  				$str.= '&'.$key.'='.$val;
	  			}
	  		}
  			$link.= $str;
  		}
  		
  		return $link;
  	}
  	
  	/**
  	 * @desc Go URL
  	 * @param string $url ex: http://cgs.vn/
  	 */
  	public static function goUrl($url=''){
		Header("Location: ".$url);
		ob_end_flush();
		exit();
  	}
  	
  	/**
  	 * @desc Go Link
  	 * @param array $param
  	 * @param string $page
  	 * @param string $portal
  	 */
	public static function goLink($param=array(), $page=null, $portal=null){
		$url = Page::link($param,$page,$portal);
		Header("Location: ".$url);
		ob_end_flush();
		exit();
  	}
  	
  	/**
  	 * @desc Filter path if rewrite url
  	 * @param unknown_type $path
  	 */
  	private static function filterPath($path=''){
  		/*if (!CGS_URL_REWRITE || !file_exists(CGS_ROOT_PATH . '.htaccess')) return $path;
  		
  		$stringFilter = array(
  			'modules/'	=> 'stamod/',
  			'webskins/'	=> 'staweb/',
  		);
  		$path = strtr($path, $stringFilter);*/
  		
  		return CGS_URL.$path;
  	}
  	////////////////////////////////////////////////////////////////////////////////
  	// REQUEST DATA
  	/**
  	 * Lay du lieu tu form, url, cookie, session,...
  	 * @param $name
  	 * @param $validate
  	 * @param $def
  	 * @param $method: GET,POST,REQUEST,FILE,COOKIE,SESSION,OBJECT,SERVER,GLOBAL
  	 */
  	public static function getRequest($name='', $validate='def', $def=NULL, $method='REQUEST'){
  		if ($name=='') return NULL;
  		if ($method == 'COOKIE' || $method == 'SESSION') {$name = md5(CGS_URL).'.'.$name;}
  		
  		if (isset(self::$_param[$method][$name])) return self::$_param[$method][$name];
		if (isset(self::$_param[$method]['CGS.'.$name])) return self::$_param[$method]['CGS.'.$name];
		
		switch ($method){
			case 'GET':
				$value = isset($_GET[$name])?$_GET[$name]:NULL;
				break;
			case 'POST':
				$value = isset($_POST[$name])?$_POST[$name]:NULL;
				break;
			case 'REQUEST':
				$value = isset($_REQUEST[$name])?$_REQUEST[$name]:NULL;
				break;
			case 'FILE':
				$value = isset($_FILES[$name])?$_FILES[$name]:NULL;
				break;
			case 'COOKIE':
				$value = isset($_COOKIE[$name])?$_COOKIE[$name]:NULL;
				break;
			case 'SESSION':
				$value = isset($_SESSION[$name])?$_SESSION[$name]:NULL;
				break;
			case 'OBJECT':
				if (isset(self::$_param[$method][$name]) && is_object(self::$_param[$method][$name])) {
					$value = self::$_param[$method][$name];
				} elseif (class_exists($name)) {
					$value = new $name();
				} else {
					die('Khong ton tai object '.$name.'()');
				}
				return $value;
				break;
			case 'SERVER':
				$value = isset($_SERVER[$name])?$_SERVER[$name]:NULL;
				break;
			case 'GLOBAL':
				$value = isset($_GLOBAL[$name])?$_GLOBAL[$name]:NULL;
				break;
			default :
				$value = isset($_REQUEST[$name])?$_REQUEST[$name]:NULL;
				break;
		}
		
		if (is_null($value)) return $def;
		
		if ($validate == 'int'){
			(int) $value;
		}
		if ($validate == 'str'){
			(string) $value;
		}
		if ($validate == 'def'){
			$value;
		}
		if ($validate == 'obj'){
			if (isset(self::$_param[$method][$name]) && is_object(self::$_param[$method][$name])) {
				$value = self::$_param[$method][$name];
			} elseif (class_exists($name)) {
				$value = new $name();
			} else {
				die('Khong ton tai object '.$name.'()');
			}
		}
		
		self::setRequest($name, $value, $method);
		return $value;
  	}
  	
	/**
	 * @desc Tra ve data of method
	 * @param string $method : POST, GET, REQUEST, COOKIE, SESSION
	 */
	public static function getRequestAll($method=null){
		if (!$method) return;
		switch ($method){
			case 'POST':
				self::$_param = $_POST;
				break;
			case 'GET':
				self::$_param = $_GET;
				break;
			case 'REQUEST':
				self::$_param = $_REQUEST;
				break;
			case 'FILE':
				//self::$_param = $_FILE;
				break;
			case 'COOKIE':
				self::$_param = $_COOKIE;
				break;
			case 'SESSION':
				self::$_param = $_SESSION;
				break;
			case 'SERVER':
				self::$_param = $_SERVER;
				break;
			default :
				self::$_param = $_REQUEST;
				break;
		}
		
		return self::$_param;
	}
	
	/**
	 * @desc Them data vao $_param
	 * @param unknown_type $method
	 */
	public function pushRequest($method=null){
		if (!$method) return self::$_param;
		switch ($method){
			case 'POST':
				self::$_param =  $_POST + self::$_param;
				break;
			case 'GET':
				self::$_param = $_GET + self::$_param;
				break;
			case 'REQUEST':
				self::$_param = $_REQUEST + self::$_param;
				break;
			case 'FILE':
				//self::$_param = $_FILE + self::$_param;
				break;
			case 'COOKIE':
				self::$_param = $_COOKIE + self::$_param;
				break;
			case 'SESSION':
				self::$_param = $_SESSION + self::$_param;
				break;
			case 'SERVER':
				self::$_param = $_SERVER + self::$_param;
				break;
			default :
				self::$_param = $_REQUEST + self::$_param;
				break;
		}
		
		return self::$_param;
	}
	
	/**
	 * @desc Set value for Parameter
	 * @param string $name
	 * @param nothing $value
	 */
	public static function setRequest ($name='', $value=NULL, $method='REQUEST'){
		if ($method == 'COOKIE' || $method == 'SESSION') {$name = md5(CGS_URL).'.'.$name;}
		
		switch ($method){
			case 'POST':
				$_POST[$name] = $value;
				break;
			case 'GET':
				$_GET[$name] = $value;
				break;
			case 'REQUEST':
				$_REQUEST[$name] = $value;
				break;
			case 'FILE':
				$_FILE[$name] = $value;
				break;
			case 'COOKIE':
				$_COOKIE[$name] = $value;
				break;
			case 'SESSION':
				$_SESSION[$name] = $value;
				break;
			case 'SERVER':
				$_SERVER[$name] = $value;
				break;
			default :
				$_REQUEST[$name] = $value;
				break;
		}
    	return (self::$_param[$method][$name] = $value);
  	}
  	
  	/**
  	 * @return parameter in PAGE
  	 */
  	public static function getParamRequest(){
  		return self::$_param;
  	}
  	
  	/**
  	 * @desc Clear Parameter
  	 */
  	public static function clearRequestAll(){
  		self::$_param = array();
  	}
  	
  	public static function clearRequest($name='', $method='REQUEST') {
  		if ($method == 'COOKIE' || $method == 'SESSION') {$name = md5(CGS_URL).'.'.$name;}
  		if (isset(self::$_param[$method][$name])) {
  			unset(self::$_param[$method][$name]);
  		}
  		switch ($method){
			case 'POST':
				if (isset($_POST[$name])) unset($_POST[$name]);
				break;
			case 'GET':
				if (isset($_GET[$name])) unset($_GET[$name]);
				break;
			case 'REQUEST':
				if (isset($_REQUEST[$name])) unset($_REQUEST[$name]);
				break;
			case 'FILE':
				if (isset($_FILE[$name])) unset($_FILE[$name]);
				break;
			case 'COOKIE':
				if (isset($_COOKIE[$name])) unset($_COOKIE[$name]);
				break;
			case 'SESSION':
				if (isset($_SESSION[$name])) unset($_SESSION[$name]);
				break;
			case 'SERVER':
				if (isset($_SERVER[$name])) unset($_SERVER[$name]);
				break;
			default :
				break;
		}
  	}
  	
  	/**
  	 * @desc Filter request data
  	 * @desc Protects better diverse attempts of Cross-Site Scripting attacks
  	 * @desc Security INPUT
  	 */
  	public static function filterRequest(){
  		if (isset($_GET['___param___'])){
  			$___params___ = explode('/',$_GET['___param___']);
  			unset($_GET['___param___']);
  			unset($_REQUEST['___param___']);
  			
  			$size = count($___params___);
  			$param_ext = array();
  			for ($i=0; $i<$size; $i++) {
  				if ($___params___[$i] == '') {
  					break;
  				}
  				
  				if (isset($___params___[$i+1])) {
  					$param_ext[$___params___[$i]] = $___params___[++$i];
  				} else {
  					$param_ext[$___params___[$i]] = '';
  					break;
  				}
  			}
  			$_GET += $param_ext;
  			$_REQUEST += $param_ext;
  		}
  		
  		// Cross-Site Scripting attack defense 
		// Lets now sanitize the GET vars
	    if (count($_GET) > 0) {
        	foreach ($_GET as $secvalue) {
        		if (!is_array($secvalue)) {
					if ((eregi("<[^>]*script.*\"?[^>]*>", $secvalue)) ||
							(eregi(".*[[:space:]](or|and)[[:space:]].*(=|like).*", $secvalue)) ||
							(eregi("<[^>]*object.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*iframe.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*applet.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*meta.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*style.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*form.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*window.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*alert.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*img.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*document.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*cookie.*\"?[^>]*>", $secvalue)) ||
							(eregi("\"", $secvalue))) {
							Header("Location: index.php");
					}
				}
			}
		}
	
		// Lets now sanitize the POST vars
		if ( count($_POST) > 0) {
			foreach ($_POST as $secvalue) {
				if (!is_array($secvalue)) {
					if ((eregi("<[^>]*script.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*object.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*iframe.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*applet.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*window.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*alert.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*document.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*cookie.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*meta.*\"?[^>]*>", $secvalue))
							) {
							Header("Location: index.php");
					}
				}
			}
		}
	
		//Lets now sanitize the COOKIE vars
		if ( count($_COOKIE) > 0) {
			foreach ($_COOKIE as $secvalue) {
				if (!is_array($secvalue)) {
					if ((eregi("<[^>]*script.*\"?[^>]*>", $secvalue)) ||
							(eregi(".*[[:space:]](or|and)[[:space:]].*(=|like).*", $secvalue)) ||
							(eregi("<[^>]*object.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*iframe.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*applet.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*meta.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*style.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*form.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*window.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*alert.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*document.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*cookie.*\"?[^>]*>", $secvalue)) ||
							(eregi("<[^>]*img.*\"?[^>]*>", $secvalue))
							) {
							Header("Location: index.php");
					}
				}
			}
		}
  	}
  	
  	////////////////////////////////////////
  	// ASSIGN
  	/**
  	 * @desc Set assign in PAGE
  	 * @param $name
  	 * @param $value
  	 */
  	public static function setAssign($name='', $value=NULL){
  		if ($name == '') return;
  		if (CGS_DEBUG && CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_VAR')){
	  		$mod = self::get('current_mod_file');
	  		self::$_assign[$mod][$name] = $value;
  		}
  	}
  	
  	/**
  	 * @desc Set array assign in PAGE
  	 * @param $abc
  	 */
	public static function setAssigns($abc=array()){
		if (!is_array($abc)) return;
		if (CGS_DEBUG && CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_VAR')){
	  		foreach ($abc as $name => $value) {
	  			self::setAssign($name, $value);
	  		}
		}
  	}
  	
  	/**
  	 * @return $_assign parameter;
  	 */
  	public static function getAssign() {
  		return self::$_assign;
  	}
  	
  	// reset page
  	public static function reset() {
  		self::$_param = array();
  		self::$__langs = array();
  		self::$_MOD_PATH = '';
  		self::$_MOD_FILE = '';
  		self::$_TPL_PATH = '';
  		self::$_TPL_FILE = '';
  	}
  	
  	// begin load page
  	public static function autoLoadPage($path, $file) {
  		self::$_MOD_PATH = $path.DS;
  		self::$_MOD_FILE = $file;
  		self::$_TPL_PATH = $path.DS;
  		self::$_TPL_FILE = $file;
  	}
  	
  	
  	public static function getModPath() {
  		return self::$_MOD_PATH;
  	}
	public static function getModFile() {
  		return self::$_MOD_FILE;
  	}
	public static function getTplPath() {
  		return self::$_TPL_PATH;
  	}
	public static function getTplFile() {
  		return self::$_TPL_FILE;
  	}
  	
  	public static function displayImage($url="", $imageAlt= "", $height = "30", $width = "30"){
  		return '<img border="0" src="'.$url.'" alt="'.$imageAlt.'" width="'.$width.'" height="'.$height.'" />';
  	}
  	
  	public static function isLogIn(){
  		return Page :: getRequest('IS_LOG_IN', 'def', false, 'SESSION');
  		
  	}
}
?>