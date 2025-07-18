<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
// Memastikan hanya admin yang bisa mengakses file ini
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Mengambil aksi dan ID dari URL
$action = $_GET['action'] ?? '';
$order_id = $_GET['id'] ?? 0;

// =======================================================
// AKSI: MENANDAI PESANAN SEBAGAI LUNAS (PAID)
// =======================================================
if ($action == 'mark_paid' && $order_id > 0) {
    
    // Siapkan query untuk mengubah order_status menjadi 'Paid'
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'Paid' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, kembali ke halaman pesanan dengan pesan sukses
        header("Location: view_orders.php?status=update_success");
    } else {
        // Jika gagal, kembali dengan pesan error
        header("Location: view_orders.php?status=update_error");
    }
    $stmt->close();
    exit;
}

// =======================================================
// AKSI BARU: MEMBATALKAN PESANAN
// =======================================================
if ($action == 'cancel_order' && $order_id > 0) {
    
    // Siapkan query untuk mengubah order_status menjadi 'Cancelled'
    $stmt = $conn->prepare("UPDATE orders SET order_status = 'Cancelled' WHERE id = ?");
    $stmt->bind_param("i", $order_id);
    
    // Eksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, kembali ke halaman pesanan dengan pesan sukses
        header("Location: view_orders.php?status=cancel_success");
    } else {
        // Jika gagal, kembali dengan pesan error
        header("Location: view_orders.php?status=cancel_error");
    }
    $stmt->close();
    exit;
}


// Jika tidak ada aksi yang cocok, redirect ke halaman utama admin
header("Location: admin_panel.php");
exit;
?>
