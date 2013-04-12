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
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultSessionsPeer.php';


class MCDetailTeacher extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: header('Thông tin gia sư');

		$objGiasu = new DefaultGiasuPeer();
		$objClass = new DefaultClassPeer();
		$objLocation = new DefaultLocationPeer();
		
		$id = Page :: getRequest('id', 'int', 0, 'GET');

		$row = $objGiasu->selectOne('giasu', 'giasu_id, firstname, lastname, gender, level, expected_fee, teach_classes, teach_locations, teach_sessions, validate, avatar, mobile, school, faculty, introduction', '`status` = 1 AND `giasu_id` = ' . $id);
		$info = "";

		$arrayLevel = array (
			"0" => 'Cao đẳng',
			'1' => 'Đại học',
			'2' => 'Đã ra trường',
			'3' => 'Giáo viên'
		);

		$arrayValidate = array (
			'0' => 'Chưa đánh giá',
			'1' => 'TRUNGTAMTOAN.COM đảm bảo về chất lượng dạy',
		);
		
		$className = "Chưa có thông tin";
		if ($row['teach_classes'] != '') {
			$className ='';
			$arrayClass = $objClass->select('class', 'name', "class_id IN(" . $row['teach_classes'] . ")");
			foreach ($arrayClass as $class) {
				$className .= $class['name'] . ", ";
			}
		}

		$sessionObj = new DefaultSessionsPeer();
		$sessionName = 'Chưa có thông tin';
		if ($row['teach_sessions'] != '') {
			$sessionName = '';
				$arraySesisons = $sessionObj->select('sessions', 'session, day', "`sessions_id` IN(" . $row['teach_sessions'] . ")");
				foreach ($arraySesisons as $session) {
					$sessionName .= $session['session'] . " ".$session['day'].", ";
				}
			}
		
			$locationName = "Chưa có thông tin";
			if ($row['teach_locations'] != '') {
				$locationName='';
				$arrayLocation = $objLocation->select('location', 'name', "`location_id` IN(" . $row['teach_locations'] . ")");

				foreach ($arrayLocation as $location) {
					$locationName .= $location['name'] . ", ";
				}
			}
			
			$gender = ($row['gender'] == 1) ? 'Nam' : 'Nữ';
			$level = "";
			foreach ($arrayLevel as $key => $value) {
				if ($row['level'] == $key) {
					$level = $value;
					break;
				}
			}

			$validated = "";
			foreach ($arrayValidate as $key => $value) {
				if ($row['validate'] == $key) {
					$validated = $value;
					break;
				}
			}
			$phone = (($row['validate'] == 0)?$row['mobile']:CGS_MOBILE);
			$goBack = Page :: link(NULL, 'listTeacher', 'mc_web');
			$avatar = $row['avatar']!=NULL?$row['avatar']:"noavatar.gif";
			$avatarLink = Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.$avatar,"avatar","130","110");
			$introduction = '';
			if($row['introduction']!=''){
				$introduction = '<tr><td><b>Thông tin khác</b></td><td colspan="2">'.$row['introduction'].'</td></tr>';
			}
			$fee = ($row['expected_fee'] != "") ? $row['expected_fee'] . ' đồng/ca' : 'Chưa có thông tin';
			$info .= '<table width="100%">
														<tr><td colspan="3" style="color: blue; background: #E8F3FD;"><h2>ID:  MCT_' . $row['giasu_id'] . '</h2> </td><tr>
														<tr><td rowspan="5" width=110px>'.$avatarLink.'</td>' .
														'<td><b>Họ tên:</b></td><td><b>' . $row['firstname'] . ' ' . $row['lastname'] . '</b></td></tr>
														<tr><td><b>Giới tính:</b></td><td  colspan="2">' . $gender . '</td></tr>
														<tr><td><b>Trình độ:</b></td><td colspan="2">' . $level . '</td></tr>														
														<tr><td><b>Trường:</b></td><td colspan="2">' .(($row['school']=='')?"Chưa có thông tin":$row['school']). '</td></tr>
														<tr><td><b>Khoa:</b></td><td colspan="2">'.(($row['faculty']=='')?"Chưa có thông tin":$row['faculty']).'</td></tr>' .
														'<tr><td><b>Điện thoại liên hệ:</b></td><td colspan="2"><b>'.$phone.'</b></td></tr>'.
															'<tr><td><b>Mức lương:</b></td><td colspan="2">'.$fee.'</td></tr>' .
																'<tr><td><b>Nhận dạy lớp:</b></td><td colspan="2">' . $className . '</td></tr>'
														 .	'<tr><td><b>Ca dạy:</b></td><td colspan="2">' . $sessionName . '</td></tr>'.														 
																'<tr><td><b>Tại khu vực:</b></td><td colspan="2">' . $locationName . '</td></tr>'
															.$introduction.'
														<tr><td><b>Đánh giá:</b></td><td style="color: blue" colspan="2"><b>' . $validated . '</b></td></tr>
														<tr><td colspan="3"  style="background: #E8F3FD;"><center><a href="#" onclick="history.go(-1);" style="color:blue;">Quay lại</a></center></td></tr>
													</table>';

		
		$this->assign('infor', $info);
		$html = $this->output();
		return $html;
	}
}