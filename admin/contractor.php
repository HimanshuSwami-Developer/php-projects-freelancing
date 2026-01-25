<?php
require_once './../session.php';
require_once './../db.php';

$conn = getDB();

/* ===============================
   AUTH CHECK
================================ */
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['admin', 'owner'])) {
    header("Location: ../login.php");
    exit;
}

/* ===============================
   EXPORT TO EXCEL
================================ */
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="contractors.csv"');

    $out = fopen('php://output', 'w');
    fputcsv($out, ['Name', 'Email', 'Contact', 'Pay Amount', 'Pay Date']);

    $res = $conn->query("
        SELECT contractor_name,email,contact_number,pay_amount,pay_date
        FROM contractors
        ORDER BY pay_date DESC
    ");
    while ($r = $res->fetch_assoc()) {
        $r['pay_date'] = date('d-m-Y', strtotime($r['pay_date']));
        fputcsv($out, $r);
    }

    fclose($out);
    exit;
}

/* ===============================
   ADD / UPDATE CONTRACTOR
================================ */
if (isset($_POST['save_contractor'])) {

    $id = $_POST['contractor_id'] ?: null;
    $name = $_POST['contractor_name'];
    $email = strtolower(trim($_POST['email']));
    $phone = $_POST['contact_number'];
    $amount = $_POST['pay_amount'];
    $date = $_POST['pay_date'];

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/Upload/contractors/";
    $uploadDb = "/Upload/contractors/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $slipPath = null;
    if (!empty($_FILES['pay_slip']['name'])) {
        $safeEmail = str_replace(['/', '\\'], '_', $email);
        $fileName = $safeEmail . ".png";
        move_uploaded_file($_FILES['pay_slip']['tmp_name'], $uploadDir . $fileName);
        $slipPath = $uploadDb . $fileName;
    }

    if ($id) {
        $stmt = $conn->prepare("
            UPDATE contractors SET
            contractor_name=?, email=?, contact_number=?, pay_amount=?, pay_date=?,
            pay_slip = COALESCE(?, pay_slip)
            WHERE id=?
        ");
        $stmt->bind_param(
            "sssdsii",
            $name,
            $email,
            $phone,
            $amount,
            $date,
            $slipPath,
            $id
        );
    } else {
        $stmt = $conn->prepare("
            INSERT INTO contractors
            (contractor_name,email,contact_number,pay_amount,pay_slip,pay_date)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt->bind_param(
            "sssiss",
            $name,
            $email,
            $phone,
            $amount,
            $slipPath,
            $date
        );
    }

    $stmt->execute();
    $stmt->close();
    header("Location: contractor.php");
    exit;
}

/* ===============================
   DELETE CONTRACTOR
================================ */
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $res = $conn->query("SELECT pay_slip FROM contractors WHERE id=$id")->fetch_assoc();
    if (!empty($res['pay_slip'])) {
        $fs = $_SERVER['DOCUMENT_ROOT'] . $res['pay_slip'];
        if (file_exists($fs))
            unlink($fs);
    }

    $conn->query("DELETE FROM contractors WHERE id=$id");
    header("Location: contractor.php");
    exit;
}

/* ===============================
   FETCH DATA
================================ */
$contractors = $conn->query("
    SELECT * FROM contractors
    ORDER BY pay_date DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contractor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.25s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100">

    <?php include 'navbar.php'; ?>

    <div class="max-w-7xl mx-auto mt-10 p-4">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Contractor Payments</h1>
            <div class="flex gap-2">
                <a href="contractor.php?export=excel" class="bg-green-600 text-white px-4 py-2 rounded">
                    Export Excel
                </a>
                <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Add Contractor
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="w-full border text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Email</th>
                        <th class="border p-2">Contact</th>
                        <th class="border p-2">Pay Amount</th>
                        <th class="border p-2">Pay Date</th>
                        <th class="border p-2">Pay Slip</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contractors as $c): ?>
                        <tr class="text-center">
                            <td class="border p-2"><?= htmlspecialchars($c['contractor_name']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($c['email']) ?></td>
                            <td class="border p-2"><?= htmlspecialchars($c['contact_number']) ?></td>
                            <td class="border p-2 font-semibold">£<?= number_format($c['pay_amount'], 2) ?></td>
                            <td class="border p-2"><?= $c['pay_date'] ?></td>
                            <td class="border p-2">
                                <?php if ($c['pay_slip']): ?>
                                    <button onclick="openImage('<?= $c['pay_slip'] ?>')"
                                        class="text-blue-600 underline">View</button>
                                <?php else: ?>—<?php endif; ?>
                            </td>
                            <td class="border p-2 space-x-2">
                                <button onclick='editContractor(<?= json_encode($c) ?>)'
                                    class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                                <a href="?delete=<?= $c['id'] ?>" onclick="return confirm('Delete contractor?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div id="modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-fadeIn">

            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between">
                <h3 class="text-white font-semibold">Contractor Payment</h3>
                <button onclick="closeModal()" class="text-white">✕</button>
            </div>

            <form method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <input type="hidden" name="contractor_id" id="cid">

                <input id="cname" name="contractor_name" placeholder="Contractor Name" required
                    class="w-full border p-2 rounded">
                <input id="cemail" name="email" type="email" placeholder="Email" required
                    class="w-full border p-2 rounded">
                <input id="cphone" name="contact_number" placeholder="Contact Number" class="w-full border p-2 rounded">

                <div class="grid grid-cols-2 gap-3">
                    <input id="camount" name="pay_amount" type="number" step="0.01" placeholder="Pay Amount" required
                        class="border p-2 rounded">
                    <input id="cdate" name="pay_date" type="date" required class="border p-2 rounded">
                </div>

                <input type="file" name="pay_slip" accept="image/*" class="w-full border p-2 rounded">

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()" class="border px-4 py-2 rounded">Cancel</button>
                    <button name="save_contractor" class="bg-blue-600 text-white px-5 py-2 rounded">Save</button>
                </div>
            </form>

        </div>
    </div>

    <!-- IMAGE MODAL -->
    <div id="imgModal" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded relative">
            <button onclick="closeImage()"
                class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded">✕</button>
            <img id="img" class="max-h-[80vh]">
        </div>
    </div>

    <script>
        function openModal() { modal.classList.remove('hidden'); }
        function closeModal() { modal.classList.add('hidden'); }

        function editContractor(c) {
            openModal();
            cid.value = c.id;
            cname.value = c.contractor_name;
            cemail.value = c.email;
            cphone.value = c.contact_number;
            camount.value = c.pay_amount;
            cdate.value = c.pay_date;
        }

        function openImage(src) { img.src = src; imgModal.classList.remove('hidden'); }
        function closeImage() { img.src = ''; imgModal.classList.add('hidden'); }
    </script>

</body>

</html>