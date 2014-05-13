<?php
require(dirname(__FILE__).'/../../includes/init.php');

if(file_exists(dirname(__FILE__).'/../config.php')) require(dirname(__FILE__).'/../config.php');
else require(dirname(__FILE__).'/../config.default.php');

// Admin Session:
$aSession = new Session('admin');

// Admin Lang:
if(!$aSession->exists('locale')) $aSession->set('locale', key($GLOBALS['admin']['locale']));
$lang = new Lang($aSession->get('locale'));
$lang->load(ROOT.'/admin/locale/'.$lang->lang.'_core.csv');
$lang->load(ROOT.'/admin/locale/'.$lang->lang.'.csv');

// Login check:
if($aSession->exists('adminData'))
{
    // Stores admin data glabally:
    $GLOBALS['admin']['data'] = $aSession->get('adminData');

    // Stores partners data glabally:
    $partnersDB = new adminsPartnersAdmins;
    $GLOBALS['admin']['data']['partners']  = $partnersDB->getPartnersByAdmin();
    $GLOBALS['admin']['data']['partnerID'] = $aSession->get('partnerID');
}
elseif(basename($_SERVER['PHP_SELF']) != 'login.php')
{
    header('Location: '.ADMIN.'/login.php');
    exit;
}

// Admin Log:
$log = new adminsLog;

// Ajax class loader:
if(isset($_GET['_class']) && basename($_SERVER['PHP_SELF']) != 'login.php')
{
    $obj = new $_GET['_class'];
    if(isset($_GET['_method'])) $obj->$_GET['_method']();
    exit;
}

// http://code.google.com/speed/page-speed/docs/rendering.html#SpecifyCharsetEarly
header('Content-type: text/html; charset=UTF-8');


