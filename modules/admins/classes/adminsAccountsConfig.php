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
        $config = getModuleConfig('admins');
        foreach($config['accounts_config'] as $key => $type)
        {
            $source[$key]['type'] = $type;
        }
        
        echo json_encode($source);
    }
}


