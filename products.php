<?php
include 'includes/header.php';
include 'config/db.php';

$db = getDB();

/* ===== SESSION FAVOURITES ===== */
if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = [];
}

/* ===== CATEGORY FILTER ===== */
$categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;

/* ===== TOGGLE FAVOURITE ===== */
if (isset($_GET['fav'])) {
    $pid = (int)$_GET['fav'];

    if (isset($_SESSION['favourites'][$pid])) {
        unset($_SESSION['favourites'][$pid]);
    } else {
        $_SESSION['favourites'][$pid] = $pid;
    }

    $redirect = "products.php";
    if ($categoryFilter > 0) {
        $redirect .= "?category=" . $categoryFilter;
    }
    header("Location: $redirect");
    exit;
}

/* ===== FETCH DATA ===== */
$categories = $db->query("SELECT * FROM categories WHERE status = 1");

$sql = "SELECT * FROM products";
if ($categoryFilter > 0) {
    $sql .= " WHERE category_id = $categoryFilter";
}
$products = $db->query($sql);
?>

<section class="max-w-7xl mx-auto px-6 py-20">

    <h1 class="text-4xl font-bold mb-12 text-center">Our Collection</h1>

    <!-- Category Filter -->
    <div class="flex flex-wrap justify-center gap-4 mb-16">
        <a href="products.php"
           class="border px-5 py-2 text-sm transition
           <?= $categoryFilter === 0 ? 'bg-black text-white' : 'hover:bg-black hover:text-white' ?>">
            All
        </a>

        <?php while ($cat = $categories->fetch_assoc()): ?>
            <a href="products.php?category=<?= $cat['id'] ?>"
               class="border px-5 py-2 text-sm transition
               <?= $categoryFilter === (int)$cat['id'] ? 'bg-black text-white' : 'hover:bg-black hover:text-white' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

<?php while ($p = $products->fetch_assoc()):
    $isFav = isset($_SESSION['favourites'][$p['id']]);
    $pageUrl = "products.php" . ($categoryFilter ? "?category=$categoryFilter" : "?");
    include 'product-card.php';
endwhile; ?>

</div>


</section>

<?php include 'includes/footer.php'; ?>
