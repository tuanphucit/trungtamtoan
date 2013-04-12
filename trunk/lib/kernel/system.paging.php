<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' ); 
class ClassPaging
{
/**
* @desc  Ham khoi tao
*/
	function __construct()
	{
	}
	/**
	* @desc Ham phan trang
	* @access public
	* @param $total - Tong so ban ghi
	* @param $perPage - So ban ghi tren/1 trang
	* @param $numPageShow - so trang duoc hien thi default = 10
	* @param $page_no param phan trang, default la page_no (nen de la page_no)
	* @param $classCurrent - Class css de phan biet trang hien tai, default = ''
	* @param $classNormal - Class css cho cac trang normal default = ''
	* @param $url_rewrite - link rewrite default = '', cau truc link rewrite nay xem function buildUrlRewrite() cua class_link
	* @return tra ve chuoi phan trang voi cau truc <li><a ...>1</a></li><li><a ...>2></a></li>....<li><a ...>n</a></li>
	*/
	public static function paging($total, $perPage, $arrParram = array(), $numPageShow = 10, $page_name='page_no', $classCurrent = 'active', $classNormal = '', $cond = '')
	{   		 		
		if($arrParram){
			$currentpage = $arrParram[$page_name];
		}
		else{
			$currentpage = Page :: getRequest($page_name,'int',1, 'GET');
		}	
		$content='';
		//tong trang
		$totalpage = ceil($total/$perPage);
		if ($totalpage < 2) { // Return neu chi co 1 trang
			return '';
		}
		//trang hien tai
		$currentpage = round($currentpage);
		if($classCurrent == ''){
			$classCurrent = 'class="paging-active"';
		}else{
		   $classCurrent = 'class="'.$classCurrent.'"';
		}   
		if($classNormal){
			$classNormal = 'class="'.$classNormal.'"';
		}	
		if($currentpage <= 0 || $currentpage > $totalpage){
			$currentpage = 1;
		}
		
		if($currentpage > ($numPageShow/2)){
			$startpage = $currentpage - floor($numPageShow/2);
			if($totalpage - $startpage < $numPageShow)
			{
				$startpage = $totalpage - $numPageShow + 1;
			}
		}
		else{
			$startpage = 1;
		}
		if($startpage < 1)
		{
			$startpage = 1;
		}        
		//Link den trang truoc
		if($currentpage > 1){
			$arrParram[$page_name] = ($currentpage-1).$cond;
			$url =  Page::link($arrParram,null,null);
			$content.= '<li><A HREF = "'.$url.'" >&laquo; Trước</A></li>';
		}
		//Danh sach cac trang        
		if($startpage > 1){
			$arrParram[$page_name] = (1).$cond;
			$url =  Page::link($arrParram,null,null);
			$content.= '<li><a '.$classNormal.' href= "'.$url.' ">1</a></li>';            
		}
		for($i = $startpage; $i <= $startpage + $numPageShow - 1 && $i <= $totalpage; $i++){
			if($i == $currentpage)
			{
				$content.= '<li><a '.$classCurrent.' href="javascript:;">'.$i.'</a></li>';
			}
			else {
				$arrParram[$page_name] = $i.$cond;
				$url =  Page::link($arrParram,null,null);
				$content .= '<li><a '.$classNormal.' href= "'.$url.' ">'.$i.'</a></li>';
			}
		}
		if($i == $totalpage){
			$arrParram[$page_name] = $totalpage.$cond;
			$url =  Page::link($arrParram,null,null);
			$content .= '<li><a '.$classNormal.' href= "'.$url.' ">'.$totalpage.'</a></li>';
		}
		elseif($i < $totalpage)
		{
			$arrParram[$page_name] = $totalpage.$cond;
			$url =  Page::link($arrParram,null,null);
			$content .= '<li>...</li><li><a '.$classNormal.' href= "'.$url.' ">'.$totalpage.'</a></li>';
		}        
		//Trang sau
		if($currentpage < $totalpage){
			$arrParram[$page_name] = ($currentpage+1).$cond;
			$url =  Page::link($arrParram,null,null);
			$content .= '<li><A '.$classNormal.' HREF = "'.$url.'">Sau &raquo;</A></li>';
		}         
		return $content;        
	}
	
	/**
	* @desc Ham phan trang
	* @access public
	* @param $total - Tong so ban ghi
	* @param $perPage - So ban ghi tren/1 trang
	* @param $numPageShow - so trang duoc hien thi default = 10
	* @param $page_no param phan trang, default la page_no (nen de la page_no)
	* @param $classCurrent - Class css de phan biet trang hien tai, default = ''
	* @param $classNormal - Class css cho cac trang normal default = ''
	* @param $url_rewrite - link rewrite default = '', cau truc link rewrite nay xem function buildUrlRewrite() cua class_link
	* @return tra ve chuoi phan trang voi cau truc <li><a ...>1</a></li><li><a ...>2></a></li>....<li><a ...>n</a></li>
	*/
	public static function pagingHistory($total, $perPage, $numPageShow = 10, $page_name='page_no'
										, $classCurrent = '', $classNormal = '', $url_rewrite = '', $cond = '')
	{    
		$content='';
		//tong trang
		$totalpage = ceil($total/$perPage);
		if ($totalpage < 2) { // Return neu chi co 1 trang
			return '';
		}
		//trang hien tai
		$currentpage = Page :: getRequest($page_name,'int',1, 'GET');
		$currentpage = round($currentpage);
		if($classCurrent == '')
			$classCurrent = 'class="pages-active"';
		else
		   $classCurrent = 'class="'.$classCurrent.'"';
		if($classNormal)
			$classNormal = 'class="'.$classNormal.'"';
		if($currentpage <= 0 || $currentpage > $totalpage)
		{
			$currentpage = 1;
		}
		
		if($currentpage > ($numPageShow/2))
		{
			$startpage = $currentpage - floor($numPageShow/2);
			if($totalpage - $startpage < $numPageShow)
			{
				$startpage = $totalpage - $numPageShow + 1;
			}
		}
		else
		{
			$startpage = 1;
		}
		if($startpage < 1)
		{
			$startpage = 1;
		}        
		//Link den trang truoc
		if($currentpage > 1)
		{
			if($url_rewrite)                
				$url = str_replace('{page_no}',($currentpage-1),$url_rewrite);
			else
				$url = Page::link(array($page_name=>($currentpage-1)),null, null).$cond;
			$content.= '<li><A HREF = "'.$url.'"  title="'.($currentpage-1).'">&laquo; Trước</A></li>';
		}
		//Danh sach cac trang        
		if($startpage > 1)
		{
			if($url_rewrite)                
				$url = str_replace('{page_no}','1',$url_rewrite);
			else
				$url = Page::link(array($page_name=>1),null, null).$cond;
			$content.= '<li><a '.$classNormal.' href= "'.$url.' " title="1">1</a></li>';            
		}
		for($i = $startpage; $i <= $startpage + $numPageShow - 1 && $i <= $totalpage; $i++)
		{
			if($i == $currentpage)
			{
				$content.= '<li><a '.$classCurrent.' href="javascript:;" title="'.$i.'">'.$i.'</a></li>';
			}
			else 
			{
				if($url_rewrite)                
					$url = str_replace('{page_no}',$i,$url_rewrite);
				else
					$url = Page::link(array($page_name=>$i),null, null).$cond;
				$content .= '<li><a '.$classNormal.' href= "'.$url.' " title="'.$i.'">'.$i.'</a></li>';
			}
		}
		if($i == $totalpage)
		{
			if($url_rewrite)                
				$url = str_replace('{page_no}',$totalpage,$url_rewrite);
			else
				$url = Page::link(array($page_name=>$totalpage),null, null).$cond;
			$content .= '<li><a '.$classNormal.' href= "'.$url.' " title="'.$totalpage.'">'.$totalpage.'</a></li>';
		}
		else
		if($i < $totalpage)
		{
			if($url_rewrite)                
				$url = str_replace('{page_no}',$totalpage,$url_rewrite);
			else
				$url = Page::link(array($page_name=>$totalpage),null, null).$cond;
			$content .= '<li>...</li><li><a '.$classNormal.' href= "'.$url.' " title="'.$totalpage.'">'.$totalpage.'</a></li>';
		}        
		//Trang sau
		if($currentpage < $totalpage)
		{
			if($url_rewrite)                
				$url = str_replace('{page_no}',($currentpage + 1),$url_rewrite);
			else
				$url = Page::link(array($page_name=>($currentpage+1)), null, null).$cond;
			$content .= '<li><A '.$classNormal.' HREF = "'.$url.'" title="'.($currentpage+1).'">Sau &raquo;</A></li>';
		}         
		return $content;        
	}
	
	/**
	* @description Ham phan trang dung trong ajax
	* @access public
	* @param $total - Tong so ban ghi
	* @param $perPage - So ban ghi tren/1 trang
	* @param $numPageShow - so trang duoc hien thi default = 10
	* @param $page_no param phan trang, default la page_no (nen de la page_no)
	* @param $classCurrent - Class css de phan biet trang hien tai, default = ''
	* @param $classNormal - Class css cho cac trang normal default = ''
	* @param $function_call - ten ham javascript goi viec nhay trang default = 'GoToPage'
	* @return tra ve chuoi phan trang voi cau truc <li><a ...>1</a></li><li><a ...>2></a></li>....<li><a ...>n</a></li>
	*/
	public static function pagging_ajax_ebay($total, $perPage, $numPageShow, $currentpage, $classCurrent = '', $classNormal = '', $function_call = array()){
		$content='';
		$totalpage = ceil($total/$perPage);
		if($classCurrent == '')
			$classCurrent = 'class="paging-active"';
		else
		   $classCurrent = 'class="'.$classCurrent.'"';
		if($classNormal)
			$classNormal = 'class="'.$classNormal.'"';
		if($currentpage <= 0 || $currentpage > $totalpage)
		{
			$currentpage = 1;
		}
		
		if($currentpage > ($numPageShow/2))
		{
			$startpage = $currentpage-floor($numPageShow/2);
			if(($totalpage - $startpage) < $numPageShow)
			{
				$startpage = $totalpage - $numPageShow + 1;
			}
		}
		else
		{
			$startpage = 1;
		}
		if($startpage < 1)
		{
			$startpage = 1;
		} 
		if(is_array($function_call)){
			$countParam = count($function_call);
			$strParam = "(";
			for($i = 0; $i < $countParam; $i++){
				if($i == 0)
					$functionName = $function_call[$i];
				else{
					if($i != ($countParam-1))
						$strParam .= "'" . $function_call[$i] . "',";  
				}
			}
		}
		   
		//Link den trang truoc
		if($currentpage > 1)
		{
			$strPrev = $functionName . $strParam . "'" . ($currentpage-1) . "');";
			$content.= '<li><a '.$classNormal.' HREF = "javascript:'. $strPrev. '" >&laquo; Trước</A></li>';
		}
		//Danh sach cac trang        
		if($startpage > 1)
		{
			$content.= '<li><a '.$classNormal.' href= "javascript:'.$function_call.'(1);">1</a></li>';            
		}
		for($i = $startpage; $i <= ($startpage + $numPageShow - 1) && $i <= $totalpage; $i++)
		{
			$strPage = $functionName . $strParam . "'" . $i . "');";
			if($i == $currentpage)
			{
				$content.= '<li ><a '.$classCurrent.' href="javascript:;">'.$i.'</a></li>';
			}
			else 
			{
				$content.= '<li><a '.$classNormal.' href="javascript:' . $strPage .'">'.$i.'</a></li>';
			}
		}
		if($i == $totalpage)
		{
			$content.= '<li><a '.$classNormal.' href= "javascript:'.$function_call.'('.$totalpage.');">'.$totalpage.'</a></li>';
		}
		else
			if($i < $totalpage)
			{
				$content.= '<li>...</li><li><a '.$classNormal.' href= "javascript:'.$function_call.'('.$totalpage.');">'.$totalpage.'</a></li>';
			}        
		//Trang sau
		if($currentpage < $totalpage)
		{
			$strNext = $functionName . $strParam . "'" . ($currentpage+1) . "');";
			$content.= '<li><a '.$classNormal.' HREF = "javascript:'. $strNext .'">Sau &raquo;</a></li>';
		}
		if($totalpage < 2)
			$content='';
		return $content;
	}
	public static function pagging_ajax($total, $perPage, $numPageShow=10, $page_name='page_no', $classCurrent = '', $classNormal = '', $function_call='GoToPage', $isNotAll = false)
	{
		$content='';
		$totalpage = ceil($total/$perPage);         
		$currentpage = Page :: getRequest($page_name,'int',1, 'GET');
	   // $currentpage=round($currentpage);
		if($classCurrent == '')
			$classCurrent = 'class="paging-active"';
		else
		   $classCurrent = 'class="'.$classCurrent.'"';
		if($classNormal)
			$classNormal = 'class="'.$classNormal.'"';
		if($currentpage <= 0 || $currentpage > $totalpage)
		{
			$currentpage = 1;
		}
		
		if($currentpage > ($numPageShow/2))
		{
			$startpage = $currentpage-floor($numPageShow/2);
			if(($totalpage - $startpage) < $numPageShow)
			{
				$startpage = $totalpage - $numPageShow + 1;
			}
		}
		else
		{
			$startpage = 1;
		}
		if($startpage < 1)
		{
			$startpage = 1;
		}        
		//Link den trang truoc
		if($currentpage > 1)
		{
			$content.= '<li><A '.$classNormal.' HREF = "javascript:'.$function_call.'('.($currentpage-1).');" >&laquo; Trước</A></li>';
		}
		//Danh sach cac trang        
		if($startpage > 1)
		{
			$content.= '<li><a '.$classNormal.' href= "javascript:'.$function_call.'(1);">1</a></li>';            
		}
		for($i = $startpage; $i <= ($startpage + $numPageShow - 1) && $i <= $totalpage; $i++)
		{
			if($i == $currentpage)
			{
				$content.= '<li ><a '.$classCurrent.' href="javascript:;">'.$i.'</a></li>';
			}
			else 
			{
				$content.= '<li><a '.$classNormal.' href= "javascript:'.$function_call.'('.$i.'); ">'.$i.'</a></li>';
			}
		}
		if($i == $totalpage)
		{
			$content.= '<li><a '.$classNormal.' href= "javascript:'.$function_call.'('.$totalpage.');">'.$totalpage.'</a></li>';
		}
		else
			if($i < $totalpage and !$isNotAll)
			{
				$content.= '<li>...</li><li><a '.$classNormal.' href= "javascript:'.$function_call.'('.$totalpage.');">'.$totalpage.'</a></li>';
			}        
		//Trang sau
		if($currentpage < $totalpage)
		{
			$content.= '<li><A '.$classNormal.' HREF = "javascript:'.$function_call.'('.($currentpage+1).');">Sau &raquo;</A></li>';
		}
		if($totalpage < 2)
			$content='';
		return $content;
			
	}
	
	public static function pagging_pre_next($total, $perPage, $numPageShow=10, $page_name='page_no', $classPre = '', $classNext = '', $function_call='GoToPage')
	{
		$content='';
		$totalpage = ceil($total/$perPage);         
		$currentpage = Page :: getRequest($page_name,'int',1, 'GET');
		$classPre = 'class="'.$classPre.'"';
		$classNext = 'class="'.$classNext.'"';
		if($currentpage <= 0 || $currentpage > $totalpage)
		{
			$currentpage = 1;
		}
		
		if($currentpage > ($numPageShow/2))
		{
			$startpage = $currentpage-floor($numPageShow/2);
			if(($totalpage - $startpage) < $numPageShow)
			{
				$startpage = $totalpage - $numPageShow + 1;
			}
		}
		else
		{
			$startpage = 1;
		}
		if($startpage < 1)
		{
			$startpage = 1;
		}        
		//Link den trang truoc
		if($currentpage > 1)
		{
			$content.= '<A '.$classPre.' HREF = "javascript:'.$function_call.'('.($currentpage-1).');" ></A>';
		}
		//Trang sau
		if($currentpage < $totalpage)
		{
			$content.= '<A '.$classNext.' HREF = "javascript:'.$function_call.'('.($currentpage+1).');"></A>';
		}
		if($totalpage < 2)
			$content='';
		return $content;
			
	}	
}