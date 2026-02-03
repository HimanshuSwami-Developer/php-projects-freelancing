<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

$products = $db->query("SELECT COUNT(*) total FROM products")->fetch_assoc();
$orders   = $db->query("SELECT COUNT(*) total FROM orders")->fetch_assoc();
$users    = $db->query("SELECT COUNT(*) total FROM users")->fetch_assoc();
?>

<h1 class="text-3xl font-bold mb-10">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <div class="border p-6 rounded-lg">
        <p class="text-gray-500">Products</p>
        <p class="text-4xl font-bold"><?= $products['total'] ?></p>
    </div>

    <div class="border p-6 rounded-lg">
        <p class="text-gray-500">Orders</p>
        <p class="text-4xl font-bold"><?= $orders['total'] ?></p>
    </div>

    <div class="border p-6 rounded-lg">
        <p class="text-gray-500">Users</p>
        <p class="text-4xl font-bold"><?= $users['total'] ?></p>
    </div>

</div>

<?php include 'includes/footer.php'; ?>
