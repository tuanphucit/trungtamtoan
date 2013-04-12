<?php
defined('IN_CGS') or die('Restricted Access');
require_once CGS_LIB_PATH.'crawls/crawlbase.php';

class InfoEducation extends CrawlBase {
	public $base_url = 'http://giaoducthoidai.vn/';	
	public function InfoEducation(){
		
	}
	//get url of University
	function getArticleLink() {
		$crawl = $this->fetch ( $this->base_url.'/channel/2741/' );
		$arrayLink = array();
		if ($crawl) {
			$dom = $this->htmlToDOM ( $crawl );
			$divs = $this->getElementsByClass($dom,'div',"item");
			$i = 0;
			foreach($divs as $div){
				$as = $div->getElementsByTagName('a');
				foreach($as as $a){
					$arrayLink[] = $a->getAttribute('href');
					$i++;
					if($i == 5){
						break;
					}					
				}
				if($i == 5){
						break;
					}
			}		
		}	
		return ($arrayLink);
	}
	
	function getNewArticle(){
		$extensions = $this->getArticleLink();
		
		$arrayData = array();
		foreach($extensions as $extension){
			$crawl = $this->fetch ( $this->base_url.$extension);
			$arrayDiv = array();
			$data = array();
			if ($crawl) {
				$div0 = '';
				$dom = $this->htmlToDOM ( $crawl );
				$div0 = $dom->getElementById('detail');
				
				$title = $dom->getElementById("detail-title");			
				$title0 = ($this->getInnerHTML($title));

				$content0 = $dom->getElementById("detail-content");					
				
				$ps = $content0->getElementsByTagName('p');
				$p0 = "";
				foreach ( $ps as $p ) {
					   $p0 = $p;
					   break;
				}
				$introGoc = $this->getInnerHTML($p0);
				$introduction = "<i>(Nguồn giaoducthoidai.vn)</i> ".str_replace(array('<strong>','</strong>'),array('',''),$introGoc);
				$imgs = $content0->getElementsByTagName('img');
				//$content0->removeChild($p0);
				$allImg = array();			
				foreach ($imgs as $img){	
					$imageLink = "http://gdtd.vn/".$img->getAttribute('src');
					$dir= CgsFunc::createThumbs($imageLink,CGS_IMAGES_DATA."imageForArticle",400);
					$allImg[] = $dir;
					$img->setAttribute('src',$dir);	
				}				
						
				$content = ($this->getInnerHTML($content0));
				$content = str_replace($introGoc,'',$content);
				$headImage = $allImg[0];
				$data = array('subject'=>$title0, 'headImage'=>$headImage, 'content'=> $content, 'introduction'=>$introduction);	
			}	
		$arrayData[] = $data;
		}
		return $arrayData;
	}
	
	public function getListUniversity(){
		$urlUniversity= 'http://thi.moet.gov.vn/?page=1.7&script=truong';
		$un = $this->fetch ($urlUniversity);
		$un = str_replace('#bgcolor','bgcolor',$un);
		$university = array();
		if($un){
			$dom = $this->htmlToDOM ( $un );
				$trs = $dom->getElementsByTagName ( 'tr' );
			foreach ( $trs as $tr ) {
				$color= $tr->getAttribute('bgcolor');	
   				if($color == '#F4FAFF' || $color == 'FFFFFF'){
   					$thisTR = $tr;
   					$tds = $thisTR->getElementsByTagName ('td');
   					$i = 0;
   					$code = '';
   					$name = '';
   					foreach ( $tds as $td ) {
   						
   						if($i == 1){
   							$temp = trim($td->nodeValue);
   							$arrayTemp = explode(' ',$temp);
   							$code = $arrayTemp[1];
   						}  
   						if($i == 2){
   							$name = trim($td->nodeValue);
   						} 
   						$university[] = array('code'=>$code,'name'=>$name);  
   						$i++;
					}
   				}	
			}
		}
		return $university;
	}
}
