<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit568719de61bc052c841f5e201acfb4fb
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Emojione\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Emojione\\' => 
        array (
            0 => __DIR__ . '/..' . '/emojione/emojione/lib/php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit568719de61bc052c841f5e201acfb4fb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit568719de61bc052c841f5e201acfb4fb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit568719de61bc052c841f5e201acfb4fb::$classMap;

        }, null, ClassLoader::class);
    }
}
