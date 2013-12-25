<?php
class adminsAccounts extends ConnExtjs
{
	public $_table	= 'admins_accounts';
	public $_index	= 'accountID';
	public $_fields	= array('name',
							'active',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');
    
	protected $_dependantClasses = array('adminsAccountsAdmins', 'adminsAccountsConfig'); // delete childrens

	// ------------------------------------------------------------------------------- //


}


