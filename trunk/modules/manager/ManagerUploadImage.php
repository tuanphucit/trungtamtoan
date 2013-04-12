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
defined('IN_CGS') or die('Restricted Access');
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDocumentPeer.php';

class ManagerUploadImage extends CgsModules {
	function __construct() {
	}

	function execute() {
		$username = Page :: getRequest('username', 'str', '','SESSION');
		Page :: header('Upload ảnh cho bài viết');
		
		if (Page::getRequest('IS_MANAGER_LOGIN','def',false,'SESSION')==false) {
			Page::goLink(null,'login','manager');
		}
		
		$articleID = Page :: getRequest('article_id', 'int', 0, 'GET');
			
		$docObj = new DefaultDocumentPeer();	
		$allImage = $docObj->select('document', '*', "`status` = 0 AND `name` = '{$articleID}' AND `doc_cate_id` = 0 AND `classID` = 0 ", 'updatetime DESC');
		$this->block('BlockList');
		$stt = 1;
		if($allImage){
			foreach ($allImage as $image){				
				$imageLink = Page::displayImage(CGS_DOCUMENT_PATH.$image['filename'],"image","100","100");
				$this->assign('link',  CGS_DOCUMENT_PATH.$image['filename']);
				$this->assign('image', $imageLink);
				$this->assign('stt', $stt);
				$this->assign('del_link', Page::link(array('id'=>$image['id']),'DelDoc','manager'));
				
				$this->add_block('BlockList');
				$stt++;
			}
		}
		$form = new CgsFormsView('manager' . DS . 'MCuploadImage.xml');
		$view = $form->getView('MCuploadImageView');
		$view->setValidate(true);
		$this->assign('FORM_BEGIN', $view->getFormBegin(array (
			'enctype' => "multipart/form-data", 'method'=>'POST', 'action'=>''
		)));
		$image = '';
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('fileUpload', '<input type="file" name="fileUpload" id="fileUpload" accept="image/*" size="30" class="validate[required]"/>');
		$this->assign('image', $image);
		
		$submit = Page :: getRequest('uploadImage', 'str', '', 'POST');		
		$newName = '';
		if ($submit) {
			$fileUpload = Page :: getRequest('fileUpload', 'def', null, 'FILE');
			$filename='';
			$type='';
			if ($fileUpload['size'] != 0) {		
				$date = Date('Ymd', time());
				CgsFunc::createDir(CGS_DOCUMENT_PATH.$date);	
				$type = explode(".", $fileUpload["name"]);
				$type = $type[count($type)-1];
				$newName = $username."_".time().".".$type;
				$uploadResult = move_uploaded_file($fileUpload["tmp_name"], CGS_DOCUMENT_PATH.$date.DS.$newName);
				$filename = $date.DS.$newName;	
			}
			
			$data = array (
				'name' => $articleID,
				'description' => '',
				'classID' => 0,
				'doc_cate_id' => 0,
				'filename' => $filename,
				'createtime' => current(),
				'author' => Page :: getRequest('username', 'str', '','SESSION'),
				'type'=> $type,	
				'status'=>0,	
							
			);
			if($uploadResult){
				$docObj->insert('document', $data);
				header('Location: '.$_SERVER['REQUEST_URI']);
			}
			$submit = null;
		}
		$html = $this->output();
		return $html;
	}
}