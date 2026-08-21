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
define('APP_TAGLINE', 'Recepi Tradisional Malaysia');
define('APP_URL', 'http://localhost/receipe');
define('APP_ROOT', dirname(__DIR__));
define('CONTACT_EMAIL', 'lavanya.raja23@gmail.com');
define('CONTACT_FORMSUBMIT_KEY', 'lavanya.raja23@gmail.com');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'lavanya.raja23@gmail.com');
define('SMTP_PASS', '');

date_default_timezone_set('Asia/Kuala_Lumpur');

require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/includes/functions.php';
require_once APP_ROOT . '/includes/auth.php';
