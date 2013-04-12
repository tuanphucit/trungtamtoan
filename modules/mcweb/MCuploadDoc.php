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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDocumentPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultDoccatePeer.php';

class MCuploadDoc extends CgsModules {
	function __construct() {
	}

	function execute() {
		$username = Page :: getRequest('username', 'str', '','SESSION');
		Page :: header('Upload tài liệu lên Trung tâm toán');
		Page :: reg('js', Page :: pathMod() . 'MCuploadDoc.js');
		Page::reg('css',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/css/validationEngine.jquery.css');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/languages/jquery.validationEngine-vi2.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/jquery.validationEngine.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/other-validations.js','footer');
  		Page::reg('js',CGS_WEBSKINS_PATH.'plugins/formValidator.2.2/js/contrib/file-validator.js','footer');
		
		
		if (!Page :: isLogIn()) {
			Page :: goLink(null, 'index', 'mc_web');
		}		
		$docObj = new DefaultDocumentPeer();
		$classObj = new DefaultClassPeer();
		$docCateObj = new DefaultDoccatePeer();
		
		$form = new CgsFormsView('mcweb' . DS . 'MCuploadDoc.xml');
		$view = $form->getView('MCuploadDocView');
		$view->setValidate(false);
		$allClass = $classObj->getListAll('*');
		$allCate = $docCateObj->getListAll('*');
		$view->setListData('classID', $allClass, 'class_id,name');
		$view->setListData('CateID', $allCate, 'id,name');

		$this->assign('FORM_BEGIN', $view->getFormBegin(array (
			'enctype' => "multipart/form-data"
		)));
		$this->assign('FORM_END', $view->getFormEnd());
		$this->assign('fileUpload', '<input type="file" name="fileUpload" id="fileUpload" accept="*/*" size="30" class="validate[required]"/>');
		$this->assign('name', $view->getHtml('name'));
		$this->assign('classID', $view->getHtml('classID'));
		$this->assign('CateID', $view->getHtml('CateID'));
		$this->assign('description', $view->getHtml('description'));
		
		$submit = Page :: getRequest('upload', 'str', '', 'POST');
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

			$name = Page :: getRequest('name', 'str', '', 'POST');
			$description = Page :: getRequest('description', 'str', '', 'POST');
			$classID = Page :: getRequest('classID', 'str', '', 'POST');
			$cateID = Page :: getRequest('CateID', 'str', '', 'POST');
			
			$data = array (
				'name' => $name,
				'description' => $description,
				'classID' => $classID,
				'doc_cate_id' => $cateID,
				'filename' => $filename,
				'createtime' => current(),
				'author' => Page :: getRequest('username', 'str', '','SESSION'),
				'type'=> $type,		
							
			);
			if($uploadResult){
				$docObj->insert('document', $data);
			}
			$submit = null;
			Page::goLink(null,'yourdoc','mc_web');
		}
		$html = $this->output();
		return $html;
	}
}