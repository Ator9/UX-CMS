<?php

/**
 *
 * Example:
 *
 * http://qbnz.com/highlighter/geshi-doc.html
 *
 * $geshi = new GeSHi(strip_tags($main['description']), 'php');
 * $geshi->set_header_type(GESHI_HEADER_DIV);
 * $geshi->enable_classes();
 * echo '<style type="text/css">'.$geshi->get_stylesheet().'</style>';
 * echo $geshi->parse_code();
 *
 *
 */

require(dirname(__FILE__).'/../lib/geshi/geshi.php');

