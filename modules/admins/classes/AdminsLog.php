<?php
class AdminsLog extends ConnExt
{
	public $_table	= 'admins_logs';
	public $_index	= 'logID';
	public $_fields	= array('adminID',
	                        'task',
							'comment',
							'ip',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


    // Grid List:
    public function extGrid()
    {
        $sql = 'SELECT t1.*, t2.username
                FROM '.$this->_table.' AS t1
                LEFT JOIN admins AS t2 USING (adminID)
                WHERE 1';

        return parent::extGrid($sql);
    }
    

    // Log:
    public function log($task, $comment='')
    {
        global $aSession;
        if(is_object($aSession)) $this->adminID = $aSession->get('adminID');
        
        $this->task    = $task;
        $this->comment = $comment;
        $this->ip      = $_SERVER['REMOTE_ADDR'];

        return parent::insert($data);
    }
}
