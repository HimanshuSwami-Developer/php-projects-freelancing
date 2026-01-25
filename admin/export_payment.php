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
   FILTERS (same as payment.php)
================================ */
$empFilter    = $_GET['user_id'] ?? '';
$statusFilter = $_GET['status'] ?? '';
$from         = $_GET['from'] ?? '';
$to           = $_GET['to'] ?? '';

$where  = "WHERE 1=1";
$params = [];
$types  = "";

if ($empFilter !== '') {
    $where .= " AND a.user_id=?";
    $params[] = $empFilter;
    $types   .= "i";
}

if ($statusFilter !== '') {
    $where .= " AND p.payment_status=?";
    $params[] = $statusFilter;
    $types   .= "s";
}

if ($from && $to) {
    $where .= " AND DATE(a.shift_start) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
    $types   .= "ss";
}

/* ===============================
   FETCH PAYMENT DATA
================================ */
$sql = "
    SELECT
        u.emp_id,
        a.user_name,
        a.mode,
        a.shift_start,
        a.shift_end,
        a.status AS attendance_status,
        COALESCE(p.cash_payment,0) AS cash_payment,
        COALESCE(p.ni_payment,0) AS ni_payment,
        COALESCE(p.expense,0) AS expense,
        COALESCE(p.payment_status,'pending') AS payment_status
    FROM attendance a
    LEFT JOIN payment_track p ON p.attendance_id = a.id
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
$filename = "payment_tracker_" . date('Y-m-d_H-i') . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

/* ===============================
   OUTPUT EXCEL TABLE
================================ */
echo "<table border='1'>";
echo "<tr>
        <th>Employee ID</th>
        <th>Name</th>
        <th>Mode</th>
        <th>Shift Start</th>
        <th>Shift End</th>
        <th>Attendance Status</th>
        <th>Payment I</th>
        <th>Payment II</th>
        <th>Expense</th>
        <th>Payment Status</th>
      </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['emp_id']}</td>";
    echo "<td>".htmlspecialchars($row['user_name'])."</td>";
    echo "<td>{$row['mode']}</td>";
    echo "<td>{$row['shift_start']}</td>";
    echo "<td>{$row['shift_end']}</td>";
    echo "<td>{$row['attendance_status']}</td>";
    echo "<td>{$row['cash_payment']}</td>";
    echo "<td>{$row['ni_payment']}</td>";
    echo "<td>{$row['expense']}</td>";
    echo "<td>{$row['payment_status']}</td>";
    echo "</tr>";
}

echo "</table>";
exit;
