<?php
defined('IN_CGS') or die('Restricted Access');


class SimpleFileCache {
	public static function get($id, $check_only = false) {
		//$file_name = CACHE_FILE_PATH . $id . CACHE_FILE_EXTENSION;
		$file_name = self::get_file_name($id);	
		if (file_exists ( $file_name )) {
			$modified = filemtime ( $file_name );
			$data = unserialize ( file_get_contents ( $file_name ) );
			if ((! $data ['livetime'] || (time () - $modified) <= $data ['livetime'] * 60) && $data ['data']) {
				if ($check_only)
					return true;
				else
					return $data ['data'];
			} else {
				@unlink ( $file_name );
			}
		}
		return false;
	}
	
	public static function delete($id) {
		$file_name = CACHE_FILE_PATH . $id . CACHE_FILE_EXTENSION;
		@unlink ( $file_name );
	}
	
	public static function add($id, $value, $live_time_in_minutes = null) {
		//$file_name = CACHE_FILE_PATH . $id . CACHE_FILE_EXTENSION;
		$file_name = self::get_file_name($id);
		$data = array ('livetime' => $live_time_in_minutes, 'data' => $value );
		return file_put_contents ( $file_name, serialize ( $data ) );
	}
	
	public static function get_file_name($id) {
		$sub = ord(substr($id, -1)) % 3;
		if (($pos = strpos($id, DS))!==false) {
			$file_name = CACHE_FILE_PATH . substr($id, 0, $pos) . DS . $sub . substr($id, $pos) . CACHE_FILE_EXTENSION;
		} else {            
			$file_name = CACHE_FILE_PATH . $sub . DS . $id . CACHE_FILE_EXTENSION;
		}
		return $file_name;
	}
	
	public static function empty_folder($tmp_path) {
		if (! is_writeable ( $tmp_path ) && is_dir ( $tmp_path )) {
			chmod ( $tmp_path, 0777 );
		}
		$handle = opendir ( $tmp_path );
		while ( $tmp = readdir ( $handle ) ) {
			if ($tmp != '..' && $tmp != '.' && $tmp != '') {
				if (is_writeable ( $tmp_path . DS . $tmp ) && is_file ( $tmp_path . DS . $tmp )) {
					unlink ( $tmp_path . DS . $tmp );
				} elseif (! is_writeable ( $tmp_path . DS . $tmp ) && is_file ( $tmp_path . DS . $tmp )) {
					chmod ( $tmp_path . DS . $tmp, 0666 );
					unlink ( $tmp_path . DS . $tmp );
				}
				
				if (is_writeable ( $tmp_path . DS . $tmp ) && is_dir ( $tmp_path . DS . $tmp )) {
					delete_folder ( $tmp_path . DS . $tmp );
				} elseif (! is_writeable ( $tmp_path . DS . $tmp ) && is_dir ( $tmp_path . DS . $tmp )) {
					chmod ( $tmp_path . DS . $tmp, 0777 );
					delete_folder ( $tmp_path . DS . $tmp );
				}
			}
		}
		
		closedir ( $handle );
	}
}


