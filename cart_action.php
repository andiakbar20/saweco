<?php
require 'config.php';

$action = $_GET['action'] ?? '';
$product_id = $_POST['product_id'] ?? $_GET['id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Aksi: Tambah ke Keranjang
if ($action == 'add' && $product_id > 0) {
    if (isset($_SESSION['cart'][$product_id])) {
        // Jika produk sudah ada, tambahkan jumlahnya
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        // Jika produk baru, tambahkan ke keranjang
        $_SESSION['cart'][$product_id] = $quantity;
    }
    // Redirect kembali ke halaman produk atau keranjang
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'cart.php'));
    exit;
}

// Aksi: Hapus dari Keranjang
if ($action == 'remove' && $product_id > 0) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: cart.php");
    exit;
}

// Aksi: Kosongkan Keranjang (akan digunakan setelah checkout)
if ($action == 'clear') {
    $_SESSION['cart'] = [];
    header("Location: home.php");
    exit;
}

// Jika tidak ada aksi yang cocok
header("Location: home.php");
exit;
?>
