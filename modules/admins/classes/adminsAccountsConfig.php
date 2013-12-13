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


    // Get config types from config (Ext.grid.property.Grid):
    public function extGetConfigTypes()
    {
        $dir = strtolower(current(preg_split('/(?<=[a-z]) (?=[A-Z])/x', $GLOBALS['admin']['class'])));
    
        $config = getModuleConfig($dir);
        foreach($config['accounts_config'] as $key => $type)
        {
            $source[$key]['type'] = $type;
        }
        
        echo json_encode($source);
    }
}


