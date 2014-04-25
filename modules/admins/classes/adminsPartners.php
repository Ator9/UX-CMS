<?php
class adminsPartners extends ConnExtjs
{
	public $_table	= 'partners';
	public $_index	= 'partnerID';
	public $_fields	= array('name',
							'active',
							'adminID_created', // (Reserved) Automatic usage on insert (Conn.php)
							'adminID_updated', // (Reserved) Automatic usage on update (Conn.php)
							'date_created',    // (Reserved) Automatic usage on insert (Conn.php)
							'date_updated');   // (Reserved) Automatic usage on update (Conn.php)
    
	protected $_dependantClasses = array('adminsPartnersAdmins', 'adminsPartnersConfig'); // delete childrens

	// ------------------------------------------------------------------------------- //


}


