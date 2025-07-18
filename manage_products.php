<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Ambil semua data produk dari database
$result = $conn->query("SELECT * FROM products ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style ini bisa dipindahkan ke style.css jika diinginkan */
        body { 
            background: #0f1419;
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
        }
        .manage-container { 
            max-width: 1200px; 
            margin: 8rem auto 2rem; 
            padding: 2rem; 
            background: rgba(0, 0, 0, 0.8); 
            border-radius: 20px; 
            border: 1px solid var(--border-color); 
            backdrop-filter: blur(10px);
        }
        .manage-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
            padding-bottom: 1rem; 
            border-bottom: 1px solid var(--border-color); 
        }
        .manage-header h1 { 
            font-size: 2.5rem; 
            color: var(--primary); 
        }
        .btn { 
            display: inline-block; 
            padding: 0.6rem 1.2rem; 
            background: var(--primary); 
            color: #fff; 
            border-radius: 8px; 
            text-decoration: none; 
            transition: background 0.3s; 
            border: none; cursor: pointer; 
        }
        .btn:hover { 
            background: #22c55e; 
        }
        .btn-add { 
            background-color: #3b82f6; 
        }
        .btn-add:hover { 
            background-color: #2563eb; 
        }
        .data-table { 
            width: 100%; 
            border-collapse: collapse; 
            color: #ccc; 
        }
        .data-table th, .data-table td { 
            padding: 1rem; 
            text-align: left; 
            border-bottom: 1px solid var(--border-color); 
        }
        .data-table th { 
            color: #fff; 
        }
        .data-table img { 
            width: 60px; height: 60px; 
            object-fit: cover; 
            border-radius: 8px; 
        }
        .action-buttons a { 
            color: #fff; 
            margin-right: 0.5rem; 
            text-decoration: none; 
            padding: 0.4rem 0.8rem; 
            border-radius: 5px; 
            font-size: 0.9rem; 
        }
        .btn-edit { 
            background-color: #3b82f6; 
        }
        .btn-delete { 
            background-color: #ef4444; 
        }
    </style>
</head>
<body>
    <div class="manage-container">
        <div class="manage-header">
            <h1>Kelola Produk</h1>
            <div>
                <a href="product_form.php" class="btn btn-add">Tambah Produk Baru</a>
                <a href="admin_panel.php" class="btn">Kembali ke Panel</a>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <!-- DIUBAH: Header kolom dari "ID" menjadi "No." -->
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $nomor = 1; // Inisialisasi nomor urut ?>
                        <?php while($product = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- DIUBAH: Menampilkan nomor urut -->
                                <td><?php echo $nomor; ?></td>
                                <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Gambar Produk"></td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>IDR <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                <td class="action-buttons">
                                    <a href="product_form.php?id=<?php echo $product['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="product_action.php?action=delete&id=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus produk ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php $nomor++; // Tambahkan 1 ke nomor urut ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">Belum ada produk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
