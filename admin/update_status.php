<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

requireAdmin();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $orderId = isset($_POST['order_id']) ? (int) $_POST['order_id'] : 0;

    $status = $_POST['status'] ?? '';



    $allowedStatuses = [
        'Pending',
        'Prepared',
        'Served'
    ];



    if ($orderId > 0 && in_array($status, $allowedStatuses)) {


        $stmt = $pdo->prepare("
            UPDATE orders
            SET status = ?
            WHERE id = ?
        ");



        $stmt->execute([
            $status,
            $orderId
        ]);

    }

}



header("Location: /digital-menu-system/admin/dashboard.php");

exit;

?>