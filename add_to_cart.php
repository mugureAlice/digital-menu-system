<?php
session_start();
include 'includes/db.php';

if(!isset($_GET['id'])){
    die("Invalid menu item");
}

$id = intval( $_GET['id']);

$sql = "SELECT * FROM menu_items WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$item) {
    die("Menu item not found");
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty']++;
} else {
    $_SESSION['cart'][$id] = [
        "name" => $item['name'],
        "price" => $item['price'],
        "qty" => 1
    ];
}

header("Location: menu.php");
exit();
?>