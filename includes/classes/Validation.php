<?php
/**
 * Laravel Validation
 *
 * @version 5.1.22
 * @author http://laravel.com/docs/validation
 * @link https://packagist.org/packages/illuminate/validation
 * Install: composer require illuminate/validation
 *
 *
 * Usage:
 * $validation = new Validation();
 * $res = $validation->make($_POST, $rulesArray);
 *
 */
require_once(INCLUDES.'/lib/laravel/validation/vendor/autoload.php');

class Validation extends Illuminate\Validation\Factory
{
    function __construct($locale = 'es')
    {
        parent::__construct(new \Symfony\Component\Translation\Translator($locale));
    }
}
