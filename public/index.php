<?php

/**
 * This Place Dev Challenge Bot - an application to complete the This Place dev challenge without human assistance
 *
 * @author Joe Savage
 * @link https://github.com/joesavage1983/this-place-dev-challenge-bot
 * @license http://opensource.org/licenses/MIT MIT License
 */

// Set constant that holds the project's folder path
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Auto-loader for Composer-dependencies
if (file_exists(ROOT . 'vendor/autoload.php')) {
    require ROOT . 'vendor/autoload.php';
}

// Set up Tracy debugger
use \Tracy\Debugger;
Debugger::enable(Debugger::DEVELOPMENT);
// Debugger::enable(Debugger::PRODUCTION, __DIR__ . '/../logs');

// Include Codeception c3 file for test coverage
include ROOT . '../c3.php';

// Load challenge class
require ROOT . 'application/core/challenge.php';

// Attempt challenge
$challenge = new Challenge("Joe Savage");
$challenge->complete();
