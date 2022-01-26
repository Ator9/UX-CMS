<?php
/**
 * Database Connection Class
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 *
 * Reserved column names (automatic usage):
 * - deleted         // insert() & delete()
 * - adminID_created // insert()
 * - adminID_updated // update()
 * - date_created    // insert()
 * - date_updated    // update()
 *
 *
 * Transactions:
 * $this->autocommit(false);
 * -- all your quries --
 * $this->commit();
 *
 */

class Conn extends mysqli
{
	public $_debug  = false;   // True to save all queries (adminsLog)
	public $_table	= '';      // Table name
	public $_index	= '';      // Table primary Key
	public $_fields	= array(); // Table columns (auto filled with "getColumns()" if not set)

	protected $_extendedClasses  = array(); // Insert, Update (unique index + foregin key parent table)
	protected $_dependantClasses = array(); // Delete childrens


	// ------------------------------------------------------------------------------- //


	function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $db = DB_NAME)
	{
		@parent::__construct($host, $user, $pass, $db);
		if(mysqli_connect_errno()) exit('Database connection error');
		if(!parent::set_charset('utf8mb4')) exit('Database utf8mb4 error');

		if($this->_table != '' && empty($this->_fields)) $this->_fields = $this->getColumns(); // automatic fields
		elseif($this->_index != '') array_unshift($this->_fields, $this->_index); // adds index to field list
	}


	// mysqli_query returns FALSE on failure.
	// For successful SELECT, SHOW, DESCRIBE or EXPLAIN queries mysqli_query() will return a result object.
	// For other successful queries mysqli_query() will return TRUE.
	public function query($sql, $resultmode = MYSQLI_STORE_RESULT)
	{
		if($this->_debug) $this->logQuery($sql, 'SQL Debug');
		if($result = parent::query($sql)) return $result;

		$this->logQuery($sql, 'SQL Error');
		if(mysqli_errno($this) && LOCAL) throw new Exception(mysqli_error($this).' '.$sql);
		return false;
	}


    /**
     * Get single row with PK or custom column
     *
     * @return Boolean
     */
	public function get($value, $field = '')
	{
	    if($field == '' || !in_array($field, $this->_fields)) $field = $this->_index;

		$sql = 'SELECT * FROM '.$this->_table.' WHERE '.$field.' = "'.$this->escape($value).'" LIMIT 1';
		if(($res = $this->query($sql)) && $res->num_rows == 1)
		{
		    $this->set($res->fetch_assoc());
		    return true;
		}
		return false;
	}


    public function getList($sql='')
	{
		if($sql=='') $sql = 'SELECT t1.* FROM '.$this->_table.' AS t1';
		return $this->query($sql);
	}


	public function save($auto_increment = true)
	{
		if($this->getID()) return $this->update();
		return $this->insert($auto_increment);
	}


	public function insert($auto_increment = true)
	{
		foreach($this->_fields as $field)
		{
			if(isset($this->$field))
			{
			    $arr[$field] = ($this->$field != 'NULL') ? '"'.$this->escape($this->$field).'"' : 'NULL';
			}
		}

		if($auto_increment === true) unset($arr[$this->_index]);
		if(in_array('deleted', $this->_fields)) $arr['deleted'] = '"N"';
		if(in_array('date_created', $this->_fields) && !isset($this->date_created)) $arr['date_created'] = 'NOW()';
		if(isset($GLOBALS['admin']['data']['adminID']) && in_array('adminID_created', $this->_fields)) $arr['adminID_created'] = (int) $GLOBALS['admin']['data']['adminID'];

		$sql = 'INSERT IGNORE INTO '.$this->_table.' ('.implode(',', array_keys($arr)).') VALUES ('.implode(',', $arr).')';
		if($this->query($sql))
		{
			if($this->insert_id > 0)
			{
				$this->setID($this->insert_id);

		        // Extended Classes (foreign keys, unique):
		        foreach($this->_extendedClasses as $className)
				{
					$db = new $className();
            		foreach($db->_fields as $field)
					{
    					if(isset($this->$field)) $db->$field = $this->$field;
    				}
    				$db->setID($this->getID());
            		$db->insert(false);
				}
			}
			return true;
		}
		return false;
	}


	public function update()
	{
		foreach($this->_fields as $field)
		{
			if(isset($this->$field))
			{
				$arr[$field] = ($this->$field != 'NULL') ? $field.' = "'.$this->escape($this->$field).'"' : $field.' = NULL';
			}
		}

		unset($arr['date_updated']);
		if(isset($GLOBALS['admin']['data']['adminID']) && in_array('adminID_updated', $this->_fields)) $arr['adminID_updated'] = 'adminID_updated = '.(int) $GLOBALS['admin']['data']['adminID'];

		$sql = 'UPDATE IGNORE '.$this->_table.' SET '.implode(', ', $arr).' WHERE '. $this->_index.' = "'.$this->getID().'"';
		if($this->query($sql))
        {
            // Extended Classes (foreign keys, unique):
            foreach($this->_extendedClasses as $className)
    		{
    			$db = new $className();
                if(!$db->get($this->getID()))
                {
                    $db->setID($this->getID());
                    $db->insert(false); // Si no existe lo creo
                }

                foreach($db->_fields as $field)
        		{
        			if(isset($this->$field)) $db->$field = $this->$field;
        		}

                $db->update();
    		}
            return true;
        }
        return false;
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


	public function set($data = array())
    {
        foreach($this->_fields as $field)
        {
            if(isset($data[$field])) $this->$field = $data[$field];
        }
    }


    public function getID()
    {
        if(isset($this->{$this->_index})) return $this->{$this->_index};
        return false;
    }


    public function setID($id)
    {
        if($this->_index != '') $this->{$this->_index} = $id;
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
     * Get table data in array format
     *
     * @return Array
     */
    public function getArray()
    {
        foreach($this->_fields as $field) $arr[$field] = isset($this->$field) ?  $this->$field : '';
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


	public function escape($str)
    {
        // if(get_magic_quotes_gpc()) $str = stripslashes($str);
        $str = trim($str);
        return parent::real_escape_string($str);
    }


    // Query logger:
	public function logQuery($sql, $task='SQL')
	{
        $log = new adminsLog;
        $data['classname'] = get_class($this);
        $data['task']      = $task;
        $data['comment']   = (mysqli_errno($this) ? mysqli_error($this).'<br>' : '').$sql;
        $log->log($data);
	}
}
