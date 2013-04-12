<?php
defined('IN_CGS') or die ('Restricted Access');
/**
 * @desc Module controler of PAGE
 * @author longhoangvnn
 *
 */
class CgsModules {
	protected $_tpl_dir;
	protected $_tpl_file;
	protected $_mod_dir;
	protected $_mod_file;
	private $__lang = array();
	private $_is_tpl = NULL;
	
	function __construct() {
		Page::reg('js', 'webskins/js/jquery-1.6.4.js');
		Page::reg('css', 'webskins/skins/platform/jquery.alerts/jquery.alerts.css');
		Page::reg('js', 'webskins/js/jquery.alerts.js','header');
	}
	
	/**
	 * return lang
	 * @param string $name
	 * @param bool $is_edit: true|false -> debug edit | no edit
	 */
	public function lang($name='',$is_edit=true){
		$out = isset($this->__lang[$name]) 
					? $this->__lang[$name]
					: 'lang.'.$name;
		if (!$is_edit) return $out;
		
		if (CGS_DEBUG && CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_LANG')){
			$_path = Page::get('current_tpl_dir').'|'.Page::get('current_tpl_file');
			$_rel = $_path.'|'.$name;
			$out = '<span class="debug-lang" rel="'.$_rel.'">'.$out.'</span>';
		}
		return $out;
	}
	
	/**
	 * @desc set template path
	 * @param string $path Path file
	 */
	public function tpl($path=null){
		if (!$path) return 'Không tồn tại template';
		
		$this->_mod_dir = Page::get('current_mod_dir');
		$this->_mod_file = Page::get('current_mod_file');
		
		skn() -> tpl($this->_mod_file, $path);
		$this->_is_tpl = $path;
		
		$this->_tpl_dir = Page::get('current_tpl_dir');
		$this->_tpl_file = Page::get('current_tpl_file');
		
		$this->__addLang();
	}
	
	// auto get Tpl
	public function autoLoadDefaultTpl() {
		$file = Page::getTplPath() . Page::getTplFile()	. '.htm';
		if (file_exists(CGS_TPL_PATH . $file)) {
			$this->tpl($file);
		}
	}
	
	/**
	 * @return html current page output
	 */
	public function output(){
		$this->checkTpl();
		return skn()->output($this->_mod_file);
	}
	
	/**
	 * @desc add block in process
	 * @param string $blockName
	 */
	public function block($blockName=''){
		$this->checkTpl();
		skn()->block($this->_mod_file, $blockName);
	}
	
	/**
	 * @desc Kiem tra xem co ton tai Template hay chua
	 * @param $handle
	 */
	function checkTpl() {
		if (is_null($this->_is_tpl)) {
			$tpl = Page::pathTpl().Page::get('current_mod_file').'.htm';
			$this->tpl($tpl);
		}
	}
	
	/**
	 * @desc Add data in Block
	 * @param string $blockName
	 */
	public function add_block($blockName=''){
		$blockValue = skn()->add_block($blockName);
		Page::setAssign($blockName, $blockValue);
	}
	
	/**
	 * @desc Push parameter out Template
	 * @param string $varName
	 * @param nothing $varVal
	 */
	public function assign($varName='',$varVal=null){
		$this->checkTpl();
		skn()->assign($varName, $varVal);
		Page::setAssign($varName, $varVal);
	}
	
	/**
	 * @desc Push parameters out Template
	 * @param array $abc
	 */
	public function assigns($abc=array()){
		skn()->assigns($abc);
		Page::setAssigns($abc);
	}
	
	/**
	 * @desc Get language in PAGE
	 */
	private function __addLang(){
		$_lang = Page::getLang($this->_tpl_file);
		if (!empty($_lang)){
			$this->__lang = Page::getLang($this->_tpl_file);
			return $this->__lang;
		}
		
		// lang public all modules
		if (file_exists(CGS_LANG_PATH . 'lang.php')){
			if (!isset($lang) || !is_array($lang)) $lang = array();
			require CGS_LANG_PATH . 'lang.php';
		}
		
		// lang public current module
		if (file_exists(CGS_LANG_PATH . $this->_tpl_dir . 'langs.php')){
			if (!isset($lang) || !is_array($lang)) $lang = array();
			require CGS_LANG_PATH . $this->_tpl_dir . 'langs.php';
		}
		
		// current lang
		$file = CGS_LANG_PATH . $this->_tpl_dir . $this->_tpl_file . '.php';

		if (file_exists($file)){
			if (!isset($lang) || !is_array($lang)) $lang = array();
			require_once $file;
			
			if (isset($lang) && is_array($lang)){
				$this->__lang = $lang;
				
				Page::pushLang($this->_tpl_file, $lang);
			}
		}
		
		return $this->__lang;
	}
	
	/**
	 * @return current module path
	 */
	public function pathMod($file='', $path=null){
		if ($path != null){
			return CGS_MODULES_PATH . $path . $file;
		}
		
		return Page::pathMod().$file;
	}
	
	/**
	 * @return current template path
	 */
	public function pathTpl($file='', $path=null){
		if ($path != null){
			//return CGS_TPL_PATH . $path . $file;
			return $path . $file;
		}
		
		return Page::pathTpl().$file;
	}
	
	/**
	 *GET current link of page 
	 */
	function curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
}