<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/db.php';


requireLogin();



if (!isset($_SESSION['cart'])) {

    $_SESSION['cart'] = [];

}



// Add item to cart

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {


    $itemId = (int) ($_POST['item_id'] ?? 0);

    $qty = max(1, (int) ($_POST['qty'] ?? 1));



    $stmt = $pdo->prepare(
        "SELECT * FROM menu_items WHERE id = ?"
    );


    $stmt->execute([$itemId]);


    $item = $stmt->fetch();



    if ($item) {


        if (isset($_SESSION['cart'][$itemId])) {


            $_SESSION['cart'][$itemId]['qty'] += $qty;



        } else {


            $_SESSION['cart'][$itemId] = [

                'id' => $item['id'],

                'name' => $item['name'],

                'price' => $item['price'],

                'qty' => $qty

            ];


        }

    }



    redirect('/digital-menu-system/menu.php');

}



// Category filter

$category = $_GET['category'] ?? '';



if ($category !== '') {


    $stmt = $pdo->prepare(
        "SELECT * FROM menu_items WHERE category = ? ORDER BY name"
    );


    $stmt->execute([$category]);



} else {


    $stmt = $pdo->query(
        "SELECT * FROM menu_items ORDER BY category, name"
    );


}



$items = $stmt->fetchAll();



// Get categories

$catStmt = $pdo->query(
    "SELECT DISTINCT category FROM menu_items ORDER BY category"
);


$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);



require_once __DIR__ . '/header.php';

?>


<h2>Our Menu</h2>



<div class="filter-bar">


<a 
href="/digital-menu-system/menu.php"
class="<?= $category === '' ? 'active' : '' ?>"
>
All
</a>



<?php foreach ($categories as $cat): ?>


<a 
href="/digital-menu-system/menu.php?category=<?= urlencode($cat) ?>"
class="<?= $category === $cat ? 'active' : '' ?>"
>

<?= sanitize($cat) ?>

</a>



<?php endforeach; ?>


</div>




<div class="menu-grid">


<?php foreach ($items as $item): ?>


<div class="menu-card">



<?php if (!empty($item['image'])): ?>


<img 
src="/digital-menu-system/uploads/<?= sanitize($item['image']) ?>"
alt="<?= sanitize($item['name']) ?>"
>



<?php else: ?>


<div class="img-placeholder">

No Image

</div>



<?php endif; ?>




<h3>
<?= sanitize($item['name']) ?>
</h3>




<p class="category-tag">

<?= sanitize($item['category']) ?>

</p>




<p class="price">

KES <?= number_format($item['price'], 2) ?>

</p>




<form method="POST" class="add-form">


<input 
type="hidden" 
name="item_id" 
value="<?= $item['id'] ?>"
>



<input 
type="number" 
name="qty" 
value="1" 
min="1" 
class="qty-input"
>



<button 
type="submit" 
name="add_to_cart"
>
Add to Cart
</button>



</form>



</div>



<?php endforeach; ?>



</div>



<?php require_once __DIR__ . '/footer.php'; ?>