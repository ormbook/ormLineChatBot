<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc53d1fd1134b4f94d2bb50e53920d64d
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LINE\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LINE\\' => 
        array (
            0 => __DIR__ . '/..' . '/linecorp/line-bot-sdk/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc53d1fd1134b4f94d2bb50e53920d64d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc53d1fd1134b4f94d2bb50e53920d64d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
