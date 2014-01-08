<?php
class adminsRoles extends ConnExtjs
{
	public $_table	= 'admins_roles';
	public $_index	= 'roleID';
	public $_fields	= array('name',
							'permission',
							'adminID_created',
							'adminID_updated',
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)


	// ------------------------------------------------------------------------------- //


}
