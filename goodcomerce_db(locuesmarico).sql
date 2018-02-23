-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2018 a las 14:04:42
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `goodcomerce_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api_key`
--

CREATE TABLE `api_key` (
  `id` int(11) NOT NULL,
  `key_api` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `status` enum('En solicitud','Esperando confirmación','Rechazada','Confirmación caducada','En desarrollo','Activa','Caída','Vencida','Pausada') COLLATE utf8_spanish_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `api_key`
--

INSERT INTO `api_key` (`id`, `key_api`, `status`, `user_id`) VALUES
(14, '$2y$10$b3AcmsGbpr3VllfsVH/CTebFgf24L7QA5lfjmz./MJfH92MCu8hTy', 'Activa', 21),
(15, '$2y$10$2f9asJzuzWz.DxZTtqMlh.dpdABi9/Mzm1Mv42/vqZKZXWrONTVMm', 'En solicitud', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `consumer_key` text COLLATE utf8_spanish_ci NOT NULL,
  `consumer_secret` text COLLATE utf8_spanish_ci NOT NULL,
  `appname` text COLLATE utf8_spanish_ci NOT NULL,
  `paypal_client_id` text COLLATE utf8_spanish_ci NOT NULL,
  `paypal_secret` text COLLATE utf8_spanish_ci NOT NULL,
  `paypal_email` text COLLATE utf8_spanish_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`id`, `url`, `consumer_key`, `consumer_secret`, `appname`, `paypal_client_id`, `paypal_secret`, `paypal_email`, `user_id`) VALUES
(1, 'http://localhost/Wordpress', 'ck_200333df152511eb639c4f2765f6960356e8fcda', 'cs_5c9df53e2e00518de5895ae0a142caf0a5f545d0', 'Mi Tienda Favorita', 'Ab1syOjBxeKi3lfjHlWPzo8py1VuLKplzvwkNeCry0E4zm9trP5TfSoIt-R2ySbY_nG7ugK3vzb3tvHC', 'ELCBKPMYHnpPBS4AMYQRmlVOWe7H0FV-2KGWKNwvouy7qCmMSiJWvTlLhv5gC1dORlJJRzvo8x0CAq__', 'j.urbina.0176-facilitator@gmail.com', 21),
(2, 'http://localhost/Wordpress', 'dfujytgrfdujyhtgrthrgterfikujhytg', 'fgjhgfdsafikujhytfgrdfg', 'acortador', '', '', '', 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `customer` text NOT NULL,
  `username` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`id`, `customer`, `username`) VALUES
(4, '15', 'Angel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payer_email` text NOT NULL,
  `receiver_email` text NOT NULL,
  `total` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `payments`
--

INSERT INTO `payments` (`id`, `payer_email`, `receiver_email`, `total`) VALUES
(7, '{\"mc_gross\":\"5.00\",\"protection_eligibility\":\"Eligible\",\"address_status\":\"confirmed\",\"item_number1\":\"\",\"payer_id\":\"R2B3ZKGZHWW8C\",\"address_street\":\"1 Main St\",\"payment_date\":\"17:25:41 Feb 22, 2018 PST\",\"payment_status\":\"Completed\",\"charset\":\"windows-1252\",\"address_zip\":\"95131\",\"first_name\":\"test\",\"mc_fee\":\"0.45\",\"address_country_code\":\"US\",\"address_name\":\"test buyer\",\"notify_version\":\"3.9\",\"custom\":\"\",\"payer_status\":\"verified\",\"business\":\"j.urbina.0176-facilitator@gmail.com\",\"address_country\":\"United States\",\"num_cart_items\":\"1\",\"address_city\":\"San Jose\",\"verify_sign\":\"A2S1fniRGsoquzRDbs4f5rc383f8ALoKVG39dpx3aDPSMNcFsjqCxitj\",\"payer_email\":\"j.urbina.0176-buyer@gmail.com\",\"txn_id\":\"7XN14246S3230411Y\",\"payment_type\":\"instant\",\"last_name\":\"buyer\",\"item_name1\":\"Otra Camisa\",\"address_state\":\"CA\",\"receiver_email\":\"j.urbina.0176-facilitator@gmail.com\",\"payment_fee\":\"0.45\",\"quantity1\":\"1\",\"receiver_id\":\"X2GE9BN7AFALU\",\"txn_type\":\"cart\",\"mc_gross_1\":\"5.00\",\"mc_currency\":\"USD\",\"residence_country\":\"US\",\"test_ipn\":\"1\",\"transaction_subject\":\"\",\"payment_gross\":\"5.00\",\"ipn_track_id\":\"93f3fbb8da414\"}', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `phinxlog`
--

CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `phinxlog`
--

INSERT INTO `phinxlog` (`version`, `migration_name`, `start_time`, `end_time`, `breakpoint`) VALUES
(20180214091232, 'CreateUsers', '2018-02-14 12:43:46', '2018-02-14 12:43:46', 0),
(20180214092722, 'CreateProfile', '2018-02-14 12:43:47', '2018-02-14 12:43:47', 0),
(20180214134255, 'CreateApiKey', '2018-02-14 12:43:47', '2018-02-14 12:43:48', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `state` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `number_phone` int(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`id`, `name`, `last_name`, `country`, `city`, `state`, `email`, `photo`, `number_phone`, `user_id`) VALUES
(11, 'Angelito', 'Gonzalez', 'Venezuela', 'Guayana', 'Bolivar', 'angelangelangel91@hotmail.com', 'img/user.jpg', 2147483647, 21),
(12, 'Jose', 'urbina', 'venezuela', 'Guayana', 'Bolivar', 'j.urbina.0179@gmail.com', 'img/users/cFsgHRhlz8.png', 2, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `role` enum('admin','user','','') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(21, 'angel', '$2y$10$XGGMM1e.GX0o2kOQfsGkFOtJn4rHiNvy08ZGDluoZJFUb5oKnSXNm', 'admin'),
(22, 'valdemaro', '$2y$10$uiX6puyFWExlXgGlKrStUeO97ivWGpdyLbg9OrZLPgA3XuuRDzche', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `api_key`
--
ALTER TABLE `api_key`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_EMAIL` (`email`),
  ADD UNIQUE KEY `UNIQUE_NUMBER_PHONE` (`number_phone`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `api_key`
--
ALTER TABLE `api_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `api_key`
--
ALTER TABLE `api_key`
  ADD CONSTRAINT `api_key_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `config`
--
ALTER TABLE `config`
  ADD CONSTRAINT `config_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
