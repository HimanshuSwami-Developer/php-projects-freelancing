<?php
require_once './../session.php';
require_once './../db.php';

$conn = getDB();

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner')) {
    header("Location: ./../login.php");
    exit;
}

$adminId = $_SESSION['user_id'];

/* ===============================
   FETCH EMPLOYEES
================================ */
$employees = [];
$empResult = $conn->query("
    SELECT id, emp_id ,name 
    FROM users
    WHERE role='user'
    ORDER BY name
");
while ($row = $empResult->fetch_assoc()) {
    $employees[] = $row;
}

/* ===============================
   DELETE ATTENDANCE
================================ */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM attendance WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $_SESSION['success'] = "Attendance deleted";
    header("Location: index.php");
    exit;
}

/* ===============================
   ADD / UPDATE ATTENDANCE
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!empty($_POST['attendance_id'])) {
        $stmt = $conn->prepare("
            UPDATE attendance SET
            user_id=?, user_name=?, mode=?,
            shift_start=?, shift_end=?, status=?, updated_by=?
            WHERE id=?
        ");
        $stmt->bind_param(
            "isssssii",
            $_POST['user_id'],
            $_POST['user_name'],
            $_POST['mode'],
            $_POST['shift_start'],
            $_POST['shift_end'],
            $_POST['status'],
            $adminId,
            $_POST['attendance_id']
        );
        $_SESSION['success'] = "Attendance updated";
    } else {
        $stmt = $conn->prepare("
            INSERT INTO attendance
            (user_id, user_name, mode, shift_start, shift_end, status, updated_by)
            VALUES (?,?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "isssssi",
            $_POST['user_id'],
            $_POST['user_name'],
            $_POST['mode'],
            $_POST['shift_start'],
            $_POST['shift_end'],
            $_POST['status'],
            $adminId
        );
        $_SESSION['success'] = "Attendance added";
    }

    $stmt->execute();
    $stmt->close();
    header("Location: index.php");
    exit;
}

/* ===============================
   FILTERS
================================ */
$empFilter = $_GET['user_id'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$where = "WHERE 1=1";
$params = [];
$types = "";

if ($empFilter !== '') {
    $where .= " AND user_id=?";
    $params[] = $empFilter;
    $types .= "i";
}

if ($statusFilter !== '') {
    $where .= " AND status=?";
    $params[] = $statusFilter;
    $types .= "s";
}

if ($from && $to) {
    $where .= " AND DATE(shift_start) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
    $types .= "ss";
}

/* ===============================
   PAGINATION
================================ */
$limit = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;

/* TOTAL COUNT */
$countSql = "SELECT COUNT(*) total FROM attendance $where";
$countStmt = $conn->prepare($countSql);
if ($params)
    $countStmt->bind_param($types, ...$params);
$countStmt->execute();
$total = $countStmt->get_result()->fetch_assoc()['total'];
$countStmt->close();

$totalPages = ceil($total / $limit);

/* ===============================
   FETCH DATA (WITH EMP ID)
================================ */
$sql = "
    SELECT 
        a.*,
        u.emp_id
    FROM attendance a
    LEFT JOIN users u ON u.id = a.user_id
    $where
    ORDER BY a.shift_start DESC
    LIMIT $limit OFFSET $offset
";
$stmt = $conn->prepare($sql);
if ($params)
    $stmt->bind_param($types, ...$params);
$stmt->execute();
$attendance = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <?php include 'navbar.php'; ?>

    <div class="max-w-[80%] mx-auto mt-4">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Attendance Management</h1>
            <div>
                <a onclick="openModal()" class="mr-10 bg-blue-600 text-white px-4 py-2 rounded">
                    + Add Shift
                </a>
                <a href="export_attendance.php?<?= http_build_query($_GET) ?>"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Export Excel
                </a>
            </div>

        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <!-- FILTER BAR -->
        <form method="GET" class="bg-white p-4 rounded shadow mb-4 grid grid-cols-1 md:grid-cols-6 gap-4">

            <select name="user_id" class="border p-2 rounded">
                <option value="">All Employees</option>
                <?php foreach ($employees as $emp): ?>
                    <option value="<?= $emp['id'] ?>" <?= $empFilter == $emp['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="status" class="border p-2 rounded">
                <option value="">All Status</option>
                <option value="present" <?= $statusFilter == 'present' ? 'selected' : '' ?>>Present</option>
                <option value="absent" <?= $statusFilter == 'absent' ? 'selected' : '' ?>>Absent</option>
            </select>

            <input type="date" name="from" value="<?= $from ?>" class="border p-2 rounded">
            <input type="date" name="to" value="<?= $to ?>" class="border p-2 rounded">

            <button class="bg-blue-600 text-white px-4 rounded">Filter</button>
            <a href="index.php" class="bg-gray-400 text-white px-4 py-2 rounded text-center">
                Reset
            </a>

        </form>

        <!-- TABLE -->
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">EMP ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Mode</th>
                        <th class="border p-2">Shift Start</th>
                        <th class="border p-2">Shift End</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if ($attendance->num_rows == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">
                                No attendance found
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php while ($row = $attendance->fetch_assoc()): ?>
                        <tr class="text-center">
                            <td class="border p-2"><?= $row['user_id'] ?></td>
                            <td class="border p-2"><?= $row['emp_id'] ?></td>
                            <td class="border p-2"><?= htmlspecialchars($row['user_name']) ?></td>
                            <td class="border p-2"><?= ucfirst($row['mode']) ?></td>
                            <td class="border p-2"><?= date("d M Y, g:i a", strtotime($row['shift_start'])) ?></td>
                            <td class="border p-2"><?= date("d M Y, g:i a", strtotime($row['shift_end'])) ?></td>
                            <td class="border p-2">
                                <span class="px-2 py-1 rounded text-white
<?= $row['status'] == 'present' ? 'bg-green-600' : 'bg-red-600' ?>">
                                    <?= ucfirst(str_replace('_', ' ', $row['status'])) ?>
                                </span>
                            </td>
                            <td class="border p-2 space-x-2">
                                <button onclick='editAttendance(<?= json_encode($row) ?>)'
                                    class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete record?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
            <div class="flex justify-center gap-2 mt-6 flex-wrap">
                <?php
                $q = $_GET;
                unset($q['page']);
                $qStr = http_build_query($q);
                ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?= $qStr ?>&page=<?= $i ?>" class="px-3 py-1 border rounded
<?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        <div id="attendanceModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[70%] overflow-hidden transform transition-all">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white" id="modalTitle">Add Attendance Record</h3>
                            <p class="text-blue-100 text-sm mt-1">Record employee attendance details</p>
                        </div>
                        <button onclick="closeModal()" class="text-white hover:bg-white/20 p-2 rounded-full transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form method="POST" class="p-6 space-y-8">
                    <input type="hidden" name="attendance_id" id="attendance_id">

                    <!-- Employee Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Select Employee
                            </span>
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition appearance-none bg-white hover:border-gray-400">
                            <option value="" disabled selected>Choose an employee...</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= $emp['id'] ?>" data-name="<?= htmlspecialchars($emp['name']) ?>">
                                    <?= htmlspecialchars($emp['name']) ?>
                                    <span class="text-gray-500 text-sm">(ID: <?= $emp['id'] ?>)</span>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="user_name" id="user_name">
                    </div>

                    <!-- Mode Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Tracking Mode
                            </span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <input type="radio" name="mode" value="event" class="hidden" checked>
                                <div class="text-center w-full">
                                    <div class="font-medium text-gray-800">Event-based</div>
                                    <div class="text-xs text-gray-500 mt-1">Specific events</div>
                                </div>
                            </label>
                            <label
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <input type="radio" name="mode" value="static" class="hidden">
                                <div class="text-center w-full">
                                    <div class="font-medium text-gray-800">Static</div>
                                    <div class="text-xs text-gray-500 mt-1">Fixed schedule</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Date & Time Inputs -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Shift Start
                                </span>
                            </label>
                            <input type="datetime-local" name="shift_start" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition hover:border-gray-400">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Shift End
                                </span>
                            </label>
                            <input type="datetime-local" name="shift_end" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition hover:border-gray-400">
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Attendance Status
                            </span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-400 transition has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                                <input type="radio" name="status" value="present" class="hidden" checked>
                                <div class="flex items-center gap-2 w-full justify-center">
                                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    <span class="font-medium text-gray-800">Present</span>
                                </div>
                            </label>
                            <label
                                class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-400 transition has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <input type="radio" name="status" value="absent" class="hidden">
                                <div class="flex items-center gap-2 w-full justify-center">
                                    <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    <span class="font-medium text-gray-800">Absent</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeModal()"
                            class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition active:scale-95">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-700 hover:to-indigo-700 transition active:scale-95 shadow-md hover:shadow-lg">
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Save Record
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openModal() {
            document.getElementById('attendanceModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('attendanceModal').classList.add('hidden');
        }

        function editAttendance(data) {
            openModal();
            document.getElementById('attendance_id').value = data.id;
            document.getElementById('user_id').value = data.user_id;
            document.getElementById('user_name').value = data.user_name;
            document.getElementById('mode').value = data.mode;
            document.querySelector('[name="shift_start"]').value = data.shift_start.replace(' ', 'T');
            document.querySelector('[name="shift_end"]').value = data.shift_end.replace(' ', 'T');
            document.querySelector('[name="status"]').value = data.status;
        }

        document.getElementById('user_id').addEventListener('change', function () {
            this.form.user_name.value = this.options[this.selectedIndex].text;
        });
    </script>


</body>

</html>