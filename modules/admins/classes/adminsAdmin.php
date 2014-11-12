<?php
class adminsAdmin extends ConnExtjs
{
	public $_table	= 'admins';
	public $_index	= 'adminID';


	// ------------------------------------------------------------------------------- //


	public function login($user, $pass)
	{
        global $aSession;
	
		$sql = 'SELECT * FROM '.$this->_table.' 
		        WHERE username = "'.$this->escape($user).'" AND password = "'.$this->escape($pass).'" 
		        AND active = "Y" '.((in_array('deleted', $this->_fields)) ? 'AND deleted <> "Y"' : '');
		if(($rs = $this->query($sql)) && $rs->num_rows == 1)
		{
		    // Last Login:
		    $this->set($rs->fetch_assoc());
		    $this->last_login = date('Y-m-d H:i:s');
		    $this->update();

            $aSession->set('adminData', $this->getArray());

            $btn_text = (!empty($this->firstname)) ? $this->firstname.' '.$this->lastname : $this->username;
            $aSession->set('closeBtnTxt', $btn_text);

            // Login log:
            $log = new adminsLog;
            $log->log(array('classname' => get_class($log), 'task' => 'login', 'adminID' => $this->getID()));
		    
		    return true;
		}
		return false;
	}
}


