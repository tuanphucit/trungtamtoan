<?php
defined('IN_CGS') or die ('Restricted Access');
/**
 * 
 */
require_once CGS_SYSTEM_PATH.'cgs.database.php';
require_once CGS_SYSTEM_PATH.'cgs.modules.php';
class Cgs {
	private static $portal = NULL;
	private static $page = NULL;
	private static $path = NULL;
	private static $fnc = NULL;
	private static $layout = array();
	private static $listMod = array();
	
	function __construct(){
		self::$portal = Page::getRequest('portal','str',DEFAULT_PORTAL);
		self::$page = Page::getRequest('page','str',DEFAULT_PAGE);
		
		CgsGlobal::set('portal',self::$portal);
		CgsGlobal::set('page',self::$page);
	}
	
	static function dispatch(){
		
		// Nếu là system
		if (self::$portal=='system' && self::print_system() === true) {
			return true;
		} 
		
		$dbObj = new CgsDatabase();
		$dbObj->setProperty('db');
		$rs_portal = $dbObj->selectOne('portal','id,portal_name',"portal_name='".self::$portal."' AND publish_flg='1'");
		try {
			if (empty($rs_portal)){
				throw new CgsException ('Truy cập trái phép hoặc Không tồn tại portal = ['.self::$portal.']');
			} else {
				$rs_page = $dbObj->selectOne('page','id,page_name,layout,modules,portal_id,master_id,title,description,keyword',"page_name='".self::$page."' AND portal_id='{$rs_portal['id']}' AND publish_flg='1'");
				try {
					if (empty($rs_page)){
						throw new CgsException ('Truy cập trái phép hoặc Không tồn tại portal/page = ['.self::$portal.'/'.self::$page.']');
					} else {
						self::$layout[0] = $rs_page['layout'];
					}
				} catch (CgsException $ex ) {
					if (CGS_DEBUG) {
						echo $ex->print_error ();
						exit();
					}
					echo 'Khong ton tai PAGE!';
					exit();
				}
			}
		} catch (CgsException $ex ) {
			if (CGS_DEBUG) {
				echo $ex->print_error ();
				exit();
			}
			echo 'Khong ton tai PORTAL!';
			exit();
		}
		
		
		self::$listMod = json_decode($rs_page['modules'],true);
		
		try {
			$CgsLayout = new CgsLayout();
			if (isset(self::$layout[0]) && ($rs = $CgsLayout->layout(self::$layout[0]))) {
				// Nếu có master page
				if ($rs_page['master_id']>0){
					$rs_master = $dbObj->selectOne('page','id,modules,title,description,keyword',"`id`='".$rs_page['master_id']."'");
					if (isset($rs_master['modules'])){
						$parrentMod = json_decode($rs_master['modules'],true);
						
						// Kế thừa tất cả các module của master page
						self::$listMod = !empty(self::$listMod)
											? array_merge_recursive($parrentMod,self::$listMod)
											: $parrentMod;
											
						// Set header master page if exist
						Page::header($rs_master['title'],$rs_master['description'],$rs_master['keyword']);
					}
				}
				
				// Set header page if exist
				Page::header($rs_page['title'],$rs_page['description'],$rs_page['keyword']);
				
				echo $CgsLayout->output(self::$listMod,$rs[1]);
				self::$layout[1] = $rs[1];
				
			} else {
				throw new CgsException ('Không có layout!');
			}
			
		} catch ( CgsException $ex ) {
			echo $ex->print_error ();
			exit();
		}
		
	}
	
	// Dùng cho ajax
	static function dispatchAjax(){
		self::$path = Page::getRequest('path','str','');
		self::$fnc = Page::getRequest('fnc','str','');
		$full_path = CGS_ROOT_PATH.'modules'.DS.'ajaxs'.DS
						.self::$path.DS.self::$fnc.'.php';
		if (!file_exists($full_path)) {
			die('Function not found!');
		}
		try {
			require_once CGS_SYSTEM_PATH . 'cgs.ajax.process.php';
			require_once $full_path;
			if (!class_exists('AjaxProcess')) {
				die('Process not found!');
			}
			$AjaxProcess = new AjaxProcess();
			$AjaxProcess->execute();
		} catch ( CgsException $ex ) {
			echo $ex->print_error ();
			exit();
		}
		exit();
	}
	
	static function print_system(){
		$page = self::$page;
		
		$config_file = CGS_ROOT_PATH.'modules'.DS.'system'.DS.'config.php';
		if (!file_exists($config_file)) throw new CgsException('Khong ton tai file system');
		require_once $config_file;
		
		global $system_default;
		global $system_page;
		
		if (isset($system_page[$page])){
			// default
			self::$listMod = $system_default['modules'];
			self::$layout[0] = $system_default['layout'];
			self::$listMod = $system_page[$page]['modules'];
			self::$layout[0] = $system_page[$page]['layout'];
		} else {
			// Neu ko tim thay trang defined thi chuyen qua DB
			return FALSE;
		}
		
		try {
			$CgsLayout = new CgsLayout();
			if ($rs = $CgsLayout->layout(self::$layout[0])) {
				echo $CgsLayout->output(self::$listMod,$rs[1]);
				self::$layout[1] = $rs[1];
			} else {
				throw new CgsException ();
			}
			
		} catch ( CgsException $ex ) {
			echo $ex->print_error ();
			exit();
		}
		
		return TRUE;
	}
	
	function __destruct(){
		if (CGS_DEBUG){
			CgsGlobal::set('debug-portal', self::$portal);
			CgsGlobal::set('debug-page', self::$page);
			CgsGlobal::set('debug-layout', self::$layout);
			CgsGlobal::set('debug-listMod', self::$listMod);
			
			echo CgsGlobal::printDebug();
		}
	}
}