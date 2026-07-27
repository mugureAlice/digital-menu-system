<?php

require_once '../config/db.php';
require_once '../includes/auth.php';

requireAdmin();


if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);

}

header("Location: menu_itemss.php");
exit;

?>