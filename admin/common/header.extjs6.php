<!doctype html>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs6/classic/theme-classic/resources/theme-classic-all.css'); ?>">
<?php if(isset($GLOBALS['admin']['header_charts']) && $GLOBALS['admin']['header_charts'] == true) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs6/charts/classic/classic/resources/charts-all.css'); ?>">
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.default.css'); ?>">
<?php if(is_file(__DIR__.'/../resources/extjs.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs6/ext-all'.((LOCAL)?'-debug':'').'.js'); ?>"></script>
<?php if(isset($GLOBALS['admin']['header_charts']) && $GLOBALS['admin']['header_charts'] == true) { ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs6/charts/classic/charts'.((LOCAL)?'-debug':'').'.js'); ?>"></script>
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs6/classic/locale/locale-'.$aSession->get('locale').'.js'); ?>"></script>
