<?php
// Create "config_admin.php" & change

// Admin title:
$GLOBALS['admin']['title'] = 'UX CMS';

// Admin favicon URL:
$GLOBALS['admin']['favicon'] = '';

// Admin login class (Default "adminsAdmin"):
$GLOBALS['admin']['class'] = 'adminsAdmin';

// Admin partners needed:
$GLOBALS['admin']['partners_enabled'] = false;

// Header (admin/common/):
$GLOBALS['admin']['header'] = 'header.extjs4.php';

// Languages (Default first position):
$GLOBALS['admin']['locale'] = array('es'=>'Español', 'en'=>'English');

// Default module (Default "admins"): 
$GLOBALS['admin']['default_module'] = 'admins';

// Custom logout redirect url (Default empty): 
$GLOBALS['admin']['logout_redirect_url'] = '';

// Buttons tree footer (2 max): 
$GLOBALS['admin']['fbar_buttons'][] = array('url' => HOST, 'text' => 'Home Page');

// IP restriction:
$GLOBALS['admin']['allowed_ips'] = array(); // Example: array('192.168.1.1', '200.55.*.*', '200.100.*.50');

// Custom javascript (admin/index.php):
$GLOBALS['admin']['custom_js'] = <<<js

js;
