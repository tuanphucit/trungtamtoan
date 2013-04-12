<?php
defined('IN_CGS') or die('Restricted Access');

require_once CGS_LIB_PATH.'crawls/crawlbase.php';

class Mark extends CrawlBase {
	
	function getMark($url) {
		
		$html = $this->fetch ( $url );
		
		if (strtolower ( $html ) == "couldn't connect to host") {
			return $html;
		}
		if ($html) {
			$dom = $this->htmlToDOM ( $html );
			$tds = $dom->getElementsByTagName ( 'td' );
			$tdDiem = '';
			foreach ( $tds as $td ) {
				$color= $td->getAttribute('bgcolor');				
       				if($color == "#B9DCFF")
       					$tdDiem = $td;
       				if($tdDiem != ''){
       					break;
       				}	
			}
		}
		return $content =  $this->getInnerHTML($tdDiem);
	}
}
?>
