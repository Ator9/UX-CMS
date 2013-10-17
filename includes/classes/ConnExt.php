<?
class ConnExt extends Conn
{
	public $_table	= '';
	public $_index	= '';
	public $_fields	= array();

	protected $_dependant_classes = array(); // delete()

	public $_debug  = false;
	

	// ------------------------------------------------------------------------------- //


    // Save:
    public function extSave()
    {
        if($this->save($_POST, $_POST[$this->_index])) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Delete:
    public function extDelete()
    {
        $data = json_decode(stripslashes($_POST['data']));
        
        if($this->delete($data->{$this->_index})) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List:
    public function extGrid($sql='', $filter=true)
    {
        // Default select:
        if($sql=='') $sql = 'SELECT * FROM '.$this->_table.' WHERE 1';

        // Default filter:
        if($filter && isset($_REQUEST['search']))
        {
            if(!isset($_REQUEST['columns'])) $_REQUEST['columns'] = array($this->_index);
            
            foreach($_REQUEST['columns'] as $field)
            {
                $filter[] = $field.' LIKE "%'.$this->escape($_REQUEST['search']).'%"';
            }

            $sql = str_replace('WHERE 1', 'WHERE 1 AND ('.implode(' OR ', $filter).') ', $sql);
        }

        if(strpos($sql, 'ORDER BY')===false && $_GET['sort']) $sql.= ' ORDER BY '.$this->escape($_REQUEST['sort']).' '.$this->escape($_REQUEST['dir']);
        if(strpos($sql, 'LIMIT')===false) $sql.= ' LIMIT '.(int) $_REQUEST['start'].', '.(int) $_REQUEST['limit'];
        
        // SELECT extra param:
        $sql = str_replace('SELECT ', 'SELECT SQL_CALC_FOUND_ROWS ', $sql);

        // Query:   
        $rs = $this->query($sql);
        if($rs->num_rows>0)
        {
            while($row = $rs->fetch_assoc())
            {
                $response['data'][] = $row;
            }
        }

        $rs = $this->query('SELECT FOUND_ROWS()');
        list($response['totalCount']) = $rs->fetch_row();
        
    	echo json_encode($response);
    }
}
?>
