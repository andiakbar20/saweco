<?php
require 'config.php';

// Pastikan request adalah POST dan keranjang tidak kosong
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
    header("Location: home.php");
    exit;
}

// 1. Ambil data dari form
$customer_name = trim($_POST['customer_name']);
$customer_email = trim($_POST['customer_email']);
$customer_phone = trim($_POST['customer_phone']);

$cart = $_SESSION['cart'];
$total_price = 0;

// 2. Hitung total harga dari produk di keranjang
$product_ids = array_keys($cart);
if (!empty($product_ids)) {
    $ids_string = implode(',', array_map('intval', $product_ids));
    $result = $conn->query("SELECT id, price FROM products WHERE id IN ($ids_string)");
    $products_data = [];
    while ($row = $result->fetch_assoc()) {
        $products_data[$row['id']] = $row['price'];
    }
    foreach ($cart as $id => $quantity) {
        if (isset($products_data[$id])) {
            $total_price += $products_data[$id] * $quantity;
        }
    }
}

// 3. Simpan pesanan ke database dengan status "Pending"
$payment_method = "QRIS (Manual)"; // Set metode pembayaran default
$stmt_order = $conn->prepare("INSERT INTO orders (customer_name, customer_email, customer_phone, total_price, payment_method, order_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
$stmt_order->bind_param("sssis", $customer_name, $customer_email, $customer_phone, $total_price, $payment_method);
$stmt_order->execute();
$order_id = $stmt_order->insert_id; // Ambil ID pesanan yang baru dibuat

// 4. Simpan item-item pesanan ke tabel order_items
$stmt_items = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cart as $id => $quantity) {
    if (isset($products_data[$id])) {
        $price = $products_data[$id];
        $stmt_items->bind_param("iiid", $order_id, $id, $quantity, $price);
        $stmt_items->execute();
    }
}

// 5. Kosongkan keranjang belanja setelah pesanan dibuat
unset($_SESSION['cart']);

// 6. Arahkan ke halaman pembayaran dengan ID pesanan
header("Location: payment.php?order_id=" . $order_id);
exit;
?>
