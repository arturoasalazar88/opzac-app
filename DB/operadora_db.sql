-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-03-2019 a las 00:21:49
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `operadora_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `address` text COLLATE utf8mb4_unicode_ci,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `address`, `owner`, `created_at`, `updated_at`) VALUES
(1, 'Operadora', 'Operadora Zacatecas', 'Zacatecas, centro', 'Fulanito detal', NULL, NULL),
(2, 'Maxibus', 'Maxibus Zacatecas', 'Zacatecas, centro', 'Fulanita detal', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departures`
--

CREATE TABLE `departures` (
  `id` int(10) UNSIGNED NOT NULL,
  `tour_id` int(10) UNSIGNED NOT NULL,
  `horario` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `departures`
--

INSERT INTO `departures` (`id`, `tour_id`, `horario`, `created_at`, `updated_at`) VALUES
(1, 1, '10:00:00', NULL, NULL),
(2, 1, '12:00:00', NULL, NULL),
(3, 2, '17:30:00', NULL, NULL),
(4, 2, '14:25:00', NULL, NULL),
(5, 3, '10:00:00', NULL, NULL),
(6, 4, '19:45:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hotels`
--

CREATE TABLE `hotels` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '--',
  `zone_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `hotels`
--

INSERT INTO `hotels` (`id`, `name`, `key`, `zone_id`, `created_at`, `updated_at`) VALUES
(1, 'Operadora', 'OP', 1, NULL, NULL),
(2, 'Maxibus', 'MX', 1, NULL, NULL),
(3, 'Casa Real', 'CR', 2, NULL, NULL),
(4, 'Plaza', 'PL', 2, NULL, NULL),
(5, 'Don Miguel', 'DM', 2, NULL, NULL),
(6, 'Zacatecas Courts', 'ZC', 2, NULL, NULL),
(7, 'Colon', 'CL', 2, NULL, NULL),
(8, 'Arroyo de la PLata', 'AP', 2, NULL, NULL),
(9, 'Campanario', 'CP', 2, NULL, NULL),
(10, 'María Benita', 'MB', 2, NULL, NULL),
(11, 'María Conchita', 'MC', 2, NULL, NULL),
(12, 'Reyna Soledad', 'RS', 4, NULL, NULL),
(13, 'Casa Torres', 'CT', 4, NULL, NULL),
(14, 'Casa Cortés', 'CC', 4, NULL, NULL),
(15, 'Argento Inn', 'AI', 4, NULL, NULL),
(16, 'Posada de la Moneda', 'PM', 4, NULL, NULL),
(17, 'Santa Rita', 'SR', 4, NULL, NULL),
(18, 'Emporio', 'EP', 4, NULL, NULL),
(19, 'Santa Lucía', 'SL', 4, NULL, NULL),
(20, 'Santo Domingo', 'SM', 4, NULL, NULL),
(21, 'Hostal del Carmen', 'HC', 4, NULL, NULL),
(22, 'Hostal Ángeles', 'HA', 4, NULL, NULL),
(23, 'Posada Tolosa', 'PT', 4, NULL, NULL),
(24, 'Finca del Minero', 'FM', 4, NULL, NULL),
(25, 'Terrase', 'TR', 3, NULL, NULL),
(26, 'Hostal del Vasco', 'HV', 3, NULL, NULL),
(27, 'Casa Arechiga', 'CA', 3, NULL, NULL),
(28, 'Casona de los Vitrales', 'CV', 3, NULL, NULL),
(29, 'Mesón de Jobito', 'MJ', 3, NULL, NULL),
(30, 'Mesón de la Merced', 'MM', 3, NULL, NULL),
(31, 'Condesa', 'CO', 3, NULL, NULL),
(32, 'Refugio de Don Carlos', 'RDC', 3, NULL, NULL),
(33, 'Quinta Real', 'QR', 3, NULL, NULL),
(34, 'Alica', 'AL', 3, NULL, NULL),
(35, 'Baruk Teleférico', 'BT', 1, NULL, NULL),
(36, 'Parador', 'PR', 1, NULL, NULL),
(37, 'City Express', 'CE', 1, NULL, NULL),
(38, 'Hampton Inn', 'HI', 1, NULL, NULL),
(39, 'Fiesta Inn', 'FI', 1, NULL, NULL),
(40, 'Hacienda Baruk', 'HB', 1, NULL, NULL),
(41, 'Posada del Carmen', 'PC', 4, NULL, NULL),
(42, 'Posada de los Condes', 'PCD', 4, NULL, NULL),
(43, 'Providencia', 'PV', 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_12_27_005855_create_projects_table', 1),
(4, '2018_12_29_053719_create_tasks_table', 1),
(5, '2019_01_04_002600_create_zones_table', 1),
(6, '2019_01_05_052949_create_hotels_table', 1),
(7, '2019_01_07_041851_create_tours_table', 1),
(8, '2019_01_08_215255_create_reservations_table', 1),
(9, '2019_02_12_230109_create_companies_table', 1),
(10, '2019_02_13_184033_create_roles_table', 1),
(11, '2019_03_15_190958_create_departures_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `client` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `procedence` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `number_kids` int(11) NOT NULL DEFAULT '0',
  `number_adults` int(11) NOT NULL DEFAULT '0',
  `number_elders` int(11) NOT NULL DEFAULT '0',
  `comission_kids` decimal(6,2) NOT NULL DEFAULT '0.00',
  `comission_adults` decimal(6,2) NOT NULL DEFAULT '0.00',
  `comission_elders` decimal(6,2) NOT NULL DEFAULT '0.00',
  `total` decimal(6,2) NOT NULL,
  `total_commission` decimal(6,2) NOT NULL,
  `remaining` decimal(6,2) NOT NULL,
  `actual_pay` decimal(6,2) NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_numbers` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'XXXX',
  `user_id` int(10) UNSIGNED NOT NULL,
  `tour_id` int(10) UNSIGNED DEFAULT NULL,
  `departure_id` int(10) UNSIGNED NOT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL,
  `folio` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id`, `status`, `client`, `client_email`, `telephone`, `procedence`, `room`, `date`, `number_kids`, `number_adults`, `number_elders`, `comission_kids`, `comission_adults`, `comission_elders`, `total`, `total_commission`, `remaining`, `actual_pay`, `payment_method`, `credit_numbers`, `user_id`, `tour_id`, `departure_id`, `hotel_id`, `folio`, `comments`, `created_at`, `updated_at`) VALUES
(1, 0, 'Roberto del Rio', 'roberto@prueba.com', '0123456789', NULL, 101, '2019-03-26', 1, 2, 0, '0.00', '0.00', '0.00', '280.00', '20.00', '180.00', '100.00', 'efectivo', 'XXXX', 1, NULL, 1, 1, 'TEST003FD', NULL, NULL, NULL),
(2, 0, 'María del los Ángeles', 'maria@prueba.com', '0123456789', NULL, 102, '2019-03-26', 2, 2, 0, '0.00', '0.00', '0.00', '360.00', '20.00', '60.00', '300.00', 'efectivo', 'XXXX', 1, NULL, 1, 1, 'TEST003FD', NULL, NULL, NULL),
(3, 0, 'Leonel Migration Busuu', 'leonel@prueba.com', '0123456789', NULL, 202, '2019-03-26', 0, 2, 0, '0.00', '0.00', '0.00', '200.00', '20.00', '0.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 1, 'TEST003FD', NULL, NULL, NULL),
(4, 0, 'Andrea Marte', 'leonel@prueba.com', '0123456789', NULL, 306, '2019-03-26', 0, 2, 2, '0.00', '0.00', '0.00', '340.00', '20.00', '140.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 2, 4, 'TEST003FD', NULL, NULL, NULL),
(5, 0, 'Carlos Raul Mauricio', 'mauricio@prueba.com', '0123456789', NULL, 303, '2019-03-26', 2, 2, 1, '0.00', '0.00', '0.00', '430.00', '20.00', '70.00', '360.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(6, 0, 'Alejandría de Roma', 'alejandria@prueba.com', '0123456789', NULL, 512, '2019-03-26', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(7, 0, 'Roma de Alejandría', 'roma@prueba.com', '0123456789', NULL, 512, '2019-03-26', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 2, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(8, 0, 'Sandy Rubalcaba', 'misandria@prueba.com', '0123456789', NULL, 512, '2019-03-26', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 2, 2, 'TEST003FD', NULL, NULL, NULL),
(9, 0, 'Hay The Johnes', 'haymaker@prueba.com', '0123456789', NULL, 462, '2019-03-26', 2, 2, 0, '0.00', '0.00', '0.00', '160.00', '20.00', '60.00', '100.00', 'efectivo', 'XXXX', 2, NULL, 1, 3, 'TEST003FD', NULL, NULL, NULL),
(10, 0, 'Don Marino', 'marino@prueba.com', '0123456789', NULL, 232, '2019-03-26', 1, 2, 1, '0.00', '0.00', '0.00', '250.00', '35.00', '60.00', '100.00', 'efectivo', 'XXXX', 1, NULL, 1, 4, 'TEST003FD', NULL, NULL, NULL),
(11, 0, 'Rumerio Del Rosario', 'rumero@prueba.com', '0123456789', NULL, 612, '2019-03-26', 1, 2, 1, '0.00', '0.00', '0.00', '250.00', '35.00', '60.00', '100.00', 'efectivo', 'XXXX', 1, NULL, 3, 4, 'TEST003FD', NULL, NULL, NULL),
(12, 0, 'Juan Tenorio', 'juan@prueba.com', '0123456789', NULL, 793, '2019-03-26', 1, 2, 1, '0.00', '0.00', '0.00', '250.00', '35.00', '60.00', '100.00', 'efectivo', 'XXXX', 1, NULL, 1, 5, 'TEST003FD', NULL, NULL, NULL),
(13, 0, 'Genaro Guitierrez', 'genaro@prueba.com', '0123456789', NULL, 777, '2019-03-26', 1, 2, 1, '0.00', '0.00', '0.00', '350.00', '35.00', '60.00', '100.00', 'efectivo', 'XXXX', 2, NULL, 1, 4, 'TEST003FD', NULL, NULL, NULL),
(14, 0, 'Hugo del monte', 'delmonte@prueba.com', '0123456789', NULL, 512, '2019-03-26', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 2, 2, 'TEST003FD', NULL, NULL, NULL),
(15, 0, 'Persona del futuro 1', 'futuro@prueba.com', '0123456789', NULL, 512, '2019-03-27', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(16, 0, 'Persona del futuro 2', 'futuro@prueba.com', '0123456789', NULL, 512, '2019-03-27', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(17, 0, 'Persona del futuro 3', 'futuro@prueba.com', '0123456789', NULL, 512, '2019-03-27', 1, 2, 2, '0.00', '0.00', '0.00', '300.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL),
(18, 0, 'Persona del futuro 4', 'futuro@prueba.com', '0123456789', NULL, 512, '2019-03-27', 1, 2, 2, '0.00', '0.00', '0.00', '250.00', '20.00', '100.00', '200.00', 'efectivo', 'XXXX', 1, NULL, 1, 2, 'TEST003FD', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `administrator` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `type`, `administrator`, `created_at`, `updated_at`) VALUES
(1, 'Operador', 0, NULL, NULL),
(2, 'Recepción', 0, NULL, NULL),
(3, 'Módulo', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tours`
--

CREATE TABLE `tours` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `horario` time DEFAULT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `cost_kids` int(11) NOT NULL DEFAULT '0',
  `cost_adults` int(11) NOT NULL DEFAULT '0',
  `cost_elders` int(11) NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `limit` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `current` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tours`
--

INSERT INTO `tours` (`id`, `company_id`, `name`, `horario`, `owner`, `cost_kids`, `cost_adults`, `cost_elders`, `image`, `limit`, `active`, `description`, `closed`, `current`, `created_at`, `updated_at`) VALUES
(1, 1, 'Zacatecas impresionante', NULL, 'none', 80, 100, 70, 'default.jpg', 55, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2019-03-26', NULL, NULL),
(2, 1, 'Guadalupe tradicional', NULL, 'none', 90, 120, 80, 'default.jpg', 40, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2019-03-26', NULL, NULL),
(3, 2, 'Zacatecas sus ruinas y sus rimas', NULL, 'none', 60, 70, 70, 'default.jpg', 40, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2019-03-26', NULL, NULL),
(4, 2, 'Santuario de plateros y fresnillo', NULL, 'none', 60, 70, 70, 'default.jpg', 40, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2019-03-26', NULL, NULL),
(5, 2, 'Zacatecas industrial y veta grande', NULL, 'none', 60, 70, 70, 'default.jpg', 40, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, '2019-03-26', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `hotel_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `comission_kids` decimal(4,2) NOT NULL DEFAULT '0.00',
  `comission_adults` decimal(4,2) NOT NULL DEFAULT '0.00',
  `comission_elders` decimal(4,2) NOT NULL DEFAULT '0.00',
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `company_id`, `hotel_id`, `name`, `username`, `role_id`, `is_admin`, `comission_kids`, `comission_adults`, `comission_elders`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'José Jaime Rodríguez Hernández', 'James', 1, 1, '5.00', '5.00', '0.00', 'james@gmail.com', NULL, '$2y$10$hqEyMsIJexZ9lKISODezX.kyGXmM91a8Q6CVK5.DdDiz1d20iuZCC', NULL, NULL, NULL),
(2, 1, 1, 'Administrador', 'admin', 1, 1, '0.00', '0.00', '0.00', 'admin@admin.com', NULL, '$2y$10$F8zdoz8ZmVk/OoC3t/4LIeEPt9QD5UpUqze9gJxeokcHLFOdaEdqe', NULL, NULL, NULL),
(3, 2, 2, 'Jon Doe', 'John', 1, 0, '0.00', '0.00', '0.00', 'jon@example.com', NULL, '$2y$10$521gOZWYGKcfQwHvRc.6jOSGslW9cI1IPhRlTBBaHIa3D4wmW6FHW', NULL, NULL, NULL),
(4, 1, 2, 'Jane Doe', 'Jane', 2, 1, '0.00', '0.00', '0.00', 'jane@example.com', NULL, '$2y$10$mmebiqvxYIk0/r1AneQgs.QyNzNbrrjRFpW7J7g6sigNS5PW0jCvK', NULL, NULL, NULL),
(5, 2, 5, 'Pete Doe', 'Pete', 2, 0, '0.00', '0.00', '0.00', 'pete@example.com', NULL, '$2y$10$vn0azV0uynY6lyCaL2MYxeaIh7M7PMZG/NRt7rXESJXq4WedZ9vDi', NULL, NULL, NULL),
(6, 1, 6, 'Peter Parker', 'Pete', 2, 1, '0.00', '0.00', '0.00', 'peter@example.com', NULL, '$2y$10$wAI87a53eHSrw26iSwyXi.0Mf0Na7bwG0dHT5lr0/s4QjRvnUVQg6', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zones`
--

CREATE TABLE `zones` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `zones`
--

INSERT INTO `zones` (`id`, `name`, `number`, `created_at`, `updated_at`) VALUES
(1, 'Zona Sur', '1', NULL, NULL),
(2, 'Zona Norte', '2', NULL, NULL),
(3, 'Zona Este', '3', NULL, NULL),
(4, 'Zona Oeste', '4', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departures`
--
ALTER TABLE `departures`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `departures`
--
ALTER TABLE `departures`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `zones`
--
ALTER TABLE `zones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
