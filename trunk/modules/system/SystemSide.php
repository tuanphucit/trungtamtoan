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
class SystemSide extends CgsModules {
	function __construct(){
		
	}
	
	function execute(){
		$portal = CgsGlobal::get('portal',DEFAULT_PORTAL);
		$page = CgsGlobal::get('page',DEFAULT_PAGE);
		$id = Page::getRequest('id','int',0,'GET');
		
		$menu = array(
			array(	'title'		=> $this->lang('system_portal'),
					'link'		=> Page::link(null,'portal','system'),
					'is_active'	=> in_array($page,array('portal','portal_edit')) ? true : false,
					'sub'	=> array(
						array(
							'title'	=> $this->lang('list'),
							'link'	=> Page::link(null,'portal','system'),
							'is_active'	=> $page=='portal' ? true : false
						),
						array(
							'title'	=> $this->lang('edit'),
							'link'	=> Page::link(array('id'=>$id),'portal_edit','system'),
							'is_active'	=> $id > 0 ? true : false,
							'is_hide'	=> $id == 0 ? true : false,
						),
					)
			),
			array(	'title'		=> $this->lang('system_page'),
					'link'		=> Page::link(null,'page','system'),
					'is_active'	=> ($page=='page' || $page=='page_edit') ? true : false,
					'sub'	=> array(
						array(
							'title'	=> $this->lang('list'),
							'link'	=> Page::link(null,'page','system'),
							'is_active'	=> $page=='page' ? true : false
						),
						array(
							'title'	=> $this->lang('edit'),
							'link'	=> Page::link(array('id'=>$id),'page_edit','system'),
							'is_active'	=> $page=='page_edit' ? true : false,
							'is_hide'	=> $page!='page_edit' ? true : false,
						),
					)
			),
			array(	'title'		=> $this->lang('system_layout'),
					'link'		=> Page::link(null,'layout','system'),
					'is_active'	=> $page=='layout' ? true : false
			),
			array(	'title'		=> $this->lang('system_module'),
					'link'		=> Page::link(null,'module','system'),
					'is_active'	=> $page=='module' ? true : false
			),
			array(	'title'		=> $this->lang('system_side'),
					'link'		=> Page::link(null,'side','system'),
					'is_active'	=> $page=='side' ? true : false
			),
			array(	'title'		=> $this->lang('system_setting'),
					'link'		=> Page::link(null,'setting','system'),
					'is_active'	=> in_array($page, array('setting','hint','debug','cache','log','setting_public')) ? true : false,
					'sub'	=> array(
						array(
							'title'	=> $this->lang('hint'),
							'link'	=> Page::link(null,'hint','system'),
							'is_active'	=> $page=='hint' ? true : false
						),
						array(
							'title'	=> $this->lang('debug'),
							'link'	=> Page::link(null,'debug','system'),
							'is_active'	=> $page=='debug' ? true : false,
						),
						array(
							'title'	=> $this->lang('cache'),
							'link'	=> Page::link(null,'cache','system'),
							'is_active'	=> $page=='cache' ? true : false,
						),
						array(
							'title'	=> $this->lang('log'),
							'link'	=> Page::link(null,'log','system'),
							'is_active'	=> $page=='log' ? true : false,
						),
						array(
							'title'	=> $this->lang('setting'),
							'link'	=> Page::link(null,'setting_public','system'),
							'is_active'	=> $page=='setting_public' ? true : false,
						),
					)
			),
			array(	'title'		=> $this->lang('codegen'),
					'link'		=> Page::link(null,'codegen','system'),
					'is_active'	=> in_array($page, array('codegen','gen_model','gen_ui')) ? true : false,
					'sub'	=> array(
						array(
							'title'	=> $this->lang('gen_model'),
							'link'	=> Page::link(null,'gen_model','system'),
							'is_active'	=> $page=='gen_model' ? true : false
						),
						array(
							'title'	=> $this->lang('gen_ui'),
							'link'	=> Page::link(null,'gen_ui','system'),
							'is_active'	=> $page=='gen_ui' ? true : false,
						),
					)
			),
		);
		
		$this->block('BlockList');
		foreach ($menu as $row){
			if (isset($row['is_hide']) && $row['is_hide']) continue;
			
			$this->assign('rs_title', $row['title']);
			$this->assign('rs_link', $row['link']);
			$this->assign('rs_class', $row['is_active'] ? 'side_on' : '');
			$this->assign('sub_side', isset($row['sub']) ? $this->__getSubSide($row['is_active'],$row['sub']) : '');
			$this->add_block('BlockList');
		}
		
		return $this->output();
	}
	
	private function __getSubSide($parrent_active=false, $menu=array()){
		if (!$parrent_active) return;
		if (!is_array($menu) || empty($menu)) return;
		
		$html = '<ul>';
		foreach ($menu as $row){
			if (isset($row['is_hide']) && $row['is_hide']) continue;
			
			$html.= '<li class="'.($row['is_active']?'current':'').'"><a href="'.$row['link'].'">'.$row['title'].'</a></li>';
		}
		$html.= '</ul>';
		
		return $html;
	}
}