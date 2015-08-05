<?php
class adminsPartners extends ConnExtjs
{
	public $_table	= 'partners';
	public $_index	= 'partnerID';

	// ------------------------------------------------------------------------------- //

	// Grid List:
	public function extGrid($sql = '', $filter = true, $return = false)
	{
		if($GLOBALS['admin']['data']['superuser'] != 'Y')
		{
		    $sql = 'SELECT * FROM '.$this->_table.' WHERE partnerID IN ('.implode(',', array_keys($GLOBALS['admin']['data']['partners'])).')'; 
		    return parent::extGrid($sql);
		}
	
		return parent::extGrid();
	}
}

