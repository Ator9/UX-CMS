<?php
class adminsPartnersConfig extends ConnExtjs
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'partners_configs';
	public $_index	= '';


	// ------------------------------------------------------------------------------- //


    // Create:
    public function extCreate()
    {
        if(!is_numeric($_REQUEST['partnerID'])) exit;
    
        $data = (array) json_decode(stripslashes($_POST['data']));
    
        $sql = 'INSERT INTO '.$this->_table.' (partnerID, name, value) 
                VALUES ('.$_REQUEST['partnerID'].' , "'.$this->escape($data['name']).'", "'.$this->escape($data['value']).'")
                ON DUPLICATE KEY UPDATE value = "'.$this->escape($data['value']).'"';
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List | Filters with config:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['partnerID'])) exit;
    
        // All results:
        $sql = 'SELECT * FROM '.$this->_table.' WHERE partnerID = '.$_REQUEST['partnerID'];
        foreach(parent::extGrid($sql, true, true) as $row)
        {
            $results[$row['name']] = $row['value'];
        }

        // Filter needed results:
        $config = getModuleConfig(getModuleDir($GLOBALS['admin']['class']));
        ksort($config['partners_config']);
        foreach($config['partners_config'] as $name => $desc)
        {
            $response['data'][] = array('name' => $name, 'value' => $results[$name], 'description' => $desc);
        }
        
        $response['totalCount'] = count($config['partners_config']);
    	echo json_encode($response);
    }

}


