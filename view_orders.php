<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Ambil semua data pesanan dari database, diurutkan dari yang paling baru
$result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pesanan - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style khusus untuk halaman "Lihat Pesanan" */
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
        .btn-back {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #22c55e;
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
            font-size: 1.1rem;
        }
        .data-table tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }
        /* Style untuk status pesanan */
        .status-pending { color: #f59e0b; font-weight: bold; }
        .status-paid { color: #22c55e; font-weight: bold; }
        .status-cancelled { color: #ef4444; font-weight: bold; }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .btn-action {
            color: #fff;
            padding: 0.4rem 0.8rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
        }
        .btn-mark-paid { background-color: #3b82f6; }
        .btn-cancel { background-color: #ef4444; }
    </style>
</head>
<body>
    <div class="manage-container">
        <div class="manage-header">
            <h1>Daftar Pesanan Masuk</h1>
            <a href="admin_panel.php" class="btn-back">Kembali ke Panel</a>
        </div>
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID Pesanan</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $nomor = 1; ?>
                        <?php while($order = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                <td>IDR <?php echo number_format($order['total_price'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="status-<?php echo strtolower(htmlspecialchars($order['order_status'])); ?>">
                                        <?php echo htmlspecialchars($order['order_status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y, H:i', strtotime($order['order_date'])); ?></td>
                                <td class="action-buttons">
                                    <?php if ($order['order_status'] == 'Pending'): ?>
                                        <a href="order_action.php?action=mark_paid&id=<?php echo $order['id']; ?>" class="btn-action btn-mark-paid" onclick="return confirm('Anda yakin ingin menandai pesanan ini sebagai LUNAS?');">
                                            Tandai Lunas
                                        </a>
                                        <a href="order_action.php?action=cancel_order&id=<?php echo $order['id']; ?>" class="btn-action btn-cancel" onclick="return confirm('Anda yakin ingin MEMBATALKAN pesanan ini?');">
                                            Batalkan
                                        </a>
                                    <?php else: ?>
                                        <span>-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center;">Belum ada pesanan yang masuk.</td></tr>
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
