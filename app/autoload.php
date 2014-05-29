<?php
umask(0000);
use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Gedmo', __DIR__.'/../vendor/gedmo-doctrine-extensions/lib');
$loader->add('Stof', __DIR__.'/../vendor/bundles');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
