<?php
// You can create a custom "includes/functions.php" (it will be loaded automatically)

// Get modules to build extjs tree panel:
function getAdminTree()
{
    global $lang;
    
    foreach(getFilesFromDir(ROOT.'/modules') as $module)
    {
        if(!is_dir($module['path'])) continue;

        $config = getModuleConfig($module['name']);
        if($config['enabled'] != true) continue;
        if(!empty($config['admins']) && !in_array($GLOBALS['admin']['data']['adminID'], $config['admins'])) continue; // Allowed admins (array)

        $panel = basename($module['path']);
        $tree[$lang->t($panel.'.'.$config['name'])] = array('text'=>$lang->t($panel.'.'.$config['name']), 'id'=>$panel, 'icon'=>'resources/icons/'.$config['icon'], 'leaf'=>true);
    }
    
    ksort($tree); // Alphabetical order
    return $tree;
}


// Get module config:
function getModuleConfig($module)
{
    $config = '';
    if(is_file($file = ROOT.'/modules/'.$module.'/config.php')) require $file;
    elseif(is_file($file = ROOT.'/modules/'.$module.'/config.default.php')) require $file;
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


// Get admin partners select (admin config.php):
function getAdminPartners()
{
    foreach($GLOBALS['admin']['data']['partners'] as $value)
    {
        $partners[] = "{ 'partnerID': ".$value['partnerID'].", 'name': '".$value['name']."' }";
    }
    
    echo ", tbar: [{ 
                xtype: 'combobox',
                name: 'partnerID',
                displayField: 'name',
                valueField: 'partnerID',
                ".(($GLOBALS['admin']['data']['partnerID']>0) ? "value: ".$GLOBALS['admin']['data']['partnerID']."," : '')."
                width: '100%',
                editable: false,
                emptyText: 'Select Partner',
                fields: [ 'name', 'partnerID' ],
                store: Ext.create('Ext.data.Store', {
                    fields: [ 'partnerID', 'name' ],
                    data: [".implode(',', (array) $partners)."]
                }),
                listeners: {
                    'select': function(combo, records, eOpts) {
                        Ext.Ajax.request({
                            scope: this,
                            url: 'index.php?_class=adminsPartnersAdmins&_method=setPartnerID',
                            params: { partnerID: records[0].get('partnerID') },
                            success: function(response) {
                                location.reload();
                            }
                        });
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


// Get Admin Translations:
function getAdminLocale($modules=array())
{
    global $aSession, $lang;
    
    // Global words:
    foreach($lang->words as $key => $value) $js.= 'Admin.lang._["'.$key.'"]="'.$value.'";';

    // Module words:
    foreach($modules as $module)
    foreach($lang->loadModule($module, false) as $key => $value)
    {
        $js.= 'Admin.lang.'.$module.'["'.$key.'"]="'.$value.'";';
    }

    echo $js;
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


