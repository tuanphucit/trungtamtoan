<?php 
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

/**
 * default config
 */
global $system_default;
$system_default = array();
$system_default['layout'] = 'master_system.htm';
$system_default['modules'] = array(
	'header' => array('system/SystemPermission.php','system/SystemHeader.php'),
	'navigation' => array('system/SystemNavigation.php'),
	'pathway' => array('system/SystemPathway.php'),
	'side' => array('system/SystemSide.php'),
	'center' => array(),
	'footer' => array('system/SystemFooter.php'),
);

//================
/**
 * pages config
 */
global $system_page;
$system_page = array();

// Login
$system_page['login']['layout'] = 'master_system_login.htm';
$system_page['login']['modules'] = array(
	'center' => array('system/SystemLogin.php'),
);
// Logout
$system_page['logout']['layout'] = 'master_system_login.htm';
$system_page['logout']['modules'] = array(
	'center' => array('system/SystemLogout.php'),
);

// main
$system_page['main']['layout'] = 'master_system.htm';
$system_page['main']['modules'] =  $system_default['modules'];
$system_page['main']['modules']['center'][0] = 'system/SysMain.php';

// portal
$system_page['portal']['layout'] = 'master_system.htm';
$system_page['portal']['modules'] =  $system_default['modules'];
$system_page['portal']['modules']['center'][0] = 'system/SystemPortalAdd.php';
$system_page['portal']['modules']['center'][1] = 'system/SystemPortal.php';

// portal
$system_page['portal_edit']['layout'] = 'master_system.htm';
$system_page['portal_edit']['modules'] =  $system_default['modules'];
$system_page['portal_edit']['modules']['center'][0] = 'system/SystemPortalEdit.php';
$system_page['portal_edit']['modules']['center'][1] = 'system/SystemPortal.php';
/////////////////////////////

// page
$system_page['page']['layout'] = 'master_system.htm';
$system_page['page']['modules'] =  $system_default['modules'];
$system_page['page']['modules']['center'][0] = 'system/SystemPageAdd.php';
$system_page['page']['modules']['center'][1] = 'system/SystemPage.php';

// page_edit
$system_page['page_edit']['layout'] = 'master_system.htm';
$system_page['page_edit']['modules'] =  $system_default['modules'];
$system_page['page_edit']['modules']['center'][0] = 'system/SystemPageEdit.php';
//$system_page['page_edit']['modules']['center'][1] = 'system/SystemPage.php';

// layout
$system_page['layout']['layout'] = 'master_system.htm';
$system_page['layout']['modules'] =  $system_default['modules'];
$system_page['layout']['modules']['center'][0] = 'system/SystemLayouts.php';

// module
$system_page['module']['layout'] = 'master_system.htm';
$system_page['module']['modules'] =  $system_default['modules'];
$system_page['module']['modules']['center'][0] = 'system/SystemModule.php';

// setting
$system_page['setting']['layout'] = 'master_system.htm';
$system_page['setting']['modules'] =  $system_default['modules'];
$system_page['setting']['modules']['center'][0] = 'system/SystemHint.php';
$system_page['setting']['modules']['center'][1] = 'system/SystemDebug.php';
$system_page['setting']['modules']['center'][2] = 'system/SystemCache.php';
$system_page['setting']['modules']['center'][3] = 'system/SystemLog.php';
$system_page['setting']['modules']['center'][4] = 'system/SystemSetting.php';

// hint
$system_page['hint']['layout'] = 'master_system.htm';
$system_page['hint']['modules'] =  $system_default['modules'];
$system_page['hint']['modules']['center'][0] = 'system/SystemHint.php';

// debug
$system_page['debug']['layout'] = 'master_system.htm';
$system_page['debug']['modules'] =  $system_default['modules'];
$system_page['debug']['modules']['center'][0] = 'system/SystemDebug.php';

// cache
$system_page['cache']['layout'] = 'master_system.htm';
$system_page['cache']['modules'] =  $system_default['modules'];
$system_page['cache']['modules']['center'][0] = 'system/SystemCache.php';

// log
$system_page['log']['layout'] = 'master_system.htm';
$system_page['log']['modules'] =  $system_default['modules'];
$system_page['log']['modules']['center'][0] = 'system/SystemLog.php';

// setting public
$system_page['setting_public']['layout'] = 'master_system.htm';
$system_page['setting_public']['modules'] =  $system_default['modules'];
$system_page['setting_public']['modules']['center'][0] = 'system/SystemSetting.php';