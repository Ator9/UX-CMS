<?php
class Admins extends ConnExt
{
	public $_table	= 'admins';
	public $_index	= 'adminID';
	public $_fields	= array('roleID',
	                        'username',
							'password',
							'email',
							'firstname',
							'lastname',
							'superuser',
							'active',
							'last_login',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


	public function login($user, $pass)
	{
        global $aSession, $aLog;
	
		$sql = 'SELECT * FROM '.$this->_table.' WHERE username="'.$this->escape($user).'" AND password="'.$this->escape($pass).'" AND active="Y"';
		if(($rs = $this->query($sql)) && $rs->num_rows == 1)
		{
		    $this->set($rs->fetch_assoc());

		    $aSession->set('adminID',   $this->getID());
            $aSession->set('adminData', $this->getData());

            // Log:
            $aLog->log('login');

		    // Last Login:
		    $this->last_login = date('Y-m-d H:i:s');
		    $this->update();
		    
		    return true;
		}
		return false;
	}
}
