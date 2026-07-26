<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/db.php';

requireAdmin();

// Dashboard Statistics
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

$pendingOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Pending'")->fetchColumn();

$preparedOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Prepared'")->fetchColumn();

$servedOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status='Served'")->fetchColumn();

// Get all orders with customer names
$stmt = $pdo->query("
    SELECT
        orders.*,
        users.name
    FROM orders
    INNER JOIN users
        ON orders.user_id = users.id
    ORDER BY orders.created_at DESC
");

$orders = $stmt->fetchAll();

require_once __DIR__ . '/../header.php';
?>

<style>

.dashboard-cards{
    display:flex;
    gap:20px;
    margin:20px 0;
    flex-wrap:wrap;
}

.card{
    flex:1;
    min-width:180px;
    background:#ffffff;
    padding:20px;
    border-radius:8px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
    text-align:center;
}

.card h3{
    margin-bottom:10px;
}

.card p{
    font-size:24px;
    font-weight:bold;
}

.orders-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.orders-table th,
.orders-table td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

.orders-table th{
    background:#333;
    color:white;
}

button{
    padding:6px 12px;
    cursor:pointer;
}

select{
    padding:5px;
}

</style>

<h2>Admin Dashboard</h2>

<p>Welcome, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong></p>

<div class="dashboard-cards">

    <div class="card">
        <h3>Total Orders</h3>
        <p><?= $totalOrders ?></p>
    </div>

    <div class="card">
        <h3>Pending</h3>
        <p><?= $pendingOrders ?></p>
    </div>

    <div class="card">
        <h3>Prepared</h3>
        <p><?= $preparedOrders ?></p>
    </div>

    <div class="card">
        <h3>Served</h3>
        <p><?= $servedOrders ?></p>
    </div>

</div>

<h3>Recent Orders</h3>

<table class="orders-table">

<thead>

<tr>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Table</th>
    <th>Total</th>
    <th>Status</th>
    <th>Date</th>
    <th>Update Status</th>
</tr>

</thead>

<tbody>

<?php if(count($orders) > 0): ?>

<?php foreach($orders as $order): ?>

<tr>

<td><?= $order['id'] ?></td>

<td><?= htmlspecialchars($order['name']) ?></td>

<td><?= htmlspecialchars($order['table_number']) ?></td>

<td>KSh <?= number_format($order['total'],2) ?></td>

<td><?= htmlspecialchars($order['status']) ?></td>

<td><?= $order['created_at'] ?></td>

<td>

<form action="update_status.php" method="POST">

<input
type="hidden"
name="order_id"
value="<?= $order['id'] ?>">

<select name="status">

<option value="Pending"
<?= $order['status']=='Pending' ? 'selected' : '' ?>>
Pending
</option>

<option value="Prepared"
<?= $order['status']=='Prepared' ? 'selected' : '' ?>>
Prepared
</option>

<option value="Served"
<?= $order['status']=='Served' ? 'selected' : '' ?>>
Served
</option>

</select>

<button type="submit">
Update
</button>

</form>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
<td colspan="7">
No orders found.
</td>
</tr>

<?php endif; ?>

</tbody>

</table>

<?php require_once __DIR__ . '/../footer.php'; ?>