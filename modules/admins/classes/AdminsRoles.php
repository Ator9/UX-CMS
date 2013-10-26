<?php
class AdminsRoles extends ConnExt
{
	public $_table	= 'admins_roles';
	public $_index	= 'roleID';
	public $_fields	= array('name',
							'permission',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


}
