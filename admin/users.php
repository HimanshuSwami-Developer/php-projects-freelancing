<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTH CHECK (Admin / Owner)
================================ */
if (
    !isset($_SESSION['user_id']) ||
    !in_array($_SESSION['user_role'], ['admin', 'owner'])
) {
    header("Location: ../login.php");
    exit;
}

$conn = getDB();

/* ===============================
   OWNER UPDATE ROLE / STATUS
================================ */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    $_SESSION['user_role'] === 'owner'
) {
    $emp_id    = intval($_POST['emp_id']);
    $role      = $_POST['role'];
    $is_active = intval($_POST['is_active']);

    if (in_array($role, ['admin', 'user'])) {
        $stmt = $conn->prepare("
            UPDATE users
            SET role = ?, is_active = ?
            WHERE emp_id = ?
        ");
        $stmt->bind_param("sii", $role, $is_active, $emp_id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* ===============================
   FETCH ALL USERS
================================ */
$stmt = $conn->prepare("
    SELECT emp_id, name, email, contact, address,
           role, is_active,
           act_doc, act_expirey,
           sia_doc, sia_expirey,
           share_code_doc, share_code_expirey
    FROM users where role != 'owner'
    ORDER BY emp_id ASC
");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$docs = [
    'act_doc'        => 'ACT Certificate',
    'sia_doc'        => 'SIA Certificate',
    'share_code_doc' => 'Share Code'
];

$expiryMap = [
    'act_doc'        => 'act_expirey',
    'sia_doc'        => 'sia_expirey',
    'share_code_doc' => 'share_code_expirey'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Users Management</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<?php include 'navbar.php'; ?>

<div class="p-6 space-y-6">

<h2 class="text-2xl font-bold">
    <?= $_SESSION['user_role'] === 'owner' ? 'Owner Dashboard - All Users' : 'Admin Dashboard - Users' ?>
</h2>

<!-- SEARCH -->
<input
    type="text"
    id="searchInput"
    placeholder="Search by ID, Name or Email"
    class="w-full md:w-1/2 border p-2 rounded"
    onkeyup="filterUsers()"
>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">

  <!-- ACT -->
  <div class="border p-3 rounded bg-gray-50">
    <h3 class="font-semibold mb-2">ACT Certificate Expiry</h3>
    <input type="date" id="actFrom" class="border p-2 rounded w-full mb-2">
    <input type="date" id="actTo" class="border p-2 rounded w-full mb-2">
    <select id="actSort" class="border p-2 rounded w-full mb-2">
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
    <button onclick="filterExpiry('act')" class="bg-blue-600 text-white w-full py-1 rounded">
      Apply
    </button>
  </div>

  <!-- SIA -->
  <div class="border p-3 rounded bg-gray-50">
    <h3 class="font-semibold mb-2">SIA Certificate Expiry</h3>
    <input type="date" id="siaFrom" class="border p-2 rounded w-full mb-2">
    <input type="date" id="siaTo" class="border p-2 rounded w-full mb-2">
    <select id="siaSort" class="border p-2 rounded w-full mb-2">
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
    <button onclick="filterExpiry('sia')" class="bg-blue-600 text-white w-full py-1 rounded">
      Apply
    </button>
  </div>

  <!-- SHARE CODE -->
  <div class="border p-3 rounded bg-gray-50">
    <h3 class="font-semibold mb-2">Share Code Expiry</h3>
    <input type="date" id="shareFrom" class="border p-2 rounded w-full mb-2">
    <input type="date" id="shareTo" class="border p-2 rounded w-full mb-2">
    <select id="shareSort" class="border p-2 rounded w-full mb-2">
      <option value="asc">Ascending</option>
      <option value="desc">Descending</option>
    </select>
    <button onclick="filterExpiry('share')" class="bg-blue-600 text-white w-full py-1 rounded">
      Apply
    </button>
  </div>

</div>

<button onclick="resetAllFilters()"
  class="mb-4 bg-gray-600 text-white px-4 py-2 rounded">
  Reset All Filters
</button>


<div class="bg-white rounded shadow overflow-x-auto">
<table id="usersTable" class="w-full border mt-4">
<thead class="bg-gray-200">
<tr>
<th class="p-3 border">ID</th>
<th class="p-3 border">Name</th>
<th class="p-3 border">Email</th>
<th class="p-3 border">Contact</th>
<th class="p-3 border">Address</th>

<?php if ($_SESSION['user_role'] === 'owner'): ?>
<th class="p-3 border">Role</th>
<th class="p-3 border">Status</th>
<th class="p-3 border">Action</th>
<?php endif; ?>

<?php foreach ($docs as $label): ?>
<th class="p-3 border"><?= $label ?></th>
<th class="p-3 border">Expiry</th>
<?php endforeach; ?>
</tr>
</thead>

<tbody>
<?php foreach ($users as $user): ?>
<tr class="text-center border-t">

<td class="p-2 border"><?= $user['emp_id'] ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['name']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['email']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['contact']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['address']) ?></td>

<?php if ($_SESSION['user_role'] === 'owner'): ?>
<form method="POST">
<td class="p-2 border">
    <input type="hidden" name="emp_id" value="<?= $user['emp_id'] ?>">
    <select name="role" class="border p-1 rounded">
        <option value="user" <?= $user['role']==='user'?'selected':'' ?>>User</option>
        <option value="admin" <?= $user['role']==='admin'?'selected':'' ?>>Admin</option>
    </select>
</td>

<td class="p-2 border">
    <select name="is_active" class="border p-1 rounded">
        <option value="1" <?= $user['is_active']?'selected':'' ?>>Active</option>
        <option value="0" <?= !$user['is_active']?'selected':'' ?>>Inactive</option>
    </select>
</td>

<td class="p-2 border">
    <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
        Save
    </button>
</td>
</form>
<?php endif; ?>

<?php foreach ($docs as $key => $label): ?>
<td class="p-2 border">
<?php
$path = __DIR__ . "../../user/" . $user[$key];
if (!empty($user[$key]) && file_exists($path)): ?>
<img src="../../user/<?= htmlspecialchars($user[$key]) ?>" class="mx-auto max-h-16 rounded border">
<?php else: ?>
<span class="text-red-500 text-sm">Not uploaded</span>
<?php endif; ?>
</td>

<?php if ($key === 'act_doc'): ?>
<td class="p-2 border expiry-act"
    data-date="<?= $user['act_expirey'] ?? '' ?>">
    <?= !empty($user['act_expirey']) ? $user['act_expirey'] : '-' ?>
</td>
<?php elseif ($key === 'sia_doc'): ?>
<td class="p-2 border expiry-sia"
    data-date="<?= $user['sia_expirey'] ?? '' ?>">
    <?= !empty($user['sia_expirey']) ? $user['sia_expirey'] : '-' ?>
</td>
<?php elseif ($key === 'share_code_doc'): ?>
<td  class="p-2 border expiry-share" 
    data-date="<?= $user['share_code_expirey'] ?? '' ?>">
    <?= !empty($user['share_code_expirey']) ? $user['share_code_expirey'] : '-' ?>
</td>
<?php endif; ?>

<?php endforeach; ?>

</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>

<script>
function filterExpiry(type) {

    // 🔄 Always reset table first
    resetTable();

    // 🔄 Reset other filters (ONLY ONE ACTIVE)
    ['act', 'sia', 'share'].forEach(t => {
        if (t !== type) {
            document.getElementById(t + 'From').value = '';
            document.getElementById(t + 'To').value = '';
            document.getElementById(t + 'Sort').value = 'asc';
        }
    });

    const from = document.getElementById(type + 'From').value;
    const to   = document.getElementById(type + 'To').value;
    const sort = document.getElementById(type + 'Sort').value;

    const tbody = document.querySelector('#usersTable tbody');
    const rows  = Array.from(tbody.querySelectorAll('tr'));

    let filtered = rows.filter(row => {
        const cell = row.querySelector('.expiry-' + type);
        if (!cell || !cell.dataset.date) return false;

        const d = new Date(cell.dataset.date);

        if (from && d < new Date(from)) return false;
        if (to && d > new Date(to)) return false;

        return true;
    });

    filtered.sort((a, b) => {
        const da = new Date(a.querySelector('.expiry-' + type).dataset.date);
        const db = new Date(b.querySelector('.expiry-' + type).dataset.date);
        return sort === 'asc' ? da - db : db - da;
    });

    tbody.innerHTML = '';
    filtered.forEach(r => tbody.appendChild(r));
}

// 🔄 Restore original table
function resetTable() {
    const tbody = document.querySelector('#usersTable tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    rows.sort((a, b) =>
        a.cells[0].innerText.localeCompare(b.cells[0].innerText)
    );
    tbody.innerHTML = '';
    rows.forEach(r => tbody.appendChild(r));
}

function resetAllFilters() {
    window.location.reload();
}
</script>

<!-- SEARCH SCRIPT -->
<script>
function filterUsers() {
    const val = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#usersTable tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(val) ? '' : 'none';
    });
}
</script>

</body>
</html>
