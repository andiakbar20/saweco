<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Inisialisasi variabel
$user = [
    'id' => '',
    'full_name' => '',
    'username' => '',
    'email' => '',
    'role' => 'user'
];
$page_title = "Edit Pengguna";
$form_action = "";

// Cek jika ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT id, full_name, username, email, role FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $form_action = "user_action.php?action=update&id=" . $user['id'];
    } else {
        // Jika ID tidak ditemukan, kembali ke halaman manage
        header("Location: manage_users.php");
        exit;
    }
    $stmt->close();
} else {
    // Jika tidak ada ID, kembali ke halaman manage
    header("Location: manage_users.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #0f1419; }
        .form-container {
            max-width: 800px;
            margin: 8rem auto 2rem auto;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
        }
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .form-header h1 { font-size: 2.5rem; color: var(--primary); }
        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background: var(--primary);
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn:hover { background: #22c55e; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ccc;
            font-size: 1.1rem;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1rem;
        }
        .password-note {
            font-size: 0.9rem;
            color: #888;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1><?php echo $page_title; ?></h1>
            <a href="manage_users.php" class="btn">Batal</a>
        </div>
        
        <form action="<?php echo $form_action; ?>" method="POST">
            <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password">
                <p class="password-note">Kosongkan jika tidak ingin mengubah password.</p>
            </div>
            <div class="form-group">
                <label for="role">Peran (Role)</label>
                <select id="role" name="role">
                    <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
                    <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
