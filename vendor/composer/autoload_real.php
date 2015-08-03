<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit8b1b4e898a0b1c20b0226ee08812e3fd
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit8b1b4e898a0b1c20b0226ee08812e3fd', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
        spl_autoload_unregister(array('ComposerAutoloaderInit8b1b4e898a0b1c20b0226ee08812e3fd', 'loadClassLoader'));

        $map = require __DIR__ . '/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->set($namespace, $path);
        }

        $map = require __DIR__ . '/autoload_psr4.php';
        foreach ($map as $namespace => $path) {
            $loader->setPsr4($namespace, $path);
        }

        $classMap = require __DIR__ . '/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(true);

        $includeFiles = require __DIR__ . '/autoload_files.php';
        foreach ($includeFiles as $file) {
            composerRequire8b1b4e898a0b1c20b0226ee08812e3fd($file);
        }

        return $loader;
    }
}

function composerRequire8b1b4e898a0b1c20b0226ee08812e3fd($file)
{
    require $file;
}
