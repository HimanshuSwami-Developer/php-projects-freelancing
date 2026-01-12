<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTH CHECK
================================ */

$conn = getDB();
$emp_id = $_SESSION['user_id'];

/* ===============================
   FETCH USER DATA
================================ */
$stmt = $conn->prepare("
    SELECT emp_id, name, role, email, contact, address,
   act_doc, act_expirey,
   sia_doc, sia_expirey,
   sia_licence_number,
   share_code_doc, share_code_expirey,
   share_code_text,
   first_aid_doc
FROM users
WHERE emp_id = ?
");
$stmt->bind_param("i", $emp_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

/* ===============================
   DOCUMENT CONFIG
================================ */
$docs = [
    'act_doc' => 'ACT Certificate',
    'sia_doc' => 'SIA Certificate',
    'share_code_doc' => 'Share Code',
    'first_aid_doc' => 'First Aid Certificate'
];

$expiryMap = [
    'act_doc' => 'act_expirey',
    'sia_doc' => 'sia_expirey',
    'share_code_doc' => 'share_code_expirey'
];

$expiryRules = [
    'act_doc' => '+1 year',
    'sia_doc' => '+3 years',
    'share_code_doc' => '+3 months'
];

/* ===============================
   IMAGE COMPRESSION FUNCTION
================================ */
function compressImage($source, $destination, $quality = 75)
{
    if (!function_exists('imagecreatefromjpeg') || !function_exists('imagecreatefrompng')) {
        // fallback: just move the file without compression
        move_uploaded_file($source, $destination);
        return;
    }

    $info = getimagesize($source);

    if ($info['mime'] === 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
        imagejpeg($image, $destination, $quality);
    } elseif ($info['mime'] === 'image/png') {
        $image = imagecreatefrompng($source);
        imagepng($image, $destination, 7);
    } else {
        move_uploaded_file($source, $destination);
    }
    imagedestroy($image);
}


/* ===============================
   HANDLE UPLOAD / RE-UPLOAD
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $baseDir = __DIR__ . "/Upload/{$user['email']}/";
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0777, true);
    }

    $allowedMime = ['image/jpeg', 'image/png'];

    $submitAllowedDocs = ['act_doc', 'first_aid_doc'];

    foreach ($docs as $column => $label) {

        // 🚫 BLOCK SIA & SHARE CODE ON SUBMIT
        // if (!in_array($column, $submitAllowedDocs)) {
        //     continue;
        // }

        /* BLOCK RE-UPLOAD FOR FIRST AID */
        if ($column === 'first_aid_doc' && !empty($user['first_aid_doc'])) {
            continue;
        }

        if (!isset($_FILES[$column]) || $_FILES[$column]['error'] !== 0) {
            continue;
        }

        $tmp = $_FILES[$column]['tmp_name'];
        $mime = mime_content_type($tmp);

        if (!in_array($mime, $allowedMime)) {
            die("Only JPG and PNG images are allowed.");
        }

        /* DELETE OLD FILE (ANY EXTENSION) */
        foreach (glob($baseDir . $column . '.*') as $oldFile) {
            unlink($oldFile);
        }

        $ext = pathinfo($_FILES[$column]['name'], PATHINFO_EXTENSION);
        $filename = $column . '.' . strtolower($ext);
        $dest = $baseDir . $filename;

        compressImage($tmp, $dest, 75);

        if (filesize($dest) > 2 * 1024 * 1024) {
            compressImage($tmp, $dest, 60);
        }

        $relativePath = "Upload/{$user['email']}/{$filename}";
        if ($column === 'first_aid_doc') {

            $sql = "
        UPDATE users
        SET $column = ?, updated_at = NOW()
        WHERE emp_id = ?
    ";
            $update = $conn->prepare($sql);
            $update->bind_param("si", $relativePath, $emp_id);

        } else {

            $expiryColumn = $expiryMap[$column];
            // $expiryDate = date('Y-m-d', strtotime($expiryRules[$column]));
            $expiryDate = $user[$expiryColumn] ?? null;


            $sql = "
        UPDATE users
        SET $column = ?, $expiryColumn = ?, updated_at = NOW()
        WHERE emp_id = ?
    ";
            $update = $conn->prepare($sql);
            $update->bind_param("ssi", $relativePath, $expiryDate, $emp_id);
        }


        $update->execute();
        $update->close();
    }

    $_SESSION['upload_success'] = "Documents updated successfully.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Documents</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="p-6 space-y-10">

        <!-- USER OVERVIEW -->
        <div>
            <h2 class="text-2xl font-bold mb-2">User Overview (Read Only)</h2>
            <div class="bg-white rounded shadow overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 border">Employee ID</th>
                            <th class="p-3 border">Name</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Contact</th>
                            <th class="p-3 border">Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="p-3 border"><?= $user['emp_id'] ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($user['contact']) ?></td>
                            <td class="p-3 border"><?= htmlspecialchars($user['address']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if (!empty($_SESSION['upload_success'])): ?>
            <div id="uploadSuccessMsg" class="bg-green-100 text-green-700 p-3 rounded">
                <?= $_SESSION['upload_success'];
                unset($_SESSION['upload_success']); ?>
            </div>
        <?php endif; ?>

        <!-- VIEW DOCUMENTS -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Uploaded Documents</h3>

            <div class="grid grid-cols-4 gap-6 overflow-x-auto">
                <?php foreach ($docs as $key => $label): ?>
                    <div class="border rounded p-4 text-center">
                        <h4 class="font-semibold mb-2"><?= $label ?></h4>
                        <?php if (!empty($user[$key]) && file_exists(__DIR__ . '/' . $user[$key])): ?>
                            <img src="<?= $user[$key] ?>" class="max-h-40 mx-auto border rounded">
                            <?php if ($key !== 'first_aid_doc'): ?>
                                <p class="text-sm mt-2 text-gray-600">
                                    Expires on: <?= $user[$expiryMap[$key]] ?>
                                </p>
                            <?php else: ?>
                                <p class="text-sm mt-2 text-green-600 font-semibold">
                                    One-time upload (No expiry)
                                </p>
                            <?php endif; ?>

                        <?php else: ?>
                            <span class="text-red-600 text-sm">Not uploaded yet</span>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- UPLOAD -->
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-semibold mb-4">Upload / Re-upload Documents</h3>

            <form method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-4 gap-6 overflow-x-auto">

                    <?php foreach ($docs as $key => $label): ?>
                        <div class="border rounded p-4">
                            <label class="block font-semibold mb-2">
                                <?= $label ?>
                                <span class="text-sm text-gray-500">
                                    <?php
                                    if ($key === 'first_aid_doc' && !empty($user[$key])) {
                                        echo '(Uploaded)';
                                    } else {
                                        echo empty($user[$key]) ? '(Upload)' : '(Re-upload)';
                                    }
                                    ?>
                                </span>

                            </label>

                            <?php if ($key === 'first_aid_doc' && !empty($user['first_aid_doc'])): ?>
                                <p class="text-green-600 text-sm font-semibold">
                                    Already uploaded (cannot be changed)
                                </p>
                            <?php else: ?>
                                <input type="file" name="<?= $key ?>" accept="image/*" class="w-full border p-2 rounded"
                                    onchange="previewImage(this,'preview_<?= $key ?>')">
                            <?php endif; ?>
                            <?php if ($key === 'sia_doc'): ?>
                                    <div class="mt-2 text-sm hidden" id="siaResult">
                                        <p><b>Licence No:</b> <span id="siaLicence">—</span></p>
                                        <p><b>Expiry:</b> <span id="siaExpiry">—</span></p>
                                    </div>
                                <?php endif; ?>

                                <?php if ($key === 'share_code_doc'): ?>
                                    <div class="mt-2 text-sm hidden" id="shareResult">
                                        <p><b>Share Code:</b> <span id="shareCode">—</span></p>
                                        <p><b>Valid Until:</b> <span id="shareExpiry">—</span></p>
                                    </div>
                                <?php endif; ?>


                            <img id="preview_<?= $key ?>" class="hidden mt-3 max-h-32 mx-auto border rounded">
                        </div>
                    <?php endforeach; ?>

                </div>

                <button id="submitBtn" type="submit"
                    class="mt-6 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 disabled:opacity-50">
                    Submit Changes
                </button>
            </form>
        </div>

<!-- OCR LOADER -->
<div id="ocrLoader"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 flex flex-col items-center gap-4 shadow-lg">
        <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent"></div>
        <p class="text-sm font-semibold text-gray-700">
            Extracting document details, please wait...
        </p>
    </div>
</div>

    </div>
<script src="https://js.puter.com/v2/"></script>


    <!-- BLUR DETECTION + PREVIEW -->
    <script>
function showOCRLoader() {
    document.getElementById('ocrLoader').classList.remove('hidden');
}

function hideOCRLoader() {
    document.getElementById('ocrLoader').classList.add('hidden');
}

        async function toDataURL(file) {
    return new Promise(resolve => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result);
        reader.readAsDataURL(file);
    });
}

let ocrStatus = {
    sia_doc: { valid: false },
    share_code_doc: { valid: false }
};

function updateSubmitState() {
    const submitBtn = document.getElementById("submitBtn");

    const siaInvalid =
        document.querySelector("input[name='sia_doc']")?.files.length &&
        !ocrStatus.sia_doc.valid;

    const shareInvalid =
        document.querySelector("input[name='share_code_doc']")?.files.length &&
        !ocrStatus.share_code_doc.valid;

    submitBtn.disabled = siaInvalid || shareInvalid;
}


async function runOCR(file, type) {

    showOCRLoader(); // 🔥 SHOW OVERLAY

    try {
        const rawText = await puter.ai.img2txt(await toDataURL(file));

        const t = rawText
            .toUpperCase()
            .replace(/[^A-Z0-9\s]/g, ' ')
            .replace(/\s+/g, ' ');

        let payload = { type };

        /* =======================
           SIA
        ======================= */
        if (type === 'sia') {

            const licence = t.match(/\b\d{4}\s\d{4}\s\d{4}\s\d{4}\b/);

            const day = t.match(/\b([0-3]?\d)\b/);
            const month = t.match(/\b(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|SEPT|OCT|NOV|DEC)\b/);
            const year = t.match(/\b(20[2-3]\d)\b/);

            const licenceNo = licence ? licence[0] : 'Not detected';
            const expiry = (day && month && year)
                ? new Date(`${day[1]} ${month[1]} ${year[1]}`).toISOString().split('T')[0]
                : 'Not detected';

            document.getElementById('siaLicence').innerText = licenceNo;
            document.getElementById('siaExpiry').innerText = expiry;
            document.getElementById('siaResult').classList.remove('hidden');

            payload.licence = licenceNo !== 'Not detected' ? licenceNo : null;
            payload.expiry  = expiry !== 'Not detected' ? expiry : null;
            
            ocrStatus.sia_doc.valid = !!(payload.licence && payload.expiry);
        }

        /* =======================
           SHARE CODE
        ======================= */
        if (type === 'share') {

            const code = t.match(/\b[A-Z0-9]{3}\s[A-Z0-9]{3}\s[A-Z0-9]{3}\b/);

            const date = t.match(
                /\b([0-3]?\d)\s(JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER)\s(20\d{2})\b/
            );

            const shareCode = code ? code[0] : 'Not detected';
            const expiry = date
                ? new Date(`${date[1]} ${date[2]} ${date[3]}`).toISOString().split('T')[0]
                : 'Not detected';

            document.getElementById('shareCode').innerText = shareCode;
            document.getElementById('shareExpiry').innerText = expiry;
            document.getElementById('shareResult').classList.remove('hidden');

            payload.code   = shareCode !== 'Not detected' ? shareCode : null;
            payload.expiry = expiry !== 'Not detected' ? expiry : null;
            
            ocrStatus.share_code_doc.valid = !!(payload.code && payload.expiry);
        }

        // SAVE OCR DATA
        await fetch("save_ocr.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        updateSubmitState();

    } catch (err) {
        alert("OCR failed. Please try a clearer image.");
        console.error(err);
    } finally {
        hideOCRLoader(); // 🔥 ALWAYS HIDE OVERLAY
    }
}


        let blurStatus = {
            act_doc: false,
            sia_doc: false,
            share_code_doc: false
        };

        const BLUR_THRESHOLD = 100;

        function computeVariance(data) {
            const n = data.length;
            let mean = data.reduce((a, b) => a + b, 0) / n;
            let variance = data.reduce((a, b) => a + (b - mean) * (b - mean), 0) / n;
            return variance;
        }

        function checkBlur(file) {
            return new Promise(resolve => {
                const img = new Image();
                const reader = new FileReader();
                reader.onload = e => img.src = e.target.result;
                reader.readAsDataURL(file);

                img.onload = () => {
                    const canvas = document.createElement("canvas");
                    const maxDim = 300; // scale down
                    let w = img.width;
                    let h = img.height;
                    if (Math.max(w, h) > maxDim) {
                        const scale = maxDim / Math.max(w, h);
                        w *= scale; h *= scale;
                    }
                    canvas.width = w; canvas.height = h;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(img, 0, 0, w, h);

                    const imgData = ctx.getImageData(0, 0, w, h);
                    const gray = [];
                    for (let i = 0; i < imgData.data.length; i += 4) {
                        const r = imgData.data[i], g = imgData.data[i + 1], b = imgData.data[i + 2];
                        gray.push(0.299 * r + 0.587 * g + 0.114 * b);
                    }

                    // Laplacian kernel
                    const lap = [];
                    for (let y = 1; y < h - 1; y++) {
                        for (let x = 1; x < w - 1; x++) {
                            const i = y * w + x;
                            const val = -gray[i - w - 1] - gray[i - w] - gray[i - w + 1]
                                - gray[i - 1] + 8 * gray[i] - gray[i + 1]
                                - gray[i + w - 1] - gray[i + w] - gray[i + w + 1];
                            lap.push(val);
                        }
                    }

                    const variance = computeVariance(lap);
                    resolve(variance < BLUR_THRESHOLD);
                };
            });
        }

        async function previewImage(input, id) {
            const file = input.files[0];
            const key = input.name;
            if (!file || !file.type.startsWith('image/')) {
                alert("Only image files allowed"); input.value = ""; return;
            }

            // show preview immediately
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(id);
                img.src = e.target.result;
                img.classList.remove("hidden");
            };
            reader.readAsDataURL(file);

    if (input.name === 'sia_doc') {
        runOCR(file, 'sia');
    }

    if (input.name === 'share_code_doc') {
        runOCR(file, 'share');
    }
            // check blur in background
            const isBlurry = await checkBlur(file);
            blurStatus[key] = isBlurry;
            const submitBtn = document.getElementById("submitBtn");
            submitBtn.disabled = Object.values(blurStatus).includes(true);

            if (isBlurry) {
                alert("Image might be blurry. Please upload a clearer image.");
            }
        }
    </script>

    <script>
        setTimeout(() => {
            const msg = document.getElementById("uploadSuccessMsg");
            if (msg) msg.remove();
        }, 1500);
    </script>

<script>
document.querySelector("form").addEventListener("submit", function (e) {

    // SIA validation
    if (
        document.querySelector("input[name='sia_doc']")?.files.length &&
        !ocrStatus.sia_doc.valid
    ) {
        alert("SIA document is missing Licence Number or Expiry date.");
        e.preventDefault();
        return;
    }

    // Share code validation
    if (
        document.querySelector("input[name='share_code_doc']")?.files.length &&
        !ocrStatus.share_code_doc.valid
    ) {
        alert("Share Code document is missing Code or Expiry date.");
        e.preventDefault();
        return;
    }
});
</script>

</body>

</html>