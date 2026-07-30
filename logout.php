<?php

require_once __DIR__ . '/includes/auth.php';

logoutUser();

header('Location: /digital-menu-system/login.php');
exit;

?>