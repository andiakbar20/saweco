<?php
// Panggil file config untuk memulai session dan koneksi DB
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Ambil semua data pengguna dari database untuk ditampilkan
$result = $conn->query("SELECT id, full_name, username, email, role FROM users ORDER BY id ASC");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style khusus untuk halaman Kelola Pengguna */
        body { 
            background: #0f1419; 
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
        }
        .manage-container {
            max-width: 1200px;
            margin: 8rem auto 2rem auto;
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
        .manage-header h1 { font-size: 2.5rem; color: var(--primary); }
        .btn-back {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-back:hover { background: #22c55e; }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            color: #ccc;
        }
        .user-table th, .user-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        .user-table th { color: #fff; font-size: 1.1rem; }
        .user-table tr:hover { background-color: rgba(255, 255, 255, 0.03); }
        .role-admin { color: #f59e0b; font-weight: bold; }
        .role-user { color: #ccc; }
        .action-buttons a {
            color: #fff;
            margin-right: 0.5rem;
            text-decoration: none;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .btn-edit { background-color: #3b82f6; }
        .btn-delete { background-color: #ef4444; }
        .alert-msg {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
        }
        .alert-success { background: rgba(76, 175, 80, 0.2); border: 1px solid var(--primary); color: var(--primary); }
        .alert-error { background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; }
    </style>
</head>
<body>
    <div class="manage-container">
        <div class="manage-header">
            <h1>Kelola Pengguna</h1>
            <a href="admin_panel.php" class="btn-back">Kembali ke Panel</a>
        </div>

        <?php if(isset($_GET['status'])): ?>
            <div class="alert-msg <?php echo strpos($_GET['status'], 'error') === false ? 'alert-success' : 'alert-error'; ?>">
                <?php
                    if($_GET['status'] == 'success_update') echo "Data pengguna berhasil diperbarui!";
                    if($_GET['status'] == 'success_delete') echo "Pengguna berhasil dihapus!";
                    if($_GET['status'] == 'error_self_delete') echo "Anda tidak bisa menghapus akun Anda sendiri!";
                ?>
            </div>
        <?php endif; ?>

        <div style="overflow-x:auto;">
            <table class="user-table">
                <thead>
                    <tr>
                        <!-- DIUBAH: Header kolom dari "ID" menjadi "No." -->
                        <th>No.</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $nomor = 1; // Inisialisasi nomor urut ?>
                        <?php while($user = $result->fetch_assoc()): ?>
                            <tr>
                                <!-- DIUBAH: Menampilkan nomor urut, bukan ID dari database -->
                                <td><?php echo $nomor; ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <span class="role-<?php echo $user['role']; ?>">
                                        <?php echo ucfirst($user['role']); ?>
                                    </span>
                                </td>
                                <td class="action-buttons">
                                    <a href="user_form.php?id=<?php echo $user['id']; ?>" class="btn-edit">Edit</a>
                                    <a href="user_action.php?action=delete&id=<?php echo $user['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php $nomor++; // Tambahkan 1 ke nomor urut untuk baris berikutnya ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Tidak ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
