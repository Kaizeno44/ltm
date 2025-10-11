-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th10 11, 2025 lúc 05:50 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `items`
--

INSERT INTO `items` (`id`, `name`, `price`, `deleted`) VALUES
(1, 'Trà Sữa Trân Châu Đường Đen', 45000, 0),
(2, 'Cà Phê Sữa Đá', 30000, 0),
(3, 'Bánh Mì Thịt Nướng', 25000, 0),
(4, 'Mì Ý Sốt Bò Bằm', 60000, 0),
(5, 'Pizza Hải Sản Nhỏ', 120000, 0),
(6, 'Trà Đào Cam Sả', 40000, 0),
(7, 'Sinh Tố Bơ', 35000, 0),
(8, 'Bánh Flan', 20000, 0),
(9, 'Nước Suối Aquafina', 10000, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `address` varchar(300) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `payment_type` varchar(50) DEFAULT 'Wallet',
  `total` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Yet to be delivered',
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `address`, `description`, `date`, `payment_type`, `total`, `status`, `deleted`) VALUES
(1, 1, '1 nguyễn diệu', '', '2025-10-10 20:14:06', 'Cash On Delivery', 0, 'Yet to be delivered', 0),
(2, 4, '1 ngô quyền', '', '2025-10-11 20:44:46', 'Cash On Delivery', 45000, 'Yet to be delivered', 0),
(3, 4, '2 Nguyễn Thái Sơn', '', '2025-10-11 20:56:03', 'Cash On Delivery', 135000, 'Yet to be delivered', 0),
(4, 4, '2 hiệp thành', '', '2025-10-11 21:30:17', 'Cash On Delivery', 6595000, 'Yet to be delivered', 0),
(5, 4, '1 nguyễn kiệm', '', '2025-10-11 21:40:14', 'Cash On Delivery', 85000, 'Yet to be delivered', 0),
(6, 6, '1 hoàn kiếm', '', '2025-10-11 22:43:31', 'Cash On Delivery', 265000, 'Yet to be delivered', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
(1, 2, 8, 1, 20000),
(2, 2, 3, 1, 25000),
(3, 3, 8, 1, 20000),
(4, 3, 3, 1, 25000),
(5, 3, 2, 1, 30000),
(6, 3, 4, 1, 60000),
(7, 4, 8, 1, 20000),
(8, 4, 3, 1, 25000),
(9, 4, 2, 10, 300000),
(10, 4, 4, 100, 6000000),
(11, 4, 9, 1, 10000),
(12, 4, 5, 2, 240000),
(13, 5, 1, 1, 45000),
(14, 5, 6, 1, 40000),
(15, 6, 8, 1, 20000),
(16, 6, 3, 1, 25000),
(17, 6, 2, 1, 30000),
(18, 6, 4, 1, 60000),
(19, 6, 9, 1, 10000),
(20, 6, 5, 1, 120000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT 'Customer',
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(300) DEFAULT NULL,
  `contact` bigint(20) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `username`, `password`, `email`, `address`, `contact`, `verified`, `deleted`) VALUES
(1, 'Customer', 'hehehe', 'admin', '123456', NULL, NULL, 925931331, 0, 0),
(4, 'Customer', 'nguyen', 'adu123', '123456', NULL, NULL, 1233456789, 0, 0),
(5, 'Customer', '1234567', 'gegege', '$2y$10$1LuB3uFLKB7sqej86hGoVeBmDDuaOZCYe8vKGgqA/OjgXNCu4Kwii', NULL, NULL, 12345678910, 0, 0),
(6, 'Customer', 'alo1234', 'alo123', '$2y$10$h0mH5w38Se6BVXeTDxltaOHwzpo6tWG73q59jcxdU/PVD8f9sDkEW', NULL, NULL, 123456666, 0, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
