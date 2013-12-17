<?php
// You can create a custom "includes/functions.php" (it will be loaded automatically)

// Class autoload:
// Example 1: class task{} = modules/task/task.php
// Example 2: class taskNew{} = modules/task/taskNew.php
// Example 3: class task_calendarNew{} = modules/task_calendar/task_calendarNew.php
function __autoload($class)
{
	if(file_exists(ROOT.'/includes/classes/'.$class.'.php')) require(ROOT.'/includes/classes/'.$class.'.php');
	else require(ROOT.'/modules/'.getModuleDir($class).'/classes/'.$class.'.php');
}


// Get current URL:
function getCurrentUrl($strip_query=false)
{
    $url = HOST.substr($_SERVER['REQUEST_URI'], 1);
    if($strip_query) $url = current(explode('?',$url));

    return $url;
}


function dateFormat($format, $datetime)
{
	if($datetime!='' && !strstr($datetime,'0000-00-00')) return date($format, strtotime($datetime));
	return false;
}


function isEmail($email)
{
	if(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) return false;
	return true;
}


// Get subdomain:
function getSubdomain()
{
    return array_shift(explode('.', $_SERVER['HTTP_HOST']));
}


function cleanUserInput($data)
{
	$data = array_map_recursive('strip_tags', $data);
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


// Para generar includes tipo css.123123.css:
function staticLoader($file='', $disallow=false)
{
    if(LOCAL) $file = str_replace('-min', '', $file);

    if($disallow) return HOST.'/'.$file;

    return HOST.'/'.preg_replace('{\\.([^./]+)$}', '.'.filemtime(ROOT.'/'.$file).'.$1', $file);
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


// Truncate string:
function truncate($str, $num)
{
    if(strlen($str) > $num)
    {
        $str = strip_tags($str);
        return mb_substr($str, 0, $num, 'UTF-8') . '...';
    }
    return $str;
}


// SEO URL:
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


function now()
{ 
    return date('Y-m-d H:i:s');
}


function vd($data)
{
	echo '<pre style="background:orange">';
	print_r($data);
	echo '</pre>';
}


