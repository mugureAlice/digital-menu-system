<?php

require_once __DIR__ . '/includes/auth.php';


if (isset($_GET['id'])) {

    $id = intval($_GET['id']);


    if (isset($_SESSION['cart'][$id])) {

        unset($_SESSION['cart'][$id]);

    }

}


header("Location: /digital-menu-system/cart.php");

exit;

?>