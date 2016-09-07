<?php
/**
 * League\Flysystem
 *
 * @version 1.0.27
 * @link http://flysystem.thephpleague.com/
 * @link http://flysystem.thephpleague.com/api/
 *
 * $fs = new Filesystem(null, ['upload_dir' => 'upload/products' ]);
 * $contents = $fs->listContents('', true);
 *
 */

// Autload:
spl_autoload_register(function($class) {
    $prefix = 'League\\Flysystem\\';

    if ( ! substr($class, 0, 17) === $prefix) {
        return;
    }

    $class = substr($class, strlen($prefix));
    $location = __DIR__ . '/../lib/flysystem/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($location)) {
        require_once($location);
    }
});

require_once(INCLUDES.'/lib/flysystem/Filesystem.php');

class Filesystem extends League\Flysystem\Filesystem
{
    public function __construct(AdapterInterface $adapter = null, $config = null)
    {
        if(empty($adapter))
        {
            $dir = !empty($config['upload_dir']) ? $config['upload_dir'] : 'upload';
            $adapter = new \League\Flysystem\Adapter\Local($dir);
        }

        parent::__construct($adapter, $config);
    }
}
