<!DOCTYPE html>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs5/packages/ext-theme-classic/build/resources/ext-theme-classic-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.default.css'); ?>">
<?php if(is_file(__DIR__.'/../resources/extjs.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs5/ext-all'.((LOCAL)?'-debug':'').'.js'); ?>"></script>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs5/packages/ext-locale/build/ext-locale-'.$aSession->get('locale').'.js'); ?>"></script>
