<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTH CHECK (Admin Only)
================================ */
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner') {
    die("Access denied. Only admin can view this page.");
}

$conn = getDB();

/* ===============================
   FETCH ALL USERS
================================ */
$stmt = $conn->prepare("
   SELECT emp_id, name, email, contact, address, is_active,
       act_doc, act_expirey,
       sia_doc, sia_expirey,
       share_code_doc, share_code_expirey
FROM users
WHERE role = 'user'
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

/* ===============================
   AJAX: UPDATE USER STATUS
================================ */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['ajax']) &&
    $_POST['ajax'] === 'update_status'
) {
    if (!in_array($_SESSION['user_role'], ['admin', 'owner'])) {
        http_response_code(403);
        echo json_encode(['success' => false]);
        exit;
    }

    $empId    = intval($_POST['emp_id'] ?? 0);
    $isActive = intval($_POST['is_active'] ?? -1);

    if ($empId <= 0 || !in_array($isActive, [0, 1])) {
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET is_active = ? WHERE emp_id = ?");
    $stmt->bind_param("ii", $isActive, $empId);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
    exit; // 🔴 VERY IMPORTANT
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Users</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <?php include 'navbar.php'; ?>

<div class="p-6 space-y-6">


<!-- SEARCH FILTER -->
<div class="flex items-center gap-4 mb-4">
    <input type="text" id="searchInput" placeholder="Search by Employee ID, Name or Email"
        class="w-full md:w-1/2 border p-2 rounded"
        onkeyup="filterUsers()">

    <button onclick="downloadZip()"
        class="hidden bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Download All Documents
    </button>
</div>

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

<!-- Loader -->
<div id="loader" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mx-auto mb-3"></div>
        <p class="text-sm font-semibold">Preparing ZIP, please wait...</p>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
<table id="usersTable" class="w-full border">
<thead class="bg-gray-200">
<tr>
<th class="p-3 border">Employee ID</th>
<th class="p-3 border">Name</th>
<th class="p-3 border">Email</th>
<th class="p-3 border">Contact</th>
<th class="p-3 border">Address</th>
<th class="p-3 border">Status</th>
<?php foreach ($docs as $key => $label): ?>
<th class="p-3 border"><?= $label ?> (Doc)</th>
<th class="p-3 border"><?= $label ?> Expiry</th>
<?php endforeach; ?>
</tr>
</thead>

<tbody>
<?php foreach($users as $user): ?>
<tr class="text-center border-t">
<td class="p-2 border"><?= $user['emp_id'] ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['name']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['email']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['contact']) ?></td>
<td class="p-2 border"><?= htmlspecialchars($user['address']) ?></td>
<td class="p-2 border">
  <label class="inline-flex items-center cursor-pointer">
    <input type="checkbox"
           class="sr-only peer"
           <?= $user['is_active'] ? 'checked' : '' ?>
           onchange="updateStatus(<?= $user['emp_id'] ?>, this.checked)">
    <div class="relative w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-green-600
                after:content-[''] after:absolute after:top-0.5 after:left-[2px]
                after:bg-white after:border after:rounded-full after:h-5 after:w-5
                after:transition-all peer-checked:after:translate-x-full">
    </div>
  </label>

  <div class="text-xs mt-1 font-semibold
       <?= $user['is_active'] ? 'text-green-600' : 'text-red-600' ?>">
       <?= $user['is_active'] ? 'Active' : 'Inactive' ?>
  </div>
</td>

<?php foreach($docs as $key => $label): ?>
<td class="p-2 border">
<?php 
$docPath = __DIR__ . '../../user/' . $user[$key];
if(!empty("../../user/$user[$key]") && file_exists($docPath)): ?>
<img src="<?= htmlspecialchars("../../user/$user[$key]") ?>" class="mx-auto max-h-16 border rounded">
<?php else: ?>
<span class="text-red-600 text-sm">Not uploaded</span>
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


<!-- JS SEARCH FILTER -->
<script>
  
function updateStatus(empId, checked) {
    const isActive = checked ? 1 : 0;

    fetch(window.location.href, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `ajax=update_status&emp_id=${empId}&is_active=${isActive}`
    })
    .then(res => res.json())
    .then(data => {
       if (data.success) {
            // ✅ Reload page after successful update
            window.location.reload();
        } else {
            alert('Failed to update status');
        }
    })
    .catch(() => alert('Server error'));
}

function filterUsers() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const table = document.getElementById('usersTable');
    const trs = table.getElementsByTagName('tr');

    for (let i = 1; i < trs.length; i++) { // skip header
        const tds = trs[i].getElementsByTagName('td');
        let show = false;

        // Check Employee ID, Name, Email
        for (let j = 0; j < 3; j++) {
            if (tds[j].textContent.toLowerCase().includes(input)) {
                show = true;
                break;
            }
        }

        trs[i].style.display = show ? '' : 'none';
    }
}

function downloadZip() {
    const loader = document.getElementById('loader');
    loader.classList.remove('hidden');

    // Create hidden iframe for download
    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = 'download_zip.php';

    document.body.appendChild(iframe);

    // Hide loader after some time (safe fallback)
    setTimeout(() => {
        loader.classList.add('hidden');
        document.body.removeChild(iframe);
    }, 8000);
}
</script>

</body>
</html>
