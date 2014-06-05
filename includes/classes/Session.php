<?php
/**
 * Session Manager Class
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 * Usage:
 * $session = new Session('web_user');
 * $session->set('id', 500);
 * if($session->exists('id')) $logged_id = $session->get('id');
 *
 */
 
class Session
{
	public $session_name = '';

	function __construct($custom = '')
	{
		$this->session_name = sha1(HOST.$custom);

		try{
        	session_name($this->session_name);
            session_start();
        }
        catch(Exception $e)
        {
            exit('Unable to start session: '.$e);
        }

        if($custom != '' && !isset($_SESSION[$this->session_name]))
        {
            $_SESSION[$this->session_name] = array();
        }
	}


	function set($name, $value)
	{
		if(!empty($name) && !empty($value))
		{
			if(isset($_SESSION[$this->session_name]))
			{
				$_SESSION[$this->session_name][$name] = $value;
			}
			else $_SESSION[$name] = $value;
		}
	}


	function get($name)
	{
		if(isset($_SESSION[$this->session_name][$name])) return $_SESSION[$this->session_name][$name];
		if(isset($_SESSION[$name])) return $_SESSION[$name];
		return false;
	}


	function getValue()
	{
		$args = func_get_args();
		if(!empty($args))
		{
			if(isset($_SESSION[$this->session_name])) $value = $_SESSION[$this->session_name];
			else $value = $_SESSION;

			foreach($args as $k)
			{
				if(isset($value[$k])) $value = $value[$k];
				else return false;
			}

			return $value;
		}
		return false;
	}


	function exists($name)
	{
		if(isset($_SESSION[$this->session_name][$name])) return true;
        if(isset($_SESSION[$name])) return true;
        return false;
    }


	function del($name)
	{
		if(isset($_SESSION[$this->session_name][$name])) unset($_SESSION[$this->session_name][$name]);
		elseif(isset($_SESSION[$name])) unset($_SESSION[$name]);
	}


	function destroy()
	{
		$_SESSION = array();
		session_destroy();
	}
}


