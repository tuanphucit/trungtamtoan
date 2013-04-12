<?php
/**
 * 
 */

defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class CgsLayout {
	public $root;
	public $content = '';
	
	function CgsLayout ($root='.') {
		$this->root = $root;
	}
	
	function layout($handle){
		$this->loadfile(CGS_LAYOUT_PATH.$handle);
		$content = $this->content;
		$reg_ex = "|\[\[\|(.*)\|\]\]|U";
		preg_match_all($reg_ex,$content,$s);
		
		return $s;
	}
	
	function output($listMod=array(), $layouts=array()){
		$data_keys = array();
		$data_vals = array();
		
		$is_portal_system = (CgsGlobal::get('portal')=='system');
		
		$mod_flugin = array();
		foreach ($layouts as $current){
			$_tmp = '';
			// Nếu không nhúng trang nào vào layout
			if (isset($listMod[$current])){
				$mod_flugin[$current] = $listMod[$current];
				
				foreach ($listMod[$current] as $filePath){
					try {
						if (!file_exists(CGS_MODULES_PATH.$filePath))
							throw new CgsException ( "Loadfile: $filePath is not found." );
						require_once CGS_MODULES_PATH.$filePath;
					} catch ( CgsException $ex ) {
						$_tmp.= $ex->print_error();
					}
					
					$modPath = pathinfo($filePath,PATHINFO_DIRNAME);
					$modName = pathinfo($filePath,PATHINFO_FILENAME);
					
					try {
						if (!class_exists($modName)) {
							throw new CgsException ( "Module name: $modName is not found." );
						}
						Page::reset();
						Page::autoLoadPage($modPath, $modName);
						
						$objMod = new $modName();
						$objMod->autoLoadDefaultTpl();	// load template when begin load action
						
						Page::setPath(dirname($filePath).DS);
						Page::set('current_mod_dir',$modPath);
						Page::set('current_mod_file',$modName);
						
						if (CgsGlobal::getSetting('HINT_BLOCK_ENABLE')){
							if (!$is_portal_system || CgsGlobal::getSetting('HINT_SYSTEM_MODULE_ENABLE')){
								$border_color = 'border-color:'.(CgsGlobal::getSetting('HINT_BLOCK_COLOR') ? '#'. CgsGlobal::getSetting('HINT_BLOCK_COLOR') : 'blue').' !important;';
								$border_style = CgsGlobal::getSetting('HINT_BLOCK_STYLE') ? ('border-style:'.CgsGlobal::getSetting('HINT_BLOCK_STYLE').' !important;') : '';
								$border_width = CgsGlobal::getSetting('HINT_BLOCK_WIDTH') ? ('border-width:'.CgsGlobal::getSetting('HINT_BLOCK_WIDTH').' !important;') : 'border-width:1px !important;';
								$_tmp.= '<div class="debug-block-module" style="'.$border_width.$border_color.$border_style.'"><span class="debug-module-title" title="'.$filePath.'">'.$modName.'</span>'.$objMod->execute().'</div>';
							} else {
								$_tmp.= $objMod->execute();
							}
						} else {
							$_tmp.= $objMod->execute();
						}
					} catch ( CgsException $ex ) {
						$_tmp.= $ex->print_error();
					}
					
					
				}
			} else {
				$mod_flugin[$current] = NULL;
			}
			
			if (CgsGlobal::getSetting('HINT_LAYOUT_ENABLE') && (!$is_portal_system || CgsGlobal::getSetting('HINT_SYSTEM_MODULE_ENABLE'))){
				$border_color = 'border-color:'.(CgsGlobal::getSetting('HINT_LAYOUT_COLOR') ? '#'. CgsGlobal::getSetting('HINT_LAYOUT_COLOR') : 'blue').' !important;';
				$border_style = CgsGlobal::getSetting('HINT_LAYOUT_STYLE') ? ('border-style:'.CgsGlobal::getSetting('HINT_LAYOUT_STYLE').' !important;') : '';
				$border_width = CgsGlobal::getSetting('HINT_LAYOUT_WIDTH') ? ('border-width:'.CgsGlobal::getSetting('HINT_LAYOUT_WIDTH').' !important;') : 'border-width:1px !important;';
				$_tmp = '<div class="debug-block" style="'.$border_width.$border_color.$border_style.'">'.$_tmp.'</div>';
			}
			
			// 
			$data_keys[$current] = '/'.preg_quote ( "[[|" . $current . "|]]" ).'/';
			$data_vals[$current] = $_tmp;
		}
		
		
		$html = preg_replace($data_keys, $data_vals, $this->content);
		//Nếu trong môi trường debug thì in ra các thông số hệ thống
		if (CGS_DEBUG){
			CgsGlobal::set('debug-mod_flugin',$mod_flugin);
		}
		
		$html = $this->buildHeader() . $html . $this->buildFooter();
		$this->vreset();
		
		return $html;
	}
	
	function loadfile($handle='$handle'){
		try {
			if (! file_exists( $handle )) {
				throw new CgsException ( "Loadfile: $handle is not a valid handle." );
				return false;
			}
			$filename = $this->filename ( $handle );
			
			$str = implode ( "", @file ( $filename ) );
			if (empty ( $str )) {
				throw new CgsException ( "Loadfile: While loading $handle, $filename does not exist or is empty." );
				return false;
			}
			$this -> content = $str;
			return $str;
			
		} catch ( CgsException $ex ) {
			//$this->print_err_exception ( $ex );
			$ex->print_error();
		}
	}
	
	/***************************************************************************/
	/** private: filename($filename)
   	 * filename: name to be completed.
   	 */
	function filename($filename) {
		try {
			if (substr ( $filename, 0, 1 ) != "/") {
				$filename = $this->root . "/" . $filename;
			}
			
			if (! file_exists ( $filename )) {
				throw new CgsException ( "filename: file $filename does not exist." );
				$this->halt ( "filename: file $filename does not exist." );
			
			}
			return $filename;
		} catch ( CgsException $ex ) {
			//$this->print_err_exception ( $ex );
			$ex->print_error();
		}
	}
	
	function buildHeader ($meta=array(),$css=array(),$js=array()){
		if (CGS_DEBUG){
			Page::reg('css','webskins/skins/debug/styles/system-debug.css','header');
			Page::reg('js','webskins/skins/debug/js/debug.js','footer');
		}
		
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n".
				'<html xmlns="http://www.w3.org/1999/xhtml"><head>'."\n".
				'<title>'.Page::get('header-title').'</title>'."\n".
				'<meta http-equiv="Content-Language" content="en-us">'."\n".
				'<meta property="fb:app_id" content="{471449872880599}">'."\n".
				'<meta property="fb:admins" content="{dd854c8f15792f578c77bf93fc48e4fa}"/>'."\n".

				'<meta http-equiv=Content-Type content="text/html; charset=UTF-8">'."\n".
				'<meta http-equiv="cache-control" content="no-cache">'."\n".
				'<meta http-equiv="imagetoolbar" content="no">'."\n".
				'<meta name="googlebot" content="index,follow,noodp" />'."\n".
				'<meta name="robots" content="all, index, follow">'."\n".
				'<meta name="msnbot" content="all,index,follow" />'."\n".
				'<meta name="author" content="">'."\n".
				'<meta name="description" content="'.Page::get('header-description').'">'."\n".
				'<meta name="keywords" content="'.Page::get('header-keyword').'">'."\n";
		$html.= Page::getHeaderStr();
		$html.= '<link rel="shortcut icon" href="webskins/skins/system/images/favicon.ico" />'."\n";
		$html.= '</head><body>'."\n";
		
		return $html;
	}
	
	function buildFooter (){
		$html = Page::getFooterStr();
		$html.= '</body></html>';
		return $html."\n\n";
	}
	
	/**
	 * 
	 * @param unknown_type $ex
	 */
	function print_err_exception($ex) {
		echo '<strong>Exception: </strong>' . $ex->getMessage () . '<br />';
		echo nl2br($ex->getTraceAsString());
		$ex_mgs = explode ( "\n", $ex->getTraceAsString () );
		foreach ( $ex_mgs as $ex_mg ) {
			if (strpos ( $ex_mg, "Template" ))
				echo $ex_mg . "<br>";
		}
	}
	
	/**
	 * Reset giá trị các biến sau khi thực hiện xong đọc template
	 */
	function vreset() {
		$this->content = '';
	}
	
}