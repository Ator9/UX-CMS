<?php
// You can create an empty "functions.php" & change it
// Core Functions:

// Class autoload:
// Example 1: class task{} = modules/task/task.php
// Example 2: class taskNew{} = modules/task/taskNew.php
// Example 3: class task_calendarNew{} = modules/task_calendar/task_calendarNew.php
function __autoload($class)
{
	if(file_exists(ROOT.'includes/classes/'.$class.'.php')) require(ROOT.'includes/classes/'.$class.'.php');
	else {
	    $dir = strtolower(current(preg_split('/(?<=[a-z]) (?=[A-Z])/x', $class)));
	    if(file_exists(ROOT.'admin/'.$dir.'/classes/'.$class.'.php')) require(ROOT.'admin/'.$dir.'/classes/'.$class.'.php');
	    else require(ROOT.'modules/'.$dir.'/classes/'.$class.'.php');
    }
}


// Current URL:
function getCurrentUrl($strip_query=false)
{
    $url = HOST.substr($_SERVER['REQUEST_URI'], 1);
    if($strip_query) $url = current(explode('?',$url));

    return $url;
}


function getSubdomain()
{
    return array_shift(explode('.', $_SERVER['HTTP_HOST']));
}


// Traigo los modulos para armar el arbol del admin:
function getAdminTree()
{
    $dirs = array_merge(getFilesFromDir(ROOT.'admin'), getFilesFromDir(ROOT.'modules'));
    foreach($dirs as $module)
    {
        if(!is_dir($module['path'])) continue;

        $config = getModuleConfig($module['name']);
        if($config['enabled'] !== true) continue;
        
        $tree[$config['name']] = array('text'=>$config['name'], 'panel'=>basename($module['path']), 'icon'=>'resources/icons/'.$config['icon'], 'leaf'=>true);
    }
    
    ksort($tree); // Orden alfabético

    return $tree;
}


// get admin tree footer buttons (custom config):
function getAdminTreeButtons()
{
    $fbar = array();

    if(is_array($GLOBALS['admin']['fbar_buttons']))
    foreach($GLOBALS['admin']['fbar_buttons'] as $val) {
        $fbar[] = "{text:'".$val['text']."', type:'button', width:'".(100 / count($GLOBALS['admin']['fbar_buttons']))."%', scale:'small', url:'".$val['url']."'}";
    }
    echo implode(',', $fbar);
}


// Traigo la configuracion del módulo:
function getModuleConfig($module='')
{
    if(file_exists(ROOT.'modules/'.$module.'/config.php')) require(ROOT.'modules/'.$module.'/config.php');
    elseif(file_exists(ROOT.'modules/'.$module.'/config.default.php')) require(ROOT.'modules/'.$module.'/config.default.php');
    
    elseif(file_exists(ROOT.'admin/'.$module.'/config.php')) require(ROOT.'admin/'.$module.'/config.php');
    elseif(file_exists(ROOT.'admin/'.$module.'/config.default.php')) require(ROOT.'admin/'.$module.'/config.default.php');

    return $config;
}


// Para generar includes tipo css.123123.css:
function staticLoader($file='', $disallow=false)
{
    if(LOCAL) $file = str_replace('-min', '', $file);

    if($disallow) return HOST.$file;

    return HOST.preg_replace('{\\.([^./]+)$}', '.'.filemtime(ROOT.$file).'.$1', $file);
}


function deleteCookie($name)
{
	setcookie($name, '', time()-3600, '/', '', false, true);
}


function recursiveTree($db, $table, $indexID, $parentID, $IDs, $backwards=false)
{
	$db->_table = $table;
	$db->_index	= $indexID;

	$sql = $data = array();

	$whereID = ($backwards) ? $indexID  : $parentID;
	$dataID  = ($backwards) ? $parentID : $indexID;

	if(is_numeric($IDs)) $data[] = $db->get($IDs);
	elseif(is_array($IDs))
	{
		foreach($IDs as $value) $sql[] = $value[$dataID];
		if(!empty($sql)) $params['WHERE'] = $whereID.' IN ('.implode(',', $sql).')';
		$rs = $db->getList($params);
		if($rs->num_rows > 0) while($row = $rs->fetch_assoc()) $data[] = $row;
	}

	if(!empty($data) && is_array(recursiveTree($db, $table, $indexID, $parentID, $data, $backwards)))
	{
		return array_merge($data, recursiveTree($db, $table, $indexID, $parentID, $data, $backwards));
	}
	return $data;
}


function cleanUserInput($data)
{
	$data = array_map_recursive('strip_tags',$data);
	$data = array_map_recursive('trim', $data);

	return $data;
}


function array_map_recursive($func, $arr)
{
   $newArr = array();
   foreach($arr as $key => $value)
   {
       $newArr[$key] = (is_array($value)) ? array_map_recursive($func, $value) : $func($value);
   }
   return $newArr;
}


function youtube($code, $size='640x385', $img=0)
{
	list($w, $h) = explode('x', $size);

	if($img==1) return '<img src="http://i.ytimg.com/vi/'.$code.'/default.jpg" style="width:'.$w.'px;height:'.$h.'px" alt="" />';
	if($img==2) return 'http://i.ytimg.com/vi/'.$code.'/default.jpg';
	
	return '<object width="'.$w.'" height="'.$h.'">
				<param name="movie" value="http://www.youtube.com/v/'.$code.'?hl=es&amp;fs=1&amp;rel=0" />
				<param name="allowFullScreen" value="true" />
				<param name="allowscriptaccess" value="always" />
				<embed src="http://www.youtube.com/v/'.$code.'?hl=es&amp;fs=1&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" width="'.$w.'" height="'.$h.'"></embed>
			</object>';
}


function getFilesFromDir($dir)
{
	$data = array();

	if(is_dir($dir))
	{
		$objects = new DirectoryIterator($dir); // RecursiveDirectoryIterator
		foreach($objects as $object)
		{
		    if($object->getFilename() == '.' || $object->getFilename() == '..') continue; // no hace falta con RecursiveDirectoryIterator (es mejor)
		    
			++$i;
		    $data[$i]['path']  = $object->getPathname();
		    $data[$i]['name']  = $object->getFilename();
		    $data[$i]['ext']   = pathinfo($object->getFilename(),PATHINFO_EXTENSION);
		    $data[$i]['size']  = $object->getSize();
		    $data[$i]['mtime'] = $object->getMTime();
		}
	}
	
	return $data;
}


function truncate($str, $num)
{
    if(strlen($str) > $num)
    {
        $str = strip_tags($str);
        return mb_substr($str, 0, $num, 'UTF-8') . '...';
    }
    return $str;
}


function seo($txt)
{
	$txt = mb_strtolower($txt, 'UTF-8');

    $txt = preg_replace('/(À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å)/','a',$txt);
    $txt = preg_replace('/(È|É|Ê|Ë|è|é|ê|ë)/','e',$txt);
    $txt = preg_replace('/(Ì|Í|Î|Ï|ì|í|î|ï)/','i',$txt);
    $txt = preg_replace('/(Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø)/','o',$txt);
    $txt = preg_replace('/(Ù|Ú|Û|Ü|ù|ú|û|ü)/','u',$txt);
    $txt = preg_replace('/(Ç|ç)/','c',$txt);
    $txt = preg_replace('/ÿ/','y',$txt);
    $txt = preg_replace('/(!|¡)/','',$txt);
    $txt = preg_replace('/(\/| |´|\'|"|_)/','-',$txt);

    $txt = preg_replace('/[^a-z0-9.-]/', '', $txt);
	$txt = preg_replace('/-{2,}/', '-', $txt);
	$txt = trim($txt, '-');

    return $txt;
}


function meses($num='')
{
    $data[1] = 'Enero';
    $data[2] = 'Febrero';
    $data[3] = 'Marzo';
    $data[4] = 'Abril';
    $data[5] = 'Mayo';
    $data[6] = 'Junio';
    $data[7] = 'Julio';
    $data[8] = 'Agosto';
    $data[9] = 'Septiembre';
    $data[10] = 'Octubre';
    $data[11] = 'Noviembre';
    $data[12] = 'Diciembre';

    if(array_key_exists($num, $data)) return $data[$num];
    return $data;
}


function date_mysql($format, $datetime)
{
	if($datetime!='' && !strstr($datetime,'0000-00-00')) return date($format, strtotime($datetime));
	return false;
}


function isEmail($email)
{
	if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) return false;
	return true;
}


function NOW(){ return date('Y-m-d H:i:s'); }


function vd($data)
{
	echo '<pre style="background:orange">';
	print_r($data);
	echo '</pre>';
}


// E-mail que recibe el encargado del sitio cuando se contactan:
function emailContact($data, $auth=false, $smtp=false)
{
	global $CONFIG;

	if(isset($data['nombre'])) $cuerpo = '<strong>Nombre:</strong> '.$data['nombre'].'<br>';
    $cuerpo.= '<strong>E-Mail:</strong> '.$data['email'].'<br><br>
    		   <strong>Mensaje:</strong> '.nl2br($data['mensaje']).'<br>';

	$mail= new PHPMailer();
	$mail->ContentType = 'text/html';
	$mail->CharSet 	   = 'utf-8';
	//$mail->AddReplyTo($data['email']);
	$mail->SetFrom($data['email'], $data['nombre']);
	$mail->Sender      = $CONFIG['email'];
	$mail->Subject 	   = ($data['subject']!='') ? $data['subject'] : $CONFIG['sitename'].' - Contacto';
	$mail->Body 	   = emailBody($cuerpo);
	$mail->AddAddress($CONFIG['email']);

    if(LOCAL || $auth)
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
    }

	if(LOCAL || $smtp)
	{
		$mail->Host	    = SMTP_HOST;
		$mail->Port     = SMPT_PORT;
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
	}

	return $mail->Send();
}


// Body generico simple listo para incluir contenido:
function emailBody($content)
{
	global $CONFIG;

	$html = '<html>
				<head>
				   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				   <title>'.$CONFIG['sitename'].'</title>
				</head>
				<body style="font-family:verdana,helvetica,arial,sans-serif;font-size:12px">
				'.$content.'
				</body>
			</html>';

	return $html;
}

