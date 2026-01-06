<?php
require_once './../session.php';
require_once './../db.php';

/* ---------- AUTH ---------- */
if ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'owner') {
    http_response_code(403);
    exit('Access denied');
}

/* ---------- CLEAN OUTPUT ---------- */
while (ob_get_level()) {
    ob_end_clean();
}

/* ---------- ZIP CHECK ---------- */
if (!class_exists('ZipArchive')) {
    exit('ZipArchive not enabled');
}

$conn = getDB();

/* ---------- ZIP SETUP ---------- */
$zip = new ZipArchive();
$zipName = 'user_documents_' . date('Ymd_His') . '.zip';
$zipPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipName;

if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    exit('Cannot create ZIP');
}

/* ---------- BASE UPLOAD DIR ---------- */
$baseDir = realpath('C:/xampp/htdocs/user/Upload');

if ($baseDir === false) {
    exit('Upload directory not found');
}

/* ---------- FETCH USERS ---------- */
$stmt = $conn->prepare("
    SELECT emp_id, email, act_doc, sia_doc, share_code_doc
    FROM users
");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $empId = $row['emp_id'];
    $email = trim($row['email']);

    // Folder name = email
    $userFolder = $baseDir . DIRECTORY_SEPARATOR . $email;

    if (!is_dir($userFolder)) {
        continue;
    }

    foreach (['act_doc', 'sia_doc', 'share_code_doc'] as $docKey) {
        if (!empty($row[$docKey])) {

            $filePath = $userFolder . DIRECTORY_SEPARATOR . $row[$docKey];

            if (is_file($filePath)) {
                $zip->addFile(
                    $filePath,
                    "Employee_$empId/$email/" . basename($filePath)
                );
            }
        }
    }
}

$stmt->close();
$zip->close();

/* ---------- DOWNLOAD ---------- */
if (!file_exists($zipPath)) {
    exit('ZIP not created');
}

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipName . '"');
header('Content-Length: ' . filesize($zipPath));
header('Cache-Control: no-store');

readfile($zipPath);
unlink($zipPath);
exit;
