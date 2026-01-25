<?php
require_once './../session.php';
require_once './../db.php';

header('Content-Type: application/json');

$conn = getDB();

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner')) {
    echo json_encode(['success'=>false,'message'=>'Unauthorized']);
    exit;
}


/* ===============================
   CHECK IF PAYMENT EXISTS
================================ */
$data = json_decode(file_get_contents('php://input'), true);

$payment_id     = $data['payment_id'] ?? null;
$attendance_id  = $data['attendance_id'] ?? null;
$cash_payment   = (float)($data['cash_payment'] ?? 0);
$ni_payment     = (float)($data['ni_payment'] ?? 0);
$expense        = (float)($data['expense'] ?? 0);
$payment_status = $data['payment_status'] ?? 'pending';

if (!$attendance_id) {
    echo json_encode(['success'=>false,'message'=>'Attendance ID missing']);
    exit;
}

if ($payment_id) {
    // UPDATE
    $stmt = $conn->prepare("
        UPDATE payment_track 
        SET cash_payment=?, ni_payment=?, expense=?, payment_status=?, updated_at=NOW()
        WHERE payment_id=?
    ");
    $stmt->bind_param(
        "dddsi",
        $cash_payment,
        $ni_payment,
        $expense,
        $payment_status,
        $payment_id
    );
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success'=>true,'message'=>'Payment updated successfully']);
} else {

$stmt = $conn->prepare("SELECT user_id FROM attendance WHERE id=?");
$stmt->bind_param("i", $attendance_id);
$stmt->execute();
$user_id = $stmt->get_result()->fetch_assoc()['user_id'];
$stmt->close();

if (!$user_id) {
    echo json_encode(['success'=>false,'message'=>'Invalid attendance record']);
    exit;
}

    // INSERT
   $stmt = $conn->prepare("
    INSERT INTO payment_track
    (attendance_id, user_id, cash_payment, ni_payment, expense, payment_status, created_at, updated_at)
    VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
");

$stmt->bind_param(
    "iiddss",
    $attendance_id,
    $user_id,
    $cash_payment,
    $ni_payment,
    $expense,
    $payment_status
);

    $stmt->execute();
    $stmt->close();

    echo json_encode(['success'=>true,'message'=>'Payment created successfully']);
}
