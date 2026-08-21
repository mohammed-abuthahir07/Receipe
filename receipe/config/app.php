<?php
/**
 * Ruchi — Malaysian Traditional Recipes Platform
 * App configuration
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'Ruchi');
define('APP_TAGLINE', 'Resepi Tradisional Malaysia');
define('APP_URL', 'http://localhost/receipe');
define('APP_ROOT', dirname(__DIR__));

date_default_timezone_set('Asia/Kuala_Lumpur');

require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/includes/functions.php';
require_once APP_ROOT . '/includes/auth.php';
