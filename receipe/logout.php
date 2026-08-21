<?php
require_once __DIR__ . '/config/app.php';
logout_user();
flash('success', 'Signed out. Jumpa lagi!');
redirect('index.php');
