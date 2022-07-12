<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit67324f1f3620cc3174b64a9b2d234792
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'C' => 
        array (
            'CWG\\OneSignal\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'CWG\\OneSignal\\' => 
        array (
            0 => __DIR__ . '/..' . '/carloswgama/php-onesignal/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit67324f1f3620cc3174b64a9b2d234792::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit67324f1f3620cc3174b64a9b2d234792::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit67324f1f3620cc3174b64a9b2d234792::$classMap;

        }, null, ClassLoader::class);
    }
}