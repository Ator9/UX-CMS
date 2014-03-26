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
        if(!empty($config['admins']) && !in_array($GLOBALS['admin']['data']['adminID'], $config['admins'])) continue; // Allowed admins (array)

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


// Get directory from classname:
function getModuleDir($classname='')
{
    return strtolower(current(preg_split('/(?<=[a-z]) (?=[A-Z])/x', $classname)));
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


// Get admin accounts select (admin config.php):
function getAdminAccounts()
{
    foreach($GLOBALS['admin']['data']['accounts'] as $value)
    {
        $accounts[] = "{ 'accountID': ".$value['accountID'].", 'name': '".$value['name']."' }";
    }
    
    echo ", tbar: [{ 
                xtype: 'combobox',
                name: 'accountID',
                displayField: 'name',
                valueField: 'accountID',
                width: '100%',
                emptyText: 'Select Account',
                fields: [ 'name', 'accountID' ],
                store: Ext.create('Ext.data.Store', {
                    fields: [ 'accountID', 'name' ],
                    data: [".implode(',', (array) $accounts)."]
                }),
                listeners: {
                    'select': function(combo, records, eOpts) {
                        //Admin.accountID = records[0].get('accountID');
                    }
                }
            }]";
}


// Get admin tree footer buttons (admin config.php):
function getAdminTreeButtons()
{
    $fbar = array();

    if(is_array($GLOBALS['admin']['fbar_buttons']))
    foreach($GLOBALS['admin']['fbar_buttons'] as $val) {
        $fbar[] = "{text:'".$val['text']."', type:'button', width:'".(100 / count($GLOBALS['admin']['fbar_buttons']))."%', scale:'small', url:'".$val['url']."'}";
    }
    echo implode(',', $fbar);
}


// Get lang:
function getLang($modules=array())
{
    global $aSession;

    foreach($modules as $module)
    {
        $js.= 'Admin.lang.'.$module.'=[];';
        foreach(getModuleLocale($module, $aSession->get('locale')) as $key => $value)
        {
            $js.= 'Admin.lang.'.$module.'["'.$key.'"]="'.$value.'";';
        }
    }

    echo 'Admin.lang=[];';
    echo $js;
}


// Get module lang file:
function getModuleLocale($module='', $lang='es')
{
    if(file_exists(ROOT.'/modules/'.$module.'/locale/'.$lang.'.csv')) $file = ROOT.'/modules/'.$module.'/locale/'.$lang.'.csv';
    elseif(file_exists(ROOT.'/admin/common/locale/'.$lang.'.csv')) $file = ROOT.'/admin/common/locale/'.$lang.'.csv';

    if($file != '' && ($handle = fopen($file, 'r')) !== FALSE)
    {
        while(($data = fgetcsv($handle, 1000)) !== FALSE)
        {
            $words[$data[0]] = $data[1];
        }
        fclose($handle);
    }
    
    return (array) $words;
}


// IP restriction (admin config.php):
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


