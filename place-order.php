<?php
include 'includes/header.php';
include 'config/db.php';

$db = getDB();

/* ================= CHECK CART ================= */
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

/* ================= FORM DATA ================= */
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$city    = trim($_POST['city'] ?? '');
$address = trim($_POST['address'] ?? '');

if ($name === '' || $email === '' || $phone === '' || $city === '' || $address === '') {
    die("Invalid order data");
}

/* ================= USER ================= */
$stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows) {
    $user_id = $res->fetch_assoc()['id'];
} else {
    $stmt = $db->prepare(
        "INSERT INTO users (name, email, phone, city, address)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssss", $name, $email, $phone, $city, $address);
    $stmt->execute();
    $user_id = $stmt->insert_id;
}

/* ================= CALCULATE TOTAL ================= */
$total_amount = 0;
$order_items  = [];

foreach ($_SESSION['cart'] as $pid => $item) {

    $qty  = $item['qty'];
    $size = $item['size'];

    $product = $db->query(
        "SELECT title, price FROM products WHERE id = $pid"
    )->fetch_assoc();

    if (!$product) continue;

    $total_amount += $product['price'] * $qty;

    $order_items[] = [
        'pid'   => $pid,
        'title' => $product['title'],
        'qty'   => $qty,
        'size'  => $size,
        'price' => $product['price']
    ];
}

/* ================= CREATE ORDER ================= */
$order_number = 'BB' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);

$stmt = $db->prepare(
    "INSERT INTO orders (user_id, order_number, total_amount, status)
     VALUES (?, ?, ?, 'pending')"
);
$stmt->bind_param("isd", $user_id, $order_number, $total_amount);
$stmt->execute();

$order_id = $stmt->insert_id;

/* ================= INSERT ORDER ITEMS (WITH SIZE) ================= */
$stmt = $db->prepare(
    "INSERT INTO order_items (order_id, product_id, quantity, price, size)
     VALUES (?, ?, ?, ?, ?)"
);

foreach ($order_items as $i) {
    $stmt->bind_param(
        "iiids",
        $order_id,
        $i['pid'],
        $i['qty'],
        $i['price'],
        $i['size']
    );
    $stmt->execute();
}

/* ================= CLEAR CART ================= */
unset($_SESSION['cart']);

/* ================= WHATSAPP ================= */
$whatsapp_number = "919718751020";

$msg  = "🛍️ *New Order – Banke Bihari Dress Collection*%0A%0A";
$msg .= "*Order ID:* $order_number%0A";
$msg .= "*Name:* $name%0A";
$msg .= "*Phone:* $phone%0A";
$msg .= "*City:* $city%0A";
$msg .= "*Address:* $address%0A%0A";
$msg .= "*Items:*%0A";

foreach ($order_items as $i) {
    $msg .= "- {$i['title']} ({$i['size']}) × {$i['qty']}%0A";
}

$msg .= "%0A*Total:* ₹" . number_format($total_amount, 2);

header("Location: https://wa.me/$whatsapp_number?text=$msg");
exit;
