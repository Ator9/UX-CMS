<?php
/**
 * reCAPTCHA
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 * @link https://www.google.com/recaptcha/admin#createsite
 *
 * Options:
 * <script>
 * var RecaptchaOptions = {theme:'white' , lang:'es'};
 * </script>
 *
 */

class Captcha
{
    public $public_key  = ''; // You got this from the signup page
	public $private_key = ''; // You got this from the signup page
	public $lang  	    = 'es';
	public $theme 	    = 'white';
	
	
	public function __construct($config = array())
    {
        foreach($config as $key => $value)
        {
            if(isset($this->$key)) $this->$key = $value;
        }
    }
    

	public function get()
	{
		$js = '<script type="text/javascript">var RecaptchaOptions={lang:"'.$this->lang.'",theme:"'.$this->theme.'"};</script>';
		return $js.recaptcha_get_html($this->public_key);
	}


	public function getScript($id)
	{
		$js = '<script type="text/javascript">
			       Recaptcha.create("'.$this->public_key.'","'.$id.'",{lang:"'.$this->lang.'",theme:"'.$this->theme.'",callback:Recaptcha.focus_response_field});
			   </script>';
		return $js;
	}


	public function check($challenge = '', $response = '')
	{
	    if($challenge == '') $challenge = $_POST['recaptcha_challenge_field'];
	    if($response == '')  $response  = $_POST['recaptcha_response_field'];
	    
		$resp = recaptcha_check_answer($this->private_key, $_SERVER['REMOTE_ADDR'], $challenge, $response);
		return $resp->is_valid;
	}
}

require(INCLUDES.'/lib/recaptcha/recaptchalib.php');


