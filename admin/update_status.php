<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

requireAdmin();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("
        UPDATE orders
        SET status = ?
        WHERE id = ?
    ");

    $stmt->execute([$status,$orderId]);
}

header("Location: dashboard.php");
exit;