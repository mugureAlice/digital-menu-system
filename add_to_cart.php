<?php
session_start();
include 'includes/db.php';

if(!isset($_GET['id'])){
    die("Invalid menu item");
}

$id = intval( $_GET['id']);

$sql = "SELECT * FROM menu_items WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i" ,$id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$item = mysqli_fetch_assoc($result);

if(!$item){
    die("Menu item not found");

}


if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['qty']++;
}
else{
    $_SESSION['cart'][$id] = array(
        "name" => $item['name'],
        "price" => $item['price'],
        "qty" => 1
    );

    
}

header("Location: menu.php");
exit();

?> 
