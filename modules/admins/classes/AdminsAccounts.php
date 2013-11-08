<?php
class AdminsAccounts extends ConnExtjs
{
	public $_table	= 'admins_accounts';
	public $_index	= 'accountID';
	public $_fields	= array('name',
							'active',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


}


