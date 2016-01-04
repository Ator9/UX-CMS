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
 * $blade = new Blade('templates', ROOT.'/upload/cache'); // dir
 * $replaces = [ 'title' => 'test' ];
 * echo $blade->view()->make('landing.index', $replaces); // file "landing/index"
 *
 *
 * Install: composer require philo/laravel-blade
 *
 */
require_once(INCLUDES.'/lib/laravel/blade/vendor/autoload.php');

class Blade extends Philo\Blade\Blade
{
    function __construct($viewPaths = array(), $cachePath = '/upload/cache')
    {
        parent::__construct($viewPaths, $cachePath);
    }
}
