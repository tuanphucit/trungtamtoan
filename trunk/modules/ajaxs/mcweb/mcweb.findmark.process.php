<?php
session_start ( 1 );
defined('IN_CGS') or die('Restricted Access');
require_once CGS_LIB_PATH.'crawls/mark.php';

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page :: getRequest('action', 'str', '', 'POST');	
switch ($act) {
	case 'markfind' :
		$university_code = Page :: getRequest('matruong', 'str', '', 'POST');	
		$searchType = Page :: getRequest('searchType', 'str', '', 'POST');	
		$raw_name_find = Page :: getRequest('tensbd', 'str', '', 'POST');	
		$name_find = str_replace ( " ", "+", trim($raw_name_find) );
		if($searchType == 'sbd'){
			$sobaodanh = $raw_name_find;
			$hoten = '';
		}else{
			$sobaodanh = '';
			$hoten = $name_find;
		}
		
		$url = 'http://thi.moet.gov.vn/index.php?dulieu=dulieu12.dbo.dulieu&'.
					'truong='.$university_code.'&sobaodanh='.$sobaodanh.
					'&hoten='.$hoten.'&page=1.7&script=index';
					
		$objMark = new Mark ();
		$datas = $objMark->getMark ( $url );
		$html = array ();
		
		if (! $university_code) {
			$html [] = "<tr><td > Hãy chọn trường cần tra điểm</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		} elseif (! $raw_name_find) {
			$msg = $searchType=='sbd'?'số báo danh':'tên';
			$html [] = "<tr><td > Bạn chưa nhập ".$msg."</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		}
		
		if (@strtolower ( $datas ) == "couldn't connect to host") {
			$html [] = "<tr><td > Lỗi kết nối, xin thử lại sau.</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		}
		
		if ($datas ) {
			$html [] = $datas;
		} else {
			$msg = $searchType=='sbd'?'số báo danh':'tên';
			$html [] = "<tr><td > Không tìm thấy người có ".$msg.": ".$raw_name_find."</td></tr>";
		}
		echo json_encode ( implode ( '', $html ) );
		break;
	
	
	case 'standardmark' :
		$university_code = Page :: getRequest( 'university_code', 'str', '','POST' );
		$year = Page :: getRequest('year', 'str', '','POST' );
		
		$aryUniversity = university::getAll ( $university_code );
		$url = str_replace ( ".html", "_$year.html", $aryUniversity [0] ['standard_mark_link'] );
		$url = str_replace ( "http://diemthi.24h.com.vn", "http://diemthi3.24h.com.vn", $url );

		$objMark = new Mark ();
		$datas = $objMark->getStandardMark ( $url );
		$html = array ();
		
		if (! $university_code) {
			$html [] = "<tr><td > Hãy chọn trường cần tra điểm.</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		} elseif (! $year) {
			$html [] = "<tr><td > Hãy chọn năm.</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		}
		
		if (@strtolower ( $datas ) == "couldn't connect to host") {
			$html [] = "<tr><td > Lỗi kết nối, xin thử lại sau.</td></tr>";
			echo json_encode ( implode ( ' ', $html ) );
			break;
		}
		
		if ($datas) {
			$html [] = '<tr class="header">
					<td class="DSTT_Header_bg">STT</td>
					<td class="DSTT_Header_bg">Mã ngành</td>
					<td class="DSTT_Header_bg" style="width:200px">Tên ngành</td>
					<td class="DSTT_Header_bg">Khối thi</td>
					<td class="DSTT_Header_bg">Điểm chuẩn</td>
					<td class="DSTT_Header_bg">Ghi chú</td>
				   </tr>';
			foreach ( $datas as $data ) {
				$html [] = '<tr>
					<td >' . $data ['number'] . '</td>
					<td >' . $data ['faculty _code'] . '</td>
					<td >' . $data ['faculty _name'] . '</td>
					<td >' . $data ['group'] . '</td>
					<td >' . $data ['standard_mark'] . '</td>
					<td >' . $data ['description'] . '</td>
				   </tr>';
			}
		} else {
			$html [] = "<tr><td > Chưa có điểm chuẩn cho trường này </td></tr>";
		}
		echo json_encode ( implode ( '', $html ) );
		break;

		}
	}
}	
?>
