<?php
require_once './../session.php';
require_once './../db.php';

/* ===============================
   AUTO TRIGGER EXPIRY CHECK
   (RUNS ONCE PER DAY ONLY)
================================ */
// require_once './../document_expiry_mail.php';


if (
    !isset($_SESSION['user_id']) ||
    !in_array($_SESSION['user_role'], ['admin', 'owner'])
) {
    header("Location: ../login.php");
    exit;
}

$role = $_SESSION['user_role'];
?>


<?php if (isset($_GET['inactive'])): ?>
    <div class="bg-red-100 text-red-700 p-3 text-center">
        Your account is inactive. Contact administrator.
    </div>
<?php endif; ?>

<nav class="bg-gray-900 text-white px-6 py-4 flex justify-between items-center">

    <!-- LEFT -->

    <?php if ($role === 'admin'): ?>
        <!-- ADMIN ONLY -->
        <div class="text-xl font-bold">
            Admin Dashboard
        </div>
    <?php endif; ?>

    <?php if ($role === 'owner'): ?>
        <!-- OWNER ONLY -->
        <div class="text-xl font-bold">
            Owner Dashboard
        </div>
    <?php endif; ?>

    <!-- RIGHT -->
    <div class="space-x-6 flex items-center text-sm">

        <a href="index.php" class="hover:text-gray-300">
            Attendance
        </a>

        <?php if ($role === 'admin'): ?>
            <!-- ADMIN ONLY -->
            <a href="employee.php" class="hover:text-gray-300">
                Employees
            </a>
        <?php endif; ?>

        <?php if ($role === 'owner'): ?>
            <!-- OWNER ONLY -->
            <a href="users.php" class="hover:text-gray-300">
                All Users
            </a>
        <?php endif; ?>

        <a href="payment.php" class="hover:text-gray-300">
            Payments
        </a>
        <form method="POST" action="./../download_folder.php">
    <button
        type="submit"
        class="px-4 py-2 bg-slate-700 text-white rounded-md text-sm
               hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500">
        Download All User Documents
    </button>
</form>



        <a href="./../logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">
            Logout
        </a>

    </div>

</nav>