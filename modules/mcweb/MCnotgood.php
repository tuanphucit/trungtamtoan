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
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class MCnotgood extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){	
		Page::header('Truy cập trái phép');
		$html = $this->output();
		return $html;
	}
}