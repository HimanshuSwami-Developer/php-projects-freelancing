<?php
/*
Expected variables:
$p       → product array
$isFav   → boolean
$pageUrl → current page url
$db      → database connection (already available)
*/

/* ===== FETCH FIRST IMAGE ===== */
$img = $db->query("
    SELECT image 
    FROM product_images 
    WHERE product_id = {$p['id']} 
    ORDER BY id ASC 
    LIMIT 1
")->fetch_assoc();

$imagePath = $img
    ? "assets/images/products/" . $img['image']
    : "assets/images/no-image.png"; // fallback image
?>

<div class="relative border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition bg-white">

    <!-- ===== Favourite Button ===== -->
    <a href="<?= $pageUrl ?>&fav=<?= $p['id'] ?>"
       class="absolute top-3 right-3 z-10 bg-white/80 backdrop-blur rounded-full p-1">

        <?php if ($isFav): ?>
        <!-- Filled Heart -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
             fill="currentColor" class="w-6 h-6 text-black">
            <path d="M11.645 20.91a.75.75 0 0 0 .71 0
                     C13.385 20.352 21 16.07 21 8.25
                     21 5.765 18.901 3.75 16.313 3.75
                     c-1.935 0-3.597 1.126-4.312 2.733
                     -.715-1.607-2.377-2.733-4.313-2.733
                     C5.1 3.75 3 5.765 3 8.25
                     c0 7.82 7.615 12.102 8.645 12.66Z"/>
        </svg>
        <?php else: ?>
        <!-- Outline Heart -->
        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor"
             class="w-6 h-6 text-gray-400 hover:text-black transition">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5
                     -1.935 0-3.597 1.126-4.312 2.733
                     -.715-1.607-2.377-2.733-4.313-2.733
                     C5.1 3.75 3 5.765 3 8.25
                     c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
        </svg>
        <?php endif; ?>
    </a>

    <!-- ===== IMAGE ===== -->
    <div class="h-56 overflow-hidden bg-gray-100">
        <img src="<?= $imagePath ?>"
             alt="<?= htmlspecialchars($p['title']) ?>"
             class="w-full h-full object-cover hover:scale-105 transition duration-300">
    </div>

    <!-- ===== CONTENT ===== -->
    <div class="p-5">

        <h3 class="font-semibold text-lg truncate">
            <?= htmlspecialchars($p['title']) ?>
        </h3>

        <!-- Rating -->
        <div class="flex items-center gap-1 text-sm mt-1">
            ⭐ ⭐ ⭐ ⭐ <span class="text-gray-400">(<?= number_format($p['rating'],1) ?>)</span>
        </div>

        <p class="text-gray-500 text-sm mt-1">
            ₹<?= number_format($p['sale_price'] ?? $p['price'], 2) ?>
        </p>

        <!-- Buttons -->
        <div class="flex gap-3 mt-4">

            <!-- Add to Cart -->
            <form method="post" action="cart.php" class="flex-1">
                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="size" value="M">
                <button type="submit"
                        class="w-full border border-black py-2 text-sm
                               hover:bg-black hover:text-white transition">
                    Add to Cart
                </button>
            </form>

            <!-- View -->
            <a href="product-details.php?id=<?= $p['id'] ?>"
               class="flex-1 text-center border border-gray-300 py-2 text-sm
                      hover:bg-gray-100 transition">
                View
            </a>

        </div>
    </div>
</div>
