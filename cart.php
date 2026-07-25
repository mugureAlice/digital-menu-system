<?php
session_start();
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>
<body>
    <h2>Your cart</h2>
 
<?php
if(empty($_SESSION['cart'])){
    echo "Your cart is empty"
}
else{
    $total = 0;
      echo "<table border='1' cellpadding='10'>";
    echo "<tr>";
    echo "<th>Item</th>";
    echo "<th>Price</th>";
    echo "<th>Quantity</th>";
    echo "<th>Subtotal</th>";
    echo "<th>Action</th>";
    echo "</tr>";


    foreach($_SESSION['cart'] as $id => $item)
    {
        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;

        echo "<tr>";

        echo "<td>".$item['name']."</td>";

        echo "<td>Ksh ".$item['price']."</td>";

        echo "<td>
                <form action='update_cart.php' method='POST'>
                    <input type='hidden' name='id' value='".$id."'>
                    <input type='number' name='qty' value='".$item['qty']."' min='1'>
                    <input type='submit' value='Update'>
                </form>
              </td>";

          echo "<td>Ksh ".$subtotal."</td>";

        echo "<td>
                <a href='remove_from_cart.php?id=".$id."'>
                    Remove
                </a>
              </td>";

        echo "</tr>";
      

    


}

echo "<tr>";
    echo "<td colspan='3'><strong>Total</strong></td>";
    echo "<td><strong>Ksh ".$total."</strong></td>";
    echo "<td></td>";
    echo "</tr>";

    echo "</table>";

    echo "<br>";

    echo "<a href='checkout.php'>Proceed to Checkout</a>";


}


?>    
  
    
</body>
</html>
