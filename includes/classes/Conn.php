<?php
/**
 * Database Connection Class
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Reserved column names (automatic usage):
 * - deleted         // insert() & delete()
 * - adminID_created // insert()
 * - adminID_updated // update()
 * - date_created    // insert()
 * - date_updated    // update()
 *
 */
 
class Conn extends mysqli
{
    public $_debug  = false; // True to save all queries (adminsLog)
	public $_table	= 'table';
	public $_index	= 'table_primary';
	public $_fields	= array();

	protected $_dependantClasses = array(); // delete childrens
	
	
	// ------------------------------------------------------------------------------- //


	function __construct($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $db=DB_NAME)
	{
		parent::__construct($host, $user, $pass, $db);
		if(mysqli_connect_errno()) throw new Exception(mysqli_connect_error());
		if(!parent::set_charset('utf8')) throw new Exception(mysqli_error($this));
		
		if(empty($this->_fields)) $this->_fields = $this->getColumns(); // automatic fields
		elseif($this->_index != '') array_push($this->_fields, $this->_index); // adds index to field list
	}


	// mysqli_query returns FALSE on failure.
	// For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query() will return a result object.
	// For other successful queries mysqli_query() will return TRUE.
	public function query($sql)
	{
		if($this->_debug) $this->logQuery($sql, 'SQL Debug');
		if($result = parent::query($sql)) return $result;
		
	    $this->logQuery($sql, 'SQL Error');
	    if(LOCAL) throw new Exception(mysqli_error($this).' '.$sql);
	    return false;
	}


	// Returns NULL if there are no more rows in resultset.
	public function get($indexID)
	{
		$sql = 'SELECT * FROM '.$this->_table.' WHERE '.$this->_index.' = "'.$this->escape($indexID).'" LIMIT 1';
		if(($res = $this->query($sql)) && $res->num_rows == 1)
		{
		    $this->set($res->fetch_assoc());
		    return true;
		}
		return false;
	}


	// Returns NULL if there are no more rows in resultset.
	public function getBy($field, $value)
	{
		if(in_array($field, $this->_fields))
		{
			$sql = 'SELECT * FROM '.$this->_table.' WHERE '.$field.' = "'.$this->escape($value).'" LIMIT 1';
			if(($res = $this->query($sql)) && $res->num_rows == 1)
			{
			    $this->set($res->fetch_assoc());
			    return true;
			}
		}
		return false;
	}
	

    public function getList($sql='')
	{
		if($sql=='') $sql = 'SELECT t1.* FROM '.$this->_table.' AS t1';

		return $this->query($sql);
	}


	public function save()
	{
        if($this->getID()) return $this->update();
        return $this->insert();
	}


	public function insert()
	{
		foreach($this->_fields as $field)
		{
			$arr[$field] = '"'.$this->escape($this->$field).'"';
		}

        if(in_array('deleted', $this->_fields)) $arr['deleted'] = '"N"';
		if(in_array('date_created', $this->_fields)) $arr['date_created'] = 'NOW()';
		if(in_array('adminID_created', $this->_fields)) $arr['adminID_created'] = '"'.$GLOBALS['admin']['data']['adminID'].'"';

		$sql = 'INSERT IGNORE INTO '.$this->_table.' ('.implode(',', array_keys($arr)).') VALUES ('.implode(',', $arr).')';
		if($this->query($sql))
		{
		    if($this->_index != '') $this->setID($this->insert_id);
		    return true;
		}
		return false;
	}


	public function update()
	{
		foreach($this->_fields as $field)
		{
			$arr[$field] = $field.' = "'.$this->escape($this->$field).'"';
	    }
		
        unset($arr['date_updated']);
		if(in_array('adminID_updated', $this->_fields)) $arr['adminID_updated'] = 'adminID_updated = "'.$GLOBALS['admin']['data']['adminID'].'"';

		$sql = 'UPDATE IGNORE '.$this->_table.' SET '.implode(', ', $arr).' WHERE '. $this->_index.' = "'.$this->getID().'"';
		return $this->query($sql);
	}


	public function delete($hard = false)
	{
	    // Soft delete:
        if(in_array('deleted', $this->_fields) && $hard === false)
        {
            $this->deleted = 'Y';
            return $this->update();
        }
	
		foreach($this->_dependantClasses as $className)
		{
			$db = new $className();
			if($db->_index != '') // with primary index (checks more _dependantClasses)
			{
                $res = $db->getList('SELECT * FROM '.$db->_table.' WHERE '.$this->_index.' = "'.$this->escape($this->getID()).'"');
                while($row = $res->fetch_assoc())
                {
                    if($db->get($row[$db->_index])) $db->delete($hard);
                }
			}
			else // no primary index (no _dependantClasses)
            {
                $sql = 'DELETE FROM '.$db->_table.' WHERE '.$this->_index.' = "'.$this->escape($this->getID()).'"';
                $this->query($sql);
            }
		}

		$sql = 'DELETE FROM '.$this->_table.' WHERE '.$this->_index.' = "'.$this->escape($this->getID()).'"';
		return $this->query($sql);
	}


	public function set($data=array())
    {
        foreach($this->_fields as $field)
        {
            $this->$field = isset($data[$field]) ? $data[$field] : $this->$field;
        }
    }


    public function getID()
    {
        return $this->{$this->_index};
    }


    public function setID($id)
    {
        $this->{$this->_index} = $id;
    }


    /**
     * Get table columns
     *
     * @return Array
     */
    public function getColumns()
	{
		$sql = 'SHOW COLUMNS FROM '.$this->_table;
		$res = $this->query($sql);
	    while($row = $res->fetch_assoc()) $fields[] = $row['Field'];

    	return $fields;
	}
    
    
    /**
     * Get table data
     *
     * @return Array
     */
    public function getData()
    {
        foreach($this->_fields as $field) $arr[$field] = $this->$field;
        
        return $arr;
    }


    /**
     * Get row count
     *
     * @return Int
     */
    public function getCount()
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->_table;
		$res = $this->query($sql);
		
    	list($c) = $res->fetch_row();
    	return $c;
	}


	// Check for available field:
	public function isAvailable($field, $value)
	{
		if(in_array($field, $this->_fields))
		{
			$sql = 'SELECT '.$field.' FROM '.$this->_table.' WHERE '.$field.' = "'.$this->escape($value).'" LIMIT 1';
			$res = $this->query($sql);
			if($res->num_rows == 0) return true;
		}
		return false;
	}


	public function escape($str)
    {
        if(get_magic_quotes_gpc()) $str = stripslashes($str);
        $str = trim($str);
        return parent::real_escape_string($str);
    }

	
    // Query logger:
	public function logQuery($sql, $task='SQL')
	{
        $log = new adminsLog;
        $data['classname'] = get_class($this);
        $data['task']      = $task;
        $data['comment']   = (mysqli_error($this) ? mysqli_error($this).'<br>' : '').$sql;
        $log->log($data);
	}
}


