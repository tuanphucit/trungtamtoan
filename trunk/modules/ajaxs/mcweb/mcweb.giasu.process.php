<?php
defined('IN_CGS') or die('Restricted Access');

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page :: getRequest('act', 'str', '', 'POST');
		
		switch ($act) {

			case 'validate' :
				$this->validateProcess();
				break;

			case 'next' :
				$this->nextPage();
				break;

			default :
				$this->response('NOT_TODO');
				break;
		}
	}

	function validateProcess() {
		$username = Page :: getRequest('username', 'str', '', 'POST');
		if ($username) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
			$dbObj = new DefaultGiasuPeer();
			$user = $dbObj->selectOne("giasu", 'username', "`username`='{$username}'");

			if ($user || $username == "") {
				echo json_encode(array (
					"ok" => true,
					"notice" => "username này đã tồn tại"
				));
				return;
			}
		}
		echo json_encode(array (
			"ok" => false,
			"notice" => "username này có thể dùng"
		));
		return;
	}

	function nextPage() {
		$zoneID = Page :: getRequest('zone', 'str', '0', 'SESSION');
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
		$objGiasu = new DefaultGiasuPeer();
		$objClass = new DefaultClassPeer();
		$objLocation = new DefaultLocationPeer();
		
		$type = Page :: getRequest('type', 'str', '', 'POST');
		$validate = '';
		if($type == 'type1'){
			$validate = 1;
		}elseif($type == 'type0'){
			$validate = 0;
		}		
		$currentID = Page :: getRequest('currentID', 'str', '', 'POST');
		$nextID = $currentID + 5;

		$total = $objGiasu->count("giasu", "`status` = 1 AND `validate` = ".$validate." AND `provinceID` = ".$zoneID, "giasu_id");
		$data = $objGiasu->select('giasu', 'giasu_id, firstname, lastname, gender, level, updatetime', "`status` = 1 AND `validate` = ".$validate." AND `provinceID` = ".$zoneID, 'updatetime DESC', $currentID . ',5');
		$html = "";
		if ($data && ($total >= $currentID)) {
			$arrayLevel = array (
				"0" => '<span style="color:#0099FF;">Cao đẳng</span>',
				'1' => '<span style="color:#0000FF;">Đại học</span>',
				'2' => '<span style="color:#0066CC;">Đã ra trường</span>',
				'3' => '<span style="color:#006699;">Giáo viên</span>'
			);

			foreach ($data as $row) {
				$level = "";
				foreach ($arrayLevel as $key => $value) {
					if ($row['level'] == $key) {
						$level = $value;
						break;
					}
				}
				
			$gender = ($row['gender'] == 1) ? 'Anh' : 'Chị';
			$updateTime = date('H:i | d/m/Y', strtotime($row['updatetime']));
			$link = Page :: link(array (
				'id' => $row['giasu_id']
			), 'TeacherDetail', 'mc_web');
			$html .= '<table width="100%">
							<tr style="background: #E8F3FD;"><td style="color: blue;"><h2>Mã gia sư:  MCT_' . $row['giasu_id'] . '</h2> </td><td style="text-align: left"  width="190px"><b>Đăng lúc: ' . $updateTime . '</b></td><tr>
							<tr><td>' . $gender . ' <b>' . $row['firstname'] . ' ' . $row['lastname'] . '</b> ,trình độ <b>'.$level.'</b></td><td style="text-align:left; "><a style="color: blue;" href="' . $link . '">Chi tiết</a></td><tr>		
							</table>';

			}

			echo json_encode(array (
				"ok" => true,
				"notice" => $html,
				"next" => '<center><a rel="' . $nextID . '" style="color:blue;">Tiếp theo</a></center>'
			));
			return;
		} else {
			echo json_encode(array (
				"ok" => false,
				"next" => '<center><a rel="-1" style="color:blue;">Hết</a></center>'
			));
			return;

		}
	}
}