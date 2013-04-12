<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
class Skin {
	protected $classname = "Skin";
	
	/* if set, echo assignments */
	protected $debug = false;
	
	/* $file[handle] = "filename"; */
	protected $file = array ();
	
	/* relative filenames are relative to this pathname */
	protected $root = "";
	
	/* $varkeys[key] = "key"; $varvals[key] = "value"; */
	protected $varkeys = array ();
	protected $varvals = array ();
	
	
	protected $mods = array();
	protected $blocks = array();
	
	protected $is_error = false;
	/***************************************************************************/
	/* public: Constructor.
   * root:     template directory.
   * unknowns: how to handle unknown variables.
   */
	function Skin($root = ".") {
		$this->set_root ( $root );
	}
	
	function print_var(){
		var_dump($this->mods);
		var_dump($this->blocks);
	}
	
	/* public: setroot(pathname $root)
   	 * root:   new template directory.
   	 */
	function set_root($root) {
		if (! is_dir ( $root )) {
			$this->halt ( "set_root: $root is not a directory." );
			return false;
		}
		
		$this->root = $root;
		return true;
	}
	
	
	
	function print_error($ex) {
		$this->is_error = true;
		
		echo '<strong>Exception: </strong>' . $ex->getMessage () . '<br />';
		//  echo nl2br($ex->getTraceAsString());
		$ex_mgs = explode ( "\n", $ex->getTraceAsString () );
		
		foreach ( $ex_mgs as $ex_mg ) {
			if (strpos ( $ex_mg, "Template" ))
				echo $ex_mg . "<br>";
		}
		
		//echo $ex->print_error();
	}
	
	/** public: tpl(array $filelist)
   	 * filelist: array of handle, filename pairs.
   	 *
   	 * public: tpl(string $handle, string $filename)
   	 * handle: handle for a filename,
   	 * filename: name of template file
   	 */	
	function tpl($handle, $filename = "") {
		if (! is_array ( $handle )) {
			if ($filename == "") {
				throw new CgsException ( "tpl: For handle $handle filename is empty." );
			}
			$this->file [$handle] = $this->filename ( $filename );
			$this->loadfile($handle);
		} else {
			
			reset ( $handle );
			while ( list ( $h, $f ) = each ( $handle ) ) {
				$this->file [$h] = $this->filename ( $f );
				$this->loadfile($h);
			}
		}
		
		
		// Lay file lang
		$path_parts = pathinfo($this -> file[$handle]);
		Page::set('current_tpl_dir',$path_parts['dirname']?$path_parts['dirname'].'/':'');
		Page::set('current_tpl_file',$path_parts['filename']);
	}
	
	/**
	 * set block of template
	 */
	function block($parent, $handle, $dataBlock=array()){
		if (!isset($this -> mods[$parent])){
			$this->loadfile ( $parent );
		}
		$strBlock = $this->mods[$parent];
		$reg = "/<!--\s+BEGIN $handle\s+-->(.*)\s*<!--\s+END $handle\s+-->/sm";
		preg_match_all ( $reg, $strBlock, $m );
		$str = preg_replace ( $reg, "{|" . $handle . "|}", $strBlock );

		if (!isset($m[1][0])) {
			throw new CgsException ( "block: unable to load $handle." );
		}
		$this->mods[$parent] = $str;
		$this->blocks[$handle] = $m[1][0];
		$this->assign($handle, '');
		
		////////////
		if (!empty($dataBlock)){
			foreach ($dataBlock as $key => $val){
				$this->assign($handle.'.key', $key);
				$this->assign($handle.'.val', $val);
				$this->add_block($handle);
			}
		}
	}
	
	/**
	 * replace block to template
	 */
	function add_block($handle){
		if (!isset($this->blocks[$handle])) {
			throw new CgsException ( "Block: unable to load $handle." );
		}
		
		$block = $this->blocks[$handle];
		$block = preg_replace ( $this->varkeys, $this->varvals, $block );
		$block_value = $this->get_var($handle).$block;
		$this->assign($handle, $block_value);
		return $block_value;
	}
	
	/**
	 * return block html
	 */
	function get_block($handle){
		if (!isset($this->blocks[$handle])) {
			throw new CgsException ( "block: unable to load $handle." );
		}
		
		$block = $this->blocks[$handle];
		$block = preg_replace ( $this->varkeys, $this->varvals, $block );
		return $block;
	}
	
	
	
	/** public: assign(array $values)
   	 * values: array of variable name, value pairs.
   	 *
   	 * public: assign(string $varname, string $value)
   	 * varname: name of a variable that is to be defined
   	 * value:   value of that variable
   	 */
	function assign($varname="", $value = "") {
		if (! is_array ( $varname )) {
			if (! empty ( $varname ))
			$this->varkeys [$varname] = '/' . $this->varname ( $varname ) . '/';
			$this->varvals [$varname] = $value;
		}
	}
	
	/**
	 * Đặt giá trị cho các biến theo tên và giá trị tương ứng với $var( [key]=>[value] ) của mảng truyền vào
	 * @param $var
	 */
	function assigns($var=array()){
		if (! is_array($var) || empty ( $var )) {
			if ($this->debug)
				print "scalar: set *$var*<br>\n";
		} else {
			while ( list ( $k, $v ) = each ( $var ) ) {
				$this->assign($k, $v);
			}
		}
	}
	
	/**
	 * Thay thế tất cả các biến hiện tại vào nội dung template
	 * @param $handle
	 */
	function output($handle) {
		if (!isset($this->mods[$handle])) {
			throw new CgsException ( "Module: unable to load $handle." );
		}
		
		// path
		$_path = Page::get('current_tpl_dir').'|'.Page::get('current_tpl_file');
		// Set lang
		$langs = Page::getLang(Page::get('current_tpl_file'));

		foreach ($langs as $_lang_key => $_lang_val){
			$this->varkeys ['lang.'.$_lang_key] = '/' . $this->varname ( 'lang.'.$_lang_key ) . '/';
			$this->varkeys ['_lang.'.$_lang_key] = '/' . $this->varname ( '_lang.'.$_lang_key ) . '/';
			
			if (CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_LANG')){
				$_rel = $_path.'|'.$_lang_key;
				$this->varvals ['lang.'.$_lang_key] = '<span class="debug-lang" rel="'.$_rel.'">'.$_lang_val.'</span>';
				$this->varvals ['_lang.'.$_lang_key] = $_lang_val;
			} else {
				$this->varvals ['lang.'.$_lang_key] = $_lang_val;
				$this->varvals ['_lang.'.$_lang_key] = $_lang_val;
			}
		}
		
		$this -> mods[$handle] = preg_replace ( $this->varkeys, $this->varvals, $this -> mods[$handle] );
		
		$lang_count = 0;
		$this -> mods[$handle] = $this->preg_lang($this -> mods[$handle], $lang_count);
		
		$this->vreset();
		return $this -> mods[$handle];
	}
	
	/**
	 * Hiển thị nội dung templates
	 */
	function dispatch($handle){
		if (!isset($this->mods[$handle])) {
			throw new CgsException ( "Show module: unable to load $handle." );
		}
		return $this -> mods[$handle];
	}
	
	/**
	 */
	function get_vars() {
		reset ( $this->varkeys );
		while ( list ( $k, $v ) = each ( $this->varkeys ) ) {
			$result [$k] = $this->varvals [$k];
		}
		
		return $result;
	}
	
	/** public: get_var(string varname)
   	 * varname: name of variable.
   	 *
  	 * public: get_var(array varname)
   	 * varname: array of variable names
   	 */
	function get_var($varname) {
		if (! is_array ( $varname )) {
			return $this->varvals [$varname];
		} else {
			reset ( $varname );
			while ( list ( $k, $v ) = each ( $varname ) ) {
				$result [$k] = $this->varvals [$k];
			}
			
			return $result;
		}
	}
	
	
	/***************************************************************************/
	/** private: filename($filename)
   	 * filename: name to be completed.
   	 */
	function filename($filename) {
		if (! file_exists ( $this->root . "/" . CGS_TPL_PATH . $filename )) {
			throw new CgsException ( "File $filename does not exist." );
		}
		return $filename;
	}
	
	/** private: varname($varname)
   	 * varname: name of a replacement variable to be protected.
   	 */
	function varname($varname) {
		return preg_quote ( "{|" . $varname . "|}" );
	}
	
	/** private: loadfile(string $handle)
   	 * handle:  load file defined by handle, if it is not loaded yet.
   	 */
	function loadfile($handle) {
		if (! isset ( $this->file [$handle] )) {
			throw new CgsException ( "loadfile: $handle is not a valid handle." );
			return false;
		}
		$filename = CGS_TPL_PATH . $this->file [$handle];
		
		$str = implode ( "", @file ( $filename ) );
		if (empty ( $str )) {
			throw new CgsException ( "loadfile: While loading $handle, $filename does not exist or is empty." );
			return false;
		}
		$this->mods[$handle] = $str;
		return $str;
	}
	
	/**
	 * Reset giá trị các biến sau khi thực hiện xong đọc template
	 */
	function vreset() {
		$this->varkeys = array ();
		$this->varvals = array ();
		$this->blocks = array ();
		$this->is_error = false;
	}
	
	function preg_lang($s,&$count){
		$_path = Page::get('current_tpl_dir').'|'.Page::get('current_tpl_file');
		if (CgsGlobal::getSetting('DEBUG_ENABLE') && CgsGlobal::getSetting('DEBUG_LANG')){
			$content = preg_replace(
					"/\{\|lang\.([A-z_]+)([a-zA-Z0-9_])*+\|\}/",
					'<span class="debug-lang" rel="'.$_path.'|$1'.'">lang.$1</span>',
					$s,-1,$count);
		} else {
			$content = preg_replace(
					"/\{\|lang\.([A-z_]+)([a-zA-Z0-9_])*+\|\}/",
					'lang.$1',
					$s,-1,$count);
		}
		return $content;
	}
}
?>