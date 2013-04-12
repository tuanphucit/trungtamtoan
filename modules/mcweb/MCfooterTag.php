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

class MCfooterTag extends CgsModules {
	function __construct() {
	}

	function execute() {
		$arrayLink = array(array('name'=> 'Trung tâm toán', 'link'=>Page :: link(null, 'index', 'mc_web')),
							array('name'=> 'Đăng ký làm gia sư', 'link'=>Page :: link(null, 'regTeach', 'mc_web')),
							array('name'=> 'Đăng ký tìm gia sư', 'link'=>Page :: link(null, 'regLearn', 'mc_web')),
							array('name'=> 'Danh sách học sinh', 'link'=>Page :: link(null, 'listClass', 'mc_web')),
							array('name'=> 'Danh sách gia sư', 'link'=>Page :: link(null, 'listTeacherb', 'mc_web')),
							array('name'=> 'Danh sách gia sư giỏi', 'link'=>Page :: link(null, 'listTeacherb', 'mc_web')),
							array('name'=> 'Tài liệu về toán', 'link'=> Page :: link(null, 'NewDoc', 'mc_web')),
							array('name'=> 'Liên hệ trung tâm', 'link'=>Page :: link(null, 'help', 'mc_web')),
							array('name'=> 'Giới thiệu trung tâm' , 'link'=>Page :: link(null, 'intro', 'mc_web')),
							array('name'=> 'Gửi phụ huynh' , 'link'=>Page :: link(array('id'=>307), 'articleDetail', 'mc_web')),			
							array('name'=> 'Gửi gia sư' , 'link'=>Page :: link(array('id'=>308), 'articleDetail', 'mc_web'))	
		);
		//var_dump($arrayLink);
		$this->block('BlockList');
		foreach ($arrayLink as $tag){
					$value = $tag['link'];
					$key = $tag['name'];
					$link = '<a href="'.$value.'" alt="'.$key.'">'.$key.'</a>';
					$this->assign('link_tag',$link);	
					$this->add_block('BlockList');
				}
		$html = $this->output();
		return $html;
	}
}