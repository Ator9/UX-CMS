<?php
require(__DIR__.'/../common/init.php');
header('Content-Type: application/javascript');

echo getExtAllClasses();
?>
Ext.define('ExtCache', { extend: 'Ext.Base' });
