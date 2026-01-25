<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin','owner'])) {
    exit('Access denied');
}

$conn = getDB();

/* ===============================
   GET FILTERS (same as index)
================================ */
$empFilter    = $_GET['user_id'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$from         = $_GET['from'] ?? '';
$to           = $_GET['to'] ?? '';

$where  = "WHERE 1=1";
$params = [];
$types  = "";

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
   FETCH ATTENDANCE
================================ */
$sql = "
    SELECT 
        a.user_id,
        u.emp_id,
        a.user_name,
        a.mode,
        a.shift_start,
        a.shift_end,
        a.status
    FROM attendance a
    LEFT JOIN users u ON u.id = a.user_id
    $where
    ORDER BY a.shift_start DESC
";

$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

/* ===============================
   EXCEL HEADERS
================================ */
$filename = "attendance_export_" . date('Y-m-d_H-i') . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

/* ===============================
   OUTPUT TABLE
================================ */
echo "<table border='1'>";
echo "<tr>
        <th>ID</th>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Mode</th>
        <th>Shift Start</th>
        <th>Shift End</th>
        <th>Status</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['user_id']}</td>";
    echo "<td>{$row['emp_id']}</td>";
    echo "<td>".htmlspecialchars($row['user_name'])."</td>";
    echo "<td>{$row['mode']}</td>";
    echo "<td>{$row['shift_start']}</td>";
    echo "<td>{$row['shift_end']}</td>";
    echo "<td>{$row['status']}</td>";
    echo "</tr>";
}

echo "</table>";
exit;
