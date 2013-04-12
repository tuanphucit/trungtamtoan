<?php
defined('IN_CGS') or die('Restricted Access');

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page :: getRequest('act', 'str', '', 'POST');
		switch ($act) {

			case 'next' :
				$this->nextPage();
				break;

			default :
				$this->response('NOT_TODO');
				break;
		}
	}

	function nextPage() {
		$zoneID = Page :: getRequest('zone', 'str', '0', 'SESSION');
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultHocsinhPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
		$objHocsinh = new DefaultHocsinhPeer();
		$objClass = new DefaultClassPeer();
		$objLocation = new DefaultLocationPeer();

		$currentID = Page :: getRequest('currentID', 'str', '', 'POST');
		$nextID = $currentID +5;

		$total = $objHocsinh->count("hocsinh", "`status` = 1 AND `provinceID` = ".$zoneID, "hocsinh_id");
		$data = $objHocsinh->select('hocsinh', 'hocsinh_id,  class_id, location_id, updatetime', '`status` = 1 AND `provinceID` = '.$zoneID, 'updatetime DESC', $currentID . ',5');
		$html = "";
		if ($data && ($total >= $currentID)) {
			foreach ($data as $row) {
				$className = "";
				if ($row['class_id'] != '') {
					$className = $objClass->selectOne('class', 'name', "class_id = " . $row['class_id']);
				}

				$locationName = "";
				if ($row['location_id'] != '') {
					$locationName = $objLocation->selectOne('location', 'name', "`location_id` =" . $row['location_id']);
				}
				
				$updateTime = date('H:i | d/m/Y',strtotime ($row['updatetime']));
				$link =  Page::link(array('id'=>$row['hocsinh_id']),'ClassDetail','mc_web');
				$html .= '<table width="100%">
					<tr style="background: #E8F3FD;"><td style="color: blue;"><h2>Mã lớp học:  MCH_'.$row['hocsinh_id'].'</h2> </td><td style="text-align: left"  width="190px"><b>Đăng lúc: '.$updateTime.'</b></td><tr>
					<tr><td>Cần tìm gia sư dạy <b style="color:#6633FF;">'.$className['name'].'</b> tại khu vực <b style="color:green;">'.$locationName['name'].'</b></td><td style="text-align:left; "><a style="color: blue;" href="'.$link.'">Chi tiết</a></td><tr>		
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