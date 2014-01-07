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


    // Grid List:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['accountID'])) exit;
    
        $sql = 'SELECT adm.adminID, adm.username, adm.last_login
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


    /**
     * Get associated accounts.
     *
     * @return array
     */
    public function getAccountsByAdmin()
    {
        $sql = 'SELECT acc.accountID, acc.name
                FROM '.$this->_table.' as aa
                INNER JOIN admins_accounts as acc USING (accountID)
                WHERE adminID = '.$GLOBALS['admin']['data']['adminID'].'
                ORDER BY name';
                
        if(($rs = $this->query($sql)) && $rs->num_rows > 0)
        {
            while($row = $rs->fetch_assoc())
            {
                $array[$row['accountID']] = $row;
            }
        }

        return (array) $array;
    }

}


