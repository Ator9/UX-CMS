<!DOCTYPE html>
<html>
<head>
<title><? echo $GLOBALS['admin']['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/extjs/resources/css/ext-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/styles.default.css'); ?>">
<? if(is_file(dirname(__FILE__).'/../resources/styles.css')) { ?>
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/styles.css'); ?>">
<? } ?>
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/ext-all.js'); ?>"></script>
<? if($aSession->get('locale') != 'en') { ?>
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/locale/ext-lang-'.$aSession->get('locale').'.js'); ?>"></script>
<? } ?>
