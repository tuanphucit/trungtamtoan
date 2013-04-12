<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SysPageEdit.php v1.0 03/01/2011 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 *
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_MODEL_PATH.'db'.DS.'DbPagePeer.php';
require_once CGS_SYSTEM_PATH.'system.html.form.build.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemPageEdit extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Quản trị PORTAL - CGS system','Quản trị hệ thống','cgs,system,page,page');
		
		Page::regValidateForm();
		
        Page::reg('css', CGS_JS_SYSTEM_PATH.'popup.css', 'header');
        Page::reg('js', CGS_JS_SYSTEM_PATH.'jqDnR.js', 'footer');
        Page::reg('js', CGS_JS_SYSTEM_PATH.'popup.js', 'footer');
        
		Page::reg('js', 'modules/system/SystemPageEdit.js');
		
		$page_id = Page::getRequest('page_id','int',0,'GET');
		if ($page_id == 0) return 'Không hợp lệ';
		
		// Khoi tao con tro db
		$dbObj = new DbPagePeer();
		
		// Page detail
		$rs = $dbObj->selectOne('page', 'id,page_name,brief,layout,modules,master_id,portal_id,publish_flg,title,description,keyword', "`id`='{$page_id}'");
		if (empty($rs)) return 'Không hợp lệ';
		
		$data_layout = $dbObj->select('layout', 'id,layout_name');
		$data_portal = $dbObj->select('portal', 'id,portal_name',null,null,null,'id');
		
		// Set form
		$form = new CgsFormsView('system'.DS.'SystemPage.xml');
		$view = $form->getView('SystemPageEditView');
		if (!empty($rs)){
			$view->mapData($rs, array(	'page_id'		=> 'id',
										'master_page_id'	=> 'master_id',
										'publish'=> 'publish_flg',
										'page_title'=> 'title',
										'page_description'=> 'description',
										'page_keyword'=> 'keyword',
									)
							);
		}
							
		$view->setValidate(true);
		$view->setListData('layout', $data_layout, 'layout_name,layout_name');
		$view->setListData('portal_id', $data_portal, 'id,portal_name');
		
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		
		$this->assign('fm_id', 		$view->get('page_id'));
		$this->assign('fm_page_id', 		$view->getHtml('page_id'));
		$this->assign('fm_page_name', 		$view->getHtml('page_name'));
		$this->assign('fm_brief', 			$view->getHtml('brief'));
		$this->assign('fm_layout', 			$view->getHtml('layout'));
		$this->assign('fm_master_page_id', 	$view->getHtml('master_page_id'));
		$this->assign('fm_portal_id', 		$view->getHtml('portal_id'));
		$this->assign('fm_publish', 		$view->getHtml('publish'));
		$this->assign('fm_page_title', 		$view->getHtml('page_title'));
		$this->assign('fm_page_description', 	$view->getHtml('page_description'));
		$this->assign('fm_page_keyword', 		$view->getHtml('page_keyword'));
		$this->assign('fm_empty_module', 		$view->getHtml('empty_module'));
		
		$this->assign('page_btn_OK', 	$view->getHtml('page_btn_OK'));
		$this->assign('page_btn_RESET', $view->getHtml('page_btn_RESET'));
		
		$portal_name = isset($data_portal[$rs['portal_id']]['portal_name'])
							? $data_portal[$rs['portal_id']]['portal_name']
							: 'NULL';
		$this->assign('page_goto','<a href="'.Page::link(null,$rs['page_name'],$portal_name).'" target="_blank">'.$portal_name.'/'.$rs['page_name'].'</a>');
		
		$layoutPage = $this->getLayout($rs['layout']);
		$listMod = json_decode($rs['modules'],true);
		
		
		// Master page
		$listModMaster = array();
		if ($rs['master_id']){
			$rs_master = $dbObj->selectOne('page', 'id,modules', "`id`='{$rs['master_id']}'");
			if (isset($rs_master['modules'])){
				$listModMaster = json_decode($rs_master['modules'],true);
			}
		}
		
		// Tat ca vi tri cua page
		$data_position = array();
		
		$this->block('BlockList');
		foreach ($layoutPage as $layout){
			$this->assign('ls_layout', $layout);
			$this->assign('ls_module', $this->getMod($layout,$listMod,$listModMaster,$data_position));
			$this->add_block('BlockList');
		}
		
		// Output POPUP FORM
		$viewPopup = new HtmlFormBuild();
		$viewPopup->create('select','popup_position',array('display'=>'Vị trí cắm trang'));
		$viewPopup->create('select','popup_module',array('display'=>'Module'));
		
		// Set List position
		$viewPopup->setListData('popup_position', $data_position, 'id,name');
		
		// Set List module
		$data_module = $dbObj->select('module', 'id,name,path', null, 'path ASC');
		$viewPopup->setListData('popup_module', $data_module, 'path,path');
		
		$this->assign('select_position', $viewPopup->getHtml('popup_position'));
		$this->assign('select_module', $viewPopup->getHtml('popup_module'));
		
		// link add other page
		$this->assign('parent_link',Page::link(array('portal_id'=>$rs['portal_id']),'page'));
		
		// print page list
		$data_page = $dbObj->select('page', 'id,page_name',"`portal_id`='{$rs['portal_id']}'",null,null,'id');
		$this->block('BlockOtherPage');
		foreach ($data_page as $row){
			$this->assign('other_page_title', $row['page_name']);
			$this->assign('other_page_link', Page::link(array('page_id'=>$row['id']),'page_edit','system'));
			$this->assign('other_page_class', ($row['id']==$page_id ? 'current' : ''));
			$this->add_block('BlockOtherPage');
		}
		
		
		$html = $this->output();
		return $html;
	}
	
	function getLayout($handle){
		$content = $this->loadfile(CGS_LAYOUT_PATH.$handle);
		$reg_ex = "|\[\[\|(.*)\|\]\]|U";
		preg_match_all($reg_ex,$content,$s);
		
		if (isset($s[1]) && !empty($s[1])) return $s[1];
		return array();
	}
	
	function loadfile($handle='$handle'){
		try {
			if (! file_exists( $handle )) {
				throw new CgsException ( "Loadfile: $handle is not a valid handle." );
				return false;
			}
			//$filename = $this->filename ( $handle );
			$filename = $handle;
			
			$content = implode ( "", @file ( $filename ) );
			if (empty ( $content )) {
				throw new CgsException ( "Loadfile: While loading $handle, $filename does not exist or is empty." );
				return false;
			}
			return $content;
			
		} catch ( CgsException $ex ) {
			//$this->print_err_exception ( $ex );
			$ex->print_error();
		}
	}
	
	function getMod($position='', $listMod=array(), $listModMaster=array(), &$data_module){
		$data_module[] = array('id'=>$position, 'name'=>$position);
		
		$str = '<ol rel="'.$position.'" style="padding:0px;">';

		// master page
		if (isset($listModMaster[$position])){
			foreach ($listModMaster[$position] as $key=>$mod){
				$str.= '<li style="margin:0px;list-style:none;color:#888888;" title="module of Master page">'
					. CGS_MODULES_PATH.$mod
					. '</li>';
			}
		}
		
		// current page
		if (isset($listMod[$position])){
			foreach ($listMod[$position] as $key=>$mod){
				$str.= '<li style="margin:0px;list-style:none;color:#EE8833;">'
					. '<span class="icon-up_8 hand up_mod" rel="'.$position.'|'.$key.'" title="Up"></span>'
					. '<span class="icon-down_8 hand down_mod" rel="'.$position.'|'.$key.'" title="Down"></span>'
					. CGS_MODULES_PATH.$mod
					. '<span class="icon-cancel_8 hand unplugin_mod" rel="'.$position.'|'.$key.'" title="Remove"></span>'
					. '</li>';
			}
		}
		$str.= '</ol>';
		return $str;
	}
}