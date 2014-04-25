<?php
class adminsPartnersAdmins extends ConnExtjs
{
	public $_table	= 'partners_admins';
	public $_index	= '';
	public $_fields	= array('partnerID',
							'adminID',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid()
    {
        if(!is_numeric($_REQUEST['partnerID'])) exit;
    
        $sql = 'SELECT adm.adminID, adm.username, adm.last_login, adm.email
                FROM '.$this->_table.' as acc
                INNER JOIN admins as adm ON (acc.adminID = adm.adminID AND partnerID = '.$_REQUEST['partnerID'].')
                WHERE 1';
                
        return parent::extGrid($sql);
    }


    // Delete:
    public function extDelete()
    {
        // TODO chequear adminID
    
        $data = json_decode(stripslashes($_POST['data']));

        $sql = 'DELETE FROM '.$this->_table.' WHERE partnerID = '.(int) $_POST['partnerID'].' AND adminID = '.(int) $data->adminID;
        
        if($this->query($sql)) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    /**
     * Get associated partners.
     *
     * @return array
     */
    public function getPartnersByAdmin()
    {
        $sql = 'SELECT acc.partnerID, acc.name
                FROM '.$this->_table.' as aa
                INNER JOIN partners as acc USING (partnerID)
                WHERE adminID = '.$GLOBALS['admin']['data']['adminID'].'
                ORDER BY name';
                
        if(($rs = $this->query($sql)) && $rs->num_rows > 0)
        {
            while($row = $rs->fetch_assoc())
            {
                $array[$row['partnerID']] = $row;
            }
        }

        return (array) $array;
    }
    
    
    // E:
    public function addAdminToPartner()
    {
        $sql = 'SELECT adminID FROM admins WHERE username = "'.$this->escape($_POST['key']).'"';
        
        if(($rs = $this->query($sql)) && $rs->num_rows == 1)
        {
            list($adminID) = $rs->fetch_row();
        
            $this->partnerID = $_POST['partnerID'];
            $this->adminID   = $adminID;
            if($this->insert()) $response['success'] = true;
        }
        else $response['success'] = false;
        
        echo json_encode($response);
    }

}


