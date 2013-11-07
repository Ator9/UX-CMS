<?php
// Database & Site Config:
if(file_exists(dirname(__FILE__).'/config.php')) require(dirname(__FILE__).'/config.php');
else require(dirname(__FILE__).'/config.default.php');

// Functions:
require(dirname(__FILE__).'/functions_admin.php');
require(dirname(__FILE__).'/functions_core.php');
if(file_exists(dirname(__FILE__).'/functions.php')) require(dirname(__FILE__).'/functions.php'); 

// Paths:
$local_dir = (LOCAL) ? '/'.next(explode('/', $_SERVER['PHP_SELF'])) : '';
$protocol  = ($_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

define('HOST'     , $protocol.'://'.$_SERVER['HTTP_HOST'].$local_dir);
define('ROOT'     , str_replace(DIRECTORY_SEPARATOR.'includes', '', dirname(__FILE__)));
define('ADMIN'    , HOST.'/admin');
define('MODULES'  , HOST.'/modules');
define('RESOURCES', HOST.'/resources');
define('UPLOAD'   , HOST.'/upload');


