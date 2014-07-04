<?php
class adminsAdmin extends ConnExtjs
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'admins';
	public $_index	= 'adminID';
	public $_fields	= array('roleID',
	                        'username',
							'password',
							'email',
							'firstname',
							'lastname',
							'superuser',
							'last_login',
							'active',
							'deleted',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


	public function login($user, $pass)
	{
        global $aSession;
	
		$sql = 'SELECT * FROM '.$this->_table.' 
		        WHERE username = "'.$this->escape($user).'" AND password = "'.$this->escape($pass).'" AND active = "Y" AND deleted <> "Y"';
		if(($rs = $this->query($sql)) && $rs->num_rows == 1)
		{
		    // Last Login:
		    $this->set($rs->fetch_assoc());
		    $this->last_login = date('Y-m-d H:i:s');
		    $this->update();

            $aSession->set('adminData', $this->getArray());

            // Login log:
            $log = new adminsLog;
            $log->log(array('classname' => get_class($log), 'task' => 'login', 'adminID' => $this->getID()));
		    
		    return true;
		}
		return false;
	}
}


