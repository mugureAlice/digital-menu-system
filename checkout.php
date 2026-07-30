<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';


if (empty($_SESSION['cart'])) {

    header("Location: /digital-menu-system/cart.php");
    exit;

}


$total = 0;

?>


<?php require __DIR__ . '/header.php'; ?>


<h2>Checkout</h2>


<table border="1" cellpadding="10">

<tr>
    <th>Item</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
</tr>


<?php foreach ($_SESSION['cart'] as $item): ?>

<?php

$subtotal = $item['price'] * $item['qty'];

$total += $subtotal;

?>


<tr>

    <td>
        <?= sanitize($item['name']) ?>
    </td>


    <td>
        Ksh <?= $item['price'] ?>
    </td>


    <td>
        <?= $item['qty'] ?>
    </td>


    <td>
        Ksh <?= $subtotal ?>
    </td>

</tr>


<?php endforeach; ?>


<tr>

    <td colspan="3">
        <strong>Total</strong>
    </td>


    <td>
        <strong>Ksh <?= $total ?></strong>
    </td>

</tr>


</table>


<br>


<form action="/digital-menu-system/place_order.php" method="POST">

    <label>
        Table Number
    </label>

    <br><br>


    <input 
        type="number" 
        name="table_number" 
        min="1" 
        required
    >


    <br><br>


    <input 
        type="submit" 
        value="Place Order"
    >

</form>


<?php require __DIR__ . '/footer.php'; ?>