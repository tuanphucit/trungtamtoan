<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class CgsLang{
	private $__lang = array();
	
	/**
	 * return lang
	 * @param string $name
	 */
	public function lang($name=''){
		$out = isset($this->__lang[$name]) 
					? $this->__lang[$name]
					: 'lang.'.$name;
		
		if (CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_LANG')){
			$_path = Page::get('current_tpl_dir').'|'.Page::get('current_tpl_file');
			$_rel = $_path.'|'.$name;
			$out = '<span class="debug-lang" rel="'.$_rel.'">'.$out.'</span>';
		}
		return $out;
	}
	
	/**
	 * add lang
	 */
	public function addLang(){
		$_lang = Page::getLang(Page::get('current_tpl_file'));
		if (!empty($_lang)){
			$this->__lang = Page::getLang(Page::get('current_tpl_file'));
			return $this->__lang;
		}
		
		// lang public all modules
		if (file_exists(CGS_LANG_PATH . 'lang.php')){
			require CGS_LANG_PATH . 'lang.php';
		}
		
		// lang public current module
		if (file_exists(CGS_LANG_PATH . Page::get('current_tpl_dir') . 'langs.php')){
			require CGS_LANG_PATH . Page::get('current_tpl_dir') . 'langs.php';
		}
		
		// current lang
		$file = CGS_LANG_PATH . Page::get('current_tpl_dir') . Page::get('current_tpl_file') . '.php';

		if (file_exists($file)){
			require_once $file;
			if (isset($lang) && is_array($lang)){
				$this->__lang = $lang;
				
				Page::pushLang(Page::get('current_tpl_file'), $lang);
			}
		}
		
		return $this->__lang;
	}
}