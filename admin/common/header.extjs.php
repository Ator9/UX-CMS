<? echo $GLOBALS['admin']['doctype']; ?>
<html>
<head>
<title><? echo $GLOBALS['admin']['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/extjs/resources/css/ext-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/styles_core.css'); ?>">
<? if(file_exists(dirname(__FILE__).'/../resources/styles.css')) { ?>
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/styles.css'); ?>">
<? } ?>
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/ext-all'.((LOCAL)?'-dev':'').'.js'); ?>"></script>
<? if($aSession->get('locale') != 'en') { ?>
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/locale/ext-lang-'.$aSession->get('locale').'.js'); ?>"></script>
<? } ?>
