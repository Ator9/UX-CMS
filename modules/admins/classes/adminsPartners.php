<?php
class adminsPartners extends ConnExtjs
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'partners';
	public $_index	= 'partnerID';

	protected $_dependantClasses = array('adminsPartnersAdmins', 'adminsPartnersConfig'); // delete childrens

	// ------------------------------------------------------------------------------- //


}


