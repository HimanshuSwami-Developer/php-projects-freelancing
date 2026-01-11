<?php
require_once './../session.php';
require_once './../db.php';

$conn = getDB();
$emp_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}


$data = json_decode(file_get_contents("php://input"), true);
if (!$data || empty($data['type'])) {
    http_response_code(400);
    exit;
}

// ===============================
// SIA SAVE
// ===============================
if ($data['type'] === 'sia') {

    $licence = $data['licence'] ?? null;
    $expiry  = $data['expiry'] ?? null;

  $stmt = $conn->prepare("
    UPDATE users
    SET 
        sia_licence_number = COALESCE(?, sia_licence_number),
        sia_expirey = COALESCE(?, sia_expirey)
    WHERE emp_id = ?
");
$stmt->bind_param("ssi", $licence, $expiry, $emp_id);
$stmt->execute();
    $stmt->close();
}

// ===============================
// SHARE CODE SAVE
// ===============================
if ($data['type'] === 'share') {

    $code   = $data['code'] ?? null;
    $expiry = $data['expiry'] ?? null;

  $stmt = $conn->prepare("
    UPDATE users
    SET 
        share_code_text = COALESCE(?, share_code_text),
        share_code_expirey = COALESCE(?, share_code_expirey)
    WHERE emp_id = ?
");
$stmt->bind_param("ssi", $code, $expiry, $emp_id);
$stmt->execute();

    $stmt->close();
}

echo json_encode(["status" => "ok"]);
