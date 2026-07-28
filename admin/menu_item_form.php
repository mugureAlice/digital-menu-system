<?php

require_once '../config/db.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

requireAdmin();

$message = "";

$id = null;
$name = "";
$category = "";
$price = "";
$description = "";
$image = "";
if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);

    $item = $stmt->fetch();

    if ($item) {
        $name = $item['name'];
        $category = $item['category'];
        $price = $item['price'];
        $description = $item['description'];
        $image = $item['image'];
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = sanitize($_POST['name']);
    $category = sanitize($_POST['category']);
    $price = $_POST['price'];
    $description = sanitize($_POST['description']);

    $newImage = handleImageUpload('image');

    if ($id) {
        if (!$newImage) {
            $newImage = $image;
        }

        $stmt = $pdo->prepare("
            UPDATE menu_items
            SET
                name = ?,
                category = ?,
                price = ?,
                description = ?,
                image = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $name,
            $category,
            $price,
            $description,
            $newImage,
            $id
        ]);

        $message = "✅ Menu item updated successfully!";
        $image = $newImage;

    }
    
    else {

        $stmt = $pdo->prepare("
            INSERT INTO menu_items (name, category, price, description, image)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $category,
            $price,
            $description,
            $newImage
        ]);

        $message = "✅ Menu item added successfully!";
    }
}

?>

<?php include '../header.php'; ?>

<h2><?= $id ? 'Edit Menu Item' : 'Add New Menu Item'; ?></h2>

<?php if ($message): ?>
    <p><?= $message; ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <label>Food Name</label><br>
    <input
        type="text"
        name="name"
        value="<?= htmlspecialchars($name) ?>"
        required
    ><br><br>

    <label>Category</label><br>
    <input
        type="text"
        name="category"
        value="<?= htmlspecialchars($category) ?>"
        required
    ><br><br>

    <label>Price (KES)</label><br>
    <input
        type="number"
        step="0.01"
        name="price"
        value="<?= htmlspecialchars($price) ?>"
        required
    ><br><br>

    <label>Description</label><br>
    <textarea
        name="description"
        rows="4"
    ><?= htmlspecialchars($description) ?></textarea><br><br>

    <?php if (!empty($image)): ?>
        <label>Current Image</label><br>
        <img src="../uploads/<?= htmlspecialchars($image) ?>" width="150"><br><br>
    <?php endif; ?>

    <label>Menu Image</label><br>
    <input type="file" name="image"><br><br>

    <button type="submit">
        <?= $id ? 'Update Menu Item' : 'Save Menu Item'; ?>
    </button>

</form>

<?php include '../footer.php'; ?>