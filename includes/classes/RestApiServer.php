<?php
/**
 * RESTful API Server Class 
 *
 * @author Sebastián Gasparri
 * @link https://github.com/Ator9
 *
 *
 * Setup:
 * <IfModule mod_rewrite.c>
 * RewriteEngine On
 * RewriteCond %{REQUEST_FILENAME} !-f
 * RewriteRule api/(.*)$ common/api_server.php?request=/$1 [L,NC,QSA]
 * </IfModule>
 *
 * Example api_server.php:
 *
 *
 *
 * 
 */
class RestApiServer
{
    public function __construct($url = '')
    {
        $url = trim($url, '/');
        $method = strtolower($_SERVER['REQUEST_METHOD']).ucfirst($url);
        
        if(!method_exists($this, $method)) return $this->response('Not found', 404);
        
        $this->$method();
    }
    
    
    public function response($data = '', $status = 200)
    {
        http_response_code($status);
        header('Content-type: application/json; charset=UTF-8');
        
        echo json_encode($data);
    }
}


/**
 * Set Header Response Code
 *
 * @link http://lxr.php.net/xref/PHP_5_4/sapi/cgi/cgi_main.c#354
 */
if(!function_exists('http_response_code')) // PHP 5.4.0+
{
    function http_response_code($code = '')
    {
        $data = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Moved Temporarily',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Time-out',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Large',
            415 => 'Unsupported Media Type',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Time-out',
            505 => 'HTTP Version not supported',
            511 => 'Network Authentication Required'
        );
            
        if(array_key_exists($code, $data)) header('HTTP/1.1 ' .$code. ' ' .$data[$code]);
    }
}


