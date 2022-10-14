<?php

use Composer\Autoload\ClassLoader as ComposerAutoloader;

return (static function (string $root = __DIR__): ComposerAutoloader {
    $composer_autoloader = null;
    while (! isset($composer_autoloader) && dirname($root) !== $root) {
        if (is_file($composer_file = $root.DIRECTORY_SEPARATOR.'composer.json') && is_readable($composer_file)) {
            if (($composer_data = @file_get_contents($composer_file)) && ($composer_data = @json_decode($composer_data, true))) {
                if (is_file($autoload_file = $root.DIRECTORY_SEPARATOR.($composer_data['config']['vendor-dir'] ?? 'vendor').DIRECTORY_SEPARATOR.'autoload.php') && is_readable($autoload_file)) {
                    $composer_autoloader = include_once $autoload_file;
                }
            }
        }
        $root = dirname($root);
    }

    if (! $composer_autoloader instanceof ComposerAutoloader) {
        \fwrite(
            \STDERR,
            'No such Composer autoload file'
        );
        exit(1);
    }

    return $composer_autoloader;
})();
