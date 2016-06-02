<?php
// Database & Site Config:
if(is_file(__DIR__.'/config.php')) require(__DIR__.'/config.php');
else require(__DIR__.'/config.default.php');

// Functions:
require(__DIR__.'/functions_admin.php');
require(__DIR__.'/functions_core.php');
if(is_file(__DIR__.'/functions.php')) require(__DIR__.'/functions.php'); 

// Paths:
if(!isset($custom_dir))
{
    $custom_dir = explode('/', $_SERVER['PHP_SELF']);
    $custom_dir = (LOCAL) ? '/'.next($custom_dir) : '';
}
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

define('HOST'     , $protocol.'://'.$_SERVER['HTTP_HOST'].$custom_dir);
define('ADMIN'    , HOST.'/admin');
define('MODULES'  , HOST.'/modules');
define('RESOURCES', HOST.'/resources');
define('UPLOAD'   , HOST.'/upload');

define('ROOT'     , str_replace(DIRECTORY_SEPARATOR.'includes', '', __DIR__));
define('COMMON'   , ROOT.'/common');
define('INCLUDES' , ROOT.'/includes');
