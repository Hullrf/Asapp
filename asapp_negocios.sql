-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2025 at 05:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12


START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asapp_negocios`
--

-- --------------------------------------------------------

--
-- Table structure for table `items_pedido`
--

CREATE TABLE `items_pedido` (
  `id_item` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado') DEFAULT 'Pendiente'
) COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items_pedido`
--

INSERT INTO `items_pedido` (`id_item`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`, `estado`) VALUES
(5, 2, 5, 1, 20000.00, 20000.00, 'Pendiente'),
(10, 1, 2, 15, 28000.00, 420000.00, 'Pagado'),
(11, 1, 1, 10, 35000.00, 350000.00, 'Pendiente'),
(12, 1, 1, 1, 35000.00, 35000.00, 'Pendiente'),
(13, 1, 1, 1, 35000.00, 35000.00, 'Pendiente'),
(14, 2, 6, 6, 15000.00, 90000.00, 'Pendiente'),
(15, 2, 6, 3, 15000.00, 45000.00, 'Pendiente'),
(16, 2, 4, 3, 12000.00, 36000.00, 'Pagado');

-- --------------------------------------------------------

--
-- Table structure for table `negocios`
--

CREATE TABLE `negocios` (
  `id_negocio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negocios`
--

INSERT INTO `negocios` (`id_negocio`, `nombre`, `direccion`, `telefono`, `email`, `fecha_registro`) VALUES
(1, 'Restaurante El Sabor', 'Calle 123 #45-67', '3101234567', 'contacto@elsabor.com', '2025-09-11 09:10:53'),
(2, 'Bar La Esquina', 'Carrera 10 #20-30', '3119876543', 'info@laesquina.com', '2025-09-11 09:10:53'),
(20, 'Osadia', 'Frente a la U', '1234567890', 'pepitoperez@Asapp.com', '2025-10-03 06:53:02'),
(21, 'asas', 'calle 8 a bis a # 80 - 63', '3106858659', 'davidsantiagorc@outlook.com', '2025-10-07 20:21:04');

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `id_pago` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` enum('exitoso','fallido','simulado') DEFAULT 'simulado',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_negocio` int(11) DEFAULT NULL,
  `codigo_qr` varchar(100) DEFAULT NULL,
  `estado` enum('Pendiente','Parcial','Pagado') DEFAULT 'Pendiente',
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_negocio`, `codigo_qr`, `estado`, `fecha`) VALUES
(1, 1, 'QR123ABC', 'Pendiente', '2025-09-11 09:10:54'),
(2, 2, 'QR456DEF', 'Pendiente', '2025-09-11 09:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_negocio` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `disponible` tinyint(1) DEFAULT 1
) COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `id_negocio`, `nombre`, `descripcion`, `precio`, `disponible`) VALUES
(1, 1, 'Pizza Margarita', 'Pizza con queso y albahaca', 35000.00, 1),
(2, 1, 'Hamburguesa Doble', 'Carne doble con papas', 28000.00, 1),
(3, 1, 'Jugo Natural', 'Vaso de jugo de naranja', 8000.00, 1),
(4, 2, 'Cerveza Artesanal', 'Botella 330ml', 12000.00, 1),
(5, 2, 'Gin Tonic', 'Cóctel clásico', 20000.00, 1),
(6, 2, 'Nachos con Queso', 'Bandeja para compartir', 15000.00, 1),
(9, 20, 'paleta dracula', 'helado', 5000.00, 1),
(10, 20, 'pepitop', 'helado ', 10000.00, 1),
(11, 20, 'pepitop', 'sas', 1212.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('cliente','admin') NOT NULL,
  `id_negocio` int(11) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `password`, `rol`, `id_negocio`, `creado_en`) VALUES
(9, 'PP', 'pepitoperez@Asapp.com', '$2y$10$2C304RMWougt3.dkgGAQaOFfHdzpE.Nkv01b3.PVOCsHh4lM/l8vi', 'admin', 20, '2025-10-03 06:53:02'),
(10, 'Hull', 'emaildeusuario@Asapp.com', '$2y$10$rBN79GQljDd7fG9.qqGDBeJZXI/saO.z.NMfKo62QBVB0qZeL9.O6', 'cliente', NULL, '2025-10-03 07:08:53'),
(11, 'emaildeusuario@asapp.com', 'davidsantiagorc@outlook.com', '$2y$10$hDYX4.Auwaf0GnCB2.mjeuycmoz/0/27o7matF1o3vcwc6nWyHZN2', 'admin', 21, '2025-10-07 20:21:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items_pedido`
--
ALTER TABLE `items_pedido`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indexes for table `negocios`
--
ALTER TABLE `negocios`
  ADD PRIMARY KEY (`id_negocio`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indexes for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD UNIQUE KEY `codigo_qr` (`codigo_qr`),
  ADD KEY `id_negocio` (`id_negocio`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_negocio` (`id_negocio`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_negocio` (`id_negocio`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items_pedido`
--
ALTER TABLE `items_pedido`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `negocios`
--
ALTER TABLE `negocios`
  MODIFY `id_negocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items_pedido`
--
ALTER TABLE `items_pedido`
  ADD CONSTRAINT `items_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `items_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Constraints for table `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuario_negocio` FOREIGN KEY (`id_negocio`) REFERENCES `negocios` (`id_negocio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
