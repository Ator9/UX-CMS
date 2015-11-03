<?php
/**
 * Blade Templating Engine
 *
 * @version 3.0
 * @author http://laravel.com/docs/blade
 * @link https://packagist.org/packages/philo/laravel-blade
 *
 *
 * Usage:
 * $blade = new Blade('templates'); // dir
 * $replaces = [ 'title' => 'test' ];
 * echo $blade->view()->make('landing.index', $replaces); // file "landing/index"
 *
 *
 * Install: composer require philo/laravel-blade
 *
 */
require_once(ROOT.'/1/vendor/autoload.php');

class Blade extends Philo\Blade\Blade
{
    function __construct($viewPaths = array(), $cachePath = ROOT.'/cache')
    {
        parent::__construct($viewPaths, $cachePath);
    }
}
