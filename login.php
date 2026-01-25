<?php
require_once './session.php';
require_once './db.php';

$conn = getDB();

/* ===============================
   ALREADY LOGGED IN → REDIRECT
================================ */
if (isset($_SESSION['user_id'])) {
    if (in_array($_SESSION['user_role'], ['admin', 'owner'])) {
        header("Location: ./admin/index.php");
    } else {
        header("Location: ./user/index.php");
    }
    exit;
}

$error = "";

/* ===============================
   LOGIN PROCESS
================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("
        SELECT id, name, password, role, is_active
        FROM users
        WHERE email = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$user) {
        $error = "User not found";
    }
    elseif ((int)$user['is_active'] === 0) {
        // ❌ BLOCK INACTIVE USER
        $error = "Your account is inactive. Please contact administrator.";
    }
    elseif ($password === $user['password']) {

        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['email']     = $user['email'];

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <script>
                localStorage.setItem("user_role", "<?= $user['role'] ?>");
                localStorage.setItem("user_name", "<?= htmlspecialchars($user['name']) ?>");
                localStorage.setItem("user_id", "<?= $user['id'] ?>");
                localStorage.setItem("email", "<?= $user['email'] ?>");
            </script>
        </head>
        </html>
        <?php

        if (in_array($user['role'], ['admin', 'owner'])) {
            header("Location: ./admin/index.php");
        } else {
            header("Location: ./user/index.php");
        }
        exit;

    } else {
        $error = "Invalid password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-slate-100 flex items-center justify-center font-sans">

<div class="w-full max-w-md">

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-8">

        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold text-slate-800">
                System Login
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Enter your credentials to access your account
            </p>
        </div>

        <?php if (isset($_GET['inactive'])): ?>
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-700 text-sm text-center">
                Your account has been deactivated.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-700 text-sm text-center">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Email Address
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    class="w-full px-3 py-2 border border-slate-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-3 py-2 border border-slate-300 rounded-md
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           focus:border-blue-500 transition"
                >
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-2.5 bg-blue-600 text-white text-sm font-medium rounded-md
                       hover:bg-blue-700 transition focus:outline-none focus:ring-2
                       focus:ring-blue-500 focus:ring-offset-2"
            >
                Sign In
            </button>

        </form>

        <!-- Footer -->
        <div class="mt-6 text-center text-sm text-slate-500">
            Don’t have an account?
            <a href="register.php" class="text-blue-600 hover:underline font-medium">
                Request Access
            </a>
        </div>

    </div>

    <!-- Footer Text -->
    <p class="text-center text-xs text-slate-400 mt-6">
        © <?= date('Y') ?> Your Company Name. All rights reserved.
    </p>

</div>

</body>

</html>
