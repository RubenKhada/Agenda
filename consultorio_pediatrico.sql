-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2026 a las 11:43:10
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
-- Base de datos: `consultorio_pediatrico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambios_cita`
--

CREATE TABLE `cambios_cita` (
  `id` int(11) NOT NULL,
  `cita_original_id` int(11) DEFAULT NULL,
  `nueva_fecha_propuesta` datetime DEFAULT NULL,
  `motivo_cambio` text DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `fecha_solicitud` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cambios_cita`
--

INSERT INTO `cambios_cita` (`id`, `cita_original_id`, `nueva_fecha_propuesta`, `motivo_cambio`, `estado`, `fecha_solicitud`) VALUES
(1, 7, '2026-05-10 12:31:00', 'No tendre tiempo', 'rechazado', '2026-04-09 03:07:22'),
(2, 7, '2027-12-31 03:21:00', 'Ya no tengo tiempo de nuevo', 'rechazado', '2026-04-09 03:12:26'),
(3, 5, '2030-12-31 23:01:00', 'Necesito un cambio papu', 'rechazado', '2026-04-09 03:18:42'),
(4, 5, '4000-03-12 01:32:00', 'ola', 'aprobado', '2026-04-09 03:29:36'),
(5, 5, '2133-03-12 21:31:00', 'aaaaaaaaaaaaaaa', 'aprobado', '2026-04-09 03:37:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `fecha_hora` datetime NOT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `estado` enum('pendiente','confirmada','cancelada','completada') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `paciente_id`, `doctor_id`, `fecha_hora`, `motivo_consulta`, `estado`) VALUES
(1, 3, NULL, '2026-04-09 10:00:00', 'Dolor de cabeza', 'completada'),
(2, 1, NULL, '3213-03-12 12:00:00', 'Dolor de cabeza', 'completada'),
(3, 1, NULL, '2026-03-12 17:00:00', 'Tengo diarrea', 'cancelada'),
(4, 1, NULL, '2026-03-12 10:00:00', 'Dolor de muela', 'confirmada'),
(5, 1, NULL, '2133-03-12 21:31:00', 'Dolor de rodilla', 'confirmada'),
(6, 1, NULL, '2026-04-12 10:00:00', 'Doloorr', 'pendiente'),
(7, 8, NULL, '2026-04-15 17:00:00', 'Caida', 'confirmada'),
(8, 8, NULL, '2026-05-12 11:00:00', 'Dolor de nuevo', 'confirmada'),
(9, 8, NULL, '2030-12-31 11:00:00', 'Me va a doler la muela para ese entonces ', 'completada'),
(10, 1, NULL, '3333-03-12 11:00:00', 'dwqdsa', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctores`
--

CREATE TABLE `doctores` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cedula_profesional` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `especialidad` varchar(50) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `doctores`
--

INSERT INTO `doctores` (`id`, `nombre_completo`, `email`, `cedula_profesional`, `password_hash`, `especialidad`, `activo`, `fecha_registro`) VALUES
(3, 'Ruben Fuentes Martinez', 'ruben@gmail.com', '231231231', '$2y$10$1CSpnacSA/oQJ2LCdAF8ae8UUKuk6WA8BcJKbRU3sus.3ZT4U.a3m', NULL, 1, '2026-04-08 23:17:08'),
(4, 'Erick Eduardo Baez Tapia', 'Erick@gmail.com', 'INGMEC', '$2y$10$i9d9/PlzzyQzEi/elNWgzuQXpdoKMbHNQ9xjVe92XZTdO9Tbb1fyG', NULL, 1, '2026-04-09 02:26:03'),
(5, 'Yael Fuentes', 'yael@gmail.com', '312321', '$2y$10$F9BNmqb9OqqJnD7Bi8ne.ezComxW58./oW75Y.sWZEN1vObfsaxye', NULL, 1, '2026-04-09 03:31:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `emisor_id` int(11) DEFAULT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `receptor_id` int(11) DEFAULT NULL,
  `tipo_emisor` enum('usuario','doctor') NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `emisor_id`, `paciente_id`, `receptor_id`, `tipo_emisor`, `mensaje`, `fecha_envio`, `leido`) VALUES
(1, 1, NULL, NULL, 'usuario', 'Hola', '2026-04-08 23:44:35', 0),
(2, 3, NULL, NULL, 'doctor', 'k we\r\n', '2026-04-09 00:52:40', 0),
(3, 3, NULL, 1, 'doctor', 'k we \r\n', '2026-04-09 01:19:30', 0),
(4, 3, 1, NULL, 'doctor', 'Hola', '2026-04-09 01:34:28', 0),
(5, 1, 1, NULL, 'usuario', 'Hola', '2026-04-09 02:00:16', 0),
(6, 1, 1, NULL, 'usuario', 'Como estas?\r\n', '2026-04-09 02:00:28', 0),
(7, 1, 1, NULL, 'usuario', 'Que haces?', '2026-04-09 02:10:36', 0),
(8, 1, 1, NULL, 'usuario', 'ola\r\n', '2026-04-09 02:14:29', 0),
(9, 3, 1, NULL, 'doctor', 'Que onda', '2026-04-09 02:17:00', 0),
(10, 1, 1, NULL, 'usuario', 'Nada, aqui', '2026-04-09 02:19:33', 0),
(11, 1, 1, NULL, 'usuario', 'Nada, aqui', '2026-04-09 02:19:57', 0),
(12, 8, 8, NULL, 'usuario', 'Hola', '2026-04-09 03:09:30', 0),
(13, 8, 8, NULL, 'usuario', 'Que haces?\r\n', '2026-04-09 03:12:43', 0),
(14, 3, 8, NULL, 'doctor', 'Como estas?', '2026-04-09 03:13:58', 0),
(15, 1, 1, NULL, 'usuario', 'hola\r\n', '2026-04-09 03:18:54', 0),
(16, 3, 8, NULL, 'doctor', 'holaaa', '2026-04-09 03:23:38', 0),
(17, 1, 1, NULL, 'usuario', 'hola\r\n', '2026-04-09 03:29:24', 0),
(18, 3, 8, NULL, 'doctor', 'hola', '2026-04-09 03:30:14', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `genero` enum('M','F','Otro') DEFAULT NULL,
  `curp` varchar(18) DEFAULT NULL,
  `antecedentes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `usuario_id`, `nombre`, `fecha_nacimiento`, `genero`, `curp`, `antecedentes`) VALUES
(1, 1, 'Vanessa', '2024-02-12', '', NULL, NULL),
(2, 2, '', '0000-00-00', '', NULL, NULL),
(3, 3, 'Daniel', '2020-03-12', '', NULL, NULL),
(4, 4, 'Vale', '2024-12-02', '', NULL, NULL),
(5, 5, 'Leonardo', '2026-03-12', '', NULL, NULL),
(6, 6, 'Test Paciente', '2020-01-01', '', NULL, NULL),
(7, 7, 'Test Paciente', '2020-01-01', '', NULL, NULL),
(8, 8, 'Camila', '2015-03-12', '', NULL, NULL),
(9, 9, 'Test Paciente', '2020-01-01', '', NULL, NULL),
(10, 10, 'Test Paciente', '2020-01-01', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas`
--

CREATE TABLE `recetas` (
  `id` int(11) NOT NULL,
  `cita_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `paciente_id` int(11) DEFAULT NULL,
  `medicamentos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medicamentos`)),
  `indicaciones` text DEFAULT NULL,
  `fecha_emision` datetime DEFAULT current_timestamp(),
  `firma_digital` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `email`, `telefono`, `password_hash`, `fecha_registro`, `activo`) VALUES
(1, 'Ruben Fuentes Martinez', 'ruben1@gmail.com', '321532321312', '$2y$10$yGv0v8LeGZY2362u07cV1uFf0144gcww9Grz1wRHptbnyR29UTG/m', '2026-04-08 20:32:27', 1),
(2, '', '', '', '$2y$10$gz8h8mbNKdvZ3kjQcu9ajubh6CsSx.r1jsCpWoVguaCEbIsJw64wO', '2026-04-08 23:05:08', 1),
(3, 'Danna galindo cruz', 'danna@gmail.com', '55123213', '$2y$10$m3ZtQswGMKw1swua1238zuutGM4Gqpm0qGft61FUYhiJCeRecJ.8G', '2026-04-08 23:13:35', 1),
(4, 'Liliana Prospero Rivas', 'lili@gmail.com', '5519181716', '$2y$10$BUOomyPlIksKPNp/myiyLe2CdafYME4VCfh8.C.Z9SxMUUBX6m1KS', '2026-04-09 02:22:27', 1),
(5, 'Daniel Fuentes Martinez', 'daniel@gmail.com', '5513231321', '$2y$10$o/pmjF4crbZli/DQtYQB2.YecnhxTz4l.3IyuVWPHRPckhC6fGlGu', '2026-04-09 02:53:22', 1),
(6, 'Test Usuario', 'test1775725135@test.com', '5512345678', '$2y$10$pYExoqJIqSSSDhGrDOvm0O5Vf5ZAaHYolGJovVZHn24HVlYab/vtK', '2026-04-09 02:58:55', 1),
(7, 'Test Usuario', 'test1775725163@test.com', '5512345678', '$2y$10$zl0w/kfgkBPlgTjDySbfa.9tYxdGf7iyLulQ.VH1roduMjNX.fmHy', '2026-04-09 02:59:23', 1),
(8, 'Jorge Fuentes Martinez', 'Jorge@gmail.com', '5513231322', '$2y$10$a6lxzt4k5o1BwtYy./klNON53fMmNy0f6Gv9AB9tAj65Sa/NezKy.', '2026-04-09 03:00:12', 1),
(9, 'Test Usuario', 'test1775725289@test.com', '5512345678', '$2y$10$q3cRXReWQpItQQ7c7JRkrehygQn7UAGfYAAz8l6iQL.eadCRxa.mG', '2026-04-09 03:01:29', 1),
(10, 'Test Usuario', 'test1775727267@test.com', '5512345678', '$2y$10$S6WXWYefzQZu.jsCcyqRyuVXephCI9bh5z1RBQEL8cfkfZn1ZmcJW', '2026-04-09 03:34:27', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cambios_cita`
--
ALTER TABLE `cambios_cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cita_original_id` (`cita_original_id`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paciente_id` (`paciente_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indices de la tabla `doctores`
--
ALTER TABLE `doctores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `doctor_id` (`doctor_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cambios_cita`
--
ALTER TABLE `cambios_cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `doctores`
--
ALTER TABLE `doctores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `recetas`
--
ALTER TABLE `recetas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cambios_cita`
--
ALTER TABLE `cambios_cita`
  ADD CONSTRAINT `cambios_cita_ibfk_1` FOREIGN KEY (`cita_original_id`) REFERENCES `citas` (`id`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`id`);

--
-- Filtros para la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD CONSTRAINT `pacientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `recetas`
--
ALTER TABLE `recetas`
  ADD CONSTRAINT `recetas_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id`),
  ADD CONSTRAINT `recetas_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctores` (`id`),
  ADD CONSTRAINT `recetas_ibfk_3` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
