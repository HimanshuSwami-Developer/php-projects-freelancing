<?php
include 'includes/header.php';
include 'config/db.php';

$db = getDB();

/* ================= SESSION FAVOURITES ================= */
if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = [];
}

/* ================= PRODUCT ID ================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

/* ================= TOGGLE FAVOURITE ================= */
if (isset($_GET['fav'])) {
    $pid = (int)$_GET['fav'];

    if (isset($_SESSION['favourites'][$pid])) {
        unset($_SESSION['favourites'][$pid]);
    } else {
        $_SESSION['favourites'][$pid] = $pid;
    }

    header("Location: product-details.php?id=$pid");
    exit;
}

/* ================= FETCH PRODUCT ================= */
$product = $db->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
if (!$product) {
    echo "<div class='text-center py-20'>Product not found</div>";
    include 'includes/footer.php';
    exit;
}

$isFav = isset($_SESSION['favourites'][$product['id']]);

/* ================= RELATED PRODUCTS ================= */
$related = $db->query("
    SELECT * FROM products 
    WHERE category_id = {$product['category_id']} 
    AND id != {$product['id']} 
    LIMIT 4
");
?>

<section class="max-w-7xl mx-auto px-6 py-20">

    <!-- ================= PRODUCT MAIN ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

        <!-- ================= GALLERY ================= -->
        <div class="border border-gray-200 rounded-lg p-6 relative">

            <!-- Favourite Icon -->
            <a href="product-details.php?id=<?= $product['id'] ?>&fav=<?= $product['id'] ?>"
               class="absolute top-4 right-4 text-3xl select-none">
                <?= $isFav ? '❤️' : '🤍' ?>
            </a>

            <div class="h-96 bg-gray-100 flex items-center justify-center mb-4">
                <span class="text-gray-400">Main Image</span>
            </div>

            <div class="flex gap-3">
                <div class="w-20 h-20 bg-gray-200"></div>
                <div class="w-20 h-20 bg-gray-200"></div>
                <div class="w-20 h-20 bg-gray-200"></div>
            </div>
        </div>

        <!-- ================= DETAILS ================= -->
        <div>
            <h1 class="text-4xl font-bold">
                <?= htmlspecialchars($product['title']) ?>
            </h1>

            <p class="text-gray-600 mt-4 leading-relaxed">
                <?= htmlspecialchars($product['description']) ?>
            </p>

            <p class="text-3xl font-semibold mt-6">
                ₹<?= number_format($product['price'], 2) ?>
            </p>

            <!-- Stock -->
            <p class="mt-3">
                <?php if ($product['status'] === 'available'): ?>
                    <span class="text-green-600 font-medium">In Stock</span>
                <?php else: ?>
                    <span class="text-red-600 font-medium">Out of Stock</span>
                <?php endif; ?>
            </p>

            <!-- ================= ADD TO CART FORM ================= -->
            <form method="post" action="cart.php" class="mt-8 space-y-6">

                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                <!-- Size -->
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Select Size
                    </label>
                    <select name="size" required
                            class="border px-4 py-2 w-40">
                        <option value="S">Select</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Quantity
                    </label>
                    <input type="number" name="quantity" value="1" min="1"
                           class="border px-4 py-2 w-24">
                </div>

                <button type="submit"
                        class="border border-black px-10 py-3 font-semibold
                               hover:bg-black hover:text-white transition">
                    Add to Cart
                </button>

            </form>
        </div>
    </div>

    <!-- ================= RELATED PRODUCTS ================= -->
    <div class="mt-28">
        <h2 class="text-3xl font-bold mb-12 text-center">
            Related Dresses
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">
            <?php while ($r = $related->fetch_assoc()):
                $p = $r;
                $isFav = isset($_SESSION['favourites'][$p['id']]);
                $pageUrl = "product-details.php?id={$product['id']}";
                include 'product-card.php';
            endwhile; ?>
        </div>
    </div>

</section>

<?php include 'includes/footer.php'; ?>
