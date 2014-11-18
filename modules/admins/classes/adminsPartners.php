<?php
class adminsPartners extends ConnExtjs
{
	public $_table	= 'partners';
	public $_index	= 'partnerID';

	protected $_dependantClasses = array('adminsPartnersAdmins', 'adminsPartnersConfig'); // delete childrens

	// ------------------------------------------------------------------------------- //


}


