<?php
class adminsAccountsConfig extends ConnExtjs
{
	public $_table	= 'admins_accounts_configs';
	public $_index	= '';
	public $_fields	= array('accountID',
							'name',
							'value',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


    // Create:
    public function extCreate()
    {
        if(!is_numeric($_REQUEST['accountID'])) exit;
    
        $data = (array) json_decode(stripslashes($_POST['data']));
    
        $sql = 'INSERT INTO '.$this->_table.' (accountID, name, value) 
                VALUES ('.$_REQUEST['accountID'].' , "'.$this->escape($data['name']).'", "'.$this->escape($data['value']).'")
                ON DUPLICATE KEY UPDATE value = "'.$this->escape($data['value']).'"';
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List | Filters with config:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['accountID'])) exit;
    
        // All results:
        $sql = 'SELECT * FROM '.$this->_table.' WHERE accountID = '.$_REQUEST['accountID'];
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


