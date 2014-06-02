<?php
// http://www.sencha.com/forum/showthread.php?137309-Summary-of-lt-!DOCTYPE-gt-Recommendations
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') !== false) {
    echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
} else echo '<!DOCTYPE html>';
?>
<html>
<head>
<title><?php echo $GLOBALS['admin']['title']; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/extjs4/resources/css/ext-all.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/styles.default.css'); ?>">
<?php if(is_file(dirname(__FILE__).'/../resources/styles.css')) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo staticLoader('admin/resources/styles.css'); ?>">
<?php } ?>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs4/ext-all'.((LOCAL)?'-dev':'').'.js'); ?>"></script>
<script type="text/javascript" src="<?php echo staticLoader('admin/resources/extjs4/locale/ext-lang-'.$aSession->get('locale').'.js'); ?>"></script>
