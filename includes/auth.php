<?php

declare(strict_types=1);

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    static $user = null;
    if ($user !== null) {
        return $user;
    }

    $stmt = db()->prepare('SELECT id, role, name, email, avatar_url, is_verified_author FROM users WHERE id = ?');
    $stmt->execute([(int) $_SESSION['user_id']]);
    $user = $stmt->fetch() ?: null;
    if (!$user) {
        unset($_SESSION['user_id']);
    }
    return $user;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('error', 'Please sign in to continue.');
        redirect('login.php');
    }
}

function require_role(array $roles): void
{
    require_login();
    $user = current_user();
    if (!$user || !in_array($user['role'], $roles, true)) {
        flash('error', 'You do not have permission to access that page.');
        redirect('index.php');
    }
}

function attempt_login(string $email, string $password): bool
{
    $stmt = db()->prepare('SELECT id, password_hash FROM users WHERE email = ?');
    $stmt->execute([strtolower(trim($email))]);
    $user = $stmt->fetch();

    if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    $_SESSION['user_id'] = (int) $user['id'];
    return true;
}

function register_user(string $name, string $email, string $password): array
{
    $email = strtolower(trim($email));
    $name = trim($name);

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        return ['ok' => false, 'message' => 'Please provide a valid name, email, and password (at least 6 characters).'];
    }

    $check = db()->prepare('SELECT id FROM users WHERE email = ?');
    $check->execute([$email]);
    if ($check->fetch()) {
        return ['ok' => false, 'message' => 'An account with that email already exists.'];
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = db()->prepare('INSERT INTO users (role, name, email, password_hash) VALUES (\'USER\', ?, ?, ?)');
    $stmt->execute([$name, $email, $hash]);
    $_SESSION['user_id'] = (int) db()->lastInsertId();

    return ['ok' => true, 'message' => 'Welcome to Ruchi!'];
}

function logout_user(): void
{
    unset($_SESSION['user_id']);
}
