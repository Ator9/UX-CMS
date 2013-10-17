<?
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
        global $session;
        if(is_object($session)) $data['adminID'] = $session->get('adminID');
        
        $data['task']    = $task;
        $data['comment'] = $comment;
        $data['ip']      = $_SERVER['REMOTE_ADDR'];

        return parent::insert($data);
    }
}
?>
