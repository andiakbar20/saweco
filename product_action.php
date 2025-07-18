<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
// Memastikan hanya admin yang bisa mengakses file ini
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Jika bukan admin, tendang ke halaman login
    header("Location: login.php?error=unauthorized");
    exit;
}

// Mengambil aksi dari URL (contoh: ?action=add)
$action = $_GET['action'] ?? '';

/**
 * Fungsi untuk menangani upload gambar.
 * @param array $file Data file dari $_FILES['nama_input']
 * @return string|null Path file yang baru jika sukses, null jika gagal.
 */
function uploadImage($file) {
    $target_dir = "IMG/Products/"; // Folder tujuan untuk menyimpan gambar produk
    // Buat folder jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    // Buat nama file yang unik untuk menghindari nama yang sama
    $fileName = uniqid() . '_' . basename($file["name"]);
    $target_file = $target_dir . $fileName;
    
    // Pindahkan file yang diupload ke folder tujuan
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file; // Kembalikan path file jika berhasil
    }
    return null; // Kembalikan null jika gagal
}

// =======================================================
// AKSI: MENAMBAH PRODUK BARU
// =======================================================
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil semua data dari formulir
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $original_price = !empty($_POST['original_price']) ? $_POST['original_price'] : null;
    $spec_duration = $_POST['spec_duration'];
    $spec_temp_aroma = $_POST['spec_temp_aroma'];
    $spec_weight = $_POST['spec_weight'];
    $image_url = 'IMG/Products/default.jpg'; // Gambar default jika tidak ada yang diupload

    // Cek jika ada file gambar yang diupload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $new_image_path = uploadImage($_FILES['image']);
        if ($new_image_path) {
            $image_url = $new_image_path;
        }
    }

    // Masukkan data ke database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, original_price, image_url, spec_duration, spec_temp_aroma, spec_weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddssss", $name, $description, $price, $original_price, $image_url, $spec_duration, $spec_temp_aroma, $spec_weight);
    $stmt->execute();
    
    // Redirect kembali ke halaman kelola produk dengan pesan sukses
    header("Location: manage_products.php?status=success_add");
    exit;
}

// =======================================================
// AKSI: MEMPERBARUI PRODUK
// =======================================================
if ($action == 'update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $original_price = !empty($_POST['original_price']) ? $_POST['original_price'] : null;
    $spec_duration = $_POST['spec_duration'];
    $spec_temp_aroma = $_POST['spec_temp_aroma'];
    $spec_weight = $_POST['spec_weight'];

    // Query dasar untuk update tanpa gambar
    $sql = "UPDATE products SET name=?, description=?, price=?, original_price=?, spec_duration=?, spec_temp_aroma=?, spec_weight=? WHERE id=?";
    $params = [$name, $description, $price, $original_price, $spec_duration, $spec_temp_aroma, $spec_weight, $id];
    $types = "ssddsssi";

    // Jika ada gambar baru yang diupload, ubah query untuk menyertakan update gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $new_image_path = uploadImage($_FILES['image']);
        if ($new_image_path) {
            $sql = "UPDATE products SET name=?, description=?, price=?, original_price=?, image_url=?, spec_duration=?, spec_temp_aroma=?, spec_weight=? WHERE id=?";
            $params = [$name, $description, $price, $original_price, $new_image_path, $spec_duration, $spec_temp_aroma, $spec_weight, $id];
            $types = "ssddssssi";
        }
    }
    
    // Eksekusi query update
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    // Redirect kembali ke halaman kelola produk dengan pesan sukses
    header("Location: manage_products.php?status=success_update");
    exit;
}

// =======================================================
// AKSI: MENGHAPUS PRODUK
// =======================================================
if ($action == 'delete') {
    $id = $_GET['id'];
    
    // Hapus data dari database berdasarkan ID
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect kembali ke halaman kelola produk dengan pesan sukses
    header("Location: manage_products.php?status=success_delete");
    exit;
}

// Jika tidak ada aksi yang cocok, redirect ke halaman utama admin
header("Location: admin_panel.php");
exit;
?>
