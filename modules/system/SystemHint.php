<?php
/**
 * @desc			
 * @author 			HoangNV<longhoangvnn@gmail.com> 
 * @package 		modules
 * @subpackage 		system
 * @version 		Id: SystemHint.php v1.0 2011/07/23 hoangnv
 * @since 			CGS v 2.0
 * @copyright 		CGS.,JSC (c) 2011
 */
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
//require_once CGS_MODEL_PATH.'db'.DS.'setting.base.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';
class SystemHint extends CgsModules{
	function __construct(){
		
	}
	
	function execute(){
		Page::header('Cấu hình hệ thống - CGS system','Quản trị hệ thống','cgs,system,page,page');
		Page::regColorpicker();
		Page::reg('js', Page::pathMod().'SystemHint.js');
		
		$form = new CgsFormsView('system'.DS.'SystemSetting.xml');
		$view = $form->getView('SystemHintView');
		$this->assign('FORM_BEGIN', $view->getFormBegin());
		$this->assign('FORM_END', 	$view->getFormEnd());
		$this->assign('hint_btn_OK', 	$view->getHtml('hint_btn_OK'));
		$this->assign('hint_btn_RESET', $view->getHtml('hint_btn_RESET'));
		
		// Set value default
		$view->set('hint_layout_enable',	CgsGlobal::getSetting('HINT_LAYOUT_ENABLE'));
		$view->set('hint_layout_color',		CgsGlobal::getSetting('HINT_LAYOUT_COLOR'));
		if (CgsGlobal::getSetting('HINT_LAYOUT_STYLE')){
			$view->set('hint_layout_style',		CgsGlobal::getSetting('HINT_LAYOUT_STYLE'));
		}
		if (CgsGlobal::getSetting('HINT_LAYOUT_WIDTH')){
			$view->set('hint_layout_width',		CgsGlobal::getSetting('HINT_LAYOUT_WIDTH'));
		}
		
		$view->set('hint_block_enable',		CgsGlobal::getSetting('HINT_BLOCK_ENABLE'));
		$view->set('hint_block_color',		CgsGlobal::getSetting('HINT_BLOCK_COLOR'));
		if (CgsGlobal::getSetting('HINT_BLOCK_STYLE')){
			$view->set('hint_block_style',		CgsGlobal::getSetting('HINT_BLOCK_STYLE'));
		}
		if (CgsGlobal::getSetting('HINT_BLOCK_WIDTH')){
			$view->set('hint_block_width',		CgsGlobal::getSetting('HINT_BLOCK_WIDTH'));
		}
		
		$view->set('hint_system_module_enable',		CgsGlobal::getSetting('HINT_SYSTEM_MODULE_ENABLE'));
		
		// Send value to template
		$this->assign('hint_layout_enable', 	$view->getHtml('hint_layout_enable'));
		$this->assign('hint_layout_color', 		$view->getHtml('hint_layout_color'));
		$this->assign('hint_layout_color_value',$view->get('hint_layout_color'));
		$this->assign('hint_layout_style', 		$view->getHtml('hint_layout_style'));
		$this->assign('hint_layout_style_value',$view->get('hint_layout_style'));
		$this->assign('hint_layout_width', 		$view->getHtml('hint_layout_width'));
		$this->assign('hint_layout_width_value',$view->get('hint_layout_width'));
		
		$this->assign('hint_block_enable', 		$view->getHtml('hint_block_enable'));
		$this->assign('hint_block_color', 		$view->getHtml('hint_block_color'));
		$this->assign('hint_block_color_value', $view->get('hint_block_color'));
		$this->assign('hint_block_style', 		$view->getHtml('hint_block_style'));
		$this->assign('hint_block_style_value', $view->get('hint_block_style'));
		$this->assign('hint_block_width', 		$view->getHtml('hint_block_width'));
		$this->assign('hint_block_width_value', $view->get('hint_block_width'));
		
		$this->assign('hint_system_module_enable', $view->getHtml('hint_system_module_enable'));

		$html = $this->output();
		return $html;
	}
}