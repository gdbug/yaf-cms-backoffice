<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit561bcb8ca55e58ac511e5b9e2c2e7dcf
{
    public static $files = array (
        '3b5531f8bb4716e1b6014ad7e734f545' => __DIR__ . '/..' . '/illuminate/support/Illuminate/Support/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Carbon\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Carbon\\' => 
        array (
            0 => __DIR__ . '/..' . '/nesbot/carbon/src/Carbon',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Symfony\\Component\\Translation\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/translation',
            ),
        ),
        'P' => 
        array (
            'PhpRbac' => 
            array (
                0 => __DIR__ . '/..' . '/owasp/phprbac/PhpRbac/src',
            ),
        ),
        'I' => 
        array (
            'Illuminate\\Support' => 
            array (
                0 => __DIR__ . '/..' . '/illuminate/support',
            ),
            'Illuminate\\Events' => 
            array (
                0 => __DIR__ . '/..' . '/illuminate/events',
            ),
            'Illuminate\\Database' => 
            array (
                0 => __DIR__ . '/..' . '/illuminate/database',
            ),
            'Illuminate\\Container' => 
            array (
                0 => __DIR__ . '/..' . '/illuminate/container',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit561bcb8ca55e58ac511e5b9e2c2e7dcf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit561bcb8ca55e58ac511e5b9e2c2e7dcf::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit561bcb8ca55e58ac511e5b9e2c2e7dcf::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}