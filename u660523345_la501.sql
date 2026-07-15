-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-07-2026 a las 15:10:56
-- Versión del servidor: 11.8.8-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u660523345_la501`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `icono` varchar(100) NOT NULL,
  `categoria` enum('compras','reservaciones','fidelidad','variedad','especial') NOT NULL,
  `requisito` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `achievements`
--

INSERT INTO `achievements` (`id`, `slug`, `nombre`, `descripcion`, `icono`, `categoria`, `requisito`, `created_at`, `updated_at`) VALUES
(1, 'primera_orden', 'Primera Orden', 'Realizaste tu primer pedido en La 501.', '🍔', 'compras', 1, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(2, '5_ordenes', 'Cliente Habitual', 'Has realizado 5 pedidos. ¡Ya eres parte de la familia!', '🔥', 'compras', 5, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(3, '10_ordenes', 'Fan de La 501', 'Has realizado 10 pedidos. ¡Eres un verdadero fan!', '⭐', 'compras', 10, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(4, '25_ordenes', 'Cliente Frecuente', '25 pedidos. La 501 ya es tu segundo hogar.', '🏅', 'compras', 25, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(5, '50_ordenes', 'Leyenda de La 501', '50 pedidos. Eres una leyenda del restaurante.', '👑', 'compras', 50, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(6, 'primera_reserva', 'Primera Mesa', 'Reservaste tu primera mesa en La 501.', '📅', 'reservaciones', 1, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(7, '5_reservas', 'Reservador Experto', 'Has reservado mesa 5 veces.', '🗓️', 'reservaciones', 5, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(8, '10_reservas', 'Cliente VIP', '10 reservaciones. Eres un cliente VIP.', '💎', 'reservaciones', 10, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(9, '1_mes', '1 Mes con Nosotros', 'Llevas 1 mes siendo parte de La 501.', '📆', 'fidelidad', 1, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(10, '3_meses', '3 Meses Fiel', 'Llevas 3 meses con nosotros. ¡Gracias!', '🤝', 'fidelidad', 3, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(11, '6_meses', 'Medio Año', '6 meses siendo cliente de La 501.', '🎖️', 'fidelidad', 6, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(12, '1_anio', '1 Año en La 501', 'Un año completo con nosotros. ¡Felicidades!', '🎂', 'fidelidad', 12, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(13, '2_anios', 'Veterano', 'Dos años de fidelidad. Eres un veterano.', '🏆', 'fidelidad', 24, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(14, 'fan_hamburguesas', 'Fan de Hamburguesas', 'Has ordenado hamburguesas 5 veces.', '🍔', 'variedad', 5, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(15, 'fan_bar', 'Alma de la Barra', 'Has ordenado del bar 5 veces.', '🍺', 'variedad', 5, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(16, 'fan_alitas', 'Rey de las Alitas', 'Has ordenado alitas 5 veces.', '🍗', 'variedad', 5, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(17, 'explorador', 'Explorador del Menú', 'Has ordenado de al menos 4 categorías diferentes.', '🗺️', 'variedad', 4, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(18, 'noche_viernes', 'Alma de Viernes', 'Has hecho un pedido un viernes por la noche.', '🌙', 'especial', 1, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(19, 'grupo_grande', 'El del Grupo', 'Hiciste una reservación para más de 8 personas.', '👥', 'especial', 8, '2026-04-01 20:26:57', '2026-04-01 20:26:57'),
(20, 'puntos_100', 'Acumulador', 'Acumulaste 100 puntos de fidelidad.', '💰', 'especial', 100, '2026-04-01 20:26:57', '2026-04-01 20:26:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-0f42a6843ab5990b3b9db7bd7b14fdeb', 'i:1;', 1783466616),
('laravel-cache-0f42a6843ab5990b3b9db7bd7b14fdeb:timer', 'i:1783466616;', 1783466616),
('laravel-cache-17fbfdcaad5187cd77d91f982ecc79f4', 'i:2;', 1783437315),
('laravel-cache-17fbfdcaad5187cd77d91f982ecc79f4:timer', 'i:1783437315;', 1783437315),
('laravel-cache-2028bded811150e9ae1bd18d7c8cca8b', 'i:1;', 1783465792),
('laravel-cache-2028bded811150e9ae1bd18d7c8cca8b:timer', 'i:1783465792;', 1783465792),
('laravel-cache-57338f401b620656216ed3070d4cce54', 'i:1;', 1783442753),
('laravel-cache-57338f401b620656216ed3070d4cce54:timer', 'i:1783442753;', 1783442753),
('laravel-cache-5ec8de8f4597cb76a37d0909d2c0c116', 'i:3;', 1783466599),
('laravel-cache-5ec8de8f4597cb76a37d0909d2c0c116:timer', 'i:1783466599;', 1783466599),
('laravel-cache-69b3334c51a4830ae8547f40572842e2', 'i:8;', 1783439732),
('laravel-cache-69b3334c51a4830ae8547f40572842e2:timer', 'i:1783439732;', 1783439732),
('laravel-cache-766e3e601174cb028b25495bca33ce0e', 'i:6;', 1783439003),
('laravel-cache-766e3e601174cb028b25495bca33ce0e:timer', 'i:1783439003;', 1783439003),
('laravel-cache-7ed7af04abd66696a6698677bad407dd', 'i:2;', 1783442716),
('laravel-cache-7ed7af04abd66696a6698677bad407dd:timer', 'i:1783442716;', 1783442716),
('laravel-cache-9056aae3f1f67c664ddbcc7e986a7235', 'i:4;', 1783433797),
('laravel-cache-9056aae3f1f67c664ddbcc7e986a7235:timer', 'i:1783433797;', 1783433797),
('laravel-cache-999e3edaeef592b415936422e932e4b9', 'i:1;', 1783436434),
('laravel-cache-999e3edaeef592b415936422e932e4b9:timer', 'i:1783436434;', 1783436434),
('laravel-cache-a4342e7c6682a0c8449bc3863337c864', 'i:1;', 1783468819),
('laravel-cache-a4342e7c6682a0c8449bc3863337c864:timer', 'i:1783468819;', 1783468819),
('laravel-cache-ac08400b6ba571cbf296ebc7a9f30de0', 'i:5;', 1783440484),
('laravel-cache-ac08400b6ba571cbf296ebc7a9f30de0:timer', 'i:1783440484;', 1783440484),
('laravel-cache-ada01b031088938e0f81064fd9cdd741', 'i:3;', 1783440140),
('laravel-cache-ada01b031088938e0f81064fd9cdd741:timer', 'i:1783440140;', 1783440140);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carousel_slides`
--

CREATE TABLE `carousel_slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `carousel_slides`
--

INSERT INTO `carousel_slides` (`id`, `image_path`, `subtitle`, `title`, `description`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'https://res.cloudinary.com/decigylbc/image/upload/v1783380283/xh54fikeq3jjdil4qb1j.png', 'Gourmet & Grill', 'SABOR INIGUALABLE', 'Las mejores hamburguesas a la parrilla y cerveza artesanal bien fría.', 1, 1, '2026-07-05 02:56:20', '2026-07-06 17:24:44'),
(2, 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200&auto=format&fit=crop', 'La emoción del juego', 'PASIÓN DEPORTIVA', 'El mejor ambiente familiar para disfrutar de tus deportes favoritos.', 2, 1, '2026-07-05 02:56:20', '2026-07-05 02:56:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `type` enum('pregunta','sugerencia','queja') NOT NULL DEFAULT 'pregunta',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('pendiente','respondido') NOT NULL DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `type`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Luis Angel Hernandez Hernandez', 'mr.dimanh758@gmail.com', 'sugerencia', 'marketing', 'Hola querido 501 creo que tengo muy buenas ideas para su negocio', 'respondido', '2026-03-08 23:33:53', '2026-03-08 23:35:31'),
(6, 'Luis Angel Hernandez Hernandez', 'mr.dimanh758@gmail.com', 'pregunta', 'marketing', 'asdfghjklñ{', 'pendiente', '2026-03-09 21:39:38', '2026-03-09 21:39:38'),
(7, 'asdasdasda', 'na@gmail.com', 'pregunta', '12lajdmm', 'holqksm ajd', 'pendiente', '2026-03-22 20:18:18', '2026-03-22 20:18:18'),
(8, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:46:54', '2026-03-23 21:46:54'),
(9, 'http://www.google.com/', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:38', '2026-03-23 21:47:38'),
(10, 'http://www.google.com:80/', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:40', '2026-03-23 21:47:40'),
(11, 'http://www.google.com', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:41', '2026-03-23 21:47:41'),
(12, 'http://www.google.com/search?q=ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:42', '2026-03-23 21:47:42'),
(13, 'http://www.google.com:80/search?q=ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:44', '2026-03-23 21:47:44'),
(14, 'www.google.com/', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:45', '2026-03-23 21:47:45'),
(15, 'www.google.com:80/', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:47', '2026-03-23 21:47:47'),
(16, 'www.google.com', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:48', '2026-03-23 21:47:48'),
(17, 'www.google.com/search?q=ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:49', '2026-03-23 21:47:49'),
(18, 'www.google.com:80/search?q=ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:47:51', '2026-03-23 21:47:51'),
(19, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://www.google.com/', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:22', '2026-03-23 21:48:22'),
(20, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://www.google.com:80/', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:23', '2026-03-23 21:48:23'),
(21, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://www.google.com', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:25', '2026-03-23 21:48:25'),
(22, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://www.google.com/search?q=ZAP', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:26', '2026-03-23 21:48:26'),
(23, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://www.google.com:80/search?q=ZAP', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:28', '2026-03-23 21:48:28'),
(24, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'www.google.com/', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:29', '2026-03-23 21:48:29'),
(25, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'www.google.com:80/', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:30', '2026-03-23 21:48:30'),
(26, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'www.google.com', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:32', '2026-03-23 21:48:32'),
(27, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'www.google.com/search?q=ZAP', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:33', '2026-03-23 21:48:33'),
(28, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'www.google.com:80/search?q=ZAP', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:48:34', '2026-03-23 21:48:34'),
(29, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://www.google.com/', 'pendiente', '2026-03-23 21:48:36', '2026-03-23 21:48:36'),
(30, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://www.google.com:80/', 'pendiente', '2026-03-23 21:48:37', '2026-03-23 21:48:37'),
(31, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://www.google.com', 'pendiente', '2026-03-23 21:48:38', '2026-03-23 21:48:38'),
(32, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://www.google.com/search?q=ZAP', 'pendiente', '2026-03-23 21:48:40', '2026-03-23 21:48:40'),
(33, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://www.google.com:80/search?q=ZAP', 'pendiente', '2026-03-23 21:48:41', '2026-03-23 21:48:41'),
(34, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'www.google.com/', 'pendiente', '2026-03-23 21:48:42', '2026-03-23 21:48:42'),
(35, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'www.google.com:80/', 'pendiente', '2026-03-23 21:48:44', '2026-03-23 21:48:44'),
(36, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'www.google.com', 'pendiente', '2026-03-23 21:48:45', '2026-03-23 21:48:45'),
(37, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'www.google.com/search?q=ZAP', 'pendiente', '2026-03-23 21:48:46', '2026-03-23 21:48:46'),
(38, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'www.google.com:80/search?q=ZAP', 'pendiente', '2026-03-23 21:48:48', '2026-03-23 21:48:48'),
(39, '7445158636607355120.owasp.org', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:36', '2026-03-23 21:49:36'),
(40, 'https://7445158636607355120.owasp.org', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:38', '2026-03-23 21:49:38'),
(41, 'https://7445158636607355120%2eowasp%2eorg', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:39', '2026-03-23 21:49:39'),
(42, '5;URL=\'https://7445158636607355120.owasp.org\'', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:40', '2026-03-23 21:49:40'),
(43, 'URL=\'http://7445158636607355120.owasp.org\'', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:42', '2026-03-23 21:49:42'),
(44, 'https://7445158636607355120.owasp.org/?ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:43', '2026-03-23 21:49:43'),
(45, '5;URL=\'https://7445158636607355120.owasp.org/?ZAP\'', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:45', '2026-03-23 21:49:45'),
(46, 'https://\\7445158636607355120.owasp.org', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:46', '2026-03-23 21:49:46'),
(47, 'http://\\7445158636607355120.owasp.org', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:49:48', '2026-03-23 21:49:48'),
(48, 'ZAP', 'zaproxy@example.com', 'sugerencia', '7445158636607355120.owasp.org', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:15', '2026-03-23 21:50:15'),
(49, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'https://7445158636607355120.owasp.org', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:16', '2026-03-23 21:50:16'),
(50, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'https://7445158636607355120%2eowasp%2eorg', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:18', '2026-03-23 21:50:18'),
(51, 'ZAP', 'zaproxy@example.com', 'sugerencia', '5;URL=\'https://7445158636607355120.owasp.org\'', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:19', '2026-03-23 21:50:19'),
(52, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'URL=\'http://7445158636607355120.owasp.org\'', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:20', '2026-03-23 21:50:20'),
(53, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'https://7445158636607355120.owasp.org/?Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:22', '2026-03-23 21:50:22'),
(54, 'ZAP', 'zaproxy@example.com', 'sugerencia', '5;URL=\'https://7445158636607355120.owasp.org/?Zaproxy dolore alias impedit expedita quisquam.\'', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:23', '2026-03-23 21:50:23'),
(55, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'https://\\7445158636607355120.owasp.org', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:24', '2026-03-23 21:50:24'),
(56, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'http://\\7445158636607355120.owasp.org', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:26', '2026-03-23 21:50:26'),
(57, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '7445158636607355120.owasp.org', 'pendiente', '2026-03-23 21:50:27', '2026-03-23 21:50:27'),
(58, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'https://7445158636607355120.owasp.org', 'pendiente', '2026-03-23 21:50:28', '2026-03-23 21:50:28'),
(59, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'https://7445158636607355120%2eowasp%2eorg', 'pendiente', '2026-03-23 21:50:30', '2026-03-23 21:50:30'),
(60, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '5;URL=\'https://7445158636607355120.owasp.org\'', 'pendiente', '2026-03-23 21:50:31', '2026-03-23 21:50:31'),
(61, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'URL=\'http://7445158636607355120.owasp.org\'', 'pendiente', '2026-03-23 21:50:32', '2026-03-23 21:50:32'),
(62, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'https://7445158636607355120.owasp.org/?Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:50:34', '2026-03-23 21:50:34'),
(63, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '5;URL=\'https://7445158636607355120.owasp.org/?Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.\'', 'pendiente', '2026-03-23 21:50:35', '2026-03-23 21:50:35'),
(64, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'https://\\7445158636607355120.owasp.org', 'pendiente', '2026-03-23 21:50:36', '2026-03-23 21:50:36'),
(65, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'http://\\7445158636607355120.owasp.org', 'pendiente', '2026-03-23 21:50:38', '2026-03-23 21:50:38'),
(66, '<!--#EXEC cmd=\"ls /\"-->', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:18', '2026-03-23 21:51:18'),
(67, '\"><!--#EXEC cmd=\"ls /\"--><', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:21', '2026-03-23 21:51:21'),
(68, '<!--#EXEC cmd=\"dir \\\"-->', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:23', '2026-03-23 21:51:23'),
(69, '\"><!--#EXEC cmd=\"dir \\\"--><', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:25', '2026-03-23 21:51:25'),
(70, 'ZAP', 'zaproxy@example.com', 'sugerencia', '<!--#EXEC cmd=\"ls /\"-->', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:43', '2026-03-23 21:51:43'),
(71, 'ZAP', 'zaproxy@example.com', 'sugerencia', '\"><!--#EXEC cmd=\"ls /\"--><', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:46', '2026-03-23 21:51:46'),
(72, 'ZAP', 'zaproxy@example.com', 'sugerencia', '<!--#EXEC cmd=\"dir \\\"-->', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:48', '2026-03-23 21:51:48'),
(73, 'ZAP', 'zaproxy@example.com', 'sugerencia', '\"><!--#EXEC cmd=\"dir \\\"--><', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:51:50', '2026-03-23 21:51:50'),
(74, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '<!--#EXEC cmd=\"ls /\"-->', 'pendiente', '2026-03-23 21:51:52', '2026-03-23 21:51:52'),
(75, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '\"><!--#EXEC cmd=\"ls /\"--><', 'pendiente', '2026-03-23 21:51:54', '2026-03-23 21:51:54'),
(76, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '<!--#EXEC cmd=\"dir \\\"-->', 'pendiente', '2026-03-23 21:51:56', '2026-03-23 21:51:56'),
(77, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', '\"><!--#EXEC cmd=\"dir \\\"--><', 'pendiente', '2026-03-23 21:51:58', '2026-03-23 21:51:58'),
(78, '\'', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:27', '2026-03-23 21:52:27'),
(79, 'ZAP\'', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:29', '2026-03-23 21:52:29'),
(80, '\"', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:30', '2026-03-23 21:52:30'),
(81, 'ZAP\"', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:32', '2026-03-23 21:52:32'),
(82, ';', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:33', '2026-03-23 21:52:33'),
(83, 'ZAP;', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:35', '2026-03-23 21:52:35'),
(84, '\'(', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:36', '2026-03-23 21:52:36'),
(85, 'ZAP\'(', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:38', '2026-03-23 21:52:38'),
(86, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:39', '2026-03-23 21:52:39'),
(87, 'ZAP', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:40', '2026-03-23 21:52:40'),
(88, 'ZAP AND 1=1 --', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:42', '2026-03-23 21:52:42'),
(89, 'ZAP AND 1=2 --', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'pendiente', '2026-03-23 21:52:44', '2026-03-23 21:52:44'),
(90, 'ZAP OR 1=1 --', 'zaproxy@example.com', 'sugerencia', 'Zaproxy dolore alias impedit expedita quisquam.', 'Zaproxy alias impedit expedita quisquam pariatur exercitationem. Nemo rerum eveniet dolores rem quia dignissimos.', 'respondido', '2026-03-23 21:52:45', '2026-04-14 12:15:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingredientes`
--

CREATE TABLE `ingredientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad_usada` decimal(8,2) NOT NULL DEFAULT 1.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ingredientes`
--

INSERT INTO `ingredientes` (`id`, `product_id`, `inventory_id`, `nombre`, `cantidad_usada`, `created_at`, `updated_at`) VALUES
(10, 17, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(11, 17, 12, 'Boneless de Pollo', 0.15, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(12, 17, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(13, 17, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(14, 17, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(15, 17, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(16, 17, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(17, 17, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(18, 18, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(19, 18, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(20, 18, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(21, 18, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(22, 18, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(23, 19, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(24, 19, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(25, 19, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(26, 19, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(27, 19, 34, 'Cebolla Morada', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(28, 19, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(29, 19, 46, 'Piña', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(30, 20, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(31, 20, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(32, 20, 16, 'Salchichón', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(33, 20, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(34, 20, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(35, 20, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(36, 20, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(37, 20, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(38, 22, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(39, 22, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(40, 22, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(41, 22, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(42, 22, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(43, 22, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(44, 22, 54, 'Aros de Cebolla', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(45, 23, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(46, 23, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(47, 23, 19, 'Chorizo Argentino', 0.08, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(48, 23, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(49, 23, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(50, 23, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(51, 23, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(52, 23, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(53, 24, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(54, 24, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(55, 24, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(56, 24, 15, 'Jamón', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(57, 24, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(58, 24, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(59, 25, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(60, 25, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(61, 25, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(62, 25, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(63, 25, 34, 'Cebolla Morada', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(64, 25, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(65, 25, 23, 'Camarón', 0.10, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(66, 25, 24, 'Surimi', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(67, 198, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(68, 198, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(69, 198, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(70, 198, 15, 'Jamón', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(71, 198, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(72, 198, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(73, 198, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(74, 198, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(75, 198, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(76, 199, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(77, 199, 12, 'Boneless de Pollo', 0.15, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(78, 199, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(79, 199, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(80, 199, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(81, 199, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(82, 199, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(83, 199, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(84, 200, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(85, 200, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(86, 200, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(87, 200, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(88, 200, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(89, 201, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(90, 201, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(91, 201, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(92, 201, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(93, 201, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(94, 201, 34, 'Cebolla Morada', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(95, 201, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(96, 201, 46, 'Piña', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(97, 202, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(98, 202, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(99, 202, 16, 'Salchichón', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(100, 202, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(101, 202, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(102, 202, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(103, 202, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(104, 202, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(105, 203, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(106, 203, 10, 'Carne de Arrachera', 0.15, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(107, 203, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(108, 203, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(109, 203, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(110, 203, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(111, 203, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(112, 204, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(113, 204, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(114, 204, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(115, 204, 25, 'Queso Amarillo', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(116, 204, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(117, 204, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(118, 204, 54, 'Aros de Cebolla', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(119, 205, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(120, 205, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(121, 205, 19, 'Chorizo Argentino', 0.08, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(122, 205, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(123, 205, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(124, 205, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(125, 205, 33, 'Cebolla Blanca', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(126, 205, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(127, 206, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(128, 206, 9, 'Carne de Res', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(129, 206, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(130, 206, 15, 'Jamón', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(131, 206, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(132, 206, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(133, 207, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(134, 207, 14, 'Tocino', 0.04, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(135, 207, 28, 'Queso Mozzarella', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(136, 207, 32, 'Jitomate', 0.03, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(137, 207, 34, 'Cebolla Morada', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(138, 207, 35, 'Lechuga', 0.02, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(139, 207, 23, 'Camarón', 0.10, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(140, 207, 24, 'Surimi', 0.05, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(141, 208, 70, 'Pan de Hamburguesa', 1.00, '2026-06-29 14:27:22', '2026-06-29 14:27:22'),
(160, 16, NULL, 'Pan de Hamburguesa', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(161, 16, NULL, 'Carne de Res', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(162, 16, NULL, 'Tocino', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(163, 16, NULL, 'Jamón', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(164, 16, NULL, 'Queso Amarillo', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(165, 16, NULL, 'Queso Mozzarella', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(166, 16, NULL, 'Jitomate', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(167, 16, NULL, 'Cebolla Blanca', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48'),
(168, 16, NULL, 'Lechuga', 1.00, '2026-07-07 10:26:48', '2026-07-07 10:26:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `unit` varchar(50) NOT NULL COMMENT 'kg, L, pz, cajas, etc.',
  `current_stock` decimal(8,2) NOT NULL DEFAULT 0.00,
  `min_stock` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inventories`
--

INSERT INTO `inventories` (`id`, `name`, `category`, `unit`, `current_stock`, `min_stock`, `created_at`, `updated_at`) VALUES
(9, 'Carne de res (Hamburguesa)', 'Carnes', 'pz', 0.00, 20.00, '2026-03-08 16:40:59', '2026-07-03 13:43:25'),
(10, 'Arrachera', 'Carnes', 'kg', 14.85, 5.00, '2026-03-08 16:40:59', '2026-07-03 12:17:56'),
(11, 'Pechuga de pollo', 'Carnes', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(12, 'Boneless de pollo', 'Carnes', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-07-03 13:28:21'),
(13, 'Alitas de pollo', 'Carnes', 'kg', 6.00, 10.00, '2026-03-08 16:40:59', '2026-03-08 16:59:24'),
(14, 'Tocino', 'Carnes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-07-03 13:43:25'),
(15, 'Jamón', 'Carnes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-07-03 13:25:54'),
(16, 'Salchichón', 'Carnes', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(17, 'Salchicha para Jocho', 'Carnes', 'pz', 0.00, 30.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(18, 'Salchicha Italiana', 'Carnes', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(19, 'Chorizo Argentino', 'Carnes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(20, 'Chistorra', 'Carnes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(21, 'Pepperoni', 'Carnes', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(22, 'Jamón Serrano', 'Carnes', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(23, 'Camarón', 'Mariscos', 'kg', 5.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 17:12:06'),
(24, 'Surimi', 'Mariscos', 'kg', 3.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 17:12:16'),
(25, 'Queso Amarillo (Rebanadas)', 'Lácteos', 'pz', 0.00, 50.00, '2026-03-08 16:40:59', '2026-07-03 13:28:21'),
(26, 'Queso Manchego', 'Lácteos', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(27, 'Queso Gouda', 'Lácteos', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(28, 'Queso Mozzarella', 'Lácteos', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-07-03 13:25:54'),
(29, 'Queso Parmesano', 'Lácteos', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(30, 'Leche Condensada', 'Lácteos', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(31, 'Helado de Vainilla', 'Lácteos', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(32, 'Jitomate', 'Verduras', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-07-03 13:43:25'),
(33, 'Cebolla Blanca', 'Verduras', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-07-03 13:28:21'),
(34, 'Cebolla Morada', 'Verduras', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-06-30 10:18:37'),
(35, 'Lechuga', 'Verduras', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-07-03 13:43:25'),
(36, 'Espinaca', 'Verduras', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(37, 'Aguacate', 'Verduras', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(38, 'Champiñones', 'Verduras', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(39, 'Jalapeños Frescos', 'Verduras', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(40, 'Pimiento Rojo', 'Verduras', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(41, 'Aceitunas', 'Verduras', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(42, 'Ajo', 'Verduras', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(43, 'Albahaca Fresca', 'Verduras', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(44, 'Hierbabuena', 'Verduras', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(45, 'Limón', 'Verduras', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(46, 'Piña', 'Frutas', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-06-30 10:18:37'),
(47, 'Mango', 'Frutas', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(48, 'Fresa', 'Frutas', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(49, 'Manzana', 'Frutas', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(50, 'Arándano Fresco', 'Frutas', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(51, 'Sandía', 'Frutas', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(52, 'Papas a la Francesa (Congeladas)', 'Abarrotes', 'kg', 0.00, 10.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(53, 'Papas Crisscut (Congeladas)', 'Abarrotes', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(54, 'Aros de Cebolla (Congelados)', 'Abarrotes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(55, 'Totopos', 'Abarrotes', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(56, 'Tiritas de maíz frito', 'Abarrotes', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(57, 'Frijoles Refritos', 'Abarrotes', 'kg', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(58, 'Chilli con carne', 'Abarrotes', 'kg', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(59, 'Mayonesa', 'Salsas', 'L', 0.00, 4.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(60, 'Cátsup', 'Salsas', 'L', 0.00, 4.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(61, 'Mostaza', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(62, 'Salsa BBQ Hot', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(63, 'Salsa Teriyaki', 'Salsas', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(64, 'Salsa Habanero Cremoso', 'Salsas', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(65, 'Aderezo Chipotle', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(66, 'Aderezo Ranch', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(67, 'Aderezo César', 'Salsas', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(68, 'Aceite Macha', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-04-14 12:15:19'),
(69, 'Chimichurri', 'Salsas', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(70, 'Pan de Hamburguesa', 'Panadería', 'pz', 0.00, 40.00, '2026-03-08 16:40:59', '2026-07-03 13:43:25'),
(71, 'Pan de Jocho', 'Panadería', 'pz', 0.00, 40.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(72, 'Tortilla de Harina (Burritos)', 'Panadería', 'pz', 0.00, 30.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(73, 'Crotones', 'Panadería', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(74, 'Galletas Oreo', 'Dulces', 'pz', 0.00, 20.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(75, 'Cheesecake Frutos Rojos', 'Postres', 'pz', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(76, 'Cheesecake Oreo', 'Postres', 'pz', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(77, 'Jugo de Piña', 'Insumos Bar', 'L', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(78, 'Jugo de Arándano', 'Insumos Bar', 'L', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(79, 'Jugo de Naranja', 'Insumos Bar', 'L', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(80, 'Jugo de Toronja', 'Insumos Bar', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(81, 'Crema de Coco', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(82, 'Granadina', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(83, 'Miel de Agave', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(84, 'Jarabe Endulzante (Sirope Natural)', 'Insumos Bar', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(85, 'Sirope de Jengibre', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(86, 'Sirope de Lavanda', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(87, 'Sirope de Fruta Dragón', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(88, 'Azul de Curazao', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(89, 'Licor de Naranja (Controy/Triple Sec)', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(90, 'Licor de Coco', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(91, 'Chamoy', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(92, 'Sangrita', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(93, 'Tajín', 'Insumos Bar', 'kg', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(94, 'Pulpa de Guanábana', 'Insumos Bar', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(95, 'Concentrado de Jamaica', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(96, 'Concentrado de Tamarindo', 'Insumos Bar', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(97, 'Granos de Café (Espresso)', 'Insumos Bar', 'kg', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(98, 'Ron Blanco (Bacardí/Captain)', 'Alcohol', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(99, 'Ron Malibú', 'Alcohol', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(100, 'Vodka (Smirnoff/Absolut)', 'Alcohol', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(101, 'Tequila Blanco', 'Alcohol', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(102, 'Tequila Reposado', 'Alcohol', 'L', 0.00, 3.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(103, 'Mezcal Espadín', 'Alcohol', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(104, 'Ginebra', 'Alcohol', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(105, 'Brandy (Torres)', 'Alcohol', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(106, 'Whisky', 'Alcohol', 'L', 0.00, 2.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(107, 'Licor 43', 'Alcohol', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(108, 'Crema Irlandesa (Baileys)', 'Alcohol', 'L', 0.00, 1.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(109, 'Agua Mineral Topochico', 'Bebidas', 'pz', 0.00, 24.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(110, 'Coca Cola 600ml', 'Bebidas', 'pz', 0.00, 24.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(111, 'Refresco de Lima (Sprite/7Up)', 'Bebidas', 'L', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(112, 'Refresco de Toronja (Squirt)', 'Bebidas', 'L', 0.00, 5.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(113, 'Ginger Ale', 'Bebidas', 'pz', 0.00, 12.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(114, 'Agua Tónica', 'Bebidas', 'pz', 0.00, 12.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(115, 'Escuis (Variados)', 'Bebidas', 'pz', 0.00, 24.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(116, 'Cerveza Corona', 'Bebidas', 'pz', 0.00, 48.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(117, 'Cerveza Victoria', 'Bebidas', 'pz', 0.00, 48.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(118, 'Cerveza Ultra', 'Bebidas', 'pz', 0.00, 48.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59'),
(119, 'Cerveza Cero', 'Bebidas', 'pz', 0.00, 24.00, '2026-03-08 16:40:59', '2026-03-08 16:40:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000002_create_jobs_table', 1),
(2, '2026_02_01_204222_add_restaurant_fields_to_users_table', 2),
(3, '2026_02_04_181543_add_image_to_products_table', 3),
(4, '2026_02_04_182338_add_image_to_products_table', 3),
(5, '2026_03_31_194341_add_avatar_to_users_table', 4),
(6, '2026_06_27_000000_add_exclusiones_to_order_items_table', 5),
(7, '2026_06_29_140000_add_excluded_ingredients_to_order_items_table', 5),
(8, '2026_06_29_141000_add_inventory_fields_to_ingredientes_table', 5),
(9, '2026_07_05_024022_create_carousel_slides_table', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) NOT NULL DEFAULT 'Deportes',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` date DEFAULT NULL COMMENT 'Fecha desde la que se muestra al publico',
  `end_date` date DEFAULT NULL COMMENT 'Fecha en la que se oculta al publico',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `category`, `active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(2, 'agbvcq', 'dasdsa2f', 'news/qdGUcfErroOf6BlGmpRWazIaZQKfuBdGNPLntTkv.jpg', 'Evento', 1, '2026-03-01', '2026-03-23', '2026-03-01 02:30:37', '2026-03-01 23:11:00'),
(3, 'dasdsa', 'dasdsad', 'news/W7ytqggXTlmh0OiSxrhcckxTEYy6KOLvYlpgVNCA.jpg', 'Aviso', 1, '2026-03-02', '2026-03-01', '2026-03-01 19:08:24', '2026-03-02 20:49:07'),
(5, 'd', 'd', 'news/AvMKyzq5O020K7AhzACmvhsXR1RQbsdPQu0mqrRm.jpg', 'Deportes', 1, '2026-03-01', '2026-03-18', '2026-03-01 19:47:02', '2026-03-01 23:10:46'),
(7, 'dasdas', 'vxczzcxzx', 'news/uylOQWHL4Cg0GsOsIt9E8FGUJFEsDifTZtwN86EL.png', 'Deportes', 1, '2026-03-01', '2026-03-20', '2026-03-01 19:52:30', '2026-03-19 00:01:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'ID del cliente si está logueado',
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `customer_address` text DEFAULT NULL COMMENT 'Null si es para comer en local o pasar a recoger',
  `table_number` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','paid','failed','preparing','ready','delivered') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL COMMENT 'tarjeta, efectivo, mercadopago',
  `payment_id` varchar(255) DEFAULT NULL COMMENT 'ID de la transacción en MercadoPago/Stripe',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_phone`, `customer_address`, `table_number`, `total`, `status`, `payment_method`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 42.00, 'ready', 'efectivo', NULL, '2026-03-02 15:15:33', '2026-06-30 12:00:06'),
(2, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 3772.00, 'ready', 'efectivo', NULL, '2026-03-02 15:16:30', '2026-06-30 12:00:08'),
(3, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 15:20:16', '2026-06-30 12:00:15'),
(4, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 15:20:35', '2026-06-30 12:00:17'),
(5, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 15:23:40', '2026-06-30 12:00:18'),
(6, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'efectivo', NULL, '2026-03-02 15:25:55', '2026-06-30 12:00:20'),
(7, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 15:26:18', '2026-06-30 12:00:21'),
(8, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 15:31:06', '2026-06-30 12:00:41'),
(9, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 15:31:13', '2026-06-30 12:00:47'),
(10, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 15:31:26', '2026-06-30 12:00:49'),
(11, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 16:07:06', '2026-06-30 12:00:51'),
(12, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:07:22', '2026-06-30 12:00:54'),
(13, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:07:34', '2026-06-30 12:01:00'),
(14, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:08:22', '2026-06-30 12:01:01'),
(15, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:10:43', '2026-06-30 12:01:03'),
(16, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:18:34', '2026-06-30 12:01:05'),
(17, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:18:46', '2026-06-30 12:01:07'),
(18, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:19:40', '2026-06-30 12:01:09'),
(19, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:21:26', '2026-06-30 12:01:10'),
(20, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:21:56', '2026-06-30 12:01:11'),
(21, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:22:24', '2026-06-30 12:01:12'),
(22, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:23:25', '2026-06-30 12:01:34'),
(23, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:25:00', '2026-06-30 12:01:34'),
(24, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:27:12', '2026-06-30 12:01:35'),
(25, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:35:14', '2026-06-30 12:01:36'),
(26, NULL, 'asd', '1234567890', 'dasdasda', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:36:38', '2026-06-30 12:01:37'),
(27, NULL, 'adsad', '1234567991', 'asdasd', NULL, 682.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:38:59', '2026-06-30 12:01:38'),
(28, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 16:43:16', '2026-06-30 12:01:38'),
(29, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 16:50:17', '2026-06-30 12:01:39'),
(30, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-02 16:52:03', '2026-06-30 12:01:40'),
(31, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'tarjeta', NULL, '2026-03-02 16:52:15', '2026-06-30 12:01:40'),
(32, NULL, 'Angel Hernandez', '7713497438', 'MIRADOR', NULL, 1364.00, 'ready', 'efectivo', NULL, '2026-03-02 17:09:40', '2026-06-30 12:01:41'),
(33, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 639.00, 'ready', 'efectivo', NULL, '2026-03-02 20:38:22', '2026-06-30 12:01:41'),
(34, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 210.00, 'ready', 'efectivo', NULL, '2026-03-02 20:40:16', '2026-06-30 12:01:42'),
(35, 9, 'Mesa 56', 'Local', 'Consumo en sucursal', NULL, 246.00, 'ready', 'efectivo', NULL, '2026-03-03 17:44:38', '2026-06-30 12:01:44'),
(36, NULL, 'Luis Angel Hernandez Hernandez', '7712174809', 'Aldama, Tahuizan, 43000 Huejutla de Reyes, Hgo.', NULL, 21.00, 'ready', 'efectivo', NULL, '2026-03-03 20:38:29', '2026-06-30 12:01:45'),
(37, NULL, 'Luis Angel Hernandez Hernandez', '771 217 4809', 'Aldama, Tahuizan, 43000 Huejutla de Reyes, Hgo.', NULL, 52.00, 'ready', 'efectivo', NULL, '2026-03-03 20:39:26', '2026-06-30 12:01:46'),
(38, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 20:42:40', '2026-06-30 12:01:47'),
(39, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 21:51:05', '2026-06-30 12:01:47'),
(40, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 21:54:26', '2026-06-30 12:01:48'),
(41, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 21:55:25', '2026-06-30 12:01:49'),
(42, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 21:55:37', '2026-06-30 12:01:50'),
(43, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:00:55', '2026-06-30 12:01:51'),
(44, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:09:35', '2026-06-30 12:01:53'),
(45, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:10:16', '2026-06-30 12:01:54'),
(46, NULL, 'Angel Hernandez', '7713497438', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:15:10', '2026-06-30 12:01:54'),
(47, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:16:41', '2026-06-30 12:01:55'),
(48, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:25:33', '2026-06-30 12:01:56'),
(49, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Hshs', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:34:53', '2026-06-30 12:01:56'),
(50, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Bdhs', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:35:26', '2026-06-30 12:01:57'),
(51, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Hhs', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 22:36:56', '2026-06-30 12:01:58'),
(52, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Ggg', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 23:52:18', '2026-06-30 12:01:58'),
(53, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Ggg', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 23:55:33', '2026-06-30 12:01:59'),
(54, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Gg', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-03 23:58:07', '2026-06-30 12:01:59'),
(55, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-04 14:36:53', '2026-06-30 12:02:00'),
(56, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-04 14:38:01', '2026-06-30 12:02:00'),
(57, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-04 14:42:21', '2026-06-30 12:02:01'),
(58, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-04 14:46:58', '2026-06-30 12:02:02'),
(59, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', '148805820450', '2026-03-04 14:54:49', '2026-06-30 12:02:02'),
(60, 1, 'Angel Hernandez', '7712457018', 'MIRADOR', NULL, 42.00, 'ready', 'tarjeta', '148806383208', '2026-03-04 14:59:51', '2026-06-30 12:02:02'),
(61, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 21.00, 'ready', 'tarjeta', NULL, '2026-03-04 16:51:19', '2026-06-30 12:02:04'),
(62, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'tarjeta', '148822601630', '2026-03-04 16:53:21', '2026-06-30 12:02:04'),
(63, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 341.00, 'ready', 'tarjeta', NULL, '2026-03-04 16:57:34', '2026-06-30 12:02:05'),
(64, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Huejutla', NULL, 426.00, 'ready', 'efectivo', NULL, '2026-03-04 21:00:58', '2026-06-30 12:02:05'),
(65, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 213.00, 'ready', 'tarjeta', NULL, '2026-03-04 21:08:08', '2026-06-30 12:02:05'),
(66, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-04 21:17:18', '2026-06-30 12:02:06'),
(67, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-04 21:19:05', '2026-06-30 12:02:06'),
(68, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-04 21:24:53', '2026-06-30 12:02:07'),
(69, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 21.00, 'ready', 'efectivo', NULL, '2026-03-04 21:58:10', '2026-06-30 12:02:08'),
(70, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-04 22:06:31', '2026-06-30 12:02:08'),
(71, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Universidad Tecnológica de la Huasteca Hidalguense, Carr. Huejutla - Chalahuiyapa S/N, Col.Tepoxteco, 43000 Huejutla de Reyes, Hgo.', NULL, 426.00, 'ready', 'efectivo', NULL, '2026-03-04 22:09:57', '2026-06-30 12:02:09'),
(72, NULL, 'Luis Angel Hernandez Hernandez', '7712976220', 'Calactoc', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-04 23:28:50', '2026-06-30 12:02:13'),
(73, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Fg', NULL, 213.00, 'ready', 'efectivo', NULL, '2026-03-05 19:09:06', '2026-06-30 12:02:14'),
(74, NULL, 'Fg', '5', 'Gg', NULL, 123.00, 'ready', 'efectivo', NULL, '2026-03-05 19:20:21', '2026-06-30 12:02:16'),
(75, NULL, 'aaasdlkaskd', '7712994676', 'adaskjdkad', NULL, 213.00, 'ready', 'tarjeta', '149033812996', '2026-03-05 23:05:59', '2026-06-30 12:02:18'),
(76, NULL, 'asfsad', '7712994676', 'asjdhajhsd', NULL, 341.00, 'ready', 'efectivo', NULL, '2026-03-05 23:08:20', '2026-06-30 12:02:19'),
(77, NULL, 'Angel Hernandez', '7713497438', 'MIRADOR', NULL, 224.00, 'ready', 'efectivo', NULL, '2026-03-08 04:50:44', '2026-06-30 12:02:25'),
(78, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'efectivo', NULL, '2026-03-08 05:32:56', '2026-06-30 12:02:26'),
(79, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'efectivo', NULL, '2026-03-08 05:36:15', '2026-06-30 12:02:26'),
(80, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'efectivo', NULL, '2026-03-08 05:36:41', '2026-06-30 12:02:27'),
(81, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', NULL, '2026-03-08 17:04:09', '2026-06-30 12:02:27'),
(82, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', NULL, '2026-03-08 17:21:25', '2026-06-30 12:02:28'),
(83, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', '148726632825', '2026-03-08 17:21:57', '2026-06-30 12:02:29'),
(84, NULL, 'ghhghfhf', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', '148896779925', '2026-03-09 21:03:56', '2026-06-30 12:02:31'),
(85, 9, 'Mesa 1', 'Local', 'Consumo en sucursal', NULL, 307.00, 'ready', 'pendiente', NULL, '2026-03-18 13:14:19', '2026-06-30 12:00:35'),
(86, 9, 'Mesa 1', 'Local', 'Consumo en sucursal', NULL, 195.00, 'ready', 'pendiente', NULL, '2026-03-18 13:29:49', '2026-06-30 12:00:39'),
(87, 9, 'Mesa 2', 'Local', 'Consumo en sucursal', NULL, 224.00, 'ready', 'pendiente', NULL, '2026-03-18 13:30:17', '2026-06-30 12:00:38'),
(88, 9, 'Mesa 3', 'Local', 'Consumo en sucursal', NULL, 307.00, 'ready', 'pendiente', NULL, '2026-03-18 13:31:39', '2026-06-30 12:00:39'),
(89, 9, 'Mesa 2', 'Local', 'Consumo en sucursal', NULL, 140.00, 'ready', 'pendiente', NULL, '2026-03-18 13:32:43', '2026-06-30 12:02:32'),
(90, 9, 'Mesa 1', 'Local', 'Consumo en sucursal', NULL, 707.00, 'ready', 'pendiente', NULL, '2026-03-18 13:35:21', '2026-06-30 12:02:34'),
(91, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 2038.00, 'paid', 'pendiente', NULL, '2026-03-18 13:37:55', '2026-03-18 13:38:23'),
(92, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 112.00, 'paid', 'pendiente', NULL, '2026-03-18 13:38:30', '2026-03-18 13:38:49'),
(93, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 125.00, 'paid', 'pendiente', NULL, '2026-03-18 13:38:34', '2026-03-18 13:38:55'),
(94, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 135.00, 'paid', 'pendiente', NULL, '2026-03-18 13:38:39', '2026-03-18 13:38:52'),
(95, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 307.00, 'paid', 'pendiente', NULL, '2026-03-18 13:56:53', '2026-03-18 13:57:09'),
(96, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-03-18 14:21:29', '2026-03-18 14:51:47'),
(97, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 140.00, 'paid', 'tarjeta', NULL, '2026-03-18 14:51:16', '2026-03-18 14:51:43'),
(99, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-03-18 14:59:27', '2026-03-18 14:59:33'),
(100, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'tarjeta', NULL, '2026-03-18 15:27:13', '2026-03-18 15:27:26'),
(102, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'tarjeta', '150993104388', '2026-03-19 00:41:56', '2026-06-30 12:02:41'),
(104, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 6045.00, 'paid', 'efectivo', NULL, '2026-03-26 12:37:35', '2026-03-26 12:37:38'),
(105, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'tarjeta', NULL, '2026-03-26 12:41:46', '2026-03-26 12:42:02'),
(106, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-04-11 16:11:58', '2026-04-14 19:13:18'),
(107, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-04-11 16:15:31', '2026-04-14 19:13:16'),
(108, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Hshsh', NULL, 112.00, 'ready', 'efectivo', NULL, '2026-04-14 22:09:16', '2026-06-30 12:02:51'),
(111, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-04-14 22:30:59', '2026-06-30 12:02:52'),
(112, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 120.00, 'ready', 'efectivo', NULL, '2026-04-14 22:31:44', '2026-06-30 12:02:56'),
(113, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Jdhs', NULL, 955.00, 'ready', 'efectivo', NULL, '2026-04-14 22:36:47', '2026-06-30 12:02:57'),
(1001, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-02-01 19:00:00', '2026-02-01 19:00:00'),
(1002, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993200100', '2026-02-01 20:15:00', '2026-02-01 20:15:00'),
(1003, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'efectivo', NULL, '2026-02-01 21:30:00', '2026-06-30 12:00:00'),
(1004, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-02-02 20:00:00', '2026-02-02 20:00:00'),
(1005, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 307.00, 'paid', 'tarjeta', '150993200110', '2026-02-03 21:00:00', '2026-02-03 21:00:00'),
(1006, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'efectivo', NULL, '2026-02-04 19:30:00', '2026-02-04 19:30:00'),
(1007, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-02-04 22:00:00', '2026-06-30 12:00:00'),
(1008, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 307.00, 'paid', 'tarjeta', '150993200120', '2026-02-05 20:00:00', '2026-02-05 20:00:00'),
(1009, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 135.00, 'paid', 'efectivo', NULL, '2026-02-05 21:30:00', '2026-02-05 21:30:00'),
(1010, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 2038.00, 'paid', 'tarjeta', '150993200130', '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(1011, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-02-06 20:00:00', '2026-02-06 20:00:00'),
(1012, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 707.00, 'paid', 'efectivo', NULL, '2026-02-06 21:00:00', '2026-02-06 21:00:00'),
(1013, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993200131', '2026-02-06 22:00:00', '2026-06-30 12:00:01'),
(1014, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1300.00, 'paid', 'tarjeta', '150993200140', '2026-02-07 18:30:00', '2026-02-07 18:30:00'),
(1015, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-02-07 19:30:00', '2026-02-07 19:30:00'),
(1016, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 955.00, 'paid', 'tarjeta', '150993200141', '2026-02-07 20:30:00', '2026-02-07 20:30:00'),
(1017, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'efectivo', NULL, '2026-02-07 21:30:00', '2026-02-07 21:30:00'),
(1018, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Hshsh', NULL, 224.00, 'ready', 'efectivo', NULL, '2026-02-07 22:30:00', '2026-06-30 12:00:01'),
(1019, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 770.00, 'paid', 'tarjeta', '150993200150', '2026-02-08 19:00:00', '2026-02-08 19:00:00'),
(1020, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'efectivo', NULL, '2026-02-08 20:30:00', '2026-02-08 20:30:00'),
(1021, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', '150993200151', '2026-02-08 21:45:00', '2026-06-30 12:00:02'),
(1022, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-02-09 20:00:00', '2026-02-09 20:00:00'),
(1023, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-02-10 21:00:00', '2026-02-10 21:00:00'),
(1024, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 307.00, 'paid', 'tarjeta', '150993200160', '2026-02-11 19:30:00', '2026-02-11 19:30:00'),
(1025, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 224.00, 'paid', 'efectivo', NULL, '2026-02-11 21:00:00', '2026-02-11 21:00:00'),
(1026, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 335.00, 'paid', 'efectivo', NULL, '2026-02-12 20:00:00', '2026-02-12 20:00:00'),
(1027, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 175.00, 'ready', 'tarjeta', '150993200170', '2026-02-12 21:30:00', '2026-06-30 12:00:02'),
(1028, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1100.00, 'paid', 'tarjeta', '150993200180', '2026-02-13 19:00:00', '2026-02-13 19:00:00'),
(1029, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-02-13 20:00:00', '2026-02-13 20:00:00'),
(1030, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 707.00, 'paid', 'efectivo', NULL, '2026-02-13 21:00:00', '2026-02-13 21:00:00'),
(1031, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'tarjeta', '150993200181', '2026-02-13 22:00:00', '2026-06-30 12:00:02'),
(1032, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1500.00, 'paid', 'tarjeta', '150993200190', '2026-02-14 18:00:00', '2026-02-14 18:00:00'),
(1033, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 955.00, 'paid', 'tarjeta', '150993200191', '2026-02-14 19:00:00', '2026-02-14 19:00:00'),
(1034, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 1300.00, 'paid', 'efectivo', NULL, '2026-02-14 20:00:00', '2026-02-14 20:00:00'),
(1035, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 770.00, 'paid', 'tarjeta', '150993200192', '2026-02-14 21:00:00', '2026-02-14 21:00:00'),
(1036, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-02-14 22:00:00', '2026-02-14 22:00:00'),
(1037, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993200193', '2026-02-14 22:30:00', '2026-06-30 12:00:03'),
(1038, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-02-15 19:00:00', '2026-02-15 19:00:00'),
(1039, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993200200', '2026-02-15 20:30:00', '2026-02-15 20:30:00'),
(1040, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 175.00, 'ready', 'efectivo', NULL, '2026-02-15 22:00:00', '2026-06-30 12:00:03'),
(1041, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 134.00, 'paid', 'efectivo', NULL, '2026-02-16 20:30:00', '2026-02-16 20:30:00'),
(1042, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-02-17 21:00:00', '2026-02-17 21:00:00'),
(1043, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 307.00, 'paid', 'tarjeta', '150993200210', '2026-02-18 19:30:00', '2026-02-18 19:30:00'),
(1044, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-02-18 21:30:00', '2026-02-18 21:30:00'),
(1045, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'efectivo', NULL, '2026-02-19 20:00:00', '2026-02-19 20:00:00'),
(1046, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 152.00, 'ready', 'tarjeta', '150993200220', '2026-02-19 21:45:00', '2026-06-30 12:00:03'),
(1047, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 930.00, 'paid', 'tarjeta', '150993200230', '2026-02-20 19:00:00', '2026-02-20 19:00:00'),
(1048, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-02-20 20:00:00', '2026-02-20 20:00:00'),
(1049, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993200231', '2026-02-20 21:00:00', '2026-02-20 21:00:00'),
(1050, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-02-20 22:00:00', '2026-02-20 22:00:00'),
(1051, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1300.00, 'paid', 'tarjeta', '150993200240', '2026-02-21 18:30:00', '2026-02-21 18:30:00'),
(1052, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 955.00, 'paid', 'efectivo', NULL, '2026-02-21 19:30:00', '2026-02-21 19:30:00'),
(1053, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993200241', '2026-02-21 20:30:00', '2026-02-21 20:30:00'),
(1054, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-02-21 21:30:00', '2026-02-21 21:30:00'),
(1055, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-02-21 22:30:00', '2026-06-30 12:00:04'),
(1056, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'tarjeta', '150993200250', '2026-02-22 19:00:00', '2026-02-22 19:00:00'),
(1057, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 335.00, 'paid', 'efectivo', NULL, '2026-02-22 20:30:00', '2026-02-22 20:30:00'),
(1058, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'tarjeta', '150993200251', '2026-02-22 22:00:00', '2026-06-30 12:00:04'),
(1059, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-02-23 20:30:00', '2026-02-23 20:30:00'),
(1060, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-02-24 21:00:00', '2026-02-24 21:00:00'),
(1061, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993200260', '2026-02-25 19:30:00', '2026-02-25 19:30:00'),
(1062, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 224.00, 'paid', 'efectivo', NULL, '2026-02-25 21:00:00', '2026-02-25 21:00:00'),
(1063, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 307.00, 'paid', 'efectivo', NULL, '2026-02-26 20:00:00', '2026-02-26 20:00:00'),
(1064, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 175.00, 'ready', 'tarjeta', '150993200270', '2026-02-26 21:30:00', '2026-06-30 12:00:04'),
(1065, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1100.00, 'paid', 'tarjeta', '150993200280', '2026-02-27 19:00:00', '2026-02-27 19:00:00'),
(1066, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-02-27 20:00:00', '2026-02-27 20:00:00'),
(1067, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993200281', '2026-02-27 21:00:00', '2026-02-27 21:00:00'),
(1068, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-02-27 22:00:00', '2026-02-27 22:00:00'),
(1069, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1500.00, 'paid', 'tarjeta', '150993200290', '2026-02-28 18:30:00', '2026-02-28 18:30:00'),
(1070, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 955.00, 'paid', 'efectivo', NULL, '2026-02-28 19:30:00', '2026-02-28 19:30:00'),
(1071, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993200291', '2026-02-28 20:30:00', '2026-02-28 20:30:00'),
(1072, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-02-28 21:30:00', '2026-02-28 21:30:00'),
(1073, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993200292', '2026-02-28 22:15:00', '2026-06-30 12:00:05'),
(2001, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-03-01 19:00:00', '2026-03-01 19:00:00'),
(2002, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993300100', '2026-03-01 20:15:00', '2026-03-01 20:15:00'),
(2003, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Hshsh', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-03-01 21:30:00', '2026-06-30 12:00:05'),
(2004, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-03-02 20:30:00', '2026-03-02 20:30:00'),
(2005, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 224.00, 'paid', 'efectivo', NULL, '2026-03-03 21:00:00', '2026-03-03 21:00:00'),
(2006, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 307.00, 'paid', 'tarjeta', '150993300110', '2026-03-04 19:30:00', '2026-03-04 19:30:00'),
(2007, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 195.00, 'paid', 'efectivo', NULL, '2026-03-04 21:30:00', '2026-03-04 21:30:00'),
(2008, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 175.00, 'paid', 'efectivo', NULL, '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(2009, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 152.00, 'ready', 'tarjeta', '150993300120', '2026-03-05 21:30:00', '2026-06-30 12:02:17'),
(2010, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 930.00, 'paid', 'tarjeta', '150993300130', '2026-03-06 19:00:00', '2026-03-06 19:00:00'),
(2011, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-03-06 20:00:00', '2026-03-06 20:00:00'),
(2012, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300131', '2026-03-06 21:00:00', '2026-03-06 21:00:00'),
(2013, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-03-06 22:00:00', '2026-03-06 22:00:00'),
(2014, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1300.00, 'paid', 'tarjeta', '150993300140', '2026-03-07 18:30:00', '2026-03-07 18:30:00'),
(2015, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 955.00, 'paid', 'efectivo', NULL, '2026-03-07 19:30:00', '2026-03-07 19:30:00'),
(2016, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993300141', '2026-03-07 20:30:00', '2026-03-07 20:30:00'),
(2017, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'efectivo', NULL, '2026-03-07 21:30:00', '2026-03-07 21:30:00'),
(2018, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 335.00, 'ready', 'efectivo', NULL, '2026-03-07 22:30:00', '2026-06-30 12:02:19'),
(2019, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 2038.00, 'paid', 'tarjeta', '150993300150', '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(2020, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-03-08 20:00:00', '2026-03-08 20:00:00'),
(2021, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 307.00, 'paid', 'tarjeta', '150993300151', '2026-03-08 21:30:00', '2026-03-08 21:30:00'),
(2022, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 134.00, 'paid', 'efectivo', NULL, '2026-03-09 21:00:00', '2026-03-09 21:00:00'),
(2023, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-03-10 21:00:00', '2026-03-10 21:00:00'),
(2024, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993300160', '2026-03-11 19:30:00', '2026-03-11 19:30:00'),
(2025, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 224.00, 'paid', 'efectivo', NULL, '2026-03-11 21:00:00', '2026-03-11 21:00:00'),
(2026, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 307.00, 'paid', 'efectivo', NULL, '2026-03-12 20:00:00', '2026-03-12 20:00:00'),
(2027, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'tarjeta', '150993300170', '2026-03-12 21:30:00', '2026-06-30 12:02:32'),
(2028, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1100.00, 'paid', 'tarjeta', '150993300180', '2026-03-13 19:00:00', '2026-03-13 19:00:00'),
(2029, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-03-13 20:00:00', '2026-03-13 20:00:00'),
(2030, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300181', '2026-03-13 21:00:00', '2026-03-13 21:00:00'),
(2031, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 335.00, 'paid', 'efectivo', NULL, '2026-03-13 22:00:00', '2026-03-13 22:00:00'),
(2032, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1500.00, 'paid', 'tarjeta', '150993300190', '2026-03-14 18:30:00', '2026-03-14 18:30:00'),
(2033, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 955.00, 'paid', 'efectivo', NULL, '2026-03-14 19:30:00', '2026-03-14 19:30:00'),
(2034, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993300191', '2026-03-14 20:30:00', '2026-03-14 20:30:00'),
(2035, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-03-14 21:30:00', '2026-03-14 21:30:00'),
(2036, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-03-14 22:30:00', '2026-06-30 12:00:34'),
(2037, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'tarjeta', '150993300200', '2026-03-15 19:00:00', '2026-03-15 19:00:00'),
(2038, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'efectivo', NULL, '2026-03-15 20:30:00', '2026-03-15 20:30:00'),
(2039, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 177.00, 'paid', 'tarjeta', '150993104111', '2026-03-15 21:20:00', '2026-03-15 22:00:00'),
(2040, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-03-16 21:00:00', '2026-03-16 21:00:00'),
(2041, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-03-17 21:00:00', '2026-03-17 21:00:00'),
(2042, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993300210', '2026-03-18 19:30:00', '2026-03-18 19:30:00'),
(2043, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 307.00, 'paid', 'efectivo', NULL, '2026-03-18 21:00:00', '2026-03-18 21:00:00'),
(2044, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 224.00, 'paid', 'efectivo', NULL, '2026-03-19 20:00:00', '2026-03-19 20:00:00'),
(2045, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'tarjeta', '150993104388', '2026-03-19 21:30:00', '2026-06-30 12:02:42'),
(2046, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 930.00, 'paid', 'tarjeta', '150993300220', '2026-03-20 19:00:00', '2026-03-20 19:00:00'),
(2047, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-03-20 20:00:00', '2026-03-20 20:00:00'),
(2048, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300221', '2026-03-20 21:00:00', '2026-03-20 21:00:00'),
(2049, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-03-20 22:00:00', '2026-03-20 22:00:00'),
(2050, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1300.00, 'paid', 'tarjeta', '150993300230', '2026-03-21 18:30:00', '2026-03-21 18:30:00'),
(2051, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 955.00, 'paid', 'efectivo', NULL, '2026-03-21 19:30:00', '2026-03-21 19:30:00'),
(2052, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993300231', '2026-03-21 20:30:00', '2026-03-21 20:30:00'),
(2053, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-03-21 21:30:00', '2026-03-21 21:30:00'),
(2054, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 335.00, 'ready', 'efectivo', NULL, '2026-03-21 22:30:00', '2026-06-30 12:02:42'),
(2055, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-03-22 19:00:00', '2026-03-22 19:00:00'),
(2056, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300240', '2026-03-22 20:30:00', '2026-03-22 20:30:00'),
(2057, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 224.00, 'ready', 'efectivo', NULL, '2026-03-22 22:00:00', '2026-06-30 12:02:43'),
(2058, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 134.00, 'paid', 'efectivo', NULL, '2026-03-23 21:00:00', '2026-03-23 21:00:00'),
(2059, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-03-24 21:00:00', '2026-03-24 21:00:00'),
(2060, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993300250', '2026-03-25 19:30:00', '2026-03-25 19:30:00'),
(2061, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-03-25 23:00:00', '2026-06-30 12:02:43'),
(2062, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 6045.00, 'paid', 'efectivo', NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(2063, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 335.00, 'paid', 'tarjeta', '150993300260', '2026-03-26 21:00:00', '2026-03-26 21:00:00'),
(2064, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1100.00, 'paid', 'tarjeta', '150993300270', '2026-03-27 19:00:00', '2026-03-27 19:00:00'),
(2065, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-03-27 20:00:00', '2026-03-27 20:00:00'),
(2066, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300271', '2026-03-27 21:00:00', '2026-03-27 21:00:00'),
(2067, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 335.00, 'paid', 'efectivo', NULL, '2026-03-27 22:00:00', '2026-03-27 22:00:00'),
(2068, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1500.00, 'paid', 'tarjeta', '150993300280', '2026-03-28 18:30:00', '2026-03-28 18:30:00'),
(2069, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-03-28 19:30:00', '2026-03-28 19:30:00'),
(2070, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993300281', '2026-03-28 20:30:00', '2026-03-28 20:30:00'),
(2071, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-03-28 21:30:00', '2026-03-28 21:30:00'),
(2072, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993300282', '2026-03-28 22:30:00', '2026-06-30 12:02:44'),
(2073, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-03-29 19:00:00', '2026-03-29 19:00:00'),
(2074, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993300290', '2026-03-29 20:30:00', '2026-03-29 20:30:00'),
(2075, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 175.00, 'ready', 'efectivo', NULL, '2026-03-29 22:00:00', '2026-06-30 12:02:45'),
(2076, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-03-30 21:00:00', '2026-03-30 21:00:00'),
(2077, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-03-31 21:00:00', '2026-03-31 21:00:00'),
(3001, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993400100', '2026-04-01 19:30:00', '2026-04-01 19:30:00'),
(3002, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 224.00, 'paid', 'efectivo', NULL, '2026-04-01 21:00:00', '2026-04-01 21:00:00'),
(3003, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 307.00, 'paid', 'efectivo', NULL, '2026-04-02 20:00:00', '2026-04-02 20:00:00'),
(3004, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 152.00, 'ready', 'tarjeta', '150993400110', '2026-04-02 21:30:00', '2026-06-30 12:02:45'),
(3005, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 930.00, 'paid', 'tarjeta', '150993400120', '2026-04-03 19:00:00', '2026-04-03 19:00:00'),
(3006, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 707.00, 'paid', 'efectivo', NULL, '2026-04-03 20:00:00', '2026-04-03 20:00:00'),
(3007, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'tarjeta', '150993400121', '2026-04-03 21:00:00', '2026-04-03 21:00:00'),
(3008, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 224.00, 'paid', 'efectivo', NULL, '2026-04-03 22:00:00', '2026-04-03 22:00:00'),
(3009, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993104222', '2026-04-04 20:00:00', '2026-04-04 21:10:00'),
(3010, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 955.00, 'paid', 'efectivo', NULL, '2026-04-04 19:00:00', '2026-04-04 19:00:00'),
(3011, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 1300.00, 'paid', 'tarjeta', '150993400130', '2026-04-04 20:30:00', '2026-04-04 20:30:00'),
(3012, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 447.00, 'paid', 'efectivo', NULL, '2026-04-04 21:30:00', '2026-04-04 21:30:00'),
(3013, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993400131', '2026-04-04 22:30:00', '2026-06-30 12:02:45'),
(3014, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-04-05 19:00:00', '2026-04-05 19:00:00'),
(3015, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993400140', '2026-04-05 20:30:00', '2026-04-05 20:30:00'),
(3016, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Hshsh', NULL, 224.00, 'ready', 'efectivo', NULL, '2026-04-05 22:00:00', '2026-06-30 12:02:46'),
(3017, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-04-06 21:00:00', '2026-04-06 21:00:00'),
(3018, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-04-07 21:00:00', '2026-04-07 21:00:00'),
(3019, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993400150', '2026-04-08 19:30:00', '2026-04-08 19:30:00'),
(3020, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 307.00, 'paid', 'efectivo', NULL, '2026-04-08 21:00:00', '2026-04-08 21:00:00'),
(3021, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 224.00, 'paid', 'efectivo', NULL, '2026-04-09 20:00:00', '2026-04-09 20:00:00'),
(3022, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 152.00, 'ready', 'tarjeta', '150993400160', '2026-04-09 21:30:00', '2026-06-30 12:02:46'),
(3023, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 134.00, 'paid', 'efectivo', NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(3024, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 930.00, 'paid', 'tarjeta', '150993400170', '2026-04-10 19:30:00', '2026-04-10 19:30:00'),
(3025, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 707.00, 'paid', 'efectivo', NULL, '2026-04-10 20:30:00', '2026-04-10 20:30:00'),
(3026, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 447.00, 'paid', 'tarjeta', '150993400171', '2026-04-10 21:30:00', '2026-04-10 21:30:00'),
(3027, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-04-11 16:00:00', '2026-04-11 16:00:00'),
(3028, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'efectivo', NULL, '2026-04-11 16:15:00', '2026-04-11 16:15:00'),
(3029, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 1300.00, 'paid', 'tarjeta', '150993400180', '2026-04-11 19:00:00', '2026-04-11 19:00:00'),
(3030, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 955.00, 'paid', 'efectivo', NULL, '2026-04-11 20:30:00', '2026-04-11 20:30:00'),
(3031, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993400181', '2026-04-11 21:30:00', '2026-04-11 21:30:00'),
(3032, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', '150993104333', '2026-04-12 21:45:00', '2026-06-30 12:02:47'),
(3033, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 707.00, 'paid', 'efectivo', NULL, '2026-04-12 19:00:00', '2026-04-12 19:00:00'),
(3034, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 447.00, 'paid', 'tarjeta', '150993400190', '2026-04-12 20:30:00', '2026-04-12 20:30:00'),
(3035, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 112.00, 'ready', 'efectivo', NULL, '2026-04-13 22:09:16', '2026-06-30 12:02:47'),
(3036, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-04-14 19:30:00', '2026-04-14 19:30:00'),
(3037, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Jdhs', NULL, 152.00, 'ready', 'efectivo', NULL, '2026-04-14 22:00:00', '2026-06-30 12:02:48'),
(3038, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-04-14 22:30:59', '2026-06-30 12:02:53'),
(3039, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 120.00, 'ready', 'efectivo', NULL, '2026-04-14 22:31:44', '2026-06-30 12:02:56'),
(3040, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Jdhs', NULL, 955.00, 'ready', 'efectivo', NULL, '2026-04-14 22:36:47', '2026-06-30 12:02:57'),
(8001, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 182.00, 'paid', 'efectivo', NULL, '2026-02-14 20:30:00', '2026-02-14 21:15:00'),
(8002, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 335.00, 'ready', 'tarjeta', '150993104000', '2026-02-28 22:15:00', '2026-06-30 12:00:05'),
(8003, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 175.00, 'paid', 'efectivo', NULL, '2026-03-05 19:45:00', '2026-03-05 20:30:00'),
(8004, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 177.00, 'paid', 'tarjeta', '150993104111', '2026-03-15 21:20:00', '2026-03-15 22:00:00'),
(8005, NULL, 'Luis Angel Hernadez Hernadez', '7713497438', 'Ggg', NULL, 244.00, 'ready', 'efectivo', NULL, '2026-03-25 23:00:00', '2026-06-30 12:02:44'),
(8006, NULL, 'Mesa 3', 'Local', 'Consumo en sucursal', 3, 770.00, 'paid', 'tarjeta', '150993104222', '2026-04-04 20:00:00', '2026-04-04 21:10:00'),
(8007, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 134.00, 'paid', 'efectivo', NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(8008, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 112.00, 'ready', 'tarjeta', '150993104333', '2026-04-12 21:45:00', '2026-06-30 12:02:47'),
(8009, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 195.00, 'paid', 'efectivo', NULL, '2026-04-14 19:30:00', '2026-04-14 19:30:00'),
(8010, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Jdhs', NULL, 152.00, 'ready', 'efectivo', NULL, '2026-04-14 22:00:00', '2026-06-30 12:02:48'),
(8011, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 670.00, 'ready', 'efectivo', NULL, '2026-04-15 07:22:25', '2026-06-30 12:03:00'),
(8012, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Hshs', NULL, 820.00, 'ready', 'efectivo', NULL, '2026-04-21 05:26:06', '2026-06-30 12:03:00'),
(8013, NULL, 'Luis Angel Hernandez Hernandez', '7713497438', 'Gh', NULL, 1490.00, 'ready', 'efectivo', NULL, '2026-04-21 08:20:11', '2026-06-30 12:03:03'),
(8014, NULL, 'Alan', 'jahir', 'asmkdjkasd', NULL, 390.00, 'ready', 'efectivo', NULL, '2026-06-30 08:26:58', '2026-06-30 12:03:05'),
(8015, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 307.00, 'paid', 'efectivo', NULL, '2026-06-30 09:30:45', '2026-06-30 09:31:01'),
(8016, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-06-30 09:31:39', '2026-06-30 09:44:16'),
(8017, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 195.00, 'paid', 'efectivo', NULL, '2026-06-30 09:44:20', '2026-06-30 09:44:24'),
(8018, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 390.00, 'paid', 'efectivo', NULL, '2026-06-30 10:01:16', '2026-06-30 10:06:21'),
(8019, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 390.00, 'paid', 'efectivo', NULL, '2026-06-30 10:10:10', '2026-06-30 10:18:34'),
(8020, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'efectivo', NULL, '2026-06-30 10:11:02', '2026-06-30 10:18:34'),
(8021, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 125.00, 'paid', 'efectivo', NULL, '2026-06-30 10:11:20', '2026-06-30 10:18:37'),
(8022, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 390.00, 'paid', 'efectivo', NULL, '2026-06-30 10:40:07', '2026-06-30 10:42:12'),
(8023, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 125.00, 'paid', 'efectivo', NULL, '2026-06-30 10:40:59', '2026-06-30 10:42:12'),
(8024, NULL, 'Alan', '7712994676', 'Co Zapote', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-06-30 10:45:04', '2026-06-30 12:03:06'),
(8025, NULL, 'Alan', '7712994676', 'Col.Zapote', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-06-30 12:06:42', '2026-06-30 12:07:27'),
(8026, 1, 'Angel Hernandez', '7712994676', 'Col.Zapote', NULL, 112.00, 'ready', 'efectivo', NULL, '2026-06-30 12:08:10', '2026-06-30 12:08:35'),
(8027, 1, 'Angel Hernandez', '7712994676', 'Col. Zapote', NULL, 140.00, 'ready', 'efectivo', NULL, '2026-06-30 12:10:44', '2026-06-30 12:11:56'),
(8028, NULL, 'Luis Angel Hernandez Hernandez', '7712457018', 'MIRADOR', NULL, 356.00, 'ready', 'efectivo', NULL, '2026-06-30 12:11:24', '2026-06-30 12:12:27'),
(8029, NULL, 'Alan', '7712994676', 'kdsasd', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-06-30 12:14:15', '2026-06-30 12:14:22'),
(8030, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 140.00, 'paid', 'Mixto (Efectivo: $100.00, Tarjeta: $100.00)', NULL, '2026-07-02 15:33:26', '2026-07-02 15:34:37'),
(8031, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 152.00, 'paid', 'Mixto (Efectivo: $152.00)', NULL, '2026-07-03 12:16:45', '2026-07-03 12:17:56'),
(8032, NULL, 'Alan', '7712994676', 'shzsd', NULL, 390.00, 'paid', 'efectivo', NULL, '2026-07-03 13:25:54', '2026-07-03 13:25:54'),
(8033, NULL, 'Mesa 1', 'Local', 'Consumo en sucursal', 1, 112.00, 'paid', 'Mixto (Efectivo: $50.00, Tarjeta: $72.00)', NULL, '2026-07-03 13:27:17', '2026-07-03 13:28:21'),
(8034, NULL, 'andres', '7711134497', 'magisterial', NULL, 195.00, 'ready', 'efectivo', NULL, '2026-07-03 13:43:25', '2026-07-03 13:46:26'),
(8035, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 264.00, 'ready', 'pendiente', NULL, '2026-07-03 14:13:20', '2026-07-03 14:16:36'),
(8036, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 125.00, 'ready', 'pendiente', NULL, '2026-07-03 14:16:53', '2026-07-03 14:17:10'),
(8037, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 38.00, 'ready', 'pendiente', NULL, '2026-07-03 14:17:29', '2026-07-03 14:17:43'),
(8038, NULL, 'Mesa 2', 'Local', 'Consumo en sucursal', 2, 35.00, 'ready', 'pendiente', NULL, '2026-07-03 14:18:09', '2026-07-03 14:18:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `excluded_ingredients` text DEFAULT NULL,
  `exclusiones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `subtotal`, `excluded_ingredients`, `exclusiones`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'eqw', 2, 21.00, 42.00, NULL, NULL, '2026-03-02 15:15:33', '2026-03-02 15:15:33'),
(2, 2, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 15:16:30', '2026-03-02 15:16:30'),
(3, 2, NULL, 'vasdf', 11, 341.00, 3751.00, NULL, NULL, '2026-03-02 15:16:30', '2026-03-02 15:16:30'),
(4, 3, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 15:20:16', '2026-03-02 15:20:16'),
(5, 4, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 15:20:35', '2026-03-02 15:20:35'),
(6, 5, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 15:23:40', '2026-03-02 15:23:40'),
(7, 6, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 15:25:55', '2026-03-02 15:25:55'),
(8, 7, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 15:26:18', '2026-03-02 15:26:18'),
(9, 8, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 15:31:06', '2026-03-02 15:31:06'),
(10, 9, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 15:31:13', '2026-03-02 15:31:13'),
(11, 10, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 15:31:26', '2026-03-02 15:31:26'),
(12, 11, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 16:07:06', '2026-03-02 16:07:06'),
(13, 12, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:07:22', '2026-03-02 16:07:22'),
(14, 13, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:07:34', '2026-03-02 16:07:34'),
(15, 14, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:08:22', '2026-03-02 16:08:22'),
(16, 15, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:10:43', '2026-03-02 16:10:43'),
(17, 16, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:18:34', '2026-03-02 16:18:34'),
(18, 17, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:18:46', '2026-03-02 16:18:46'),
(19, 18, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:19:40', '2026-03-02 16:19:40'),
(20, 19, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-02 16:21:26', '2026-03-02 16:21:26'),
(21, 20, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:21:56', '2026-03-02 16:21:56'),
(22, 21, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:22:24', '2026-03-02 16:22:24'),
(23, 22, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:23:25', '2026-03-02 16:23:25'),
(24, 23, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:25:00', '2026-03-02 16:25:00'),
(25, 24, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:27:12', '2026-03-02 16:27:12'),
(26, 25, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-02 16:35:14', '2026-03-02 16:35:14'),
(27, 26, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 16:36:38', '2026-03-02 16:36:38'),
(28, 27, NULL, 'vasdf', 2, 341.00, 682.00, NULL, NULL, '2026-03-02 16:38:59', '2026-03-02 16:38:59'),
(29, 28, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 16:43:16', '2026-03-02 16:43:16'),
(30, 29, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 16:50:17', '2026-03-02 16:50:17'),
(31, 30, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 16:52:03', '2026-03-02 16:52:03'),
(32, 31, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-02 16:52:15', '2026-03-02 16:52:15'),
(33, 32, NULL, 'vasdf', 4, 341.00, 1364.00, NULL, NULL, '2026-03-02 17:09:40', '2026-03-02 17:09:40'),
(34, 33, NULL, 'asd', 3, 213.00, 639.00, NULL, NULL, '2026-03-02 20:38:22', '2026-03-02 20:38:22'),
(35, 34, NULL, 'eqw', 10, 21.00, 210.00, NULL, NULL, '2026-03-02 20:40:16', '2026-03-02 20:40:16'),
(36, 35, NULL, 'dasd', 2, 123.00, 246.00, NULL, NULL, '2026-03-03 17:44:38', '2026-03-03 17:44:38'),
(37, 36, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 20:38:29', '2026-03-03 20:38:29'),
(38, 37, NULL, 'das', 1, 52.00, 52.00, NULL, NULL, '2026-03-03 20:39:26', '2026-03-03 20:39:26'),
(39, 38, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 20:42:40', '2026-03-03 20:42:40'),
(40, 39, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 21:51:05', '2026-03-03 21:51:05'),
(41, 40, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 21:54:26', '2026-03-03 21:54:26'),
(42, 41, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 21:55:25', '2026-03-03 21:55:25'),
(43, 42, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 21:55:37', '2026-03-03 21:55:37'),
(44, 43, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:00:55', '2026-03-03 22:00:55'),
(45, 44, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:09:35', '2026-03-03 22:09:35'),
(46, 45, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:10:16', '2026-03-03 22:10:16'),
(47, 46, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:15:10', '2026-03-03 22:15:10'),
(48, 47, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:16:41', '2026-03-03 22:16:41'),
(49, 48, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:25:33', '2026-03-03 22:25:33'),
(50, 49, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:34:53', '2026-03-03 22:34:53'),
(51, 50, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:35:26', '2026-03-03 22:35:26'),
(52, 51, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 22:36:56', '2026-03-03 22:36:56'),
(53, 52, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 23:52:18', '2026-03-03 23:52:18'),
(54, 53, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 23:55:33', '2026-03-03 23:55:33'),
(55, 54, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-03 23:58:07', '2026-03-03 23:58:07'),
(56, 55, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 14:36:53', '2026-03-04 14:36:53'),
(57, 56, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 14:38:01', '2026-03-04 14:38:01'),
(58, 57, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 14:42:21', '2026-03-04 14:42:21'),
(59, 58, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 14:46:58', '2026-03-04 14:46:58'),
(60, 59, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 14:54:49', '2026-03-04 14:54:49'),
(61, 60, NULL, 'eqw', 2, 21.00, 42.00, NULL, NULL, '2026-03-04 14:59:51', '2026-03-04 14:59:51'),
(62, 61, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 16:51:19', '2026-03-04 16:51:19'),
(63, 62, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-04 16:53:21', '2026-03-04 16:53:21'),
(64, 63, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-04 16:57:34', '2026-03-04 16:57:34'),
(65, 64, NULL, 'asd', 2, 213.00, 426.00, NULL, NULL, '2026-03-04 21:00:58', '2026-03-04 21:00:58'),
(66, 65, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 21:08:08', '2026-03-04 21:08:08'),
(67, 66, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 21:17:18', '2026-03-04 21:17:18'),
(68, 67, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 21:19:05', '2026-03-04 21:19:05'),
(69, 68, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 21:24:53', '2026-03-04 21:24:53'),
(70, 69, NULL, 'eqw', 1, 21.00, 21.00, NULL, NULL, '2026-03-04 21:58:10', '2026-03-04 21:58:10'),
(71, 70, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 22:06:31', '2026-03-04 22:06:31'),
(72, 71, NULL, 'asd', 2, 213.00, 426.00, NULL, NULL, '2026-03-04 22:09:57', '2026-03-04 22:09:57'),
(73, 72, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-04 23:28:50', '2026-03-04 23:28:50'),
(74, 73, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-05 19:09:06', '2026-03-05 19:09:06'),
(75, 74, NULL, 'sad', 1, 123.00, 123.00, NULL, NULL, '2026-03-05 19:20:21', '2026-03-05 19:20:21'),
(76, 75, NULL, 'asd', 1, 213.00, 213.00, NULL, NULL, '2026-03-05 23:05:59', '2026-03-05 23:05:59'),
(77, 76, NULL, 'vasdf', 1, 341.00, 341.00, NULL, NULL, '2026-03-05 23:08:20', '2026-03-05 23:08:20'),
(78, 77, NULL, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-08 04:50:44', '2026-03-08 04:50:44'),
(79, 78, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 05:32:56', '2026-03-08 05:32:56'),
(80, 79, NULL, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-08 05:36:15', '2026-03-08 05:36:15'),
(81, 80, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 05:36:41', '2026-03-08 05:36:41'),
(82, 81, NULL, 'Clásica', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 17:04:09', '2026-03-08 17:04:09'),
(83, 82, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 17:21:25', '2026-03-08 17:21:25'),
(84, 83, NULL, 'Clásica', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 17:21:57', '2026-03-08 17:21:57'),
(85, 84, NULL, 'Clásica', 1, 112.00, 112.00, NULL, NULL, '2026-03-09 21:03:56', '2026-03-09 21:03:56'),
(86, 85, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:14:19', '2026-03-18 13:14:19'),
(87, 85, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:14:19', '2026-03-18 13:14:19'),
(88, 86, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:29:49', '2026-03-18 13:29:49'),
(89, 87, NULL, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-18 13:30:17', '2026-03-18 13:30:17'),
(90, 88, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:31:39', '2026-03-18 13:31:39'),
(91, 88, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:31:39', '2026-03-18 13:31:39'),
(92, 89, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 13:32:43', '2026-03-18 13:32:43'),
(93, 90, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:35:21', '2026-03-18 13:35:21'),
(94, 90, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:35:21', '2026-03-18 13:35:21'),
(95, 90, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 13:35:21', '2026-03-18 13:35:21'),
(96, 90, NULL, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-03-18 13:35:21', '2026-03-18 13:35:21'),
(97, 90, NULL, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-03-18 13:35:21', '2026-03-18 13:35:21'),
(98, 91, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(99, 91, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(100, 91, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(101, 91, NULL, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(102, 91, NULL, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(103, 91, NULL, 'Especial Rings', 1, 125.00, 125.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(104, 91, NULL, 'Argentina', 1, 138.00, 138.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(105, 91, NULL, 'White Burger', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(106, 91, NULL, 'Marisquera', 1, 152.00, 152.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(107, 91, NULL, 'Hamburguesa Clásica', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(108, 91, NULL, 'Hamburguesa Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(109, 91, NULL, 'Hamburguesa Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(110, 91, NULL, 'Hamburguesa Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(111, 91, NULL, 'Hamburguesa Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(112, 91, NULL, 'Hamburguesa Arrachera', 1, 152.00, 152.00, NULL, NULL, '2026-03-18 13:37:55', '2026-03-18 13:37:55'),
(113, 92, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:38:30', '2026-03-18 13:38:30'),
(114, 93, NULL, 'Especial Rings', 1, 125.00, 125.00, NULL, NULL, '2026-03-18 13:38:34', '2026-03-18 13:38:34'),
(115, 94, NULL, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-03-18 13:38:39', '2026-03-18 13:38:39'),
(116, 95, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 13:56:53', '2026-03-18 13:56:53'),
(117, 95, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 13:56:53', '2026-03-18 13:56:53'),
(118, 96, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 14:21:29', '2026-03-18 14:21:29'),
(119, 97, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-18 14:51:16', '2026-03-18 14:51:16'),
(121, 99, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 14:59:27', '2026-03-18 14:59:27'),
(122, 100, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 15:27:13', '2026-03-18 15:27:13'),
(124, 102, NULL, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-19 00:41:56', '2026-03-19 00:41:56'),
(126, 104, NULL, 'Clásica', 31, 195.00, 6045.00, NULL, NULL, '2026-03-26 12:37:35', '2026-03-26 12:37:35'),
(127, 105, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-26 12:41:46', '2026-03-26 12:41:46'),
(128, 105, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-26 12:41:46', '2026-03-26 12:41:46'),
(129, 105, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-26 12:41:46', '2026-03-26 12:41:46'),
(130, 105, NULL, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-03-26 12:41:46', '2026-03-26 12:41:46'),
(131, 105, NULL, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-03-26 12:41:46', '2026-03-26 12:41:46'),
(132, 106, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-11 16:11:58', '2026-04-11 16:11:58'),
(133, 107, NULL, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-11 16:15:31', '2026-04-11 16:15:31'),
(134, 107, NULL, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-11 16:15:31', '2026-04-11 16:15:31'),
(135, 107, NULL, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-04-11 16:15:31', '2026-04-11 16:15:31'),
(136, 108, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-14 22:09:16', '2026-04-14 22:09:16'),
(137, 111, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-14 22:30:59', '2026-04-14 22:30:59'),
(138, 112, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-04-14 22:31:44', '2026-04-14 22:31:44'),
(139, 113, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(140, 113, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(141, 113, 20, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(142, 113, 22, 'Especial Rings', 1, 125.00, 125.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(143, 113, 205, 'Hamburguesa Argentina', 1, 138.00, 138.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(144, 113, 206, 'White Burger', 1, 140.00, 140.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(145, 113, 207, 'Hamburguesa Marisquera', 1, 152.00, 152.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(172, 8001, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-14 20:30:00', '2026-02-14 20:30:00'),
(173, 8001, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-14 20:30:00', '2026-02-14 20:30:00'),
(174, 8002, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-28 22:15:00', '2026-02-28 22:15:00'),
(175, 8002, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-28 22:15:00', '2026-02-28 22:15:00'),
(176, 8003, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(177, 8003, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(178, 8004, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-15 21:20:00', '2026-03-15 21:20:00'),
(179, 8004, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-15 21:20:00', '2026-03-15 21:20:00'),
(180, 8005, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-03-25 23:00:00', '2026-03-25 23:00:00'),
(181, 8005, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-03-25 23:00:00', '2026-03-25 23:00:00'),
(182, 8006, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-04 20:00:00', '2026-04-04 20:00:00'),
(183, 8007, 26, 'Jocho Clásico', 1, 99.00, 99.00, NULL, NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(184, 8007, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(185, 8008, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-12 21:45:00', '2026-04-12 21:45:00'),
(186, 8008, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-04-12 21:45:00', '2026-04-12 21:45:00'),
(187, 8009, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-14 19:30:00', '2026-04-14 19:30:00'),
(188, 8010, 106, 'Cantarito', 1, 77.00, 77.00, NULL, NULL, '2026-04-14 22:00:00', '2026-04-14 22:00:00'),
(189, 8010, 141, 'Copeo José cuervo especial blanco 1.5oz', 1, 75.00, 75.00, NULL, NULL, '2026-04-14 22:00:00', '2026-04-14 22:00:00'),
(190, 1001, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-01 19:00:00', '2026-02-01 19:00:00'),
(191, 1002, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-01 20:15:00', '2026-02-01 20:15:00'),
(192, 1002, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-01 20:15:00', '2026-02-01 20:15:00'),
(193, 1002, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-01 20:15:00', '2026-02-01 20:15:00'),
(194, 1003, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-01 21:30:00', '2026-02-01 21:30:00'),
(195, 1003, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-01 21:30:00', '2026-02-01 21:30:00'),
(196, 1004, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-02 20:00:00', '2026-02-02 20:00:00'),
(197, 1005, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-02-03 21:00:00', '2026-02-03 21:00:00'),
(198, 1005, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-03 21:00:00', '2026-02-03 21:00:00'),
(199, 1005, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-02-03 21:00:00', '2026-02-03 21:00:00'),
(200, 1005, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-02-03 21:00:00', '2026-02-03 21:00:00'),
(201, 1006, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-04 19:30:00', '2026-02-04 19:30:00'),
(202, 1006, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-04 19:30:00', '2026-02-04 19:30:00'),
(203, 1006, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-04 19:30:00', '2026-02-04 19:30:00'),
(204, 1006, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-04 19:30:00', '2026-02-04 19:30:00'),
(205, 1007, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-02-04 22:00:00', '2026-02-04 22:00:00'),
(206, 1007, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-02-04 22:00:00', '2026-02-04 22:00:00'),
(207, 1008, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-02-05 20:00:00', '2026-02-05 20:00:00'),
(208, 1008, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-05 20:00:00', '2026-02-05 20:00:00'),
(209, 1008, 92, 'Moscow Mule', 1, 88.00, 88.00, NULL, NULL, '2026-02-05 20:00:00', '2026-02-05 20:00:00'),
(210, 1009, 100, 'Margarita', 1, 80.00, 80.00, NULL, NULL, '2026-02-05 21:30:00', '2026-02-05 21:30:00'),
(211, 1009, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-02-05 21:30:00', '2026-02-05 21:30:00'),
(212, 1009, 159, 'Mineral Topochico 600ml', 1, 40.00, 40.00, NULL, NULL, '2026-02-05 21:30:00', '2026-02-05 21:30:00'),
(213, 1010, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(214, 1010, 134, '6 Shots José cuervo especial blanco', 1, 250.00, 250.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(215, 1010, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(216, 1010, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(217, 1010, 96, 'Long island blue', 1, 90.00, 90.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(218, 1010, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-02-06 19:00:00', '2026-02-06 19:00:00'),
(219, 1011, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-06 20:00:00', '2026-02-06 20:00:00'),
(220, 1011, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-06 20:00:00', '2026-02-06 20:00:00'),
(221, 1011, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-06 20:00:00', '2026-02-06 20:00:00'),
(222, 1011, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-06 20:00:00', '2026-02-06 20:00:00'),
(223, 1012, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-06 21:00:00', '2026-02-06 21:00:00'),
(224, 1013, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-06 22:00:00', '2026-02-06 22:00:00'),
(225, 1013, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-06 22:00:00', '2026-02-06 22:00:00'),
(226, 1014, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-02-07 18:30:00', '2026-02-07 18:30:00'),
(227, 1015, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-07 19:30:00', '2026-02-07 19:30:00'),
(228, 1016, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-02-07 20:30:00', '2026-02-07 20:30:00'),
(229, 1017, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-07 21:30:00', '2026-02-07 21:30:00'),
(230, 1017, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-07 21:30:00', '2026-02-07 21:30:00'),
(231, 1017, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-07 21:30:00', '2026-02-07 21:30:00'),
(232, 1017, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-07 21:30:00', '2026-02-07 21:30:00'),
(233, 1018, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-07 22:30:00', '2026-02-07 22:30:00'),
(234, 1019, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-08 19:00:00', '2026-02-08 19:00:00'),
(235, 1020, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-08 20:30:00', '2026-02-08 20:30:00'),
(236, 1020, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-08 20:30:00', '2026-02-08 20:30:00'),
(237, 1020, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-08 20:30:00', '2026-02-08 20:30:00'),
(238, 1020, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-08 20:30:00', '2026-02-08 20:30:00'),
(239, 1021, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-08 21:45:00', '2026-02-08 21:45:00'),
(240, 1022, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-09 20:00:00', '2026-02-09 20:00:00'),
(241, 1023, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-10 21:00:00', '2026-02-10 21:00:00'),
(242, 1024, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-02-11 19:30:00', '2026-02-11 19:30:00'),
(243, 1024, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-11 19:30:00', '2026-02-11 19:30:00'),
(244, 1024, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-02-11 19:30:00', '2026-02-11 19:30:00'),
(245, 1025, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-11 21:00:00', '2026-02-11 21:00:00'),
(246, 1026, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-12 20:00:00', '2026-02-12 20:00:00'),
(247, 1026, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-12 20:00:00', '2026-02-12 20:00:00'),
(248, 1027, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-12 21:30:00', '2026-02-12 21:30:00'),
(249, 1027, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-02-12 21:30:00', '2026-02-12 21:30:00'),
(250, 1028, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-02-13 19:00:00', '2026-02-13 19:00:00'),
(251, 1028, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-13 19:00:00', '2026-02-13 19:00:00'),
(252, 1029, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-13 20:00:00', '2026-02-13 20:00:00'),
(253, 1029, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-13 20:00:00', '2026-02-13 20:00:00'),
(254, 1029, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-13 20:00:00', '2026-02-13 20:00:00'),
(255, 1029, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-13 20:00:00', '2026-02-13 20:00:00'),
(256, 1030, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-13 21:00:00', '2026-02-13 21:00:00'),
(257, 1031, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-13 22:00:00', '2026-02-13 22:00:00'),
(258, 1032, 131, 'Botella Buchanans 12 750ml', 1, 1500.00, 1500.00, NULL, NULL, '2026-02-14 18:00:00', '2026-02-14 18:00:00'),
(259, 1033, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-02-14 19:00:00', '2026-02-14 19:00:00'),
(260, 1034, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-02-14 20:00:00', '2026-02-14 20:00:00'),
(261, 1035, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-14 21:00:00', '2026-02-14 21:00:00'),
(262, 1036, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-14 22:00:00', '2026-02-14 22:00:00'),
(263, 1036, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-14 22:00:00', '2026-02-14 22:00:00'),
(264, 1036, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-14 22:00:00', '2026-02-14 22:00:00'),
(265, 1036, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-14 22:00:00', '2026-02-14 22:00:00'),
(266, 1037, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-14 22:30:00', '2026-02-14 22:30:00'),
(267, 1037, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-14 22:30:00', '2026-02-14 22:30:00'),
(268, 1038, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-15 19:00:00', '2026-02-15 19:00:00'),
(269, 1039, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-15 20:30:00', '2026-02-15 20:30:00'),
(270, 1039, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-15 20:30:00', '2026-02-15 20:30:00'),
(271, 1039, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-15 20:30:00', '2026-02-15 20:30:00'),
(272, 1039, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-15 20:30:00', '2026-02-15 20:30:00'),
(273, 1040, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-15 22:00:00', '2026-02-15 22:00:00'),
(274, 1040, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-02-15 22:00:00', '2026-02-15 22:00:00'),
(275, 1041, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-16 20:30:00', '2026-02-16 20:30:00'),
(276, 1041, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-02-16 20:30:00', '2026-02-16 20:30:00'),
(277, 1042, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-17 21:00:00', '2026-02-17 21:00:00'),
(278, 1043, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-18 19:30:00', '2026-02-18 19:30:00'),
(279, 1043, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-18 19:30:00', '2026-02-18 19:30:00'),
(280, 1044, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-18 21:30:00', '2026-02-18 21:30:00'),
(281, 1045, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-19 20:00:00', '2026-02-19 20:00:00'),
(282, 1045, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-19 20:00:00', '2026-02-19 20:00:00'),
(283, 1045, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-19 20:00:00', '2026-02-19 20:00:00'),
(284, 1045, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-19 20:00:00', '2026-02-19 20:00:00'),
(285, 1046, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-19 21:45:00', '2026-02-19 21:45:00'),
(286, 1046, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-02-19 21:45:00', '2026-02-19 21:45:00'),
(287, 1047, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-02-20 19:00:00', '2026-02-20 19:00:00'),
(288, 1048, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-20 20:00:00', '2026-02-20 20:00:00'),
(289, 1049, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-20 21:00:00', '2026-02-20 21:00:00'),
(290, 1049, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-20 21:00:00', '2026-02-20 21:00:00'),
(291, 1049, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-20 21:00:00', '2026-02-20 21:00:00'),
(292, 1049, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-20 21:00:00', '2026-02-20 21:00:00'),
(293, 1050, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-20 22:00:00', '2026-02-20 22:00:00'),
(294, 1051, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-02-21 18:30:00', '2026-02-21 18:30:00'),
(295, 1052, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-02-21 19:30:00', '2026-02-21 19:30:00'),
(296, 1053, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-21 20:30:00', '2026-02-21 20:30:00'),
(297, 1054, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-21 21:30:00', '2026-02-21 21:30:00'),
(298, 1054, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-21 21:30:00', '2026-02-21 21:30:00'),
(299, 1054, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-21 21:30:00', '2026-02-21 21:30:00'),
(300, 1054, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-21 21:30:00', '2026-02-21 21:30:00'),
(301, 1055, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-02-21 22:30:00', '2026-02-21 22:30:00'),
(302, 1055, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-02-21 22:30:00', '2026-02-21 22:30:00'),
(303, 1056, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-22 19:00:00', '2026-02-22 19:00:00'),
(304, 1057, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-22 20:30:00', '2026-02-22 20:30:00'),
(305, 1057, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-22 20:30:00', '2026-02-22 20:30:00'),
(306, 1058, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-22 22:00:00', '2026-02-22 22:00:00'),
(307, 1059, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-23 20:30:00', '2026-02-23 20:30:00'),
(308, 1060, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-24 21:00:00', '2026-02-24 21:00:00'),
(309, 1061, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-25 19:30:00', '2026-02-25 19:30:00'),
(310, 1061, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-25 19:30:00', '2026-02-25 19:30:00'),
(311, 1061, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-25 19:30:00', '2026-02-25 19:30:00'),
(312, 1061, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-25 19:30:00', '2026-02-25 19:30:00'),
(313, 1062, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-25 21:00:00', '2026-02-25 21:00:00'),
(314, 1063, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-02-26 20:00:00', '2026-02-26 20:00:00'),
(315, 1063, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-26 20:00:00', '2026-02-26 20:00:00'),
(316, 1063, 92, 'Moscow Mule', 1, 88.00, 88.00, NULL, NULL, '2026-02-26 20:00:00', '2026-02-26 20:00:00'),
(317, 1064, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-02-26 21:30:00', '2026-02-26 21:30:00'),
(318, 1064, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-02-26 21:30:00', '2026-02-26 21:30:00'),
(319, 1065, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-02-27 19:00:00', '2026-02-27 19:00:00'),
(320, 1065, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-27 19:00:00', '2026-02-27 19:00:00'),
(321, 1066, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-27 20:00:00', '2026-02-27 20:00:00'),
(322, 1067, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-27 21:00:00', '2026-02-27 21:00:00'),
(323, 1067, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-27 21:00:00', '2026-02-27 21:00:00'),
(324, 1067, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-27 21:00:00', '2026-02-27 21:00:00'),
(325, 1067, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-27 21:00:00', '2026-02-27 21:00:00'),
(326, 1068, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-02-27 22:00:00', '2026-02-27 22:00:00'),
(327, 1069, 131, 'Botella Buchanans 12 750ml', 1, 1500.00, 1500.00, NULL, NULL, '2026-02-28 18:30:00', '2026-02-28 18:30:00'),
(328, 1070, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-02-28 19:30:00', '2026-02-28 19:30:00'),
(329, 1071, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-02-28 20:30:00', '2026-02-28 20:30:00'),
(330, 1072, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-28 21:30:00', '2026-02-28 21:30:00'),
(331, 1072, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-02-28 21:30:00', '2026-02-28 21:30:00'),
(332, 1072, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-02-28 21:30:00', '2026-02-28 21:30:00'),
(333, 1072, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-02-28 21:30:00', '2026-02-28 21:30:00'),
(334, 1073, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-02-28 22:15:00', '2026-02-28 22:15:00'),
(335, 1073, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-02-28 22:15:00', '2026-02-28 22:15:00'),
(336, 2001, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-01 19:00:00', '2026-03-01 19:00:00'),
(337, 2002, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-01 20:15:00', '2026-03-01 20:15:00'),
(338, 2002, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-01 20:15:00', '2026-03-01 20:15:00'),
(339, 2002, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-01 20:15:00', '2026-03-01 20:15:00'),
(340, 2002, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-01 20:15:00', '2026-03-01 20:15:00'),
(341, 2003, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-03-01 21:30:00', '2026-03-01 21:30:00'),
(342, 2003, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-03-01 21:30:00', '2026-03-01 21:30:00'),
(343, 2004, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-02 20:30:00', '2026-03-02 20:30:00'),
(344, 2005, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-03 21:00:00', '2026-03-03 21:00:00'),
(345, 2006, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-04 19:30:00', '2026-03-04 19:30:00'),
(346, 2006, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-03-04 19:30:00', '2026-03-04 19:30:00'),
(347, 2006, 92, 'Moscow Mule', 1, 88.00, 88.00, NULL, NULL, '2026-03-04 19:30:00', '2026-03-04 19:30:00'),
(348, 2007, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-04 21:30:00', '2026-03-04 21:30:00'),
(349, 2008, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(350, 2008, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-03-05 19:45:00', '2026-03-05 19:45:00'),
(351, 2009, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-05 21:30:00', '2026-03-05 21:30:00'),
(352, 2009, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-03-05 21:30:00', '2026-03-05 21:30:00'),
(353, 2010, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-03-06 19:00:00', '2026-03-06 19:00:00'),
(354, 2011, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-06 20:00:00', '2026-03-06 20:00:00'),
(355, 2012, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-06 21:00:00', '2026-03-06 21:00:00'),
(356, 2012, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-06 21:00:00', '2026-03-06 21:00:00'),
(357, 2012, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-06 21:00:00', '2026-03-06 21:00:00'),
(358, 2012, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-06 21:00:00', '2026-03-06 21:00:00'),
(359, 2013, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-06 22:00:00', '2026-03-06 22:00:00'),
(360, 2014, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-03-07 18:30:00', '2026-03-07 18:30:00'),
(361, 2015, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-03-07 19:30:00', '2026-03-07 19:30:00'),
(362, 2016, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-07 20:30:00', '2026-03-07 20:30:00'),
(363, 2017, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-07 21:30:00', '2026-03-07 21:30:00'),
(364, 2017, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-07 21:30:00', '2026-03-07 21:30:00'),
(365, 2017, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-07 21:30:00', '2026-03-07 21:30:00'),
(366, 2017, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-07 21:30:00', '2026-03-07 21:30:00'),
(367, 2018, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-07 22:30:00', '2026-03-07 22:30:00'),
(368, 2018, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-07 22:30:00', '2026-03-07 22:30:00'),
(369, 2019, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(370, 2019, 134, '6 Shots José cuervo especial blanco', 1, 250.00, 250.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(371, 2019, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(372, 2019, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(373, 2019, 96, 'Long island blue', 1, 90.00, 90.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(374, 2019, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-03-08 18:30:00', '2026-03-08 18:30:00'),
(375, 2020, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-08 20:00:00', '2026-03-08 20:00:00'),
(376, 2020, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-08 20:00:00', '2026-03-08 20:00:00'),
(377, 2020, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-08 20:00:00', '2026-03-08 20:00:00'),
(378, 2020, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-08 20:00:00', '2026-03-08 20:00:00'),
(379, 2021, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-08 21:30:00', '2026-03-08 21:30:00'),
(380, 2021, 100, 'Margarita', 1, 80.00, 80.00, NULL, NULL, '2026-03-08 21:30:00', '2026-03-08 21:30:00'),
(381, 2021, 106, 'Cantarito', 1, 85.00, 85.00, NULL, NULL, '2026-03-08 21:30:00', '2026-03-08 21:30:00'),
(382, 2022, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-09 21:00:00', '2026-03-09 21:00:00'),
(383, 2022, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-03-09 21:00:00', '2026-03-09 21:00:00'),
(384, 2023, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-10 21:00:00', '2026-03-10 21:00:00'),
(385, 2024, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-11 19:30:00', '2026-03-11 19:30:00'),
(386, 2024, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-11 19:30:00', '2026-03-11 19:30:00'),
(387, 2024, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-11 19:30:00', '2026-03-11 19:30:00'),
(388, 2024, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-11 19:30:00', '2026-03-11 19:30:00'),
(389, 2025, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-11 21:00:00', '2026-03-11 21:00:00'),
(390, 2026, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-12 20:00:00', '2026-03-12 20:00:00'),
(391, 2026, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-03-12 20:00:00', '2026-03-12 20:00:00'),
(392, 2026, 92, 'Moscow Mule', 1, 88.00, 88.00, NULL, NULL, '2026-03-12 20:00:00', '2026-03-12 20:00:00'),
(393, 2027, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-12 21:30:00', '2026-03-12 21:30:00'),
(394, 2028, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-03-13 19:00:00', '2026-03-13 19:00:00'),
(395, 2028, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-13 19:00:00', '2026-03-13 19:00:00'),
(396, 2029, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-13 20:00:00', '2026-03-13 20:00:00'),
(397, 2030, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-13 21:00:00', '2026-03-13 21:00:00'),
(398, 2030, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-13 21:00:00', '2026-03-13 21:00:00'),
(399, 2030, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-13 21:00:00', '2026-03-13 21:00:00'),
(400, 2030, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-13 21:00:00', '2026-03-13 21:00:00'),
(401, 2031, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-13 22:00:00', '2026-03-13 22:00:00'),
(402, 2031, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-13 22:00:00', '2026-03-13 22:00:00'),
(403, 2032, 131, 'Botella Buchanans 12 750ml', 1, 1500.00, 1500.00, NULL, NULL, '2026-03-14 18:30:00', '2026-03-14 18:30:00'),
(404, 2033, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-03-14 19:30:00', '2026-03-14 19:30:00'),
(405, 2034, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-14 20:30:00', '2026-03-14 20:30:00'),
(406, 2035, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-14 21:30:00', '2026-03-14 21:30:00'),
(407, 2035, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-14 21:30:00', '2026-03-14 21:30:00'),
(408, 2035, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-14 21:30:00', '2026-03-14 21:30:00'),
(409, 2035, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-14 21:30:00', '2026-03-14 21:30:00'),
(410, 2036, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-03-14 22:30:00', '2026-03-14 22:30:00'),
(411, 2036, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-03-14 22:30:00', '2026-03-14 22:30:00'),
(412, 2037, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-15 19:00:00', '2026-03-15 19:00:00'),
(413, 2038, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-15 20:30:00', '2026-03-15 20:30:00'),
(414, 2038, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-15 20:30:00', '2026-03-15 20:30:00'),
(415, 2038, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-15 20:30:00', '2026-03-15 20:30:00'),
(416, 2038, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-15 20:30:00', '2026-03-15 20:30:00'),
(417, 2039, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-15 21:20:00', '2026-03-15 21:20:00'),
(418, 2039, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-15 21:20:00', '2026-03-15 21:20:00'),
(419, 2040, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-16 21:00:00', '2026-03-16 21:00:00'),
(420, 2041, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-17 21:00:00', '2026-03-17 21:00:00'),
(421, 2042, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-18 19:30:00', '2026-03-18 19:30:00'),
(422, 2042, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-18 19:30:00', '2026-03-18 19:30:00'),
(423, 2042, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-18 19:30:00', '2026-03-18 19:30:00'),
(424, 2042, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-18 19:30:00', '2026-03-18 19:30:00'),
(425, 2043, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-03-18 21:00:00', '2026-03-18 21:00:00'),
(426, 2043, 100, 'Margarita', 1, 80.00, 80.00, NULL, NULL, '2026-03-18 21:00:00', '2026-03-18 21:00:00'),
(427, 2043, 106, 'Cantarito', 1, 85.00, 85.00, NULL, NULL, '2026-03-18 21:00:00', '2026-03-18 21:00:00'),
(428, 2044, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-19 20:00:00', '2026-03-19 20:00:00'),
(429, 2045, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-19 21:30:00', '2026-03-19 21:30:00'),
(430, 2046, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-03-20 19:00:00', '2026-03-20 19:00:00'),
(431, 2047, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-20 20:00:00', '2026-03-20 20:00:00'),
(432, 2048, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-20 21:00:00', '2026-03-20 21:00:00'),
(433, 2048, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-20 21:00:00', '2026-03-20 21:00:00'),
(434, 2048, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-20 21:00:00', '2026-03-20 21:00:00'),
(435, 2048, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-20 21:00:00', '2026-03-20 21:00:00'),
(436, 2049, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-20 22:00:00', '2026-03-20 22:00:00'),
(437, 2050, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-03-21 18:30:00', '2026-03-21 18:30:00'),
(438, 2051, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-03-21 19:30:00', '2026-03-21 19:30:00'),
(439, 2052, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-21 20:30:00', '2026-03-21 20:30:00'),
(440, 2053, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-21 21:30:00', '2026-03-21 21:30:00'),
(441, 2053, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-21 21:30:00', '2026-03-21 21:30:00'),
(442, 2053, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-21 21:30:00', '2026-03-21 21:30:00'),
(443, 2053, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-21 21:30:00', '2026-03-21 21:30:00'),
(444, 2054, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-21 22:30:00', '2026-03-21 22:30:00'),
(445, 2054, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-21 22:30:00', '2026-03-21 22:30:00'),
(446, 2055, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-22 19:00:00', '2026-03-22 19:00:00'),
(447, 2056, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-22 20:30:00', '2026-03-22 20:30:00'),
(448, 2056, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-22 20:30:00', '2026-03-22 20:30:00'),
(449, 2056, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-22 20:30:00', '2026-03-22 20:30:00'),
(450, 2056, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-22 20:30:00', '2026-03-22 20:30:00'),
(451, 2057, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-22 22:00:00', '2026-03-22 22:00:00'),
(452, 2058, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-23 21:00:00', '2026-03-23 21:00:00'),
(453, 2058, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-03-23 21:00:00', '2026-03-23 21:00:00'),
(454, 2059, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-24 21:00:00', '2026-03-24 21:00:00'),
(455, 2060, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-25 19:30:00', '2026-03-25 19:30:00'),
(456, 2060, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-25 19:30:00', '2026-03-25 19:30:00'),
(457, 2060, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-25 19:30:00', '2026-03-25 19:30:00'),
(458, 2060, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-25 19:30:00', '2026-03-25 19:30:00'),
(459, 2061, 32, 'Clásico Arrachera', 1, 155.00, 155.00, NULL, NULL, '2026-03-25 23:00:00', '2026-03-25 23:00:00'),
(460, 2061, 41, 'Strombo Original', 1, 89.00, 89.00, NULL, NULL, '2026-03-25 23:00:00', '2026-03-25 23:00:00'),
(461, 2062, 121, 'Botella Captain Morgan 750ml', 1, 620.00, 620.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(462, 2062, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(463, 2062, 134, '6 Shots José cuervo especial blanco', 1, 250.00, 250.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(464, 2062, 19, 'Hawaiana Teriyaki', 3, 125.00, 375.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(465, 2062, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(466, 2062, 96, 'Long island blue', 3, 90.00, 270.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(467, 2062, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-03-26 19:00:00', '2026-03-26 19:00:00'),
(468, 2063, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-26 21:00:00', '2026-03-26 21:00:00'),
(469, 2063, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-26 21:00:00', '2026-03-26 21:00:00'),
(470, 2064, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-03-27 19:00:00', '2026-03-27 19:00:00'),
(471, 2064, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-27 19:00:00', '2026-03-27 19:00:00'),
(472, 2065, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-27 20:00:00', '2026-03-27 20:00:00'),
(473, 2066, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-27 21:00:00', '2026-03-27 21:00:00'),
(474, 2066, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-27 21:00:00', '2026-03-27 21:00:00'),
(475, 2066, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-27 21:00:00', '2026-03-27 21:00:00'),
(476, 2066, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-27 21:00:00', '2026-03-27 21:00:00'),
(477, 2067, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-27 22:00:00', '2026-03-27 22:00:00'),
(478, 2067, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-27 22:00:00', '2026-03-27 22:00:00'),
(479, 2068, 131, 'Botella Buchanans 12 750ml', 1, 1500.00, 1500.00, NULL, NULL, '2026-03-28 18:30:00', '2026-03-28 18:30:00'),
(480, 2069, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-28 19:30:00', '2026-03-28 19:30:00'),
(481, 2070, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-03-28 20:30:00', '2026-03-28 20:30:00'),
(482, 2071, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-28 21:30:00', '2026-03-28 21:30:00'),
(483, 2071, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-28 21:30:00', '2026-03-28 21:30:00'),
(484, 2071, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-28 21:30:00', '2026-03-28 21:30:00'),
(485, 2071, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-28 21:30:00', '2026-03-28 21:30:00'),
(486, 2072, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-28 22:30:00', '2026-03-28 22:30:00'),
(487, 2072, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-03-28 22:30:00', '2026-03-28 22:30:00'),
(488, 2073, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-03-29 19:00:00', '2026-03-29 19:00:00'),
(489, 2074, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-29 20:30:00', '2026-03-29 20:30:00'),
(490, 2074, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-29 20:30:00', '2026-03-29 20:30:00'),
(491, 2074, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-03-29 20:30:00', '2026-03-29 20:30:00'),
(492, 2074, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-03-29 20:30:00', '2026-03-29 20:30:00'),
(493, 2075, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-03-29 22:00:00', '2026-03-29 22:00:00');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `subtotal`, `excluded_ingredients`, `exclusiones`, `created_at`, `updated_at`) VALUES
(494, 2075, 90, 'Azulito', 1, 55.00, 55.00, NULL, NULL, '2026-03-29 22:00:00', '2026-03-29 22:00:00'),
(495, 2076, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-03-30 21:00:00', '2026-03-30 21:00:00'),
(496, 2077, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-03-31 21:00:00', '2026-03-31 21:00:00'),
(497, 3001, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-01 19:30:00', '2026-04-01 19:30:00'),
(498, 3001, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-01 19:30:00', '2026-04-01 19:30:00'),
(499, 3001, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-01 19:30:00', '2026-04-01 19:30:00'),
(500, 3001, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-01 19:30:00', '2026-04-01 19:30:00'),
(501, 3002, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-04-01 21:00:00', '2026-04-01 21:00:00'),
(502, 3003, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-04-02 20:00:00', '2026-04-02 20:00:00'),
(503, 3003, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-04-02 20:00:00', '2026-04-02 20:00:00'),
(504, 3003, 92, 'Moscow Mule', 1, 88.00, 88.00, NULL, NULL, '2026-04-02 20:00:00', '2026-04-02 20:00:00'),
(505, 3004, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-02 21:30:00', '2026-04-02 21:30:00'),
(506, 3004, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-04-02 21:30:00', '2026-04-02 21:30:00'),
(507, 3005, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-04-03 19:00:00', '2026-04-03 19:00:00'),
(508, 3006, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-03 20:00:00', '2026-04-03 20:00:00'),
(509, 3007, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-03 21:00:00', '2026-04-03 21:00:00'),
(510, 3007, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-03 21:00:00', '2026-04-03 21:00:00'),
(511, 3007, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-03 21:00:00', '2026-04-03 21:00:00'),
(512, 3007, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-03 21:00:00', '2026-04-03 21:00:00'),
(513, 3008, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-04-03 22:00:00', '2026-04-03 22:00:00'),
(514, 3009, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-04 20:00:00', '2026-04-04 20:00:00'),
(515, 3010, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-04-04 19:00:00', '2026-04-04 19:00:00'),
(516, 3011, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-04-04 20:30:00', '2026-04-04 20:30:00'),
(517, 3012, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-04 21:30:00', '2026-04-04 21:30:00'),
(518, 3012, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-04 21:30:00', '2026-04-04 21:30:00'),
(519, 3012, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-04 21:30:00', '2026-04-04 21:30:00'),
(520, 3012, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-04 21:30:00', '2026-04-04 21:30:00'),
(521, 3013, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-04 22:30:00', '2026-04-04 22:30:00'),
(522, 3013, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-04-04 22:30:00', '2026-04-04 22:30:00'),
(523, 3014, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-05 19:00:00', '2026-04-05 19:00:00'),
(524, 3015, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-05 20:30:00', '2026-04-05 20:30:00'),
(525, 3015, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-05 20:30:00', '2026-04-05 20:30:00'),
(526, 3015, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-05 20:30:00', '2026-04-05 20:30:00'),
(527, 3015, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-05 20:30:00', '2026-04-05 20:30:00'),
(528, 3016, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-04-05 22:00:00', '2026-04-05 22:00:00'),
(529, 3017, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-06 21:00:00', '2026-04-06 21:00:00'),
(530, 3018, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-07 21:00:00', '2026-04-07 21:00:00'),
(531, 3019, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-08 19:30:00', '2026-04-08 19:30:00'),
(532, 3019, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-08 19:30:00', '2026-04-08 19:30:00'),
(533, 3019, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-08 19:30:00', '2026-04-08 19:30:00'),
(534, 3019, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-08 19:30:00', '2026-04-08 19:30:00'),
(535, 3020, 50, 'Nachos 501', 1, 95.00, 95.00, NULL, NULL, '2026-04-08 21:00:00', '2026-04-08 21:00:00'),
(536, 3020, 100, 'Margarita', 1, 80.00, 80.00, NULL, NULL, '2026-04-08 21:00:00', '2026-04-08 21:00:00'),
(537, 3020, 106, 'Cantarito', 1, 85.00, 85.00, NULL, NULL, '2026-04-08 21:00:00', '2026-04-08 21:00:00'),
(538, 3021, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-04-09 20:00:00', '2026-04-09 20:00:00'),
(539, 3022, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-09 21:30:00', '2026-04-09 21:30:00'),
(540, 3022, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-04-09 21:30:00', '2026-04-09 21:30:00'),
(541, 3023, 26, 'Jocho Clásico', 1, 99.00, 99.00, NULL, NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(542, 3023, 71, 'Cerveza Corona', 1, 35.00, 35.00, NULL, NULL, '2026-04-10 18:30:00', '2026-04-10 18:30:00'),
(543, 3024, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-04-10 19:30:00', '2026-04-10 19:30:00'),
(544, 3025, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-10 20:30:00', '2026-04-10 20:30:00'),
(545, 3026, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-10 21:30:00', '2026-04-10 21:30:00'),
(546, 3026, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-10 21:30:00', '2026-04-10 21:30:00'),
(547, 3026, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-10 21:30:00', '2026-04-10 21:30:00'),
(548, 3026, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-10 21:30:00', '2026-04-10 21:30:00'),
(549, 3027, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-11 16:00:00', '2026-04-11 16:00:00'),
(550, 3028, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-11 16:15:00', '2026-04-11 16:15:00'),
(551, 3028, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-11 16:15:00', '2026-04-11 16:15:00'),
(552, 3028, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-11 16:15:00', '2026-04-11 16:15:00'),
(553, 3028, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-11 16:15:00', '2026-04-11 16:15:00'),
(554, 3029, 120, 'Botella Maestro dobel diamante 700ml', 1, 1300.00, 1300.00, NULL, NULL, '2026-04-11 19:00:00', '2026-04-11 19:00:00'),
(555, 3030, 130, 'Botella Jack Daniel\'s 700ml', 1, 1000.00, 1000.00, NULL, NULL, '2026-04-11 20:30:00', '2026-04-11 20:30:00'),
(556, 3031, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-11 21:30:00', '2026-04-11 21:30:00'),
(557, 3031, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-11 21:30:00', '2026-04-11 21:30:00'),
(558, 3031, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-11 21:30:00', '2026-04-11 21:30:00'),
(559, 3031, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-11 21:30:00', '2026-04-11 21:30:00'),
(560, 3032, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-12 21:45:00', '2026-04-12 21:45:00'),
(561, 3032, 160, 'Salsa BBQ', 1, 0.00, 0.00, NULL, NULL, '2026-04-12 21:45:00', '2026-04-12 21:45:00'),
(562, 3033, 117, 'Botella José cuervo especial blanco 1L', 1, 770.00, 770.00, NULL, NULL, '2026-04-12 19:00:00', '2026-04-12 19:00:00'),
(563, 3034, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-12 20:30:00', '2026-04-12 20:30:00'),
(564, 3034, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-12 20:30:00', '2026-04-12 20:30:00'),
(565, 3034, 81, 'Malibú', 1, 82.00, 82.00, NULL, NULL, '2026-04-12 20:30:00', '2026-04-12 20:30:00'),
(566, 3034, 71, 'Cerveza Corona', 2, 35.00, 70.00, NULL, NULL, '2026-04-12 20:30:00', '2026-04-12 20:30:00'),
(567, 3035, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-13 22:09:16', '2026-04-13 22:09:16'),
(568, 3036, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-14 19:30:00', '2026-04-14 19:30:00'),
(569, 3037, 106, 'Cantarito', 1, 77.00, 77.00, NULL, NULL, '2026-04-14 22:00:00', '2026-04-14 22:00:00'),
(570, 3037, 141, 'Copeo José cuervo especial blanco 1.5oz', 1, 75.00, 75.00, NULL, NULL, '2026-04-14 22:00:00', '2026-04-14 22:00:00'),
(571, 3038, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-14 22:30:59', '2026-04-14 22:30:59'),
(572, 3039, 21, 'Arrachera', 1, 120.00, 120.00, NULL, NULL, '2026-04-14 22:31:44', '2026-04-14 22:31:44'),
(573, 3040, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(574, 3040, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(575, 3040, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(576, 3040, 20, 'Mexa', 1, 135.00, 135.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(577, 3040, 22, 'Especial Rings', 1, 125.00, 125.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(578, 3040, 205, 'Hamburguesa Argentina', 1, 138.00, 138.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(579, 3040, 206, 'White Burger', 1, 140.00, 140.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(580, 3040, 207, 'Hamburguesa Marisquera', 1, 152.00, 152.00, NULL, NULL, '2026-04-14 22:36:47', '2026-04-14 22:36:47'),
(581, 8011, 16, 'Clásica', 2, 195.00, 390.00, NULL, NULL, '2026-04-15 07:22:25', '2026-04-15 07:22:25'),
(582, 8011, 33, 'Pollo', 1, 145.00, 145.00, NULL, NULL, '2026-04-15 07:22:25', '2026-04-15 07:22:25'),
(583, 8011, 53, 'Con arrachera', 1, 135.00, 135.00, NULL, NULL, '2026-04-15 07:22:25', '2026-04-15 07:22:25'),
(584, 8012, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(585, 8012, 17, 'Boneless', 2, 112.00, 224.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(586, 8012, 73, 'Cerveza Ultra', 1, 40.00, 40.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(587, 8012, 46, 'Strombo Argentino', 1, 99.00, 99.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(588, 8012, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(589, 8012, 212, 'Jocho 501', 1, 122.00, 122.00, NULL, NULL, '2026-04-21 05:26:06', '2026-04-21 05:26:06'),
(590, 8013, 17, 'Boneless', 3, 112.00, 336.00, NULL, NULL, '2026-04-21 08:20:11', '2026-04-21 08:20:11'),
(591, 8013, 118, 'Botella José cuervo tradicional 1L', 1, 930.00, 930.00, NULL, NULL, '2026-04-21 08:20:11', '2026-04-21 08:20:11'),
(592, 8013, 210, 'Jocho Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-04-21 08:20:11', '2026-04-21 08:20:11'),
(593, 8013, 211, 'Jocho Argentino', 1, 112.00, 112.00, NULL, NULL, '2026-04-21 08:20:11', '2026-04-21 08:20:11'),
(594, 8014, 16, 'Clásica', 1, 195.00, 195.00, '[\"Cebolla Blanca\",\"Jitomate\",\"Queso Amarillo\"]', NULL, '2026-06-30 08:26:58', '2026-06-30 08:26:58'),
(595, 8014, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-06-30 08:26:58', '2026-06-30 08:26:58'),
(596, 8015, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-06-30 09:30:45', '2026-06-30 09:30:45'),
(597, 8015, 17, 'Boneless', 1, 112.00, 112.00, NULL, NULL, '2026-06-30 09:30:45', '2026-06-30 09:30:45'),
(598, 8016, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-06-30 09:31:39', '2026-06-30 09:31:39'),
(599, 8017, 16, 'Clásica', 1, 195.00, 195.00, NULL, NULL, '2026-06-30 09:44:20', '2026-06-30 09:44:20'),
(600, 8018, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-06-30 10:01:16', '2026-06-30 10:01:16'),
(601, 8018, 16, 'Clásica', 1, 195.00, 195.00, '[\"Tocino\"]', NULL, '2026-06-30 10:01:16', '2026-06-30 10:01:16'),
(602, 8019, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-06-30 10:10:10', '2026-06-30 10:10:10'),
(603, 8019, 16, 'Clásica', 1, 195.00, 195.00, '[\"Jam\\u00f3n\"]', NULL, '2026-06-30 10:10:10', '2026-06-30 10:10:10'),
(604, 8020, 17, 'Boneless', 1, 112.00, 112.00, '[\"Jitomate\"]', NULL, '2026-06-30 10:11:02', '2026-06-30 10:11:02'),
(605, 8021, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, '[]', NULL, '2026-06-30 10:11:20', '2026-06-30 10:11:20'),
(606, 8022, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-06-30 10:40:07', '2026-06-30 10:40:07'),
(607, 8022, 16, 'Clásica', 1, 195.00, 195.00, '[\"Jam\\u00f3n\"]', NULL, '2026-06-30 10:40:07', '2026-06-30 10:40:07'),
(608, 8023, 22, 'Especial Rings', 1, 125.00, 125.00, '[\"Cebolla Blanca\",\"Aros de Cebolla\"]', NULL, '2026-06-30 10:40:59', '2026-06-30 10:40:59'),
(609, 8024, 16, 'Clásica', 1, 195.00, 195.00, '[\"Jitomate\"]', NULL, '2026-06-30 10:45:04', '2026-06-30 10:45:04'),
(610, 8025, 16, 'Clásica', 1, 195.00, 195.00, '[\"Tocino\"]', NULL, '2026-06-30 12:06:42', '2026-06-30 12:06:42'),
(611, 8026, 17, 'Boneless', 1, 112.00, 112.00, '[\"Jitomate\"]', NULL, '2026-06-30 12:08:10', '2026-06-30 12:08:10'),
(612, 8027, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, '[]', NULL, '2026-06-30 12:10:44', '2026-06-30 12:10:44'),
(613, 8028, 222, 'Strombo Hawaiano', 1, 99.00, 99.00, '[]', NULL, '2026-06-30 12:11:24', '2026-06-30 12:11:24'),
(614, 8028, 33, 'Pollo', 1, 145.00, 145.00, '[]', NULL, '2026-06-30 12:11:24', '2026-06-30 12:11:24'),
(615, 8028, 17, 'Boneless', 1, 112.00, 112.00, '[\"Lechuga\"]', NULL, '2026-06-30 12:11:24', '2026-06-30 12:11:24'),
(616, 8029, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-06-30 12:14:15', '2026-06-30 12:14:15'),
(617, 8030, 18, 'Jalapeño Poppers', 1, 140.00, 140.00, '[]', NULL, '2026-07-02 15:33:26', '2026-07-02 15:33:26'),
(618, 8031, 203, 'Hamburguesa Arrachera', 1, 152.00, 152.00, '[\"Queso Mozzarella\"]', NULL, '2026-07-03 12:16:45', '2026-07-03 12:16:45'),
(619, 8032, 16, 'Clásica', 1, 195.00, 195.00, '[\"Queso Amarillo\"]', NULL, '2026-07-03 13:25:54', '2026-07-03 13:25:54'),
(620, 8032, 16, 'Clásica', 1, 195.00, 195.00, '[]', NULL, '2026-07-03 13:25:54', '2026-07-03 13:25:54'),
(621, 8033, 17, 'Boneless', 1, 112.00, 112.00, '[\"Queso Mozzarella\"]', NULL, '2026-07-03 13:27:17', '2026-07-03 13:27:17'),
(622, 8034, 16, 'Clásica', 1, 195.00, 195.00, '[\"Cebolla Blanca\",\"Jam\\u00f3n\",\"Queso Amarillo\",\"Queso Mozzarella\"]', NULL, '2026-07-03 13:43:25', '2026-07-03 13:43:25'),
(623, 8035, 198, 'Hamburguesa Clásica', 1, 112.00, 112.00, '[]', NULL, '2026-07-03 14:13:20', '2026-07-03 14:13:20'),
(624, 8035, 207, 'Hamburguesa Marisquera', 1, 152.00, 152.00, '[\"Camar\\u00f3n\"]', NULL, '2026-07-03 14:13:20', '2026-07-03 14:13:20'),
(625, 8036, 19, 'Hawaiana Teriyaki', 1, 125.00, 125.00, '[]', NULL, '2026-07-03 14:16:53', '2026-07-03 14:16:53'),
(626, 8037, 247, 'Agua de Jamaica', 1, 38.00, 38.00, '[]', NULL, '2026-07-03 14:17:29', '2026-07-03 14:17:29'),
(627, 8038, 71, 'Cerveza Corona', 1, 35.00, 35.00, '[]', NULL, '2026-07-03 14:18:09', '2026-07-03 14:18:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('luis.angelhdez1811@gmail.com', '$2y$12$j3ihfL3LRab5iWvJSNtEhuJnHYC.v4dUScLG5EBlz62wPVNC/Ihhi', '2026-03-09 21:11:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `subcategory` varchar(255) DEFAULT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `min_stock` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `category`, `subcategory`, `available`, `created_at`, `updated_at`, `stock`, `min_stock`) VALUES
(16, 'Clásica', 'Carne de res, jamón, tocino, queso fundido, queso amarillo, mayonesa, lechuga, cebolla, jitomate y salsa de la casa', 'https://res.cloudinary.com/decigylbc/image/upload/v1783441608/l48oeaalcvlsdy08duxs.png', 195.00, 'Hamburguesas', NULL, 1, '2026-03-06 20:38:29', '2026-07-07 10:26:48', 0, 10),
(17, 'Boneless', 'Boneless bañado en tu salsa preferida, tocino, queso fundido, queso amarillo, mayonesa, lechuga, cebolla, jitomate', 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?q=80&w=1200&auto=format&fit=crop', 112.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(18, 'Jalapeño Poppers', 'Carne de res, jalapeño relleno de combinación de quesos envuelto en tocino, queso amarillo, queso blanco, tocino, aderezo de jalapeño', 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?q=80&w=1200&auto=format&fit=crop', 140.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(19, 'Hawaiana Teriyaki', 'Carne de res, piña a la plancha con baño de salsa teriyaki, tocino, queso fundido, mayonesa, lechuga, cebolla morada', 'https://images.unsplash.com/photo-1525059696034-4967a8e1dca2?q=80&w=1200&auto=format&fit=crop', 125.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(20, 'Mexa', 'Carne de res, salchichón, tocino, queso fundido, queso amarillo, mayonesa, lechuga, tiritas de maíz frito, jitomate, salsa de habanero cremoso', 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=1200&auto=format&fit=crop', 135.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(21, 'Arrachera', 'Orden de 3 tacos con queso. Incluye guacamole', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?q=80&w=1200&auto=format&fit=crop', 120.00, 'Tacos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(22, 'Especial Rings', 'Carne de res, aros de cebolla, tocino, salsa hot bbq, queso fundido, queso amarillo, mayonesa', 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=1200&auto=format&fit=crop', 125.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(23, 'Argentina', 'Carne de res, chorizo argentino, chimichurri, queso fundido, tocino, lechuga, cebolla, jitomate, mayonesa y un toque de aderezo de chipotle', 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=1200&auto=format&fit=crop', 138.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:08:42', 0, 10),
(24, 'White Burger', 'Carne de res, jamón, ensalada americana, jitomate, mayonesa, envuelta en queso fundido y tocino deshidratado', 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?q=80&w=1200&auto=format&fit=crop', 140.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(25, 'Marisquera', 'Camarón, y Surimi cocidos en toque de aceite macha, tocino, queso fundido, aderezo de chipotle, lechuga, cebolla morada y jitomate', 'https://images.unsplash.com/photo-1610440042657-612c34d95e9f?q=80&w=1200&auto=format&fit=crop', 152.00, 'Hamburguesas', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(26, 'Jocho Clásico', 'Salchicha envuelta con tocino, cebolla caramelizada, pico de gallo, queso derretido, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?q=80&w=1200&auto=format&fit=crop', 99.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(27, 'Jocho Boneless', 'Salchicha envuelta en tocino, boneless con tu salsa favorita, queso derretido, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1541214113241-21578d2d9b62?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(28, 'Jocho Argentino', 'Salchicha envuelta en tocino, chorizo argentino, chimichurri, queso derretido, cátsup y mostaza', 'https://images.unsplash.com/photo-1627059313773-ac9c065fec22?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(29, 'Jocho 501', 'Doble salchicha envueltas en tocino, extra queso fundido, cebolla caramelizada, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?q=80&w=1200&auto=format&fit=crop', 122.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(30, 'Jocho Mexa', 'Salchicha envuelta en tocino, salchichón, guacamole picoso, queso fundido, cebolla caramelizada, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1612240498936-65f5101365d2?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(31, 'Jocho Arrachera', 'Salchicha envuelta en tocino, Carne de arrachera, extra queso fundido, guacamole picoso, tocino, cebolla caramelizada, mayonesa', 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?q=80&w=1200&auto=format&fit=crop', 125.00, 'Jochos', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(32, 'Clásico Arrachera', 'Arrachera, papa frita, aguacate, lechuga, jitomate, cebolla asada, mezcla de quesos, frijoles refritos, salsa de la casa, envuelto en tortilla de harina caliente', 'https://images.unsplash.com/photo-1626700051175-6518c4793fde?q=80&w=1200&auto=format&fit=crop', 155.00, 'Burritos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(33, 'Pollo', 'Pechuga de pollo marinada, papa frita, lechuga, jitomate, aguacate, cebolla asada, tocino, envuelto en tortilla de harina, frijoles refritos, mezcla de quesos y aderezo de chipotle', 'https://images.unsplash.com/photo-1574784032398-356396e95c1c?q=80&w=1200&auto=format&fit=crop', 145.00, 'Burritos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(34, 'Texano', 'Arrachera, pimiento rojo, chilli, lechuga, cebolla asada, mezcla de quesos, papa crisscut, frijoles refritos, salsa, envuelto en tortilla de harina', 'https://images.unsplash.com/photo-1566740933430-b5e70b06d2d5?q=80&w=1200&auto=format&fit=crop', 160.00, 'Burritos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(35, 'Carnes Frías', 'Jamón, tocino, salchicha, salchichón, papa crisscut, pimientos, lechuga, jitomate, cebolla asada, mezcla de quesos, frijoles refritos, salsa, envuelto en tortilla de harina caliente', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 145.00, 'Burritos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(36, 'Canival', 'Arrachera, chistorra, chorizo argentino, tocino, salchichón, papa frita, jitomate, cebolla asada, mezcla de quesos, frioles refritos, salsa, envuelto en tortilla de harina caliente', 'https://images.unsplash.com/photo-1601924582970-9238bcb495d9?q=80&w=1200&auto=format&fit=crop', 165.00, 'Burritos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(37, 'Arrachera', 'Orden de 3 tacos con queso. Incluye guacamole', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?q=80&w=1200&auto=format&fit=crop', 120.00, 'Tacos', NULL, 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(38, 'Chistorra', 'Orden de 3 tacos con queso. Incluye guacamole', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 110.00, 'Tacos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(39, 'Chorizo Argentino', 'Orden de 3 tacos con queso. Incluye guacamole', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 110.00, 'Tacos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(40, 'Mixtos', 'Orden de 3 tacos con queso. Incluye guacamole', 'https://images.unsplash.com/photo-1615870216519-2f9fa575fa5c?q=80&w=1200&auto=format&fit=crop', 120.00, 'Tacos', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(41, 'Strombo Original', 'Albahaca, jitomate, toque de ajo y combinación de 3 quesos gouda, manchego y mozarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 89.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(42, 'Strombo de Carnes Frías', 'Jamón, salchicha, tocino, chorizo y queso mozarella', 'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(43, 'Strombo Pepperoni Champiñón', 'Pepperoni, champiñones y queso mozarella', 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?q=80&w=1200&auto=format&fit=crop', 95.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(44, 'Strombo Hawaiano', 'Jamón, salchicha, piña y queso mozarella', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(45, 'Strombo Italiano', 'Salchicha italiana, pepperoni, jamón serrano, aceitunas y queso mozarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 108.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(46, 'Strombo Argentino', 'Chorizo argentino, pimiento, chimichurri y queso mozzarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(47, 'Strombo Arrachera', 'Arrachera, pimiento, cebolla morada y queso mozzarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 125.00, 'Strombolis', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(48, 'Arma tus papas', 'Papas a la francesa o crisscut, queso amarillo, salsas de menú, ranch, parmesano, chile quebrado', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 92.00, 'Entradas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(49, 'Chilli papas', 'Papas fritas con chilli, ranch y queso amarillo. Agrega 1 salsa a tu gusto', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 99.00, 'Entradas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(50, 'Nachos 501', 'Totopos con frijoles, salchichón, chorizo argentino, pico de gallo y queso amarillo', 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?q=80&w=1200&auto=format&fit=crop', 95.00, 'Entradas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(51, 'Ensalada de frutos rojos', 'Fresa, manzana, arándano, lechuga, espinaca y aderezo', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 80.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(52, 'Con pollo a la plancha', '', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 99.00, 'Opción Fit', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(53, 'Con arrachera', '', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 135.00, 'Opción Fit', '', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(54, 'Ensalada césar', 'Lechuga, crotones, aderezo y parmesano', 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?q=80&w=1200&auto=format&fit=crop', 70.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(55, 'Con pollo a la plancha', '', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 99.00, 'Opción Fit', NULL, 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(56, 'Con arrachera', '', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 135.00, 'Opción Fit', NULL, 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(57, 'Malteada', 'Sabores: Moka, vainilla, chocolate o fresa', 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=1200&auto=format&fit=crop', 72.00, 'Algo Dulce', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(58, 'Cheesecake frutos rojos', '', 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?q=80&w=1200&auto=format&fit=crop', 79.00, 'Postres', 'Pasteles', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(59, 'Cheesecake oreo', '', 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?q=80&w=1200&auto=format&fit=crop', 79.00, 'Postres', 'Pasteles', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(60, 'Oreo fries + helado', 'Papas de oreo acompañadas de helado de vainilla', 'https://images.unsplash.com/photo-1551024601-bec78aea704b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Algo Dulce', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(61, 'Cafe americano', '', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1200&auto=format&fit=crop', 55.00, 'Postres', 'Cafetería', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(62, 'Chocolate caliente', '', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1200&auto=format&fit=crop', 55.00, 'Postres', 'Cafetería', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(63, 'Agua de limón', '', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 38.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(64, 'Agua de Jamaica', '', 'https://images.unsplash.com/photo-1497534446932-c925b458314e?q=80&w=1200&auto=format&fit=crop', 38.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(65, 'Limonada', '', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 52.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(66, 'Agua embotellada 600ml', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 25.00, 'Bebidas sin Alcohol', 'Embotelladas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(67, 'Coca Cola 600ml', '', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(68, 'Coca Cola Vidrio', '', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(69, 'Refrescos y jugos', '', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(70, 'Escuis de vidrio', '', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-06 20:38:29', '2026-07-08 09:02:11', 0, 10),
(71, 'Cerveza Corona', '', 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(72, 'Cerveza Victoria', '', 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(73, 'Cerveza Ultra', '', 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 40.00, 'Cervezas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(74, 'Preparado de michelada', '', 'https://images.unsplash.com/photo-1532634922-8fe0b757fb13?q=80&w=1200&auto=format&fit=crop', 30.00, 'Cervezas', 'Micheladas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(75, 'Michelada de litro', '', 'https://images.unsplash.com/photo-1532634922-8fe0b757fb13?q=80&w=1200&auto=format&fit=crop', 110.00, 'Cervezas', 'Micheladas', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(76, 'Cubeta de 6 cervezas', '', 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 200.00, 'Cervezas', 'Promociones', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(77, 'Cerveza Cero', '', 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', '', 1, '2026-03-06 20:38:29', '2026-07-08 08:54:18', 0, 10),
(81, 'Malibú', 'Ron malibú, jugo de piña, jugo de arándano y hielo', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(82, 'Piña colada', 'Ron, licor de coco, crema de coco y jugo de piña', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(83, 'Blue hawaiian', 'Ron, malibú, azul de curazao y toques citricos', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(84, 'Quemadita', 'Ron, agua mineral, coca cola y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(85, 'Mojito Cubano', 'Ron, limon, hierbabuena, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(86, 'Mojito de Coco', 'Ron, crema de coco, hierbabuena, y toque de limón', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(87, 'Mojito Frutos rojos', 'Ron, frutos rojos, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 89.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(88, 'Mojito de Maracuyá', 'Ron, Maracuya, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 89.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(89, 'Mojito de Mango', 'Ron, mango, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(90, 'Azulito', 'Vodka, mora azul, curazao y refresco de lima', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 55.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(91, 'Pantera Rosa', 'Vodka, piña, granadina y leche condensada', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(92, 'Moscow Mule', 'Vodka, limón, sirope de gengibre, hierbabuena y ginger', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 88.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(93, 'Limonada Eléctrica', 'Vodka, limon, agua mineral y mora azul', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(94, 'Mango deck', 'Vodka, Mango, endulzante y chamoy', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(95, 'Caipiroska', 'Vodka, limon, sirope y hielo triturado', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 70.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(96, 'Long island blue', 'Vodka, ron, ginebra, tequila, curazao, limón y mora azul', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 90.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(97, 'Beso de fresa', 'Vodka, granadina, jugo de arándano, soda de lima y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(98, 'Café Irlandés', 'Café, endulzante, licor de 43 chocolate y baileys', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Digestivos', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(99, 'Carajillo', 'Café, endulzante y licor del 43', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Digestivos', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(100, 'Margarita', 'Tequila, licor de naranja, miel de agave y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(101, 'Margarita de Fresa', 'Tequila, licor de naranja, miel de agave y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(102, 'Margarita Lavanda', 'Tequila, licor de naranja, sirope de lavanda, jugo de limón y crema de coco', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(103, 'Margarita Dragón', 'Tequila, licor de naranja, sirope de fruta dragón y jugo de limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(104, 'Tequila Sunrise', 'Tequila, jugo de naranja, granadina', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(105, 'Vampiro', 'Tequila, limón, toronja, sangrita y tajin', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(106, 'Cantarito', 'Tequila, jugo de naranja, refresco de toronja, jugo de limón y fruta citrica', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(107, 'Paloma Dragón', 'Tequila, jugo de limon, toronja y sirope de fruta dragón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(108, 'Mezcamaica', 'Mezcal, concentrado de jamaica, hierbabuena, sirope y agua mineral', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(109, 'Mezcandia', 'Mezcal, sandía, sirope y agua mineral', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(110, 'Mezcalita de Limón', 'Mezcal, licor de naranja, miel de agave y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(111, 'Mezcalita de Fresa', 'Mecal, licor de naranja, miel de agave y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(112, 'Mezcalita de Maracuyá', 'Mezcal, licor de naranja, miel de agave y maracuyá', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(113, 'Mezcalita de Tamarindo', 'Mezcal, licor de naranja, miel de agave y tamarindo', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(114, 'Gin Pepino Limón', 'Vodka, mora azul, curazao y refresco de lima', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 95.00, 'Coctelería', 'Ginebra', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(115, 'Gin Frutos Rojos', 'Ginebra, agua tónica y frutos rojos', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 95.00, 'Coctelería', 'Ginebra', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(116, 'Bruma', 'Ginebra, pulpa de guanabana, toque de albahaca y agua mineralizada', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 90.00, 'Coctelería', 'Ginebra', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(117, 'Botella José cuervo especial blanco 1L', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 770.00, 'Destilados', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(118, 'Botella José cuervo tradicional 1L', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 930.00, 'Destilados', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(119, 'Botella José cuervo tradicional cristalino', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1100.00, 'Destilados', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(120, 'Botella Maestro dobel diamante 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1300.00, 'Destilados', 'Tequila', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(121, 'Botella Captain Morgan 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 620.00, 'Destilados', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(122, 'Botella Bacardí blanco 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 600.00, 'Destilados', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(123, 'Botella Bacardí de mango-chile 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Ron', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(124, 'Botella Torres 5 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Brandy', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(125, 'Botella Torres 10 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 850.00, 'Destilados', 'Brandy', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(126, 'Botella Smirnoff 1L', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 780.00, 'Destilados', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(127, 'Botella Smirnoff Tamarindo 1L', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 870.00, 'Destilados', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(128, 'Botella Absolut Azul 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 875.00, 'Destilados', 'Vodka', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(129, 'Botella Black & White 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Whisky', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(130, 'Botella Jack Daniel\'s 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1000.00, 'Destilados', 'Whisky', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(131, 'Botella Buchanans 12 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1500.00, 'Destilados', 'Whisky', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(132, 'Botella Fandango Espadín Joven 750ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 700.00, 'Destilados', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(133, 'Botella 400 Conejos Joven 700ml', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1100.00, 'Destilados', 'Mezcal', 1, '2026-03-08 16:22:16', '2026-07-08 08:54:18', 0, 10),
(134, '6 Shots José cuervo especial blanco', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 250.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(135, '6 Shots José Cuervo tradicional', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(136, '6 Shots José Cuervo TRADICION cristalino', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 390.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(137, '6 Shots Bacardí mango chile', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(138, '6 Shots Smirnoff tamarindo', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(139, '6 Shots Mezcal fandango', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 300.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(140, '6 Shots Perlas negras', '', 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 350.00, 'Destilados', 'Shots', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(141, 'Copeo José cuervo especial blanco 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(142, 'Copeo José cuervo tradicional 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(143, 'Copeo José cuervo tradicional cristalino 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 110.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(144, 'Copeo Maestro dobel diamante 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 130.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(145, 'Copeo Captain Morgan 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(146, 'Copeo Bacardí blanco 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(147, 'Copeo Bacardí de mango-chile 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(148, 'Copeo Torres 5 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(149, 'Copeo Torres 10 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 95.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(150, 'Copeo Smirnoff 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(151, 'Copeo Smirnoff Tamarindo 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(152, 'Copeo Absolut Azul 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 85.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(153, 'Copeo Black & White 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(154, 'Copeo Jack Daniel\'s 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 120.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(155, 'Copeo Buchanans 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 135.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(156, 'Copeo Fandango Espadín Joven 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(157, 'Copeo 400 Conejos Joven 1.5oz', 'Servicio por copeo', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 120.00, 'Destilados', 'Copeo', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(158, 'Jugo de litro', 'Jugo natural preparado', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 70.00, 'Sin Alcohol', '', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(159, 'Mineral Topochico 600ml', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 40.00, 'Bebidas sin Alcohol', 'Extras', 1, '2026-03-08 16:22:16', '2026-07-08 09:02:11', 0, 10),
(160, 'Salsa BBQ', '', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(161, 'Salsa Mango Habanero', 'Picante nivel 4', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(162, 'Salsa Buffalo', 'Picante nivel 2', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(163, 'Salsa De La Casa', 'Picante nivel 4', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(164, 'Salsa Tamarindo Habanero', 'Picante nivel 4', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(165, 'Salsa Habanero Cremosa', 'Picante nivel 4', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(166, 'Salsa Hot BBQ', 'Picante nivel 1', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(167, 'Salsa Durazno Serrano', 'Picante nivel 4', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(168, 'Salsa Arándano Chipotle', 'Picante nivel 2', NULL, 0.00, 'Salsas y Extras', '', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(169, 'Adobo Tajín', 'Exclusivo para piernitas. Picante nivel 1', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(170, 'Salsa Callejera', 'Exclusivo para piernitas. Picante nivel 1', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(171, 'Adobo Clásico', 'Exclusivo para piernitas. Picante nivel 1', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(172, 'Chipotle Cremoso', 'Exclusivo para piernitas. Picante nivel 3', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(173, 'Salsa Macha', 'Exclusivo para piernitas. Picante nivel 3', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(174, 'Ajo Parmesano', 'Exclusivo para piernitas', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(175, 'Pimienta Limón', 'Exclusivo para piernitas', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(176, 'Teriyaki', 'Exclusivo para piernitas', NULL, 0.00, 'Salsas y Extras', 'Piernitas', 1, '2026-03-11 21:37:10', '2026-03-12 06:47:06', 0, 10),
(177, 'Arma tus papas', 'Papas a la francesa o crisscut, queso amarillo, salsas de menú, ranch, parmesano, chile quebrado', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 92.00, 'Entradas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(178, 'Chilli papas', 'Papas fritas con chilli, ranch y queso amarillo. Agrega 1 salsa a tu gusto', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 99.00, 'Entradas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(179, 'Nachos 501', 'Totopos con frijoles, salchichón, chorizo argentino, pico de gallo y queso amarillo', 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?q=80&w=1200&auto=format&fit=crop', 95.00, 'Entradas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(180, 'Chilli nachos', 'Totopos con frijoles, chilli, queso amarillo, ranch, pico de gallo y queso amarillo', 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?q=80&w=1200&auto=format&fit=crop', 99.00, 'Entradas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(181, 'Porción de Boneless', '4 piezas', 'https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?q=80&w=1200&auto=format&fit=crop', 35.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(182, 'Porción de Dedos de queso', '4 dedos', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 35.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(183, 'Porción de aros de cebolla', '6 aros', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 25.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(184, 'Porción de Chorizo argentino', '', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 25.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(185, 'Porción de salchichón', '', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 25.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(186, 'Porción de Arrachera Marinada', '', 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?q=80&w=1200&auto=format&fit=crop', 35.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(187, 'Porción de queso fundido', '', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 25.00, 'Entradas', 'Especialidades', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(188, 'Piernas Adobadas 350gr', 'Incluye 1 salsa', 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?q=80&w=1200&auto=format&fit=crop', 120.00, 'Alitas y Costillas', 'Piernas', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(189, 'Piernas Adobadas 700gr', 'Incluye 2 salsas', 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?q=80&w=1200&auto=format&fit=crop', 220.00, 'Alitas y Costillas', 'Piernas', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(190, 'Alitas 350gr', 'Incluye 1 salsa', 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?q=80&w=1200&auto=format&fit=crop', 140.00, 'Alitas y Costillas', 'Alitas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(191, 'Alitas 700gr', 'Incluye 2 salsas', 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?q=80&w=1200&auto=format&fit=crop', 270.00, 'Alitas y Costillas', 'Alitas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(192, 'Boneless 10 piezas', 'Incluye 1 salsa', 'https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?q=80&w=1200&auto=format&fit=crop', 129.00, 'Alitas y Costillas', 'Boneless', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(193, 'Boneless Medio kilo', 'Incluye 2 salsas', 'https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?q=80&w=1200&auto=format&fit=crop', 198.00, 'Alitas y Costillas', 'Boneless', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(194, 'Aros Cebolla 12 piezas', 'Incluye 1 salsa', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 98.00, 'Alitas y Costillas', 'Snacks', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(195, 'Aros Cebolla 18 piezas', 'Incluye 2 salsas', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 130.00, 'Alitas y Costillas', 'Snacks', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(196, 'Dedos de Queso 6 piezas', 'Incluye 1 salsa', 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?q=80&w=1200&auto=format&fit=crop', 140.00, 'Alitas y Costillas', 'Snacks', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(197, 'Costillas', '3-4 costillitas y papas fritas (1 salsa)', 'https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=1200&auto=format&fit=crop', 185.00, 'Alitas y Costillas', 'Costillas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(198, 'Hamburguesa Clásica', 'Carne de res, jamón, tocino, queso fundido, queso amarillo, mayonesa, lechuga, cebolla, jitomate y salsa de la casa', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1200&auto=format&fit=crop', 112.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(199, 'Hamburguesa Boneless', 'Boneless bañado en tu salsa preferida, tocino, queso fundido, queso amarillo, mayonesa, lechuga, cebolla, jitomate', 'https://images.unsplash.com/photo-1625813506062-0aeb1d7a094b?q=80&w=1200&auto=format&fit=crop', 112.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(200, 'Hamburguesa Jalapeño Poppers', 'Carne de res, jalapeño relleno de combinación de quesos envuelto en tocino, queso amarillo, queso blanco, tocino, aderezo jalapeño', 'https://images.unsplash.com/photo-1586190848861-99aa4a171e90?q=80&w=1200&auto=format&fit=crop', 140.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(201, 'Hamburguesa Hawaiana Teriyaki', 'Carne de res, piña a la plancha con baño de salsa teriyaki, tocino, queso fundido, mayonesa, lechuga, cebolla morada, jitomate', 'https://images.unsplash.com/photo-1525059696034-4967a8e1dca2?q=80&w=1200&auto=format&fit=crop', 125.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(202, 'Hamburguesa Mexa', 'Carne de res, salchichón, tocino, queso fundido, queso amarillo, mayonesa, lechuga, tiritas de maíz frito, jitomate y salsa de habanero cremoso', 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=1200&auto=format&fit=crop', 135.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(203, 'Hamburguesa Arrachera', '150gr de Carne de arrachera, queso fundido, guacamole, tocino, cebolla caramelizada, mayonesa, lechuga y jitomate', 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1200&auto=format&fit=crop', 152.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(204, 'Hamburguesa Especial Rings', 'Carne de res, aros de cebolla, tocino, salsa hot bbq, queso fundido, queso amarillo, mayonesa', 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=1200&auto=format&fit=crop', 125.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(205, 'Hamburguesa Argentina', 'Carne de res, Chorizo argentino, chimichurri, queso fundido, tocino, lechuga, cebolla, jitomate, mayonesa y un toque de aderezo chipotle', 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?q=80&w=1200&auto=format&fit=crop', 138.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 09:08:42', 0, 10),
(206, 'White Burger', 'Carne de res, jamón, ensalada americana, jitomate, mayonesa, envuelta en queso fundido y tocino deshidratado', 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?q=80&w=1200&auto=format&fit=crop', 140.00, 'Hamburguesas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(207, 'Hamburguesa Marisquera', 'Camarón y Surimi cocidos en toque de aceite macha, tocino, queso fundido, aderezo de chipotle, lechuga, cebolla morada y jitomate', 'https://images.unsplash.com/photo-1610440042657-612c34d95e9f?q=80&w=1200&auto=format&fit=crop', 152.00, 'Hamburguesas', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(208, 'Extra Papas (Hamburguesas o Jochos)', 'Agrega papas a tu platillo', 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1200&auto=format&fit=crop', 22.00, 'Extras', 'Complementos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(209, 'Jocho Clásico', 'Salchicha envuelta con tocino, cebolla caramelizada, pico de gallo, queso derretido, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?q=80&w=1200&auto=format&fit=crop', 99.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(210, 'Jocho Boneless', 'Salchicha envuelta en tocino, boneless con tu salsa favorita, queso derretido, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1541214113241-21578d2d9b62?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(211, 'Jocho Argentino', 'Salchicha envuelta en tocino, chorizo argentino, chimichurri, queso derretido, cátsup y mostaza', 'https://images.unsplash.com/photo-1627059313773-ac9c065fec22?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(212, 'Jocho 501', 'Doble salchicha envueltas en tocino, extra queso fundido, cebolla caramelizada, queso amarillo, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?q=80&w=1200&auto=format&fit=crop', 122.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(213, 'Jocho Mexa', 'Salchicha envuelta en tocino, salchichón, guacamole picoso, queso fundido, cebolla caramelizada, mayonesa, cátsup y mostaza', 'https://images.unsplash.com/photo-1612240498936-65f5101365d2?q=80&w=1200&auto=format&fit=crop', 112.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10);
INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `category`, `subcategory`, `available`, `created_at`, `updated_at`, `stock`, `min_stock`) VALUES
(214, 'Jocho Arrachera', 'Salchicha envuelta en tocino, Carne de arrachera, extra queso fundido, guacamole picoso, tocino, cebolla caramelizada, mayonesa', 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?q=80&w=1200&auto=format&fit=crop', 125.00, 'Jochos', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(215, 'Tacos de Arrachera (Orden 3)', 'Con queso, incluye guacamole', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?q=80&w=1200&auto=format&fit=crop', 120.00, 'Tacos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(216, 'Tacos de Chistorra (Orden 3)', 'Con queso, incluye guacamole', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 110.00, 'Tacos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(217, 'Tacos de Chorizo Argentino (Orden 3)', 'Con queso, incluye guacamole', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 110.00, 'Tacos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(218, 'Tacos Mixtos (Orden 3)', 'Con queso, incluye guacamole', 'https://images.unsplash.com/photo-1615870216519-2f9fa575fa5c?q=80&w=1200&auto=format&fit=crop', 120.00, 'Tacos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(219, 'Strombo Original', 'Albahaca, jitomate, toque de ajo y combinación de 3 quesos gouda, manchego y mozarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 89.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(220, 'Strombo de Carnes Frías', 'Jamón, salchicha, tocino, chorizo y queso mozarella', 'https://images.unsplash.com/photo-1593560708920-61dd98c46a4e?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(221, 'Strombo Pepperoni Champiñón', 'Pepperoni, champiñones y queso mozarella', 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?q=80&w=1200&auto=format&fit=crop', 95.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(222, 'Strombo Hawaiano', 'Jamón, salchicha, piña y queso mozarella', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(223, 'Strombo Italiano', 'Salchicha italiana, pepperoni, jamón serrano, aceitunas y queso mozarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 108.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(224, 'Strombo Argentino', 'Chorizo argentino, pimiento, chimichurri y queso mozzarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 99.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(225, 'Strombo Arrachera', 'Arrachera, pimiento, cebolla morada y queso mozzarella', 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1200&auto=format&fit=crop', 125.00, 'Strombolis', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(226, 'Burrito Clásico Arrachera', 'Arrachera, papa frita, aguacate, lechuga, jitomate, cebolla asada, mezcla de quesos, frijoles refritos, salsa de la casa', 'https://images.unsplash.com/photo-1626700051175-6518c4793fde?q=80&w=1200&auto=format&fit=crop', 155.00, 'Burritos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(227, 'Burrito Pollo', 'Pechuga de pollo marinada, papa frita lechuga, jitomate, aguacate, cebolla asada, tocino, frijoles refritos, mezcla de quesos y aderezo chipotle', 'https://images.unsplash.com/photo-1574784032398-356396e95c1c?q=80&w=1200&auto=format&fit=crop', 145.00, 'Burritos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(228, 'Burrito Texano', 'Arrachera, pimiento rojo, chilli, lechuga, cebolla asada, mezcla de quesos, papa crisscut, frijoles refritos, salsa', 'https://images.unsplash.com/photo-1566740933430-b5e70b06d2d5?q=80&w=1200&auto=format&fit=crop', 160.00, 'Burritos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(229, 'Burrito Carnes Frías', 'Jamón, tocino, salchicha, salchichón, papa crisscut, pimientos, lechuga, jitomate, cebolla asada, mezcla de quesos, frijoles refritos, salsa', 'https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?q=80&w=1200&auto=format&fit=crop', 145.00, 'Burritos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(230, 'Burrito Canival', 'Arrachera, chistorra, chorizo argentino, tocino, salchichón, papa frita, jitomate, cebolla asada, mezcla de quesos, frijoles refritos, salsa', 'https://images.unsplash.com/photo-1601924582970-9238bcb495d9?q=80&w=1200&auto=format&fit=crop', 165.00, 'Burritos', '', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(231, 'Ensalada de frutos rojos', 'Fresa, manzana, arándano, lechuga, espinaca y aderezo', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 80.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(232, 'Ensalada de frutos rojos con Pollo', 'Con pollo a la plancha', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 109.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(233, 'Ensalada de frutos rojos con Arrachera', 'Con arrachera', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1200&auto=format&fit=crop', 145.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(234, 'Ensalada César', 'Lechuga, crotones, aderezo y parmesano', 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?q=80&w=1200&auto=format&fit=crop', 70.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(235, 'Ensalada César con Pollo', 'Con pollo a la plancha', 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?q=80&w=1200&auto=format&fit=crop', 99.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(236, 'Ensalada César con Arrachera', 'Con arrachera', 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?q=80&w=1200&auto=format&fit=crop', 135.00, 'Opción Fit', 'Ensaladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(237, 'Malteada de moka', '', 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=1200&auto=format&fit=crop', 72.00, 'Postres', 'Malteadas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(238, 'Malteada de vainilla', '', 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=1200&auto=format&fit=crop', 72.00, 'Postres', 'Malteadas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(239, 'Malteada de chocolate', '', 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=1200&auto=format&fit=crop', 72.00, 'Postres', 'Malteadas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(240, 'Malteada de fresa', '', 'https://images.unsplash.com/photo-1579954115545-a95591f28bfc?q=80&w=1200&auto=format&fit=crop', 72.00, 'Postres', 'Malteadas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(241, 'Cheesecake frutos rojos', NULL, 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?q=80&w=1200&auto=format&fit=crop', 79.00, 'Postres', 'Pasteles', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(242, 'Cheesecake oreo', NULL, 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?q=80&w=1200&auto=format&fit=crop', 79.00, 'Postres', 'Pasteles', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(243, 'Oreo fries + helado de vainilla', '', 'https://images.unsplash.com/photo-1551024601-bec78aea704b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Postres', 'Especiales', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(244, 'Café americano', NULL, 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1200&auto=format&fit=crop', 55.00, 'Postres', 'Cafetería', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(245, 'Chocolate Caliente', NULL, 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1200&auto=format&fit=crop', 55.00, 'Postres', 'Cafetería', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(246, 'Agua de limón', NULL, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 38.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(247, 'Agua de Jamaica', NULL, 'https://images.unsplash.com/photo-1497534446932-c925b458314e?q=80&w=1200&auto=format&fit=crop', 38.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(248, 'Limonada', NULL, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 52.00, 'Bebidas sin Alcohol', 'Aguas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(249, 'Agua embotellada 600ml', NULL, 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 25.00, 'Bebidas sin Alcohol', 'Embotelladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(250, 'Coca Cola 600ml', NULL, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(251, 'Coca Cola vidrio', NULL, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(252, 'Refrescos y jugos', NULL, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(253, 'Escuis de vidrio', NULL, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?q=80&w=1200&auto=format&fit=crop', 35.00, 'Bebidas sin Alcohol', 'Refrescos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(254, 'Cerveza Corona', NULL, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(255, 'Cerveza Victoria', NULL, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(256, 'Cerveza Ultra', NULL, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 40.00, 'Cervezas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(257, 'Preparado de michelada', NULL, 'https://images.unsplash.com/photo-1532634922-8fe0b757fb13?q=80&w=1200&auto=format&fit=crop', 30.00, 'Cervezas', 'Micheladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(258, 'Michelada de litro', NULL, 'https://images.unsplash.com/photo-1532634922-8fe0b757fb13?q=80&w=1200&auto=format&fit=crop', 110.00, 'Cervezas', 'Micheladas', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(259, 'Cubeta de 6 cervezas', NULL, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 200.00, 'Cervezas', 'Promociones', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(260, 'Cerveza cero', NULL, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?q=80&w=1200&auto=format&fit=crop', 35.00, 'Cervezas', NULL, 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(261, 'Malibú', 'Ron malibú, jugo de piña, jugo de arándano y hielo', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(262, 'Piña colada', 'Ron, licor de coco, crema de coco y jugo de piña', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(263, 'Blue hawaiian', 'Ron, malibú, azul de curazao y toques citricos', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(264, 'Quemadita', 'Ron, agua mineral, coca cola y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(265, 'Mojito Cubano', 'Ron, limon, hierbabuena, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(266, 'Mojito de Coco', 'Ron, crema de coco, hierbabuena, y toque de limón', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(267, 'Mojito Frutos rojos', 'Ron, frutos rojos, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 89.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(268, 'Mojito de Maracuyá', 'Ron, Maracuya, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 89.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(269, 'Mojito de Mango', 'Ron, mango, hierbabuena, limón, endulzante y agua mineral', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(270, 'Azulito', 'Vodka, mora azul, curazao y refresco de lima', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 55.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(271, 'Pantera Rosa', 'Vodka, piña, granadina y leche condensada', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(272, 'Moscow Mule', 'Vodka, limón, sirope de gengibre, hierbabuena y ginger', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 88.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(273, 'Limonada Electrica', 'Vodka, limon, agua mineral y mora azul', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(274, 'Mango deck', 'Vodka, Mango, endulzante y chamoy', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 82.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(275, 'Caipiroska', 'Vodka, limon, sirope y hielo triturado', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 70.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(276, 'Long island blue', 'Vodka, ron, ginebra, tequila, curazao, limón y mora azul', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 90.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(277, 'Beso de fresa', 'Vodka, granadina, jugo de arándano, soda de lima y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(278, 'Margarita', 'Tequila, licor de naranja, miel de agave y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(279, 'Margarita de Fresa', 'Tequila, licor de naranja, miel de agave y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(280, 'Margarita Lavanda', 'Tequila, licor de naranja, sirope de lavanda, jugo de limón y crema de coco', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(281, 'Margarita Dragón', 'Tequila, licor de naranja, sirope de fruta dragón y jugo de limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(282, 'Tequila Sunrise', 'Tequila, jugo de naranja, granadina', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(283, 'Vampiro', 'Tequila, limón, toronja, sangrita y tajin', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 77.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(284, 'Cantarito', 'Tequila, jugo de naranja, refresco de toronja, jugo de limón y fruta citrica', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(285, 'Paloma Dragón', 'Tequila, jugo de limon, toronja y sirope de fruta dragón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(286, 'Mezcamaica', 'Mezcal, concentrado de jamaica, hierbabuena, sirope y agua mineral', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(287, 'Mezcandia', 'Mezcal, sandía, sirope y agua mineral', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(288, 'Mezcalita de Limón', 'Mezcal, licor de naranja, miel de agave y limón', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(289, 'Mezcalita de Fresa', 'Mecal, licor de naranja, miel de agave y fresa', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(290, 'Mezcalita de Maracuyá', 'Mezcal, licor de naranja, miel de agave y maracuyá', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(291, 'Mezcalita de Tamarindo', 'Mezcal, licor de naranja, miel de agave y tamarindo', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 80.00, 'Coctelería', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(292, 'Gin Pepino Limón', 'Vodka, mora azul, curazao y refresco de lima', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 95.00, 'Coctelería', 'Ginebra', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(293, 'Gin Frutos Rojos', 'Ginebra, agua tónica y frutos rojos', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 95.00, 'Coctelería', 'Ginebra', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(294, 'Bruma', 'Ginebra, pulpa de guanabana, toque de albahaca y agua mineralizada', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 90.00, 'Coctelería', 'Ginebra', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(295, 'Café Irlandés', 'Café, endulzante, licor de 43 chocolate y baileys', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Digestivos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(296, 'Carajillo', 'Café, endulzante y licor del 43', 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200&auto=format&fit=crop', 85.00, 'Coctelería', 'Digestivos', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(297, 'José cuervo especial blanco 1L (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 770.00, 'Destilados', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(298, 'José cuervo tradicional 1L (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 930.00, 'Destilados', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(299, 'José cuervo tradicional cristalino (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1100.00, 'Destilados', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(300, 'Maestro dobel diamante 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1300.00, 'Destilados', 'Tequila', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(301, 'Captain Morgan 750ML (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 620.00, 'Destilados', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(302, 'Bacardí blanco 750ML (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 600.00, 'Destilados', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(303, 'Bacardi de mango-chile 750ML (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Ron', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(304, 'Torres 5 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Brandy', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(305, 'Torres 10 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 850.00, 'Destilados', 'Brandy', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(306, 'Smirnoff 1L (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 780.00, 'Destilados', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(307, 'Smirnoff Tamarindo 1L (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 870.00, 'Destilados', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(308, 'Absolut Azul 750ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 875.00, 'Destilados', 'Vodka', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(309, 'Black & White 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 650.00, 'Destilados', 'Whisky', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(310, 'Jack Daniel\'s 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1000.00, 'Destilados', 'Whisky', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(311, 'Buchanans 12 750ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1500.00, 'Destilados', 'Whisky', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(312, 'Fandango Espadin Joven 750 ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 700.00, 'Destilados', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(313, '400 Conejos Joven 700ml (Botella)', 'Cada botella incluye 3 servicios o un jugo de litro', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 1100.00, 'Destilados', 'Mezcal', 1, '2026-03-11 21:37:10', '2026-07-08 08:54:18', 0, 10),
(314, 'José cuervo especial blanco 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(315, 'José cuervo tradicional 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(316, 'José cuervo tradicional cristalino 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 110.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(317, 'Maestro dobel diamante 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 130.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(318, 'Captain Morgan 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(319, 'Bacardí blanco 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(320, 'Bacardi de mango-chile 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 80.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(321, 'Torres 5 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(322, 'Torres 10 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 95.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(323, 'Smirnoff 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(324, 'Smirnoff Tamarindo 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(325, 'Absolut Azul 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 85.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(326, 'Black & White 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(327, 'Jack Daniel\'s 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 120.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(328, 'Buchanans 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 135.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(329, 'Fandango Espadin Joven 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 75.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(330, '400 Conejos Joven 1.5oz', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 120.00, 'Destilados', 'Copeo', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(331, '6 Shots José cuervo especial blanco', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 250.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(332, '6 Shots José cuervo tradicional', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(333, '6 Shots José cuervo TRADICION cristalino', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 390.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(334, '6 Shots Bacardi mango chile', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(335, '6 Shots Smirnoff tamarindo', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 280.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(336, '6 Shots Mezcal fandango', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 300.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(337, '6 Shots Perlas negras', NULL, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?q=80&w=1200&auto=format&fit=crop', 350.00, 'Destilados', 'Shots', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(338, 'Jugos de litro', '', 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 70.00, 'Bebidas sin Alcohol', 'Extras', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10),
(339, 'Mineral topochico 600ml', NULL, 'https://images.unsplash.com/photo-1527061011665-3652c757a4d4?q=80&w=1200&auto=format&fit=crop', 40.00, 'Bebidas sin Alcohol', 'Extras', 1, '2026-03-11 21:37:10', '2026-07-08 09:02:11', 0, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL COMMENT 'Ruta de la imagen promocional',
  `tag` varchar(50) DEFAULT NULL,
  `price_text` varchar(50) NOT NULL,
  `icon` varchar(20) DEFAULT NULL,
  `color_gradient` varchar(255) DEFAULT 'from-green-600 to-green-900',
  `end_date` date DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `promotions`
--

INSERT INTO `promotions` (`id`, `title`, `description`, `image`, `tag`, `price_text`, `icon`, `color_gradient`, `end_date`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Jueves de Alitas', 'Compra una orden de 12 alitas y la segunda te sale a mitad de precio. ¡Elige tus salsas favoritas!', NULL, '¡Solo Jueves!', '2x$150', '?', 'from-green-600 to-green-900', NULL, 1, '2026-03-01 17:51:52', '2026-03-02 00:46:14'),
(2, 'Combo Familiar', '4 Hamburguesas clásicas + 2 órdenes de papas grandes + 1 refresco de 2 litros por un precio increíble.', '', 'Todo el día', '$549', '?', 'from-orange-500 to-red-700', NULL, 1, '2026-03-01 17:51:52', '2026-03-06 18:09:15'),
(3, 'Tu Postre Gratis', 'Visítanos el día de tu cumpleaños, presenta tu identificación y el postre va por nuestra cuenta.', NULL, '¡Felicidades!', 'GRATIS', '?', 'from-purple-600 to-indigo-900', NULL, 1, '2026-03-01 17:51:52', '2026-03-02 00:45:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `fecha_reservacion` date NOT NULL,
  `hora_reservacion` time NOT NULL,
  `cantidad_personas` int(11) NOT NULL,
  `zona` varchar(255) NOT NULL,
  `status` enum('pendiente','confirmada','cancelada','finalizada') DEFAULT 'pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `nombre_completo`, `telefono`, `correo_electronico`, `fecha_reservacion`, `hora_reservacion`, `cantidad_personas`, `zona`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Luis Angel', '7713497438', 'luis.angelhdez1811@gmail.com', '2026-03-26', '13:00:00', 8, 'General', 'finalizada', '2026-03-26 10:20:09', '2026-03-31 18:13:36'),
(3, 'Alan', '7712994676', 'Alan.angelhdez1811@gmail.com', '2026-03-26', '14:00:00', 1, 'General', 'finalizada', '2026-03-26 10:21:11', '2026-03-31 18:13:36'),
(4, 'asdasd', '7713497438', 'mr.dimanh758@gmail.com', '2026-03-31', '14:30:00', 3, 'General', 'cancelada', '2026-03-26 11:27:36', '2026-03-26 11:27:36'),
(5, 'asdasd', '7713497438', 'luis.angelhdez1811@gmail.com', '2026-03-27', '13:15:00', 3, 'Terraza', 'finalizada', '2026-03-26 12:15:53', '2026-03-31 18:13:36'),
(6, 'asdasd', '7713497433', 'luis.angelhdez1811@gmail.com', '2026-03-27', '14:20:00', 5, 'Terraza', 'finalizada', '2026-03-26 23:20:04', '2026-03-31 18:13:36'),
(7, 'Asd', '771 349 7438', '20230034@uthh.edu.mx', '2026-03-31', '18:54:00', 7, 'Terraza', 'cancelada', '2026-03-31 18:39:24', '2026-03-31 19:23:11'),
(8, 'Asd', '771 349 7438', '20230034@uthh.edu.mx', '2026-03-31', '20:48:00', 1, 'General', 'finalizada', '2026-03-31 18:49:01', '2026-04-01 14:45:02'),
(9, 'Asd', '771 349 7438', '20230034@uthh.edu.mx', '2026-03-31', '20:49:00', 1, 'General', 'finalizada', '2026-03-31 18:49:26', '2026-04-01 14:45:02'),
(10, 'Asd', '771 349 7438', 'luis.angelhdez1811@gmail.com', '2026-03-31', '21:49:00', 1, 'General', 'cancelada', '2026-03-31 18:49:49', '2026-03-31 19:23:19'),
(11, 'Asd', '771 349 7438', 'luis.angelhdez1811@gmail.com', '2026-03-31', '20:08:00', 1, 'General', 'finalizada', '2026-03-31 19:08:35', '2026-04-01 14:45:02'),
(12, 'Asd', '771 349 7438', '20230034@uthh.edu.mx', '2026-03-31', '20:09:00', 1, 'General', 'finalizada', '2026-03-31 19:09:07', '2026-04-01 14:45:02'),
(13, 'asdasd', '7712457018', 'luis.angelhdez1811@gmail.com', '2026-04-29', '18:43:00', 9, 'General', 'finalizada', '2026-04-01 14:43:24', '2026-06-07 19:52:16'),
(14, 'alan', '7712994676', 'alanjahir305@gmail.com', '2026-07-05', '13:30:00', 4, 'Terraza', 'finalizada', '2026-07-03 14:23:19', '2026-07-06 13:30:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3cpbHNHG1G3SoEskx6yunHaIaBpUEGokXIA71yHr', NULL, '2a02:4780:2b:1877:0:2bc6:9ef0:1', 'curl/7.76.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMURjRWFRZ1UzRjZIdHVqb3UwcHVab1o3ZVNsWHBaTnBsSUNSa1E4ViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzQ6Imh0dHBzOi8vdGFuLW9rYXBpLTU5NTEzOS5ob3N0aW5nZXJzaXRlLmNvbS9ydW4tYXV0by1iYWNrdXA/dGltZT0xNzc0NDc1ODIxIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774475821),
('a4XCmFEgC5b5Avaz0X7YEm5ps6qapaDXrJTuZ9kF', NULL, '2a02:4780:2b:1877:0:2bc6:9ef0:1', 'curl/7.76.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3lnTVBGVURnQ1gxVHpxSzNSUG9zQWRjbUR5SFZGS2Q1NkhFazdTViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzQ6Imh0dHBzOi8vdGFuLW9rYXBpLTU5NTEzOS5ob3N0aW5nZXJzaXRlLmNvbS9ydW4tYXV0by1iYWNrdXA/dGltZT0xNzc0NDc1NzYxIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774475761),
('HlYKOoTEE5LiwOg2yhP47Y6KpQwCds4E6YP4Bc5v', NULL, '2a02:4780:2b:1877:0:2bc6:9ef0:1', 'curl/7.76.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTk93T3k3SGQ5NUF0QzVsSndqM2c3SGxMZkhzOHN0MEVMcVh3Nzg0RiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzQ6Imh0dHBzOi8vdGFuLW9rYXBpLTU5NTEzOS5ob3N0aW5nZXJzaXRlLmNvbS9ydW4tYXV0by1iYWNrdXA/dGltZT0xNzc0NDc1ODgxIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774475881);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL COMMENT 'Nombre de la configuracion (ej. logo, direccion)',
  `value` text DEFAULT NULL COMMENT 'El valor guardado',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'logo', 'https://res.cloudinary.com/decigylbc/image/upload/v1783430563/zpt5cdpcslnhjmvdax8q.png', NULL, '2026-07-07 07:22:44'),
(2, 'map_url', 'https://maps.google.com/maps?q=La%20501%20Centro&output=embed', NULL, '2026-03-01 22:41:19'),
(3, 'address_line1', 'Av. Deportiva #501', NULL, NULL),
(4, 'address_line2', 'Col. Centro', NULL, NULL),
(5, 'address_line3', 'CP 43000, Huejutla de Reyes, Hgo.', NULL, '2026-03-01 22:42:52'),
(6, 'schedule_domingo', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(7, 'schedule_lunes', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(8, 'schedule_martes', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(9, 'schedule_miercoles', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(10, 'schedule_jueves', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(11, 'schedule_viernes', '13:00 PM – 10:30 PM', NULL, '2026-03-08 00:31:13'),
(12, 'schedule_sabado', '13:00 PM – 10:30 PM', NULL, '2026-07-07 07:24:47'),
(13, 'backup_enabled', '1', '2026-03-18 11:53:23', '2026-03-19 16:38:39'),
(14, 'backup_frecuencia', 'intervalo', '2026-03-18 11:53:23', '2026-03-26 22:53:55'),
(15, 'backup_hora', '03:00', '2026-03-18 11:53:23', '2026-03-18 11:53:23'),
(16, 'backup_intervalo', '60', '2026-03-18 11:53:23', '2026-03-26 23:03:07'),
(17, 'backup_delete_old', '1', '2026-03-18 11:53:23', '2026-03-18 11:53:23'),
(2117, 'business_name', 'La 501 Sports', '2026-06-15 02:03:01', '2026-06-15 02:03:01'),
(2118, 'about_us', 'Somos un restaurante y sports bar donde la pasión por el deporte y la buena comida se unen para crear momentos inolvidables.', '2026-06-15 02:03:01', '2026-06-15 02:03:01'),
(2680, 'backup_last_run', '2026-07-08 08:25:03', '2026-07-08 08:25:03', '2026-07-08 08:25:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('income','expense') NOT NULL COMMENT 'income = ingreso, expense = gasto',
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`id`, `type`, `category`, `amount`, `description`, `transaction_date`, `created_at`, `updated_at`) VALUES
(1, 'income', 'Ventas en Local', 4500.00, 'Ventas del turno matutino', '2026-03-01', '2026-03-01 20:28:25', '2026-03-01 20:28:25'),
(2, 'expense', 'Proveedores', 1200.50, 'Pago a proveedor de carne fresca', '2026-03-01', '2026-03-01 20:28:25', '2026-03-01 20:28:25'),
(3, 'expense', 'Servicios', 500.00, 'Pago de recibo de internet', '2026-02-28', '2026-03-01 20:28:25', '2026-03-01 20:28:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0 COMMENT 'Puntos de lealtad',
  `pregunta_secreta` varchar(255) DEFAULT NULL,
  `respuesta_secreta` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT 'cliente',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `direccion_favorita` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `telefono`, `password`, `points`, `pregunta_secreta`, `respuesta_secreta`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`, `direccion_favorita`) VALUES
(1, 'Angel Hernandez', 'mr.dimanh758@gmail.com', 'avatars/av_1780286492_1.png', '7713497438', '$2y$12$eFbvCNbbm6vTeBG7ELLDquZGKjyTTXnoc5VtKpoSaJvcJBkm3xy0u', 535, '¿Cuál es tu platillo favorito de La 501?', '$2y$12$N1w9SHl8AENpm9CDcB/Xi.a5yA/gS9X7FeOi0pooHVHwnJ3yBI9zm', 'cliente', 1, NULL, '2026-03-01 02:10:09', '2026-06-30 12:10:44', NULL),
(2, 'Luis Angel Hernandez Hernandez', 'luis.angelhdez1811@gmail.com', 'avatars/av_1783020910_2.jpg', '7712457018', '$2y$12$UiYUo2iNlyb6F13MSKPax.zem8BYeVQEczYLa5dUXrt2bi9nKg7yO', 0, '¿Cuál es el nombre de tu primera mascota?', '$2y$12$hvL0t/w258DtkVktLz3O1eY4ehOKX6Sr1fFQ48zuDnbey/AXyrH6a', 'admin', 1, NULL, '2026-03-01 02:13:34', '2026-07-02 13:35:10', NULL),
(9, 'Luis Angel Hernandez Hernandez', 'angelhdez1811@gmail.com', NULL, '7713497438', '$2y$12$P2ltjDPCKr65OEtKefKa8O3SEVHeCQQEkPgKXx1wwPhawvZIFaITq', 0, NULL, NULL, 'empleado', 1, NULL, '2026-03-03 17:12:59', '2026-03-18 14:52:39', NULL),
(10, 'Luis Angel Hernandez Hernandez', 'luis@gmail.com', NULL, '7712457018', '$2y$12$4KfJQjvKjKwcBOCi5N6s1O8w7W/fK4faDWlLq5.stzQgxq7ek.K1m', 0, NULL, NULL, 'admin', 1, NULL, '2026-03-03 17:46:31', '2026-03-04 16:38:53', NULL),
(14, 'Alan Bochi', 'alanjahir305@gmail.com', NULL, '7712994676', '$2y$12$SvESP5MwV3iRKNwkTvArb.t9YzsJ6SWWgsKTk3RlLTdBLPkQcUXeG', 0, NULL, NULL, 'cocinero', 1, NULL, '2026-06-30 09:29:47', '2026-06-30 09:29:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_achievements`
--

CREATE TABLE `user_achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `achievement_id` bigint(20) UNSIGNED NOT NULL,
  `unlocked_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_achievements`
--

INSERT INTO `user_achievements` (`id`, `user_id`, `achievement_id`, `unlocked_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2026-04-01 14:41:33', '2026-04-01 14:41:33', '2026-04-01 14:41:33'),
(2, 1, 2, '2026-04-01 14:41:33', '2026-04-01 14:41:33', '2026-04-01 14:41:33'),
(3, 1, 3, '2026-04-01 14:41:33', '2026-04-01 14:41:33', '2026-04-01 14:41:33'),
(4, 1, 9, '2026-04-01 14:41:33', '2026-04-01 14:41:33', '2026-04-01 14:41:33'),
(5, 1, 20, '2026-04-01 14:41:33', '2026-04-01 14:41:33', '2026-04-01 14:41:33'),
(6, 2, 1, '2026-04-01 14:45:06', '2026-04-01 14:45:06', '2026-04-01 14:45:06'),
(7, 2, 6, '2026-04-01 14:45:06', '2026-04-01 14:45:06', '2026-04-01 14:45:06'),
(8, 2, 7, '2026-04-01 14:45:06', '2026-04-01 14:45:06', '2026-04-01 14:45:06'),
(9, 2, 9, '2026-04-01 14:45:06', '2026-04-01 14:45:06', '2026-04-01 14:45:06'),
(10, 2, 19, '2026-04-01 14:45:06', '2026-04-01 14:45:06', '2026-04-01 14:45:06'),
(11, 9, 1, '2026-04-01 15:52:07', '2026-04-01 15:52:07', '2026-04-01 15:52:07'),
(12, 9, 2, '2026-04-01 15:52:07', '2026-04-01 15:52:07', '2026-04-01 15:52:07'),
(13, 9, 3, '2026-04-01 15:52:07', '2026-04-01 15:52:07', '2026-04-01 15:52:07'),
(14, 9, 9, '2026-04-09 12:09:02', '2026-04-09 12:09:02', '2026-04-09 12:09:02'),
(15, 1, 10, '2026-06-30 12:08:10', '2026-06-30 12:08:10', '2026-06-30 12:08:10'),
(16, 2, 2, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(17, 2, 3, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(18, 2, 4, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(19, 2, 5, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(20, 2, 10, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(21, 2, 14, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(22, 2, 15, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(23, 2, 17, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(24, 2, 18, '2026-06-30 12:16:37', '2026-06-30 12:16:37', '2026-06-30 12:16:37'),
(25, 9, 4, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(26, 9, 5, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(27, 9, 10, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(28, 9, 14, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(29, 9, 15, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(30, 9, 17, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58'),
(31, 9, 18, '2026-06-30 12:58:58', '2026-06-30 12:58:58', '2026-06-30 12:58:58');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_ventas_diarias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_ventas_diarias` (
`fecha` date
,`total_pedidos` bigint(21)
,`ingresos_totales` decimal(32,2)
);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `carousel_slides`
--
ALTER TABLE `carousel_slides`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_ingrediente` (`product_id`),
  ADD KEY `ingredientes_inventory_id_foreign` (`inventory_id`);

--
-- Indices de la tabla `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_status_created_at` (`status`,`created_at`),
  ADD KEY `idx_orders_user_id` (`user_id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order_id` (`order_id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_products_available_category` (`available`,`category`);

--
-- Indices de la tabla `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_transactions_type_date` (`type`,`transaction_date`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_achievement` (`user_id`,`achievement_id`),
  ADD KEY `fk_user_achievements_achievement` (`achievement_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `carousel_slides`
--
ALTER TABLE `carousel_slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;

--
-- AUTO_INCREMENT de la tabla `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8039;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=628;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=341;

--
-- AUTO_INCREMENT de la tabla `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2681;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_ventas_diarias`
--
DROP TABLE IF EXISTS `v_ventas_diarias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u660523345_501Centro`@`%` SQL SECURITY DEFINER VIEW `v_ventas_diarias`  AS SELECT cast(`orders`.`created_at` as date) AS `fecha`, count(`orders`.`id`) AS `total_pedidos`, sum(`orders`.`total`) AS `ingresos_totales` FROM `orders` WHERE `orders`.`status` in ('paid','delivered','entregado') GROUP BY cast(`orders`.`created_at` as date) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD CONSTRAINT `fk_product_ingrediente` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ingredientes_inventory_id_foreign` FOREIGN KEY (`inventory_id`) REFERENCES `inventories` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `fk_user_achievements_achievement` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_achievements_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
