<?php
defined ( 'IN_CGS' ) or die ( 'Restricted Access' );
$host = 'localhost';
//$host = 'trungtamtoan.com';
return array (	
	'default' => 'db', 
	'database' => array (
		'db' => array (
			'username' => 'danndmc', 
			'password' => 'c3bX99tA5b1', 
			'host' => 'mysql-server',
			'port' => '12096', 
			'dbname' => 'danndmc',
			'prefix' => '',
			'object' => 'MySQL'),
		'mc' => array (
			'username' => 'root', 
			'password' => '', 
			'host' => $host,
			'port' => '3306', 
			'dbname' => 'cgs_platform',
			'prefix' => '',
			'object' => 'MySQL'),
		));