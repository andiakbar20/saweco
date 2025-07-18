<?php
// Panggil file config untuk memulai session
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
// Cek jika pengguna tidak login atau jika rolenya BUKAN 'admin'
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Jika tidak memenuhi syarat, tendang ke halaman login dengan pesan error
    header("Location: login.php?error=unauthorized");
    exit;
}

// Jika lolos, artinya dia adalah admin.
// Ambil nama admin dari session untuk ditampilkan.
$adminName = $_SESSION['user_fullname'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style khusus untuk Admin Panel */
        body {
            background: #0f1419;
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
        }
        .admin-container {
            max-width: 1200px;
            margin: 10rem auto 2rem auto;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }
        .admin-header h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .admin-header p {
            font-size: 1.2rem;
            color: #ccc;
            margin-bottom: 2rem;
        }
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.3s ease;
            display: block; /* Agar seluruh area kartu bisa di-klik */
            color: #fff; /* Warna teks default */
            text-decoration: none; /* Hapus garis bawah link */
        }
        .admin-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
        }
        .admin-card i {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: block;
        }
        .admin-card h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #fff; /* Pastikan warna heading putih */
        }
        .admin-card p {
            color: #ccc; /* Warna deskripsi */
        }
    </style>
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>Selamat Datang di Admin Panel</h1>
            <p>Anda login sebagai <strong><?php echo htmlspecialchars($adminName); ?></strong> (Admin)</p>
        </div>

        <div class="admin-grid">
            <!-- DIUBAH: href sekarang mengarah ke manage_users.php -->
            <a href="manage_users.php" class="admin-card">
                <i data-feather="users"></i>
                <h3>Kelola Pengguna</h3>
                <p>Lihat, tambah, atau hapus pengguna.</p>
            </a>
            <a href="manage_products.php" class="admin-card">
                <i data-feather="package"></i>
                <h3>Kelola Produk</h3>
                <p>Ubah detail, harga, dan stok produk.</p>
            </a>
            <a href="view_orders.php" class="admin-card">
                <i data-feather="file-text"></i>
                <h3>Lihat Pesanan</h3>
                <p>Monitor pesanan yang masuk.</p>
            </a>
            <a href="home.php" class="admin-card">
                <i data-feather="home"></i>
                <h3>Kembali ke Website</h3>
            </a>
        </div>
        
    </div>

    <script>
      feather.replace();
    </script>
</body>
</html>
