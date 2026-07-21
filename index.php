<?php
require_once __DIR__ . '/includes/auth.php';
header('Location: ' . (isLoggedIn() ? '/menu.php' : '/login.php'));
exit;
