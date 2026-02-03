<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

/* ================= FETCH ORDERS ================= */
$orders = $db->query("
    SELECT 
        o.id,
        o.order_number,
        o.total_amount,
        o.status,
        o.created_at,
        u.name,
        u.phone,
        u.city,
        u.address
    FROM orders o
    JOIN users u ON u.id = o.user_id
    ORDER BY o.id DESC
");
?>

<h1 class="text-3xl font-bold mb-8">Orders</h1>

<div class="space-y-8">

<?php while ($o = $orders->fetch_assoc()): ?>

<?php
/* ================= FETCH ORDER ITEMS ================= */
$items = $db->query("
    SELECT 
        p.title,
        oi.quantity,
        oi.size,
        oi.price
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = {$o['id']}
");
?>

<div class="border border-gray-200 rounded-xl p-6 bg-white shadow-sm">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">

        <div>
            <h2 class="text-lg font-semibold">
                Order ID:
                <span class="font-mono">
                    <?= htmlspecialchars($o['order_number'] ?? 'BB' . str_pad($o['id'], 6, '0', STR_PAD_LEFT)) ?>
                </span>
            </h2>

            <p class="text-sm text-gray-500">
                <?= date('d M Y, h:i A', strtotime($o['created_at'])) ?>
            </p>
        </div>

        <div class="text-right">
            <p class="font-semibold">
                Total: ₹<?= number_format($o['total_amount'], 2) ?>
            </p>

            <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full
                <?= $o['status'] === 'pending'
                    ? 'bg-yellow-100 text-yellow-800'
                    : 'bg-green-100 text-green-800' ?>">
                <?= ucfirst($o['status']) ?>
            </span>
        </div>
    </div>

    <!-- CUSTOMER -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div>
            <p class="text-sm text-gray-500">Customer</p>
            <p class="font-medium"><?= htmlspecialchars($o['name']) ?></p>
            <p class="text-sm"><?= htmlspecialchars($o['phone']) ?></p>
        </div>

        <div>
            <p class="text-sm text-gray-500">Address</p>
            <p class="text-sm">
                <?= htmlspecialchars($o['city']) ?><br>
                <?= nl2br(htmlspecialchars($o['address'])) ?>
            </p>
        </div>

    </div>

    <!-- PRODUCTS -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 border">Product</th>
                    <th class="p-3 border">Size</th>
                    <th class="p-3 border">Qty</th>
                    <th class="p-3 border">Price</th>
                    <th class="p-3 border">Total</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($i = $items->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="p-3 border">
                        <?= htmlspecialchars($i['title']) ?>
                    </td>
                    <td class="p-3 border text-center">
                        <?= htmlspecialchars($i['size']) ?>
                    </td>
                    <td class="p-3 border text-center">
                        <?= (int)$i['quantity'] ?>
                    </td>
                    <td class="p-3 border">
                        ₹<?= number_format($i['price'], 2) ?>
                    </td>
                    <td class="p-3 border font-semibold">
                        ₹<?= number_format($i['price'] * $i['quantity'], 2) ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php endwhile; ?>

</div>

<?php include 'includes/footer.php'; ?>
