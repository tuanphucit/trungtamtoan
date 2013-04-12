<?php
ob_start();

define('IN_CGS', TRUE);
define('CGS_DEBUG', FALSE);
require_once 'define.php';
require_once CGS_CONFIG.'config.php';
$cgs = new Cgs();
$cgs->dispatch();
//Cgs::dispatch();