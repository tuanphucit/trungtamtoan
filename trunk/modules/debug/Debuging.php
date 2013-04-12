<?php
/**
 * Quảng cáo thương hiệu
 * @author longhoangvnn
 *
 */
class Debuging {
	function __construct(){
		
	}
	
	function execute(){
		Page::reg('js', 'webskins/skins/platform/js/jquery-1.4.2.min.js');
		Page::reg('css', 'webskins/skins/debug/styles/system-debug.css');
		Page::reg('js', 'webskins/skins/debug/js/debug.js','footer');
		skn() -> tpl('Debuging','webskins/templates/debug/debuging.htm');
		
		$debug_err = '';
		foreach (get_included_files() as $inc){
			$debug_err.= '<li>'.$inc.'</li>';
		}
		skn()->assign('debug_err', $debug_err);
		
		//---------------------
		$debug_sql = '';
		foreach (get_included_files() as $inc){
			$debug_sql.= '<li>'.$inc.'</li>';
		}
		skn()->assign('debug_sql', $debug_sql);
		
		//-----------------------
		$debug_var = '';
		foreach (get_included_files() as $inc){
			$debug_var.= '<li>'.$inc.'</li>';
		}
		skn()->assign('debug_var', $debug_var);
		
		//------------------
		$debug_inc = '';
		foreach (get_included_files() as $inc){
			$debug_inc.= '<li>'.$inc.'</li>';
		}
		skn()->assign('debug_inc', $debug_inc);
		return skn() -> output('Debuging');
	}
}