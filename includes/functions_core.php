<?php
// You can create a custom "includes/functions.php" (it will be loaded automatically)

// Class Autoloader:
// Example 1: class task{} = modules/task/task.php
// Example 2: class taskNew{} = modules/task/taskNew.php
// Example 3: class task_calendarNew{} = modules/task_calendar/task_calendarNew.php
function class_autoloader($class)
{
	if(is_file($file = ROOT.'/includes/classes/'.$class.'.php')) require $file;
	elseif(is_file($file = ROOT.'/includes/traits/'.$class.'.php')) require $file;
	elseif(is_file($file = ROOT.'/modules/'.getModuleDir($class).'/classes/'.$class.'.php')) require $file;
} spl_autoload_register('class_autoloader');


// Simple query:
function query($sql)
{
    $q = new Conn();
    return $q->query($sql);
}

// Get current URL:
function getCurrentUrl($strip_query=false)
{
    $url = HOST.substr($_SERVER['REQUEST_URI'], 1);
    if($strip_query) $url = current(explode('?', $url));

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


function cleanForm($data)
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


// Get subdomain:
function getSubdomain()
{
    return array_shift(explode('.', $_SERVER['HTTP_HOST']));
}


function deleteCookie($name)
{
	setcookie($name, '', time()-3600, '/', '', false, true);
}


function getFilesFromDir($dir)
{
	$data = array(); $i = 0;

	if(is_dir($dir))
	{
		$objects = new DirectoryIterator($dir);
		foreach($objects as $object)
		{
		    if($object->getFilename() == '.' || $object->getFilename() == '..') continue;
		    
		    $data[$i]['path']  = $object->getPathname();
		    $data[$i]['name']  = $object->getFilename();
		    $data[$i]['ext']   = pathinfo($object->getFilename(),PATHINFO_EXTENSION);
		    $data[$i]['size']  = $object->getSize();
		    $data[$i]['mtime'] = $object->getMTime();
		    $i++;
		}
	}

	return $data;
}


/**
 * Truncate string
 *
 * @return String
 */
function truncate($str, $num)
{
    if(strlen($str) > $num)
    {
        $str = strip_tags($str);
        return mb_substr($str, 0, $num, 'UTF-8') . '...';
    }
    return $str;
}


/**
 * SEO URL
 *
 * @return String
 */
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
    $txt = preg_replace('/(\/| |´|\'|"|_|.)/','-',$txt);
    
    $txt = preg_replace('/[^a-z0-9-]/', '', $txt);
    $txt = preg_replace('/-{2,}/', '-', $txt);
    $txt = trim($txt, '-');

    return $txt;
}


function vd($data)
{
	echo '<pre style="background:orange">';
	print_r($data);
	echo '</pre>';
}


