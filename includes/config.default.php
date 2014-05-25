<?php
// Create "config.php" & change

// Define local/online:
if(in_array($_SERVER['HTTP_HOST'], array('localhost'))) define('LOCAL', true);
else define('LOCAL', false);

if(LOCAL)
{
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '1');
	define('DB_NAME', 'cmspro');
}
else
{
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '1');
	define('DB_NAME', 'cms');
}

// E-mail config:
define('SMTP_HOST', '');
define('SMTP_USER', '');
define('SMTP_PASS', '');
define('SMPT_PORT', 25);

// Timezone:
date_default_timezone_set('America/Argentina/Buenos_Aires');


