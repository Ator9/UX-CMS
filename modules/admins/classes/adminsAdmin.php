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
							'active',
							'last_login',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


	public function login($user, $pass)
	{
        global $aSession;
	
		$sql = 'SELECT * FROM '.$this->_table.' WHERE username="'.$this->escape($user).'" AND password="'.$this->escape($pass).'" AND active="Y"';
		if(($rs = $this->query($sql)) && $rs->num_rows == 1)
		{
		    $this->set($rs->fetch_assoc());

            $aSession->set('adminData', $this->getData());

            // Log:
            $log = new adminsLog; // Guardo el error en base de datos
            $log->log(array('classname' => get_class($log), 'task' => 'login', 'adminID' => $this->getID()));

		    // Last Login:
		    $this->last_login = date('Y-m-d H:i:s');
		    $this->update();
		    
		    return true;
		}
		return false;
	}
}


