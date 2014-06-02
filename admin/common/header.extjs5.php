<!DOCTYPE html>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs5/packages/ext-theme-classic/build/resources/ext-theme-classic-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/styles.default.css'); ?>">
<?php if(is_file(dirname(__FILE__).'/../resources/styles.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/styles.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs5/ext-all'.((LOCAL)?'-debug':'').'.js'); ?>"></script>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs5/packages/ext-locale/build/ext-locale-'.$aSession->get('locale').'.js'); ?>"></script>
