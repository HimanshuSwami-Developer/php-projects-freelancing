<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTH CHECK
================================ */
if (
    !isset($_SESSION['user_id']) ||
    !in_array($_SESSION['user_role'], ['admin', 'owner'])
) {
    header("Location: ../login.php");
    exit;
}

$conn = getDB();

function img($path){
    if(!$path) return '<span class="text-gray-400">—</span>';

    $fs  = __DIR__ . "/../" . $path;
    $url = "../" . $path;

    return file_exists($fs)
        ? "<img src='$url'
                 class='mx-auto h-12 rounded border
                        hover:scale-110 transition cursor-pointer'
                 onclick=\"openImageModal('$url')\">"
        : '<span class="text-gray-400">—</span>';
}

/* ===============================
   UPDATE ROLE / STATUS (OWNER)
================================ */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['update_role']) &&
    $_SESSION['user_role'] === 'owner'
) {
    $id        = (int)$_POST['user_id'];
    $role      = $_POST['role'];
    $is_active = (int)$_POST['is_active'];

    if (in_array($role, ['user','admin'])) {
        $stmt = $conn->prepare("
            UPDATE users SET role=?, is_active=? WHERE id=?
        ");
        $stmt->bind_param("sii", $role, $is_active, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* ===============================
   UPDATE PASSWORD (ADMIN / OWNER)
================================ */
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['update_password']) &&
    in_array($_SESSION['user_role'], ['admin','owner'])
) {
    $id  = (int)$_POST['user_id'];
    $pwd = $_POST['password']; // plain as requested

    $stmt = $conn->prepare("
        UPDATE users SET password=? WHERE id=?
    ");
    $stmt->bind_param("si", $pwd, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* ===============================
   FETCH USERS + DOCUMENTS
================================ */
$stmt = $conn->prepare("
SELECT 
    u.id, u.name, u.email, u.contact, u.address, u.role, u.is_active,

    ac.act_blue_doc, ac.act_blue_expiry,
    ac.act_orange_doc, ac.act_orange_expiry,

    s.sia_licence_doc, s.sia_licence_number, s.sia_licence_expiry,

    sc.share_code_doc, sc.share_code_number, sc.share_code_expiry,
    sc.first_aid_doc, sc.first_aid_expiry

FROM users u
LEFT JOIN act_certificate ac ON ac.user_id = u.id
LEFT JOIN sia_licence s ON s.user_id = u.id
LEFT JOIN sharecode_first_aid sc ON sc.user_id = u.id
WHERE u.role != 'owner'
ORDER BY u.id ASC
");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

/* ===============================
   EXPIRY COLOR
================================ */
function expiryClass($date, $warn = 30) {
    if (!$date) return '';
    $today = new DateTime();
    $exp   = new DateTime($date);
    $diff  = (int)$today->diff($exp)->format('%r%a');
    if ($diff < 0) return 'bg-red-200';
    if ($diff <= $warn) return 'bg-red-100';
    return '';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Users Management</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">
    
<?php include 'navbar.php'; ?>
<div class="p-6">
<!-- HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
    <h2 class="text-2xl font-bold text-slate-800">
        <?= $_SESSION['user_role']==='owner' ? 'Owner Dashboard' : 'Admin Dashboard' ?>
    </h2>

    <span class="mt-2 md:mt-0 inline-flex items-center px-3 py-1 rounded-full text-sm
        <?= $_SESSION['user_role']==='owner'
            ? 'bg-purple-100 text-purple-700'
            : 'bg-blue-100 text-blue-700' ?>">
        Role: <?= strtoupper($_SESSION['user_role']) ?>
    </span>
</div>

<!-- SEARCH -->
<div class="relative max-w-md mb-4">
    <input id="searchInput"
           onkeyup="filterUsers()"
           placeholder="Search by name or email"
           class="w-full pl-10 pr-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-200">

    <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
</div>

<!-- TABLE CARD -->
<div class="bg-white shadow-lg rounded-xl overflow-x-auto">
<table id="usersTable" class="min-w-full text-sm text-slate-700">

<thead class="bg-slate-200 sticky top-0 z-10">
<tr>
<th class="p-3 border">ID</th>
<th class="p-3 border">User</th>
<th class="p-3 border">Contact</th>
<th class="p-3 border">Address</th>

<?php if($_SESSION['user_role']==='owner'): ?>
<th class="p-3 border">Role</th>
<th class="p-3 border">Status</th>
<th class="p-3 border">Save</th>
<?php endif; ?>

<th class="p-3 border">ACT Blue</th>
<th class="p-3 border">Expiry</th>
<th class="p-3 border">ACT Orange</th>
<th class="p-3 border">Expiry</th>
<th class="p-3 border">SIA</th>
<th class="p-3 border">Expiry</th>
<th class="p-3 border">Share Code</th>
<th class="p-3 border">Expiry</th>
<th class="p-3 border">First Aid</th>
<th class="p-3 border">Password</th>
</tr>
</thead>

<tbody class="divide-y">
<?php foreach($users as $u): ?>
<tr class="hover:bg-slate-50 transition text-center">

<td class="p-3 border font-semibold"><?= $u['id'] ?></td>

<td class="p-3 border text-left">
    <div class="font-medium"><?= htmlspecialchars($u['name']) ?></div>
    <div class="text-xs text-gray-500"><?= htmlspecialchars($u['email']) ?></div>
</td>

<td class="p-3 border"><?= htmlspecialchars($u['contact']) ?></td>
<td class="p-3 border max-w-xs truncate"><?= htmlspecialchars($u['address']) ?></td>

<?php if($_SESSION['user_role']==='owner'): ?>
<form method="POST">
<td class="p-3 border">
<input type="hidden" name="user_id" value="<?= $u['id'] ?>">
<select name="role" class="border rounded px-2 py-1 text-sm">
<option value="user" <?= $u['role']==='user'?'selected':'' ?>>User</option>
<option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>Admin</option>
</select>
</td>

<td class="p-3 border">
<select name="is_active"
        class="border rounded px-2 py-1 text-sm
        <?= $u['is_active']?'bg-green-50':'bg-red-50' ?>">
<option value="1" <?= $u['is_active']?'selected':'' ?>>Active</option>
<option value="0" <?= !$u['is_active']?'selected':'' ?>>Inactive</option>
</select>
</td>

<td class="p-3 border">
<button name="update_role"
        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
Save
</button>
</td>
</form>
<?php endif; ?>

<td class="p-3 border"><?= img($u['act_blue_doc']) ?></td>
<td class="p-3 border <?= expiryClass($u['act_blue_expiry']) ?>">
    <?= $u['act_blue_expiry'] ?: '—' ?>
</td>

<td class="p-3 border"><?= img($u['act_orange_doc']) ?></td>
<td class="p-3 border <?= expiryClass($u['act_orange_expiry']) ?>">
    <?= $u['act_orange_expiry'] ?: '—' ?>
</td>

<td class="p-3 border">
    <?= img($u['sia_licence_doc']) ?>
    <div class="text-xs mt-1"><?= $u['sia_licence_number'] ?></div>
</td>
<td class="p-3 border <?= expiryClass($u['sia_licence_expiry']) ?>">
    <?= $u['sia_licence_expiry'] ?: '—' ?>
</td>

<td class="p-3 border">
    <?= img($u['share_code_doc']) ?>
    <div class="text-xs mt-1"><?= $u['share_code_number'] ?></div>
</td>
<td class="p-3 border <?= expiryClass($u['share_code_expiry']) ?>">
    <?= $u['share_code_expiry'] ?: '—' ?>
</td>

<td class="p-3 border"><?= img($u['first_aid_doc']) ?></td>

<td class="p-3 border">
<form method="POST" class="flex items-center gap-2 justify-center">
<input type="hidden" name="user_id" value="<?= $u['id'] ?>">
<input type="password"
       name="password"
       placeholder="New password"
       class="border rounded px-2 py-1 text-xs w-28" required>
<button name="update_password"
        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
Set
</button>
</form>
</td>

</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

</div>
<script>
function filterUsers(){
    let v=document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#usersTable tbody tr').forEach(r=>{
        r.style.display=r.innerText.toLowerCase().includes(v)?'':'none';
    });
}
</script>

</body>
</html>
