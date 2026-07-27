<?php

require_once '../config/db.php';


require_once '../includes/functions.php';


require_once '../includes/auth.php';


requireAdmin();




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    $name = sanitize($_POST['name']);
    $category = sanitize($_POST['category']);
    $price = $_POST['price'];
    $description = sanitize($_POST['description']);

    
    $stmt = $pdo->prepare("
        INSERT INTO menu_items (name, category, price, description)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $name,
        $category,
        $price,
        $description
    ]);

    $message = "✅ Menu item added successfully!";
}

?>

<?php include '../header.php'; ?>

<h2>Add New Menu Item</h2>


<?php if ($message): ?>
    <p><?= $message; ?></p>
<?php endif; ?>

<form method="POST">

    
    <label>Food Name</label><br>
    <input type="text" name="name" required><br><br>

   
    <label>Category</label><br>
    <input type="text" name="category" required><br><br>

   
    <label>Price (KES)</label><br>
    <input type="number" step="0.01" name="price" required><br><br>

   
    <label>Description</label><br>
    <textarea name="description" rows="4"></textarea><br><br>

    
    <button type="submit">Save Menu Item</button>

</form>

<?php include '../footer.php'; ?>