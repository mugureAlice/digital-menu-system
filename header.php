<?php require_once __DIR__ . '/includes/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Menu Kiosk</title>
<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<nav class="navbar">
    <a href="/menu.php" class="brand">🍽️ Kiosk</a>
    <div class="nav-links">
        <?php if (isLoggedIn()): ?>
            <a href="/menu.php">Menu</a>
            <a href="/cart.php">Cart <?php if (!empty($_SESSION['cart'])): ?>(<?= array_sum(array_column($_SESSION['cart'], 'qty')) ?>)<?php endif; ?></a>
            <?php if (isAdmin()): ?>
                <a href="/admin/dashboard.php">Admin Dashboard</a>
                <a href="/admin/menu_items.php">Manage Menu</a>
            <?php endif; ?>
            <span class="user-tag">Hi, <?= sanitize($_SESSION['name']) ?></span>
            <a href="/logout.php">Logout</a>
        <?php else: ?>
            <a href="/login.php">Login</a>
            <a href="/register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>
<main class="container">
