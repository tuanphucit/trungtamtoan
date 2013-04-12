<?php
class CgsException extends Exception {
	protected $cause;
	
	function __construct($p1, $p2 = null) {
		
		$cause = null;
		
		if ($p2 !== null) {
			$msg = $p1;
			$cause = $p2;
		} else {
			if ($p1 instanceof Exception) {
				$msg = "";
				$cause = $p1;
			} else {
				$msg = $p1;
			}
		}
		
		parent::__construct ( $msg );
		
		if ($cause !== null) {
			$this->cause = $cause;
			$this->message .= " [wrapped: " . $cause->getMessage () . "]";
		}
	}
	
	/**
	 * Get Cause
	 *
	 */
	public function getCause() {
		return $this->cause;
	}
	
	function print_error(){
		require_once CGS_SYSTEM_PATH.'system.skin.php';
		$Skin = new Skin();
		$Skin -> tpl('systemError','debug/system.error.htm');
		$Skin -> block('systemError','BlockList');
		$content = '';
		foreach ( $this->getTrace() as $i => $ex ) { 
			$args = '';
			foreach ($ex['args'] as $item){
				$args.= ",'".$item."'";
			}
			$Skin -> assign('file', $ex['file']);
			$Skin -> assign('line', $ex['line']);
			$Skin -> assign('func', $ex['class'].$ex['type'].$ex['function'].'('.substr($args,1).')');
			$Skin -> add_block('BlockList');
		}
		$Skin -> assign('idErr', md5(microtime().$args));
		$Skin -> assign('msg', get_class($this) . " '{$this->message}' <br/>in <b>{$this->file}({$this->line})</b>");
		return $Skin -> output('systemError');
		
		//echo CgsGlobal::printDebug();
		//die();
	}
	
	public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                . "{$this->getTraceAsString()}";
    }
	
	/***************************************************************************/
	function loadfile($handle){
		try {
			if (! file_exists( $handle )) {
				throw new Exception ( "Loadfile: $handle is not a valid handle." );
				return false;
			}
			$filename = $this->filename ( $handle );
			
			$str = implode ( "", @file ( $filename ) );
			if (empty ( $str )) {
				throw new Exception ( "Loadfile: While loading $handle, $filename does not exist or is empty." );
				return false;
			}
			return $str;
			
		} catch ( Exception $ex ) {
			echo nl2br($ex->getTraceAsString());
		}
	}
	/***************************************************************************/
	/** private: filename($filename)
   	 * filename: name to be completed.
   	 */
	function filename($filename) {
		try {
			if (substr ( $filename, 0, 1 ) != "/") {
				$filename = "./" . $filename;
			}
			
			if (! file_exists ( $filename )) {
				throw new Exception ( "filename: file $filename does not exist." );
				$this->halt ( "filename: file $filename does not exist." );
			
			}
			return $filename;
		} catch ( Exception $ex ) {
			echo nl2br($ex->getTraceAsString());
		}
	}
	
	function print_error_nice(){
		Page :: goLink(null, 'notgood', 'mc_web');
		return;
	}
}