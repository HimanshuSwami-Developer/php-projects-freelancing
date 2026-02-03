<?php
include 'includes/header.php';
include 'config/db.php';

if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = [];
}

// Add to favourites
if (isset($_GET['add'])) {
    $pid = (int)$_GET['add'];
    $_SESSION['favourites'][$pid] = $pid;
    header("Location: favourites.php");
    exit;
}

// Remove from favourites
if (isset($_GET['remove'])) {
    unset($_SESSION['favourites'][$_GET['remove']]);
}

$db = getDB();
?>

<section class="max-w-7xl mx-auto px-6 py-20">

    <h1 class="text-4xl font-bold mb-12 text-center">
        Your Favourites
    </h1>

    <?php if (!empty($_SESSION['favourites'])): ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">

        <?php foreach ($_SESSION['favourites'] as $pid): 
            $product = $db->query("SELECT * FROM products WHERE id = $pid")->fetch_assoc();
        ?>

        <div class="border border-gray-200 rounded-lg overflow-hidden
                    hover:shadow-lg transition">

            <!-- Image -->
            <div class="h-56 bg-gray-100 flex items-center justify-center">
                <span class="text-gray-400 text-sm">Product Image</span>
            </div>

            <!-- Details -->
            <div class="p-5">
                <h3 class="font-semibold text-lg">
                    <?= htmlspecialchars($product['title']) ?>
                </h3>

                <p class="text-gray-500 text-sm mt-1">
                    ₹<?= number_format($product['price'], 2) ?>
                </p>

                <div class="flex gap-3 mt-5">
                    <a href="product-details.php?id=<?= $product['id'] ?>"
                       class="flex-1 text-center border border-black py-2 text-sm
                              hover:bg-black hover:text-white transition">
                        View
                    </a>

                    <a href="favourites.php?remove=<?= $product['id'] ?>"
                       class="flex-1 text-center border border-gray-300 py-2 text-sm
                              hover:bg-gray-100 transition">
                        Remove
                    </a>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

    <?php else: ?>
        <p class="text-center text-gray-500">
            You have no favourite products yet.
        </p>
    <?php endif; ?>

</section>

<?php include 'includes/footer.php'; ?>
