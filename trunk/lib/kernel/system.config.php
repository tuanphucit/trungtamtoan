<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
require_once CGS_SYSTEM_PATH.'system.handling.php';

if (function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Dhaka');// UTC/GMT
if(ini_get('short_open_tag')!="1") ini_set('short_open_tag',"1");
ini_set('default_charset',"UTF-8");

require_once CGS_SYSTEM_PATH.'cgs.exception.php';
require_once CGS_SYSTEM_PATH.'cgs.func.php';
require_once CGS_SYSTEM_PATH.'global.class.php';
require_once CGS_SYSTEM_PATH.'system.log.php';
require_once CGS_SYSTEM_PATH.'system.page.php';
require_once CGS_SYSTEM_PATH.'system.file.php';
require_once CGS_SYSTEM_PATH.'system.skin.php';
require_once CGS_SYSTEM_PATH.'system.layout.php';
require_once CGS_SYSTEM_PATH.'cgs.class.php';
require_once CGS_SYSTEM_PATH.'system.html.form.build.php';
require_once CGS_SYSTEM_PATH.'system.forms.view.php';

/**
 * Filter INPUT REQUEST DATA
 */
Page::filterRequest();

/**
 * set Config Connection Database
 */
CgsGlobal::setConnDB();

/**
 * get and set Setting-config
 */
require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
$dbSetting = new DbSettingPeer();
CgsGlobal::set('config_setting', $dbSetting->getConfig());

/**
 * Gọi hàm sử lý template
 * @var	unknown_type
 */
$skn = new Skin();
function &skn(){
	global $skn;
	return $skn;
}


?>