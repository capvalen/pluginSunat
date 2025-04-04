<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit65bb91ee4e77771b08210b6d22bf2609
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit65bb91ee4e77771b08210b6d22bf2609', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit65bb91ee4e77771b08210b6d22bf2609', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit65bb91ee4e77771b08210b6d22bf2609::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
