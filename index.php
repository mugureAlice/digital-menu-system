<?php

require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header('Location: /digital-menu-system/menu.php');
} else {
    header('Location: /digital-menu-system/login.php');
}

exit;