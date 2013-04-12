<?php
defined('IN_CGS') or die('Restricted Access');

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page :: getRequest('act', 'str', '', 'POST');
		switch ($act) {
			case 'add' :
				$this->addProcess();
				break;

			case 'load' :
				$this->loadProcess();
				break;
				
			default :
				$this->response('NOT_TODO');
				break;
		}
	}

	function loadProcess() {
		$url = Page :: getRequest('urlLink', 'str', '', 'POST');
		if ($url) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultCommentPeer.php';
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultGiasuPeer.php';
			$dbObj = new DefaultCommentPeer();
			$dbGiasu = new DefaultGiasuPeer();
			$comments = $dbObj->select('comment','*',"`page_url` = '{$url}' AND `status` = 1","comment_time DESC");
			
			$htmComment = '';
			if($comments){
				$htmComment = '<table>';
				foreach($comments as $comment){
					$user = $comment['username'];
					$ava = $dbGiasu->selectOne('giasu','avatar, giasu_id',"`username` = '{$user}'");
					$avatar = ($ava['avatar']!=NULL)?$ava['avatar']:"noavatar.gif";
					$avatarLink = Page::displayImage(CGS_AVATAR_PATH.'thumb'.DS.$avatar,"avatar","50","50");
					if($ava['giasu_id']){
						$linkUser = Page :: link(array ('id' => $ava['giasu_id']), 'TeacherDetail', 'mc_web');
					}else{
						$linkUser =  Page :: link(null, 'regTeach', 'mc_web');
					}
					$updateTime = date('H:i | d/m/Y', strtotime($comment['comment_time']));					
					$htmComment .= "<tr><td width=50px; rowspan='2'><a href='".$linkUser."'>".$avatarLink."</a></td>" .
							"<td class='comment_user'><b><a href='".$linkUser."'>".$comment['username']."</a></b><i>(".$updateTime.")</i></td></tr>" .
							"<tr><td class='comment_content'>".$comment['content']."</td></tr>";
				}
				$htmComment .= '</table>';
			} 
		}
		echo json_encode(array (
			"notice" => "success",
			"content" => $htmComment
		));
		return;
	}

	function addProcess() {
		$username = Page :: getRequest('username', 'str', '', 'SESSION');
		$currentLink = Page :: getRequest('currentLink', 'str', '', 'POST');
		$fullname = Page :: getRequest('fullname', 'str', '', 'POST');
		$yourcomment = Page :: getRequest('yourcomment', 'str', '', 'POST');
		
		$data['page_url'] = $currentLink;
		$data['username'] = $username==''?$fullname:$username;
		$data['content'] = $yourcomment;					
		$data['comment_time'] = current();
		if ($data) {
			require_once CGS_MODEL_PATH . 'default' . DS . 'DefaultCommentPeer.php';
			$dbObj = new DefaultCommentPeer();			
			$id = $dbObj->insert("comment",$data);
			if ($id) {
				echo json_encode(array (
					"notice" => "success"
				));
				return;
			}
		}
		echo json_encode(array (
			"notice" => "not success"
		));
		return;
	}

}