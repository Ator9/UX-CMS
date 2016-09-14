<!doctype html>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('resources/lib/bootstrap/css/bootstrap.min.css'); ?>">
<?php if(is_file(__DIR__.'/../resources/styles.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/styles.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('resources/lib/jquery/jquery-1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo staticLoader('resources/lib/bootstrap/js/bootstrap.min.js'); ?>"></script>
