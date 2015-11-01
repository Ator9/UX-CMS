<?php
/**
 * Create a new Eloquent model instance
 *
 * @author http://laravel.com/docs/eloquent
 * @link https://packagist.org/packages/illuminate/database
 *
 * Install / Updates:
 * "composer require illuminate/database"
 *
 */
require_once(INCLUDES.'/lib/illuminate/database/vendor/autoload.php');

class Eloquent extends Illuminate\Database\Eloquent\Model
{
    // Create a new database capsule manager
    public function __construct($host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $db=DB_NAME)
    {
        $capsule = new Illuminate\Database\Capsule\Manager;
        $capsule->addConnection(array(
            'driver'    => 'mysql',
            'host'      => $host,
            'database'  => $db,
            'username'  => $user,
            'password'  => $pass,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ));
        $capsule->bootEloquent();

        parent::__construct();
    }
}
