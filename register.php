<?php
require_once "db.php";

$conn = getDB();
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->begin_transaction();

    try {

        $name = $_POST['name'];
        $email = trim(strtolower($_POST['email']));
        $contact = $_POST['contact'];
        $address = $_POST['address'];

        /* ==========================
           PREVENT DUPLICATE USER
        ========================== */
        $chk = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $chk->bind_param("s", $email);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            throw new Exception("User already exists with this email");
        }
        $chk->close();

        /* ==========================
           CREATE USER FOLDER
        ========================== */
        $uploadBaseFs = __DIR__ . "/Upload/";
        $uploadBaseDb = "Upload/";

        if (!is_dir($uploadBaseFs)) {
            mkdir($uploadBaseFs, 0777, true);
        }

        $folderName = preg_replace('/[^a-zA-Z0-9@.]/', '_', $email);
        $userFolderFs = $uploadBaseFs . $folderName . "/";
        $userFolderDb = $uploadBaseDb . $folderName . "/";

        if (!is_dir($userFolderFs)) {
            mkdir($userFolderFs, 0777, true);
        }

        /* ==========================
           SAVE SIGNATURES
        ========================== */
        $authSignedPath = null;
        if (!empty($_POST['auth_signed_image'])) {
            file_put_contents(
                $userFolderFs . "authentication_signed.png",
                base64_decode(str_replace(
                    ['data:image/png;base64,', ' '],
                    ['', '+'],
                    $_POST['auth_signed_image']
                ))
            );
            $authSignedPath = $userFolderDb . "authentication_signed.png";
        }

        $screenSignedPath = null;
        if (!empty($_POST['screen_signed_image'])) {
            file_put_contents(
                $userFolderFs . "screening_signed.png",
                base64_decode(str_replace(
                    ['data:image/png;base64,', ' '],
                    ['', '+'],
                    $_POST['screen_signed_image']
                ))
            );
            $screenSignedPath = $userFolderDb . "screening_signed.png";
        }

        /* ==========================
           INSERT USER
        ========================== */
        $stmt = $conn->prepare("
            INSERT INTO users
            (name, email, contact, address, signed_authentication_doc, signed_screening_doc)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssss",
            $name,
            $email,
            $contact,
            $address,
            $authSignedPath,
            $screenSignedPath
        );
        $stmt->execute();

        $userId = $stmt->insert_id;
        $stmt->close();

        /* ==========================
           DATE HELPERS
        ========================== */
        function addDays($date, $days)
        {
            return date('Y-m-d', strtotime("$date -$days days"));
        }
        function addMonths($date, $months)
        {
            return date('Y-m-d', strtotime("$date -$months months"));
        }

        /* ==========================
           ACT CERTIFICATES
        ========================== */
        $actBluePath = $actOrangePath = null;
        $actBlueExpiry = $_POST['act_blue_expiry'] ?? null;
        $actOrangeExpiry = $_POST['act_orange_expiry'] ?? null;

        if (!empty($_FILES['act_blue_doc']['name'])) {
            move_uploaded_file($_FILES['act_blue_doc']['tmp_name'], $userFolderFs . "act_blue.png");
            $actBluePath = $userFolderDb . "act_blue.png";
        }

        if (!empty($_FILES['act_orange_doc']['name'])) {
            move_uploaded_file($_FILES['act_orange_doc']['tmp_name'], $userFolderFs . "act_orange.png");
            $actOrangePath = $userFolderDb . "act_orange.png";
        }

        $actBlue15 = $actBlueExpiry ? addDays($actBlueExpiry, 15) : null;
        $actOrange15 = $actOrangeExpiry ? addDays($actOrangeExpiry, 15) : null;

        $stmt = $conn->prepare("
            INSERT INTO act_certificate
            (user_id, act_blue_doc, act_orange_doc, act_blue_expiry, act_orange_expiry,
             act_blue_expiry_15d, act_orange_expiry_15d)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issssss",
            $userId,
            $actBluePath,
            $actOrangePath,
            $actBlueExpiry,
            $actOrangeExpiry,
            $actBlue15,
            $actOrange15
        );
        $stmt->execute();
        $stmt->close();

        /* ==========================
           SIA LICENCE
        ========================== */
        $siaPath = null;
        $siaNo = $_POST['sia_licence_number'] ?? null;
        $siaExpiry = $_POST['sia_licence_expiry'] ?? null;

        if (!empty($_FILES['sia_licence_doc']['name'])) {
            move_uploaded_file($_FILES['sia_licence_doc']['tmp_name'], $userFolderFs . "sia_licence.png");
            $siaPath = $userFolderDb . "sia_licence.png";
        }

        $stmt = $conn->prepare("
            INSERT INTO sia_licence
            (user_id, sia_licence_doc, sia_licence_number, sia_licence_expiry,
             sia_licence_expiry_3m, sia_licence_expiry_2m, sia_licence_expiry_1m)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $siaExpiry3 = $siaExpiry ? addMonths($siaExpiry, 3) : null;
        $siaExpiry2 = $siaExpiry ? addMonths($siaExpiry, 2) : null;
        $siaExpiry1 = $siaExpiry ? addMonths($siaExpiry, 1) : null;

        $stmt->bind_param(
            "issssss",
            $userId,
            $siaPath,
            $siaNo,
            $siaExpiry,
            $siaExpiry3,
            $siaExpiry2,
            $siaExpiry1
        );

        $stmt->execute();
        $stmt->close();

        /* ==========================
           SHARE CODE + FIRST AID
        ========================== */
        $sharePath = $firstAidPath = null;
        $shareNo = $_POST['share_code_number'] ?? null;
        $shareExpiry = $_POST['share_code_expiry'] ?? null;
        $firstAidExpiry = $_POST['first_aid_expiry'] ?? null;

        if (!empty($_FILES['share_code_doc']['name'])) {
            move_uploaded_file($_FILES['share_code_doc']['tmp_name'], $userFolderFs . "share_code.png");
            $sharePath = $userFolderDb . "share_code.png";
        }

        if (!empty($_FILES['first_aid_doc']['name'])) {
            move_uploaded_file($_FILES['first_aid_doc']['tmp_name'], $userFolderFs . "first_aid.png");
            $firstAidPath = $userFolderDb . "first_aid.png";
        }

        $stmt = $conn->prepare("
            INSERT INTO sharecode_first_aid
            (user_id, share_code_doc, share_code_number, share_code_expiry,
             share_code_expiry_15d, first_aid_doc, first_aid_expiry, first_aid_expiry_1m)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $shareGraceExpiry = $shareExpiry ? addDays($shareExpiry, 15) : null;
        $firstAidGraceExpiry = $firstAidExpiry ? addMonths($firstAidExpiry, 1) : null;


        $stmt->bind_param(
            "isssssss",
            $userId,
            $sharePath,
            $shareNo,
            $shareExpiry,
            $shareGraceExpiry,
            $firstAidPath,
            $firstAidExpiry,
            $firstAidGraceExpiry
        );

        $stmt->execute();
        $stmt->close();

        $conn->commit();
        $success = "Registration completed successfully!";

    } catch (Exception $e) {
        $conn->rollback();
        $error = $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>User Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-5xl mx-auto bg-white p-6 shadow rounded">

        <h2 class="text-2xl font-bold mb-4">User Registration</h2>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" onsubmit="return submitForm();">


            <!-- USER DETAILS -->
            <label class="font-semibold">Full Name</label>
            <input type="text" name="name" class="w-full border p-2 mb-3" required>

            <label class="font-semibold">Email</label>
            <input type="email" name="email" class="w-full border p-2 mb-3" required>

            <label class="font-semibold">Contact</label>
            <input type="text" name="contact" class="w-full border p-2 mb-3" required>

            <label class="font-semibold">Address</label>
            <textarea name="address" class="w-full border p-2 mb-4" required></textarea>

            <hr class="my-6">

            <!-- AUTHENTICATION DOC SIGN -->
            <h3 class="text-lg font-semibold mb-2">Authentication Document</h3>

            <div class="border mb-2 overflow-auto">
                <canvas id="authCanvas"></canvas>
            </div>


            <input type="hidden" name="auth_signed_image" id="auth_signed_image">

            <hr class="my-6">

            <!-- SCREENING DOC SIGN -->
            <h3 class="text-lg font-semibold mb-2">Screening Document</h3>

            <div class="border mb-2 overflow-auto">
                <canvas id="screenCanvas"></canvas>
            </div>

            <input type="hidden" name="screen_signed_image" id="screen_signed_image">

            <hr class="my-6">

            <div class="grid gap-4">
                <h3 class="text-lg font-semibold mb-2">ACT Certificates</h3>

                <div class="grid grid-cols-2 gap-6">

                    <!-- ACT BLUE -->
                    <div class="border p-4 rounded">
                        <h4 class="font-semibold mb-2">ACT Blue</h4>

                        <input type="file" accept="image/*" name="act_blue_doc" class="w-full border p-2"
                            data-type="blue" onchange="handleDocumentOCR(this)">

                        <img class="act-preview hidden mt-3 max-h-72 border mx-auto" />
                        <input type="hidden" name="act_blue_expiry">

                        <div class="act-result hidden mt-3 text-sm">
                            <p><strong>Completion Date:</strong> <span class="act-issue"></span></p>
                            <p><strong>Expiry Date (+1 year):</strong> <span class="act-expiry"></span></p>
                        </div>
                    </div>

                    <!-- ACT ORANGE -->
                    <div class="border p-4 rounded">
                        <h4 class="font-semibold mb-2">ACT Orange</h4>

                        <input type="file" accept="image/*" name="act_orange_doc" class="w-full border p-2"
                            data-type="orange" onchange="handleDocumentOCR(this)">

                        <img class="act-preview hidden mt-3 max-h-72 border mx-auto" />
                        <input type="hidden" name="act_orange_expiry">

                        <div class="act-result hidden mt-3 text-sm">
                            <p><strong>Completion Date:</strong> <span class="act-issue"></span></p>
                            <p><strong>Expiry Date (+1 year):</strong> <span class="act-expiry"></span></p>
                        </div>
                    </div>

                </div>


                <div class="grid grid-cols-2 gap-6">

                    <!-- ACT BLUE -->
                    <h3 class="text-lg font-semibold mt-6 mb-2">SIA Licence</h3>

                    <div class="border p-4 rounded max-w-xl">

                        <input type="file" accept="image/*" name="sia_licence_doc" class="w-full border p-2"
                            data-type="sia" onchange="handleDocumentOCR(this)">

                        <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />
                        <input type="hidden" name="sia_licence_number">
                        <input type="hidden" name="sia_licence_expiry">

                        <div class="doc-result hidden mt-3 text-sm">
                            <p><strong>Licence Number:</strong> <span class="sia-licence"></span></p>
                            <p><strong>Expiry Date:</strong> <span class="sia-expiry"></span></p>
                        </div>

                    </div>
                    <h3 class="text-lg font-semibold mt-6 mb-2">Right to Work – Share Code</h3>

                    <div class="border p-4 rounded max-w-xl">

                        <input type="file" accept="image/*" name="share_code_doc" class="w-full border p-2"
                            data-type="share" onchange="handleDocumentOCR(this)">

                        <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />
                        <input type="hidden" name="share_code_number">
                        <input type="hidden" name="share_code_expiry">

                        <div class="doc-result hidden mt-3 text-sm">
                            <p><strong>Share Code:</strong> <span class="share-code"></span></p>
                            <p><strong>Valid Until:</strong> <span class="share-expiry"></span></p>
                        </div>

                    </div>

                    <h3 class="text-lg font-semibold mt-6 mb-2">First Aid at Work Certificate</h3>

                    <div class="border p-4 rounded max-w-xl">

                        <input type="file" accept="image/*" name="first_aid_doc" class="w-full border p-2"
                            data-type="firstaid" onchange="handleDocumentOCR(this)">

                        <img class="doc-preview hidden mt-3 max-h-72 border mx-auto" />
                        <input type="hidden" name="first_aid_expiry">

                        <div class="doc-result hidden mt-3 text-sm">
                            <p><strong>Awarded Date:</strong> <span class="fa-issue"></span></p>
                            <p><strong>Expiry Date:</strong> <span class="fa-expiry"></span></p>
                        </div>

                    </div>




                    <!-- LOADER -->
                    <div id="ocrLoader"
                        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded shadow">
                            Extracting date…
                        </div>
                    </div>

                </div>

                <hr class="my-6">

                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">
                    Register & Save
                </button>

        </form>


    </div>


    <script>
        function showLoader() {
            document.getElementById("ocrLoader").classList.remove("hidden");
        }
        function hideLoader() {
            document.getElementById("ocrLoader").classList.add("hidden");
        }

        function toDataURL(file) {
            return new Promise(resolve => {
                const r = new FileReader();
                r.onload = e => resolve(e.target.result);
                r.readAsDataURL(file);
            });
        }

        async function handleDocumentOCR(input) {

            const file = input.files[0];
            if (!file) return;

            const type = input.dataset.type;
            const container = input.closest("div");

            const preview =
                container.querySelector(".doc-preview") ||
                container.querySelector(".act-preview");

            const resultBox =
                container.querySelector(".doc-result") ||
                container.querySelector(".act-result");

            showLoader();

            /* =====================
               IMAGE PREVIEW
            ===================== */
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

                /* =====================
                   ACT (BLUE / ORANGE)
                ===================== */
                if (type === 'blue' || type === 'orange') {

                    const dateMatch =
                        t.match(/\b([0-3]?\d)[./]([0-1]?\d)[./](20\d{2})\b/);

                    if (!dateMatch) {
                        alert("ACT completion date not detected");
                        return;
                    }

                    const issueDate = new Date(
                        `${dateMatch[3]}-${dateMatch[2]}-${dateMatch[1]}`
                    );

                    const expiryDate = new Date(issueDate);
                    expiryDate.setFullYear(expiryDate.getFullYear() + 1);

                    const expiryISO = expiryDate.toISOString().split("T")[0];

                    container.querySelector(".act-issue").innerText =
                        issueDate.toLocaleDateString("en-GB");

                    container.querySelector(".act-expiry").innerText =
                        expiryDate.toLocaleDateString("en-GB");

                    /* ✅ SAVE TO HIDDEN INPUT */
                    container.querySelector(
                        `input[name="act_${type}_expiry"]`
                    ).value = expiryISO;

                    resultBox.classList.remove("hidden");
                }

                /* =====================
                   SIA LICENCE
                ===================== */
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

                    const expiryISO =
                        new Date(`${day[1]} ${month[1]} ${year[1]}`)
                            .toISOString()
                            .split("T")[0];

                    container.querySelector(".sia-licence").innerText =
                        licenceMatch[0];

                    container.querySelector(".sia-expiry").innerText =
                        expiryISO;

                    /* ✅ SAVE TO HIDDEN INPUTS */
                    container.querySelector(
                        "input[name='sia_licence_number']"
                    ).value = licenceMatch[0];

                    container.querySelector(
                        "input[name='sia_licence_expiry']"
                    ).value = expiryISO;

                    resultBox.classList.remove("hidden");
                }

                /* =====================
                   SHARE CODE
                ===================== */
                if (type === 'share') {

                    const codeMatch =
                        t.match(/\b[A-Z0-9]{3}\s[A-Z0-9]{3}\s[A-Z0-9]{3}\b/);

                    const expiryMatch =
                        t.match(/\b([0-3]?\d)\s(JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER)\s(20\d{2})\b/);

                    if (!codeMatch || !expiryMatch) {
                        alert("Share code details not detected");
                        return;
                    }

                    const expiryDate =
                        new Date(`${expiryMatch[1]} ${expiryMatch[2]} ${expiryMatch[3]}`);

                    const expiryISO =
                        expiryDate.toISOString().split("T")[0];

                    container.querySelector(".share-code").innerText =
                        codeMatch[0];

                    container.querySelector(".share-expiry").innerText =
                        expiryDate.toLocaleDateString("en-GB");

                    /* ✅ SAVE TO HIDDEN INPUTS */
                    container.querySelector(
                        "input[name='share_code_number']"
                    ).value = codeMatch[0];

                    container.querySelector(
                        "input[name='share_code_expiry']"
                    ).value = expiryISO;

                    resultBox.classList.remove("hidden");
                }

                /* =====================
                   FIRST AID AT WORK
                ===================== */
                if (type === 'firstaid') {

                    const dateMatch =
                        t.match(/\b([0-3]?\d)\s(DECEMBER|JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER)\s(20\d{2})\b/);

                    if (!dateMatch) {
                        alert("First Aid awarded date not detected");
                        return;
                    }

                    const issueDate =
                        new Date(`${dateMatch[1]} ${dateMatch[2]} ${dateMatch[3]}`);

                    const expiryDate = new Date(issueDate);
                    expiryDate.setFullYear(expiryDate.getFullYear() + 1);

                    const expiryISO =
                        expiryDate.toISOString().split("T")[0];

                    container.querySelector(".fa-issue").innerText =
                        issueDate.toLocaleDateString("en-GB");

                    container.querySelector(".fa-expiry").innerText =
                        expiryDate.toLocaleDateString("en-GB");

                    /* ✅ SAVE TO HIDDEN INPUT */
                    container.querySelector(
                        "input[name='first_aid_expiry']"
                    ).value = expiryISO;

                    resultBox.classList.remove("hidden");
                }

            } catch (err) {
                console.error(err);
                alert("OCR failed. Please upload a clearer image.");
            } finally {
                hideLoader();
            }
        }

    </script>

    <script>
        function isPast(dateStr) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return new Date(dateStr) < today;
        }

        function validateDocuments() {

            const requiredFields = [
                { name: "act_blue_expiry", label: "ACT Blue Certificate" },
                { name: "act_orange_expiry", label: "ACT Orange Certificate" },
                { name: "sia_licence_number", label: "SIA Licence Number" },
                { name: "sia_licence_expiry", label: "SIA Licence Expiry" },
                { name: "share_code_number", label: "Share Code" },
                // { name: "share_code_expiry", label: "Share Code Expiry" },
                { name: "first_aid_expiry", label: "First Aid Certificate" }
            ];

            for (const field of requiredFields) {
                const el = document.querySelector(`[name="${field.name}"]`);
                if (!el || !el.value) {
                    alert(`${field.label} is missing or OCR failed`);
                    return false;
                }

                if (field.name.includes("expiry") && isPast(el.value)) {
                    alert(`${field.label} is expired`);
                    return false;
                }
            }

            return true;
        }
    </script>


    <script>
        const nameInput = document.querySelector("input[name='name']");


        // =====================
        // AUTHENTICATION CANVAS
        // =====================
        const authCanvas = document.getElementById('authCanvas');
        const authCtx = authCanvas.getContext('2d');
        const authPad = new SignaturePad(authCanvas);

        const authImg = new Image();
        authImg.src = 'document.png';
        authImg.onload = () => {
            authCanvas.width = authImg.width;
            authCanvas.height = authImg.height;
            authCtx.drawImage(authImg, 0, 0);
        };


        // =====================
        // SCREENING CANVAS
        // =====================
        const screenCanvas = document.getElementById('screenCanvas');
        const screenCtx = screenCanvas.getContext('2d');
        const screenPad = new SignaturePad(screenCanvas);

        const screenImg = new Image();
        screenImg.src = 'document.png';
        screenImg.onload = () => {
            screenCanvas.width = screenImg.width;
            screenCanvas.height = screenImg.height;
            screenCtx.drawImage(screenImg, 0, 0);
        };


        // =====================
        // SUBMIT
        // =====================
        function submitForm() {

            if (authPad.isEmpty() || screenPad.isEmpty()) {
                alert("Please sign both documents.");
                return false;
            }
            if (!validateDocuments()) {
                return false;
            }

            const name = nameInput.value.trim();
            if (!name) {
                alert("Enter name");
                return false;
            }

            drawName(authCtx, authCanvas, name);
            drawName(screenCtx, screenCanvas, name);

            document.getElementById('auth_signed_image').value =
                authCanvas.toDataURL('image/png');

            document.getElementById('screen_signed_image').value =
                screenCanvas.toDataURL('image/png');

            return true;
        }


        function drawName(ctx, canvas, name) {
            const x = 80;
            const y = canvas.height - 150;

            ctx.font = "14px Arial";
            ctx.fillStyle = "black";
            ctx.fillText("Full Name:", x, y);

            ctx.font = "600 16px Arial";
            ctx.fillText(name, x + 90, y);
        }

        function previewImage(input, id) {
            const file = input.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(id);
                img.src = e.target.result;
                img.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }


    </script>
    <script src="https://js.puter.com/v2/"></script>

</body>

</html>