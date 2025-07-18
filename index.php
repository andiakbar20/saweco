<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? $_SESSION['user_fullname'] : '';
$userUsername = $isLoggedIn ? $_SESSION['user_username'] : '';
$userEmail = $isLoggedIn ? $_SESSION['user_email'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAWECO - Solusi Energi Hijau dari Limbah Sawit</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a2332 100%);
            min-height: 100vh;
            color: #fff;
            overflow-x: hidden;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: url('IMG/bg2.jpg');
            background-size: cover;
            background-position: center;
            z-index: -1;
            opacity: 0.3;
        }

        /* Header */
        .header {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
        }

        .logo .green {
            color: #0b6623;
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #0b6623;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-welcome {
            color: #0b6623;
            font-weight: 500;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn-login, .btn-register {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-login {
            background: transparent;
            border: 1px solid #0b6623;
            color: #0b6623;
        }

        .btn-login:hover {
            background: #0b6623;
            color: white;
        }

        .btn-register {
            background: #0b6623;
            color: white;
        }

        .btn-register:hover {
            background: #0a5a1f;
        }

        .logout-btn {
            background: #ff4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: #cc0000;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 2rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-section {
            text-align: center;
            padding: 4rem 0;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-bottom: 2rem;
        }

        .hero-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #0b6623;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-description {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #0b6623;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #0a5a1f;
        }

        .btn-secondary {
            background: transparent;
            color: #0b6623;
            border: 2px solid #0b6623;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #0b6623;
            color: white;
        }

        .features-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #0b6623;
        }

        .feature-description {
            opacity: 0.9;
            line-height: 1.6;
        }

        .user-dashboard {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .user-dashboard h2 {
            color: #0b6623;
            margin-bottom: 1rem;
        }

        .user-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem;
            border-radius: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #0b6623;
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="nav-container">
            <div class="logo">
                SAWE<span class="green">CO</span>
            </div>
            <nav class="nav-links">
                <a href="#home">Beranda</a>
                <a href="#about">Tentang</a>
                <a href="#products">Produk</a>
                <a href="#contact">Kontak</a>
            </nav>
            <div class="user-info">
                <?php if ($isLoggedIn): ?>
                    <span class="user-welcome">Selamat datang, <?php echo htmlspecialchars($userName); ?>!</span>
                    <button class="logout-btn" onclick="logout()">Logout</button>
                <?php else: ?>
                    <div class="auth-buttons">
                        <a href="login.php" class="btn-login">Masuk</a>
                        <a href="login.php" class="btn-register">Daftar</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if ($isLoggedIn): ?>
            <!-- User Dashboard -->
            <div class="user-dashboard">
                <h2>Dashboard Pengguna</h2>
                <div class="user-info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div><?php echo htmlspecialchars($userName); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Username</div>
                        <div><?php echo htmlspecialchars($userUsername); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div><?php echo htmlspecialchars($userEmail); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div style="color: #0b6623; font-weight: bold;">Aktif</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="hero-title">SAWECO</h1>
            <p class="hero-subtitle">Solusi Energi Hijau dari Limbah Sawit</p>
            <p class="hero-description">
                Mengubah limbah kelapa sawit menjadi energi terbarukan yang ramah lingkungan. 
                Bergabunglah dalam revolusi energi hijau untuk masa depan yang berkelanjutan.
            </p>
            <div class="cta-buttons">
                <a href="#products" class="btn-primary">Jelajahi Produk</a>
                <a href="#about" class="btn-secondary">Pelajari Lebih Lanjut</a>
            </div>
        </div>

        <!-- Features Section -->
        <div class="features-section">
            <div class="feature-card">
                <h3 class="feature-title">🌱 Ramah Lingkungan</h3>
                <p class="feature-description">
                    Menggunakan limbah kelapa sawit sebagai sumber energi terbarukan, 
                    mengurangi jejak karbon dan mendukung keberlanjutan lingkungan.
                </p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">⚡ Energi Efisien</h3>
                <p class="feature-description">
                    Teknologi konversi limbah sawit menjadi energi dengan efisiensi tinggi 
                    dan output yang optimal untuk berbagai kebutuhan.
                </p>
            </div>
            <div class="feature-card">
                <h3 class="feature-title">💰 Ekonomis</h3>
                <p class="feature-description">
                    Solusi energi yang cost-effective dengan memanfaatkan limbah yang 
                    sebelumnya tidak bernilai menjadi sumber energi yang menguntungkan.
                </p>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>