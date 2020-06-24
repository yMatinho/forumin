<?php
session_start();
$autoload = function($load) {
	include('classes/'.$load.'.php');
};
spl_autoload_register($autoload);
define('INCLUDE_PATH', 'http://localhost/sites-novos/Forumin/');
define('HOST', 'localhost');
define('DATABASE', 'new_forumin');
define('USER', 'root');
define('PASSWORD', '');
?>