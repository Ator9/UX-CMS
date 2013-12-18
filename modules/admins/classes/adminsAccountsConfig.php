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
        $data = (array) json_decode(stripslashes($_POST['data']));
    
        $sql = 'INSERT INTO '.$this->_table.' (accountID, name, value) 
                VALUES (0 , "'.$this->escape($data['name']).'", "'.$this->escape($data['value']).'")
                ON DUPLICATE KEY UPDATE value = "'.$this->escape($data['value']).'"';
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List | Filters with config:
    public function extGrid()
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
        foreach($config['accounts_config'] as $name => $desc)
        {
            $response['data'][] = array('name' => $name, 'value' => $results[$name], 'description' => $desc);
        }
        
        $response['totalCount'] = count($config['accounts_config']);
    	echo json_encode($response);
    }

}


