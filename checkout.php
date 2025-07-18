<?php
require 'config.php';

// Jika keranjang kosong, jangan biarkan masuk ke halaman checkout
if (empty($_SESSION['cart'])) {
    header("Location: home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Style khusus untuk halaman Checkout */
        body {
            background-color: #010101;
            color: #fff;
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }
        .checkout-page-container {
            padding: 7rem 7% 4rem;
        }
        .checkout-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 2.5rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
        }
        .checkout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .checkout-header h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin: 0;
        }
        .btn-back-cart {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: transparent;
            border: 1px solid var(--border-color);
            color: #ccc;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-back-cart:hover {
            background-color: var(--card-bg);
            color: #fff;
            border-color: var(--primary);
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: #ccc; }
        .form-group input, .form-group textarea { 
            width: 100%; 
            padding: 0.8rem; 
            border-radius: 8px; 
            border: 1px solid var(--border-color); 
            background: rgba(255, 255, 255, 0.05); 
            color: #fff; 
            font-family: 'Poppins', sans-serif; /* Pastikan font sama */
        }
        .btn-submit-order { width: 100%; padding: 1rem; background: var(--primary); color: #fff; border: none; border-radius: 8px; font-size: 1.2rem; cursor: pointer; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="checkout-page-container">
        <div class="checkout-container">
            <div class="checkout-header">
                <h1>Checkout</h1>
                <a href="cart.php" class="btn-back-cart">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali ke Keranjang</span>
                </a>
            </div>

            <form action="checkout_process.php" method="POST" id="checkout-form">
                <h2>Detail Pengiriman</h2>
                <div class="form-group">
                    <label for="customer_name">Nama Lengkap</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>
                <div class="form-group">
                    <label for="customer_email">Email</label>
                    <input type="email" id="customer_email" name="customer_email" required>
                </div>
                <div class="form-group">
                    <label for="customer_phone">Nomor Telepon (WhatsApp)</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required>
                </div>
                <!-- INPUT ALAMAT BARU -->
                <div class="form-group">
                    <label for="customer_address">Alamat Lengkap Pengiriman</label>
                    <textarea id="customer_address" name="customer_address" rows="4" placeholder="Contoh: Jl. Sudirman No. 123, Kel. Suka Maju, Kec. Tampan, Kota Pekanbaru, Riau, 28292" required></textarea>
                </div>
                <button type="submit" class="btn-submit-order">Lanjutkan ke Pembayaran</button>
            </form>
        </div>
    </div>
    <script>
        feather.replace();
    </script>
</body>
</html>
