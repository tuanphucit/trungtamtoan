<?php
class MCwebNewClass extends CgsModules
{
	function __construct(){
		
	}
	
	function execute(){	
		$this->assign('index', Page::link(null,'index','mc_web'));		
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultHocsinhPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultClassPeer.php';
		require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultLocationPeer.php';
		$objHocsinh = new DefaultHocsinhPeer();
		$objClass = new DefaultClassPeer();
		$objLocation = new DefaultLocationPeer();
		$data = $objHocsinh->select('hocsinh', 'hocsinh_id,  class_id, location_id, updatetime', '`status` = 1', 'updatetime DESC', '0,5');
		$newClass = '';
		if ($data) {
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
				$newClass .= '	<li class="newclass"><h3><a href="'.$link.'">'.$className['name'].' <i>(KV '.$locationName['name'].')</i></a></h3></li>';

			}		

		}else{
			$newClass = '<li class="newclass"><h3>Đang cập nhập</h3></li>';
		}
		$avatarLink = Page::displayImage(CGS_AVATAR_PATH."new.gif","avatar","25","45");
		$this->assign('newImage',$avatarLink);
		$this->assign('newClass',$newClass);
		
		if(Page::isLogIn()){
			$giasu = Page :: getRequest('username', 'str', NULL, 'SESSION');
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
			$giasuObj = new DefaultGiasuPeer();	
			$giasuData = $giasuObj->selectOne("giasu", 'gender, teach_classes, level, teach_locations', "`username` = '{$giasu}'");		
			if($giasuData){
				$stringLocations = $giasuData['teach_locations'];
				$stringClasses = $giasuData['teach_classes'];
				$stringGender = $giasuData['gender'].', 3';
				$level = $giasuData['level'];
				$dataSuggest = '';
				if($stringLocations && $stringClasses){
					$dataSuggest = $objHocsinh->select('hocsinh', 'hocsinh_id,  class_id, location_id, updatetime',
					 "status = 0 AND location_id IN({$stringLocations}) " .
					 " AND class_id IN({$stringClasses}) " .
					 "AND expected_gender IN({$stringGender}) " .
					 "AND expected_level = {$level}", 'updatetime DESC', '0,5');					
				}else{
					if($stringLocations){
						$dataSuggest = $objHocsinh->select('hocsinh', 'hocsinh_id,  class_id, location_id, updatetime',
						 "status = 0 AND location_id IN({$stringLocations}) " .					 
					 	"AND expected_gender IN({$stringGender}) " .
					 	"AND expected_level = {$level}", 'updatetime DESC', '0,5');
					}
					
					elseif($stringClasses){
						$dataSuggest = $objHocsinh->select('hocsinh', 'hocsinh_id,  class_id, location_id, updatetime',
						 "status = 0 AND class_id IN({$stringClasses}) " .					 
					 	"AND expected_gender IN({$stringGender}) " .
					 	"AND expected_level = {$level}", 'updatetime DESC', '0,5');
					}					
				}				
			}	
			
			$htmlSuggest = '';
			if ($dataSuggest) {
				foreach ($dataSuggest as $row) {
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
					$htmlSuggest .= '	<li class="newclass"><h3><a href="'.$link.'">'.$className['name'].' <i>(KV '.$locationName['name'].')</i></a></h3></li>';
	
				}
			}else{
				$htmlSuggest = '<li class="newclass"><h3>Không có gợi ý phù hợp</h3></li>';
			}
			
		}else{
			$htmlSuggest = '<li class="newclass"><h3>Đăng nhập để được gợi ý</h3></li>';
		}
		
		$promotion = Page::displayImage(CGS_IMAGES_DATA.'promotion'.DS.'ads1.png',"promotion1","250","210");
		$this->assign('promotion',$promotion);
		$this->assign('htmlSuggest',$htmlSuggest);
		$this->tpl(Page::pathTpl().'MCwebNewClass.htm');
		return $this->output();
	}
}