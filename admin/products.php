<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();
$products = $db->query("SELECT * FROM products ORDER BY id DESC");
?>

<h1 class="text-3xl font-bold mb-8">Products</h1>

<table class="w-full border">
    <tr class="bg-gray-100">
        <th class="p-3 border">Title</th>
        <th class="p-3 border">Price</th>
        <th class="p-3 border">Status</th>
    </tr>

    <?php while ($p = $products->fetch_assoc()): ?>
    <tr>
        <td class="p-3 border"><?= $p['title'] ?></td>
        <td class="p-3 border">₹<?= $p['price'] ?></td>
        <td class="p-3 border"><?= $p['status'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
