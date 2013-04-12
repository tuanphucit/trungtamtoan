<?php 
defined('IN_CGS') or die ('Restricted Access');
/**
 * @author longhoangvnn@gmail.com
 * @desc Các function sử dugj chung cho hệ thống
 */

class CgsFunc {
	
	/**
	 * Create new dir
	 * @param string $path
	 */
	static function createDir($path='', $is_create_sub=true, $mod='777', &$msg='') {
		if (file_exists($path)) return true;
		
//		$path = str_replace('/', DS, $path);
//		$path = str_replace('\\', DS, $path);
		if ($is_create_sub !== true) {
			if (@mkdir($path)) {
				@$exec = exec("chmod {$mod} {$path}");
				return true;
			} else {
				return false;
			}
		} else {
			$subs = explode(DS, $path, -1);
			$subpath = implode(DS, $subs);
			if (file_exists($subpath)) {
				if (@mkdir($path)) {
					$msg.= "- Created is folder [{$path}]\n";
					@$exec = exec("chmod {$mod} {$path}");
					if ($exec) {
						$msg.= "&nbsp; <b>chmod {$mod} {$path}</b>: is successfull\n";
					} else {
						$msg.= "&nbsp; <b>chmod {$mod} {$path}</b>: is not successfull\n";
					}
					return true;
				} else {
					return false;
				}
			} else {
				if ( self::createDir($subpath, true, $mod, $msg) ) {
					if (@mkdir($path)) {
						$msg.= "- Created is folder [{$path}]\n";
						@$exec = exec("chmod {$mod} {$path}");
						if ($exec) {
							$msg.= "&nbsp; <b>chmod {$mod} {$path}</b>: is successfull\n";
						} else {
							$msg.= "&nbsp; <b>chmod {$mod} {$path}</b>: is not successfull\n";
						}
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			}
			
		}
		
		//return false;
	}
	
	static function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth){ 
		$source = $pathToImages;    //Source file
		$info = pathinfo($source);	
		$dest = $pathToThumbs.DS.$info["basename"];
		if(!file_exists($dest)){
			$stype =  $info["extension"];
			switch($stype) {
			    case 'gif':
			    $simg = imagecreatefromgif($source);
			    break;
			    case 'JPG':
			    $dest = str_replace('JPG','jpg',$dest);
			    $simg = imagecreatefromjpeg($source);
			    break;
			    case 'jpg':
			    $simg = imagecreatefromjpeg($source);
			    break;
			    case 'png':
			    $simg = imagecreatefrompng($source);
			    break;		   
			}			
			  $width = imagesx( $simg );
		      $height = imagesy( $simg );
		      $new_width = $thumbWidth;
		      $new_height = floor( $height * ( $thumbWidth / $width ) );
		      $tmp_img = imagecreatetruecolor( $new_width, $new_height );
		      imagecopyresampled( $tmp_img, $simg, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
		      imagejpeg( $tmp_img, $dest);		      
		}
		return $dest;
	}
	
	static function passwordGenerator($str='', $LEN=10) {
		$CODE = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		$str = md5($str.md5($LEN));
		$CODE_len = strlen($CODE);
		$str_len = strlen($str);
		
		$total = 0;
		for ($i=0; $i<$str_len; $i++) {
			$total += strpos($CODE, $str{$i});
		}
		
		$result = '';
		$num = 0;
		while ($num < $LEN) {
			$num ++;
			$pos = $total % $CODE_len;
			$result.= $CODE{$pos};
			
			$total = $total + $num * $pos;
		}
		
		return $result;
	}
}