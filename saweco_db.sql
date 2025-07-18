-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Jul 2025 pada 02.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saweco_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_address` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `payment_gateway_id` varchar(255) DEFAULT NULL COMMENT 'Transaction ID from Midtrans',
  `payment_details` text DEFAULT NULL COMMENT 'JSON data like QR code URL, VA number',
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending' COMMENT 'Pending, Paid, Expired, Failed',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_price`, `payment_method`, `payment_gateway_id`, `payment_details`, `order_status`, `order_date`) VALUES
(7, 'ilmi', 'ilmi123@gmail.com', '0812345657', '', 30000.00, 'QRIS (Manual)', NULL, NULL, 'Pending', '2025-07-17 19:00:49'),
(8, 'Andi', 'ilmi123@gmail.com', '0812345657', '', 30000.00, 'QRIS (Manual)', NULL, NULL, 'Pending', '2025-07-17 19:13:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 7, 3, 1, 30000.00),
(4, 8, 2, 1, 30000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `badge_text` varchar(50) DEFAULT NULL,
  `badge_class` varchar(50) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `spec_duration` varchar(50) DEFAULT NULL,
  `spec_temp_aroma` varchar(50) DEFAULT NULL,
  `spec_weight` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `original_price`, `image_url`, `badge_text`, `badge_class`, `rating`, `spec_duration`, `spec_temp_aroma`, `spec_weight`) VALUES
(1, 'Saweco Original', 'Briket klasik tanpa aroma tambahan, cocok untuk berbagai kebutuhan pembakaran dengan kualitas terbaik.', 25000.00, 30000.00, 'IMG/Products/1.jpg', 'Best Seller', '', 4.9, '3-4 jam', 'Suhu: 800°C', '1kg'),
(2, 'Saweco Citrus Fresh', 'Briket dengan aroma lemon segar yang memberikan pengalaman pembakaran yang menyenangkan dan menyegarkan.', 30000.00, 35000.00, 'IMG/Products/2.jpg', 'Refreshing', 'eco', 4.8, '3-4 jam', 'Aroma: Lemon', '1kg'),
(3, 'Saweco BBQ', 'Briket khusus BBQ dengan aroma kayu manis yang memberikan cita rasa istimewa pada makanan panggang Anda.', 30000.00, 35000.00, 'IMG/Products/3.jpg', 'BBQ Special', 'bbq', 4.7, '3-4 jam', 'Aroma: Kayu Manis', '1kg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user' COMMENT 'Peran pengguna: user atau admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Andi Haji Maulana Akbar', 'Andi', 'akbarandi804@gmail.com', '$2y$10$klBgib0qPzNt5cMDen6lw.WFCCYKI4a90XL0.ts7a2Zgj5CI1XEhe', 'admin', '2025-07-16 08:06:35'),
(3, 'haris kyut', 'haris ganteng', 'harisgg@gmail.com', '$2y$10$IX89bFmUNvTIDIOVEh7/l.BvV028.bHh7ACFd/rNR/bUPX0GEXBiC', 'user', '2025-07-16 10:10:20'),
(4, 'Cahyati Rhieqza Salsabilla', 'Eza Cantik', 'rhieqza@gmail.com', '$2y$10$kA3jg9s1WvMcuJ4982SyPO66YgOgtC0SWeFQGQkPX5MBofYMeIlLa', 'user', '2025-07-16 10:24:57'),
(5, 'Raihandri', 'Raihan Slebew', 'raihanocu@gmail.com', '$2y$10$ZDCKHmcwvRV7ibntTa63aOCv2QhTWpP6yU4gKtVJfItXnJRJEUS1W', 'user', '2025-07-16 12:19:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
