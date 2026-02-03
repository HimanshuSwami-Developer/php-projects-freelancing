<?php
include 'includes/header.php';
include 'config/db.php';

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$db = getDB();
?>

<section class="max-w-4xl mx-auto px-6 py-20">

    <h1 class="text-4xl font-bold mb-12 text-center">
        Checkout
    </h1>

    <form method="post" action="place-order.php"
          class="bg-white/70 backdrop-blur-xl border border-gray-200 rounded-2xl p-10 space-y-6">

        <!-- ================= USER INFO ================= -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="text" name="name" required
                   placeholder="Full Name"
                   class="border px-4 py-3 rounded">

            <input type="email" name="email" required
                   placeholder="Email Address"
                   class="border px-4 py-3 rounded">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="text" name="phone" required
                   placeholder="Phone Number"
                   class="border px-4 py-3 rounded">

            <input type="text" name="city" required
                   placeholder="City"
                   class="border px-4 py-3 rounded">
        </div>

        <textarea name="address" rows="4" required
                  placeholder="Full Address"
                  class="border px-4 py-3 rounded w-full"></textarea>

        <!-- ================= ORDER SUMMARY ================= -->
        <div class="border-t pt-6">
            <h3 class="font-semibold mb-4">Order Summary</h3>

            <?php
            $total = 0;

            foreach ($_SESSION['cart'] as $pid => $item):
                $qty  = $item['qty'];
                $size = $item['size'];

                $p = $db->query("SELECT * FROM products WHERE id = $pid")->fetch_assoc();
                if (!$p) continue;

                $line = $p['price'] * $qty;
                $total += $line;
            ?>
            <div class="flex justify-between text-sm mb-2">
                <span>
                    <?= htmlspecialchars($p['title']) ?>
                    <span class="text-gray-500">
                        (Size: <?= htmlspecialchars($size) ?>)
                    </span>
                    × <?= $qty ?>
                </span>
                <span>₹<?= number_format($line, 2) ?></span>
            </div>
            <?php endforeach; ?>

            <div class="flex justify-between font-bold text-lg mt-4">
                <span>Total</span>
                <span>₹<?= number_format($total, 2) ?></span>
            </div>
        </div>

        <button type="submit"
                class="w-full bg-black text-white py-4 font-semibold
                       hover:bg-gray-800 transition rounded">
            Place Order
        </button>
    </form>

</section>

<?php include 'includes/footer.php'; ?>
