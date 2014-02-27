<?php
class adminsAccountsAdmins extends ConnExtjs
{
	public $_table	= 'admins_accounts_admins';
	public $_index	= '';
	public $_fields	= array('accountID',
							'adminID',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['accountID'])) exit;
    
        $sql = 'SELECT adm.adminID, adm.username, adm.last_login, adm.email
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
    
    
    // E:
    public function addAdminToAccount()
    {
        $sql = 'SELECT adminID FROM admins
                WHERE username = "'.$this->escape($_POST['key']).'" OR email = "'.$this->escape($_POST['key']).'" 
                LIMIT 1';
        
        if(($rs = $this->query($sql)) && $rs->num_rows == 1)
        {
            list($adminID) = $rs->fetch_row();
        
            $this->accountID = $_POST['accountID'];
            $this->adminID   = $adminID;
            if($this->insert()) $response['success'] = true;
        }
        else $response['success'] = false;
        
        echo json_encode($response);
    }

}


