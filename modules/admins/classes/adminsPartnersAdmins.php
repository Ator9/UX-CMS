<?php
class adminsPartnersAdmins extends ConnExtjs
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'partners_admins';
	public $_index	= '';


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid()
    {
        // Check:
        $partners = $this->getPartnersByAdmin();
        if($GLOBALS['admin']['data']['superuser'] == 'Y' || array_key_exists($_REQUEST['partnerID'], $partners))
        {
            $sql = 'SELECT adm.adminID, adm.username, adm.last_login, adm.email
                    FROM '.$this->_table.' as acc
                    INNER JOIN admins as adm ON (acc.adminID = adm.adminID AND partnerID = '.$_REQUEST['partnerID'].')
                    WHERE 1';
            return parent::extGrid($sql);
        }

        echo json_encode(array('success' => true));
    }


    // Delete:
    public function extDelete()
    {
        $response['success'] = false;
        
        // Check:
        $partners = $this->getPartnersByAdmin();
        if($GLOBALS['admin']['data']['superuser'] == 'Y' || array_key_exists($_POST['partnerID'], $partners))
        {
            $data = json_decode(stripslashes($_POST['data']));

            $sql = 'DELETE FROM '.$this->_table.' WHERE partnerID = '.(int) $_POST['partnerID'].' AND adminID = '.(int) $data->adminID;
            if($this->query($sql)) $response['success'] = true;
        }

        echo json_encode($response);
    }


    /**
     * Get associated partners.
     *
     * @return array
     */
    public function getPartnersByAdmin()
    {
        global $aSession;
    
        $sql = 'SELECT acc.partnerID, acc.name
                FROM '.$this->_table.' as aa
                INNER JOIN partners as acc USING (partnerID)
                WHERE adminID = '.$GLOBALS['admin']['data']['adminID'].' AND active = "Y"
                ORDER BY name';
                
        if(($rs = $this->query($sql)) && $rs->num_rows > 0)
        {
            while($row = $rs->fetch_assoc())
            {
                if(!$aSession->exists('partnerID')) $aSession->set('partnerID', $row['partnerID']);

                $array[$row['partnerID']] = $row;
            }
        }

        return (array) $array;
    }


    function setPartnerID()
    {
        // Check:
        $partners = $this->getPartnersByAdmin();
        if(array_key_exists($_POST['partnerID'], $partners))
        {
            global $aSession;
            $aSession->set('partnerID', $_POST['partnerID']);
        }
    }

    
    // E:
    public function addAdminToPartner()
    {
        $response['success'] = false;
        
        // Check:
        $partners = $this->getPartnersByAdmin();
        if($GLOBALS['admin']['data']['superuser'] == 'Y' || array_key_exists($_POST['partnerID'], $partners))
        {
            $sql = 'SELECT adminID FROM admins WHERE username = "'.$this->escape($_POST['key']).'"';
            if(($rs = $this->query($sql)) && $rs->num_rows == 1)
            {
                list($adminID) = $rs->fetch_row();
            
                $this->partnerID = $_POST['partnerID'];
                $this->adminID   = $adminID;
                if($this->insert()) $response['success'] = true;
            }
        }
        
        echo json_encode($response);
    }

}


