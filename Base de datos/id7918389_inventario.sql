-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-01-2019 a las 02:39:33
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id7918389_inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(10, 'No hay'),
(39, 'Flor'),
(40, 'Flor azul'),
(41, 'Flor roja'),
(42, 'Flor verde'),
(44, 'Zapatos'),
(45, 'Zapatos negros'),
(46, 'Alcancia'),
(47, 'Caja'),
(48, 'Computadora'),
(50, 'Pizarron'),
(51, 'Maceta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `lema` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `id_usuario`, `logo`, `lema`) VALUES
(1, 1, 'FB_IMG_1525490002447.jpg', 'Desarrollo de software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nivel` int(1) NOT NULL,
  `estado_actual` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `nivel`, `estado_actual`) VALUES
(1, 'Administradores', 1, 1),
(51, 'Grupo Especial', 2, 1),
(55, 'Usuarios', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `nombre_archivo`, `tipo_archivo`) VALUES
(16, 'no_image.jpg', 'image/jpeg'),
(37, 'Chrysanthemum.jpg', 'image/jpeg'),
(38, 'Lighthouse.jpg', 'image/jpeg'),
(40, 'Screenshot_20180529-163906.png', 'image/png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(25,2) NOT NULL,
  `precio_venta` decimal(25,2) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_media` int(11) DEFAULT NULL,
  `fecha_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `cantidad`, `precio_compra`, `precio_venta`, `id_categoria`, `id_media`, `fecha_actualizacion`) VALUES
(22, 'Rosa', 4, 1.00, 24.00, 39, 37, '2019-01-07 10:59:06'),
(24, 'Rosa verde chica', 20, 1.00, 28.00, 40, 38, '2019-01-07 10:40:05'),
(27, 'Espina rota', 27, 1.00, 5.00, 39, 37, '2019-01-07 10:39:40'),
(28, 'Zapatos blancos', 25, 12.00, 25.00, 44, NULL, '2019-01-07 11:02:40'),
(29, 'Zapatos negros', 45, 12.00, 34.00, 45, 37, '2019-01-07 11:00:32'),
(30, 'Rosa blanca grande', 12, 23.00, 23.05, 39, 37, '2019-01-07 11:09:00'),
(31, 'Croc', 9, 45.00, 67.00, 44, 40, '2019-01-07 11:09:00'),
(32, 'Corbata azul', 3, 1.00, 2.00, NULL, 37, '2019-01-10 10:39:26');

--
-- Disparadores `producto`
--
DELIMITER $$
CREATE TRIGGER `producto_eliminado` AFTER DELETE ON `producto` FOR EACH ROW INSERT INTO producto_eliminado(id,nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion) VALUES (OLD.id,OLD.nombre,OLD.cantidad,OLD.precio_compra,OLD.precio_venta,OLD.id_categoria,OLD.id_media,OLD.fecha_actualizacion)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `producto_respaldo` AFTER INSERT ON `producto` FOR EACH ROW INSERT INTO producto_respaldo(id,nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion) VALUES (NEW.id,NEW.nombre,NEW.cantidad,NEW.precio_compra,NEW.precio_venta,NEW.id_categoria,NEW.id_media,NEW.fecha_actualizacion)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_eliminado`
--

CREATE TABLE `producto_eliminado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` decimal(25,2) DEFAULT NULL,
  `precio_venta` decimal(25,2) NOT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_media` int(11) DEFAULT NULL,
  `fecha_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto_eliminado`
--

INSERT INTO `producto_eliminado` (`id`, `nombre`, `cantidad`, `precio_compra`, `precio_venta`, `id_categoria`, `id_media`, `fecha_actualizacion`) VALUES
(21, 'Flor roja', 1, 1.00, 1.00, 39, 37, '2018-12-04 17:50:58'),
(33, 'Flor roja', 12, 1.00, 1.00, 41, 37, '2019-01-10 10:41:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_respaldo`
--

CREATE TABLE `producto_respaldo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(25,2) NOT NULL,
  `precio_venta` decimal(25,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_media` int(11) NOT NULL,
  `fecha_actualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto_respaldo`
--

INSERT INTO `producto_respaldo` (`id`, `nombre`, `cantidad`, `precio_compra`, `precio_venta`, `id_categoria`, `id_media`, `fecha_actualizacion`) VALUES
(13, 'Flor azul', 1, 1.00, 1.00, 40, 37, '2019-01-04 10:25:50'),
(14, 'Flor roja', 1, 1.00, 1.00, 35, 29, '2018-12-03 19:08:53'),
(16, 'Flor roja', 1, 1.00, 1.00, 36, 30, '2018-12-03 19:10:22'),
(18, 'Flor roja', 1, 1.00, 1.00, 37, 31, '2018-12-03 19:13:36'),
(19, 'Flor', 1, 1.00, 1.00, 38, 32, '2018-12-03 19:24:34'),
(21, 'Flor', 1, 1.00, 1.00, 39, 37, '2018-12-04 17:32:30'),
(22, 'Rosa', 1, 1.00, 1.00, 39, 37, '2018-12-04 18:48:46'),
(23, 'Espina', 1, 1.00, 5.00, 39, 37, '2018-12-04 18:48:46'),
(24, 'Rosa verde', 1, 1.00, 1.00, 40, 38, '2018-12-04 18:54:45'),
(25, 'Flor azul', 1, 1.00, 1.00, 10, 16, '2018-12-03 19:24:34'),
(26, 'Flor azul', 1, 1.00, 1.00, 40, 37, '2019-01-07 10:15:08'),
(27, 'Espina', 27, 1.00, 5.00, 39, 37, '2018-12-04 19:05:21'),
(28, 'Zapatos blancos', 25, 12.00, 25.00, 44, 38, '2019-01-07 11:00:13'),
(29, 'Zapatos negros', 45, 12.00, 34.00, 45, 37, '2019-01-07 11:00:32'),
(30, 'Rosa blanca grande', 12, 23.00, 23.05, 39, 37, '2019-01-07 11:09:00'),
(31, 'Croc', 12, 45.00, 67.00, 44, 40, '2019-01-07 11:09:00'),
(32, 'Corbata azul', 12, 1.00, 2.00, 49, 37, '2019-01-10 10:39:26'),
(33, 'Flor roja', 12, 1.00, 1.00, 41, 37, '2019-01-10 10:41:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rango_fecha`
--

CREATE TABLE `rango_fecha` (
  `id` int(11) NOT NULL,
  `id_tipos_reporte` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rango_fecha`
--

INSERT INTO `rango_fecha` (`id`, `id_tipos_reporte`, `fecha_inicio`, `fecha_fin`) VALUES
(8, 39, '2018-12-01 00:00:00', '2018-12-07 00:00:00'),
(9, 41, '2018-12-15 00:00:00', '2019-01-15 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reporte`
--

INSERT INTO `reporte` (`id`, `nombre`) VALUES
(1, 'diario'),
(2, 'mensual'),
(3, 'fechas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_usuario`
--

CREATE TABLE `reporte_usuario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_reporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `reporte_usuario`
--

INSERT INTO `reporte_usuario` (`id`, `id_usuario`, `id_reporte`) VALUES
(39, 1, 3),
(40, 13, 1),
(41, 21, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `nombre`) VALUES
(1, 'defecto'),
(2, 'pastel'),
(3, 'personalizado1'),
(4, 'personalizado2'),
(5, 'personalizado3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_personal`
--

CREATE TABLE `tema_personal` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tema_personal`
--

INSERT INTO `tema_personal` (`id`, `id_usuario`, `id_tema`) VALUES
(1, 1, 1),
(11, 13, 1),
(12, 14, 3),
(13, 15, 5),
(14, 16, 3),
(15, 17, 1),
(18, 20, 1),
(19, 21, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `id_grupo_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `imagen` varchar(255) DEFAULT 'no_image.jpg',
  `imagen_fondo` varchar(255) DEFAULT NULL,
  `estado` int(1) NOT NULL,
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `id_grupo_usuario`, `nombre`, `username`, `contrasena`, `imagen`, `imagen_fondo`, `estado`, `ultimo_login`) VALUES
(1, 1, 'Enrique Paul', 'Administrador', '9dbf7c1488382487931d10235fc84a74bff5d2f4', 'nuk1p8um1.jpg', '', 1, '2019-01-15 13:54:26'),
(13, 51, 'Enrique Paul', 'Especial', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'no_image.jpg', NULL, 1, '2019-01-10 10:54:05'),
(14, 55, 'Quique Paul', 'Usuario', 'b665e217b51994789b02b1838e730d6b93baa30f', 'no_image.jpg', '', 1, '2019-01-10 10:36:17'),
(15, 1, 'Enrique Paul', 'Administradore', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'no_image.jpg', NULL, 1, '2018-12-11 11:46:49'),
(16, 51, 'Enrique Paul', 'Especiale', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'no_image.jpg', NULL, 1, '2018-11-28 14:17:32'),
(17, 55, 'Enrique Paul', 'Usuarioe', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'no_image.jpg', NULL, 1, '2018-11-28 14:02:40'),
(20, 1, 'Enrique', 'Residentes', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'no_image.jpg', NULL, 1, '2019-01-03 11:19:35'),
(21, 1, 'Juan Carlos', 'juan', '51eac6b471a284d3341d8c0c63d0f1a286262a18', 'ecqkfrzj21.jpg', 'FB_IMG_1525490002447.jpg', 1, '2019-01-07 11:22:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(25,2) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `id_usuario`, `id_producto`, `cantidad`, `precio`, `fecha`) VALUES
(3, 1, 25, 6, 12.00, '2018-12-20'),
(4, 14, 22, 6, 6.00, '2018-12-05'),
(5, 14, 24, 2, 56.00, '2019-01-07'),
(6, 13, 24, 4, 112.00, '2019-01-07'),
(7, 14, 31, 3, 201.00, '2019-01-06'),
(8, 14, 32, 9, 18.00, '2019-01-10');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categorie_id` (`id_categoria`),
  ADD KEY `id_media` (`id_media`);

--
-- Indices de la tabla `producto_eliminado`
--
ALTER TABLE `producto_eliminado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_media` (`id_media`);

--
-- Indices de la tabla `producto_respaldo`
--
ALTER TABLE `producto_respaldo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_media` (`id_media`);

--
-- Indices de la tabla `rango_fecha`
--
ALTER TABLE `rango_fecha`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reporte` (`id_tipos_reporte`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_reporte` (`id_reporte`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tema_personal`
--
ALTER TABLE `tema_personal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grupo_usuario` (`id_grupo_usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `producto_respaldo`
--
ALTER TABLE `producto_respaldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `rango_fecha`
--
ALTER TABLE `rango_fecha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tema_personal`
--
ALTER TABLE `tema_personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`id_media`) REFERENCES `media` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_eliminado`
--
ALTER TABLE `producto_eliminado`
  ADD CONSTRAINT `producto_eliminado_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_eliminado_ibfk_2` FOREIGN KEY (`id_media`) REFERENCES `media` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `rango_fecha`
--
ALTER TABLE `rango_fecha`
  ADD CONSTRAINT `rango_fecha_ibfk_1` FOREIGN KEY (`id_tipos_reporte`) REFERENCES `reporte_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_usuario`
--
ALTER TABLE `reporte_usuario`
  ADD CONSTRAINT `reporte_usuario_ibfk_1` FOREIGN KEY (`id_reporte`) REFERENCES `reporte` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_usuario_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tema_personal`
--
ALTER TABLE `tema_personal`
  ADD CONSTRAINT `tema_personal_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tema_personal_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_grupo_usuario`) REFERENCES `grupo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `producto_respaldo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
