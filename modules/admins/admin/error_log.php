<?php
require(__DIR__.'/init.php');

$output = shell_exec('tac /var/www/'.$_SERVER['HTTP_HOST'].'/log/error.log');
vd(htmlentities($output));
