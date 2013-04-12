<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPage.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'default'.DS.'DefaultClassPeer.php';
require_once CGS_MODEL_PATH.'default'.DS.'DefaultDoccatePeer.php';
require_once CGS_MODEL_PATH.'default'.DS.'DefaultDocumentPeer.php';


class MCclassSide extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){		
		
		Page::header('Danh sách Tài liệu');
		$classObj = new DefaultClassPeer();		
		$docCateObj = new DefaultDoccatePeer();
		$dodcObj = new DefaultDocumentPeer();
		
		$allClass = $classObj->getListAll('*');
		$allCate = $docCateObj->getListAll('*');
		$classID = Page :: getRequest('classID', 'int', 0, 'GET');	
		$cateID = Page :: getRequest('cateID', 'int', 0, 'GET');
		$page = Page :: getRequest('page', 'str', '', 'GET');
		if($page == 'DocDetail'){
			$id = Page :: getRequest('id', 'int', 0, 'GET');
			$doc = $dodcObj->selectOne('document', 'classID, doc_cate_id', "`id` = {$id} AND `status` = 1 ", '','');
			$classID = $doc['classID'];
			$cateID = $doc['doc_cate_id'];			
		}	
		
		$htmlContent = "<ul>";
		$stt = 1;
		foreach ($allClass as $class){
			$style = ($classID==$class['class_id'])?'style="color: blue; text-decoration: underline;"':'';
			$htmlContent .= "<li><h3 ".$style." >".$stt.". ".$class['name']."</h3><ul>";
			$stt2 = 1;
			foreach ($allCate as $cate){	
				$cateStyle = ($cateID==$cate['id'] && $classID==$class['class_id'])?'style="color: blue; text-decoration: underline;"':'';				
				$link = Page::link(array('classID'=>$class['class_id'], 'cateID'=>$cate['id']),'DocOfClass','mc_web');
				$htmlContent .= "<li><a href='".$link."' ".$cateStyle.">"."$stt".".$stt2. ".$cate['name']."</a></li>";
				$stt2++;
			}
			$stt++;
			$htmlContent .= "</ul></li>";
		}
		$htmlContent .= "</ul>";
		$this->assign('content',$htmlContent);
		$html = $this->output();
		return $html;
	}
}