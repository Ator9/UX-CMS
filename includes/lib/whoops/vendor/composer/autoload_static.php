<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita97f9acf5eab16f7e3cd3d9f0aae27a8
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Whoops\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Whoops\\' => 
        array (
            0 => __DIR__ . '/..' . '/filp/whoops/src/Whoops',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita97f9acf5eab16f7e3cd3d9f0aae27a8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita97f9acf5eab16f7e3cd3d9f0aae27a8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
