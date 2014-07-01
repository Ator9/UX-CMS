<?php
require(__DIR__.'/common/init.php');

// IP restriction:
checkAdminIpAccess();

// Login:
if(isset($_POST['login']))
{
    // Lang set:
    if(array_key_exists($_POST['locale'], $GLOBALS['admin']['locale'])) $aSession->set('locale', $_POST['locale']);

    $db = new $GLOBALS['admin']['class']();
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

    header('Location: '.ADMIN.'/login.php');
    exit;
}

// Check admin session with ExtJs Ajax (index.php):
header('HTTP/1.1 401 Unauthorized');

require(ROOT.'/admin/common/header.bootstrap.php');
if($GLOBALS['admin']['favicon']!='') { ?><link type="image/x-icon" href="<?php echo $GLOBALS['admin']['favicon']; ?>" rel="shortcut icon" /><?php } ?>
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
	    <?php if(isset($error)) { ?>
	    <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Warning!</strong><br>No match for Username / Password
        </div>
        <?php } ?>
		<h4><?php echo $GLOBALS['admin']['title']; ?></h4><hr>
		<label>
			<?php echo $lang->t('User');?>
			<input type="text" name="name" class="form-control" required autofocus />
		</label>
		<label>
			<?php echo $lang->t('Password');?>
			<input type="password" name="pass" class="form-control" required />
		</label>
		<?php
		// Languages (admin/config.php):
        if(count($GLOBALS['admin']['locale']) > 1)
        {
		    ?>
		    <label><?php echo $lang->t('Language');?>
			    <select name="locale" class="form-control">
			    <?php
                foreach($GLOBALS['admin']['locale'] as $key => $locale)
                {
                    $sel = ($key==$aSession->get('locale')) ? ' selected' : '';
                    echo '<option value="'.$key.'"'.$sel.'>'.$locale.'</option>';
                }
			    ?>
			    </select>
		    </label>
		    <?php
		}
		?>
		<input type="hidden" name="login" value="1" />
		<button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo $lang->t('Login');?></button>
	</form>
</div>
</body>
</html>
