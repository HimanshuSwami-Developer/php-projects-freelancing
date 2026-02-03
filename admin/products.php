<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

/* ================= DELETE PRODUCT ================= */
if (isset($_GET['delete'])) {
    $pid = (int)$_GET['delete'];

    $imgs = $db->query("SELECT image FROM product_images WHERE product_id = $pid");
    while ($img = $imgs->fetch_assoc()) {
        $file = "../assets/images/products/" . $img['image'];
        if (file_exists($file)) unlink($file);
    }

    $db->query("DELETE FROM product_images WHERE product_id = $pid");
    $db->query("DELETE FROM products WHERE id = $pid");

    header("Location: products.php");
    exit;
}

/* ================= DELETE ALL IMAGES ================= */
if (isset($_GET['delete_images'])) {
    $pid = (int)$_GET['delete_images'];

    $imgs = $db->query("SELECT image FROM product_images WHERE product_id = $pid");
    while ($img = $imgs->fetch_assoc()) {
        $file = "../assets/images/products/" . $img['image'];
        if (file_exists($file)) unlink($file);
    }

    $db->query("DELETE FROM product_images WHERE product_id = $pid");
    header("Location: products.php?edit=$pid");
    exit;
}

/* ================= DELETE SINGLE IMAGE ================= */
if (isset($_GET['delete_image'])) {
    $imgId = (int)$_GET['delete_image'];

    $img = $db->query("SELECT image, product_id FROM product_images WHERE id = $imgId")->fetch_assoc();
    if ($img) {
        $file = "../assets/images/products/" . $img['image'];
        if (file_exists($file)) unlink($file);

        $db->query("DELETE FROM product_images WHERE id = $imgId");
        header("Location: products.php?gallery={$img['product_id']}");
        exit;
    }
}

/* ================= ADD MORE IMAGES ================= */
if (isset($_POST['add_images'])) {

    $pid = (int)$_POST['product_id'];
    $product = $db->query("SELECT title FROM products WHERE id=$pid")->fetch_assoc();

    if ($product && !empty($_FILES['images']['name'][0])) {

        $folder = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($product['title']));
        $dir = "../assets/images/products/$folder/";

        if (!is_dir($dir)) mkdir($dir, 0777, true);

        foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
            $imgName = time() . '_' . $_FILES['images']['name'][$k];
            move_uploaded_file($tmp, $dir . $imgName);

            $path = "$folder/$imgName";
            $stmt = $db->prepare("INSERT INTO product_images (product_id, image) VALUES (?, ?)");
            $stmt->bind_param("is", $pid, $path);
            $stmt->execute();
        }
    }

    header("Location: products.php?gallery=$pid");
    exit;
}


/* ================= ADD / UPDATE PRODUCT ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id    = (int)($_POST['id'] ?? 0);
    $title = trim($_POST['title']);
    $price = $_POST['price'];
    $sale  = $_POST['sale_price'] !== '' ? $_POST['sale_price'] : null;
    $rate  = $_POST['rating'];
    $stock = (int)$_POST['stock'];
    $desc  = $_POST['description'];
    $cat   = $_POST['category_id'];

    $status = $stock > 0 ? 'available' : 'out_of_stock';

    if ($id > 0) {
        $stmt = $db->prepare("
            UPDATE products 
            SET title=?, price=?, sale_price=?, rating=?, stock=?, description=?, category_id=?, status=?
            WHERE id=?
        ");
        $stmt->bind_param(
            "sdddisssi",
            $title, $price, $sale, $rate, $stock, $desc, $cat, $status, $id
        );
        $stmt->execute();
        $product_id = $id;
    } else {
        $stmt = $db->prepare("
            INSERT INTO products 
            (title, price, sale_price, rating, stock, description, category_id, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sdddisss",
            $title, $price, $sale, $rate, $stock, $desc, $cat, $status
        );
        $stmt->execute();
        $product_id = $stmt->insert_id;
    }

    /* ================= IMAGE UPLOAD / REPLACE ================= */
    if (!empty($_FILES['images']['name'][0])) {

        if ($id > 0) {
            $old = $db->query("SELECT image FROM product_images WHERE product_id = $product_id");
            while ($o = $old->fetch_assoc()) {
                $file = "../assets/images/products/" . $o['image'];
                if (file_exists($file)) unlink($file);
            }
            $db->query("DELETE FROM product_images WHERE product_id = $product_id");
        }

        $folder = preg_replace('/[^a-zA-Z0-9]/', '-', strtolower($title));
        $dir = "../assets/images/products/$folder/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
            $imgName = time() . '_' . $_FILES['images']['name'][$k];
            move_uploaded_file($tmp, $dir . $imgName);

            $path = "$folder/$imgName";
            $stmt = $db->prepare("INSERT INTO product_images (product_id, image) VALUES (?, ?)");
            $stmt->bind_param("is", $product_id, $path);
            $stmt->execute();
        }
    }

    header("Location: products.php");
    exit;
}

/* ================= EDIT PRODUCT ================= */
$editProduct = null;
if (isset($_GET['edit'])) {
    $pid = (int)$_GET['edit'];
    $editProduct = $db->query("SELECT * FROM products WHERE id=$pid")->fetch_assoc();
}

/* ================= DATA ================= */
$products = $db->query("
    SELECT p.*, c.name AS category
    FROM products p
    LEFT JOIN categories c ON c.id = p.category_id
    ORDER BY p.id DESC
");

$categories = $db->query("SELECT * FROM categories WHERE status=1");
?>

<h1 class="text-3xl font-bold mb-8">Product Management</h1>

<!-- ================= ADD / EDIT FORM ================= -->
<div class="bg-white border rounded-xl p-6 mb-12 max-w-3xl">

<h2 class="text-xl font-semibold mb-4">
    <?= $editProduct ? 'Edit Product' : 'Add Product' ?>
</h2>

<form method="post" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">

<?php if ($editProduct): ?>
<input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
<?php endif; ?>

<input name="title" required placeholder="Product Title"
       value="<?= htmlspecialchars($editProduct['title'] ?? '') ?>"
       class="border px-4 py-3 rounded col-span-2">

<input name="price" required placeholder="Price"
       value="<?= $editProduct['price'] ?? '' ?>"
       class="border px-4 py-3 rounded">

<input name="sale_price" placeholder="Sale Price"
       value="<?= $editProduct['sale_price'] ?? '' ?>"
       class="border px-4 py-3 rounded">

<input name="rating" type="number" step="0.1" min="0" max="5"
       placeholder="Rating"
       value="<?= $editProduct['rating'] ?? 0 ?>"
       class="border px-4 py-3 rounded">

<input name="stock" type="number" min="0" required
       placeholder="Stock"
       value="<?= $editProduct['stock'] ?? 0 ?>"
       class="border px-4 py-3 rounded">

<select name="category_id" class="border px-4 py-3 rounded">
<?php while ($c = $categories->fetch_assoc()): ?>
<option value="<?= $c['id'] ?>"
    <?= isset($editProduct) && $editProduct['category_id']==$c['id']?'selected':'' ?>>
    <?= $c['name'] ?>
</option>
<?php endwhile; ?>
</select>

<textarea name="description" required
          placeholder="Description"
          class="border px-4 py-3 rounded col-span-2"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>

<input type="file" name="images[]" multiple class="border px-4 py-3 rounded col-span-2">

<button class="bg-black text-white px-10 py-3 rounded col-span-2 hover:bg-gray-800">
    <?= $editProduct ? 'Update Product' : 'Add Product' ?>
</button>

<?php if ($editProduct): ?>
<a href="products.php?delete_images=<?= $editProduct['id'] ?>"
   class="text-red-600 underline col-span-2 text-sm">
    Remove All Images
</a>
<?php endif; ?>

</form>
</div>

<!-- ================= PRODUCT LIST ================= -->
<div class="overflow-x-auto bg-white border rounded-xl">
<table class="w-full text-left text-sm">

<thead class="bg-gray-50">
<tr>
<th class="p-3 border">ID</th>
<th class="p-3 border">Title</th>
<th class="p-3 border">Category</th>
<th class="p-3 border">Price</th>
<th class="p-3 border">Sale</th>
<th class="p-3 border">Rating</th>
<th class="p-3 border">Stock</th>
<th class="p-3 border">Image</th>
<th class="p-3 border">Action</th>
</tr>
</thead>

<tbody>
<?php while ($p = $products->fetch_assoc()): ?>
<tr class="border-t">

<td class="p-3"><?= $p['id'] ?></td>
<td class="p-3 font-medium"><?= htmlspecialchars($p['title']) ?></td>
<td class="p-3"><?= $p['category'] ?></td>
<td class="p-3">₹<?= $p['price'] ?></td>
<td class="p-3"><?= $p['sale_price'] ? '₹'.$p['sale_price'] : '-' ?></td>
<td class="p-3"><?= $p['rating'] ?></td>

<td class="p-3">
<?php if ($p['stock'] > 5): ?>
<span class="text-green-600 font-semibold"><?= $p['stock'] ?> In Stock</span>
<?php elseif ($p['stock'] > 0): ?>
<span class="text-yellow-600 font-semibold"><?= $p['stock'] ?> Low</span>
<?php else: ?>
<span class="text-red-600 font-semibold">Out</span>
<?php endif; ?>
</td>

<td class="p-3">
<?php
$img = $db->query("SELECT image FROM product_images WHERE product_id={$p['id']} LIMIT 1")->fetch_assoc();
if ($img):
?>
<img src="../assets/images/products/<?= $img['image'] ?>"
     class="w-14 h-14 object-cover rounded">
<?php endif; ?>
</td>

<td class="p-3 flex gap-3 flex-wrap">
    <a href="products.php?edit=<?= $p['id'] ?>" class="text-blue-600">Edit</a>

    <a href="products.php?gallery=<?= $p['id'] ?>"
       class="text-purple-600 font-semibold">
       Gallery
    </a>

    <a href="products.php?delete=<?= $p['id'] ?>"
       onclick="return confirm('Delete product?')"
       class="text-red-600">
       Delete
    </a>
</td>


</tr>
<?php endwhile; ?>
</tbody>

</table>
</div>
<?php if (isset($_GET['gallery'])): 
    $gid = (int)$_GET['gallery'];
    $gallery = $db->query("SELECT * FROM product_images WHERE product_id = $gid");
?>
<hr class="my-12">

<h2 class="text-2xl font-bold mb-6">Product Gallery</h2>

<!-- IMAGE GRID -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">

<?php while ($img = $gallery->fetch_assoc()): ?>
<div class="relative group border rounded-lg overflow-hidden">

    <img src="../assets/images/products/<?= $img['image'] ?>"
         class="w-full h-40 object-cover">

    <!-- DELETE ICON -->
    <a href="products.php?delete_image=<?= $img['id'] ?>"
       onclick="return confirm('Delete this image?')"
       class="absolute top-2 right-2 bg-white text-red-600
              rounded-full w-8 h-8 flex items-center justify-center
              shadow hover:bg-red-600 hover:text-white transition">
        ✕
    </a>

</div>
<?php endwhile; ?>

</div>

<!-- ADD MORE IMAGES -->
<form method="post" enctype="multipart/form-data"
      class="bg-gray-50 border rounded-xl p-6 max-w-xl">

    <input type="hidden" name="product_id" value="<?= $gid ?>">
    <input type="file" name="images[]" multiple required
           class="border w-full px-4 py-3 mb-4">

    <button name="add_images"
            class="bg-black text-white px-8 py-3 rounded hover:bg-gray-800">
        Add More Images
    </button>

    <a href="products.php" class="ml-4 underline text-sm">
        Back to Products
    </a>
</form>

<?php endif; ?>


<?php include 'includes/footer.php'; ?>
