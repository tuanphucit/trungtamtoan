<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );

class AjaxProcess extends CgsAjaxProcess {
	function execute() {
		$act = Page::getRequest('act','str','','POST');
		switch ($act){
			case 'setting_public':
				$this->settingPublic();
				break;
			case 'config_hint':
				$this->configHint();
				break;
			case 'config_debug':
				$this->configDebug();
				break;
			case 'config_cache':
				$this->configCache();
				break;
			case 'config_log':
				$this->configLog();
				break;
				
			default:
				$this->response('NOT_TODO');
				break;
		}
	}
	
	function settingPublic(){
		$rewrite_url = Page::getRequest('rewrite_url','int',0,'POST');
		// get old data
		require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
		$db = new DbSettingPeer();
		$setting = $db->getConfig();
		
		$data_insert = array();
		
		$this->fillterAndUpdateProcess($setting, 'REWRITE_URL', $rewrite_url, $db, $data_insert);
		//update config setting
		if (!empty($data_insert)){
			$db->insertMulti($db->getTbl(),$data_insert);
		}
		$this->response('SUCC');
	}
	
	
	function configHint(){
		$hint_layout_enable 	= Page::getRequest('hint_layout_enable','int',0,'POST');
		$hint_layout_color 		= Page::getRequest('hint_layout_color','str','','POST');
		$hint_layout_style 		= Page::getRequest('hint_layout_style','str','','POST');
		$hint_layout_width 		= Page::getRequest('hint_layout_width','str','','POST');
		$hint_block_enable 		= Page::getRequest('hint_block_enable','int',0,'POST');
		$hint_block_color 		= Page::getRequest('hint_block_color','str','','POST');
		$hint_block_style 		= Page::getRequest('hint_block_style','str','','POST');
		$hint_block_width 		= Page::getRequest('hint_block_width','str','','POST');
		$hint_system_module_enable = Page::getRequest('hint_system_module_enable','int',0,'POST');
		
		// get old data
		require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
		$db = new DbSettingPeer();
		$setting = $db->getConfig();
		
		$data_insert = array();
		
		$this->fillterAndUpdateProcess($setting, 'HINT_LAYOUT_ENABLE', $hint_layout_enable, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_LAYOUT_COLOR', $hint_layout_color, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_LAYOUT_STYLE', $hint_layout_style, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_LAYOUT_WIDTH', $hint_layout_width, $db, $data_insert);
		
		$this->fillterAndUpdateProcess($setting, 'HINT_BLOCK_ENABLE', $hint_block_enable, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_BLOCK_COLOR', $hint_block_color, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_BLOCK_STYLE', $hint_block_style, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'HINT_BLOCK_WIDTH', $hint_block_width, $db, $data_insert);
		
		$this->fillterAndUpdateProcess($setting, 'HINT_SYSTEM_MODULE_ENABLE', $hint_system_module_enable, $db, $data_insert);
		
		//update config setting
		if (!empty($data_insert)){
			$db->insertMulti($db->getTbl(),$data_insert);
		}
		$this->response('SUCC');
	}
	
	function configDebug(){
		$debug_enable		= Page::getRequest('debug_enable','int',0,'POST');
		$debug_error 		= Page::getRequest('debug_error','int',0,'POST');
		$debug_general_information 		= Page::getRequest('debug_general_information','int',0,'POST');
		$debug_layout_position_flugin 	= Page::getRequest('debug_layout_position_flugin','int',0,'POST');
		$debug_sql_query 		= Page::getRequest('debug_sql_query','int',0,'POST');
		$debug_includes_file 	= Page::getRequest('debug_includes_file','int',0,'POST');
		$debug_var 		= Page::getRequest('debug_var','int',0,'POST');
		$debug_request 	= Page::getRequest('debug_request','int',0,'POST');
		$debug_lang 	= Page::getRequest('debug_lang','int',0,'POST');
		
		// get old data
		require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
		$db = new DbSettingPeer();
		$setting = $db->getConfig();
		
		$data_insert = array();
		
		$this->fillterAndUpdateProcess($setting, 'DEBUG_ENABLE', $debug_enable, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_ERROR', $debug_error, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_GENERAL_INFORMATION', $debug_general_information, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_LAYOUT_POSITION_FLUGIN', $debug_layout_position_flugin, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_SQL_QUERY', $debug_sql_query, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_INCLUDES_FILE', $debug_includes_file, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_VAR', $debug_var, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_REQUEST', $debug_request, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'DEBUG_LANG', $debug_lang, $db, $data_insert);
	
		//update config setting
		if (!empty($data_insert)){
			$db->insertMulti($db->getTbl(),$data_insert);
		}
		$this->response('SUCC');
	}
	
	/**
	 * @desc Config xu dung cache
	 */
	function configCache(){
		$cache_enable 	= Page::getRequest('cache_enable','int',0,'POST');
		$cache_sql 		= Page::getRequest('cache_sql','int',0,'POST');
		$cache_sql_time = Page::getRequest('cache_sql_time','int',0,'POST');
		$cache_uri 		= Page::getRequest('cache_uri','int',0,'POST');
		$cache_uri_time = Page::getRequest('cache_uri_time','int',0,'POST');
		$cache_module 		= Page::getRequest('cache_module','int',0,'POST');
		$cache_module_time 	= Page::getRequest('cache_module_time','int',0,'POST');
		$cache_js 		= Page::getRequest('cache_js','int',0,'POST');
		$cache_js_time 	= Page::getRequest('cache_js_time','int',0,'POST');
		$cache_css 		= Page::getRequest('cache_css','int',0,'POST');
		$cache_css_time = Page::getRequest('cache_css_time','int',0,'POST');
		
		// get old data
		require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
		$db = new DbSettingPeer();
		$setting = $db->getConfig();
		
		$data_insert = array();
		
		$this->fillterAndUpdateProcess($setting, 'CACHE_ENABLE', $cache_enable, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_SQL', $cache_sql, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_SQL_TIME', $cache_sql_time, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_URI', $cache_uri, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_URI_TIME', $cache_uri_time, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_MODULE', $cache_module, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_MODULE_TIME', $cache_module_time, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_JS', $cache_js, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_JS_TIME', $cache_js_time, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_CSS', $cache_css, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'CACHE_CSS_TIME', $cache_css_time, $db, $data_insert);
	
		//update config setting
		if (!empty($data_insert)){
			$db->insertMulti($db->getTbl(),$data_insert);
		}
		$this->response('SUCC');
	}
	
	/**
	 * Log file
	 */
	function configLog() {
		$log_enable 	= Page::getRequest('log_enable','int',0,'POST');
		$log_error 		= Page::getRequest('log_error','int',0,'POST');
		$log_sql 		= Page::getRequest('log_sql','int',0,'POST');
		$log_sql_view 	= Page::getRequest('log_sql_view','int',0,'POST');
		$log_sql_add 	= Page::getRequest('log_sql_add','int',0,'POST');
		$log_sql_edit 	= Page::getRequest('log_sql_edit','int',0,'POST');
		$log_sql_delete	= Page::getRequest('log_sql_delete','int',0,'POST');
		$log_sql_other 	= Page::getRequest('log_sql_other','int',0,'POST');
		$log_sql_slow 	= Page::getRequest('log_sql_slow','int',0,'POST');
		$log_sql_slow_time = Page::getRequest('log_sql_slow_time','int',0,'POST');
		
		// get old data
		require_once CGS_MODEL_PATH.'db'.DS.'DbSettingPeer.php';
		$db = new DbSettingPeer();
		$setting = $db->getConfig();
		
		$data_insert = array();
		
		$this->fillterAndUpdateProcess($setting, 'LOG_ENABLE', $log_enable, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_ERROR', $log_error, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL', $log_sql, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_VIEW', $log_sql_view, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_ADD', $log_sql_add, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_EDIT', $log_sql_edit, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_DELETE', $log_sql_delete, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_OTHER', $log_sql_other, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_SLOW', $log_sql_slow, $db, $data_insert);
		$this->fillterAndUpdateProcess($setting, 'LOG_SQL_SLOW_TIME', $log_sql_slow_time, $db, $data_insert);
	
		//update config setting
		if (!empty($data_insert)){
			$db->insertMulti($db->getTbl(),$data_insert);
		}
		$this->response('SUCC');
	}
	
	
	/**
	 * Update setting
	 * @param $data
	 * @param $key
	 * @param $val
	 * @param $db
	 * @param $data_insert
	 */
	function fillterAndUpdateProcess($setting=array(), $key='', $val=null, &$db, &$data_insert){
		$key = strtoupper($key);
		
		if (isset($setting[$key])) {
			$data_update = array(
				'name'	=> $key,
				'value' => $val
			);
			$db->update($db->getTbl(), $data_update, "name='".$key."'");
		} else {
			$data_insert[] = array(
				'name'	=> $key,
				'value' => $val
			);
		}
	}
}