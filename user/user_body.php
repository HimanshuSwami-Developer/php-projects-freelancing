<?php
require_once "./../session.php";
require_once "./../db.php";

$conn = getDB();
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    header("Location: login.php");
    exit;
}

/* ===============================
   FETCH USER + DOCUMENT DATA
================================ */
$stmt = $conn->prepare("
SELECT 
    u.name, u.email, u.contact, u.role,

    ac.act_blue_doc, ac.act_blue_expiry,
    ac.act_orange_doc, ac.act_orange_expiry,

    s.sia_licence_doc, s.sia_licence_number, s.sia_licence_expiry,

    sc.share_code_doc, sc.share_code_number, sc.share_code_expiry,
    sc.first_aid_doc, sc.first_aid_expiry

FROM users u
LEFT JOIN act_certificate ac ON ac.user_id = u.id
LEFT JOIN sia_licence s ON s.user_id = u.id
LEFT JOIN sharecode_first_aid sc ON sc.user_id = u.id
WHERE u.id = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();


function expiryClass($date, $warningDays = 30)
{
    if (empty($date))
        return '';

    $today = new DateTime();
    $expiry = new DateTime($date);
    $diff = (int) $today->diff($expiry)->format('%r%a');

    if ($diff < 0) {
        return 'bg-red-200';       // expired
    }

    if ($diff <= $warningDays) {
        return 'bg-red-100';       // near expiry
    }

    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doc_type'])) {

    $type = $_POST['doc_type'];

    $rootFs = dirname($_SERVER['DOCUMENT_ROOT']);
    $baseFs = $rootFs . "/Upload/{$user['email']}/";
    $baseDb = "/Upload/{$user['email']}/";

    if (!is_dir($baseFs))
        mkdir($baseFs, 0777, true);

    switch ($type) {

        case 'act_blue':
        case 'act_orange':
            $file = "{$type}_doc";
            move_uploaded_file($_FILES[$file]['tmp_name'], $baseFs . "{$type}.png");

            $docPath = $baseDb . "{$type}.png";
            $expiryDate = $_POST["{$type}_expiry"];

            $stmt = $conn->prepare("
                UPDATE act_certificate
                SET {$type}_doc = ?, {$type}_expiry = ?
                WHERE user_id = ?
            ");
            $stmt->bind_param(
                "ssi",
                $docPath,
                $expiryDate,
                $userId
            );
            break;

        case 'sia':
            move_uploaded_file($_FILES['sia_licence_doc']['tmp_name'], $baseFs . "sia.png");

            $stmt = $conn->prepare("
    UPDATE sia_licence
    SET sia_licence_doc = ?,
        sia_licence_number = ?,
        sia_licence_expiry = ?
    WHERE user_id = ?
");

            /* ✅ VARIABLES ONLY */
            $siaDoc = $baseDb . "sia.png";
            $siaNumber = $_POST['sia_licence_number'];
            $siaExpiry = $_POST['sia_licence_expiry'];

            $stmt->bind_param(
                "sssi",
                $siaDoc,
                $siaNumber,
                $siaExpiry,
                $userId
            );

            $stmt->execute();
            $stmt->close();

            break;

        case 'share':
            move_uploaded_file($_FILES['share_code_doc']['tmp_name'], $baseFs . "share.png");

            $stmt = $conn->prepare("
    UPDATE sharecode_first_aid
    SET share_code_doc = ?, 
        share_code_number = ?, 
        share_code_expiry = ?
    WHERE user_id = ?
");

            $shareDoc = $baseDb . "share.png";
            $shareNumber = $_POST['share_code_number'];
            $shareExpiry = $_POST['share_code_expiry'];

            $stmt->bind_param(
                "sssi",
                $shareDoc,
                $shareNumber,
                $shareExpiry,
                $userId
            );

            $stmt->execute();
            $stmt->close();

            break;

        case 'firstaid':
            move_uploaded_file($_FILES['first_aid_doc']['tmp_name'], $baseFs . "first_aid.png");

            $stmt = $conn->prepare("
    UPDATE sharecode_first_aid
    SET first_aid_doc = ?, 
        first_aid_expiry = ?
    WHERE user_id = ?
");

            $firstAidDoc = $baseDb . "first_aid.png";
            $firstAidExpiry = $_POST['first_aid_expiry'];

            $stmt->bind_param(
                "ssi",
                $firstAidDoc,
                $firstAidExpiry,
                $userId
            );

            $stmt->execute();
            $stmt->close();

            break;
    }

    if (isset($stmt)) {
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>User Documents</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto bg-white p-6 shadow rounded">

        <!-- PROFILE -->
        <h2 class="text-2xl font-bold mb-4">Profile</h2>

        <p><b>Name:</b> <?= htmlspecialchars($user['name']) ?></p>
        <p><b>Email:</b> <?= htmlspecialchars($user['email']) ?></p>
        <p><b>Contact:</b> <?= htmlspecialchars($user['contact']) ?></p>
        <p><b>Role:</b> <?= strtoupper($user['role']) ?></p>

        <hr class="my-6">

        <!-- DOCUMENT TABLE -->
        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2">Document</th>
                    <th class="border p-2">Details</th>
                    <th class="border p-2">Expiry</th>
                    <th class="border p-2">View</th>
                </tr>
            </thead>
            <tbody>

                <tr class="<?= expiryClass($user['act_blue_expiry']) ?>">

                    <td class="border p-2 font-semibold">ACT Blue</td>
                    <td class="border p-2">—</td>
                    <td class="border p-2"><?= $user['act_blue_expiry'] ?? '—' ?></td>
                    <td class="border p-2 text-center">
                        <?php if (!empty($user['act_blue_doc'])): ?>
                            <button type="button" onclick="openImageModal('/<?= ltrim($user['act_blue_doc'], '/') ?>')"
                                class="text-blue-600 underline">
                                View
                            </button>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>

                </tr>

                <tr class="<?= expiryClass($user['act_orange_expiry']) ?>">

                    <td class="border p-2 font-semibold">ACT Orange</td>

                    <td class="border p-2">—</td>

                    <td class="border p-2">
                        <?= $user['act_orange_expiry'] ?: '—' ?>
                    </td>

                    <td class="border p-2 text-center">
                        <?php if (!empty($user['act_orange_doc'])): ?>
                            <button type="button" onclick="openImageModal('/<?= ltrim($user['act_orange_doc'], '/') ?>')"
                                class="text-blue-600 underline">
                                View
                            </button>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>


                <tr class="<?= expiryClass($user['sia_licence_expiry']) ?>">

                    <td class="border p-2 font-semibold">SIA Licence</td>

                    <td class="border p-2">
                        <b>No:</b> <?= $user['sia_licence_number'] ?: '—' ?>
                    </td>

                    <td class="border p-2">
                        <?= $user['sia_licence_expiry'] ?: '—' ?>
                    </td>

                    <td class="border p-2 text-center">
                        <?php if (!empty($user['sia_licence_doc'])): ?>
                            <button type="button" onclick="openImageModal('/<?= ltrim($user['sia_licence_doc'], '/') ?>')"
                                class="text-blue-600 underline">
                                View
                            </button>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>


                <tr class="<?= expiryClass($user['share_code_expiry']) ?>">

                    <td class="border p-2 font-semibold">Share Code</td>

                    <td class="border p-2">
                        <b>Code:</b> <?= $user['share_code_number'] ?: '—' ?>
                    </td>

                    <td class="border p-2">
                        <?= $user['share_code_expiry'] ?: '—' ?>
                    </td>

                    <td class="border p-2 text-center">
                        <?php if (!empty($user['share_code_doc'])): ?>
                            <button type="button" onclick="openImageModal('/<?= ltrim($user['share_code_doc'], '/') ?>')"
                                class="text-blue-600 underline">
                                View
                            </button>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>

                <tr class="<?= expiryClass($user['first_aid_expiry']) ?>">

                    <td class="border p-2 font-semibold">First Aid</td>

                    <td class="border p-2">—</td>

                    <td class="border p-2">
                        <?= $user['first_aid_expiry'] ?: '—' ?>
                    </td>

                    <td class="border p-2 text-center">
                        <?php if (!empty($user['first_aid_doc'])): ?>
                            <button type="button" onclick="openImageModal('/<?= ltrim($user['first_aid_doc'], '/') ?>')"
                                class="text-blue-600 underline">
                                View
                            </button>
                        <?php else: ?>
                            —
                        <?php endif; ?>
                    </td>
                </tr>


            </tbody>
        </table>


        <form method="POST" enctype="multipart/form-data"
            onsubmit="return validateBeforeSave(this.querySelector('.save-btn'))">

            <input type="hidden" name="doc_type" value="act_blue">

            <div class="border p-4 rounded relative" data-doc="act_blue">

                <h4 class="font-semibold mb-2">ACT Blue</h4>

                <input type="file" name="act_blue_doc" accept="image/*" data-type="blue"
                    onchange="handleDocumentOCR(this)" class="w-full border p-2" required>

                <img class="act-preview hidden mt-3 max-h-72 border mx-auto" />

                <div class="act-result hidden mt-3 text-sm">
                    <p><strong>Completion Date:</strong> <span class="act-issue"></span></p>
                    <p><strong>Expiry Date:</strong> <span class="act-expiry"></span></p>
                </div>

                <input type="hidden" name="act_blue_expiry">

                <button type="submit" class="save-btn hidden mt-3 bg-blue-600 text-white px-4 py-1 rounded">
                    Save ACT Blue
                </button>

            </div>
        </form>



        <form method="POST" enctype="multipart/form-data"
            onsubmit="return validateBeforeSave(this.querySelector('.save-btn'))">

            <input type="hidden" name="doc_type" value="act_orange">

            <div class="border p-4 rounded relative" data-doc="act_orange">

                <h4 class="font-semibold mb-2">ACT Orange</h4>

                <input type="file" name="act_orange_doc" accept="image/*" data-type="orange"
                    onchange="handleDocumentOCR(this)" class="w-full border p-2" required>

                <img class="act-preview hidden mt-3 max-h-72 border mx-auto" />

                <div class="act-result hidden mt-3 text-sm">
                    <p><strong>Completion Date:</strong> <span class="act-issue"></span></p>
                    <p><strong>Expiry Date:</strong> <span class="act-expiry"></span></p>
                </div>

                <input type="hidden" name="act_orange_expiry">

                <button type="submit" class="save-btn hidden mt-3 bg-blue-600 text-white px-4 py-1 rounded">
                    Save ACT Orange
                </button>

            </div>
        </form>

        <form method="POST" enctype="multipart/form-data"
            onsubmit="return validateBeforeSave(this.querySelector('.save-btn'))">

            <input type="hidden" name="doc_type" value="sia">

            <div class="border p-4 rounded relative" data-doc="sia">

                <h4 class="font-semibold mb-2">SIA Licence</h4>

                <input type="file" name="sia_licence_doc" accept="image/*" data-type="sia"
                    onchange="handleDocumentOCR(this)" class="w-full border p-2" required>

                <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />

                <div class="doc-result hidden mt-3 text-sm">
                    <p><strong>Licence No:</strong> <span class="sia-licence"></span></p>
                    <p><strong>Expiry Date:</strong> <span class="sia-expiry"></span></p>
                </div>

                <input type="hidden" name="sia_licence_number">
                <input type="hidden" name="sia_licence_expiry">

                <button type="submit" class="save-btn hidden mt-3 bg-blue-600 text-white px-4 py-1 rounded">
                    Save SIA Licence
                </button>

            </div>
        </form>


        <form method="POST" enctype="multipart/form-data"
            onsubmit="return validateBeforeSave(this.querySelector('.save-btn'))">

            <input type="hidden" name="doc_type" value="share">

            <div class="border p-4 rounded relative" data-doc="share">

                <h4 class="font-semibold mb-2">Share Code</h4>

                <input type="file" name="share_code_doc" accept="image/*" data-type="share"
                    onchange="handleDocumentOCR(this)" class="w-full border p-2" required>

                <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />

                <div class="doc-result hidden mt-3 text-sm">
                    <p><strong>Code:</strong> <span class="share-code"></span></p>
                    <p><strong>Expiry Date:</strong> <span class="share-expiry"></span></p>
                </div>

                <input type="hidden" name="share_code_number">
                <input type="hidden" name="share_code_expiry">

                <button type="submit" class="save-btn hidden mt-3 bg-blue-600 text-white px-4 py-1 rounded">
                    Save Share Code
                </button>

            </div>
        </form>


        <form method="POST" enctype="multipart/form-data"
            onsubmit="return validateBeforeSave(this.querySelector('.save-btn'))">

            <input type="hidden" name="doc_type" value="firstaid">

            <div class="border p-4 rounded relative" data-doc="firstaid">

                <h4 class="font-semibold mb-2">First Aid</h4>

                <input type="file" name="first_aid_doc" accept="image/*" data-type="firstaid"
                    onchange="handleDocumentOCR(this)" class="w-full border p-2" required>

                <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />

                <div class="doc-result hidden mt-3 text-sm">
                    <p><strong>Awarded Date:</strong> <span class="fa-issue"></span></p>
                    <p><strong>Expiry Date:</strong> <span class="fa-expiry"></span></p>
                </div>

                <input type="hidden" name="first_aid_expiry">

                <button type="submit" class="save-btn hidden mt-3 bg-blue-600 text-white px-4 py-1 rounded">
                    Save First Aid
                </button>

            </div>
        </form>


    </div>

    <!-- IMAGE MODAL -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden flex items-center justify-center z-50">
        <div class="relative bg-white p-4 rounded shadow max-w-4xl">
            <button onclick="closeImageModal()"
                class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded">✕</button>
            <img id="modalImage" class="max-h-[80vh] mx-auto border rounded">
        </div>
    </div>

    <div id="ocrLoader" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white px-6 py-4 rounded shadow text-lg">
            Extracting document details…
        </div>
    </div>



    <script>
        function openImageModal(src) {
            document.getElementById("modalImage").src = src;
            document.getElementById("imageModal").classList.remove("hidden");
        }
        function closeImageModal() {
            document.getElementById("modalImage").src = "";
            document.getElementById("imageModal").classList.add("hidden");
        }
    </script>

    <script>
        function showLoader() {
            document.getElementById("ocrLoader").classList.remove("hidden");
        }

        function hideLoader() {
            document.getElementById("ocrLoader").classList.add("hidden");
        }

        function toDataURL(file) {
            return new Promise(resolve => {
                const reader = new FileReader();
                reader.onload = e => resolve(e.target.result);
                reader.readAsDataURL(file);
            });
        }
    </script>

    <script src="https://js.puter.com/v2/"></script>

    <script>
        async function handleDocumentOCR(input) {

            const file = input.files[0];
            if (!file) return;

            const type = input.dataset.type;
            const wrapper = input.closest("[data-doc]");

            const preview =
                wrapper.querySelector(".doc-preview") ||
                wrapper.querySelector(".act-preview");

            if (!preview) {
                console.error("Preview image not found");
                return;
            }


            const resultBox =
                wrapper.querySelector(".doc-result") ||
                wrapper.querySelector(".act-result");

            const saveBtn = wrapper.querySelector(".save-btn");

            showLoader();

            /* IMAGE PREVIEW */
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);

            try {
                const rawText = await puter.ai.img2txt(await toDataURL(file));

                const t = rawText
                    .toUpperCase()
                    .replace(/[^A-Z0-9./\s]/g, ' ')
                    .replace(/\s+/g, ' ');

                let success = false;

                /* ACT */
                if (type === 'blue' || type === 'orange') {

                    const dateMatch = t.match(/\b([0-3]?\d)[./]([0-1]?\d)[./](20\d{2})\b/);
                    if (!dateMatch) throw "ACT date not detected";

                    const issueDate = new Date(`${dateMatch[3]}-${dateMatch[2]}-${dateMatch[1]}`);
                    const expiryDate = new Date(issueDate);
                    expiryDate.setFullYear(expiryDate.getFullYear() + 1);

                    wrapper.querySelector(".act-issue").innerText =
                        issueDate.toLocaleDateString("en-GB");

                    wrapper.querySelector(".act-expiry").innerText =
                        expiryDate.toLocaleDateString("en-GB");

                    wrapper.querySelector(`input[name="act_${type}_expiry"]`).value =
                        expiryDate.toISOString().split("T")[0];

                    success = true;
                }

                /* SIA */
                if (type === 'sia') {

                    const licenceMatch =
                        t.match(/\b\d{4}\s\d{4}\s\d{4}\s\d{4}\b/);

                    const day = t.match(/\b([0-3]?\d)\b/);
                    const month = t.match(/\b(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|SEPT|OCT|NOV|DEC)\b/);
                    const year = t.match(/\b(20[2-3]\d)\b/);

                    if (!licenceMatch || !day || !month || !year) {
                        alert("SIA licence details not detected");
                        return;
                    }

                    const expiryISO = new Date(`${day[1]} ${month[1]} ${year[1]}`)
                        .toISOString()
                        .split("T")[0];

                    wrapper.querySelector(".sia-licence").innerText = licenceMatch[0];
                    wrapper.querySelector(".sia-expiry").innerText = expiryISO;

                    wrapper.querySelector("input[name='sia_licence_number']").value = licenceMatch[0];
                    wrapper.querySelector("input[name='sia_licence_expiry']").value = expiryISO;

                    success = true;
                }

                /* SHARE CODE */
                if (type === 'share') {

                    const code = t.match(/\b[A-Z0-9]{3}\s[A-Z0-9]{3}\s[A-Z0-9]{3}\b/);
                    const expiry = t.match(/\b([0-3]?\d)\s(JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER)\s(20\d{2})\b/);

                    if (!code || !expiry) throw "Share code missing";

                    const expiryISO = new Date(`${expiry[1]} ${expiry[2]} ${expiry[3]}`)
                        .toISOString().split("T")[0];

                    wrapper.querySelector(".share-code").innerText = code[0];
                    wrapper.querySelector(".share-expiry").innerText = expiryISO;

                    wrapper.querySelector("input[name='share_code_number']").value = code[0];
                    wrapper.querySelector("input[name='share_code_expiry']").value = expiryISO;

                    success = true;
                }

                /* FIRST AID */
                if (type === 'firstaid') {

                    const dateMatch =
                        t.match(/\b([0-3]?\d)\s(DECEMBER|JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER)\s(20\d{2})\b/);

                    if (!dateMatch) throw "First Aid date missing";

                    const issueDate = new Date(`${dateMatch[1]} ${dateMatch[2]} ${dateMatch[3]}`);
                    const expiryDate = new Date(issueDate);
                    expiryDate.setFullYear(expiryDate.getFullYear() + 1);

                    wrapper.querySelector(".fa-issue").innerText =
                        issueDate.toLocaleDateString("en-GB");

                    wrapper.querySelector(".fa-expiry").innerText =
                        expiryDate.toLocaleDateString("en-GB");

                    wrapper.querySelector("input[name='first_aid_expiry']").value =
                        expiryDate.toISOString().split("T")[0];

                    success = true;
                }

                if (success) {
                    resultBox.classList.remove("hidden");
                    saveBtn.classList.remove("hidden");
                }

            } catch (e) {
                alert("OCR failed: " + e);
            } finally {
                hideLoader();
            }
        }
    </script>


    <script>
        function validateBeforeSave(btn) {
            const wrapper = btn.closest("[data-doc]");
            const expiryInput = wrapper.querySelector("input[type='hidden'][name$='_expiry']");

            if (!expiryInput || !expiryInput.value) {
                alert("OCR not completed or expiry missing");
                return false;
            }

            if (new Date(expiryInput.value) < new Date()) {
                alert("Document is expired");
                return false;
            }

            return true;
        }
    </script>



</body>

</html>