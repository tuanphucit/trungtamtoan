<?php
define('IN_CGS', TRUE);
define('CGS_DEBUG', FALSE);
require_once 'define.php';
require_once CGS_CONFIG.'config.php';
require_once CGS_SYSTEM_PATH . 'cgs.ajax.process.php';

//$cgs = new Cgs();
//$cgs->dispatchAjax();
Cgs::dispatchAjax();