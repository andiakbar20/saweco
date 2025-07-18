<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

$action = $_GET['action'] ?? '';

// Aksi: Memperbarui Pengguna
if ($action == 'update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        // Jika password diisi, update password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET full_name=?, username=?, email=?, password=?, role=? WHERE id=?");
        $stmt->bind_param("sssssi", $full_name, $username, $email, $password, $role, $id);
    } else {
        // Jika password kosong, jangan update password
        $stmt = $conn->prepare("UPDATE users SET full_name=?, username=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("ssssi", $full_name, $username, $email, $role, $id);
    }
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php?status=success_update");
    exit;
}

// Aksi: Menghapus Pengguna
if ($action == 'delete') {
    $id = $_GET['id'];
    
    // Pencegahan agar admin tidak bisa menghapus dirinya sendiri
    if ($id == $_SESSION['user_id']) {
        header("Location: manage_users.php?status=error_self_delete");
        exit;
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php?status=success_delete");
    exit;
}

// Jika tidak ada aksi yang cocok
header("Location: manage_users.php");
exit;
?>
