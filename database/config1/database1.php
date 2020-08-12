<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'production';
$query_builder = TRUE;  

$db['production'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'globaltech',
	'password' => 'Dw1Sur@2020-sql=root&J4nG4nd18uk4nt4rd1C1dUk+password>Gl0bp-sql',
	'database' => 'elearning',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);