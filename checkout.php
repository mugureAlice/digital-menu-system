<?php

session_start();

if (empty($_SESSION['cart']))
{
    header("Location: cart.php");
    exit();
}

$total = 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h2>Checkout</h2>

<?php

echo "<table border='1' cellpadding='10'>";

echo "<tr>";
echo "<th>Item</th>";
echo "<th>Price</th>";
echo "<th>Quantity</th>";
echo "<th>Subtotal</th>";
echo "</tr>";

foreach($_SESSION['cart'] as $item)
{
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;

    echo "<tr>";

    echo "<td>".$item['name']."</td>";

    echo "<td>Ksh ".$item['price']."</td>";

    echo "<td>".$item['qty']."</td>";

    echo "<td>Ksh ".$subtotal."</td>";

    echo "</tr>";
}

echo "<tr>";

echo "<td colspan='3'><strong>Total</strong></td>";

echo "<td><strong>Ksh ".$total."</strong></td>";

echo "</tr>";

echo "</table>";

echo "<br>";

?>

<form action="place_order.php" method="POST">

    <label>Table Number</label><br><br>

    <input type="number" name="table_number" min="1" required>

    <br><br>

    <input type="submit" value="Place Order">

</form>

</body>
</html>