<?php
require(dirname(__FILE__).'/1nit.php');

// language:
if(array_key_exists($_POST['locale'], $GLOBALS['admin']['locale'])) $aSession->set('locale', $_POST['locale']);
elseif(!$aSession->exists('locale')) $aSession->set('locale', key($GLOBALS['admin']['locale']));

if(isset($_POST['act_login']))
{
    $db = new Admins();
    if($db->login($_POST['name'], $_POST['pass']))
    {
        header('Location: '.ADMIN);
        exit;
    }
    else $error = true;
}

if(isset($_GET['logout']))
{
    $aSession->destroy();

    header('Location: '.ADMIN.'login.php');
    exit;
}

require(dirname(__FILE__).'/common/header.bootstrap.php');
?>
<style type="text/css">
body{padding:40px 0;background-color:#eee}
.form-signin{max-width:300px;padding:20px 30px;margin:0 auto;background-color:#fff;border:1px solid #e5e5e5;
-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;
-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);
-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);
box-shadow:0 1px 2px rgba(0,0,0,.05);
}
.form-signin select,.form-signin input[type="text"],.form-signin input[type="password"]{font-size:16px;height:auto;margin:5px 0 12px;padding:7px 9px}
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
			Usuario<br>
			<input type="text" name="name" class="form-control" required autofocus />
		</label>
		<label>
			Password<br>
			<input type="password" name="pass" class="form-control" required />
		</label>
		<label>
			Language<br>
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
		<input type="hidden" name="act_login" value="1" />
		<button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
	</form>
</div>
</body>
</html>
