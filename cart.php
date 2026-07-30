<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';

?>


<?php require __DIR__ . '/header.php'; ?>


<h2>Your Cart</h2>


<?php

if (empty($_SESSION['cart'])) {

    echo "<p>Your cart is empty</p>";

} else {

    $total = 0;

    echo "<table border='1' cellpadding='10'>";

    echo "
    <tr>
        <th>Item</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>
    ";


    foreach ($_SESSION['cart'] as $id => $item) {


        $subtotal = $item['price'] * $item['qty'];

        $total += $subtotal;


        echo "<tr>";


        echo "<td>" . sanitize($item['name']) . "</td>";


        echo "<td>Ksh " . $item['price'] . "</td>";



        echo "
        <td>

            <form action='/digital-menu-system/update_cart.php' method='POST'>

                <input 
                    type='hidden' 
                    name='id' 
                    value='$id'
                >


                <input 
                    type='number' 
                    name='qty' 
                    value='{$item['qty']}' 
                    min='1'
                >


                <input 
                    type='submit' 
                    value='Update'
                >

            </form>

        </td>
        ";



        echo "<td>Ksh " . $subtotal . "</td>";



        echo "
        <td>
            <a href='/digital-menu-system/remove_from_cart.php?id=$id'>
                Remove
            </a>
        </td>
        ";


        echo "</tr>";

    }



    echo "
    <tr>
        <td colspan='3'><strong>Total</strong></td>
        <td><strong>Ksh $total</strong></td>
        <td></td>
    </tr>
    ";


    echo "</table>";


    echo "
    <br>

    <a href='/digital-menu-system/checkout.php'>
        Proceed to Checkout
    </a>
    ";

}

?>


<?php require __DIR__ . '/footer.php'; ?>