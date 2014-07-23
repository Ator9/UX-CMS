<?php
/**
 * RESTful Client/Server API Class 
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 *
 * Client Setup:
 * $api = new RestApi(array('api_url' => 'http://example.com/api'));
 * or
 * $api = new RestApi($config); // $config with url, username and password
 * or
 * $api = new customRestApi(); // Custom class extends RestApi with hardcoded config
 *
 * Client Methods:
 * $response = $api->get('/products'); // Get product list
 * $response = $api->get('/products/333'); // Get product ID 333
 * $response = $api->post('/products', 'data'); // Adds a new product
 * $response = $api->put('/products/333', 'data'); // Updates product ID 333
 * $response = $api->delete('/products/333'); // Deletes product ID 333
 *
 *
 * Server Setup:
 * <IfModule mod_rewrite.c>
 * RewriteEngine On
 * RewriteCond %{REQUEST_FILENAME} !-f
 * RewriteRule api/(.*)$ common/api.php?request=/$1 [L,NC,QSA]
 * </IfModule>
 * 
 */
class RestApi
{
    protected $api_url      = ''; // http://example.com/api
    protected $api_username = '';
    protected $api_password = '';


    public function __construct($config = array())
    {
        foreach($config as $key => $value)
        {
            if(isset($this->$key)) $this->$key = $value;
        }
    }
    
    
    /**
     * Execute a GET Request
     * 
     * @param string $path
     * @return Array
     */
    public function get($path)
    {
        return $this->execute($path);
    }
    
    
    /**
     * Execute a POST Request
     * 
     * @param string $path
     * @param string $body
     * @return Array
     */
    public function post($path, $body)
    {
        $opts = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_POST       => true, 
            CURLOPT_POSTFIELDS => json_encode($body)
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute a PUT Request
     * 
     * @param string $path
     * @param string $body
     * @return Array
     */
    public function put($path, $body)
    {
        $opts = array(
            CURLOPT_HTTPHEADER    => array('Content-Type: application/json'),
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS    => json_encode($body)
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute a DELETE Request
     * 
     * @param string $path
     * @return Array
     */
    public function delete($path) {
        $opts = array(
            CURLOPT_CUSTOMREQUEST => 'DELETE'
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute requests and returns the json body and status header
     * 
     * @param string $path
     * @return Array
     */
    public function execute($path, $opts = array())
	{
	    $ch = curl_init($this->api_url.$path);
	    curl_setopt_array($ch, $opts);
	    
	    $return['body']   = json_decode(curl_exec($ch));
        $return['status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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





