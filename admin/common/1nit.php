<?php
require(dirname(__FILE__).'/../../includes/1nit.php');

if(file_exists(dirname(__FILE__).'/../config.php')) require(dirname(__FILE__).'/../config.php');
else require(dirname(__FILE__).'/../config.default.php');

// Admin Session:
$aSession = new Session('admin');

// Login check:
if(!$aSession->exists('adminData') && basename($_SERVER['PHP_SELF']) != 'login.php')
{
    header('Location: '.ADMIN.'/login.php');
    exit;
}

// Stores all admin data glabally:
$GLOBALS['admin']['data'] = $aSession->get('adminData');

// ------------------------------------------------------------------------------

// Admin Log:
$aLog = new AdminsLog;

// Ajax class loader:
if(isset($_GET['_class']))
{
	$db = new $_GET['_class'];
	if(isset($_GET['_method'])) $db->$_GET['_method']();
	exit;
}

// http://code.google.com/speed/page-speed/docs/rendering.html#SpecifyCharsetEarly
header('Content-type: text/html; charset=UTF-8');
