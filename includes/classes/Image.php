<?php
class Image extends Conn
{
	public $_table	= 'contents_images';
	public $_index	= 'imageID';
	public $_fields	= array('contentID',
							'title',
							'description',
							'filename',
							'position',
							'adminID_created',
							'adminID_updated',
							'date_created',
							'date_updated');

	public $_index2	= 'contentID'; // Imagen asociada a <>
	public $_dir    = 'images/';

	public $_file   = ''; // Ej: $_FILES['file']
	public $_thumbs = array('1280x1024', '640x480', '400x300', '200x150', '100x75'); // 640x480+100x75 Usados en admin
	public $_thumbQ = 80; // Quality

	// ------------------------------------------------------------------------------- //


	public function update($data, $indexID)
	{
		if(trim($data['filename']) == '') return false;

		if($old = parent::get($indexID))
		{
			if($old['filename'] != $data['filename'])
			{
				$base = ROOT.$this->_dir.$old[$this->_index2].'/';

				if(file_exists($base.$data['filename'])) return false; // No puedo renombrar un archivo pisando uno existente

				if(file_exists($base.$old['filename'])) rename($base.$old['filename'], $base.$data['filename']);
				foreach($this->_thumbs as $t)
				{
					if(file_exists($base.$this->getThumb($old['filename'], $t)))
					{
						rename($base.$this->getThumb($old['filename'], $t), $base.$this->getThumb($data['filename'], $t));
					}
				}
			}

			parent::update($data, $indexID);

			// Actualizo y genero thumbs si sube nueva imagen:
			if($this->upload($data, $data['filename']))	$this->processAll($indexID);

			return true;
		}
		return false;
	}


	public function insert($data)
	{
		if(trim($data['filename']) == '' || $data[$this->_index2] == '') return false;

		if(file_exists(ROOT.$this->_dir.$data[$this->_index2].'/'.$data['filename'])) return false;

		if(parent::insert($data))
		{
			if($this->upload($data, $data['filename']))
			{
				$this->processAll($this->insert_id); // Genero thumbs
			}
			return true;
		}
		return false;
	}


	private function upload($data, $name)
	{
		$base = ROOT.$this->_dir.$data[$this->_index2].'/';

	    // Subo solo si no existe o si existe y esta actualizando:
		if($this->_file['tmp_name'] && (!file_exists($base.$name) || (file_exists($base.$name) && $this->insert_id == 0) ))
		{
			if(!is_dir($base))
			{
				mkdir($base);
				chmod($base, 0777);
			}

			if(move_uploaded_file($this->_file['tmp_name'], $base.$name)) return chmod($base.$name, 0777);
		}
		return false;
	}


	public function delete($indexID)
	{
		if($row = $this->get($indexID))
		{
			$base = ROOT.$this->_dir.$row[$this->_index2].'/';

			$path = $base.$row['filename'];
			if(is_file($path) && file_exists($path)) unlink($path);
			foreach($this->_thumbs as $size)
			{
				$path = $base.$this->getThumb($row['filename'], $size);
				if(is_file($path) && file_exists($path)) unlink($path);
			}
		}

		return parent::delete($indexID);
	}


	public function getThumb($filename, $size)
	{
		return pathinfo($filename,PATHINFO_FILENAME).'-'.$size.'.'.pathinfo($filename,PATHINFO_EXTENSION);
	}


	// Proceso todas las imagenes. Con el original armo todos los thumbs:
	public function processAll($ID='')
	{
		$params = (is_numeric($ID)) ? array('WHERE' => $this->_index.'='.$ID) : '';

		$rs = parent::getList($params);
		if($rs->num_rows > 0)
		{
			while($row = $rs->fetch_assoc())
			{
				$base = ROOT.$this->_dir.$row[$this->_index2].'/';
				if(file_exists($base.$row['filename']))
				{
					foreach($this->_thumbs as $t)
					{
						list($width, $height) = explode('x', $t);
						$this->thumbMaker($base.$row['filename'], $base.$this->getThumb($row['filename'], $t), $width, $height);
					}
				}
			}
		}
	}


	public function thumbMaker($src, $dest, $ancho=0, $alto=0)
	{
		$ext = strtolower(pathinfo($src, PATHINFO_EXTENSION));

		switch($ext)
		{
			case 'jpg':  $input = ImageCreateFromJPEG($src); break;
			case 'png':  $input = ImageCreateFromPNG($src);  break;
			case 'gif':  $input = ImageCreateFromGIF($src);  break;
			default: exit('Error. Image Type:'.$src);
		}

		$imgX = imagesx($input);
	    $imgY = imagesy($input);

	    if($ancho > 0 && $alto > 0 && ($imgX > $ancho || $imgY > $alto))
	    {
	        $a = $ancho / $alto;
	        $b = $imgX / $imgY;

	        if($a < $b)
	        {
	            $ancho = $ancho;
	            $alto  = ($ancho / $imgX) * $imgY;
	        }
	        else
	        {
	            $alto  = $alto;
	            $ancho = ($alto / $imgY) * $imgX;
	        }
	    }
	    else
	    {
	    	$ancho = $imgX;
	    	$alto  = $imgY;
	    }

	    $output = imagecreatetruecolor($ancho, $alto);
	    imagecopyresampled($output, $input, 0,0,0,0, $ancho, $alto, $imgX, $imgY);
		imagejpeg($output, $dest, $this->_thumbQ);

		chmod($dest, 0777);
	}
}

set_time_limit(0);
/*
ini_set ('display_errors', true);
ini_set("post_max_size","64M");
ini_set("memory_limit","128M");

echo ini_get('post_max_size');
*/

