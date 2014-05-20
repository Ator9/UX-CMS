<?php

/**
 * Twig template loader
 *
 * @author Sebastián Gasparri
 * http://www.linkedin.com/in/sgasparri
 *
 * Example:
 * $twig = new Twig();
 * echo $twig->render('path/template.html', array('name'=>'sebastian'));
 *
 */

require(INCLUDES.'/lib/twig/lib/Twig/Autoloader.php');
Twig_Autoloader::register();

class Twig extends Twig_Environment
{
    public function __construct(Twig_LoaderInterface $loader = null, $options = array())
    {
        if(null === $loader) $loader = new Twig_Loader_Filesystem(ROOT);
        parent::__construct($loader, $options);
    }
}


