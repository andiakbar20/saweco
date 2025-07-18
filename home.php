<?php
require 'config.php';

// Memeriksa status login dan status admin
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? $_SESSION['user_username'] : '';
$isAdmin = $isLoggedIn && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SAWECO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"rel="stylesheet"/>

<!-- Link Swiper JS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
      
    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My style -->
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <!--Navbar start-->
    <nav class="navbar">
      <a href="#" class="navbar-logo">SAW<span>ECO</span>.</a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#products">Produk</a>
        <a href="#contact">Kontak</a>
      </div>

      <div class="navbar-extra">
        <?php if ($isLoggedIn): ?>
            <!-- Jika sudah login -->
            <span class="user-greeting">Hi, 
              <?php 
            $words = explode(' ', $userName); // Pecah nama menjadi array kata
            $firstTwoWords = array_slice($words, 0, 2); // Ambil 2 kata pertama
            echo htmlspecialchars(implode(' ', $firstTwoWords)); // Gabungkan lagi 2 kata itu dengan spasi
?>!
</span>
<div class="navbar-extra">
    <a href="cart.php" id="shopping-cart-button">
        <i data-feather="shopping-cart"></i>
        <?php 
            $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            if ($cart_count > 0) {
                echo "<span class='cart-count'>$cart_count</span>";
            }
        ?>
    </a>
            
            <?php if ($isAdmin): ?>
                <!-- Tampilkan tombol ini HANYA JIKA ADMIN -->
                <a href="admin_panel.php" class="icon-button" title="Admin Panel"><i data-feather="settings"></i></a>
            <?php endif; ?>

            <a href="logout.php" id="logout-button" class="icon-button" title="Logout"><i data-feather="log-out"></i></a>
        <?php else: ?>
            <!-- Jika belum login -->
            <a href="login.php" id="login-button" class="icon-button" title="Login / Register"><i data-feather="user"></i></a>
        <?php endif; ?>
        
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>
    <!--Navbar end-->

    <!-- Hero Section strart-->
    <section class="hero" id="home">
      <main class="content">
        <h1>Energi Hijau dari <span>Limbah Sawit</span></h1>
        <p>
          Dulu hanya dianggap sampah, kini menjadi sumber energi yang bersih dan
          bernilai. Mari nyalakan api tanpa merusak bumi.
        </p>
        <a href="#products" class="cta">Beli Sekarang</a>
      </main>
    </section>
    <!-- Hero Section end-->

    <!-- About Section start -->
    <section id="about" class="about">
      <div class="about-container">
        <h2><span>Tentang</span> Kami</h2>

        <div class="about-cards">
          <div class="about-card">
            <div class="card-icon">
              <i data-feather="help-circle"></i>
            </div>
            <h3>Kenapa Memilih Kami?</h3>
            <p>
              Saweco lahir dari keprihatinan akan banyaknya limbah pelepah
              kelapa sawit yang hanya dibuang atau dibakar, terutama di Provinsi
              Riau—wilayah dengan perkebunan sawit terluas di Indonesia.
            </p>
            <p>
              Limbah ini bukan hanya mencemari lingkungan, tetapi juga menjadi
              penyumbang gas rumah kaca. Kami percaya, limbah bukan akhir dari
              nilai, tapi awal dari solusi.
            </p>
            <p>
              Bermula dari tugas kewirausahaan di Universitas Muhammadiyah Riau
              pada akhir 2024, tim mahasiswa Teknik Informatika mulai merintis
              ide ini menjadi usaha nyata dengan menciptakan briket sawit
              aromatik.
            </p>
          </div>

          <div class="about-card">
            <div class="card-icon">
              <i data-feather="users"></i>
            </div>
            <h3>👥 Profil Tim & Sejarah Usaha</h3>
            <p>
              Saweco dikelola oleh lima mahasiswa kreatif dan inovatif dari
              Universitas Muhammadiyah Riau:
            </p>
            <ul style="text-align: left; margin: 1rem 0; padding-left: 1rem">
              <li>
                <strong>Raja Rafi Andana Pratama</strong> – Ketua Tim
                (Koordinasi & Strategi)
              </li>
              <li>
                <strong>Angelita Vebiola</strong> – Keuangan (Pengelolaan dana &
                administrasi)
              </li>
              <li>
                <strong>Andi Haji Maulana Akbar</strong> – Produksi (Kontrol
                kualitas & proses briket)
              </li>
              <li>
                <strong>M. Hafizurahman Hasby</strong> – Publikasi (Konten &
                sosial media)
              </li>
              <li>
                <strong>M. Fitter Mirano</strong> – Marketing (Pemasaran &
                relasi pelanggan)
              </li>
            </ul>
            <p>
              Kami memulai dari skala kecil di Pekanbaru dan kini berkembang
              melalui promosi digital, pengujian produk, serta kolaborasi dengan
              masyarakat lokal dan mitra potensial.
            </p>
          </div>

          <div class="about-card">
            <div class="card-icon">
              <i data-feather="award"></i>
            </div>
            <h3>♻️ Keunggulan Produk Kami</h3>
            <p>
              Saweco hadir sebagai
              <strong>solusi energi bersih dan ekonomis</strong> dengan
              keunggulan berikut:
            </p>
            <ul style="text-align: left; margin: 1rem 0; padding-left: 1rem">
              <li>
                ✅ <strong>Ekonomi Sirkular:</strong> Memanfaatkan limbah
                perkebunan sebagai sumber energi terbarukan.
              </li>
              <li>
                ✅ <strong>Ramah Lingkungan:</strong> Mengurangi pembakaran
                terbuka & emisi karbon.
              </li>
              <li>
                ✅ <strong>Varian Unik:</strong> Tersedia dalam aroma kayu manis
                (BBQ) dan lemon segar (Citrus Fresh).
              </li>
              <li>
                ✅ <strong>Efisien dan Tahan Lama:</strong> Nilai kalor tinggi,
                kadar abu rendah, dan pembakaran stabil.
              </li>
              <li>
                ✅ <strong>Memberdayakan Masyarakat:</strong> Membuka peluang
                kerja dan nilai ekonomi baru dari limbah.
              </li>
            </ul>
          </div>

          <div class="about-card">
            <div class="card-icon">
              <i data-feather="eye"></i>
            </div>
            <h3>Visi Kami</h3>
            <p>
              Menjadi pelopor dalam inovasi energi terbarukan berbasis limbah
              perkebunan kelapa sawit di Indonesia, yang tidak hanya ramah
              lingkungan tetapi juga berdaya guna tinggi bagi masyarakat lokal
              dan global.
            </p>
            <p>
              Kami berkomitmen untuk menciptakan masa depan yang lebih
              berkelanjutan melalui teknologi hijau dan pemberdayaan masyarakat.
            </p>
          </div>

          <div class="about-card">
            <div class="card-icon">
              <i data-feather="target"></i>
            </div>
            <h3>Misi Kami</h3>
            <p>
              Mengembangkan produk briket berkualitas tinggi dari limbah sawit
              dengan teknologi ramah lingkungan dan memberikan nilai tambah
              ekonomi bagi masyarakat sekitar perkebunan.
            </p>
            <p>
              Edukasi masyarakat tentang pentingnya energi terbarukan dan
              mendorong adopsi solusi energi bersih di seluruh Indonesia.
            </p>
          </div>
        </div>

        <div class="stats-section">
          <div class="stats-container">
            <div class="stat-item">
              <span class="stat-number">100%</span>
              <span class="stat-label">Ramah Lingkungan</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">3</span>
              <span class="stat-label">Varian Produk</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">2024</span>
              <span class="stat-label">Tahun Berdiri</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">∞</span>
              <span class="stat-label">Potensi Limbah</span>
            </div>
          </div>
        </div>

        <div class="timeline-section">
          <h3>Perjalanan Kami</h3>
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <div class="timeline-year">2024</div>
                <h4>Awal Mula</h4>
                <p>
                  Ide Saweco lahir dari tugas kewirausahaan mahasiswa Teknik
                  Informatika Universitas Muhammadiyah Riau
                </p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <div class="timeline-year">2024</div>
                <h4>Riset & Pengembangan</h4>
                <p>
                  Tim mulai meneliti dan mengembangkan teknologi pengolahan
                  limbah sawit menjadi briket aromatik
                </p>
              </div>
            </div>
            <div class="timeline-item">
              <div class="timeline-dot"></div>
              <div class="timeline-content">
                <div class="timeline-year">2025</div>
                <h4>Peluncuran Produk</h4>
                <p>
                  Saweco resmi meluncurkan produk briket dengan varian aroma
                  kayu manis dan lemon
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- About Section end -->

    <!-- Products Section Start -->

    <section class="products" id="products">
      <h2><span>Produk </span> Kami</h2>
      <p>
        Briket ramah lingkungan dengan berbagai varian aroma untuk kebutuhan
        energi Anda.
      </p>

      <div class="row">
        <?php
          // Pastikan koneksi sudah ada dari require 'config.php' di atas
          $products_result = $conn->query("SELECT * FROM products ORDER BY id ASC");
          if ($products_result->num_rows > 0) {
              while($product = $products_result->fetch_assoc()) {
        ?>
                  <div class="product-card">
                      <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="product-link-wrapper">
                          <?php if (!empty($product['badge_text'])): ?>
                              <div class="product-badge <?php echo htmlspecialchars($product['badge_class']); ?>">
                                  <?php echo htmlspecialchars($product['badge_text']); ?>
                              </div>
                          <?php endif; ?>
                          
                          <div class="product-image">
                              <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                          </div>
                          <div class="product-content">
                              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                              
                              <!-- AWAL BAGIAN RATING BINTANG -->
                              <div class="product-stars">
                                  <?php
                                    $rating = floatval($product['rating']);
                                    // Loop untuk 5 bintang
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($rating >= $i) {
                                            // Bintang penuh
                                            echo '<i data-feather="star" class="star-full"></i>';
                                        } elseif ($rating > ($i - 1) && $rating < $i) {
                                            // Bintang setengah (jika ada) - ini memerlukan ikon custom atau trik CSS
                                            // Untuk sekarang kita bulatkan ke bawah
                                            echo '<i data-feather="star"></i>';
                                        } else {
                                            // Bintang kosong
                                            echo '<i data-feather="star"></i>';
                                        }
                                    }
                                  ?>
                                  <span class="rating-text">(<?php echo number_format($rating, 1); ?>)</span>
                              </div>
                              <!-- AKHIR BAGIAN RATING BINTANG -->

                              <div class="product-price">
                                  IDR <?php echo number_format($product['price'], 0, ',', '.'); ?>
                                  <?php if (!empty($product['original_price'])): ?>
                                      <span>IDR <?php echo number_format($product['original_price'], 0, ',', '.'); ?></span>
                                  <?php endif; ?>
                              </div>
                          </div>
                      </a>
                  </div>
        <?php
              }
          } else {
              echo "<p>Belum ada produk yang tersedia.</p>";
          }
        ?>
      </div>

      <!-- Product Detail Modal -->
      <div id="productModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <div id="modalBody">
            <!-- Product details will be inserted here -->
          </div>
        </div>
      </div>
    </section>
    <!-- Products Section end -->

    <!-- Contact Section start -->
    <section class="contact" id="contact">
      <h2><span>Kontak</span> Kami</h2>
      <p>
        Hubungi kami untuk pemesanan dan informasi lebih lanjut tentang produk briket ramah
        lingkungan.
      </p>
      
      
      <div class="contact-container">
        <div class="contact-form">
          <div class="form-wrapper">
            <h3>Kirim Pesan</h3>

          <form onsubmit="sendMassage()">
              <div class="input-group">
                <label for="name">Nama Lengkap</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  placeholder="Masukkan nama lengkap Anda" 
                  required
                />
              </div>

              <div class="input-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  placeholder="Masukkan email Anda"
                  required
                />
              </div>

              <div class="input-group">
                <label for="subject">Subjek</label>
                <input
                  type="text"
                  id="subject"
                  name="subject"
                  placeholder="Subjek pesan Anda"
                  required
                />
              </div>

              <div class="input-group">
                <label for="message">Pesan</label>
                <textarea
                  id="message"
                  name="message"
                  rows="5"
                  placeholder="Tulis pesan Anda di sini..."
                  required
                ></textarea>
              </div>

              <button type="submit" class="btn-submit">
                <i data-feather="send"></i>
                Kirim Pesan via WhatsApp
              </button>
            </form>
          </div>
        </div>

        <div class="contact-map">
          <div class="map-wrapper">
            <h3>Lokasi Kami</h3>
            <div class="map-container">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.666475712319!2d101.41292547581922!3d0.4998758637164508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a9dd2843d4bb%3A0x897aa69d1dc34376!2sFakultas%20Ilmu%20Komputer%20UMRI!5e0!3m2!1sid!2sid!4v1749474276232!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                width="100%"
                height="400"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              >
              </iframe>
            </div>

            <div class="contact-info">
              <div class="info-item">
                <i data-feather="map-pin"></i>
                <div>
                  <h4>Alamat</h4>
                  <p>
                    Universitas Muhammadiyah Riau, Pekanbaru, Riau,
                    Indonesia
                  </p>
                </div>
              </div>

              <div class="info-item">
                <i data-feather="phone"></i>
                <div>
                  <h4>Telepon</h4>
                  <p>+62 813-4820-1731</p>
                </div>
              </div>

              <div class="info-item">
                <i data-feather="mail"></i>
                <div>
                  <h4>Email</h4>
                  <p>akbarandi2269@gmail.com</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Section end -->

    <!-- Footer start -->
    <footer>
      <div class="socials">
        <a href="https://www.instagram.com/a.akbar.__/"><i data-feather="instagram"></i></a>
        <a href="https://x.com/aakbr_20"><i data-feather="twitter"></i></a>
        <a href="https://www.facebook.com/profile.php?id=100076063234812"><i data-feather="facebook"></i></a>
      </div>

      <div class="links">
        <a href="#home">Home</a>
        <a href="#about">Tentang Kami</a>
        <a href="#products">Produk</a>
        <a href="#contact">Kontak</a>
      </div>

      <div class="credits">
        <p>Created by <a href="">ndyy20</a>. | &copy; 2025.</p>
      </div>
    </footer>
    <!-- Footer end -->

    <!-- Feather Icon -->
    <script>
      feather.replace();
    </script>

    <!-- Swiper Js Link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- My Javascript -->
    <script src="script.js"></script>
  </body>
</html>
