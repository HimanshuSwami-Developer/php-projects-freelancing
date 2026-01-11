<?php
require_once './../session.php';

if (!in_array($_SESSION['user_role'], ['admin','owner'])) {
    http_response_code(403);
    exit;
}

$email = $_GET['email'] ?? '';
$email = basename($email); // 🔐 prevent traversal

// ✅ CORRECT ABSOLUTE PATH
$baseDir = realpath(__DIR__ . '/../user/Upload/' . $email);

$files = [];

if ($baseDir && is_dir($baseDir)) {
    foreach (glob($baseDir . '/*.{jpg,jpeg,png}', GLOB_BRACE) as $file) {
        // ✅ CORRECT WEB PATH
        $files[] = '../user/Upload/' . rawurlencode($email) . '/' . basename($file);
    }
}

header('Content-Type: application/json');
echo json_encode($files);
