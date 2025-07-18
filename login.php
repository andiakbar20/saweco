<?php
// Memanggil file config yang sudah otomatis memulai session
require 'config.php';

// Jika pengguna sudah login, langsung arahkan ke halaman utama
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: home.php");
    exit;
}

$register_error = '';
$login_error = '';

// --- LOGIKA REGISTER ---
if (isset($_POST['register'])) {
    $fullName = trim($_POST['registerFullName']);
    $username = trim($_POST['registerUsername']);
    $email = trim($_POST['registerEmail']);
    $password = $_POST['registerPassword'];
    $confirmPassword = $_POST['registerConfirmPassword'];

    // Validasi input di sisi server
    if (empty($fullName) || empty($username) || empty($email) || empty($password)) {
        $register_error = 'Semua field harus diisi!';
    } elseif (strlen($password) < 6) {
        $register_error = 'Password minimal harus 6 karakter!';
    } elseif ($password !== $confirmPassword) {
        $register_error = 'Password dan konfirmasi password tidak cocok!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = 'Format email tidak valid!';
    } else {
        // Cek apakah username atau email sudah ada di database
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $register_error = 'Username atau Email sudah terdaftar!';
        } else {
            // Enkripsi password sebelum disimpan
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Masukkan pengguna baru ke database
            $insert_stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password) VALUES (?, ?, ?, ?)");
            $insert_stmt->bind_param("ssss", $fullName, $username, $email, $hashed_password);
            
            if ($insert_stmt->execute()) {
                // Redirect ke halaman login dengan pesan sukses
                header("Location: login.php?status=reg_success");
                exit();
            } else {
                $register_error = 'Registrasi gagal, silakan coba lagi.';
            }
            $insert_stmt->close();
        }
        $stmt_check->close();
    }
}

// --- LOGIKA LOGIN ---
if (isset($_POST['login'])) {
    $username = trim($_POST['loginUsername']);
    $password = $_POST['loginPassword'];

    if (empty($username) || empty($password)) {
        $login_error = 'Username dan password harus diisi!';
    } else {
        // Cari pengguna berdasarkan username atau email
        $stmt = $conn->prepare("SELECT id, full_name, username, email, password, role FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verifikasi password yang dimasukkan dengan hash di database
            if (password_verify($password, $user['password'])) {
                // Jika login sukses, simpan semua data penting ke session
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_fullname'] = $user['full_name'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirect ke halaman utama
                header("Location: home.php");
                exit();
            } else {
                $login_error = 'Username atau password salah!';
            }
        } else {
            $login_error = 'Username atau password salah!';
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registrasi - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style khusus untuk halaman Login */
        body {
            background-color: #010101;
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .auth-container {
            width: 100%;
            max-width: 420px;
            padding: 2rem;
        }
        .auth-card {
            background: rgba(0, 0, 0, 0.8); 
            padding: 2.5rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }
        .auth-title {
            text-align: center;
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ccc;
        }
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1rem;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 0.8rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-primary:hover { background: #22c55e; }
        .auth-switch { text-align: center; margin-top: 1.5rem; color: #aaa; }
        .auth-switch a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-switch a:hover { text-decoration: underline; }
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: 500;
        }
        .alert-success { background: rgba(34, 197, 94, 0.2); border: 1px solid #22c55e; color: #22c55e; }
        .alert-error { background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #ef4444; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Login Form -->
        <div id="loginForm">
            <div class="auth-card">
                <h2 class="auth-title">Masuk</h2>
                <?php if (isset($_GET['status']) && $_GET['status'] == 'reg_success'): ?>
                    <div class="alert alert-success">Registrasi berhasil! Silakan login.</div>
                <?php endif; ?>
                <?php if ($login_error): ?>
                    <div class="alert alert-error"><?php echo $login_error; ?></div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label class="form-label">Username atau Email</label>
                        <input type="text" class="form-input" name="loginUsername" placeholder="Masukkan username atau email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-input" name="loginPassword" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" name="login" class="btn-primary">Login</button>
                </form>
                <div class="auth-switch">
                    <p>Belum punya akun? <a href="#" onclick="toggleForms()">Daftar disini</a></p>
                </div>
            </div>
        </div>

        <!-- Register Form -->
        <div id="registerForm" class="hidden">
            <div class="auth-card">
                <h2 class="auth-title">Daftar Akun</h2>
                <?php if ($register_error): ?>
                    <div class="alert alert-error"><?php echo $register_error; ?></div>
                <?php endif; ?>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-input" name="registerFullName" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-input" name="registerUsername" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" name="registerEmail" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-input" name="registerPassword" placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-input" name="registerConfirmPassword" placeholder="Ulangi password" required>
                    </div>
                    <button type="submit" name="register" class="btn-primary">Daftar</button>
                </form>
                <div class="auth-switch">
                    <p>Sudah punya akun? <a href="#" onclick="toggleForms()">Login disini</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function toggleForms() {
            loginForm.classList.toggle('hidden');
            registerForm.classList.toggle('hidden');
        }

        // Jika ada error registrasi, tampilkan form register secara default
        <?php if ($register_error): ?>
        toggleForms();
        <?php endif; ?>
    </script>
</body>
</html>
