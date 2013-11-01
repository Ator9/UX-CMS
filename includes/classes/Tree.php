<?php

/**
 *
 * Nested Tree
 * Estructuramos todo para que el Root Node no se vea
 *
 */

class Tree extends Conn
{
	// Para iniciar el Arbol. Chequeo que exista el Nodo Primario. Lo creo.
	public function checkRoot($name='root')
	{
		$rs = parent::getList(array(), 1);
		if($rs->num_rows == 0)
		{
			parent::query('TRUNCATE '.$this->_table);

			$data['name'] 	  = $name;
			$data['lft']	  = 1;
			$data['rgt']  	  = 2;
			$data['parentID'] = 0;
		    $data['level']    = 0;
			parent::insert($data);
		}
	}


	public function update($data)
	{
		if($node = parent::get($data[$this->_index]))
		{
			// Si no cambia el nodo, update normal:
			if($node['parentID'] == $data['parentID']) return parent::update($data, $node[$this->_index]);


			// Necesito la info del nodo destino:
			$parent = parent::get($data['parentID']);

			// Chequeo que no quiera mover el nodo a uno de sus hijos:
			if($parent['lft'] > $node['lft'] && $parent['lft'] < $node['rgt']) return false;


			// Cambio de nodo - Varios pasos:
			$delta = $node['rgt'] - $node['lft'] + 1;

			// 1- Seteo lft y rgt en negativos (del nodo a mover y todos sus hijos):
			$sql = 'UPDATE '.$this->_table.'
					SET lft = 0-lft, rgt = 0-rgt
			 		WHERE lft BETWEEN '.$node['lft'].' AND '.$node['rgt'];
			parent::query($sql);

			// 2- Subo los nodos que estan a la derecha para que llenen el hueco (igual que en delete()):
			$sql = 'UPDATE '.$this->_table.'
					SET lft = CASE WHEN lft > '.$node['rgt'].' THEN lft-'.$delta.' ELSE lft END,
						rgt = CASE WHEN rgt > '.$node['rgt'].' THEN rgt-'.$delta.' ELSE rgt END
					WHERE rgt > '.$node['rgt'];
			parent::query($sql);




			// 3- TAREA=limpiar http://stackoverflow.com/questions/889527/mysql-move-node-in-nested-set/1274175#1274175
			$sql = 'UPDATE '.$this->_table.'
					SET lft = lft + '.$delta.'
					WHERE lft >= IF('.$parent['rgt'].' > '.$node['rgt'].', '.$parent['rgt'].' - '.$delta.', '.$parent['rgt'].')';
			parent::query($sql);

			$sql = 'UPDATE '.$this->_table.'
					SET rgt = rgt + '.$delta.'
					WHERE rgt >= IF('.$parent['rgt'].' > '.$node['rgt'].', '.$parent['rgt'].' - '.$delta.', '.$parent['rgt'].')';
			parent::query($sql);


			//4- TAREA=limpiar
			$sql = 'UPDATE '.$this->_table.'
					SET lft = 0-(lft)+IF('.$parent['rgt'].' > '.$node['rgt'].', '.$parent['rgt'].' - '.$node['rgt'].' - 1, '.$parent['rgt'].' - '.$node['rgt'].' - 1 + '.$delta.'),
				    	rgt = 0-(rgt)+IF('.$parent['rgt'].' > '.$node['rgt'].', '.$parent['rgt'].' - '.$node['rgt'].' - 1, '.$parent['rgt'].' - '.$node['rgt'].' - 1 + '.$delta.')
					WHERE lft <= 0-'.$node['lft'].' AND rgt >= 0-'.$node['rgt'];
			parent::query($sql);




			$this->levelBuilder();

			return parent::update($data, $node[$this->_index]);
		}
		return false;
	}


	// Acomodo el arbol e inserto:
	public function insert($data)
	{
		if($parent = parent::get($data['parentID']))
		{
			// Hago lugar (muevo para la derecha 2 lugares e inserto:
			$sql = 'UPDATE '.$this->_table.'
					SET lft = CASE WHEN lft > '.$parent['rgt'].' THEN lft+2 ELSE lft END,
						rgt = CASE WHEN rgt >='.$parent['rgt'].' THEN rgt+2 ELSE rgt END
					WHERE rgt >= '.$parent['rgt'];
			parent::query($sql);

			$ins 		  = $data;
			$ins['lft']   = $parent['rgt'];
			$ins['rgt']   = $parent['rgt'] + 1;
			$ins['level'] = $parent['level'] + 1;
			return parent::insert($ins);
		}
		return false;
	}


	// Borro el nodo y los hijos. Luego reacomodo el arbol (muevo a los que estan a la derecha):
	public function delete($indexID)
	{
		if($node = parent::get($indexID))
		{
			$sql = 'DELETE FROM '.$this->_table.' WHERE lft BETWEEN '.$node['lft'].' AND '.$node['rgt'];
			if(parent::query($sql))
			{
				$delta = $node['rgt'] - $node['lft'] + 1;

				$sql = 'UPDATE '.$this->_table.'
						SET lft = CASE WHEN lft > '.$node['rgt'].' THEN lft-'.$delta.' ELSE lft END,
							rgt = CASE WHEN rgt > '.$node['rgt'].' THEN rgt-'.$delta.' ELSE rgt END
						WHERE rgt > '.$node['rgt'];
				return parent::query($sql);
			}
		}
		return false;
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
