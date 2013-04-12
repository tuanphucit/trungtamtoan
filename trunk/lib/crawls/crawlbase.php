<?php
defined('IN_CGS') or die('Restricted Access');
require_once CGS_LIB_PATH.'crawls/SimpleFileCache.php';
class CrawlBase {
	public $cache = true;
	public $cache_time = 60;
	
	public $delay = 0; // in second
	

	function fetch($url) {
		$id = md5 ( $url );
		
		if ($this->cache)
			$data = SimpleFileCache::get ( $id );
		
		if (! $data) {
			$data = $this->curl_get ( $url );
			
			if ($this->delay)
				sleep ( $this->delay );
			SimpleFileCache::add ( $id, $data, $this->cache_time );
		}
		
		return $data;
	}
	
	function htmlToDOM($html) {
		$dom = new domDocument ();		
		$dom->loadHTML ( $html );		
		return $dom;
	}
	
	function getElementsByClass($dom, $tagName, $classNames) {
		$result = array ();
		$els = $dom->getElementsByTagName ( $tagName );
		foreach ( $els as $el ) {
			if (($el->getAttribute ( 'class' ) == $classNames || in_array ( $el->getAttribute ( 'class' ), $classNames )) && ! $el->hasAttribute ( 'id' ))
				$result [] = $el;
		}
		return $result;
	}
	
	function getInnerHTML($node) {
		$innerHTML = '';
		$children = $node->childNodes;
		foreach ( $children as $child ) {
			$innerHTML .= $child->ownerDocument->saveXML ( $child );
		}
		return $innerHTML;
	}
	
	function removeByTagName(&$node, $tagName) {
		$els = $node->getElementsByTagName ( $tagName );
		while ( $els->length > 0 ) {
			$node->removeChild ( $els->item ( 0 ) );
			$els = $node->getElementsByTagName ( $tagName );
		}
	}
	
	function curl_get($url) {   
		$userAgent = $this->getUserAgent();
		$defaults = array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_TIMEOUT => 12,
			CURLOPT_COOKIEJAR => CGS_ROOT_PATH  . 'data' . DS . 'cookie' . DS . md5($userAgent) . '.txt',
			CURLOPT_COOKIEFILE => CGS_ROOT_PATH. 'data' . DS . 'cookie' . DS . md5($userAgent) . '.txt'
		);
		
		$ch = curl_init();
		curl_setopt_array($ch, $defaults);
		if( ! $result = curl_exec($ch)) {
			trigger_error(curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}
	
	function getUserAgent () {	
		$aryAgent = array( 1 => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
					   2 => 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)',
					   3 => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)',
					   4 => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)',
					   7 => 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)',
					   8 => 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/5.0)',
					   9 => 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)',
					   10 => 'Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)');
	
		return $aryAgent[array_rand($aryAgent, 1)];
	}
	
	function strip_selected_tags($str, $tags = "", $stripContent = true) {
	preg_match_all ( "/<([^>]+)>/i", $tags, $allTags, PREG_PATTERN_ORDER );
	foreach ( $allTags [1] as $tag ) {
		$replace = "%(<$tag.*?>)(.*?)(<\/$tag.*?>)%is";
		$replace2 = "%(<$tag.*?>)%is";
		//echo $replace;
		if ($stripContent) {
			$str = preg_replace ( $replace, '', $str );
			$str = preg_replace ( $replace2, '', $str );
		}
		$str = preg_replace ( $replace, '${2}', $str );
		$str = preg_replace ( $replace2, '${2}', $str );
	}
	return $str;
}
}
?>
