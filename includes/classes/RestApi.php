<?php
/**
 * RESTful Client/Server API Class 
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 *
 * Server Setup:
 * <IfModule mod_rewrite.c>
 * RewriteEngine On
 * RewriteCond %{REQUEST_FILENAME} !-f
 * RewriteCond %{REQUEST_FILENAME} !-d
 * RewriteRule api/(.*)$ common/api.php?request=$1 [L,NC,QSA]
 * </IfModule>
 * 
 */
class RestApi
{
    protected $api_url    = '';
    protected $app_id     = '';
    protected $app_secret = '';


    public function __construct($config = array())
    {
        if(isset($config['api_url']))    $this->api_url    = $config['api_url'];
        if(isset($config['app_id']))     $this->app_id     = $config['app_id'];
        if(isset($config['app_secret'])) $this->app_secret = $config['app_secret'];
    }
    
    
    public function get($path)
    {
    
    }
    
    /**
     * Execute a POST Request
     * 
     * @return Array
     */
    public function post($path, $body=array())
    {
        $opts = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POST       => true, 
            CURLOPT_POSTFIELDS => json_encode($body)
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute requests and returns the json body and headers
     * 
     * @return Array
     */
    public function execute($path, $opts)
	{
	    $ch = curl_init($this->api_url.$path);
	    curl_setopt_array($ch, $opts);
	    
	    $return['body'] = json_decode(curl_exec($ch));
        $return['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $return;
	}
}


/*
/Public method for access api.
//This method dynmically call the method based on the query string
public function processApi()
{
    $func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
    if((int)method_exists($this,$func) > 0)
    $this->$func();
    else
    $this->response('',404);
    // If the method not exist with in this class, response would be "Page not found".
}

if($this->get_request_method() != "GET")
{
$this->response('',406);
}




+ GET admin/login?username=foo&password=bar
  =>
  {
     "status": "200",
     "data": true
  }

+ GET admin/login?username=foo&password=invalidPassword
  =>
  {
     "status": "500",
     "error": "InvalidLoginException",
     "message": "Login is invalid or no access"
  }

+ GET admin/login
  =>
  {
     "status: "400",
     "error": "MissingRequiredArgumentException",
     "message": "Argument 'username' is missing"
  }







*/





