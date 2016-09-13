<?php
class SimpleFile extends Conn
{
	public $_dir  = 'files/';

	public $_table	= 'files';
	public $_index	= 'fileID';
	public $_fields	= array('title',
							'description',
							'filename',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');


	// ------------------------------------------------------------------------------- //


	public function update($data, $indexID)
	{
		if($old = parent::get($indexID))
		{
			if($old['filename'] != $data['filename'])
			{
				if(file_exists(ROOT.$this->_dir.$data['filename'])) return false; // No puedo renombrar un archivo pisando uno existente
				if(file_exists(ROOT.$this->_dir.$old['filename'])) rename(ROOT.$this->_dir.$old['filename'], ROOT.$this->_dir.$data['filename']);
			}

			return parent::update($data, $indexID);
		}
		return false;
	}

	public function insert($data)
	{
	    if(file_exists(ROOT.$this->_dir.$data['filename'])) return false;
	    return parent::insert($data);
	}

	public function upload($file, $name)
	{
	    $dir = ROOT.$this->_dir;

	    // Subo solo si no existe o si existe y esta actualizando:
		if($file['tmp_name'] && (!file_exists($dir.$name) || (file_exists($dir.$name) && $this->insert_id == 0) ))
		{
			if(!is_dir($dir))
			{
				mkdir($dir);
				chmod($dir, 0777);
			}

			if(move_uploaded_file($file['tmp_name'], $dir.$name)) return chmod($dir.$name, 0777);
		}
		return false;
	}


	function delete($indexID)
	{
		if($row = $this->get($indexID))
		{
			$path = ROOT.$this->_dir.$row['filename'];
			if(is_file($path) && file_exists($path)) unlink($path);
		}

		return parent::delete($indexID);
	}
}

/*
set_time_limit(0);
ini_set ('display_errors', true);
ini_set("post_max_size","64M");
ini_set("memory_limit","128M");

echo ini_get('post_max_size');
*/
