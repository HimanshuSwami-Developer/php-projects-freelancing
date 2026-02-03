<?php
include 'includes/header.php';
include 'config/db.php';

$db = getDB();

/* ================= SESSION FAVOURITES ================= */
if (!isset($_SESSION['favourites'])) {
    $_SESSION['favourites'] = [];
}
?>

<!-- ================= HERO / BANNER ================= -->
<section class="max-w-7xl mx-auto px-6 pt-28 pb-36 text-center">
    <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight">
        Banke Bihari
        <span class="block font-light mt-3">Premium Dress Collection</span>
    </h1>

    <p class="mt-6 text-gray-500 max-w-2xl mx-auto leading-relaxed">
        Timeless black & white elegance for Shyam Baba shringar,
        festivals and daily seva.
    </p>

    <a href="products.php"
       class="inline-block mt-10 border border-black px-12 py-4 text-sm font-semibold
              hover:bg-black hover:text-white transition">
        Explore Collection
    </a>
</section>

<!-- ================= FEATURED PRODUCTS ================= -->
<section class="max-w-7xl mx-auto px-6 pb-28">
    <h2 class="text-3xl font-bold text-center mb-14">
        Featured Products
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10">
        <?php
        $products = $db->query("SELECT * FROM products LIMIT 4");
        while ($p = $products->fetch_assoc()):
            $isFav = isset($_SESSION['favourites'][$p['id']]);
            $pageUrl = "index.php?";
            include 'product-card.php';
        endwhile;
        ?>
    </div>
</section>

<!-- ================= CATEGORIES ================= -->
<section class="bg-gray-50 py-24">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-14">
            Shop by Category
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <?php
            $categories = $db->query("SELECT * FROM categories WHERE status = 1");
            while ($c = $categories->fetch_assoc()):
            ?>
            <a href="products.php?category=<?= $c['id'] ?>"
               class="border border-gray-200 rounded-lg p-10 text-center
                      hover:bg-black hover:text-white transition">
                <h3 class="font-semibold text-lg tracking-wide">
                    <?= htmlspecialchars($c['name']) ?>
                </h3>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section class="max-w-7xl mx-auto px-6 py-28">
    <h2 class="text-3xl font-bold text-center mb-16">
        What Our Devotees Say
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <div class="border border-gray-200 rounded-lg p-8">
            <p class="text-gray-600 leading-relaxed">
                “Beautiful quality dresses. Perfect fitting and divine feel.”
            </p>
            <p class="mt-6 font-semibold">— Ramesh, Vrindavan</p>
        </div>

        <div class="border border-gray-200 rounded-lg p-8">
            <p class="text-gray-600 leading-relaxed">
                “Elegant designs and fast delivery. Highly recommended.”
            </p>
            <p class="mt-6 font-semibold">— Sunita, Jaipur</p>
        </div>

        <div class="border border-gray-200 rounded-lg p-8">
            <p class="text-gray-600 leading-relaxed">
                “Best online store for Shyam Baba dresses.”
            </p>
            <p class="mt-6 font-semibold">— Ankit, Delhi</p>
        </div>
    </div>
</section>

<!-- ================= CLIENT SATISFACTION ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="bg-gray-50 py-28">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-16">
            Client Satisfaction
        </h2>

        <!-- COUNTERS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-20">
            <div>
                <p class="text-5xl font-extrabold counter" data-target="98">0</p>
                <p class="text-gray-500 mt-2">Happy Customers (%)</p>
            </div>

            <div>
                <p class="text-5xl font-extrabold counter" data-target="4.9">0</p>
                <p class="text-gray-500 mt-2">Average Rating</p>
            </div>

            <div>
                <p class="text-5xl font-extrabold counter" data-target="10000">0</p>
                <p class="text-gray-500 mt-2">Orders Delivered</p>
            </div>
        </div>

        <!-- CHART -->
        <div class="bg-white border border-gray-200 rounded-xl p-8">
            <canvas id="satisfactionChart" height="120"></canvas>
        </div>
    </div>
</section>

<script>
$(document).ready(function () {
    $('.counter').each(function () {
        let $this = $(this);
        let target = parseFloat($this.data('target'));
        let count = 0;
        let increment = target / 100;

        let interval = setInterval(function () {
            count += increment;
            if (count >= target) {
                count = target;
                clearInterval(interval);
            }
            $this.text(target % 1 === 0 ? Math.floor(count) : count.toFixed(1));
        }, 20);
    });
});

new Chart(document.getElementById('satisfactionChart'), {
    type: 'bar',
    data: {
        labels: ['Happy Customers', 'Average Rating', 'Orders Delivered'],
        datasets: [{
            data: [98, 4.9, 10000],
            backgroundColor: ['#000000', '#4b5563', '#9ca3af']
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

<?php include 'includes/footer.php'; ?>
