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
        // All results:
        $sql = 'SELECT * FROM '.$this->_table.' WHERE accountID = 0';
        foreach(parent::extGrid($sql, true, true) as $row)
        {
            $results[$row['name']] = $row['value'];
        }

        // Filter needed results:
        $config = getModuleConfig(getModuleDir($GLOBALS['admin']['class']));
        ksort($config['accounts_config']);
        foreach($config['accounts_config'] as $name => $type)
        {
            $response['data'][] = array('name' => $name, 'value' => $results[$name]);
        }
        
        $response['totalCount'] = count($config['accounts_config']);
    	echo json_encode($response);
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


