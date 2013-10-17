<?
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
		$sql = 'SELECT * FROM '.$this->_table.' WHERE username="'.parent::escape($user).'" AND password="'.parent::escape($pass).'" AND active="Y"';
		if($rs = parent::query($sql))
		{
		    $row = $rs->fetch_assoc();

		    // Last Login:
		    parent::update(array('last_login'=>date('Y-m-d H:i:s')), $row[$this->_index]);
		    
		    return $row;
		}
		return false;
	}
}
?>
