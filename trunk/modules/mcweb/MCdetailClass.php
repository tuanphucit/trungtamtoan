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

class MCDetailClass extends CgsModules {
	function __construct() {
	}

	function execute() {
		Page :: header('Chi tiết lớp cần gia sư');
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultHocsinhPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultSessionsPeer.php';

		$objHocsinh = new DefaultHocsinhPeer();
		$objClass = new DefaultClassPeer();
		$objLocation = new DefaultLocationPeer();
		$objSession = new DefaultSessionsPeer();

		$id = Page :: getRequest('id', 'int', 0, 'GET');
		$data = $objHocsinh->selectOne('hocsinh', 'hocsinh_id,  pupilnumber, duringtime, gender, starttime, introduction,' .
		' expected_gender, teach_sessions, introduction, expected_level, expected_fee, ' .
		' class_id, location_id, updatetime, isNeedGoodTeacher, mobile', '`status` = 1 AND `hocsinh_id` = ' .
		$id);

		$arrayGender = array (
			'0' => 'Nữ',
			'1' => 'Nam',
			'2' => 'Nam và Nữ',
			'3' => 'Nam hoặc Nữ'
		);
		
		$arrayLevel = array (
				'0' => 'Cao đẳng',
				'1' => 'Đại học',
				'2' => 'Đã ra trường',
				'3' => 'Giáo viên',
				'4' => 'Không quan trọng'
			);
			
		if ($data) {
			$mobile = ($data['isNeedGoodTeacher'] == 0)?$data['mobile']:CGS_MOBILE;
			$sessionName = "";			
			if ($data['teach_sessions'] != NULL) {
				$arraySession = $objSession->select('sessions', 'session, day', "`sessions_id` IN(" . $data['teach_sessions'] . ")");
				foreach ($arraySession as $session) {
					$sessionName .= $session['session'] . " " . $session['day'] . ", ";
				}
			}

			$className = "";
			if ($data['class_id'] != '') {
				$className = $objClass->selectOne('class', 'name', "class_id = " . $data['class_id']);
			}

			$locationName = "";
			if ($data['location_id'] != '') {
				$locationName = $objLocation->selectOne('location', 'name', "`location_id` =" . $data['location_id']);
			}
			$updateTime = date('H:i | d/m/Y', strtotime($data['updatetime']));
			$startime = ($data['starttime']=='0000-00-00 00:00:00')?'Sớm nhất':date('d/m/Y', strtotime($data['starttime']));
			
			$hocsinh_gender = "";
			foreach($arrayGender as $key => $value){
				if($data['gender'] == $key){
					$hocsinh_gender = $value;
					break;
				}
			}
			
			$giasu_gender = "";
			foreach($arrayGender as $key => $value){
				if($data['expected_gender'] == $key){
					$giasu_gender = $value;
					break;
				}
			}
			
			$level = "";
			foreach ($arrayLevel as $key => $value) {
					if ($data['expected_level'] == $key) {
						$level = $value;
						break;
					}
				}
			$fee = ($data['expected_fee']==NULL)?'thỏa thuận':$data['expected_fee'].' đồng/ca';
			$link =  Page::link(array('id'=>$data['hocsinh_id']),'ClassDetail','mc_web');
			$introduction ='';
			if($data['introduction']!=''){
				$introduction = '<tr><td><b>Thông tin khác: </b></td><td>'.$data['introduction'].'</td><tr>';
			}
			
			$goBack = Page::link(NULL,'listClass','mc_web');
			$hocsinh .= '<table width="100%">
											<tr style="background: #3399CC; "><td style="color: #FFFFFF;"><b>Mã lớp học:  MCH_' . $data['hocsinh_id'].
											'</b></td><td style="text-align: right; color: #FFFFFF;"><b>Đăng lúc: '.$updateTime.'</b>' .
											'</td><tr>
											<tr><td width="35%"><b>Lớp:</b></td><td width="80%"><b>' .$className['name']. '</b></td><tr>
											<tr><td><b>Số lượng:</b></td><td>' . $data['pupilnumber'] . '</td><tr>
											<tr><td><b>Giới tính:</b></td><td>' . $hocsinh_gender. '</td><tr>
											<tr><td><b>Khu vực:</b></td><td>' . $locationName['name'] . '</td><tr>
											<tr><td><b>Liên hệ nhận lớp:</b></td><td><b>'.$mobile.'</b></td><tr>
											<tr><td>&nbsp;</td><td>&nbsp;</td><tr>
											<tr><td colspan = "2" style="background: #E8F3FD;"><b>Yêu cầu đối với gia sư</b></td><tr>	
											<tr><td><b>Trình độ:</b></td><td>'.$level.'</td><tr>
											<tr><td><b>Giới tính: </b></td><td>'.$giasu_gender.'</td><tr>
											<tr><td><b>Ca dạy dài: </b></td><td>'.$data['duringtime'].' phút</td><tr>
											<tr><td><b>Học phí:</b></td><td>' . $fee.'</td><tr>
											<tr><td><b>Ca dạy trong tuần:</b></td><td>' . $sessionName . '</td><tr>	
											<tr><td><b>Ngày nhận lớp: </b></td><td>'.$startime.'</td><tr>' .
													$introduction.'
											<tr><td>&nbsp;</td><td>&nbsp;</td><tr>
											<tr><td colspan="2"  style="background: #E8F3FD;"><center><a href="'.$goBack.'" style="color:blue;">Quay lại</a></center></td><tr>
										</table>';
			
		}
		$this->assign('infor', $hocsinh);
		$html = $this->output();
		return $html;
	}
}