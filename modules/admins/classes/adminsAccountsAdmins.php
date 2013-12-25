<?php
class adminsAccountsAdmins extends ConnExtjs
{
	public $_table	= 'admins_accounts_admins';
	public $_index	= '';
	public $_fields	= array('accountID',
							'adminID',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


    // Grid List | Filters with config:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['accountID'])) exit;
    
        // All results:
        $sql = 'SELECT adm.adminID, adm.email, adm.username FROM '.$this->_table.' as acc
                INNER JOIN admins as adm USING (adminID)
                WHERE accountID = '.$_REQUEST['accountID'];
                
        return parent::extGrid($sql);
    }

}


