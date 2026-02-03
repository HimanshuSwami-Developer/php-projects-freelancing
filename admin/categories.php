<?php
include 'includes/header.php';
include '../config/db.php';

$db = getDB();

/* ================= ADD / UPDATE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name   = trim($_POST['name']);
    $status = isset($_POST['status']) ? 1 : 0;
    $id     = (int)($_POST['id'] ?? 0);

    if ($name !== '') {

        if ($id > 0) {
            // UPDATE
            $stmt = $db->prepare(
                "UPDATE categories SET name = ?, status = ? WHERE id = ?"
            );
            $stmt->bind_param("sii", $name, $status, $id);
            $stmt->execute();
        } else {
            // ADD
            $stmt = $db->prepare(
                "INSERT INTO categories (name, status) VALUES (?, ?)"
            );
            $stmt->bind_param("si", $name, $status);
            $stmt->execute();
        }
    }

    header("Location: categories.php");
    exit;
}

/* ================= DELETE ================= */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $db->query("DELETE FROM categories WHERE id = $id");
    header("Location: categories.php");
    exit;
}

/* ================= EDIT DATA ================= */
$editCategory = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $editCategory = $db->query(
        "SELECT * FROM categories WHERE id = $id"
    )->fetch_assoc();
}

/* ================= FETCH ALL ================= */
$categories = $db->query(
    "SELECT * FROM categories ORDER BY id DESC"
);
?>

<h1 class="text-3xl font-bold mb-8">Category Management</h1>

<!-- ================= ADD / EDIT FORM ================= -->
<div class="bg-white border border-gray-200 rounded-xl p-6 mb-10 max-w-xl">

    <h2 class="text-xl font-semibold mb-4">
        <?= $editCategory ? 'Edit Category' : 'Add Category' ?>
    </h2>

    <form method="post" class="space-y-4">

        <?php if ($editCategory): ?>
            <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
        <?php endif; ?>

        <input type="text" name="name" required
               placeholder="Category Name"
               value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>"
               class="border px-4 py-3 rounded w-full">

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="status"
                   <?= !isset($editCategory) || $editCategory['status'] ? 'checked' : '' ?>>
            Active
        </label>

        <div class="flex gap-4">
            <button class="bg-black text-white px-8 py-3 rounded hover:bg-gray-800">
                <?= $editCategory ? 'Update' : 'Add' ?>
            </button>

            <?php if ($editCategory): ?>
                <a href="categories.php"
                   class="border px-8 py-3 rounded hover:bg-gray-100">
                    Cancel
                </a>
            <?php endif; ?>
        </div>

    </form>
</div>

<!-- ================= CATEGORY LIST ================= -->
<div class="overflow-x-auto bg-white border border-gray-200 rounded-xl">
<table class="w-full text-left">

    <thead class="bg-gray-50">
        <tr>
            <th class="p-4 border">ID</th>
            <th class="p-4 border">Name</th>
            <th class="p-4 border">Status</th>
            <th class="p-4 border">Action</th>
        </tr>
    </thead>

    <tbody>
    <?php while ($c = $categories->fetch_assoc()): ?>
        <tr class="border-t">
            <td class="p-4"><?= $c['id'] ?></td>

            <td class="p-4 font-medium">
                <?= htmlspecialchars($c['name']) ?>
            </td>

            <td class="p-4">
                <?= $c['status']
                    ? '<span class="text-green-600 font-medium">Active</span>'
                    : '<span class="text-red-600 font-medium">Inactive</span>' ?>
            </td>

            <td class="p-4 flex gap-4">
                <a href="categories.php?edit=<?= $c['id'] ?>"
                   class="text-blue-600 hover:underline">
                    Edit
                </a>

                <a href="categories.php?delete=<?= $c['id'] ?>"
                   onclick="return confirm('Delete this category?')"
                   class="text-red-600 hover:underline">
                    Delete
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>

</table>
</div>

<?php include 'includes/footer.php'; ?>
