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
class MCdownload extends CgsModules {
	function __construct() {
	}

	function execute() {
		$name = Page :: getRequest('name', 'str', NULL, 'GET');
		$link = CGS_DOCUMENT_PATH .$name;
		header( "Content-Disposition: attachment; filename=".$link);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header( "Content-Description: File Transfer");
		@readfile($link) OR die("<html><body OnLoad='javascript: alert('Unable to read file!');history.back();' bgcolor='#F0F0F0'>Unable to read file!</body></html>");
		exit;					
		$html = $this->output();
		return $html;
	}
}