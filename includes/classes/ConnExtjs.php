<?php
class ConnExtjs extends Conn
{
    public $_debug  = false;   // True to save all queries in adminsLog.
	public $_table	= '';      // Table name
	public $_index	= '';      // Table primary Key
	public $_fields	= array(); // Table columns (auto filled with "getColumns()" if not set)

	protected $_dependantClasses = array(); // Delete childrens
	

	// ------------------------------------------------------------------------------- //


    /**
     * Get - Single record Form load
     *
     * Example:
     * form.load({
     *   url: 'index.php?_class=className&_method=extGet',
     *   method: 'GET',
     *   params: {
     *       id: this.id
     *   },
     *   failure: function(form, action) {
     *     Ext.Msg.alert('Load failed', action.result.data);
     *   }
     * });
     *
     * @return Json
     */
    public function extGet($sql = '')
    {
        $response['success'] = false;
        $response['data']    = 'Record not found';
            
        if($sql != '')
        {
            $res = $this->query($sql);
            if($res->num_rows == 1)
            {
                $response['success'] = true;
                $response['data']    = $res->fetch_assoc();
            }
        }
        elseif($this->get($_GET[$this->_index]))
        {
            $response['success'] = true;
            $response['data']    = $this->getArray();
            
        }
        
        echo json_encode($response);
    }
    
    
    // Save (Form):
    public function extSave()
    {
        if(isset($_POST[$this->_index])) $this->get($_POST[$this->_index]);
        $this->set($_POST);
        
        if($this->save()) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Create:
    public function extCreate()
    {
        $data = json_decode($_POST['data'], true);
        
        if(isset($data[$this->_index])) $this->get($data[$this->_index]);
        $this->set($data);
        
        if($this->save())
        {
            $response['success'] = true;
            $response['data'][] = array($this->_index => $this->getID());
        }
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Delete:
    public function extDelete()
    {
        $data = json_decode($_POST['data']);

        if($this->get($data->{$this->_index}) && $this->delete()) $response['success'] = true;
        else $response['success'] = false;

        echo json_encode($response);
    }


    // Grid List:
    public function extGrid($sql = '', $filter = true, $return = false)
    {
        // Default select:
        if($sql=='') $sql = 'SELECT * FROM '.$this->_table.' WHERE ((('.((in_array('deleted', $this->_fields)) ? 'deleted="N"' : '1').')))';

        // Default filter:
        if($filter && isset($_REQUEST['search']) && trim($_REQUEST['search']) != '')
        {
            if(!isset($_REQUEST['columns'])) $_REQUEST['columns'] = array($this->_index);
            
            foreach($_REQUEST['columns'] as $field)
            {
            	$where[] = (is_numeric($_REQUEST['search'])) ? $field.'='.$this->escape($_REQUEST['search']) : $field.' LIKE "%'.$this->escape($_REQUEST['search']).'%"';
            }

            $sql = preg_replace('/WHERE \(\(\((.*)\)\)\)/', 'WHERE $1 AND ('.implode(' OR ', $where).') ', str_replace('WHERE 1', 'WHERE (((1)))', $sql), 1);
        }

        if(strpos($sql, 'ORDER BY')===false && $_REQUEST['sort'] != '') $sql.= ' ORDER BY '.$this->escape($_REQUEST['sort']).' '.$this->escape($_REQUEST['dir']);
        if(!isset($_REQUEST['csvExport']) && strpos($sql, 'LIMIT')===false) $sql.= ' LIMIT '.(int) $_REQUEST['start'].', '.(int) $_REQUEST['limit'];
        
        // Query SQL_CALC_FOUND_ROWS:
        $sql = preg_replace('/SELECT /', 'SELECT SQL_CALC_FOUND_ROWS ', $sql, 1); // 1 = only first match
        $rs  = $this->query($sql);

        if(isset($_REQUEST['csvExport']))
        {
            $csv = new CSVExport($_REQUEST['csvName']);
            $csv->putResultset($rs);
            $csv->export($_REQUEST['csvZip']=='true'); // Force boolean (true/false)
            exit;
        }

        if($rs->num_rows > 0)
        {
            while($row = $rs->fetch_assoc())
            {
                $response['data'][] = $row;
            }
        }

        if($return) return isset($response['data']) ? $response['data'] : array();

        $rs = $this->query('SELECT FOUND_ROWS()');
        list($response['totalCount']) = $rs->fetch_row();
        
    	echo json_encode($response);
    }
}
