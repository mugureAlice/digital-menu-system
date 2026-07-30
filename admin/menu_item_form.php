<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();


$message = "";

$id = null;
$name = "";
$category = "";
$price = "";
$description = "";
$image = "";


// Load existing item when editing

if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare(
        "SELECT * FROM menu_items WHERE id = ?"
    );

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



// Add or update menu item

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $name = sanitize($_POST['name'] ?? '');

    $category = sanitize($_POST['category'] ?? '');

    $price = $_POST['price'] ?? 0;

    $description = sanitize($_POST['description'] ?? '');



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



        $message = "Menu item updated successfully!";

        $image = $newImage;



    } else {



        $stmt = $pdo->prepare("
            INSERT INTO menu_items
            (name, category, price, description, image)
            VALUES (?, ?, ?, ?, ?)
        ");



        $stmt->execute([

            $name,
            $category,
            $price,
            $description,
            $newImage

        ]);



        $message = "Menu item added successfully!";

    }

}


require_once __DIR__ . '/../header.php';

?>


<h2>
    <?= $id ? 'Edit Menu Item' : 'Add New Menu Item'; ?>
</h2>



<?php if ($message): ?>

<p>
    <?= sanitize($message); ?>
</p>

<?php endif; ?>



<form method="POST" enctype="multipart/form-data">


<label>
    Food Name
</label>

<br>

<input 
    type="text" 
    name="name"
    value="<?= sanitize($name); ?>"
    required
>

<br><br>



<label>
    Category
</label>

<br>

<input 
    type="text"
    name="category"
    value="<?= sanitize($category); ?>"
    required
>

<br><br>



<label>
    Price (KES)
</label>

<br>

<input
    type="number"
    step="0.01"
    name="price"
    value="<?= sanitize($price); ?>"
    required
>

<br><br>



<label>
    Description
</label>

<br>

<textarea 
    name="description"
    rows="4"
><?= sanitize($description); ?></textarea>

<br><br>




<?php if (!empty($image)): ?>

<label>
    Current Image
</label>

<br>

<img 
    src="/digital-menu-system/uploads/<?= sanitize($image); ?>"
    width="150"
    alt="Menu Image"
>

<br><br>

<?php endif; ?>



<label>
    Upload Menu Image
</label>

<br>

<input 
    type="file"
    name="image"
    accept="image/jpeg,image/png,image/webp"
>

<br><br>



<button type="submit">

<?= $id ? 'Update Menu Item' : 'Save Menu Item'; ?>

</button>


</form>



<?php require_once __DIR__ . '/../footer.php'; ?>