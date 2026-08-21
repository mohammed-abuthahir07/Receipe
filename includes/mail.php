<?php

declare(strict_types=1);

function ensure_contact_messages_table(): void
{
    db()->exec(
        'CREATE TABLE IF NOT EXISTS contact_messages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(190) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
    );
}

function save_contact_message(string $name, string $email, string $message): bool
{
    ensure_contact_messages_table();
    $stmt = db()->prepare('INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)');
    return $stmt->execute([$name, $email, $message]);
}

function send_contact_query_email(string $name, string $email, string $message): bool
{
    $subject = 'Ruchi contact query';
    $body = "Name: {$name}\nEmail: {$email}\nQuery:\n{$message}\n";

    if (send_contact_via_formsubmit($name, $email, $message, $subject)) {
        return true;
    }

    if (defined('SMTP_PASS') && SMTP_PASS !== '') {
        return smtp_send_mail(CONTACT_EMAIL, $subject, $body, $email, $name);
    }

    $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'From: Ruchi <' . CONTACT_EMAIL . '>',
        'Reply-To: ' . sprintf('%s <%s>', $name, $email),
    ];

    return @mail(CONTACT_EMAIL, $encodedSubject, $body, implode("\r\n", $headers));
}

function send_contact_via_formsubmit(string $name, string $email, string $message, string $subject): bool
{
    if (!defined('CONTACT_FORMSUBMIT_KEY') || CONTACT_FORMSUBMIT_KEY === '') {
        return false;
    }

    $payload = http_build_query([
        'name' => $name,
        'email' => $email,
        'query' => $message,
        '_subject' => $subject,
        '_template' => 'box',
        '_captcha' => 'false',
        '_replyto' => $email,
    ]);

    $origin = rtrim(APP_URL, '/');
    $url = 'https://formsubmit.co/ajax/' . rawurlencode(CONTACT_FORMSUBMIT_KEY);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT => 20,
        CURLOPT_USERAGENT => 'Mozilla/5.0',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'Origin: ' . $origin,
            'Referer: ' . $origin . '/contact.php',
        ],
    ]);
    $result = curl_exec($ch);
    if ($result === false) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
    }
    curl_close($ch);
    if (!is_string($result) || $result === '') {
        return false;
    }

    $data = json_decode($result, true);
    $success = is_array($data) ? ($data['success'] ?? false) : false;
    return $success === true || $success === 'true';
}

function smtp_send_mail(string $to, string $subject, string $body, string $replyEmail, string $replyName): bool
{
    $host = SMTP_HOST;
    $port = (int) SMTP_PORT;
    $user = SMTP_USER;
    $pass = SMTP_PASS;

    $errno = 0;
    $errstr = '';
    $socket = @stream_socket_client(
        "tcp://{$host}:{$port}",
        $errno,
        $errstr,
        20,
        STREAM_CLIENT_CONNECT
    );
    if (!$socket) {
        return false;
    }

    $read = static function () use ($socket): string {
        $data = '';
        while ($line = fgets($socket, 515)) {
            $data .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        return $data;
    };

    $write = static function (string $command) use ($socket): void {
        fwrite($socket, $command . "\r\n");
    };

    $ok = static function (string $response, string $code): bool {
        return str_starts_with($response, $code);
    };

    try {
        if (!$ok($read(), '220')) {
            return false;
        }
        $write('EHLO ruchi.local');
        if (!$ok($read(), '250')) {
            return false;
        }
        $write('STARTTLS');
        if (!$ok($read(), '220')) {
            return false;
        }
        if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            return false;
        }
        $write('EHLO ruchi.local');
        if (!$ok($read(), '250')) {
            return false;
        }
        $write('AUTH LOGIN');
        if (!$ok($read(), '334')) {
            return false;
        }
        $write(base64_encode($user));
        if (!$ok($read(), '334')) {
            return false;
        }
        $write(base64_encode($pass));
        if (!$ok($read(), '235')) {
            return false;
        }
        $write('MAIL FROM:<' . $user . '>');
        if (!$ok($read(), '250')) {
            return false;
        }
        $write('RCPT TO:<' . $to . '>');
        if (!$ok($read(), '250')) {
            return false;
        }
        $write('DATA');
        if (!$ok($read(), '354')) {
            return false;
        }

        $encodedSubject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $payload = implode("\r\n", [
            'From: Ruchi <' . $user . '>',
            'To: <' . $to . '>',
            'Reply-To: ' . sprintf('%s <%s>', $replyName, $replyEmail),
            'Subject: ' . $encodedSubject,
            'MIME-Version: 1.0',
            'Content-Type: text/plain; charset=UTF-8',
            '',
            $body,
            '.',
        ]);
        $write($payload);
        if (!$ok($read(), '250')) {
            return false;
        }
        $write('QUIT');
        return true;
    } finally {
        fclose($socket);
    }
}
