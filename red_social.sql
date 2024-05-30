-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-05-2024 a las 02:06:43
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `red_social`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amigos`
--

CREATE TABLE `amigos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `amigo_id` int(11) DEFAULT NULL,
  `estado` enum('pendiente','aceptado','rechazado') DEFAULT 'pendiente',
  `fecha_amistad` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `amigos`
--

INSERT INTO `amigos` (`id`, `usuario_id`, `amigo_id`, `estado`, `fecha_amistad`) VALUES
(1, 2, 1, 'pendiente', '2024-05-28 18:23:58'),
(2, 3, 1, 'pendiente', '2024-05-28 19:09:41'),
(3, 4, 2, 'pendiente', '2024-05-28 21:50:26'),
(4, 4, 3, 'pendiente', '2024-05-28 21:50:36'),
(5, 4, 1, 'pendiente', '2024-05-28 21:53:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `publicacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha_publicacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `me_gusta` int(11) NOT NULL DEFAULT 0,
  `liked_by` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`id`, `usuario_id`, `contenido`, `fecha_publicacion`, `me_gusta`, `liked_by`) VALUES
(1, 1, 'que viva la FET!!', '2024-05-28 17:53:49', 0, 0),
(2, 2, 'mensaje de prueba', '2024-05-28 18:49:14', 0, 0),
(3, 3, 'soy ana', '2024-05-28 19:09:29', 6, 1),
(4, 4, 'hola, es mi primer día aquí!!!', '2024-05-28 19:16:37', 2, 1),
(5, 5, 'primeros usuarios de la aplicación web', '2024-05-28 22:36:44', 1, 1),
(6, 6, 'nueva red social de prueba, texto hecho con la intencion de rellenar el area de escrito, el cual consta de una gran capacidad de almacenamiento 1 2 3 4 5 6 7 8 9 ... gracias', '2024-05-28 22:42:43', 1, 1),
(7, 6, 'prueba de imágenes', '2024-05-28 22:57:59', 1, 1),
(8, 8, 'hola, como están todos, bienvenidos!!', '2024-05-28 23:20:10', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `fecha_registro`, `profile_image`) VALUES
(1, 'Juan', 'user1@gmail.com', '$2y$10$3pcz6AEdFFPZnZeZbhHE6u28jqDtJ1HK8Snx3V5BtXHn0.bMD51UW', '2024-05-28 17:52:54', 'uploads/e9ad58c2878a015e366ef940ec098349.jpg'),
(2, 'Pedro', 'user2@gmail.com', '$2y$10$DB3Gkz26WqBwK2sS1AMkJ.imwzgRtN./mFhX7FitXoZC7wU6J8Bim', '2024-05-28 18:23:21', 'uploads/1d91e089a51275a744500efef3e3ec9c.jpg'),
(3, 'Ana Fernández', 'user3@gmail.com', '$2y$10$VSbdQgnYr8EOz5OUzglCIOcMPUmgLgQ2S52vWZPjrJfzF.xiottjq', '2024-05-28 19:08:48', 'uploads/94e3144b75ee874511bcb5f43ade18f1.jpg'),
(4, 'Andrés Salazar', 'user4@gmail.com', '$2y$10$dwtlnlkq30mbJn61BsNNGelQjb/vbzWdS3j.xuzHXMAQUo.lBqB.S', '2024-05-28 19:15:44', 'uploads/35144a8ec77966786d626adcbc0ad36c.jpg'),
(5, 'Sebastián Losada', 'user5@gmail.com', '$2y$10$CzMN197ZacDRfdp2h58n9uAJZLxrI.w34jM1RYeup25uYXUavwyNi', '2024-05-28 22:06:42', 'uploads/af806455dfcd6ae94bf0771e3e254141.jpg'),
(6, 'Lucía Pérez', 'user6@gmail.com', '$2y$10$tWhgYs7P3JPVLGMfBl77xOBFZoQA09FcDpzh2nKJ4/F4c5ntVyHzK', '2024-05-28 22:38:51', 'uploads/a12c250bef4bd9962e43b1d68941ab0e.jpg'),
(8, 'Sofía Castro', 'user7@gmail.com', '$2y$10$sfledyxEwJjLoGTPNuYTgOwUe6sg7x9DSdJ6oXkXzp.rWl67wpIEC', '2024-05-28 23:00:44', 'uploads/cc110c67fe8f1ad6749a2b7eaaada5ef.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `amigo_id` (`amigo_id`);

--
-- Indices de la tabla `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`usuario_id`,`publicacion_id`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
-- AUTO_INCREMENT de la tabla `amigos`
--
ALTER TABLE `amigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amigos`
--
ALTER TABLE `amigos`
  ADD CONSTRAINT `amigos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `amigos_ibfk_2` FOREIGN KEY (`amigo_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD CONSTRAINT `publicaciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
