<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita358239b78144da60c5766265cee8cb1
{
    public static $files = array (
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
        'a' => 
        array (
            'app\\' => 4,
        ),
        'P' => 
        array (
            'PhpAmqpLib\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'PhpAmqpLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-amqplib/php-amqplib/PhpAmqpLib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita358239b78144da60c5766265cee8cb1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita358239b78144da60c5766265cee8cb1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
