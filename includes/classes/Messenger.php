<?php
/**
 * Messenger Class
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 * Usage:
 * $messenger = new Messenger();
 * $messenger->add('my message', 'custom_type');
 * echo $messenger->show();
 *
 */

class Messenger
{
    private $type       = 'success';  // Default bootstrap style type
	private $messages   = array(); // Stored messages
	private $predefined = array(); // Predefined messages
	public  $html       = '';


	// ------------------------------------------------------------------------------- //


    public function __construct($types = array(), $predefined = array())
    {
        $this->types['success'] = 'alert alert-dismissible alert-success';
        $this->types['info']    = 'alert alert-dismissible alert-info';
        $this->types['warning'] = 'alert alert-dismissible alert-warning';
        $this->types['danger']  = 'alert alert-dismissible alert-danger';
        if(!empty($types)) array_merge($this->types, $types);
        
        $this->predefined['created'] = array(date('H:i:s').' - El registro ha sido creado correctamente.',      'success');
        $this->predefined['updated'] = array(date('H:i:s').' - El registro ha sido actualizado correctamente.', 'info');
        $this->predefined['deleted'] = array(date('H:i:s').' - El registro ha sido eliminado correctamente.',   'warning');
        if(!empty($predefined)) array_merge($this->predefined, $predefined);
    }
    

	public function add($message, $type = '')
	{
		$this->messages[] = array($message, ($type ? $type : $this->type));
	}


	public function addPredefined($type = '')
	{
	    if(array_key_exists($type, $this->predefined)) $this->add($this->predefined[$type][0], $this->predefined[$type][1]);
	}
	

	public function show()
	{
		if(!empty($this->messages))
		foreach($this->messages as $data)
		{
			$this->html .= '<div class="messenger_class '.$this->types[$data[1]].'">'.$data[0].'</div>';
		}
		return $this->html;
	}
	
	
	public function setType($type)
	{
	    if(array_key_exists($type, $this->types)) $this->type = $type;
	    else exit('Message type not found.');
	}
	
	
	public function getCount()
	{
	    return count($this->messages);
	}
}


