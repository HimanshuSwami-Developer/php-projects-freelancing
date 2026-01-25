<?php
// download_all_users.php

/* ==========================
   BASIC SECURITY CHECK
   (add your session / role check here)
========================== */
// session_start();
// if ($_SESSION['user_role'] !== 'admin') exit('Unauthorized');

$baseDir = __DIR__ . '/Upload/';

if (!is_dir($baseDir)) {
    exit('Upload directory not found');
}

/* ==========================
   CREATE ZIP
========================== */
$zip = new ZipArchive();
$zipFileName = 'all_user_documents_' . date('Ymd_His') . '.zip';
$tempZipPath = sys_get_temp_dir() . '/' . $zipFileName;

if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    exit('Unable to create ZIP file');
}

/* ==========================
   LOOP ALL USER FOLDERS
========================== */
$users = scandir($baseDir);

foreach ($users as $userFolder) {

    if ($userFolder === '.' || $userFolder === '..') {
        continue;
    }

    $userPath = $baseDir . $userFolder;

    if (!is_dir($userPath)) {
        continue;
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($userPath, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($files as $file) {
        if ($file->isFile()) {

            $filePath = $file->getRealPath();

            // Keep folder structure inside ZIP
            $relativePath = $userFolder . '/' . basename($filePath);

            $zip->addFile($filePath, $relativePath);
        }
    }
}

$zip->close();

/* ==========================
   FORCE DOWNLOAD
========================== */
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($tempZipPath));

readfile($tempZipPath);

/* ==========================
   CLEAN UP
========================== */
unlink($tempZipPath);
exit;
