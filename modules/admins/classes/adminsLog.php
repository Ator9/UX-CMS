<?php
class adminsLog extends ConnExtjs
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'admins_logs';
	public $_index	= 'logID';


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid($sql = '', $filter = true, $return = false)
    {
        // Dates:
        if(isset($_GET['date_from'])) $where.= ' AND t1.date_created >= "'.$this->escape($_GET['date_from']).'"';
        if(isset($_GET['date_to'])) $where.= ' AND t1.date_created <= "'.$this->escape($_GET['date_to']).' 23:59:59"';
    
        $sql = 'SELECT t1.*, t2.username
                FROM '.$this->_table.' AS t1
                LEFT JOIN admins AS t2 USING (adminID)
                WHERE (((1 '.$where.')))';

        return parent::extGrid($sql);
    }
    

    // Log:
    public function log($data = array())
    {
        $this->set($data);

        if(isset($GLOBALS['admin']['data']['adminID'])) $this->adminID = $GLOBALS['admin']['data']['adminID'];
        $this->ip        = $_SERVER['REMOTE_ADDR'];

        return parent::insert();
    }
}
