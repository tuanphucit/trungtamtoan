<?php
class CgsDebugView {
	private $setting = array();
	function execute() {
  		if (CGS_DEBUG && self::getSetting('DEBUG_ENABLE')){
	  		echo '<div id="system-debug" style="text-align:left;">';
	  		if (self::getSetting('DEBUG_ERROR'))
	  			echo self::printError();
	  		if (self::getSetting('DEBUG_GENERAL_INFORMATION'))
	  			echo self::printGeneral();
	  		if (self::getSetting('DEBUG_REQUEST'))
	  			echo self::printRequest();
	  		if (self::getSetting('DEBUG_LAYOUT_POSITION_FLUGIN'))
	  			echo self::printLayout();
	  		if (self::getSetting('DEBUG_SQL_QUERY'))
	  			echo self::printSql();
	  		if (self::getSetting('DEBUG_VAR'))
	  			echo self::printVar();
	  		if (self::getSetting('DEBUG_INCLUDES_FILE'))
	  			echo self::printInc();
	  		
	  		echo '</div>';
	  	}
	}
	
	function printSql() {
		
	}
}