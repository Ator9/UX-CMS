<!DOCTYPE html>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs6/classic/theme-classic/resources/theme-classic-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.default.css'); ?>">
<?php if(is_file(__DIR__.'/../resources/extjs.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs6/ext-all'.((LOCAL)?'-debug':'').'.js'); ?>"></script>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs6/classic/locale/locale-'.$aSession->get('locale').'.js'); ?>"></script>
