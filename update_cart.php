<?php

require_once __DIR__ . '/includes/auth.php';


if (isset($_POST['id']) && isset($_POST['qty'])) {

    $id = intval($_POST['id']);

    $qty = intval($_POST['qty']);


    if ($qty > 0 && isset($_SESSION['cart'][$id])) {

        $_SESSION['cart'][$id]['qty'] = $qty;

    }

}


header("Location: /digital-menu-system/cart.php");

exit;

?>