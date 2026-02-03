<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $desc  = $_POST['description'];
    $cat   = $_POST['category_id'];

    $stmt = $db->prepare("
        INSERT INTO products (title, price, description, category_id, status)
        VALUES (?, ?, ?, ?, 'available')
    ");
    $stmt->bind_param("sdsi", $title, $price, $desc, $cat);
    $stmt->execute();

    echo "<p class='text-green-600 mb-6'>Product Added Successfully</p>";
}

$categories = $db->query("SELECT * FROM categories WHERE status = 1");
?>

<h1 class="text-3xl font-bold mb-8">Add Product</h1>

<form method="post" class="max-w-xl space-y-6">
    <input name="title" placeholder="Product Title" class="border w-full px-4 py-3">

    <input name="price" placeholder="Price" class="border w-full px-4 py-3">

    <textarea name="description" placeholder="Description"
              class="border w-full px-4 py-3"></textarea>

    <select name="category_id" class="border w-full px-4 py-3">
        <?php while ($c = $categories->fetch_assoc()): ?>
            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
        <?php endwhile; ?>
    </select>

    <button class="bg-black text-white px-8 py-3">Save</button>
</form>

<?php include 'includes/footer.php'; ?>
