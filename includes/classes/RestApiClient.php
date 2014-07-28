<?php
/**
 * RESTful API Client Class 
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 *
 * Setup api_client.php:
 * $api = new RestApiClient(array('api_url' => 'http://example.com/api'));
 * $response = $api->get('/products'); // Get product list
 * $response = $api->get('/products', array('id' => 333)); // Get product ID 333
 * $response = $api->post('/products', array('data' => 'add')); // Adds a new product
 * $response = $api->put('/products', array('id' => 333, 'data' => 'update')); // Updates product ID 333
 * $response = $api->delete('/products', array('id' => 333))); // Deletes product ID 333
 *
 */
class RestApiClient
{
    protected $api_url      = ''; // http://example.com/api
    protected $api_username = '';
    protected $api_password = '';
    protected $curl_opts    = array( // Custom cURL options
        CURLOPT_RETURNTRANSFER => true
    );
    

    /*
     * Construct - Set config
     */
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
     * @param String $path
     * @param Array $data
     * @return Array
     */
    public function get($path, $data = array())
    {
        $opts = array();
        
        if(!empty($data))
        {
            $opts = array(
                CURLOPT_HTTPHEADER    => array('Content-Type: application/json; charset=UTF-8'),
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS    => json_encode($data)
            );
        }
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute a POST Request
     * 
     * @param String $path
     * @param Array $data
     * @return Array
     */
    public function post($path, $data)
    {
        $opts = array(
            CURLOPT_HTTPHEADER => array('Content-Type: application/json; charset=UTF-8'),
            CURLOPT_POST       => true, 
            CURLOPT_POSTFIELDS => json_encode($data)
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute a PUT Request
     * 
     * @param String $path
     * @param Array $data
     * @return Array
     */
    public function put($path, $data)
    {
        $opts = array(
            CURLOPT_HTTPHEADER    => array('Content-Type: application/json; charset=UTF-8'),
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS    => json_encode($data)
        );
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute a DELETE Request
     * 
     * @param String $path
     * @param Array $data
     * @return Array
     */
    public function delete($path, $data = array())
    {
        $opts = array();
        
        if(!empty($data))
        {
            $opts = array(
                CURLOPT_HTTPHEADER    => array('Content-Type: application/json; charset=UTF-8'),
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_POSTFIELDS    => json_encode($data)
            );
        }
        
        return $this->execute($path, $opts);
    }
    
    
    /**
     * Execute requests and returns the json body and status header
     * 
     * @param String $path
     * @return Array
     */
    public function execute($path, $opts = array())
	{
	    $ch = curl_init($this->api_url.$path);
	    curl_setopt_array($ch, $this->curl_opts);
	    curl_setopt_array($ch, $opts);
	    
	    $return['data']   = json_decode(curl_exec($ch));
        $return['status'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $return;
	}
}


