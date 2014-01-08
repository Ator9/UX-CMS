<?php
class adminsAccounts extends ConnExtjs
{
	public $_table	= 'admins_accounts';
	public $_index	= 'accountID';
	public $_fields	= array('name',
							'active',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)
    
	protected $_dependantClasses = array('adminsAccountsAdmins', 'adminsAccountsConfig'); // delete childrens

	// ------------------------------------------------------------------------------- //


}


