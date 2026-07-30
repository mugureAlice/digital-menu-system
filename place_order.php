<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/db.php';


if (!isLoggedIn()) {

    header("Location: /digital-menu-system/login.php");
    exit;

}



if (empty($_SESSION['cart'])) {

    header("Location: /digital-menu-system/cart.php");
    exit;

}



$user_id = $_SESSION['user_id'];


$table_number = $_POST['table_number'] ?? null;


if (!$table_number) {

    die("Table number is required");

}



$total = 0;


foreach ($_SESSION['cart'] as $item) {

    $total += $item['price'] * $item['qty'];

}



$sql = "
INSERT INTO orders(user_id, table_number, total)
VALUES (?, ?, ?)
";


$stmt = $pdo->prepare($sql);


$stmt->execute([
    $user_id,
    $table_number,
    $total
]);



$order_id = $pdo->lastInsertId();



foreach ($_SESSION['cart'] as $id => $item) {


    $sql = "
    INSERT INTO order_items(order_id, menu_item_id, quantity, price)
    VALUES (?, ?, ?, ?)
    ";


    $stmt = $pdo->prepare($sql);


    $stmt->execute([

        $order_id,

        $id,

        $item['qty'],

        $item['price']

    ]);

}



unset($_SESSION['cart']);



header("Location: /digital-menu-system/order_successfully.php");

exit;

?>