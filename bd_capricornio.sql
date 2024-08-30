-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-07-2024 a las 17:46:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_capricornio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cargo`
--

CREATE TABLE `tb_cargo` (
  `id_cargo` int(11) NOT NULL,
  `nombre_cargo` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fyh_eliminacion` datetime DEFAULT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_cargo`
--

INSERT INTO `tb_cargo` (`id_cargo`, `nombre_cargo`, `created_at`, `updated_at`, `fyh_eliminacion`, `estado`) VALUES
(31, 'ADMINISTRATIVO', '2024-07-12 15:21:33', '2024-07-12 15:21:33', NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_clientes`
--

CREATE TABLE `tb_clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `tipo_urbanizacion` varchar(100) DEFAULT NULL,
  `reprogramar` varchar(50) DEFAULT NULL,
  `detalle_llamada` varchar(50) DEFAULT NULL,
  `detalle` text DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_llamada` date DEFAULT NULL,
  `hora_llamada` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fyh_eliminacion` datetime DEFAULT NULL,
  `estado` varchar(11) NOT NULL,
  `id_usuario_fk` int(11) DEFAULT NULL,
  `id_contacto_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_contactos`
--

CREATE TABLE `tb_contactos` (
  `id_contacto` int(11) NOT NULL,
  `celular` int(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fyh_eliminacion` datetime DEFAULT NULL,
  `detalle` varchar(255) DEFAULT NULL,
  `detalle_agenda` varchar(100) DEFAULT NULL,
  `estado` varchar(11) NOT NULL,
  `id_usuario_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_usuarios`
--

CREATE TABLE `tb_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ap_paterno` varchar(100) NOT NULL,
  `ap_materno` varchar(100) NOT NULL,
  `ci` varchar(255) NOT NULL,
  `exp` varchar(10) NOT NULL,
  `celular` varchar(10) DEFAULT NULL,
  `cargo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `direccion` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fyh_eliminacion` datetime DEFAULT NULL,
  `estado` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`id_usuario`, `nombre`, `ap_paterno`, `ap_materno`, `ci`, `exp`, `celular`, `cargo`, `email`, `direccion`, `password`, `created_at`, `updated_at`, `fyh_eliminacion`, `estado`) VALUES
(1, 'RONALD FRANCO', 'MAMANI', 'LLUSCO', '9962028', 'LP.', '77761730', 'ADMINISTRATIVO', 'ronald@gmail.com', 'EL ALTO SATELITE', '$2y$10$UL7.dH8ki3kFFi.1yLzfEufUytKyHVSLiB.7zDPoFKUjUnpfgNxYm', '2024-07-01 13:47:38', '2024-07-01 19:18:28', NULL, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_cargo`
--
ALTER TABLE `tb_cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_usuario_fk` (`id_usuario_fk`),
  ADD KEY `id_contacto_fk` (`id_contacto_fk`);

--
-- Indices de la tabla `tb_contactos`
--
ALTER TABLE `tb_contactos`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_usuario_fk` (`id_usuario_fk`);

--
-- Indices de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_cargo`
--
ALTER TABLE `tb_cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `tb_contactos`
--
ALTER TABLE `tb_contactos`
  MODIFY `id_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `tb_usuarios`
--
ALTER TABLE `tb_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tb_clientes`
--
ALTER TABLE `tb_clientes`
  ADD CONSTRAINT `tb_clientes_ibfk_1` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tb_usuarios` (`id_usuario`),
  ADD CONSTRAINT `tb_clientes_ibfk_2` FOREIGN KEY (`id_contacto_fk`) REFERENCES `tb_contactos` (`id_contacto`);

--
-- Filtros para la tabla `tb_contactos`
--
ALTER TABLE `tb_contactos`
  ADD CONSTRAINT `tb_contactos_ibfk_1` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tb_usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
