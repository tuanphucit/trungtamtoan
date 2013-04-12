<?php


/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPage.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined('IN_CGS') or die('Restricted Access');
class MCboard extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: reg('js', Page :: pathMod() . 'MCboard.js');
		Page::reg('js', CGS_WEBSKINS_PATH.'plugins/TinySlideshow/compressed.js', 'header');
		Page::reg('js', CGS_WEBSKINS_PATH.'plugins/TinySlideshow/script.js', 'header');
		Page::reg('css', CGS_WEBSKINS_PATH.'plugins/TinySlideshow/style.css', 'header');
		$this->assign('CGS_SKIN',CGS_WEBSKINS_PATH.'plugins/TinySlideshow/');					
		$html = $this->output();
		return $html;
	}
}