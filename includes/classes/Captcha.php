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
    public $publickey  = ''; // You got this from the signup page
	public $privatekey = ''; // You got this from the signup page
	public $lang  	   = 'es';
	public $theme 	   = 'white';

	public function get()
	{
		$js = '<script type="text/javascript">var RecaptchaOptions={lang:"'.$this->lang.'",theme:"'.$this->theme.'"};</script>';
		return $js.recaptcha_get_html($this->publickey);
	}


	public function getScript($id)
	{
		$js = '<script type="text/javascript">
			       Recaptcha.create("'.$this->publickey.'","'.$id.'",{lang:"'.$this->lang.'",theme:"'.$this->theme.'",callback:Recaptcha.focus_response_field});
			   </script>';
		return $js;
	}


	public function check()
	{
		$resp = recaptcha_check_answer($this->privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
		if($resp->is_valid) return true;
		return false;
	}
}

require(INCLUDES.'/lib/recaptcha/recaptchalib.php');
