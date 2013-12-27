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
        $sql = 'SELECT adm.adminID, adm.email, adm.username 
                FROM '.$this->_table.' as acc
                INNER JOIN admins as adm ON (acc.adminID = adm.adminID AND accountID = '.$_REQUEST['accountID'].')
                WHERE 1';
                
        return parent::extGrid($sql);
    }


    // Delete:
    public function extDelete()
    {
        // TODO chequear adminID
    
        $data = json_decode(stripslashes($_POST['data']));

        $sql = 'DELETE FROM '.$this->_table.' WHERE accountID = '.(int) $_POST['accountID'].' AND adminID = '.(int) $data->adminID;
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }

}


