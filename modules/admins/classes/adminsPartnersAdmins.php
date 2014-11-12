<?php
class adminsPartnersAdmins extends ConnExtjs
{
	public $_table	= 'partners_admins';
	public $_index	= '';


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid($sql = '', $filter = true, $return = false)
    {
        // Check:
        $partners = $this->getPartnersByAdmin();
        if(array_key_exists($_REQUEST['partnerID'], $partners))
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
        if(array_key_exists($_POST['partnerID'], $partners))
        {
            $data = json_decode($_POST['data']);

            $sql = 'DELETE FROM '.$this->_table.' WHERE partnerID = '.$_POST['partnerID'].' AND adminID = '.(int) $data->adminID;
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
        global $aSession; $array = array();
        
        // Superusers can see all partners:
        if($GLOBALS['admin']['data']['superuser'] == 'Y') $sql = 'SELECT partnerID, name FROM partners ORDER BY name';
        else
        {
            $sql = 'SELECT pa.partnerID, p.name
                    FROM '.$this->_table.' as pa
                    INNER JOIN partners as p USING (partnerID)
                    WHERE pa.adminID = '.$GLOBALS['admin']['data']['adminID'].' AND p.active = "Y" AND p.deleted <> "Y"
                    ORDER BY p.name';
        }
                
        if(($rs = $this->query($sql)) && $rs->num_rows > 0)
        {
            while($row = $rs->fetch_assoc())
            {
                // Set default partner:
                if($rs->num_rows == 1 && !$aSession->exists('partnerID')) $aSession->set('partnerID', $row['partnerID']);

                $array[$row['partnerID']] = $row;
            }
        }

        return $array;
    }


    function setPartnerID()
    {
        // Check:
        $partners = $this->getPartnersByAdmin();
        if(array_key_exists($_POST['partnerID'], $partners) || (count($partners) > 1 && $_POST['partnerID'] == 0))
        {
            global $aSession;
            $aSession->set('partnerID', $_POST['partnerID']);
        }
    }

    
    public function addAdminToPartner()
    {
        $response['success'] = false;
        
        // Check:
        $partners = $this->getPartnersByAdmin();
        if(array_key_exists($_POST['partnerID'], $partners))
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


