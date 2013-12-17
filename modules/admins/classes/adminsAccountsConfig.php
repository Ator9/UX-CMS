<?php
class adminsAccountsConfig extends ConnExtjs
{
	public $_table	= 'admins_accounts_configs';
	public $_index	= '';
	public $_fields	= array('accountID',
							'name',
							'value',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


    // Create:
    public function extCreate()
    {
        $sql = 'INSERT INTO '.$this->_table.' (accountID, name, value) 
                VALUES (0 , "'.$this->escape($_POST['name']).'", "'.$this->escape($_POST['value']).'")
                ON DUPLICATE KEY UPDATE value = "'.$this->escape($_POST['value']).'"';
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List | Filters with config:
    public function extGridConfigs()
    {
        $config = getModuleConfig(getModuleDir($GLOBALS['admin']['class']));
        $data   = array_keys($config['accounts_config']);

        //foreach($data as $value) $union.= 'UNION SELECT "'.$value.'", "" ';

        $sql = 'SELECT name, value FROM '.$this->_table.' WHERE name IN ("'.implode('","', $data).'")';

        return parent::extGrid($sql);
    }


    // Get config types from config (Ext.grid.property.Grid):
    public function extAccountsConfigTypes()
    {
        $config = getModuleConfig(getModuleDir($GLOBALS['admin']['class']));
        foreach($config['accounts_config'] as $key => $type)
        {
            $source[$key]['type'] = $type;
        }
        
        echo json_encode($source);
    }


}


