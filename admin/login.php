<?php
session_start();

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <!-- Tailwind CDN (FIX) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<form method="post" class="bg-white p-10 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-6 text-center">Admin Login</h2>

    <?php if ($error): ?>
        <p class="text-red-500 mb-4 text-center"><?= $error ?></p>
    <?php endif; ?>

    <input type="text" name="username" placeholder="Username"
           class="border w-full px-4 py-3 mb-4 focus:outline-none focus:ring-2 focus:ring-black">

    <input type="password" name="password" placeholder="Password"
           class="border w-full px-4 py-3 mb-6 focus:outline-none focus:ring-2 focus:ring-black">

    <button class="w-full bg-black text-white py-3 font-semibold
                   hover:bg-gray-800 transition">
        Login
    </button>
</form>

</body>
</html>
