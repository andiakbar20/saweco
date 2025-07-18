<?php
require 'config.php';

// Inisialisasi keranjang jika belum ada
$cart = $_SESSION['cart'] ?? [];
$cart_items = [];
$total_price = 0;

if (!empty($cart)) {
    // Ambil detail produk dari database berdasarkan ID di keranjang
    $product_ids = array_keys($cart);
    if (!empty($product_ids)) {
        // Pastikan semua ID adalah integer untuk keamanan
        $ids_string = implode(',', array_map('intval', $product_ids));
        $result = $conn->query("SELECT * FROM products WHERE id IN ($ids_string)");
        
        while ($product = $result->fetch_assoc()) {
            $product['quantity'] = $cart[$product['id']];
            $cart_items[] = $product;
            $total_price += $product['price'] * $product['quantity'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - SAWECO</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        /* Style khusus untuk halaman Keranjang */
        body {
            background-color: #010101;
            color: #fff;
            /* Memastikan background utama terlihat */
            background-image: url('IMG/bg2.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .cart-page-container {
            padding-top: 4rem; /* Memberi ruang di atas */
            padding-bottom: 4rem;
        }
        .cart-container {
            max-width: 950px;
            margin: 0 auto;
            padding: 2.5rem;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .cart-header h1 {
            font-size: 2.5rem;
            color: var(--primary);
            font-weight: 700;
            margin: 0;
        }
        .btn-back-home {
            display: flex;
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
        .btn-back-home:hover {
            background-color: var(--card-bg);
            color: #fff;
            border-color: var(--primary);
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            color: #fff; /* Warna teks utama menjadi putih solid */
        }
        .cart-table thead th {
            color: #fff;
            font-size: 1.2rem; /* Sedikit lebih besar */
            text-align: left;
            padding-bottom: 1.5rem;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        .cart-table tbody td {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-weight: 500; /* Tulisan lebih tebal */
        }
        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }
        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .cart-item-info img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--border-color);
        }
        .cart-item-info .item-name {
            font-weight: 600;
            font-size: 1.1rem;
            color: #fff;
        }
        .cart-table .quantity, .cart-table .action { text-align: center; }
        .btn-remove {
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .btn-remove:hover { color: #f87171; }
        .cart-footer {
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .cart-total h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
        }
        .cart-total h2 span { color: var(--primary); }
        .btn-checkout {
            padding: 0.8rem 2.5rem;
            background: var(--primary);
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        .btn-checkout:hover {
            background: #22c55e;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(11, 102, 35, 0.2);
        }
        .empty-cart { text-align: center; padding: 4rem 2rem; }
        .empty-cart i { font-size: 4rem; color: var(--primary); margin-bottom: 1.5rem; opacity: 0.5; }
        .empty-cart p { font-size: 1.2rem; color: #ccc; margin-bottom: 2rem; }
        .btn-shop {
            padding: 0.7rem 2rem;
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-shop:hover { background: var(--primary); color: #fff; }
    </style>
</head>
<body>
    <!-- Konten Keranjang -->
    <div class="cart-page-container">
        <div class="cart-container">
            <div class="cart-header">
                <h1>Keranjang Belanja</h1>
                <a href="home.php#products" class="btn-back-home">
                    <i data-feather="arrow-left"></i>
                    <span>Kembali Belanja</span>
                </a>
            </div>
            <?php if (!empty($cart_items)): ?>
                <div style="overflow-x:auto;">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Produk</th>
                                <th style="text-align:center;">Harga</th>
                                <th class="quantity">Jumlah</th>
                                <th style="text-align:right;">Subtotal</th>
                                <th class="action">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td>
                                    <div class="cart-item-info">
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <div>
                                            <div class="item-name"><?php echo htmlspecialchars($item['name']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td style="text-align:center;">IDR <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                                <td class="quantity"><?php echo $item['quantity']; ?></td>
                                <td style="text-align:right;">IDR <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                                <td class="action"><a href="cart_action.php?action=remove&id=<?php echo $item['id']; ?>" class="btn-remove">Hapus</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="cart-footer">
                    <div class="cart-total">
                        <h2>Total: <span>IDR <?php echo number_format($total_price, 0, ',', '.'); ?></span></h2>
                    </div>
                    <a href="checkout.php" class="btn-checkout">Lanjutkan ke Checkout</a>
                </div>
            <?php else: ?>
                <div class="empty-cart">
                    <i data-feather="shopping-bag"></i>
                    <p>Keranjang Anda masih kosong.</p>
                    <a href="home.php#products" class="btn-shop">Mulai Belanja</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
      feather.replace();
    </script>
</body>
</html>
