<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();


if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];


    $stmt = $pdo->prepare(
        "DELETE FROM menu_items WHERE id = ?"
    );


    $stmt->execute([$id]);

}


header("Location: /digital-menu-system/admin/menu_items.php");

exit;

?>