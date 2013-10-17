<?
class Messenger
{
	private $type	  = 1;
	private $html 	  = '';
	public $messages  = array();


	// ------------------------------------------------------------------------------- //


	public function add($txt)
	{
		$this->messages[] = $txt;
	}


	public function addPredefined($txt='')
	{
		switch($txt)
		{
			case 'added':
				$this->type(1);
				$this->add(date('H:i:s').' - El registro ha sido guardado correctamente.');
				break;

			case 'deleted':
				$this->type(3);
				$this->add(date('H:i:s').' - El registro ha sido eliminado correctamente.');
				break;

			case 'failed_weblogin':
				$this->type(3);
				$this->add(date('H:i:s').' - Los información de logueo es incorrecta.
				                             <br />Si no recuerda sus datos, puede intentar Recuperar su Contrase&ntilde;a o ponerse en contacto con nosotros.');
				break;

			default:
				$this->type(substr($txt,0,1));
				$this->add(date('H:i:s').' - '.substr($txt,1));
				break;
		}
	}


	private function build()
	{
		if(!empty($this->messages))
		{
			switch($this->type)
			{
				case 1: $class='messenger1'; $icon='information.png';	   break;
				case 2: $class='messenger2'; $icon='information.png';	   break;
				case 3: $class='messenger3'; $icon='exclamation-red.png'; break;
			}

			foreach($this->messages as $v)
			{
				$this->html.='<li><img src="'.HOST.'static/icons/'.$icon.'" alt="" class="fl" />'.$v.'</li>';
			}

			$this->html = '<div class="messenger '.$class.'"><ol>'.$this->html.'</ol></div>';
		}
	}


	public function type($n)
	{
		$this->type = $n;
	}


	public function show()
	{
		$this->build();
		return $this->html;
	}
}
?>
