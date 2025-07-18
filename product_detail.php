<?php
require 'config.php';

// Cek jika ID produk tidak ada, redirect ke home
if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}

$product_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Jika produk tidak ditemukan, redirect ke home
    header("Location: home.php");
    exit;
}
$product = $result->fetch_assoc();

// Data untuk Navbar
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? $_SESSION['user_fullname'] : '';
$isAdmin = $isLoggedIn && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Style khusus untuk Halaman Detail Produk */
        body {
            background-color: #010101;
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .detail-page-container {
            padding: 8rem 7% 4rem;
        }
        .detail-container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 2.5rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            display: grid;
            grid-template-columns: 1fr 1.2fr; /* Layout default untuk layar besar */
            gap: 3rem;
            color: #fff;
            backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
        }
        .product-gallery img {
            width: 100%;
            border-radius: 15px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .product-info h1 {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .product-price-detail {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        .product-price-detail span {
            font-size: 1.5rem;
            text-decoration: line-through;
            color: #888;
            margin-left: 1rem;
        }
        .product-description {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #fff;
            margin-bottom: 2rem;
        }
        .product-specs-detail {
            margin-bottom: 2rem;
            border-top: 1px solid var(--border-color);
            padding-top: 1.5rem;
        }
        .spec-item-detail {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        .spec-item-detail i { color: var(--primary); }
        .add-to-cart-form { display: flex; gap: 1rem; align-items: center; }
        .quantity-input {
            width: 80px;
            padding: 0.8rem;
            font-size: 1.2rem;
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            color: #fff;
            border-radius: 8px;
        }
        .btn-add-to-cart {
            padding: 0.8rem 1.5rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-add-to-cart:hover { background: #22c55e; transform: translateY(-2px); }
        .btn-back-home {
            display: inline-flex; /* Menggunakan inline-flex agar ikon dan teks sejajar */
            align-items: center;
            gap: 0.5rem;
            margin-top: 2.5rem;
            padding: 0.7rem 1.5rem;
            border: 1px solid var(--border-color);
            color: #ccc;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-back-home:hover {
            background-color: var(--card-bg);
            color: #fff;
            border-color: var(--primary);
        }

        /* PERUBAHAN UNTUK TAMPILAN HP/TABLET */
        @media (max-width: 768px) {
            .detail-container {
                grid-template-columns: 1fr; /* Ubah layout menjadi 1 kolom */
                padding: 1.5rem;
                gap: 2rem;
            }
            .product-info h1 {
                font-size: 2.2rem;
            }
            .product-price-detail {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
      <a href="home.php" class="navbar-logo">SAW<span>ECO</span>.</a>
      <div class="navbar-extra">
        <a href="cart.php" id="shopping-cart-button">
            <i data-feather="shopping-cart"></i>
            <?php if ($cart_count > 0): ?>
                <span class='cart-count'><?php echo $cart_count; ?></span>
            <?php endif; ?>
        </a>
        <?php if ($isLoggedIn): ?>
            <?php if ($isAdmin): ?>
                <a href="admin_panel.php" class="icon-button" title="Admin Panel"><i data-feather="settings"></i></a>
            <?php endif; ?>
            <a href="logout.php" id="logout-button" class="icon-button" title="Logout"><i data-feather="log-out"></i></a>
        <?php else: ?>
            <a href="login.php" id="login-button" class="icon-button" title="Login / Register"><i data-feather="user"></i></a>
        <?php endif; ?>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>

    <!-- Konten Detail Produk -->
    <div class="detail-page-container">
        <div class="detail-container">
            <div class="product-gallery">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="product-price-detail">
                    IDR <?php echo number_format($product['price'], 0, ',', '.'); ?>
                    <?php if (!empty($product['original_price'])): ?>
                        <span>IDR <?php echo number_format($product['original_price'], 0, ',', '.'); ?></span>
                    <?php endif; ?>
                </div>
                <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                
                <div class="product-specs-detail">
                    <?php if (!empty($product['spec_duration'])): ?>
                        <div class="spec-item-detail"><i data-feather="clock"></i> <span>Durasi: <?php echo htmlspecialchars($product['spec_duration']); ?></span></div>
                    <?php endif; ?>
                    <?php if (!empty($product['spec_temp_aroma'])): ?>
                        <div class="spec-item-detail"><i data-feather="thermometer"></i> <span><?php echo htmlspecialchars($product['spec_temp_aroma']); ?></span></div>
                    <?php endif; ?>
                    <?php if (!empty($product['spec_weight'])): ?>
                        <div class="spec-item-detail"><i data-feather="package"></i> <span>Berat: <?php echo htmlspecialchars($product['spec_weight']); ?></span></div>
                    <?php endif; ?>
                </div>

                <form action="cart_action.php?action=add" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                    <button type="submit" class="btn-add-to-cart">Tambah ke Keranjang</button>
                </form>

                <a href="home.php#products" class="btn-back-home">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali ke Produk</span>
                </a>
            </div>
        </div>
    </div>

    <script>
      feather.replace();
    </script>
</body>
</html>
