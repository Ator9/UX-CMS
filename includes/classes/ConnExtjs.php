<?php
class ConnExtjs extends Conn
{
	public $_table	= '';
	public $_index	= '';
	public $_fields	= array();

	protected $_dependantClasses = array(); // delete()

	public $_debug  = false;
	

	// ------------------------------------------------------------------------------- //


    // Save:
    public function extSave()
    {
        $this->get($_POST[$this->_index]);
        
        $this->set($_POST);
        
        if($this->save()) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Create:
    public function extCreate()
    {
        $data = (array) json_decode(stripslashes($_POST['data']));

        $this->get($data[$this->_index]);

        $this->set($data);
        
        if($this->save()) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Delete:
    public function extDelete()
    {
        $data = json_decode(stripslashes($_POST['data']));

        if($this->get($data->{$this->_index}) && $this->delete()) $response['success'] = true;
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
                $where[] = $field.' LIKE "%'.$this->escape($_REQUEST['search']).'%"';
            }

            $sql = str_replace('WHERE 1', 'WHERE 1 AND ('.implode(' OR ', $where).') ', $sql);
        }

        if(strpos($sql, 'ORDER BY')===false && $_GET['sort']) $sql.= ' ORDER BY '.$this->escape($_REQUEST['sort']).' '.$this->escape($_REQUEST['dir']);
        if($_REQUEST['csvExport']!='Y' && strpos($sql, 'LIMIT')===false) $sql.= ' LIMIT '.(int) $_REQUEST['start'].', '.(int) $_REQUEST['limit'];
        
        // Query SQL_CALC_FOUND_ROWS:
        $sql = preg_replace('/SELECT /', 'SELECT SQL_CALC_FOUND_ROWS ', $sql, 1); // 1 = only first match
        $rs  = $this->query($sql);

        if($_REQUEST['csvExport'] == 'Y')
        {
            $csv = new CSVExport($_REQUEST['csvName']);
            $csv->putResultset($rs);
            $csv->export($_REQUEST['csvZip']=='true'); // Force boolean (true/false)
            exit;
        }
        
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


