<?php
session_start();

require_once 'config/db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(empty($_SESSION['cart'])){
    header("Location: cart.php")
    exit();
}

$user_id = $_SESSION['user_id'];

$table_number = $_POST['table_number'];

$total = o;

foreach($_SESSION['cart'] as $item){
    $total += $item['price'] * $item['qty'];
}

$sql = "INSERT INTO orders(user_id, table_number, total) VALUES(?,?,?)";

$stmt = $pdo->prepare($sql);


$stmt->execute([
    $user_id,
    $table_number,
    $total
]);

$order_id = $pdo->lastInsertId();

foreach ($_SESSION['cart'] as $id => $item) {

    $sql = "INSERT INTO order_items (order_id, menu_item_id, quantity, price)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $order_id,
        $id,
        $item['qty'],
        $item['price']
    ]);

}

unset($_SESSION['cart']);

header("Location: order_success.php");

exit();



?>