<?
require(dirname(__FILE__).'/1nit.php');

// language:
if(array_key_exists($_POST['locale'], $GLOBALS['admin']['locale'])) $session->set('locale', $_POST['locale']);
elseif(!$session->exists('locale')) $session->set('locale', key($GLOBALS['admin']['locale']));

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
    $session->destroy();

    header('Location: '.ADMIN.'login.php');
    exit;
}

require(dirname(__FILE__).'/common/header.bootstrap.php');
?>
<style type="text/css">
body{padding:40px 0;background-color:#f5f5f5}
.form-signin{max-width:300px;padding:19px 29px 29px;margin:0 auto 20px;background-color:#fff;border:1px solid #e5e5e5;
-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;
-webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:0 1px 2px rgba(0,0,0,.05);box-shadow:0 1px 2px rgba(0,0,0,.05);}
.form-signin select,.form-signin input[type="text"],.form-signin input[type="password"]{
font-size:16px;height:auto;margin:5px 0 15px;padding:7px 9px}
</style>
</head>
<body>
<div class="container">
	<form method="post" class="form-signin">
	    <? if(isset($error)) { ?>
	    <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Warning!</strong><br>No match for Username and/or Password.
        </div>
        <? } ?>
		<legend>Login</legend>
		<label>
			Usuario<br>
			<input type="text" name="name" class="input-block-level" required autofocus />
		</label>
		<label>
			Password<br>
			<input type="password" name="pass" class="input-block-level" required />
		</label>
		<label>
			Language<br>
			<select name="locale" class="input-block-level">
			<?
            foreach($GLOBALS['admin']['locale'] as $key => $lang)
            {
                $sel = ($key==$session->get('locale')) ? ' selected' : '';
                echo '<option value="'.$key.'"'.$sel.'>'.$lang.'</option>';
            }
			?>
			</select>
		</label>
		<input type="hidden" name="act_login" value="1" />
		<button type="submit" class="btn btn-large btn-primary">Login</button>
	</form>
</div>
</body>
</html>
