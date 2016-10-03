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
function getCurrentUrl($strip_query = false)
{
    $url = HOST.$_SERVER['REQUEST_URI'];
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


// http://detectmobilebrowsers.com/
function isMobile()
{
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) return true;
    return false;
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
    $txt = preg_replace('/(\/| |´|\'|"|_|\.)/','-',$txt);
    
    $txt = preg_replace('/[^a-z0-9ñ-]/', '', $txt);
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


