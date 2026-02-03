<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Banke Bihari Dress Collection</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Theme -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#000000',
                        muted: '#6b7280'
                    }
                }
            }
        }
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-white text-black">

<!-- ================= NAVBAR ================= -->
<header class="sticky top-0 z-50 backdrop-blur-lg bg-white/70 border-b border-gray-200">
    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <a href="index.php" class="leading-tight">
            <div class="text-2xl font-extrabold tracking-wide">
                Banke Bihari
            </div>
            <div class="text-xs text-gray-500 tracking-widest">
                Dress Collection
            </div>
        </a>

        <!-- DESKTOP MENU -->
        <div class="hidden md:flex items-center space-x-10 text-sm font-medium">
            <a href="index.php" class="hover:text-gray-500 transition">Home</a>
            <a href="products.php" class="hover:text-gray-500 transition">Products</a>
            <a href="favourites.php" class="hover:text-gray-500 transition">Favourites</a>
            <a href="about.php" class="hover:text-gray-500 transition">About</a>
            <a href="contact.php" class="hover:text-gray-500 transition">Contact</a>
        </div>

        <!-- RIGHT ACTIONS -->
        <div class="flex items-center gap-4">

            <!-- CART -->
            <a href="cart.php"
               class="hidden sm:inline-block border border-black px-5 py-2 text-sm font-semibold
                      hover:bg-black hover:text-white transition">
                Cart
            </a>

            <!-- MOBILE MENU BUTTON -->
            <button id="menuBtn"
                    class="md:hidden border border-black p-2 rounded hover:bg-black hover:text-white transition">
                ☰
            </button>
        </div>
    </nav>

    <!-- ================= MOBILE MENU ================= -->
    <div id="mobileMenu"
         class="hidden md:hidden bg-white/90 backdrop-blur-xl border-t border-gray-200">

        <div class="px-6 py-6 space-y-4 text-sm font-medium">
            <a href="index.php" class="block hover:text-gray-500">Home</a>
            <a href="products.php" class="block hover:text-gray-500">Products</a>
            <a href="favourites.php" class="block hover:text-gray-500">Favourites</a>
            <a href="about.php" class="block hover:text-gray-500">About</a>
            <a href="contact.php" class="block hover:text-gray-500">Contact</a>

            <a href="cart.php"
               class="inline-block mt-4 border border-black px-5 py-2
                      hover:bg-black hover:text-white transition">
                Cart
            </a>
        </div>
    </div>
</header>

<!-- MOBILE MENU SCRIPT -->
<script>
$(function () {
    $('#menuBtn').on('click', function () {
        $('#mobileMenu').slideToggle(200);
    });
});
</script>
