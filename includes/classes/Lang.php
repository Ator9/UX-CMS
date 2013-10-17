<?
class Lang
{
	private $type	  = 1;
	private $html 	  = '';
	public $messages  = array();


	// ------------------------------------------------------------------------------- //


	public function load($file='')
	{
		if(file_exists($file))
		{
			require($file);
		}
	}
}
?>
