<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

$orders = $db->query("
    SELECT o.*, u.name, u.phone
    FROM orders o
    JOIN users u ON u.id = o.user_id
    ORDER BY o.id DESC
");
?>

<h1 class="text-3xl font-bold mb-8">Orders</h1>

<table class="w-full border">
    <tr class="bg-gray-100">
        <th class="p-3 border">Order ID</th>
        <th class="p-3 border">Customer</th>
        <th class="p-3 border">Phone</th>
        <th class="p-3 border">Total</th>
        <th class="p-3 border">Status</th>
    </tr>

    <?php while ($o = $orders->fetch_assoc()): ?>
    <tr>
        <td class="p-3 border">BB<?= str_pad($o['id'], 6, '0', STR_PAD_LEFT) ?></td>
        <td class="p-3 border"><?= $o['name'] ?></td>
        <td class="p-3 border"><?= $o['phone'] ?></td>
        <td class="p-3 border">₹<?= $o['total_amount'] ?></td>
        <td class="p-3 border"><?= $o['status'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
