<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

requireAdmin();


$stmt = $pdo->query(
    "SELECT * FROM menu_items ORDER BY created_at DESC"
);


$menuItems = $stmt->fetchAll();


require_once __DIR__ . '/../header.php';

?>


<h2>
    Menu Management
</h2>



<p>

    <a href="/digital-menu-system/admin/menu_item_form.php">
        ➕ Add New Menu Item
    </a>

</p>




<table border="1" cellpadding="10" cellspacing="0">


<thead>

<tr>

    <th>ID</th>

    <th>Image</th>

    <th>Name</th>

    <th>Category</th>

    <th>Price (KES)</th>

    <th>Actions</th>

</tr>

</thead>



<tbody>



<?php if (count($menuItems) > 0): ?>



<?php foreach ($menuItems as $item): ?>


<tr>


<td>
    <?= $item['id']; ?>
</td>



<td>


<?php if (!empty($item['image'])): ?>


<img 
    src="/digital-menu-system/uploads/<?= sanitize($item['image']); ?>" 
    width="80"
    alt="Menu Item"
>


<?php else: ?>


No Image


<?php endif; ?>


</td>




<td>
    <?= sanitize($item['name']); ?>
</td>




<td>
    <?= sanitize($item['category']); ?>
</td>




<td>
    KES <?= number_format($item['price'], 2); ?>
</td>




<td>


<a href="/digital-menu-system/admin/menu_item_form.php?id=<?= $item['id']; ?>">
    Edit
</a>



|



<a 
href="/digital-menu-system/admin/delete_menu_item.php?id=<?= $item['id']; ?>"
onclick="return confirm('Are you sure you want to delete this item?');"
>
    Delete
</a>



</td>


</tr>



<?php endforeach; ?>



<?php else: ?>



<tr>

<td colspan="6">
    No menu items found.
</td>

</tr>



<?php endif; ?>



</tbody>


</table>



<?php require_once __DIR__ . '/../footer.php'; ?>