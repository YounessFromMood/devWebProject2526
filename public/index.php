<?php

declare(strict_types=1);

// Valid PHP Version?
$minPhpVersion = '8.1'; // If you are using PHP 7.4+, change this to '7.4'
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );
    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 */

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require FCPATH . '../app/Config/Paths.php';

$paths = new Config\Paths();

// LOAD THE FRAMEWORK CONSTANTS
require $paths->systemDirectory . '/Boot/constants.php';

// LAUNCH THE APPLICATION
return (require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Boot/init.php');
