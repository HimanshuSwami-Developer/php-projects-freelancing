<?php include 'auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-black text-white p-6">
    <h2 class="text-2xl font-bold mb-10">Admin Panel</h2>

    <nav class="space-y-4">
        <a href="dashboard.php" class="block hover:text-gray-300">Dashboard</a>
        <a href="product-add.php" class="block hover:text-gray-300">Add Product</a>
        <a href="products.php" class="block hover:text-gray-300">Products</a>
        <a href="orders.php" class="block hover:text-gray-300">Orders</a>
        <a href="logout.php" class="block text-red-400 hover:text-red-300">Logout</a>
    </nav>
</aside>

<!-- CONTENT -->
<main class="flex-1 p-10 bg-white">
