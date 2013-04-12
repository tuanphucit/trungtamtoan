<?php
defined('IN_CGS') or die('Restricted Access');

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$zoneId = Page :: getRequest('zone', 'int', '', 'POST');
		Page::setRequest('zone', $zoneId, 'SESSION');
		echo json_encode(array (
			"ok" =>	true
		));
		return;
	}
}