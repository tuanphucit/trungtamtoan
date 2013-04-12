<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
session_start();
//define('DS', DIRECTORY_SEPARATOR);
define('DS', '/');
define('CGS_ROOT_PATH',	realpath(dirname(__FILE__)).DS);
define('CGS_CONFIG', CGS_ROOT_PATH.'config'.DS);
//define('CGS_URL', 'http://localhost/cgs_v1.0_20111215/');
define('CGS_URL', 'http://'.$_SERVER['SERVER_NAME']
					. ($_SERVER['SERVER_PORT']=='80'?'':$_SERVER['SERVER_PORT'])
					. implode(DS, explode(DS, $_SERVER['PHP_SELF'], -1)) . DS);


//////////////
define('DEFAULT_PORTAL', 'mc_web');
define('DEFAULT_PAGE', 'index');
define('DEFAULT_TITLE', 'CGS.,JSC');

//Thu vien he thong
define('CGS_LIB_PATH', CGS_ROOT_PATH.'lib'.DS);
define('CGS_SYSTEM_PATH', CGS_ROOT_PATH.'lib'.DS.'kernel'.DS);
define('CGS_MODEL_PATH', CGS_ROOT_PATH.'lib'.DS.'model'.DS);
define('CGS_UI_PATH', CGS_ROOT_PATH.'lib'.DS.'ui'.DS);
define('CGS_CODEGEN_PATH', CGS_ROOT_PATH.'lib'.DS.'codegen'.DS);

// Templates
define('CGS_MODULES_PATH', 'modules'.DS);
define('CGS_LAYOUT_PATH', 'webskins'.DS.'layouts'.DS);
define('CGS_WEBSKINS_PATH', 'webskins'.DS);
define('CGS_JS_SYSTEM_PATH', 'webskins/js/');
define('CGS_TPL_PATH', 'webskins'.DS.'templates'.DS);
define('CGS_LANG_PATH', 'webskins'.DS.'languages'.DS);
define('CGS_AVATAR_PATH', 'data'.DS.'avatar'.DS);
define('CGS_DOCUMENT_PATH', 'data'.DS.'document'.DS);

define('CGS_DEBUG_AJAX',TRUE);

define('CGS_CACHE', TRUE);
define('CGS_CACHE_PATH', 'cache'.DS);
define('CGS_URL_REWRITE', TRUE);
define('CGS_URL_EXTENTION', '.html');
define('CGS_LOG', TRUE);
define('CGS_LOG_PATH', 'log'.DS);
define('CGS_LOG_ERROR', TRUE);
define('CGS_LOG_SEND', 'admin@trungtamtoan.com');
define('CGS_MOBILE', '0979.603.340');
define('CGS_LOG_SLOW_TIME', 0.5);

define('SHOW_LAYOUT_HINT',TRUE);
define('SHOW_BLOCK_HINT',TRUE);


// interface
define('CGS_XML_DATAS', 'webskins'.DS.'xml_datas'.DS);
define('CGS_DATA_STATICS', 'data'.DS);
define('CGS_IMAGES_DATA',CGS_DATA_STATICS.'images'.DS);
define('CGS_IMAGES_THUMB',CGS_IMAGES_DATA.'thumb'.DS);
define('SYSTEM_LOGIN_IS_AUTH', FALSE);	//FALSE: login by form, TRUE: login by authentication


define ( 'CACHE_DEFAULT_EXPIRE', 60 );
define ( 'CACHE_SQL_EXPIRE', 60 );
define ( 'CACHE_URI_EXPIRE', 60 );
define ( 'CACHE_FILE_PATH', CGS_DATA_STATICS. 'cache' . DS );
define ( 'CACHE_FILE_EXTENSION', '.cache' );