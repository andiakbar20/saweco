<?php
require 'config.php';

// --- PERLINDUNGAN HALAMAN ADMIN ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php?error=unauthorized");
    exit;
}

// Inisialisasi variabel untuk form
$product = [
    'id' => '',
    'name' => '',
    'description' => '',
    'price' => '',
    'original_price' => '',
    'image_url' => '',
    'spec_duration' => '',
    'spec_temp_aroma' => '',
    'spec_weight' => ''
];
$page_title = "Tambah Produk Baru";
$form_action = "product_action.php?action=add";

// Cek jika ini adalah mode EDIT (ada ID di URL)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $page_title = "Edit Produk";
        $form_action = "product_action.php?action=update&id=" . $product['id'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
            background: #0f1419;
            background-image: url('IMG/bg2.jpg');
            background-size: cover; 
        }
        .form-container { 
            max-width: 800px;
            margin: 8rem auto 2rem; 
            padding: 2rem; 
            background: 
            rgba(0, 0, 0, 0.8); 
            border-radius: 20px; 
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
        .form-header h1 { 
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
            border: none; cursor: pointer; 
        }
        .form-group { 
            margin-bottom: 1.5rem; 
        }
        .form-group label { 
            display: block; 
            margin-bottom: 0.5rem; 
            color: #ccc; 
        }
        .form-group input, .form-group textarea { 
            width: 100%; 
            padding: 0.8rem; 
            border-radius: 8px; 
            border: 1px solid var(--border-color); 
            background: rgba(255, 255, 255, 0.05); 
            color: #fff; 
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1><?php echo $page_title; ?></h1>
            <a href="manage_products.php" class="btn">Batal</a>
        </div>
        <form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="original_price">Harga Asli (dicoret)</label>
                <input type="number" step="0.01" id="original_price" name="original_price" value="<?php echo htmlspecialchars($product['original_price']); ?>">
            </div>
             <div class="form-group">
                <label for="spec_duration">Spesifikasi Durasi (cth: 3-4 jam)</label>
                <input type="text" id="spec_duration" name="spec_duration" value="<?php echo htmlspecialchars($product['spec_duration']); ?>">
            </div>
             <div class="form-group">
                <label for="spec_temp_aroma">Spesifikasi Suhu/Aroma (cth: Suhu: 800°C)</label>
                <input type="text" id="spec_temp_aroma" name="spec_temp_aroma" value="<?php echo htmlspecialchars($product['spec_temp_aroma']); ?>">
            </div>
             <div class="form-group">
                <label for="spec_weight">Spesifikasi Berat (cth: 1kg)</label>
                <input type="text" id="spec_weight" name="spec_weight" value="<?php echo htmlspecialchars($product['spec_weight']); ?>">
            </div>
            <div class="form-group">
                <label for="image">Gambar Produk</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if(!empty($product['image_url'])): ?>
                    <p style="color:#888; font-size:0.9rem; margin-top:0.5rem;">Gambar saat ini: <a href="<?php echo $product['image_url']; ?>" target="_blank">Lihat</a>. Kosongkan jika tidak ingin mengubah.</p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn">Simpan Produk</button>
        </form>
    </div>
</body>
</html>
