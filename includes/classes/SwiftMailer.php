<?php
/**
 * Swift Mailer
 *
 * @version 5.4.1
 * @author http://swiftmailer.org/
 * @link https://packagist.org/packages/swiftmailer/swiftmailer
 * Install: composer require swiftmailer/swiftmailer
 *
 * Usage:
 *
 *
 */
require_once(INCLUDES.'/lib/swiftmailer/vendor/autoload.php');

class SwiftMailer extends Swift_Mailer
{
    function __construct($params = array())
    {
        if(empty($params)) $transport = Swift_SmtpTransport::newInstance('localhost', 25);
        switch($params)
        {
            case 'sendmail': $transport = Swift_SmtpTransport::newInstance('localhost', 25); break;
            case 'smtp': $transport = Swift_SmtpTransport::newInstance('localhost', 25); break;
        }

        parent::__construct($transport);
    }
}
