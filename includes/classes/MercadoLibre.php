<?php
class MercadoLibre extends Conn
{
	public $_table	= '';
	public $_index	= 'ID';
	public $_fields	= array('parentID',
	                        'name',
							'level',
							'adult',
							'path');

	private $_parser;
	private $_xmlCtD_depth  = array();
	private $_xml_parent_id = array();
	private $_sql 			= array(); // almaceno todas las categorias para ejecutar en 1 solo query

	public $_gzip 	= 'Y';
	public $_prefix = 'ml_';


	// ------------------------------------------------------------------------------- //


	public function getCountries()
	{
		$data['mla'] = array('name'=>'Argentina'            ,'GMT'=>-3, 'symbol'=>'$',   'url'=>'mercadolibre.com.ar');
		$data['mlb'] = array('name'=>'Brasil'	            ,'GMT'=>-2, 'symbol'=>'R$',  'url'=>'mercadolivre.com.br');
		$data['mlc'] = array('name'=>'Chile'	            ,'GMT'=>-4, 'symbol'=>'$',   'url'=>'mercadolibre.cl');
		$data['mco'] = array('name'=>'Colombia'	            ,'GMT'=>-5, 'symbol'=>'$',   'url'=>'mercadolibre.com.co');
		$data['mcr'] = array('name'=>'Costa Rica'       	,'GMT'=>-6, 'symbol'=>'¢',   'url'=>'mercadolibre.co.cr');
		$data['mec'] = array('name'=>'Ecuador'	            ,'GMT'=>-5, 'symbol'=>'U$S', 'url'=>'mercadolibre.com.ec');
		$data['mlm'] = array('name'=>'Mexico'	            ,'GMT'=>-6, 'symbol'=>'$',   'url'=>'mercadolibre.com.mx');
		$data['mpa'] = array('name'=>'Panamá'	            ,'GMT'=>-5, 'symbol'=>'U$S', 'url'=>'mercadolibre.com.pa');
		$data['mpe'] = array('name'=>'Peru'	                ,'GMT'=>-5, 'symbol'=>'S/.', 'url'=>'mercadolibre.com.pe');
		$data['mpt'] = array('name'=>'Portugal'	            ,'GMT'=>+1, 'symbol'=>'€',   'url'=>'mercadolivre.pt');
		$data['mrd'] = array('name'=>'República Dominicana'	,'GMT'=>-4, 'symbol'=>'$',   'url'=>'mercadolibre.com.do');
		$data['mlu'] = array('name'=>'Uruguay'	            ,'GMT'=>-2, 'symbol'=>'$',   'url'=>'mercadolibre.com.uy');
		$data['mlv'] = array('name'=>'Venezuela'	        ,'GMT'=>-4, 'symbol'=>'BsF', 'url'=>'mercadolibre.com.ve');

		return $data;
	}


	// Actualizamos las tablas:
	public function reload($cod='')
	{
		foreach($this->getCountries() as $k => $value)
		{
			if(!is_numeric($cod) && $cod != $k) continue;

			$this->_table = $this->_prefix.$k;
			if(parent::isTable($this->_table))
			{
				parent::query('TRUNCATE '.$this->_table);

				$file = 'http://www.mercadolibre.com.ar/jm/categsXml?as_site_id='.strtoupper($k).'&gzip='.$this->_gzip;

				// Resets:
				$this->_xmlCtD_depth  = array();
				$this->_xml_parent_id = array();
				$this->_xml_parent_id[0] = 0;
				$this->_sql = array();

				$this->_parser = xml_parser_create();
				xml_set_object($this->_parser, $this);
				xml_set_element_handler($this->_parser, 'startElement', 'endElement');

				if($this->_gzip == 'Y') $fp = gzopen($file, 'r');
				else $fp = fopen($file, 'r');

				while($data = fread($fp, 4096))	xml_parse($this->_parser, $data, feof($fp));

                if(count($this->_sql) <= 25000) parent::query('INSERT INTO '.$this->_table.' (ID, name, parentID, level, adult) VALUES '.implode(',', $this->_sql));
                else
                {
                    $chunk = array_chunk($this->_sql, 25000, true); // Evitamos error "MySQL server has gone away"
				    parent::query('INSERT INTO '.$this->_table.' (ID, name, parentID, level, adult) VALUES '.implode(',', $chunk[0]));
				    parent::query('INSERT INTO '.$this->_table.' (ID, name, parentID, level, adult) VALUES '.implode(',', $chunk[1]));
				}
			}
		}
	}


	private function startElement($parser, $name, $attrs)
	{
	   if(isset($attrs['NAME']))
	   {
			$nivel = $this->_xmlCtD_depth[$parser]-1;
			$this->_xml_parent_id[$nivel] = $attrs['ID'];

			$this->_sql[] = '('.$attrs['ID'].', "'.parent::safe($attrs['NAME']).'", '.$this->_xml_parent_id[$nivel-1].', '.$nivel.', "'.$attrs['ADULT'].'") ';
	   }
	   $this->_xmlCtD_depth[$parser]++;
	}


	private function endElement($parser, $name)
	{
	   $this->_xmlCtD_depth[$parser]--;
	}


	// Chequeamos que esten creadas las tablas:
	public function add()
	{
		foreach($this->getCountries() as $k => $value)
		{
			parent::query('CREATE TABLE IF NOT EXISTS ml_'.$k.' (
							`ID` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT "0",
							`parentID` MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT "0",
							`name` VARCHAR(75) NOT NULL DEFAULT "",
							`level` TINYINT(1) UNSIGNED NOT NULL DEFAULT "0",
							`adult` CHAR(1) NOT NULL DEFAULT "",
							`path` VARCHAR(200) NOT NULL DEFAULT "",
	                        INDEX `ID` (`ID`),
							INDEX `parentID` (`parentID`),
							INDEX `path` (`path`)
						) COLLATE=`utf8_general_ci` ENGINE=InnoDB');
		}
	}


	// Armo los paths SEO (electronica-audio-y-video/home-theaters/5.1):
	public function pathsBuilder($cod='')
	{
		foreach($this->getCountries() as $k => $value)
		{
			if(!is_numeric($cod) && $cod != $k) continue;

			$this->_table = $this->_prefix.$k;
			if(parent::isTable($this->_table))
			{
				$rs = parent::query('SELECT * FROM '.$this->_table);
				if($rs->num_rows > 0)
				{
					while($row = $rs->fetch_assoc())
					{
						$data['path'] = $this->seoPath($row[$this->_index]);
						parent::update($data, $row[$this->_index]);

						if(++$counter%100 == 0)	echo $k.' => '.$data['path'].'<br>';flush();
					}
				}
			}
		}
	}


	private function seoPath($ID)
	{
	    $db = new Conn;
	    
		$cats = recursiveTree($db, $this->_table, $this->_index, 'parentID', $ID, true);
		krsort($cats);
		foreach($cats as $name) $seopath.= '/'.seo($name['name']);

		return $seopath;
	}


	public function delete($table)
	{
		return parent::query('DROP table IF EXISTS '.$this->_prefix.$table);
	}
}

set_time_limit(0); // Algunos procesos lentos
//ini_set('memory_limit', '512M');

