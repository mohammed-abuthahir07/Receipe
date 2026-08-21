<?php
/**
 * MySQL connection for XAMPP
 */

declare(strict_types=1);

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ruchi_recipes');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo '<!DOCTYPE html><html><head><title>Database Error</title></head><body style="font-family:system-ui;padding:2rem;">';
        echo '<h1>Database connection failed</h1>';
        echo '<p>Import <code>database/schema.sql</code> then <code>database/seed.sql</code> in phpMyAdmin.</p>';
        echo '<p><small>' . htmlspecialchars($e->getMessage()) . '</small></p>';
        echo '</body></html>';
        exit;
    }

    return $pdo;
}
