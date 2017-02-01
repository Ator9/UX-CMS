<?php
/**
 * Nested Tree
 */
class Tree extends ConnExtjs
{
	// Tree startup, need "root":
	public function checkRoot($name = 'root')
	{
		if(parent::getCount() == 0)
		{
			parent::query('TRUNCATE '.$this->_table);

			$this->name 	= $name;
			$this->lft	    = 1;
			$this->rgt  	= 2;
			$this->parentID = 0;
			$this->level    = 0;
			
			parent::insert();
		}
	}
	
	
	/**
	* Convert classic parent/child categories to nested structure
	* Execute several times (parent/child existance)
	*
	* categoryID/parentID columns needed
	*
	* @param $table origin data
	*/
	public function convertToNested($table = 'origin_table')
	{
		$res = $this->query('SELECT * FROM '.$table.' ORDER BY parentID ASC');
		if($res->num_rows > 0)
		{
			$this->checkRoot();

			while($row = $res->fetch_assoc())
			{
				if($this->get($row[$this->_index])) continue;
				vd($row); flush();

				$this->setID($row[$this->_index]);
				$this->name 	= $row['name'];
				$this->parentID = ($row['parentID'] == 0) ? 1 : $row['parentID'];
				$this->insert(false);
			}
		}

		echo 'OK';
	}


	public function update()
    {
        // Need ORIGINAL node info:
        $orig = new $this;
        $orig->get($this->getID());
        
	    // Check que no cambien el parent del root:
	    if($orig->getID() == 1 && $this->parentID != 0) return false;
        
        // Check que no cambien el parent al ID propio:
	    if($orig->getID() == $this->parentID) return false;
		
	    // Same parent, normal update:
	    if($orig->parentID == $this->parentID) return parent::update();

        // Parent change. Need parent info:
	    $parent = new $this;
        if($parent->get($this->parentID))
        {
	        // Chequeo que no quiera mover el nodo a uno de sus hijos:
	        if($parent->lft > $orig->lft && $parent->lft < $orig->rgt) return false;


	        // Cambio de nodo - Varios pasos:
	        $delta = $orig->rgt - $orig->lft + 1;

	        // 1- Seteo lft y rgt en negativos (del nodo a mover y todos sus hijos):
	        $sql = 'UPDATE '.$this->_table.'
			        SET lft = 0-lft, rgt = 0-rgt
	         		WHERE lft BETWEEN '.$orig->lft.' AND '.$orig->rgt;
	        parent::query($sql);

	        // 2- Subo los nodos que estan a la derecha para que llenen el hueco (igual que en delete()):
	        $sql = 'UPDATE '.$this->_table.'
			        SET lft = CASE WHEN lft > '.$orig->rgt.' THEN lft-'.$delta.' ELSE lft END,
				        rgt = CASE WHEN rgt > '.$orig->rgt.' THEN rgt-'.$delta.' ELSE rgt END
			        WHERE rgt > '.$orig->rgt;
	        parent::query($sql);




	        // 3- TODO clean http://stackoverflow.com/questions/889527/mysql-move-node-in-nested-set/1274175#1274175
	        $sql = 'UPDATE '.$this->_table.'
			        SET lft = lft + '.$delta.'
			        WHERE lft >= IF('.$parent->rgt.' > '.$orig->rgt.', '.$parent->rgt.' - '.$delta.', '.$parent->rgt.')';
	        parent::query($sql);

	        $sql = 'UPDATE '.$this->_table.'
			        SET rgt = rgt + '.$delta.'
			        WHERE rgt >= IF('.$parent->rgt.' > '.$orig->rgt.', '.$parent->rgt.' - '.$delta.', '.$parent->rgt.')';
	        parent::query($sql);


	        // 4- TODO clean
	        $sql = 'UPDATE '.$this->_table.'
			        SET lft = 0-(lft)+IF('.$parent->rgt.' > '.$orig->rgt.', '.$parent->rgt.' - '.$orig->rgt.' - 1, '.$parent->rgt.' - '.$orig->rgt.' - 1 + '.$delta.'),
		            	rgt = 0-(rgt)+IF('.$parent->rgt.' > '.$orig->rgt.', '.$parent->rgt.' - '.$orig->rgt.' - 1, '.$parent->rgt.' - '.$orig->rgt.' - 1 + '.$delta.')
			        WHERE lft <= 0-'.$orig->lft.' AND rgt >= 0-'.$orig->rgt;
	        parent::query($sql);

            // Update "level" column:
	        $this->levelBuilder();
            
            // Final update:
            unset($this->_fields[array_search('lft', $this->_fields)]);
            unset($this->_fields[array_search('rgt', $this->_fields)]);
            unset($this->_fields[array_search('level', $this->_fields)]);
	        return parent::update();
	    }
	    
	    return false;
    }


	// Acomodo el arbol e inserto:
	public function insert($auto_increment = true)
	{
	    // Need parent info:
	    $parent = new $this;
        if($parent->get($this->parentID))
        {
		    // Hago lugar (muevo para la derecha 2 lugares e inserto:
		    $sql = 'UPDATE '.$this->_table.'
				    SET lft = CASE WHEN lft > '.$parent->rgt.' THEN lft+2 ELSE lft END,
					    rgt = CASE WHEN rgt >='.$parent->rgt.' THEN rgt+2 ELSE rgt END
				    WHERE rgt >= '.$parent->rgt;
		    parent::query($sql);

		    $this->lft   = $parent->rgt;
		    $this->rgt   = $parent->rgt + 1;
		    $this->level = $parent->level + 1;
		
		    return parent::insert($auto_increment);
		}
		
		return false;
	}


	// Borro el nodo y los hijos. Luego reacomodo el arbol (muevo a los que estan a la derecha):
	public function delete($hard = false)
	{
		$sql = 'DELETE FROM '.$this->_table.' WHERE lft BETWEEN '.$this->lft.' AND '.$this->rgt;
		if(parent::query($sql))
		{
			$delta = $this->rgt - $this->lft + 1;

			$sql = 'UPDATE '.$this->_table.'
					SET lft = CASE WHEN lft > '.$this->rgt.' THEN lft-'.$delta.' ELSE lft END,
						rgt = CASE WHEN rgt > '.$this->rgt.' THEN rgt-'.$delta.' ELSE rgt END
					WHERE rgt > '.$this->rgt;
			return parent::query($sql);
		}
	}


	// Obtengo la profundidad del arbol:
	public function getDepth()
	{
		$sql 	 = 'SELECT MAX(level) FROM '.$this->_table;
		$rs  	 = parent::query($sql);
    	list($d) = $rs->fetch_row();

    	return $d;
	}


	public function getPath($indexID)
	{
		$data = array();

		$sql = 'SELECT parent.*
				FROM '.$this->_table.' AS t
				INNER JOIN '.$this->_table.' AS parent
				WHERE t.lft BETWEEN parent.lft AND parent.rgt
				AND t.'.$this->_index.' = "'.$indexID.'"
				AND parent.parentID <> 0
				ORDER BY parent.lft';

		if($rs = parent::query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$data[] = $row;
			}
		}
		return $data;
	}
	
	
	// Generate canonical name (path):
	public function generateCanonicalName($primaryID = 0, $separator = ' > ')
	{
		$sql = 'SELECT * FROM '.$this->_table.(($primaryID > 0) ? ' WHERE '.$this->_index.' = '.$primaryID : '');
		$res = $this->query($sql);

		if($res->num_rows > 0)
		{
			while($row = $res->fetch_assoc())
			{
				$canonical = [];
				foreach($this->getPath($row[$this->_index]) as $data)
				{
					$canonical[] = $data['name'];

				}

				$values[] = '('.$row[$this->_index].', "'.implode($separator, $canonical).'")';
			}

			// Separo en chunks porque el query es muy largo:
		        foreach(array_chunk($values, 100) as $value)
		        {
				$sql = 'INSERT INTO '.$this->_table.' ('.$this->_index.', canonical_name)
						VALUES '.implode(',', $value).'
						ON DUPLICATE KEY UPDATE canonical_name = VALUES(canonical_name)';
		        	$this->query($sql);
		        }
		}
	}


	// Build select:
	public function getTree()
	{
		$data  = array();

		$sql = 'SELECT CONCAT( REPEAT(" >> ", COUNT(parent.'.$this->_index.') - 1) , t.name) AS name, t.'.$this->_index.', t.parentID
				FROM '.$this->_table.' AS t
				INNER JOIN '.$this->_table.' AS parent
				WHERE t.lft BETWEEN parent.lft AND parent.rgt
				AND parent.parentID <> 0
				GROUP BY t.'.$this->_index.'
				ORDER BY t.lft';

		if($rs = parent::query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$data[$row[$this->_index]] = $row;
			}
		}
		return $data;
	}


	// Seteo/actualizo level para todos los items (TAREA = hacer en 1 query solamente:
	private function levelBuilder()
	{
		$sql = 'SELECT COUNT(parent.'.$this->_index.') AS level, t.'.$this->_index.'
				FROM '.$this->_table.' AS t
				INNER JOIN '.$this->_table.' AS parent
				WHERE t.lft BETWEEN parent.lft AND parent.rgt AND parent.parentID <> 0
				GROUP BY t.'.$this->_index;

		if($rs = parent::query($sql))
		{
			while($row = $rs->fetch_assoc())
			{
				$sql = 'UPDATE '.$this->_table.' SET level = '.$row['level'].' WHERE '.$this->_index.' = '.$row[$this->_index];
				parent::query($sql);
			}
		}
	}


	// UI para ordenar:
	public function uiCustomSort()
	{
		$parentID = is_numeric($_POST['parentID']) ? $_POST['parentID'] : 1;

		$params['WHERE'] 	= 'parentID="'.$parentID.'"';
		$params['ORDER BY'] = 'lft';
		$rs = parent::getList($params);

		while($row = $rs->fetch_assoc())
		{
			$li.= '<li class="ui-state-default">
					  <div class="fl w25 tr bold">'.++$i.'</div>&nbsp; '.$row['name'].'
					  <input type="hidden" name="order[]" value="'.$row[$this->_index].'" />
				   </li>';
		}

		$html ='<div id="custom_sort" title="Ordenar '.$this->_name.'">
					<form id="form_sort">
						<ul id="sortable">'.$li.'</ul>
						<input type="hidden" name="parentID" value="'.$parentID.'" />
					</form>
				</div>
				<script type="text/javascript">
				$(function(){
					$("#sortable").sortable({
						placeholder: "ui-state-highlight"
					});
					$("#sortable").disableSelection();
				});
				</script>
				<style type="text/css">
				#sortable li{margin-bottom:5px;padding:5px;font-family:"Trebuchet Ms",Arial,Helvetica,sans-serif}
				.ui-state-highlight{height:1.5em}
				</style>';

		echo $html;
	}


	// Ordenar:
	public function customSort()
	{
		$params['WHERE'] 	= 'parentID="'.$_POST['parentID'].'"';
		$params['ORDER BY'] = 'lft';
		$rs = parent::getList($params);

		$i = 0;
		while($row = $rs->fetch_assoc())
		{
			if($row[$this->_index] != $_POST['order'][$i])
			{
				$new = parent::get($_POST['order'][$i]);

				$delta = $new['rgt'] - $new['lft'];
				$diff  = $new['lft'] - $row['lft'];


				// 1- Seteo lft y rgt en negativos (del nodo a mover y todos sus hijos):
				$sql = 'UPDATE '.$this->_table.'
						SET lft = 0-lft, rgt = 0-rgt
				 		WHERE lft BETWEEN '.$new['lft'].' AND '.$new['rgt'];
				parent::query($sql);


				$sql = 'UPDATE '.$this->_table.'
						SET lft = lft + '. ($delta+1) .' , rgt = rgt + '. ($delta+1) .'
						WHERE lft BETWEEN '.$row['lft'].' AND '.$row['rgt'].' OR lft BETWEEN '.$row['lft'].' AND '.$new['lft'];
				parent::query($sql);


				$sql = 'UPDATE '.$this->_table.'
						SET lft = 0-lft - '. $diff .' , rgt = 0-rgt - '. $diff .'
				 		WHERE lft <= 0-'.$new['lft'].' AND rgt >= 0-'.$new['rgt'];
				parent::query($sql);


				return $this->customSort();
			}
			$i++;
		}
		return true;
	}
}

/**
 * Tips:
 *
 *
 * The root will always have a 1 in its lft column and twice the number of nodes in its rgt column
 * SELECT * FROM table WHERE lft = 1
 *
 *
 * A leaf node is one that has no children under it.
 * In the nested sets table the difference between the (lft, rgt) values of leaf nodes is always 1
 * SELECT * FROM table WHERE lft = (rgt - 1)
 *
 *
 */

/*

CREATE TABLE `categories` (
	`categoryID` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL DEFAULT '',
	`seo` VARCHAR(100) NOT NULL DEFAULT '',
	`lft` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT 'Necesito valores negativos para la operacion de mover nodos',
	`rgt` SMALLINT(6) NOT NULL DEFAULT '0' COMMENT 'Necesito valores negativos para la operacion de mover nodos',
	`parentID` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
	`level` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`status` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`adminID_created` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
	`adminID_updated` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
	`date_created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`date_updated` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`categoryID`),
	UNIQUE INDEX `seo` (`seo`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;

*/
