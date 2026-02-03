<?php
include 'includes/header.php';
include 'config/db.php';

$db = getDB();

/* ================= INIT CART ================= */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ================= ADD TO CART ================= */
if (isset($_POST['product_id'], $_POST['quantity'], $_POST['size'])) {

    $pid  = (int)$_POST['product_id'];
    $qty  = (int)$_POST['quantity'];
    $size = trim($_POST['size']);

    if ($qty > 0 && $size !== '') {

        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$pid] = [
                'qty'  => $qty,
                'size' => $size
            ];
        }
    }

    header("Location: cart.php");
    exit;
}

/* ================= UPDATE CART ================= */
if (isset($_POST['update_cart']) && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $pid => $qty) {
        $qty = (int)$qty;

        if ($qty <= 0) {
            unset($_SESSION['cart'][$pid]);
        } else {
            $_SESSION['cart'][$pid]['qty'] = $qty;
        }
    }
}

/* ================= REMOVE ITEM ================= */
if (isset($_GET['remove'])) {
    $pid = (int)$_GET['remove'];
    unset($_SESSION['cart'][$pid]);
    header("Location: cart.php");
    exit;
}
?>

<section class="max-w-6xl mx-auto px-6 py-20">

    <h1 class="text-4xl font-bold mb-12 text-center">
        Your Cart
    </h1>

<?php if (!empty($_SESSION['cart'])): ?>

<form method="post">

<?php
$grandTotal = 0;
?>

<!-- ================= DESKTOP TABLE ================= -->
<div class="hidden md:block overflow-x-auto border border-gray-200 rounded-xl bg-white/70 backdrop-blur-xl">
    <table class="w-full text-left">
        <thead class="border-b bg-gray-50">
            <tr>
                <th class="p-4">Product</th>
                <th class="p-4">Size</th>
                <th class="p-4">Price</th>
                <th class="p-4">Quantity</th>
                <th class="p-4">Total</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody>

<?php foreach ($_SESSION['cart'] as $pid => $item):
    $qty  = $item['qty'];
    $size = $item['size'];

    $product = $db->query("SELECT * FROM products WHERE id = $pid")->fetch_assoc();
    if (!$product) continue;

    $total = $product['price'] * $qty;
    $grandTotal += $total;
?>
<tr class="border-b">
    <td class="p-4 font-medium">
        <?= htmlspecialchars($product['title']) ?>
    </td>
    <td class="p-4">
        <span class="border px-3 py-1 text-sm"><?= htmlspecialchars($size) ?></span>
    </td>
    <td class="p-4">₹<?= number_format($product['price'], 2) ?></td>
    <td class="p-4">
        <input type="number" name="qty[<?= $pid ?>]"
               value="<?= $qty ?>" min="1"
               class="border px-3 py-2 w-20">
    </td>
    <td class="p-4 font-semibold">
        ₹<?= number_format($total, 2) ?>
    </td>
    <td class="p-4">
        <a href="cart.php?remove=<?= $pid ?>"
           class="text-red-600 text-sm hover:underline">
            Remove
        </a>
    </td>
</tr>
<?php endforeach; ?>

        </tbody>
    </table>
</div>

<!-- ================= MOBILE CARDS ================= -->
<div class="md:hidden space-y-6">
<?php foreach ($_SESSION['cart'] as $pid => $item):
    $qty  = $item['qty'];
    $size = $item['size'];

    $product = $db->query("SELECT * FROM products WHERE id = $pid")->fetch_assoc();
    if (!$product) continue;

    $total = $product['price'] * $qty;
?>
    <div class="border border-gray-200 rounded-xl p-5 bg-white/80 backdrop-blur-xl">

        <h3 class="font-semibold text-lg">
            <?= htmlspecialchars($product['title']) ?>
        </h3>

        <div class="text-sm text-gray-600 mt-2 space-y-1">
            <p>Size: <span class="font-medium"><?= htmlspecialchars($size) ?></span></p>
            <p>Price: ₹<?= number_format($product['price'], 2) ?></p>
        </div>

        <div class="flex items-center justify-between mt-4">
            <input type="number" name="qty[<?= $pid ?>]"
                   value="<?= $qty ?>" min="1"
                   class="border px-3 py-2 w-20">

            <span class="font-semibold">
                ₹<?= number_format($total, 2) ?>
            </span>
        </div>

        <a href="cart.php?remove=<?= $pid ?>"
           class="block mt-4 text-sm text-red-600 hover:underline">
            Remove
        </a>
    </div>
<?php endforeach; ?>
</div>

<!-- ================= ACTIONS ================= -->
<div class="flex flex-col md:flex-row justify-between items-center mt-12 gap-6">
    <button type="submit" name="update_cart"
            class="border border-black px-8 py-3 font-semibold
                   hover:bg-black hover:text-white transition w-full md:w-auto">
        Update Cart
    </button>

    <div class="text-xl font-bold">
        Grand Total: ₹<?= number_format($grandTotal, 2) ?>
    </div>
</div>

</form>

<div class="text-center mt-14">
    <a href="checkout.php"
       class="inline-block bg-black text-white px-12 py-4 font-semibold
              hover:bg-gray-800 transition w-full md:w-auto">
        Proceed to Checkout
    </a>
</div>

<?php else: ?>
    <p class="text-center text-gray-500">
        Your cart is empty.
    </p>
<?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>
