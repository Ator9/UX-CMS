<? echo $GLOBALS['admin']['doctype']; ?>
<html>
<head>
<title><? echo $GLOBALS['admin']['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/extjs/resources/css/ext-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<? echo staticLoader('admin/resources/styles.css'); ?>">
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/ext-all'.((LOCAL)?'-dev':'').'.js'); ?>"></script>
<? if($session->get('locale') != 'en') { ?>
<script type="text/javascript" src="<? echo staticLoader('admin/resources/extjs/locale/ext-lang-'.$session->get('locale').'.js'); ?>"></script>
<? } ?>
