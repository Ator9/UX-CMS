<?php
// You can create a custom "includes/functions.php" (it will be loaded automatically)

// Traigo los modulos para armar el arbol del admin:
function getAdminTree()
{
    foreach(getFilesFromDir(ROOT.'/modules') as $module)
    {
        if(!is_dir($module['path'])) continue;

        $config = getModuleConfig($module['name']);
        if($config['enabled'] !== true) continue;

        $tree[$config['name']] = array('text'=>$config['name'], 'panel'=>basename($module['path']), 'icon'=>'resources/icons/'.$config['icon'], 'leaf'=>true);
    }
    
    ksort($tree); // Orden alfabético
    return $tree;
}


// Get module config:
function getModuleConfig($module)
{
    if(file_exists(ROOT.'/modules/'.$module.'/config.php')) require(ROOT.'/modules/'.$module.'/config.php');
    elseif(file_exists(ROOT.'/modules/'.$module.'/config.default.php')) require(ROOT.'/modules/'.$module.'/config.default.php');

    return $config;
}


// Get extjs class paths:
function getAdminPaths()
{
    foreach(getFilesFromDir(ROOT.'/modules') as $module)
    {
        if(!is_dir($module['path'])) continue;

        $config = getModuleConfig($module['name']);
        
        $paths.= ", '".basename($module['path'])."': '../modules/".basename($module['path'])."/admin'";
    }

    return $paths;
}


// Get admin tree footer buttons (admin config):
function getAdminTreeButtons()
{
    $fbar = array();

    if(is_array($GLOBALS['admin']['fbar_buttons']))
    foreach($GLOBALS['admin']['fbar_buttons'] as $val) {
        $fbar[] = "{text:'".$val['text']."', type:'button', width:'".(100 / count($GLOBALS['admin']['fbar_buttons']))."%', scale:'small', url:'".$val['url']."'}";
    }
    echo implode(',', $fbar);
}


// IP restriction (admin config):
function checkAdminIpAccess()
{
    if(!empty($GLOBALS['admin']['allowed_ips']))
    {
        if(in_array($_SERVER['REMOTE_ADDR'], $GLOBALS['admin']['allowed_ips'])) return true;
        else
        {
            foreach($GLOBALS['admin']['allowed_ips'] as $ip)
            {
                if(preg_match('/'.$ip.'/', $_SERVER['REMOTE_ADDR'])) return true;
            }
        }

        header('HTTP/1.0 403 Forbidden');
        exit('access denied');
    }
}


