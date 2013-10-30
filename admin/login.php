<?php
require(dirname(__FILE__).'/1nit.php');

// IP restriction:
checkAdminIpAccess();

// Language:
if(array_key_exists($_POST['locale'], $GLOBALS['admin']['locale'])) $aSession->set('locale', $_POST['locale']);
elseif(!$aSession->exists('locale')) $aSession->set('locale', key($GLOBALS['admin']['locale']));

if(isset($_POST['login']))
{
    $db = new Admins();
    if($db->login($_POST['name'], $_POST['pass']))
    {
        header('Location: '.ADMIN);
        exit;
    }
    $error = true;
}

if(isset($_GET['logout']))
{
    $aSession->destroy();

    header('Location: '.ADMIN.'login.php');
    exit;
}

// Check admin session - Ext.Ajax.on('requestexception'):
header('HTTP/1.1 401 Unauthorized');

require(dirname(__FILE__).'/common/header.bootstrap.php');
?>
<style type="text/css">
body{padding:40px 0;background-color:#eee}
.form-signin{max-width:300px;padding:20px 30px;margin:0 auto;background-color:#fff;border:1px solid #e5e5e5;
-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px}
.form-control{font-size:16px;height:auto;margin:5px 0 12px;padding:7px 9px}
</style>
</head>
<body>
<div class="container">
	<form method="post" class="form-signin">
	    <? if(isset($error)) { ?>
	    <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning!</strong><br>No match for Username / Password
        </div>
        <? } ?>
		<legend><? echo $GLOBALS['admin']['title']; ?></legend>
		<label>
			Usuario
			<input type="text" name="name" class="form-control" required autofocus />
		</label>
		<label>
			Password
			<input type="password" name="pass" class="form-control" required />
		</label>
		<label>
			Language
			<select name="locale" class="form-control">
			<?
            foreach($GLOBALS['admin']['locale'] as $key => $lang)
            {
                $sel = ($key==$aSession->get('locale')) ? ' selected' : '';
                echo '<option value="'.$key.'"'.$sel.'>'.$lang.'</option>';
            }
			?>
			</select>
		</label>
		<input type="hidden" name="login" value="1" />
		<button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
	</form>
</div>
</body>
</html>
