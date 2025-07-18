<?php
require 'config.php';

// Pastikan ada order_id di URL
if (!isset($_GET['order_id'])) {
    header("Location: home.php");
    exit;
}

$order_id = $_GET['order_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Jika pesanan tidak ditemukan, redirect
if ($result->num_rows === 0) {
    header("Location: home.php");
    exit;
}
$order = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: #0f1419; 
            font-family: 'Poppins', sans-serif; 
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
        }
        .payment-container { 
            max-width: 600px; 
            margin: 8rem auto; 
            padding: 2rem; 
            background: rgba(0, 0, 0, 0.8); 
            border-radius: 20px; 
            text-align: center; 
        }
        .payment-container h1 { 
            font-size: 2rem; 
            color: var(--primary); 
            margin-bottom: 1rem; 
        }
        .payment-container p { 
            color: #ccc; 
            margin-bottom: 2rem; 
        }
        .payment-instruction { 
            background: var(--card-bg); 
            padding: 1.5rem; 
            border-radius: 15px; 
        }
        .payment-instruction h3 { 
            font-size: 1.5rem; 
            margin-bottom: 1rem; 
        }
        .qr-code img { 
            max-width: 300px; 
            margin: 1rem auto; 
            border: 5px solid white;
            border-radius: 10px;
        }
        .total-amount { 
            font-size: 1.5rem; 
            margin-top: 1rem; 
            font-weight: bold; 
        }
        .total-amount span { 
            color: var(--primary); 
        }
        
        .btn-finish { 
            display: inline-block; 
            margin-top: 1.5rem; 
            padding: 0.7rem 2rem; 
            background: var(--primary); 
            color: #fff; 
            text-decoration: none; 
            border-radius: 50px; 
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <h1>Selesaikan Pembayaran Anda</h1>
        <p>Pesanan Anda #SAWECO-<?php echo $order_id; ?> telah dibuat.</p>

        <div class="payment-instruction">
            <h3>Pembayaran via QRIS</h3>
            <p>Silakan pindai QR Code di bawah ini dengan aplikasi e-wallet atau m-banking Anda.</p>
            <div class="qr-code">
                <!-- GANTI DENGAN URL GAMBAR QR CODE ANDA -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=SAWECO-PAYMENT" alt="QRIS Code">
            </div>
            <div class="total-amount">
                Total Pembayaran: <span>IDR <?php echo number_format($order['total_price'], 0, ',', '.'); ?></span>
            </div>
        </div>

        <a href="home.php" class="btn-finish">Selesai & Kembali ke Beranda</a>
    </div>
</body>
</html>
