-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-10-2025 a las 21:40:14
-- Versión del servidor: 12.0.2-MariaDB-log
-- Versión de PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_poa`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `buscarUnidad` (`a` VARCHAR(255), `b` VARCHAR(255)) RETURNS INT(11) DETERMINISTIC BEGIN
  DECLARE la, lb, i, j, c, c_temp INT;
  DECLARE cv0 VARBINARY(256);
  DECLARE cv1 VARBINARY(256);

  SET la = CHAR_LENGTH(a);
  SET lb = CHAR_LENGTH(b);
  IF la = 0 THEN RETURN lb; END IF;
  IF lb = 0 THEN RETURN la; END IF;

  SET cv1 = 0x00;
  SET j = 1;
  WHILE j <= lb DO
    SET cv1 = CONCAT(cv1, UNHEX(HEX(j)));
    SET j = j + 1;
  END WHILE;

  SET i = 1;
  WHILE i <= la DO
    SET cv0 = UNHEX(HEX(i));
    SET j = 1;
    WHILE j <= lb DO
      SET c = ORD(SUBSTRING(cv1, j, 1));
      IF SUBSTRING(a, i, 1) = SUBSTRING(b, j, 1) THEN
        SET c_temp = c;
      ELSE
        SET c_temp = LEAST(ORD(SUBSTRING(cv1, j+1, 1)) + 1, ORD(SUBSTRING(cv0, j, 1)) + 1, c + 1);
      END IF;
      SET cv0 = CONCAT(cv0, UNHEX(HEX(c_temp)));
      SET j = j + 1;
    END WHILE;
    SET cv1 = cv0;
    SET i = i + 1;
  END WHILE;

  RETURN ORD(SUBSTRING(cv1, lb+1, 1));
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areaestrategica_formulario1`
--

CREATE TABLE `areaestrategica_formulario1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `areEstrategica_id` bigint(20) UNSIGNED NOT NULL,
  `formulario1_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `areaestrategica_formulario1`
--

INSERT INTO `areaestrategica_formulario1` (`id`, `areEstrategica_id`, `formulario1_id`) VALUES
(1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confor_clasprim_partipo`
--

CREATE TABLE `confor_clasprim_partipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partida_tid` bigint(20) UNSIGNED NOT NULL,
  `clasificador_pid` bigint(20) UNSIGNED NOT NULL,
  `configuracion_fid` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `confor_clasprim_partipo`
--

INSERT INTO `confor_clasprim_partipo` (`id`, `partida_tid`, `clasificador_pid`, `configuracion_fid`) VALUES
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleCuartoClasi_medida_bn`
--

CREATE TABLE `detalleCuartoClasi_medida_bn` (
  `detalle_cuartoclasif_id` bigint(20) UNSIGNED NOT NULL,
  `medidabn_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalleCuartoClasi_medida_bn`
--

INSERT INTO `detalleCuartoClasi_medida_bn` (`detalle_cuartoclasif_id`, `medidabn_id`) VALUES
(20, 5),
(21, 71),
(22, 73),
(23, 92),
(6, 93),
(15, 95);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleQuintoClasi_medida_bn`
--

CREATE TABLE `detalleQuintoClasi_medida_bn` (
  `detalle_quintoclasif_id` bigint(20) UNSIGNED NOT NULL,
  `medidabn_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleTercerClasi_medida_bn`
--

CREATE TABLE `detalleTercerClasi_medida_bn` (
  `detalle_tercerclasif_id` bigint(20) UNSIGNED NOT NULL,
  `medidabn_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalleTercerClasi_medida_bn`
--

INSERT INTO `detalleTercerClasi_medida_bn` (`detalle_tercerclasif_id`, `medidabn_id`) VALUES
(9, 1),
(7, 2),
(92, 3),
(8, 4),
(18, 6),
(19, 7),
(20, 8),
(23, 9),
(93, 10),
(94, 11),
(26, 12),
(95, 13),
(28, 14),
(96, 15),
(97, 16),
(33, 17),
(34, 18),
(35, 19),
(36, 20),
(39, 21),
(98, 22),
(41, 23),
(42, 24),
(99, 25),
(100, 26),
(101, 27),
(102, 28),
(44, 29),
(45, 30),
(46, 31),
(47, 32),
(48, 33),
(50, 34),
(103, 35),
(52, 36),
(56, 37),
(104, 38),
(105, 39),
(106, 40),
(107, 41),
(108, 42),
(109, 43),
(110, 44),
(111, 45),
(112, 46),
(113, 47),
(58, 48),
(114, 49),
(115, 50),
(116, 51),
(117, 52),
(118, 53),
(119, 54),
(120, 55),
(62, 56),
(121, 57),
(122, 58),
(123, 59),
(124, 60),
(125, 61),
(63, 62),
(126, 63),
(111, 64),
(127, 65),
(128, 66),
(68, 67),
(129, 68),
(130, 69),
(131, 70),
(132, 72),
(73, 74),
(133, 75),
(74, 76),
(75, 77),
(134, 78),
(135, 79),
(136, 80),
(137, 81),
(138, 82),
(139, 83),
(140, 84),
(70, 85),
(141, 86),
(142, 87),
(143, 88),
(144, 89),
(145, 90),
(91, 91),
(147, 94),
(146, 96);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario2_objEstrategico`
--

CREATE TABLE `formulario2_objEstrategico` (
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `objetivoEstrategico_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario2_objEstrategico`
--

INSERT INTO `formulario2_objEstrategico` (`formulario2_id`, `objetivoEstrategico_id`) VALUES
(1, 32),
(2, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario2_objEstrategico_sub`
--

CREATE TABLE `formulario2_objEstrategico_sub` (
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `objEstrategico_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario2_objEstrategico_sub`
--

INSERT INTO `formulario2_objEstrategico_sub` (`formulario2_id`, `objEstrategico_id`) VALUES
(1, 13),
(2, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario2_objInstitucional`
--

CREATE TABLE `formulario2_objInstitucional` (
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `objInstitucional_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario2_objInstitucional`
--

INSERT INTO `formulario2_objInstitucional` (`formulario2_id`, `objInstitucional_id`) VALUES
(1, 13),
(2, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario2_politicaDesarrollo_pdu`
--

CREATE TABLE `formulario2_politicaDesarrollo_pdu` (
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `politicaDesarrollo_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario2_politicaDesarrollo_pdu`
--

INSERT INTO `formulario2_politicaDesarrollo_pdu` (`formulario2_id`, `politicaDesarrollo_id`) VALUES
(1, 49),
(2, 51);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario2_politicaDesarrollo_pei`
--

CREATE TABLE `formulario2_politicaDesarrollo_pei` (
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `politicaDesarrollo_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario2_politicaDesarrollo_pei`
--

INSERT INTO `formulario2_politicaDesarrollo_pei` (`formulario2_id`, `politicaDesarrollo_id`) VALUES
(1, 35),
(2, 36);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario4_unidad_res`
--

CREATE TABLE `formulario4_unidad_res` (
  `formulario4_id` bigint(20) UNSIGNED NOT NULL,
  `unidad_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario4_unidad_res`
--

INSERT INTO `formulario4_unidad_res` (`formulario4_id`, `unidad_id`) VALUES
(1, 41),
(2, 41);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fut`
--

CREATE TABLE `fut` (
  `id_fut` int(11) NOT NULL,
  `id_configuracion_formulado` bigint(20) NOT NULL,
  `nro` int(11) NOT NULL,
  `area_estrategica` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`area_estrategica`)),
  `objetivo_gestion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`objetivo_gestion`)),
  `tarea_proyecto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tarea_proyecto`)),
  `importe` decimal(50,2) DEFAULT NULL,
  `respaldo_tramite` varchar(255) DEFAULT NULL,
  `fecha_tramite` timestamp NULL DEFAULT NULL,
  `estado` enum('elaborado','verificado','aprobado','rechazado','eliminado') NOT NULL DEFAULT 'elaborado',
  `observacion` varchar(255) DEFAULT NULL,
  `id_unidad_carrera` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nro_preventivo` int(100) DEFAULT NULL,
  `id_unidad_verifica` int(11) DEFAULT NULL,
  `id_unidad_aprueba` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fut_movimiento`
--

CREATE TABLE `fut_movimiento` (
  `id_fut_mov` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `partida_codigo` int(11) NOT NULL,
  `partida_monto` decimal(50,2) NOT NULL,
  `id_mbs` int(11) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `id_fut_pp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fut_partidas_presupuestarias`
--

CREATE TABLE `fut_partidas_presupuestarias` (
  `id_fut_pp` int(11) NOT NULL,
  `organismo_financiador` int(11) NOT NULL,
  `formulario5` int(11) NOT NULL,
  `categoria_progmatica` varchar(100) DEFAULT NULL,
  `id_fut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_objetivo_estrategico`
--

CREATE TABLE `matriz_objetivo_estrategico` (
  `matriz_id` bigint(20) UNSIGNED NOT NULL,
  `objetivo_estrategico_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_objetivo_estrategico`
--

INSERT INTO `matriz_objetivo_estrategico` (`matriz_id`, `objetivo_estrategico_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 3),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 5),
(23, 6),
(24, 6),
(25, 6),
(26, 7),
(27, 8),
(28, 8),
(29, 8),
(30, 8),
(31, 8),
(32, 8),
(33, 9),
(34, 9),
(35, 10),
(36, 10),
(37, 10),
(38, 10),
(39, 10),
(40, 11),
(41, 11),
(42, 11),
(43, 12),
(44, 12),
(45, 12),
(46, 12),
(47, 12),
(48, 13),
(49, 13),
(50, 13),
(51, 13),
(52, 13),
(53, 13),
(54, 14),
(55, 14),
(56, 14),
(57, 15),
(58, 15),
(59, 15),
(60, 16),
(61, 16),
(62, 16),
(63, 16),
(64, 17),
(65, 17),
(66, 17),
(67, 18),
(68, 19),
(69, 19),
(70, 20),
(71, 21),
(72, 21),
(73, 21),
(74, 21),
(75, 21),
(76, 22),
(77, 22),
(78, 22),
(79, 23),
(80, 23),
(81, 23),
(82, 23),
(83, 23),
(84, 24),
(85, 25),
(86, 27),
(87, 27),
(88, 27),
(89, 27),
(90, 28),
(91, 28),
(92, 28),
(93, 29),
(94, 29),
(95, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_objetivo_estrategico_sub`
--

CREATE TABLE `matriz_objetivo_estrategico_sub` (
  `matriz_id` bigint(20) UNSIGNED NOT NULL,
  `obj_estrategico_sub_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_objetivo_estrategico_sub`
--

INSERT INTO `matriz_objetivo_estrategico_sub` (`matriz_id`, `obj_estrategico_sub_id`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 3),
(9, 3),
(10, 3),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 5),
(18, 5),
(19, 5),
(20, 5),
(21, 5),
(22, 6),
(23, 7),
(24, 7),
(25, 7),
(26, 8),
(27, 18),
(28, 18),
(29, 18),
(30, 18),
(31, 18),
(32, 18),
(33, 19),
(34, 19),
(35, 20),
(36, 20),
(37, 20),
(38, 20),
(39, 20),
(40, 21),
(41, 21),
(42, 21),
(43, 22),
(44, 22),
(45, 22),
(46, 22),
(47, 22),
(48, 23),
(49, 23),
(50, 23),
(51, 23),
(52, 23),
(53, 23),
(54, 24),
(55, 24),
(56, 24),
(57, 25),
(58, 25),
(59, 25),
(60, 26),
(61, 26),
(62, 26),
(63, 26),
(64, 27),
(65, 27),
(66, 27),
(67, 28),
(68, 29),
(69, 29),
(70, 30),
(71, 9),
(72, 9),
(73, 9),
(74, 9),
(75, 9),
(76, 9),
(77, 9),
(78, 9),
(79, 11),
(80, 11),
(81, 11),
(82, 11),
(83, 11),
(84, 12),
(85, 12),
(86, 14),
(87, 14),
(88, 14),
(89, 14),
(90, 14),
(91, 14),
(92, 14),
(93, 16),
(94, 16),
(95, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_objetivo_institucional`
--

CREATE TABLE `matriz_objetivo_institucional` (
  `matriz_id` bigint(20) UNSIGNED NOT NULL,
  `obj_institucional_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_objetivo_institucional`
--

INSERT INTO `matriz_objetivo_institucional` (`matriz_id`, `obj_institucional_id`) VALUES
(1, 1),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 4),
(9, 4),
(10, 4),
(11, 5),
(12, 5),
(13, 5),
(14, 5),
(15, 5),
(16, 5),
(17, 6),
(18, 6),
(19, 6),
(20, 6),
(21, 6),
(22, 7),
(23, 8),
(24, 8),
(25, 8),
(26, 2),
(27, 18),
(28, 18),
(29, 18),
(30, 18),
(31, 18),
(32, 18),
(33, 19),
(34, 19),
(35, 20),
(36, 20),
(37, 20),
(38, 20),
(39, 20),
(40, 21),
(41, 21),
(42, 21),
(43, 22),
(44, 22),
(45, 22),
(46, 22),
(47, 22),
(48, 23),
(49, 23),
(50, 23),
(51, 23),
(52, 23),
(53, 23),
(54, 25),
(55, 25),
(56, 25),
(57, 26),
(58, 26),
(59, 26),
(60, 27),
(61, 27),
(62, 27),
(63, 27),
(64, 28),
(65, 28),
(66, 28),
(67, 29),
(68, 30),
(69, 30),
(70, 24),
(71, 9),
(72, 9),
(73, 9),
(74, 9),
(75, 9),
(76, 10),
(77, 10),
(78, 10),
(79, 11),
(80, 11),
(81, 11),
(82, 11),
(83, 11),
(84, 12),
(85, 13),
(86, 14),
(87, 14),
(88, 14),
(89, 14),
(90, 15),
(91, 15),
(92, 15),
(93, 16),
(94, 16),
(95, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_politica_desarrollo_pdu`
--

CREATE TABLE `matriz_politica_desarrollo_pdu` (
  `matriz_id` bigint(20) UNSIGNED NOT NULL,
  `politica_desarrollo_pdu` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_politica_desarrollo_pdu`
--

INSERT INTO `matriz_politica_desarrollo_pdu` (`matriz_id`, `politica_desarrollo_pdu`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 4),
(24, 4),
(25, 4),
(26, 4),
(27, 6),
(28, 6),
(29, 6),
(30, 6),
(31, 6),
(32, 6),
(33, 6),
(34, 6),
(35, 6),
(36, 6),
(37, 6),
(38, 6),
(39, 6),
(40, 7),
(41, 7),
(42, 7),
(43, 7),
(44, 7),
(45, 7),
(46, 7),
(47, 7),
(48, 8),
(49, 8),
(50, 8),
(51, 8),
(52, 8),
(53, 8),
(54, 9),
(55, 9),
(56, 9),
(57, 9),
(58, 9),
(59, 9),
(60, 10),
(61, 10),
(62, 10),
(63, 10),
(64, 10),
(65, 10),
(66, 10),
(67, 10),
(68, 11),
(69, 11),
(70, 11),
(71, 12),
(72, 12),
(73, 12),
(74, 12),
(75, 12),
(76, 39),
(77, 39),
(78, 39),
(79, 40),
(80, 40),
(81, 40),
(82, 40),
(83, 40),
(84, 41),
(85, 42),
(86, 44),
(87, 44),
(88, 44),
(89, 44),
(90, 45),
(91, 45),
(92, 45),
(93, 46),
(94, 46),
(95, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_politica_desarrollo_pei`
--

CREATE TABLE `matriz_politica_desarrollo_pei` (
  `matriz_id` bigint(20) UNSIGNED NOT NULL,
  `politica_desarrollo_pei` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_politica_desarrollo_pei`
--

INSERT INTO `matriz_politica_desarrollo_pei` (`matriz_id`, `politica_desarrollo_pei`) VALUES
(1, 5),
(2, 13),
(3, 13),
(4, 13),
(5, 13),
(6, 13),
(7, 13),
(8, 14),
(9, 14),
(10, 14),
(11, 15),
(12, 15),
(13, 15),
(14, 15),
(15, 15),
(16, 15),
(17, 16),
(18, 16),
(19, 16),
(20, 16),
(21, 16),
(22, 17),
(23, 18),
(24, 18),
(25, 18),
(26, 19),
(27, 20),
(28, 20),
(29, 20),
(30, 20),
(31, 20),
(32, 20),
(33, 21),
(34, 21),
(35, 22),
(36, 22),
(37, 22),
(38, 22),
(39, 22),
(40, 23),
(41, 23),
(42, 23),
(43, 24),
(44, 24),
(45, 24),
(46, 24),
(47, 24),
(48, 25),
(49, 25),
(50, 25),
(51, 25),
(52, 25),
(53, 25),
(54, 26),
(55, 26),
(56, 26),
(57, 27),
(58, 27),
(59, 27),
(60, 28),
(61, 28),
(62, 28),
(63, 28),
(64, 29),
(65, 29),
(66, 29),
(67, 30),
(68, 31),
(69, 31),
(70, 32),
(71, 33),
(72, 33),
(73, 33),
(74, 33),
(75, 33),
(76, 33),
(77, 33),
(78, 33),
(79, 34),
(80, 34),
(81, 34),
(82, 34),
(83, 34),
(84, 35),
(85, 35),
(86, 36),
(87, 36),
(88, 36),
(89, 36),
(90, 36),
(91, 36),
(92, 36),
(93, 37),
(94, 37),
(95, 38);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_unidad_inv`
--

CREATE TABLE `matriz_unidad_inv` (
  `matriz_id_inv` bigint(20) UNSIGNED NOT NULL,
  `unidad_id_inv` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_unidad_inv`
--

INSERT INTO `matriz_unidad_inv` (`matriz_id_inv`, `unidad_id_inv`) VALUES
(1, 38),
(1, 39),
(2, 37),
(2, 39),
(3, 37),
(3, 39),
(4, 37),
(4, 39),
(5, 37),
(5, 39),
(6, 37),
(6, 39),
(7, 37),
(7, 39),
(8, 39),
(9, 39),
(10, 38),
(10, 39),
(10, 47),
(10, 50),
(11, 38),
(11, 39),
(12, 38),
(12, 39),
(13, 38),
(13, 39),
(14, 39),
(15, 39),
(16, 39),
(17, 39),
(17, 40),
(18, 39),
(18, 40),
(19, 40),
(20, 39),
(20, 40),
(21, 36),
(21, 40),
(21, 42),
(21, 43),
(22, 39),
(22, 40),
(23, 36),
(23, 37),
(23, 39),
(24, 39),
(25, 39),
(25, 44),
(26, 47),
(26, 52),
(27, 43),
(27, 46),
(28, 43),
(28, 46),
(29, 43),
(29, 46),
(30, 43),
(30, 46),
(31, 45),
(31, 47),
(31, 48),
(31, 52),
(32, 45),
(32, 47),
(32, 48),
(32, 52),
(33, 36),
(33, 43),
(33, 46),
(34, 36),
(34, 43),
(34, 46),
(35, 36),
(35, 45),
(35, 47),
(35, 48),
(35, 52),
(36, 45),
(36, 47),
(36, 48),
(36, 52),
(37, 37),
(37, 45),
(37, 47),
(37, 49),
(37, 52),
(38, 48),
(39, 48),
(40, 36),
(40, 38),
(40, 48),
(41, 48),
(42, 45),
(42, 47),
(42, 48),
(42, 52),
(43, 45),
(43, 47),
(43, 48),
(43, 52),
(44, 48),
(45, 48),
(46, 45),
(46, 47),
(46, 48),
(46, 52),
(47, 48),
(48, 45),
(48, 47),
(48, 48),
(48, 52),
(49, 45),
(49, 47),
(49, 48),
(49, 52),
(50, 45),
(50, 47),
(50, 48),
(50, 52),
(51, 45),
(51, 47),
(51, 48),
(51, 52),
(52, 48),
(53, 48),
(54, 39),
(55, 39),
(56, 39),
(57, 49),
(58, 49),
(59, 49),
(59, 50),
(59, 51),
(60, 39),
(61, 49),
(62, 39),
(63, 37),
(63, 47),
(63, 49),
(63, 52),
(63, 67),
(64, 39),
(65, 36),
(65, 37),
(65, 49),
(65, 65),
(66, 36),
(66, 37),
(66, 49),
(66, 65),
(67, 47),
(67, 49),
(67, 52),
(68, 49),
(69, 36),
(69, 37),
(69, 43),
(69, 49),
(69, 53),
(70, 39),
(70, 49),
(71, 40),
(71, 48),
(71, 50),
(72, 40),
(72, 48),
(72, 50),
(73, 39),
(73, 40),
(73, 48),
(73, 50),
(74, 39),
(74, 40),
(74, 48),
(74, 50),
(75, 39),
(75, 40),
(75, 48),
(75, 50),
(76, 39),
(76, 40),
(76, 48),
(77, 39),
(77, 40),
(77, 48),
(78, 39),
(78, 40),
(78, 48),
(78, 50),
(79, 46),
(80, 36),
(80, 37),
(80, 39),
(80, 43),
(81, 41),
(81, 46),
(82, 46),
(83, 39),
(83, 46),
(84, 46),
(85, 36),
(85, 37),
(85, 39),
(85, 41),
(85, 43),
(86, 39),
(86, 46),
(87, 46),
(88, 39),
(88, 53),
(89, 39),
(89, 68),
(89, 69),
(90, 39),
(90, 46),
(90, 53),
(90, 65),
(91, 39),
(91, 46),
(91, 53),
(91, 65),
(92, 39),
(92, 46),
(92, 53),
(93, 39),
(93, 68),
(94, 39),
(94, 68),
(95, 39),
(95, 68);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriz_unidad_res`
--

CREATE TABLE `matriz_unidad_res` (
  `matriz_id_res` bigint(20) UNSIGNED NOT NULL,
  `unidad_id_res` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `matriz_unidad_res`
--

INSERT INTO `matriz_unidad_res` (`matriz_id_res`, `unidad_id_res`) VALUES
(1, 37),
(2, 37),
(3, 37),
(4, 37),
(5, 37),
(6, 37),
(7, 37),
(8, 37),
(9, 37),
(10, 37),
(11, 37),
(12, 37),
(13, 37),
(14, 37),
(15, 37),
(16, 37),
(17, 40),
(18, 40),
(19, 40),
(20, 40),
(21, 40),
(22, 40),
(23, 49),
(24, 37),
(25, 44),
(26, 37),
(27, 48),
(28, 48),
(29, 48),
(30, 48),
(31, 48),
(32, 48),
(33, 48),
(34, 48),
(35, 48),
(36, 48),
(37, 48),
(38, 48),
(39, 48),
(40, 48),
(41, 48),
(42, 48),
(43, 48),
(44, 48),
(45, 48),
(46, 48),
(47, 48),
(48, 48),
(49, 48),
(50, 48),
(51, 48),
(52, 48),
(53, 48),
(54, 49),
(55, 49),
(56, 49),
(57, 49),
(58, 49),
(59, 49),
(60, 49),
(61, 49),
(62, 49),
(63, 49),
(64, 49),
(65, 49),
(66, 49),
(67, 49),
(68, 49),
(69, 49),
(70, 49),
(71, 50),
(72, 50),
(73, 50),
(74, 50),
(75, 50),
(76, 50),
(77, 50),
(78, 50),
(79, 46),
(80, 46),
(81, 46),
(82, 46),
(83, 46),
(84, 46),
(85, 41),
(86, 46),
(87, 46),
(88, 53),
(89, 69),
(90, 65),
(91, 65),
(92, 65),
(93, 66),
(94, 66),
(95, 66);

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2023_02_22_084654_create_permission_tables', 1),
(4, '2023_03_01_093119_create_gestion', 1),
(5, '2023_03_02_202502_create_rl_gestiones', 1),
(6, '2023_03_04_234952_create_rl_articulacion_pdes', 1),
(7, '2023_03_09_095018_create_rl_areas_estrategicas', 1),
(8, '2023_03_14_115752_create_rl_tipo_foda', 1),
(9, '2023_03_14_121635_create_rl_tipo_plan', 1),
(10, '2023_03_14_121756_create_rl_foda_descripcion', 1),
(11, '2023_03_20_163128_create_rl_politica_de_desarrollo', 1),
(12, '2023_03_20_164234_create_rl_objetivo_estrategico', 1),
(13, '2023_03_23_084627_create_rl_objetivo_estrategico_sub', 1),
(14, '2023_03_23_085409_create_rl_objetivo_institucional', 1),
(15, '2023_03_31_093414_create_rl_indicador', 1),
(16, '2023_03_31_130241_create_rl_tipo', 1),
(17, '2023_03_31_130316_create_rl_categoria', 1),
(18, '2023_03_31_130347_create_rl_resultado_producto', 1),
(19, '2023_03_31_134331_create_rl_tipo_programa_acc', 1),
(20, '2023_03_31_134419_create_rl_programa_proy_acc_est', 1),
(21, '2023_03_31_153611_create_rl_unidad_carrera', 1),
(22, '2023_04_04_085547_create_rl_matriz_planificacion', 1),
(23, '2023_04_04_100646_create_matriz_unidad_inv', 1),
(24, '2023_04_04_115109_create_matriz_unidad_res', 1),
(25, '2023_04_08_141333_create_matriz_objetivo_estrategico', 1),
(26, '2023_04_08_142712_create_matriz_objetivo_estrategico_sub', 1),
(27, '2023_04_12_164231_create_rl_financiamiento_tipo', 1),
(28, '2023_04_12_164547_create_rl_partida_tipo', 1),
(29, '2023_04_12_164632_create_rl_formulado_tipo', 1),
(30, '2023_04_12_165554_create_rl_clasificador_tipo', 1),
(31, '2023_04_26_074913_create_rl_configuracion_formulado', 1),
(32, '2023_04_26_084711_create_rl_caja', 1),
(33, '2023_05_03_153452_create_rl_formulario1', 1),
(34, '2023_05_07_200625_create_rl_formulario2', 1),
(35, '2023_05_11_101052_create_rl_foda_carreras_unidad', 1),
(36, '2023_05_12_093938_create_rl_bienservicio', 1),
(37, '2023_05_12_095140_create_rl_formulario4', 1),
(38, '2023_05_18_163232_create_rl_operaciones', 1),
(39, '2023_05_18_163757_create_rl_formulario5', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(1, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 27),
(4, 'App\\Models\\User', 28),
(4, 'App\\Models\\User', 29),
(4, 'App\\Models\\User', 30),
(4, 'App\\Models\\User', 31),
(4, 'App\\Models\\User', 32),
(4, 'App\\Models\\User', 33),
(4, 'App\\Models\\User', 34),
(4, 'App\\Models\\User', 35),
(4, 'App\\Models\\User', 36),
(4, 'App\\Models\\User', 37),
(4, 'App\\Models\\User', 38),
(4, 'App\\Models\\User', 39),
(1, 'App\\Models\\User', 40),
(1, 'App\\Models\\User', 41),
(1, 'App\\Models\\User', 45),
(2, 'App\\Models\\User', 46),
(2, 'App\\Models\\User', 47),
(1, 'App\\Models\\User', 48),
(2, 'App\\Models\\User', 49),
(4, 'App\\Models\\User', 50),
(1, 'App\\Models\\User', 51),
(1, 'App\\Models\\User', 53),
(1, 'App\\Models\\User', 54),
(4, 'App\\Models\\User', 55),
(2, 'App\\Models\\User', 61);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mot`
--

CREATE TABLE `mot` (
  `id_mot` int(11) NOT NULL,
  `id_configuracion_formulado` bigint(20) UNSIGNED NOT NULL,
  `nro` int(11) NOT NULL,
  `area_estrategica_de` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`area_estrategica_de`)),
  `ae_de_importe` decimal(50,2) DEFAULT NULL,
  `ae_a_importe` decimal(50,2) DEFAULT NULL,
  `objetivo_gestion_de` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`objetivo_gestion_de`)),
  `og_de_importe` decimal(50,2) DEFAULT NULL,
  `og_a_importe` decimal(50,2) DEFAULT NULL,
  `tarea_proyecto_de` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tarea_proyecto_de`)),
  `tp_de_importe` decimal(50,2) DEFAULT NULL,
  `tp_a_importe` decimal(50,2) DEFAULT NULL,
  `respaldo_tramite` varchar(255) DEFAULT NULL,
  `fecha_tramite` timestamp NULL DEFAULT NULL,
  `importe` decimal(50,2) NOT NULL,
  `estado` enum('elaborado','verificado','aprobado','rechazado','pendiente','eliminado') NOT NULL DEFAULT 'pendiente',
  `observacion` varchar(255) DEFAULT NULL,
  `id_unidad_carrera` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_unidad_verifica` int(11) DEFAULT NULL,
  `id_unidad_aprueba` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mot_movimiento`
--

CREATE TABLE `mot_movimiento` (
  `id_mot_mov` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `partida_codigo` int(11) NOT NULL,
  `partida_monto` decimal(50,2) NOT NULL,
  `id_mbs` int(11) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `id_mot_pp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mot_partidas_presupuestarias`
--

CREATE TABLE `mot_partidas_presupuestarias` (
  `id_mot_pp` int(11) NOT NULL,
  `organismo_financiador` int(11) NOT NULL,
  `saldo` decimal(50,2) NOT NULL,
  `formulario5` int(11) DEFAULT NULL,
  `accion` enum('DE','A') DEFAULT NULL,
  `id_mot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Menu_inicio', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(2, 'Menu_admin_usuario', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(3, 'usuarios', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(4, 'roles', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(5, 'permisos', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(6, 'Menu_gestion', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(7, 'gestion_editar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(8, 'gestion_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(9, 'gestion_crear', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(10, 'gestion_seleccionar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(11, 'gestion_pdes', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(12, 'gestion_pdes_guardar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(13, 'areas_estrategicas_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(14, 'indicador_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(15, 'Menu_configuracion', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(16, 'cua', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(17, 'fuenteDeFinanciamiento', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(18, 'fuenteDeFinanciamiento_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(19, 'tipoFormulado', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(20, 'tipoFormulado_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(21, 'tipoPartida', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(22, 'tipoPartida_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(23, 'clasificadorTipo', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(24, 'clasificadorTipo_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(25, 'clasificadorPrimero', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(26, 'clasificadorPrimero_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(27, 'clasificadorSegundo_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(28, 'clasificadorTercero_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(29, 'clasificadorCuarto_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(30, 'clasificadorQuinto_eliminar', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(31, 'Menu_configuracion_poa', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(32, 'asignar_financiamiento', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(33, 'asignar_formulado', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(34, 'Menu_formulacion_del_Poa', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(35, 'formulacion_poa', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(36, 'reportes_pdf', 'web', '2023-06-03 21:14:04', '2023-06-03 21:14:04'),
(38, 'Menu_formulario_modificacion', 'web', '2025-09-08 19:00:36', '2025-09-12 12:44:27'),
(39, 'Menu_seguimiento', 'web', '2025-09-08 19:06:16', '2025-09-08 19:06:16'),
(40, 'Validar_seguimiento', 'web', '2025-10-06 20:39:21', '2025-10-06 20:39:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_areas_estrategicas`
--

CREATE TABLE `rl_areas_estrategicas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_areas_estrategicas` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_gestion` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_areas_estrategicas`
--

INSERT INTO `rl_areas_estrategicas` (`id`, `codigo_areas_estrategicas`, `descripcion`, `estado`, `id_usuario`, `id_gestion`, `creado_el`, `editado_el`) VALUES
(1, 1, 'FORMACIÓN PROFESIONAL DE GRADO Y POSGRADO', 'activo', 48, 1, '2025-09-08 21:33:37', '2025-09-08 21:33:37'),
(2, 2, 'INVESTIGACIÓN, CIENCIA, TECNOLOGÍA E INNOVACIÓN', 'activo', 48, 1, '2025-09-08 21:33:53', '2025-09-08 21:33:53'),
(3, 3, 'INTERACCION SOCIAL Y EXTENSIÓN UNIVERSITARIA', 'activo', 48, 1, '2025-09-08 21:34:04', '2025-09-08 21:34:04'),
(4, 4, 'GESTIÓN  INSTITUCIONAL', 'activo', 48, 1, '2025-09-08 21:34:22', '2025-09-08 21:34:22');

--
-- Disparadores `rl_areas_estrategicas`
--
DELIMITER $$
CREATE TRIGGER `delete_tri_areas_estrategicas` AFTER DELETE ON `rl_areas_estrategicas` FOR EACH ROW BEGIN
                INSERT INTO tri_areas_estrategicas(accion, id_area_estrategica, ant_codigo_area_estrategica, ant_descripcion, ant_estado, ant_id_usuario, ant_id_gestion, nuevo_codigo_area_estrategica, nuevo_descripcion, nuevo_estado, nuevo_id_usuario, nuevo_id_gestion, fecha)
                VALUES('ELIMINADO', OLD.id, OLD.codigo_areas_estrategicas, OLD.descripcion, OLD.estado, OLD.id_usuario, OLD.id_gestion, NULL, NULL, NULL, NULL, NULL, NOW());
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tri_areas_estrategicas` BEFORE UPDATE ON `rl_areas_estrategicas` FOR EACH ROW BEGIN
                INSERT INTO tri_areas_estrategicas(accion, id_area_estrategica, ant_codigo_area_estrategica, ant_descripcion, ant_estado, ant_id_usuario, ant_id_gestion, nuevo_codigo_area_estrategica, nuevo_descripcion, nuevo_estado, nuevo_id_usuario, nuevo_id_gestion, fecha)
                VALUES('EDITADO', OLD.id, OLD.codigo_areas_estrategicas, OLD.descripcion, OLD.estado, OLD.id_usuario, OLD.id_gestion, NEW.codigo_areas_estrategicas, NEW.descripcion, NEW.estado, NEW.id_usuario, NEW.id_gestion, NOW());
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_articulacion_pdes`
--

CREATE TABLE `rl_articulacion_pdes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo_eje` int(11) NOT NULL,
  `descripcion_eje` text NOT NULL,
  `codigo_meta` varchar(6) NOT NULL,
  `descripcion_meta` text NOT NULL,
  `codigo_resultado` varchar(10) NOT NULL,
  `descripcion_resultado` text NOT NULL,
  `codigo_accion` varchar(8) NOT NULL,
  `descripcion_accion` text NOT NULL,
  `id_gestion` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_articulacion_pdes`
--

INSERT INTO `rl_articulacion_pdes` (`id`, `codigo_eje`, `descripcion_eje`, `codigo_meta`, `descripcion_meta`, `codigo_resultado`, `descripcion_resultado`, `codigo_accion`, `descripcion_accion`, `id_gestion`, `creado_el`, `editado_el`) VALUES
(1, 5, 'GARANTIZAR EL EJERCICIO DEL DERECHO A UNA EDUCACION INTEGRAL. INTERCULTURAL Y PLURILINGUEE CON CALIDAD Y SIN DISCRIMINACIÓN DE RAZA , ORGIEN, GENERO, CREENCIA, Y DISCAPACIDAD EN TODO EL SISTEMA EDUCATIVO PLURINACIONAL', '5.1', 'GARANTIZAR EL EJERCICIO DEL DERECHO A UNA EDUCACION INTEGRAL. INTERCULTURAL Y PLURILINGUEE CON CALIDAD Y SIN DISCRIMINACIÓN DE RAZA , ORGIEN, GENERO, CREENCIA, Y DISCAPACIDAD EN TODO EL SISTEMA EDUCATIVO PLURINACIONAL', '5.1.1', 'GENERAR INCENTIVOS PARA EL ACCESO, PERMANENCIA Y CONCLSUION DE LAS Y LOS ESTUDIANTES', '5.1.1.2', 'GENERAR INCENTIVOS PARA EL ACCESO, PERMANENCIA Y CONCLSUION DE LAS Y LOS ESTUDIANTES', 1, '2025-09-08 21:37:55', '2025-09-12 19:10:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_asignacion_monto_form4`
--

CREATE TABLE `rl_asignacion_monto_form4` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formulario4_id` bigint(20) UNSIGNED NOT NULL,
  `monto_asignado` decimal(50,2) UNSIGNED NOT NULL,
  `financiamiento_tipo_id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_asignacion_monto_form4`
--

INSERT INTO `rl_asignacion_monto_form4` (`id`, `formulario4_id`, `monto_asignado`, `financiamiento_tipo_id`, `fecha`) VALUES
(1, 2, 0.00, 2, '2025-09-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_bienservicio`
--

CREATE TABLE `rl_bienservicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_bienservicio`
--

INSERT INTO `rl_bienservicio` (`id`, `nombre`) VALUES
(1, 'BIEN'),
(2, 'NORMA'),
(3, 'SERVICIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_caja`
--

CREATE TABLE `rl_caja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saldo` decimal(50,2) UNSIGNED NOT NULL,
  `monto` decimal(50,2) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `documento_privado` varchar(100) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `gestiones_id` bigint(20) UNSIGNED NOT NULL,
  `unidad_carrera_id` bigint(20) UNSIGNED NOT NULL,
  `financiamiento_tipo_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_caja`
--

INSERT INTO `rl_caja` (`id`, `saldo`, `monto`, `fecha`, `documento_privado`, `usuario_id`, `gestiones_id`, `unidad_carrera_id`, `financiamiento_tipo_id`) VALUES
(1, 0.00, 109952.00, '2025-09-15', '20250915115618.pdf', 48, 6, 41, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_categoria`
--

CREATE TABLE `rl_categoria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_categoria`
--

INSERT INTO `rl_categoria` (`id`, `nombre`) VALUES
(1, 'PROCESO'),
(2, 'RECURSOS HUMANOS'),
(3, 'RECUROS FINANCIEROS'),
(4, 'PRODUCTO'),
(5, 'RECURSOS FISICOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_cuarto`
--

CREATE TABLE `rl_clasificador_cuarto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_clasificador_tercero` bigint(20) UNSIGNED NOT NULL,
  `modificacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_cuarto`
--

INSERT INTO `rl_clasificador_cuarto` (`id`, `codigo`, `titulo`, `descripcion`, `id_clasificador_tercero`, `modificacion`) VALUES
(1, 11210, 'Categorías Magisterio', NULL, 2, 0),
(2, 11220, 'Bono de Antiguedad', NULL, 2, 0),
(3, 11310, 'Bono de Frontera', 'Se asignarán recursos del 20% del salario básico mensual como bono de frontera, del cual se beneficiarán los (las) servidores (as) y trabajadores (as) del Sector Público, cuyo centro de trabajo se encuentre dentro de los 50 kilómetros lineales de las fronteras internacionales, de acuerdo a normativa vigente.', 3, 0),
(4, 11320, 'Remuneraciones Colaterales Médicas y de Trabajadores en Salud', 'El Ministerio de Salud, Instituciones de la Seguridad Social y los Servicios Departamentales de Salud, podrán asignar recursos en esta partida para el pago de categorías médicas, escalafón médico y riesgo profesional, según las normas legales establecidas.', 3, 0),
(5, 11330, 'Otras Bonificaciones', 'Esta partida podrá ser utilizada únicamente cuando las entidades públicas cuenten con una Ley o Decreto Supremo específico, que autorice el pago del beneficio, cuyo lineamiento se extiende a las Entidades Territoriales Autónomas y Universidades Públicas, conforme a la normativa vigente y garantizando la sostenibilidad financiera.', 3, 0),
(6, 11510, 'Primas', 'Pago adicional anual derivado de la generación de utilidades netas obtenidas anualmente, de acuerdo a normativa vigente', 5, 0),
(7, 11520, 'Bono de Producción', 'Pago adicional anual derivado de mayor productividad per cápita, sobre la participación legal de excedentes financieros que no deben ser resultado de la variación de precios, tasas, tarifas o mejoras tecnológicas, el cual estará calculado de acuerdo a normativa vigente.', 5, 0),
(8, 11810, 'Dietas de Directorio', 'Retribución a los miembros de Directorio que no perciben sueldos y salarios del Sector Público.', 8, 0),
(9, 11820, 'Otras Dietas', 'Retribución a autoridades suplentes del Órgano deliberativo de las Entidades Territoriales Autónomas (ETAs), por la asistencia a sesiones en reemplazo del titular, y otros de acuerdo a normativa vigente.', 8, 0),
(10, 11910, 'Horas Extraordinarias', '', 9, 0),
(11, 11920, 'Vacaciones no Utilizadas', '', 9, 0),
(12, 11930, 'Incentivos Económicos', '', 9, 0),
(13, 11940, 'Suplencias', '', 9, 0),
(14, 13110, 'Régimen de Corto Plazo (Salud)', '', 11, 0),
(15, 13120, 'Prima de Riesgo Profesional Régimen de Largo Plazo', '', 11, 0),
(16, 13130, 'Aporte Patronal Fondo Solidario Régimen de Largo Plazo', '', 11, 0),
(17, 22110, 'Pasajes al Interior del País', 'Gastos por pasajes dentro del territorio nacional, pasajes interdepartamentales y al interior del departamento; incluye gastos por cobro de servicio de terminal aeroportuaria', 24, 1),
(18, 22120, 'Pasajes al Exterior del País', 'Gastos por pasajes al exterior del país; incluye gastos por cobro de servicio de Terminal aeroportuaria y el Impuesto a las Salidas Aéreas al Exterior (ISAE).', 24, 1),
(19, 22210, 'Viáticos por Viajes al Interior del País', '', 25, 1),
(20, 22220, 'Viáticos por Viajes al Exterior del País.', '', 25, 1),
(21, 24110, 'Mantenimiento y Reparación de Inmuebles', '', 34, 1),
(22, 24120, 'Mantenimiento y Reparación de Vehículos, Maquinaria y Equipos', '', 34, 1),
(23, 24130, 'Mantenimiento y Reparación de Muebles y Enseres', '', 34, 1),
(24, 25120, 'Gastos Especializados por Atención Médica y otros', 'Comprende atención médica especializada, estudios, análisis, servicios de laboratorio para investigación, exámenes pre ocupacionales y otros; incluye los gastos por las Prestaciones de Servicios de Salud Integral del Estado Plurinacional de Bolivia.', 37, 1),
(25, 25130, 'Gastos por Afiliación de Estudiantes Universitarios al Seguro Social', '', 37, 1),
(26, 25210, 'Consultorías por Producto', 'Gastos destinados a la contratación de terceros bajo la modalidad de trabajo por producto, cuya relación contractual está sujeta al régimen administrativo; que no forman parte de un proyecto de inversión, constituyendo gastos de funcionamiento o de operación, de acuerdo a normativa vigente. ', 38, 1),
(27, 25220, 'Consultores Individuales de Línea', 'Gastos destinados a consultorías individuales de línea, para trabajos especializados y de apoyo en las actividades propias de la entidad, de acuerdo a normativa vigente.', 38, 1),
(28, 25230, 'Auditorías Externas', 'Gastos destinados a la realización de auditorías externas, revalorización de activos fijos efectuados por terceros, de acuerdo a normativa vigente. Partida que puede ser utilizada en actividades y proyectos de inversión capitalizables y no capitalizables, cuando corresponda. Incluye las auditorias regulatorias', 38, 1),
(29, 25810, 'Consultorías por Producto', 'Gastos por servicios contratados a terceros para la realización de estudios, investigaciones, asistencia técnica y otras actividades técnico profesionales por producto, de acuerdo a normativa vigente, cuando formen parte de proyectos de inversión cuya relación contractual está dentro del marco de los convenios de financiamiento. ', 44, 1),
(30, 25820, 'Consultores Individuales de Línea', 'Gastos en consultores de programas y proyectos de inversión pública que desempeñen actividades técnicas, operativas, administrativa, financiera cuya relación contractual está dentro del marco de los convenios de financiamiento y de acuerdo a normativa vigente. ', 44, 1),
(31, 26610, 'Servicios Públicos', 'Gastos destinados al pago de servicios de seguridad prestados por los Batallones de Seguridad Física dependientes de la Policía Boliviana y por las Fuerzas Armadas a los Altos Dignatarios de Estado, las MAEs y las entidades públicas, conforme a procedimientos establecidos y de acuerdo a normativa vigente.', 49, 1),
(32, 26620, 'Servicios Privados', 'Gastos destinados para la contratación de seguridad privada por aquellas entidades públicas, cuando la demanda exceda la capacidad de los servicios prestados por los Batallones de Seguridad Física de la Policía Boliviana.', 49, 1),
(33, 26630, 'Servicios por Traslado de Valores', 'Gastos destinados al pago de servicios de seguridad y vigilancia efectuado por personas naturales o jurídicas por traslado y custodia de valores.', 49, 1),
(34, 26640, 'Compensación Económica', 'Compensación Económica para miembros de las Fuerzas Armadas y la Policía Boliviana que conforman en el Comando Estratégico Operacional de Lucha Contra el Contrabando y las Actividades Ilícitas y personal operativo del Servicio Aéreo de Seguridad Ciudadana, en función a procedimientos establecidos y normativa vigente.', 49, 1),
(35, 26910, 'Gastos de Representación', 'Se incluyen los gastos de representación autorizados expresamente por las disposiciones legales vigentes.', 51, 1),
(36, 26920, 'Fallas de Caja', 'Gastos por fallas de caja en las instituciones financieras', 51, 1),
(37, 26930, 'Pago por Trabajos Dirigidos y Pasantías', 'Pago de incentivo a estudiantes que cumplen funciones temporales por trabajos dirigidos y pasantías en instituciones públicas de acuerdo a convenios interinstitucionales, así como por trabajos de investigación realizados por estudiantes de las universidades públicas y privadas.', 51, 1),
(38, 26940, 'Compensación Costo de Vida', 'Compensación por costo de vida para servidores públicos que cumplen funciones permanentes en el exterior del país', 51, 1),
(39, 26950, 'Aguinaldo “Esfuerzo por Bolivia”', 'Gasto destinado al pago del Segundo Aguinaldo Esfuerzo por Bolivia, que se asignará cuando el crecimiento anual del Producto Interno Bruto – PIB, supere el cuatro punto cinco por ciento (4.5%).', 51, 1),
(40, 26990, 'Otros', 'Gasto destinado al pago de servicios de terceros, incluye gastos por distribución de boletas de pago, gastos inherentes a procesos electorales y/o registros públicos, gastos específicos de líneas aéreas (según normativa nacional e internacional de aeronáutica civil), servicios de apoyo al deporte y otros que tengan duración definida en actividades propias de la entidad.', 51, 1),
(41, 27110, 'Pago por Costos Incurridos', 'Pago o reposición a las empresas por los costos incurridos en los periodos de prueba, puesta en marcha, prestación de servicios, en operaciones de extracción, transformación, conversión de los recursos naturales de propiedad del Estado Plurinacional conforme a procedimientos establecidos y de acuerdo a normativa vigente.', 52, 1),
(42, 27120, 'Pago por Utilidades', 'Pagos por distribución de utilidades por la prestación de servicios por operaciones de extracción, transformación y conversión de los recursos naturales de propiedad del Estado Plurinacional, de acuerdo a procedimientos establecidos y normativa vigente.', 52, 1),
(43, 31110, 'Gastos por Refrigerios al personal permanente, eventual y consultores individuales de línea de las Instituciones Públicas.', 'Incluye pago por refrigerios al personal de seguridad de la Policía Boliviana, según convenio interinstitucional.', 53, 1),
(44, 31120, 'Gastos por Alimentación y Otros Similares', 'Incluye los efectuados en reuniones, seminarios y otros eventos; así como los gastos por dotación de víveres a la Policía Boliviana y Fuerzas Armadas.', 53, 1),
(45, 31130, 'Alimentación Complementaria Escolar', '', 53, 1),
(46, 31140, 'Alimentación Hospitalaria, Penitenciaria y Otras Específicas', '', 53, 1),
(47, 31150, 'Alimentos y Bebidas para la atención de emergencias y desastres naturales.', '', 53, 1),
(48, 34110, 'Combustibles, Lubricantes y Derivados para consumo', '', 65, 0),
(49, 34120, 'Combustibles, Lubricantes y Derivados para comercialización', '', 65, 0),
(50, 34130, 'Energía Eléctrica para Comercialización', '', 65, 1),
(51, 42210, 'Construcciones y Mejoras de Viviendas', 'Gastos para la construcción y mejoramiento de viviendas y obras complementarias que incrementen el valor de las mismas, tales como rejas, protecciones, garajes, jardines y otros. Incluye el costo de construcción y mejoramiento de viviendas para uso de personal militar o policial.', 87, 1),
(52, 42220, 'Construcciones y Mejoras para Defensa y Seguridad', 'Gastos en infraestructura para la prestación del servicio de defensa y policía. Comprende la construcción y mejoramiento de edificios militares y policiales, cuarteles, aeropuertos, puertos y otras instalaciones militares. No incluye la construcción de viviendas, aun cuando las mismas se destinen a uso del personal militar o policial, la misma deberá ser imputada en la partida 42210 “Construcciones y Mejoras de Viviendas”', 87, 1),
(53, 42230, 'Otras Construcciones y Mejoras de Bienes Públicos de Dominio Privado', 'Gastos realizados en la construcción y mejoramiento de obras públicas del dominio privado tales como: edificios para oficinas públicas, escuelas, hospitales, electrificación, hidroeléctrica, agua potable, alcantarillado sanitario, infraestructura y equipamiento de industrialización de hidrocarburos, gas y minería, redes de distribución de gas, estadios y coliseos deportivos, y otras edificaciones destinadas al desarrollo de actividades comerciales, industriales y de servicios.', 87, 1),
(54, 42240, 'Supervisión de Construcciones y Mejoras de Bienes Públicos de Dominio Privado', 'Gastos realizados en la contratación de terceros para la supervisión de construcciones y mejoras de bienes públicos de dominio privado. Estos gastos se realizan durante la ejecución física de las obras y serán aplicados integralmente al costo total del activo institucional. Incluye los gastos por contratación a terceros para el Control y Monitoreo en proyectos contratados bajo la modalidad llave en mano.', 87, 1),
(55, 42310, 'Construcciones y Mejoras de Bienes de Dominio Público', 'Gastos destinados a la construcción de obras del dominio público tales como: calles, caminos, carreteras, túneles, parques, plazas, monumentos, canales, puentes, sistemas de riego y micro riego, y cualquier otra obra pública construida para utilidad común.', 88, 1),
(56, 42320, 'Supervisión de Construcciones y Mejoras de Bienes de Dominio Público', 'Gastos realizados en la contratación de terceros para la supervisión de construcciones y mejoras de bienes de dominio público. Estos gastos se realizan durante la ejecución física de las obras y serán aplicados integralmente al costo total. Incluye los gastos por contratación a terceros para el Control y Monitoreo en proyectos contratados bajo la modalidad llave en mano.', 88, 1),
(57, 43110, 'Equipo de Oficina y Muebles', 'Gastos para la adquisición de muebles y enseres para el equipamiento de los ambientes de las instituciones públicas.', 91, 1),
(58, 43120, 'Equipo de Computación', 'Gastos para la adquisición de equipos de computación y otros relacionados.', 91, 1),
(59, 43310, 'Vehículos Livianos para Funciones Administrativas', 'Asignaciones destinadas a la adquisición de vehículos livianos para uso administrativo y funciones operativas de las instituciones públicas, incluye: motocicletas, bicicletas, cuadratracks y otros', 93, 1),
(60, 43320, 'Vehículos Livianos para Proyectos de Inversión Pública', 'Asignaciones destinadas a la adquisición de vehículos livianos para uso en la ejecución de proyectos de inversión pública, incluye: motocicletas, bicicletas, cuadratracks y otros.', 93, 1),
(61, 43330, 'Maquinaria y Equipo de Transporte', 'Asignaciones para la adquisición de equipos mecánicos, comprendiendo: equipos de transporte por vía terrestre, equipos ferroviarios, equipos para transporte por vía marítima, lacustre, fluvial, aérea y otros. Comprende además, equipos de tracción, tales como: tractores, autoguías, motoniveladoras y retroexcavadoras. Además de trailers, carretas, cisternas, volquetas, ambulancias, carro para bomberos, plantas asfálticas, grúas para remolcar vehículos, montacargas, remolques de plataforma y equipos de auxiliares de transporte para maniobras de puertos, aeropuertos, almacenes, patios de recepción, despacho de productos y otros no comprendidos en las partidas 43310 y 43320.', 93, 1),
(62, 43340, 'Equipo de Elevación', 'Comprende las asignaciones destinadas a la adquisición de elevadores, ascensores, escaleras mecánicas, y otros.', 93, 1),
(63, 46110, 'Consultoría por Producto para Construcciones de Bienes Públicos de Dominio Privado.', 'Gastos por servicios de terceros contratados por producto para la realización de estudios para proyectos de construcción, de equipamiento y de mejoramiento de bienes públicos de dominio privado.', 98, 1),
(64, 46120, 'Consultoría de Línea para Construcciones de Bienes Públicos de Dominio Privado', 'Gastos por servicios de consultores en proyectos de inversión pública necesarias para la construcción y mejoramiento de bienes públicos de dominio privado que desempeñen actividades técnico - operativas, cuya relación contractual está dentro del marco de los convenios de financiamiento.', 98, 1),
(65, 46210, ' Consultoría por Producto para Construcciones de Bienes Públicos de Dominio Público.', 'Gastos por servicios de terceros contratados por producto para la realización de estudios para proyectos de construcción, de equipamiento y de mejoramiento de bienes de dominio público.', 99, 1),
(66, 46220, 'Consultoría de Línea para Construcciones de Bienes Públicos de Dominio Público', 'Gastos por servicios de consultores en proyectos de inversión pública necesarias para la construcción y mejoramiento de bienes de dominio público que desempeñen actividades técnico - operativas, financieras y administrativas, cuya relación contractual está dentro del marco de los convenios de financiamiento', 99, 1),
(67, 51310, 'Del Gobierno Autónomo Departamental', '', 107, 1),
(68, 51320, 'Del Gobierno Autónomo Municipal', '', 107, 1),
(69, 51330, 'Del Gobierno Autónomo Indígena Originario Campesino', '', 107, 1),
(70, 51340, 'Del Gobierno Autónomo Regional', '', 107, 1),
(71, 52410, 'Gobierno Autónomo Departamental', '', 115, 1),
(72, 52420, 'Gobierno Autónomo Municipal', '', 115, 1),
(73, 52430, 'Gobierno Autónomo Indígena Originario Campesino', '', 115, 1),
(74, 52440, 'Gobierno Autónomo Regional', '', 115, 1),
(75, 53410, 'Gobierno Autónomo Departamental', '', 121, 1),
(76, 53420, 'Gobierno Autónomo Municipal', '', 121, 1),
(77, 53430, 'Gobierno Autónomo Indígena Originario Campesino', '', 121, 1),
(78, 53440, 'Gobierno Autónomo Regional', '', 121, 1),
(79, 55110, 'Letras del Tesoro', '', 133, 1),
(80, 55120, 'Bonos del Tesoro', '', 133, 1),
(81, 55130, 'Otros', '', 133, 1),
(82, 58210, 'Incremento de Documentos por Cobrar a Corto Plazo', '', 141, 1),
(83, 58220, 'Incremento de Otros Activos Financieros a Corto Plazo', '', 141, 1),
(84, 65210, 'Gastos Devengados No Pagados por Servicios No Personales', '', 173, 1),
(85, 65220, 'Gastos Devengados No Pagados por Materiales y Suministros', '', 173, 1),
(86, 65230, 'Gastos Devengados No Pagados por Activos Reales', '', 173, 1),
(87, 65240, 'Gastos Devengados No Pagados por Activos Financieros', '', 173, 1),
(88, 66210, 'Gastos Devengados No Pagados por Servicios No Personales', '', 182, 1),
(89, 66220, 'Gastos Devengados No Pagados por Materiales y Suministros', '', 182, 1),
(90, 66230, 'Gastos Devengados No Pagados por Activos Reales', '', 182, 1),
(91, 66240, 'Gastos Devengados No Pagados por Activos Financieros', '', 182, 1),
(92, 66250, 'Gastos Devengados No Pagados por Servicio de la Deuda', '', 182, 1),
(93, 71210, 'Becas de Estudios Otorgadas a los Servidores Públicos', 'Son los recursos destinados al pago de becas de estudio otorgadas a servidores públicos.', 191, 1),
(94, 71220, 'Becas de Estudios Otorgadas a los Estudiantes Universitarios', 'Recursos destinados al pago de auxiliares de docencia, auxiliares de investigación, internado rotatorio, becas trabajo, trabajo dirigido y otros establecidos por norma.', 191, 1),
(95, 71230, 'Becas de Estudios Otorgadas a Particulares', 'Son los recursos destinados al pago de becas de estudio otorgadas a particulares.', 191, 1),
(96, 71610, 'A Personas e Instituciones Privadas sin Fines de Lucro', '', 194, 1),
(97, 71630, 'Otros de Carácter Social Establecidos por Norma Legal', '', 194, 1),
(98, 72410, 'Para Educación', '', 199, 1),
(99, 72420, 'Otras', '', 199, 1),
(100, 73410, 'Gobierno Autónomo Departamental', '', 204, 1),
(101, 73420, 'Gobierno Autónomo Municipal', '', 204, 1),
(102, 73430, 'Gobierno Autónomo Indígena Originario Campesino', '', 204, 1),
(103, 73440, 'Gobierno Autónomo Regional', '', 204, 1),
(104, 75110, 'En Efectivo', '', 210, 1),
(105, 75120, 'En Especie', '', 210, 1),
(106, 75210, 'A Instituciones Privadas sin Fines de Lucro', '', 211, 1),
(107, 75220, 'Otras de carácter económico – productivo', '', 211, 1),
(108, 77410, 'Al Gobierno Autónomo Departamental', '', 215, 1),
(109, 77440, 'Al Gobierno Autónomo Regional', '', 215, 1),
(110, 77520, 'Por Patentes Petroleras', '', 216, 1),
(111, 77530, 'Otras', '', 216, 1),
(112, 79310, 'Transferencias al Exterior en Efectivo', '', 224, 1),
(113, 79320, 'Transferencias al Exterior en Especie', '', 224, 1),
(114, 83110, 'Bienes Inmuebles', '', 237, 1),
(115, 83120, 'Vehículos Automotores', '', 237, 1),
(116, 84230, '6% Participación TGN', '', 240, 1),
(117, 84240, '11% Sobre Producción por Regalías Departamentales', '', 240, 1),
(118, 84250, '1% Sobre Producción para Regalías Compensatoria Departamental', '', 240, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_primero`
--

CREATE TABLE `rl_clasificador_primero` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `id_clasificador_tipo` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_primero`
--

INSERT INTO `rl_clasificador_primero` (`id`, `codigo`, `titulo`, `descripcion`, `estado`, `id_clasificador_tipo`) VALUES
(1, 10000, 'SERVICIOS PERSONALES', 'Gastos por concepto de servicios prestados por el personal permanente y no permanente, incluyendo el total de remuneraciones; así como los aportes al sistema de previsión social, otros aportes y previsiones para incrementos salariales.', 'activo', 2),
(2, 20000, 'SERVICIOS NO PERSONALES', 'Gastos para atender los pagos por la prestación de servicios de carácter no personal, el uso de bienes muebles e inmuebles de terceros, así como por su mantenimiento y reparación. Incluye asignaciones para el pago de servicios profesionales y comerciales prestados por personas naturales o jurídicas y por instituciones públicas o privadas.', 'activo', 2),
(3, 30000, 'MATERIALES Y SUMINISTROS', 'Comprende la adquisición de artículos, materiales y bienes que se consumen o cambien de valor durante la gestión. Se incluye los materiales que se destinan a conservación y reparación de bienes de capital.', 'activo', 2),
(4, 40000, 'ACTIVOS REALES', 'Gastos para la adquisición de bienes duraderos, construcción de obras por terceros, compra de maquinaria y equipo y semovientes. Se incluyen los estudios, investigaciones y proyectos realizados por terceros y la contratación de servicios de supervisión de construcciones y mejoras de bienes públicos de dominio privado y público, cuando corresponda incluirlos como parte del activo institucional. Comprende asimismo los activos intangibles.', 'activo', 2),
(5, 50000, 'ACTIVOS FINANCIEROS', 'Compra de acciones, participaciones de capital, inversiones, concesión de préstamos de acuerdo a normativa vigente y adquisición de títulos y valores. Incluye el incremento de saldos del activo disponible y exigible, además de los recursos inherentes a fideicomisos.', 'activo', 2),
(6, 60000, 'SERVICIO DE LA DEUDA PUBLICA Y DISMINUCION DE OTROS PASIVOS', 'Asignación de recursos para atender el pago de amortizaciones, intereses, comisiones de corto plazo y largo plazo con residentes (Deuda Interna) y no residentes (Deuda Externa); la disminución de cuentas a pagar de corto plazo y largo plazo, gastos devengados no pagados, disminución de depósitos de Instituciones Financieras; documentos y efectos a pagar y pasivos diferidos. Incluye el pago de beneficios\r\n                sociales', 'activo', 2),
(7, 70000, 'TRANSFERENCIAS', 'Gastos que corresponden a transacciones que no suponen contraprestación en bienes o servicios y cuyos importes no son reintegrados por los beneficiarios. Asimismo, contempla transferencias en el marco de convenios específicos.', 'activo', 2),
(8, 80000, 'IMPUESTOS, REGALIAS Y TASAS', 'Gastos realizados por las instituciones públicas destinados a cubrir el pago de impuestos, regalías, tasas y acuotaciones.', 'activo', 2),
(9, 90000, 'OTROS GASTOS', 'Gastos destinados a intereses por operaciones de las instituciones financieras; beneficios sociales y otros.', 'activo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_quinto`
--

CREATE TABLE `rl_clasificador_quinto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_clasificador_cuarto` bigint(20) UNSIGNED NOT NULL,
  `modificacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_quinto`
--

INSERT INTO `rl_clasificador_quinto` (`id`, `codigo`, `titulo`, `descripcion`, `id_clasificador_cuarto`, `modificacion`) VALUES
(1, 11321, 'Categorías Médicas', '', 4, 0),
(2, 11322, 'Escalafón Médico', '', 4, 0),
(3, 11323, 'Escalafón de los Trabajadores en Salud', 'Dependientes del Subsector Público de Salud, de acuerdo a norma legal vigente.', 4, 0),
(4, 11324, 'Otras Remuneraciones', '', 4, 0),
(5, 11331, 'Pago Variable', '', 5, 0),
(6, 11332, 'Pago Adicional Fijo', '', 5, 0),
(7, 11339, 'Otras Bonificaciones', '', 5, 0),
(8, 13131, ' Aporte Patronal Solidario 3%', '', 16, 0),
(9, 13132, 'Aporte Patronal Minero Solidario 2%', '', 16, 0),
(10, 11212, 'prueba', 'descripcion de prueba', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_segundo`
--

CREATE TABLE `rl_clasificador_segundo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_clasificador_primero` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_segundo`
--

INSERT INTO `rl_clasificador_segundo` (`id`, `codigo`, `titulo`, `descripcion`, `id_clasificador_primero`) VALUES
(1, 11000, 'Empleados Permanentes', 'Remuneraciones al personal regular de cada entidad.', 1),
(2, 12000, 'Empleados No Permanentes', 'Gastos para remunerar los servicios prestados a personas sujetas a contrato en forma transitoria o eventual, para misiones específicas, programas y proyectos de inversión; considerando para el efecto, la equivalencia de funciones y la escala salarial, de acuerdo a normativa vigente.', 1),
(3, 13000, 'Previsión Social', 'Gastos por concepto de aportes patronales a las entidades que administran el Seguro Social Obligatorio.', 1),
(4, 14000, 'Otros', 'Gastos no clasificados anteriormente exentos de aportes de previsión social.', 1),
(5, 15000, 'Previsiones para Incremento de Gastos en Servicios Personales', 'Previsión para creación de ítems, aplicación de incrementos salariales y otros.', 1),
(6, 21000, 'Servicios Básicos', 'Gastos por comunicaciones y servicios necesarios para el funcionamiento de las entidades,proporcionados o producidos por empresas del sector público o privado. ', 2),
(7, 22000, 'Servicios de Transporte y Seguros', 'Gastos por transporte de bienes al interior y exterior del país, transporte de personal, gastos de pasajes y viáticos para personal permanente, eventual y consultores individuales de línea, de acuerdo a contrato establecido, cuando corresponda, facultados por autoridad competente, así como gastos de instalación y retorno de funcionarios destinados en el exterior del país, incluye gastos por contratación de seguros.', 2),
(8, 23000, 'Alquileres', 'Gastos por alquileres de bienes muebles, inmuebles, equipos, maquinarias y otros de propiedad de terceros.', 2),
(9, 24000, 'Instalación, Mantenimiento y Reparaciones', 'Asignaciones destinadas a la conservación de edificios, equipos, vías de comunicación y otros bienes de uso público, así como la conversión de vehículos a gas natural, ejecutados por terceros.', 2),
(10, 25000, 'Servicios Profesionales y Comerciales', 'Gastos por servicios profesionales de asesoramiento especializado, por estudios e investigaciones específicas de acuerdo a normativa vigente. Comprende pagos de comisiones y gastos bancarios, excepto los relativos a la deuda pública. Se incluyen gastos por servicios sanitarios, médicos, sociales, de lavandería, publicidad e imprenta, ejecutados por terceros.', 2),
(11, 26000, 'Otros Servicios No Personales', '', 2),
(12, 27000, 'Gastos por Servicios Especializados por la Actividad Extractiva de Recursos Naturales del Estado Plurinacional ', 'Gastos por actividades especializadas realizadas por terceros en operaciones extractivas, de transformación, de conversión y otros, de los recursos naturales de propiedad del Estado Plurinacional, de acuerdo a normativa vigente.', 2),
(13, 31000, 'Alimentos y Productos Agroforestales', 'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.', 3),
(14, 32000, 'Productos de Papel, Cartón e Impresos', 'Gastos destinados a la adquisición de papel y cartón en sus diversas formas y clases; libros y revistas, textos de enseñanza, compra y suscripción de periódicos.', 3),
(15, 33000, 'Textiles y Vestuario', 'Gastos para la compra de ropa de trabajo, vestuario, uniformes, adquisición de calzados, hilados, telas de lino, algodón, seda, lana, fibras artificiales y tapices, alfombras, sábanas, toallas, sacos de fibras y otros artículos conexos de cáñamo, yute y otros.', 3),
(16, 34000, 'Combustibles, Productos Químicos, Farmacéuticos y Otras Fuentes de Energía', 'Gastos destinados a la compra de combustibles, lubricantes, energía eléctrica, productos químicos y farmacéuticos, llantas, neumáticos y otras.', 3),
(17, 39000, 'Productos Varios', 'Gastos en productos de limpieza, material deportivo, utensilios de cocina y comedor, instrumental menor médico-quirúrgico, útiles de escritorio, de oficina y enseñanza, materiales eléctricos, repuestos y accesorios en general.', 3),
(18, 41000, 'Inmobiliarios', 'Gastos para la adquisición de bienes inmuebles. Comprende la compra de inmuebles, terrenos y otros tipos de activos fijos afines.', 4),
(19, 42000, 'Construcciones', 'Comprende asimismo, los proyectos cuya ejecución están bajo la modalidad de llave en mano, la supervisión contratada de terceros para las construcciones y mejoras de bienes de dominio privado y público. Las partidas de este subgrupo de gasto, pueden ser presupuestadas en proyectos capitalizables y excepcionalmente en proyectos no capitalizables.', 4),
(20, 43000, 'Maquinaria y Equipo', 'Gastos para la adquisición de maquinarias, equipos y aditamentos que se usan o complementan a la unidad principal, comprendiendo: maquinaria y equipo de oficina, de producción, equipos agropecuarios, industriales, de transporte en general, energía, riego, frigoríficos, de comunicaciones, médicos, odontológicos, educativos y otros.', 4),
(21, 46000, 'Estudios y Proyectos para Inversión', 'Gastos para la contratación de estudios y otros realizados por terceros, tales como: la formulación de proyectos, realización de investigaciones y otras actividades técnico - profesionales, cuando corresponda incluir el resultado de estas investigaciones y actividades al activo institucional. Las partidas de este subgrupo de gasto, deberán ser presupuestadas en proyectos capitalizables.', 4),
(22, 49000, 'Otros Activos ', 'Gastos destinados a la adquisición de otros activos no especificados en las partidas anteriores. Incluye los gastos en la compra de activos intangibles, gastos en bienes muebles existentes usados y la adquisición de semovientes y otros animales.', 4),
(23, 51000, 'Compra de Acciones, Participaciones de Capital e Inversiones', 'Aportes de capital directo que generan participación patrimonial o mediante la adquisición de acciones u otros valores representativos del capital de empresas públicas, privadas e internacionales, radicadas en el país o en el exterior, incluye inversiones en instrumentos financieros en el exterior.', 5),
(24, 52000, 'Concesión de Préstamos a Corto Plazo al Sector Público No Financiero', 'Préstamos directos a corto plazo concedidos al Sector Público No Financiero.', 5),
(25, 53000, 'Concesión de Préstamos a Largo Plazo al Sector Público No Financiero', 'Préstamos directos a largo plazo concedidos al Sector Público No Financiero.', 5),
(26, 54000, 'Concesión de Préstamos al Sector Público Financiero y a los Sectores Privado y del Exterior', 'Préstamos directos que se conceden al Sector Público Financiero y a los sectores privado y externo.', 5),
(27, 55000, 'Compra de Títulos y Valores', 'Compra de títulos y valores que representan inversión financiera para las instituciones que realizan la adquisición y pasivos para el ente emisor y, por tanto, no representan participación o propiedad sobre su patrimonio', 5),
(28, 56000, 'Constitución de Fideicomisos y Servicios Financieros', 'Comprende los recursos otorgados para la constitución de fideicomisos y aquellos administrados para el cumplimiento de la finalidad de los mismos y para que las instituciones públicas legalmente facultadas, suscriban contratos de administración y prestación de servicios financieros con entidades de intermediación financiera.', 5),
(29, 57000, 'Incremento de Disponibilidades', 'Aplicaciones financieras que se originan en el incremento neto de los saldos de caja y bancos e inversiones temporales. ', 5),
(30, 58000, 'Incremento de Cuentas y Documentos por Cobrar y Otros Activos Financieros', 'Aplicaciones financieras que se originan en el incremento neto de cuentas del activo exigible a corto y largo plazo documentada y no documentada que constituye una institución pública. Su cálculo es consecuencia de políticas financieras de cobros.', 5),
(31, 59000, 'Afectaciones al Tesoro General de la Nación', 'Afectaciones a las cuentas fiscales del Tesoro General de la Nación y operaciones sin movimiento de efectivo, por transacciones efectuadas por el Tesoro General de la Nación por cuenta de las entidades del sector público y privado.', 5),
(32, 61000, 'Servicio de la Deuda Pública Interna', 'Gastos destinados para atender el servicio de la Deuda Pública con residentes en el país. Incluye el rescate de títulos y valores y la cancelación de préstamos.', 6),
(33, 62000, 'Servicio de la Deuda Pública Externa', 'Gastos destinados para atender el servicio de la Deuda Pública con no residentes en el país. Incluye el rescate de títulos y valores y la cancelación de préstamos.', 6),
(34, 63000, 'Disminución de Cuentas por Pagar a Corto Plazo', 'Aplicaciones financieras que se originan en la disminución neta de saldos de cuentas por pagar a corto plazo, documentada y no documentada que constituye una institución pública con proveedores, contratistas y otros. Su cálculo es el resultado de realizar mayores pagos que gastos devengados en el ejercicio, de tal manera que la política financiera genere una disminución neta de los pasivos. ', 6),
(35, 64000, 'Disminución de Cuentas por Pagar a Largo Plazo', 'Aplicaciones financieras que se originan en la disminución neta de saldos de cuentas por pagar a  largo plazo, documentada y no documentada que tiene una institución pública con proveedores y contratistas.', 6),
(36, 65000, 'Gastos Devengados No Pagados – TGN', 'Asignación de recursos destinados a cubrir gastos devengados en ejercicios anteriores que no han sido cancelados. Se utiliza en el Tesoro General de la Nación.', 6),
(37, 66000, 'Gastos Devengados No Pagados – Otras Fuentes', 'Asignación de recursos destinados a cubrir gastos devengados no pagados en ejercicios anteriores, con recursos diferentes al T.G.N. ', 6),
(38, 67000, 'Obligaciones por Afectaciones al Tesoro General de la Nación', 'Obligaciones por concepto de afectaciones realizadas a las cuentas fiscales del Tesoro General de la Nación y por operaciones sin movimiento de efectivo; así como para el pago del servicio de la deuda pública y disminución de otros pasivos.', 6),
(39, 68000, 'Disminución de Otros Pasivos', 'Asignación de recursos para cubrir el pago de beneficios sociales.', 6),
(40, 69000, 'Devolución de Fondos - Fideicomisos', 'Asignación de recursos para cubrir la devolución de fondos recibidos en fideicomiso de corto y largo plazo realizados por la institución fiduciaria y el pago de recursos recibidos de fideicomisos por la institución beneficiaria.', 6),
(41, 71000, 'Transferencias Corrientes al Sector Privado', 'Transferencias corrientes en efectivo y/o en especie que se otorgan al sector privado de la economía.', 7),
(42, 72000, 'Transferencias Corrientes al Sector Público No Financiero por Participación en Tributos', 'Transferencias corrientes a entidades públicas por participación de recaudaciones tributarias,según el sistema tributario vigente.', 7),
(43, 73000, 'Transferencias Corrientes al Sector Público No Financiero por Subsidios o Subvenciones', 'Transferencias corrientes al Sector Público No Financiero por concepto de subsidios y subvenciones, de acuerdo a disposiciones legales específicas o por acto administrativo del gobierno, destinadas a financiar sus actividades corrientes. Incluye asignaciones para programas y gastos específicos no contemplados en la categoría proyectos. ', 7),
(44, 74000, 'Transferencias Corrientes al Sector Público Financiero', 'Transferencias a entidades del Sector Público Financiero, Bancario y no Bancario, de acuerdo a disposiciones legales específicas o por acto administrativo del gobierno. Incluye asignaciones para programas y gastos específicos no contemplados en la categoría proyectos. ', 7),
(45, 75000, 'Transferencias de Capital al Sector Privado', 'Transferencias de capital en efectivo y/o en especie que tienen por finalidad financiar programas específicos de inversión de personas naturales o jurídicas privadas, de acuerdo a normativa vigente.', 7),
(46, 77000, 'Transferencias de Capital al Sector Público No Financiero por Subsidios o Subvenciones', 'Subsidios o subvenciones a entidades del Sector Público No Financiero, para financiar gastos de capital.', 7),
(47, 78000, 'Transferencias de Capital al Sector Público Financiero', 'Transferencias de capital otorgadas a Instituciones Públicas Financieras, Bancarias y no Bancarias para financiar gastos específicos de capital.', 7),
(48, 79000, ' Transferencias a Gobiernos Extranjeros, Organismos Internacionales y otros', 'Transferencias al exterior que se realizan a gobiernos extranjeros, organismos internacionales o a cualquier otro beneficiario del exterior. Asimismo, incluye transferencias a organismos internacionales en territorio nacional. ', 7),
(49, 81000, 'Renta Interna', 'Gastos realizados por las instituciones públicas destinados a cubrir las obligaciones impositivas.', 8),
(50, 82000, 'Renta Aduanera', 'Gastos realizados por las instituciones públicas destinados a cubrir las obligaciones impositivas\r\n                            por importaciones realizadas.', 8),
(51, 83000, 'Impuestos Municipales', 'Gastos realizados por las entidades públicas destinados a cubrir las obligaciones impositivas por tenencia de bienes inmuebles y vehículos automotores, y las transferencias de estos bienes.', 8),
(52, 84000, 'Regalías', 'Gastos realizados por las instituciones públicas destinados al pago de regalías por la explotación de recursos agropecuarios, yacimientos mineros, petrolíferos y otros.', 8),
(53, 85000, 'Tasas, Multas y Otros', 'Gastos realizados por las instituciones públicas destinados al pago por concepto de tasas, derechos, multas, intereses penales, acuotaciones y otros.', 8),
(54, 86000, 'Patentes', 'Gastos realizados por las entidades públicas destinados a cubrir el costo por el uso y aprovechamiento de bienes de dominio público y la realización de actividades económicas en una determinada jurisdicción territorial.', 8),
(55, 91000, 'Intereses de Instituciones Financieras', 'Gastos por intereses ocasionados por las operaciones regulares de las instituciones financieras; tales como los intereses que pagan los bancos a los ahorristas.', 9),
(56, 94000, 'Beneficios Sociales y Otros', 'Gastos destinados a cubrir el pago por concepto de desahucio y otros de naturaleza similar.', 9),
(57, 95000, 'Contingencias Judiciales', 'Gastos destinados, para cubrir pagos por obligaciones legales y debidamente ejecutoriadas.', 9),
(58, 96000, 'Otras Pérdidas y Devoluciones', 'Otras pérdidas no contempladas en las partidas anteriores que suelen ocurrir en las instituciones, como ser: pérdidas por operaciones cambiarias. Incluye devoluciones de impuestos, tasas, multas, regalías cuyos pagos se hayan realizado en exceso y correspondan a gestiones anteriores.', 9),
(59, 97000, 'Comisiones y Bonificaciones', 'Representan gastos por comisiones y bonificaciones a terceros por la venta de bienes o servicios.', 9),
(60, 98000, 'Retiros de Capital', 'Apropiación por concepto de retiros de capital, tanto del sector público como privado.', 9),
(61, 99000, 'Provisiones para Gastos Corrientes y de Capital', '', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_tercero`
--

CREATE TABLE `rl_clasificador_tercero` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_clasificador_segundo` bigint(20) UNSIGNED NOT NULL,
  `modificacion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_tercero`
--

INSERT INTO `rl_clasificador_tercero` (`id`, `codigo`, `titulo`, `descripcion`, `id_clasificador_segundo`, `modificacion`) VALUES
(1, 11100, 'Haberes Básicos', 'Remuneración básica percibida por el personal del Magisterio Fiscal, la cual debe estar determinada de acuerdo a la Escala Salarial aprobada. Se utilizará únicamente para programar el pago de haberes básicos y horas acumuladas del Magisterio Fiscal.', 1, 0),
(2, 11200, 'Bono de Antigüedad', 'Remuneración determinada por la calificación de años de servicios prestados por el servidor público. Asimismo, incluye la asignación de recursos para el pago del Escalafón Docente.', 1, 0),
(3, 11300, 'Bonificaciones', 'Remuneraciones complementarias al haber básico debiendo detallar en las planillas presupuestarias para fines de ejecución y control.', 1, 0),
(4, 11400, 'Aguinaldos', 'Remuneración extraordinaria anual conforme a las disposiciones legales en vigencia.', 1, 0),
(5, 11500, 'Primas y Bono de Producción', 'Retribución anual en las instituciones públicas, cuyo pago está sujeto a las utilidades anuales netas obtenidas y excedentes financieros de acuerdo a normativa vigente.', 1, 0),
(6, 11600, 'Asignaciones Familiares', 'Se asignarán recursos para el pago de subsidios de prenatal, natalidad, lactancia y sepelio, de acuerdo a normativa vigente.', 1, 0),
(7, 11700, 'Sueldos', 'Esta partida será utilizada para asignar el sueldo o haber básico mensual de los servidores públicos sobre la base de la escala salarial vigente, aprobada de acuerdo a normativa vigente', 1, 0),
(8, 11800, 'Dietas', 'Retribuciones a los miembros de Directorios, por asistencia a reuniones ordinarias o extraordinarias y en el caso de los Concejos Municipales, Asambleístas suplentes (Departamentales y Regionales) de acuerdo a normativa vigente. Por ser miembros de algún Directorio, los Servidores Públicos que perciben sus honorarios con recursos públicos, no pueden ser beneficiarios del pago de dietas.', 1, 0),
(9, 11900, 'Otros Servicios Personales', 'Gastos no clasificados en las anteriores partidas del grupo de servicios personales, incluye: sobre tiempo por horas extraordinarias trabajadas, asignaciones por vacaciones no utilizadas al personal retirado, incentivos económicos y otras asignaciones destinadas por ejemplo a la diferencia de haberes por suplencia temporal en un cargo de mayor jerarquía, cuando corresponda de acuerdo a normativa vigente.', 1, 0),
(10, 12100, 'Personal Eventual', '', 2, 0),
(11, 13100, 'Aporte Patronal al Seguro Social', 'Gastos por concepto de aportes patronales en favor del Seguro Social Obligatorio, considerando lo siguiente: 10% Seguro de Corto Plazo, 1.71% riesgos profesionales, 3% aporte patronal solidario y 2% aporte patronal solidario minero, cuando corresponda, de acuerdo a normativa vigente.', 3, 0),
(12, 13200, ' Aporte Patronal para Vivienda', '', 3, 0),
(13, 14100, 'Otros', '', 4, 0),
(14, 15100, 'Incremento Salarial', 'Previsión de recursos para incremento salarial.', 5, 0),
(15, 15200, 'Crecimiento Vegetativo', '', 5, 0),
(16, 15300, 'Creación de Ítems', '', 5, 0),
(17, 15400, 'Otras Previsiones', '', 5, 0),
(18, 21100, 'Comunicaciones', 'Gastos por servicios de correos, televisión por cable y otros, excepto servicios telefónicos, que poseen partida específica.', 6, 1),
(19, 21200, 'Energía Eléctrica', 'Gastos por consumo de energía eléctrica, independientemente de la fuente de suministro.', 6, 1),
(20, 21300, 'Agua', 'Gastos por consumo de agua, independientemente de la fuente de suministro.', 6, 1),
(21, 21400, 'Telefonía', 'Gastos destinados al pago de llamadas telefónicas locales, al interior y al exterior del país, así como el pago tarifario mensual y el servicio de fax, incluye la telefonía móvil, de acuerdo a normativa vigente.', 6, 1),
(22, 21500, 'Gas Domiciliario', 'Gastos destinados al pago del servicio de gas.', 6, 1),
(23, 21600, 'Internet', 'Gastos por servicios de internet, videoconferencias, transmisión de datos, dominio en páginas web y otros inherentes a este servicio, utilizados exclusivamente en entidades públicas.', 6, 1),
(24, 22100, 'Pasajes', 'Gastos por servicios de transporte: aéreo, terrestre y marítimo, por viaje de personal permanente, eventual y consultores individuales de línea, de acuerdo a contrato establecido, cuando corresponda, al interior y exterior del país. Incluye gastos por cobro de servicio de Terminal Aeroportuaria y el Impuesto a las Salidas Aéreas al Exterior (ISAE).', 7, 1),
(25, 22200, 'Viáticos', 'Gastos destinados a cubrir el alojamiento y manutención del personal que se encuentre  en misión oficial, sea permanente, eventual y/o consultores individuales de línea, de acuerdo a contrato establecido, cuando corresponda.', 7, 1),
(26, 22300, 'Fletes y Almacenamiento', 'Gastos por concepto de fletes: terrestres, aéreos y marítimos, por transporte y almacenamiento de bienes y equipos en general, incluye los de carga y descarga y otros relacionados.', 7, 1),
(27, 22400, 'Gastos de Instalación y Retorno', 'Gastos por concepto de instalación y retorno del personal diplomático, agentes aduaneros y otros funcionarios destinados en el exterior, de acuerdo a normativa vigente.', 7, 1),
(28, 22500, 'Seguros', 'Gastos por contratación de seguros para personas, equipos, vehículos, muebles, inmuebles, instalaciones, producción, equipos satelitales y otros. Incluye el pago por franquicias.', 7, 1),
(29, 22600, 'Transporte de Personal', 'Gastos destinados al traslado de personal en Comisión de las Instituciones Públicas,incluye el traslado de personal para realizar funciones operativas. Además de gastos por la entrega y recepción de documentación, efectuados por personal de servicios o mensajería. ', 7, 1),
(30, 23100, 'Alquiler de Inmuebles', 'Gastos por uso de inmuebles destinados a oficinas, escuelas y otros.', 8, 1),
(31, 23200, 'Alquiler de Equipos y Maquinarias', 'Gastos por el uso de equipos y maquinarias, tales como: equipos electrónicos, equipos médicos, de sonido, audiovisuales, maquinaria agrícola, de construcción, fijas o portables, vehículos, aeronaves, vagones, elevadores, mezcladoras y otros.', 8, 1),
(32, 23300, 'Alquiler de Tierras y Terrenos', 'Gastos que se originan por la utilización de tierras y terrenos de propiedad de terceros.', 8, 1),
(33, 23400, 'Otros Alquileres', 'Alquileres no especificados en las partidas anteriores, como derechos de aterrizajes, alquileres de semovientes, de garajes, tinglados, ambientes no destinados a oficinas y otros. Incluye alquileres de muebles y enseres', 8, 1),
(34, 24100, 'Mantenimiento y Reparación de Inmuebles, muebles y Equipos', 'Gastos para atender el mantenimiento y reparación de inmuebles, incluyendo el pago de expensas comunes, muebles, enseres, equipos de oficina, médicos, sanitarios, comunicación, tracción, transporte, elevación, perforación y otros que son ejecutados por terceros', 9, 1),
(35, 24200, 'Mantenimiento y Reparación de Vías de Comunicación', 'Gastos destinados al mantenimiento y conservación de caminos, carreteras, autopistas, puentes, vías férreas y fluviales, aeródromos y otros ejecutados por terceros.', 9, 1),
(36, 24300, 'Otros Gastos por Concepto de Instalación, Mantenimiento y Reparación', 'Gastos para la conservación de obras no clasificadas anteriormente, tales como: urbanísticas, hidráulicas, sanitarias, agropecuarias, tribunas para espectáculos, estantes para exposiciones. Incluye gastos por mantenimiento y reparación de componentes de aeronaves, instalación de gas domiciliario, redes de datos y redes eléctricas internas, soporte técnico, mantenimiento y actualización de software, instalaciones satelitales y otras ejecutadas por terceros.', 9, 1),
(37, 25100, 'Médicos, Sanitarios y Sociales', 'Gastos por contratación de terceros para servicios especializados como atención médica y análisis clínicos, servicios de laboratorios para investigación, pago de suscripciones a instituciones de Normalización de Calidad, pago de Certificaciones de Calidad para Laboratorios y otros.', 10, 1),
(38, 25200, 'Estudios, Investigaciones, Auditorías Externas y Revalorizaciones', 'Gastos por servicios de terceros contratados para la realización de estudios, investigaciones, auditorías externas y revalorizaciones de activos fijos y otras actividades técnico profesionales, de acuerdo a la normativa vigente, que pueden formar parte de un proyecto de inversión, constituyendo gastos de funcionamiento o de operación.', 10, 1),
(39, 25300, 'Comisiones y Gastos Bancarios', 'Gastos por servicios que prestan las instituciones bancarias y de intermediación financiera. Se excluyen los relacionados con la Deuda Pública.', 10, 1),
(40, 25400, 'Lavandería, Limpieza e Higiene', 'Gastos por servicios de lavandería, limpieza, higiene y fumigación de bienes y lugares públicos, realizados por terceros.', 10, 1),
(41, 25500, 'Publicidad', 'Gastos por concepto de avisos, pautas publicitarias y difusión de información en: radiodifusoras, televisión, periódicos, internet (incluye redes sociales, páginas web, blogs, aplicaciones y otros similares), contratos publicitarios y promociones por algún medio de difusión, incluye material promocional, informativo, gigantografías, imagen institucional y/o comercial, y otros relacionados', 10, 1),
(42, 25600, 'Servicios de Imprenta, Fotocopiado y Fotográficos', 'Gastos que se realizan por trabajos de: diseño, diagramación, impresión, compaginación, encuadernación, fotocopias y otros efectuados por terceros. Incluye los gastos por revelado, y copiado de fotografías, slides y otros.', 10, 1),
(43, 25700, 'Capacitación del Personal', 'Gastos por servicios destinados a la capacitación y adiestramiento de personal permanente, eventual y consultores individuales de línea, de acuerdo a contrato establecido, cuando corresponda, en cursos de formación o instrucción, que son necesarios para la actividad de la entidad. Comprende inscripciones, matrículas, cuotas, en cursos, seminarios y otros.', 10, 1),
(44, 25800, 'Estudios e Investigaciones para Proyectos de Inversión No Capitalizables', 'Gastos por servicios de terceros contratados para la realización de estudios,investigaciones, asistencia técnica y otras actividades técnico profesionales, cumpliendo la normativa vigente, cuando formen parte de proyectos de inversión relacionados con fortalecimiento institucional, medio ambiente, educación, salud, asistencia social y otros que no se concretan en la generación de activos reales. Esta partida deberá presupuestarse solamente en proyectos no capitalizables.', 10, 1),
(45, 25900, 'Servicios Manuales ', 'Gastos ocasionales destinados al pago de servicios de terceros como: albañilería, carpintería, herrería, cerrajería, plomería, jardinería, estibadores y otros servicios manuales. Estos servicios no son recurrentes ni propios de la entidad.', 10, 1),
(46, 26200, 'Gastos Judiciales', 'Gastos que se realizan como consecuencia de acciones judiciales, incluye servicios notariales y otros relacionados. ', 11, 1),
(47, 26300, 'Derechos sobre Bienes Intangibles', 'Gastos que se realizan por la utilización de bienes, tales como derechos de autor, licencias y uso de bienes y activos de propiedad industrial, comercial o intelectual. Incluye certificaciones digitales.', 11, 1),
(48, 26500, 'Conjueces y Jueces Ciudadanos', 'Gastos destinados al pago de conjueces y jueces ciudadanos de acuerdo a normativa vigente.', 11, 1),
(49, 26600, 'Servicio de Seguridad de los Batallones de Seguridad Física de la Policía Boliviana, las  Fuerzas Armadas y Vigilancia Privada', 'Gastos destinados al pago de servicios de seguridad prestados por los Batallones de Seguridad Física dependientes de la Policía Boliviana y por las Fuerzas Armadas. Incluye gastos para el pago de Servicios de Vigilancia Privada, como también para el pago de Servicios de Seguridad de transporte de valores.', 11, 1),
(50, 26700, 'Servicios de Laboratorios Especializados', 'Gastos a terceros por la prestación de servicios de laboratorio especializado para la industria, incluye estudios, análisis, normalización de calidad y otros.', 11, 1),
(51, 26900, 'Otros Servicios No Personales', 'Gastos por conceptos no clasificados en las partidas anteriores.', 11, 1),
(52, 27100, 'Servicios por la Extracción, Transformación y Conversión de los Recursos Naturales de Propiedad del Estado Plurinacional.', 'Gastos por servicios de terceros contratados por instituciones y empresas públicas, para la realización de trabajos especializados en la actividad extractiva, transformación, conversión y otros, de los recursos naturales de propiedad del Estado Plurinacional', 12, 1),
(53, 31100, 'Alimentos y Bebidas para Personas, Desayuno Escolar y Otros', 'Gastos destinados al pago de comida y bebida en establecimientos hospitalarios, penitenciarios, de orfandad, cuarteles, aeronaves y para el personal de seguridad según convenio interinstitucional; incluye pago de refrigerio: al personal permanente, eventual y consultores individuales de línea de cada entidad, por procesos electorales, emergencias y/o desastres naturales; así como almuerzos o cenas de trabajo según disposición legal, desayuno escolar y otros relacionados de acuerdo a normativa vigente', 13, 1),
(54, 31200, 'Alimentos para Animales', 'Gastos destinados a la adquisición de forrajes y otros alimentos para animales de propiedad de instituciones públicas; alimentación de los animales de propiedad del Ejército y de la Policía Boliviana, parques zoológicos, laboratorios de experimentación y otros.', 13, 1),
(55, 31300, 'Productos Agrícolas, Pecuarios y Forestales', 'Gastos para la adquisición de granos básicos, frutas y flores silvestres, goma, caña, semillas y otros productos agroforestales y agropecuarios en bruto; además, gastos por concepto de adquisición de maderas de construcción, puertas, ventanas, vigas, callapos, durmientes manufacturados o no, y todo otro producto proveniente de esta rama, incluido carbón vegetal. Incluye gastos por la compra de ganado y otros animales vivos, destinados al consumo, repoblamiento, mejoramiento genético o para usos industriales y científicos; incluye productos derivados de los mismos, como ser leche, huevos, lana, miel, pieles y otros.', 13, 1),
(56, 32100, 'Papel', 'Gastos destinados a la adquisición de papel de escritorio y otros.', 14, 0),
(57, 32200, 'Productos de Artes Gráficas', 'Gastos para la adquisición de productos de artes gráficas y otros relacionados. Incluye gastos destinados a la adquisición de artículos hechos de papel y cartón.', 14, 1),
(58, 32300, 'Libros, Manuales y Revistas', 'Gastos destinados a la adquisición de libros, manuales y revistas para bibliotecas y oficinas.', 14, 1),
(59, 32400, 'Textos de Enseñanza', 'Gastos destinados a la compra de libros para uso docente.', 14, 1),
(60, 32500, 'Periódicos y Boletines', 'Gastos para la compra y suscripción de periódicos y boletines, incluye gacetas oficiales.', 14, 1),
(61, 33100, 'Hilados, Telas, Fibras y Algodón', 'Gastos destinados para la compra de hilados y telas de lino, algodón, seda, lana y fibras artificiales, no utilizados aún en procesos de confección.', 15, 1),
(62, 33200, 'Confecciones Textiles', 'Gastos destinados a la adquisición de tapices, alfombras, sábanas, toallas, sacos de fibras, colchones, carpas, cortinas y otros textiles similares.', 15, 1),
(63, 33300, 'Prendas de Vestir', 'Gastos destinados a la adquisición de uniformes, vestimenta de diversos tipos, ropa de trabajo, distintivos y accesorios, independientemente del material de fabricación y otras de seguridad industrial de trabajo establecidas por disposiciones en vigencia', 15, 1),
(64, 33400, 'Calzados', 'Gastos destinados a la compra de calzados o zapatos complementarios de uniformes y los de uso exclusivo de servidores públicos que, por razones de seguridad industrial de trabajo establecidas por disposiciones en vigencia.', 15, 1),
(65, 34100, 'Combustibles, Lubricantes, Derivados y otras Fuentes de Energía', 'Gastos para la adquisición de petróleo crudo y parcialmente refinado, gasolina, kerosene, alcohol, aceites, grasas, fuel-oil, diésel, alquitrán, energía eléctrica y otros, como gas y cemento asfáltico. Se excluye la compra de leña y carbón.', 16, 0),
(66, 34200, 'Productos Químicos y Farmacéuticos', 'Gastos para la adquisición de compuestos químicos, tales como ácidos, sales, bases industriales, oxígeno, salitres, calcáreos, pinturas, colorantes, pulimentos; abonos y fertilizantes destinados a labores agrícolas; insecticidas, fumigantes y otros utilizados en labores agropecuarias; medicamentos e insumos para hospitales, clínicas, policlínicas y dispensarios, incluyendo productos básicos para botiquines y los utilizados en veterinaria.', 16, 1),
(67, 34300, 'Llantas y Neumáticos', 'Gastos destinados a la compra de aros, llantas y neumáticos para utilización en los equipos de tracción, transporte y elevación.', 16, 1),
(68, 34400, 'Productos de Cuero y Caucho', 'Gastos destinados a la compra de cueros, pieles, curtidos y sin curtir; maletines, portafolios y otros artículos confeccionados con cuero; además de artículos elaborados con caucho, excepto prendas de vestir, llantas y cámaras de aire.', 16, 1),
(69, 34500, 'Productos de Minerales no Metálicos y Plásticos', 'Gastos por la adquisición de productos de arcilla como macetas, floreros, ceniceros, adornos y otros. Comprende además productos de vidrio como floreros, adornos y vidrio plano. Productos elaborados en loza y porcelana como ser: jarros, inodoros, lavamanos y otros. Adquisición de cemento, cal y yeso para construcción, remodelación o mantenimiento de edificaciones públicas. Compra de tubos sanitarios, bloques, tejas y otros productos elaborados con cemento.', 16, 1),
(70, 34600, 'Productos Metálicos', 'Gastos destinados a la adquisición de lingotes, planchas, planchones, hojalata, perfiles, alambres, varillas y otros, siempre que sean de hierro o acero. Incluye productos elaborados con base en aluminio, cobre, zinc, bronce y otras aleaciones; además de envases y otros artículos de hojalata, ferretería, estructuras metálicas acabadas y demás productos metálicos. Se excluye la compra de repuestos y/o accesorios de un activo.', 16, 1),
(71, 34700, 'Minerales', 'Gastos destinados a la adquisición de estaño, plomo, oro, plata, wólfram, zinc y otros minerales metálicos; carbón mineral en todas sus variedades; piedra, arcilla, arena y grava para la construcción en general, además de diversos metaloides.', 16, 1),
(72, 34800, 'Herramientas Menores', 'Gastos para la adquisición de herramientas y equipos menores para uso agropecuario, industrial, de transporte, de construcción, tales como destornilladores, alicates, martillos, tenazas, serruchos, picos, palas, tarrajas y otras herramientas menores no activables.', 16, 1),
(73, 34900, 'Material y Equipo Militar', 'Gastos a ser efectuados por los Ministerios de Defensa y Gobierno para la adquisición de material y equipo militar de tipo fungible. Así como por las Entidades Territoriales Autónomas para equipos de protección individual para la Policía Boliviana, de acuerdo a normativa vigente', 16, 1),
(74, 39100, 'Material de Limpieza e Higiene', 'Gastos destinados a la adquisición de materiales como jabones, detergentes, desinfectantes, paños, ceras, cepillos, escobas y otros.', 17, 1),
(75, 39200, 'Material Deportivo y Recreativo', 'Gastos destinados a la adquisición de material deportivo. Incluye las compras para proveer material deportivo a las delegaciones deportivas destacadas dentro y fuera del país en representación oficial. Se incluye, además, el material destinado a usos recreativos. Se exceptúan las adquisiciones para donaciones a servidores públicos del Estado Plurinacional o personas del sector privado, de acuerdo a normativa vigente.', 17, 1),
(76, 39300, 'Utensilios de Cocina y Comedor', 'Gastos destinados a la adquisición de menaje de cocina y vajilla de comedor a ser utilizada en hospitales, hogares de niños, asilos y otros.', 17, 1),
(77, 39400, 'Instrumental Menor Médico-Quirúrgico', 'Gastos destinados a la compra de estetoscopios, termómetros, probetas, desfibriladores, además de material y útiles menores médicos quirúrgicos utilizados en hospitales, clínicas, establecimientos de salud, veterinarias, líneas aéreas y demás dependencias médicas del sector público. Incluye implementos de bioseguridad.', 17, 1),
(78, 39500, 'Útiles de Escritorio y Oficina', 'Gastos destinados a la adquisición de útiles de escritorio como ser: tintas, lápices, bolígrafos, engrapadoras, perforadoras, calculadoras, medios magnéticos, tóner para impresoras y fotocopiadoras y otros destinados al funcionamiento de oficinas.', 17, 1),
(79, 39600, 'Útiles Educacionales, Culturales y de Capacitación', 'Gastos destinados a la compra de útiles y materiales de apoyo educacional, cultural y de capacitación.', 17, 1),
(80, 39700, 'Útiles y Materiales Eléctricos', 'Gastos para la adquisición de focos, cables eléctricos y de transmisión de datos, sockets, tubos fluorescentes, accesorios de radios, lámparas de escritorio, electrodos, planchas, linternas, conductores, aisladores, fusibles, baterías, pilas, interruptores, conmutadores, enchufes y otros relacionados.', 17, 1),
(81, 39800, 'Otros Repuestos y Accesorios', 'Gastos destinados a la compra de repuestos y accesorios para los equipos comprendidos en el Subgrupo 43000. Se exceptúan las llantas y neumáticos y los clasificados en las partidas anteriores', 17, 1),
(82, 39900, 'Otros Materiales y Suministros', 'Gastos por acuñación de monedas e impresión de billetes, vituallas por atención de emergencias, desastres naturales y todos aquellos materiales y suministros que no se clasificaron en las partidas anteriores.', 17, 1),
(83, 41100, 'Edificios', 'Gastos destinados a la adquisición de edificios. El concepto “edificio\" incluye todas las instalaciones unidas permanentemente y que forman parte del mismo, las cuales no pueden instalarse o removerse sin romper las paredes, techos o pisos de la edificación.', 18, 1),
(84, 41200, 'Tierras y Terrenos', 'Gastos para la adquisición de tierras y terrenos, cualquiera sea su destino. Ejemplo: terrenos para edificaciones escolares, construcción de vías, edificios, expropiaciones y otros', 18, 1),
(85, 41300, 'Otras Adquisiciones', 'Gastos destinados a la adquisición de inmuebles no contemplados en las partidas anteriores', 18, 1),
(86, 42200, 'Construcciones y Mejoras de Bienes Públicos Nacionales de Dominio Privado', 'Comprende las construcciones y mejoras que se incorporan al patrimonio institucional de las entidades públicas. Se incluye la contratación de terceros para la supervisión de obras, cuando su costo pueda ser determinado en forma separada de la construcción y mejora de bienes públicos de dominio privado.', 19, 1),
(87, 42300, 'Construcciones y Mejoras de Bienes Nacionales de Dominio Público', 'Comprende las construcciones y mejoras en infraestructura física que no pueden ser enajenadas por tratarse de bienes de dominio público. Se incluye la contratación de terceros para la supervisión de obras cuando su costo pueda ser determinado en forma separada de la construcción y mejora de bienes de dominio público.', 19, 1),
(88, 42400, 'Construcciones y Mejoras de Bienes Públicos Nacionales de Dominio Privado - Llave en Mano', 'Comprende las construcciones y mejoras de bienes públicos de dominio privado, que se incorporan al patrimonio institucional de las Entidades públicas ejecutadas bajo la modalidad LLave en Mano que incluye: estudios, infraestructura, supervisión, equipamiento, capacitación, transferencia de tecnología, puesta en marcha, mantenimiento por el periodo de garantías y otros, establecidos en el contrato de ejecución.', 19, 1),
(89, 42500, 'Construcciones y Mejoras de Bienes Públicos Nacionales de Dominio Público - Llave en Mano', 'Comprende las construcciones y mejoras de bienes públicos de dominio público, ejecutadas bajo la modalidad LLave en Mano que incluye: estudios, infraestructura, supervisión, equipamiento, capacitación, transferencia de tecnología, puesta en marcha, mantenimiento por el periodo de garantías y otros, establecidos en el contrato de ejecución', 19, 1),
(90, 43100, 'Equipo de Oficina y Muebles', 'Gastos para la adquisición de muebles, equipos de computación, fotocopiadoras, relojes para control, equipos biométricos, mesas para dibujo y otros.', 20, 1),
(91, 43200, 'Maquinaria y Equipo de Producción', 'Gastos para la adquisición de maquinaria y equipo de producción, que comprende: equipos agropecuarios e industriales destinados a la producción de bienes, permitiendo la transformación de materias primas en productos acabados o semielaborados y otros.', 20, 1),
(92, 43300, 'Equipo de Transporte, Tracción y Elevación', 'Gastos para la adquisición de equipos mecánicos, comprendiendo: equipos de transporte por vía terrestre, equipos ferroviarios, equipos para transporte por vía marítima, lacustre y fluvial, equipos para transporte por vía aérea. Comprende además, equipos de tracción, tales como: tractores, auto guías, montacargas, motoniveladoras, además de motocicletas, bicicletas, tráiler y carretas. Asimismo, se incluye equipos de elevación, transformación de vehículos automotores a gas natural vehicular y otros', 20, 1),
(93, 43400, 'Equipo Médico y de Laboratorio', 'Gastos para la adquisición de equipos médicos, odontológicos, sanitarios y de investigación, tales como: mesas de operación, bombas de cobalto, aparatos de rayos X, equipos de rayos laser, resonancia magnética, tomógrafos, hemodiálisis, instrumental mayor médico-quirúrgico, compresoras, sillones, aparatos de prótesis, microscopios, centrifugadoras, refrigeradores especiales, laboratorios bioquímicos, esterilizadores, amplímetros, teodolitos, cubicadores, balanzas de precisión, detectores de minerales, telescopios y otros.', 20, 1),
(94, 43500, 'Equipo de Comunicación', 'Gastos destinados a la adquisición de equipos para la transmisión y recepción de datos, como ser: plantas transmisoras, receptores de radios, equipo de televisión, vídeo y audio, aparatos telegráficos, teletipos y aparatos de radio; incluye instalaciones como: torres de transmisión, equipos utilizados en aeronavegación y actividades marítimas y lacustres, equipos de posicionamiento y medición (GPS), centrales telefónicas, aparatos telefónicos, equipos de telefonía IP, antenas de comunicación Wi-Fi, Access Point, redes de área amplia, equipos de vigilancia y otros relacionados', 20, 1),
(95, 43600, 'Equipo Educacional y Recreativo', 'Gastos en bienes duraderos destinados a la enseñanza y a la recreación, comprenden aparatos audiovisuales, tales como: proyectores, micrófonos y otros. Además incluye equipos recreativos: carruseles, aparatos para parques infantiles y equipo menor de gimnasia, muebles especializados para uso escolar, tales como: pupitres, pizarrones y globos terráqueos. Se excluye mobiliario como sillas, mesas y anaqueles, aun estando destinadas para uso docente.', 20, 1),
(96, 43700, 'Otra Maquinaria y Equipo', 'Gastos para la adquisición de maquinaria y equipo especializados no contemplados en las partidas anteriores, incluye ventiladores y/o extractores de aire, calentadores de ambiente, enceradoras, refrigeradores, cocinas, aspiradoras, cámaras fotográficas digitales, cámaras de video digital, equipos para maniobra en aeropuertos y otros.', 20, 1),
(97, 46100, 'Para Construcciones de Bienes Públicos de Dominio Privado', 'Gastos por servicio de terceros contratados para la realización de investigaciones y otras actividades técnico - profesionales, necesarias para la construcción y mejoramiento de bienes Públicos de dominio privado.', 21, 1),
(98, 46200, 'Para Construcciones de Bienes de Dominio Público', 'Gastos por servicio de terceros contratados para la realización de investigaciones y otras actividades técnico - profesionales, necesarias para la construcción y mejoramiento de bienes de dominio público. ', 21, 1),
(99, 46300, 'Consultoría para capacitación, transferencia de tecnología y organización para procesos productivos, en proyectos de Inversión específicos.', 'Gastos por servicios de terceros contratados para la realización de eventos de capacitación, transferencia de tecnología y organización para procesos productivos, cuya relación contractual está dentro del marco de los convenios de financiamiento.', 21, 1),
(100, 49100, 'Activos Intangibles', 'Gastos destinados a la adquisición de derechos y licencias para el uso de bienes, activos de la propiedad industrial, comercial, intelectual y otros. Asimismo, incluye la adquisición y actualización de versiones de programas de computación.', 22, 1),
(101, 49300, 'Semovientes y Otros Animales', 'Gastos destinados a la adquisición de ganado de diferentes especies y todo tipo de animales adquiridos con fines ornamentales, de reproducción o de trabajo.', 22, 1),
(102, 49400, 'Activos Museológicos y Culturales', 'Gastos destinados a la adquisición y/o restauración de activos museológicos y culturales, que no son depreciables.', 22, 1),
(103, 49900, 'Otros', 'Gastos destinados a la adquisición de otros activos no descritos anteriormente. Incluye objetos valiosos y bibliotecas, no depreciables.', 22, 1),
(104, 51100, 'Acciones y Participaciones de Capital en Empresas Privadas Nacionales', 'Gastos destinados a la adquisición de acciones y participaciones de capital en empresas privadas nacionales, incluye acciones y certificados de aportación en cooperativas telefónicas.', 23, 1),
(105, 51200, 'Acciones y Participaciones de Capital en Empresas Públicas Nacionales', 'Gastos destinados a la adquisición de acciones y participaciones de capital en empresas públicas nacionales.', 23, 1),
(106, 51300, 'Acciones y Participaciones de Capital en Empresas Públicas Territoriales', 'Gastos destinados a la adquisición de acciones y participaciones de capital en empresas territoriales.', 23, 1),
(107, 51500, 'Acciones y Participaciones de Capital en Instituciones Públicas Financieras No Bancarias', 'Gastos destinados a la adquisición de acciones y participaciones de capital en Instituciones Públicas Financieras no Bancarias.', 23, 1),
(108, 51600, 'Acciones y Participaciones de Capital en Instituciones Públicas Financieras Bancarias', 'Gastos destinados a la adquisición de acciones y participaciones de capital en Instituciones Financieras Bancarias.', 23, 1),
(109, 51700, 'Acciones y Participaciones de Capital en Organismos Internacionales', 'Gastos destinados a la adquisición de acciones y participaciones de capital en Organismos Internacionales.', 23, 1),
(110, 51800, 'Otras Acciones y Participaciones de Capital en el Exterior', 'Gastos destinados a la adquisición de otras acciones y participaciones de capital realizadas en el exterior.', 23, 1),
(111, 51900, 'Inversiones en el Exterior', 'Recursos destinados para realizar inversiones en instrumentos financieros en el exterior, de acuerdo a normativa vigente.', 23, 1),
(112, 52100, 'Concesión de Préstamos a Corto Plazo a los Órganos del Estado Plurinacional', '', 24, 1),
(113, 52200, 'Concesión de Préstamos a Corto Plazo a Instituciones Públicas Descentralizadas', '', 24, 1),
(114, 52400, 'Concesión de Préstamos a Corto Plazo a Entidades Territoriales Autónomas', '', 24, 1),
(115, 52600, 'Concesión de Préstamos a Corto Plazo a Instituciones de Seguridad Social', '', 24, 1),
(116, 52700, 'Concesión de Préstamos a Corto Plazo a Empresas Públicas Nacionales', '', 24, 1),
(117, 52800, 'Concesión de Préstamos a Corto Plazo a Empresas Públicas Territoriales', '', 24, 1),
(118, 53100, 'Concesión de Préstamos a Largo Plazo a los Órganos del Estado Plurinacional', '', 25, 1),
(119, 53200, 'Concesión de Préstamos a Largo Plazo a Instituciones Públicas Descentralizadas', '', 25, 1),
(120, 53400, 'Concesión de Préstamos a Largo Plazo a Entidades Territoriales Autónomas', '', 25, 1),
(121, 53600, 'Concesión de Préstamos a Largo Plazo a Instituciones de Seguridad Social', '', 25, 1),
(122, 53700, 'Concesión de Préstamos a Largo Plazo a Empresas Públicas Nacionales', '', 25, 1),
(123, 53800, ' Concesión de Préstamos a Largo Plazo a Empresas Públicas Territoriales', '', 25, 1),
(124, 54100, 'Concesión de Préstamos a Corto Plazo a Instituciones Públicas Financieras No Bancarias', '', 26, 1),
(125, 54200, 'Concesión de Préstamos a Corto Plazo a Instituciones Públicas Financieras Bancarias', '', 26, 1),
(126, 54300, 'Concesión de Préstamos a Corto Plazo al Sector Privado', '', 26, 1),
(127, 54400, 'Concesión de Préstamos a Corto Plazo al Exterior', '', 26, 1),
(128, 54600, 'Concesión de Préstamos a Largo Plazo a Instituciones Públicas Financieras No Bancarias', '', 26, 1),
(129, 54700, 'Concesión de Préstamos a Largo Plazo a Instituciones Públicas Financieras Bancarias', '', 26, 1),
(130, 54800, 'Concesión de Préstamos a Largo Plazo al Sector Privado', '', 26, 1),
(131, 54900, 'Concesión de Préstamos a Largo Plazo al Exterior', '', 26, 1),
(132, 55100, 'Títulos y Valores a Corto Plazo', 'Adquisición de títulos y valores a corto plazo.', 27, 1),
(133, 55200, 'Títulos y Valores a Largo Plazo', 'Adquisición de títulos y valores a largo plazo', 27, 1),
(134, 56100, 'Colocación de Fondos en Fideicomiso', '', 28, 1),
(135, 56200, 'Concesiones de Recursos de Fideicomisos', '', 28, 1),
(136, 56300, 'Colocación de Fondos por Servicios Financieros', '', 28, 1),
(137, 57100, 'Incremento de Caja y Bancos', 'Aplicaciones financieras que se originan en el incremento neto de saldos de caja y bancos. Resulta de comparar los saldos iniciales y finales de caja y bancos que están determinados por las magnitudes de recibos y pagos de las instituciones públicas.', 29, 1),
(138, 57200, 'Incremento de Inversiones Temporales', 'Aplicaciones financieras que se originan en el incremento neto de saldos de inversiones temporales. Esta cuenta indica las variaciones del nivel de colocaciones que realizan las tesorerías como consecuencia de la existencia de superávit temporal de caja.', 29, 1),
(139, 58100, 'Incremento de Cuentas por Cobrar a Corto Plazo', 'Aplicaciones financieras que se originan en el incremento neto de saldos de las cuentas por cobrar a corto plazo.', 30, 1),
(140, 58200, 'Incremento de Documentos por Cobrar y Otros Activos Financieros a Corto Plazo', 'Aplicaciones financieras que se originan en el incremento neto de saldos de documentos y efectos por cobrar y otros activos financieros a corto plazo. Incluye las variaciones netas de saldos de anticipos financieros, activos diferidos y débitos por apertura de cartas de crédito a corto plazo.', 30, 1),
(141, 58300, 'Incremento de Cuentas por Cobrar a Largo Plazo', 'Aplicaciones financieras que se originan en el incremento neto de saldos de las cuentas por cobrar a largo plazo.', 30, 1),
(142, 58400, 'Incremento de Documentos por Cobrar y Otros Activos Financieros a Largo Plazo', 'Aplicaciones financieras que se originan en el incremento neto de saldos de documentos\r\n                                        y efectos por cobrar y otros activos financieros a largo plazo. Incluye las variaciones de\r\n                                        saldos de anticipos financieros, activos diferidos y débitos por apertura de cartas de\r\n                                        crédito a largo plazo.', 30, 1),
(143, 59100, 'Afectaciones al Tesoro General de la Nación', '', 31, 1),
(144, 61100, 'Amortización de la Deuda Pública Interna a Corto Plazo', '', 32, 1),
(145, 61200, 'Intereses de la Deuda Pública Interna a Corto Plazo', '', 32, 1),
(146, 61300, 'Comisiones y Otros Gastos de la Deuda Pública Interna a Corto Plazo', '', 32, 1),
(147, 61400, 'Intereses por Mora y Multas de la Deuda Pública Interna a Corto Plazo', '', 32, 1),
(148, 61600, 'Amortización de la Deuda Pública Interna a Largo Plazo', '', 32, 1),
(149, 61700, 'Intereses de la Deuda Pública Interna a Largo Plazo', '', 32, 1),
(150, 61800, 'Comisiones y Otros Gastos de la Deuda Pública Interna a Largo Plazo', '', 32, 1),
(151, 61900, 'Intereses por Mora y Multas de la Deuda Pública Interna a Largo Plazo', '', 32, 1),
(152, 62100, 'Amortización de la Deuda Pública Externa a Corto Plazo', '', 33, 1),
(153, 62200, 'Intereses de la Deuda Pública Externa a Corto Plazo', '', 33, 1),
(154, 62300, 'Comisiones y Otros Gastos de la Deuda Pública Externa a Corto Plazo', '', 33, 1),
(155, 62400, 'Intereses por Mora y Multas de la Deuda Pública Externa a Corto Plazo', '', 33, 1),
(156, 62600, 'Amortización de la Deuda Pública Externa a Largo Plazo', '', 33, 1),
(157, 62700, 'Intereses de la Deuda Pública Externa a Largo Plazo', '', 33, 1),
(158, 62800, 'Comisiones y Otros Gastos de la Deuda Pública Externa a Largo Plazo', '', 33, 1),
(159, 62900, 'Intereses por Mora y Multas de la Deuda Pública Externa a Largo Plazo', '', 33, 1),
(160, 63100, 'Disminución de Cuentas por Pagar a Corto Plazo por Deudas Comerciales con Proveedores', '', 34, 1),
(161, 63200, 'Disminución de Cuentas por Pagar a Corto Plazo con Contratistas', '', 34, 1),
(162, 63300, 'Disminución de Cuentas por Pagar a Corto Plazo por Sueldos y Jornales', '', 34, 1),
(163, 63400, 'Disminución de Cuentas por Pagar a Corto Plazo por Aportes Patronales', '', 34, 1),
(164, 63500, 'Disminución de Cuentas por Pagar a Corto Plazo por Retenciones', '', 34, 1),
(165, 63600, 'Disminución de Cuentas por Pagar a Corto Plazo por Impuestos, Regalías y Tasas', '', 34, 1),
(166, 63700, 'Disminución de Cuentas por Pagar a Corto Plazo por Jubilaciones y Pensiones', '', 34, 1),
(167, 63800, 'Disminución de Cuentas por Pagar a Corto Plazo por Intereses', '', 34, 1),
(168, 63900, 'Disminución de Otros Pasivos y Otras Cuentas por Pagar a Corto Plazo', 'Aplicaciones financieras que se originan en la disminución neta de saldos de otros pasivos y otras cuentas por pagar a corto plazo. Incluye las variaciones netas de saldos de depósitos a la vista, depósitos en caja de ahorro y a plazo fijo de las instituciones financieras y la disminución neta de documentos y efectos comerciales por pagar, otros documentos y pasivos diferidos a corto plazo. ', 34, 1),
(169, 64100, 'Disminución de Cuentas por Pagar a Largo Plazo por Deudas Comerciales', 'Aplicaciones financieras que se originan en la disminución neta de saldos de cuentas por pagar a largo plazo que tiene una institución pública por deudas comerciales con proveedores. ', 35, 1),
(170, 64200, 'Disminución de Otras Cuentas por Pagar a Largo Plazo', 'Aplicaciones financieras que se originan en la disminución neta de saldos de otras cuentas por pagar a largo plazo. Incluye las variaciones netas de saldos de documentos y efectos comerciales por pagar, otros documentos por pagar y pasivos diferidos a largo plazo. ', 35, 1),
(171, 65100, 'Gastos Devengados No Pagados por Servicios Personales', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados en ejercicios anteriores por concepto de servicios personales que no han sido cancelados.', 36, 1),
(172, 65200, 'Gastos Devengados No Pagados por Servicios No Personales, Materiales y Suministros, Activos Reales y Financieros ', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados en ejercicios anteriores por concepto de servicios no personales, materiales y suministros, activos reales y activos financieros que no han sido cancelados.', 36, 1),
(173, 65300, 'Gastos Devengados No Pagados por Transferencias', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados en ejercicios anteriores por concepto de transferencias que no han sido canceladas', 36, 1),
(174, 65400, 'Gastos Devengados No Pagados por Retenciones', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de retenciones no canceladas, en favor de acreedores', 36, 1),
(175, 65500, 'Gastos Devengados No Pagados por Intereses Deuda Pública Interna', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de intereses de Deuda Pública Interna no canceladas', 36, 1),
(176, 65600, 'Gastos Devengados No Pagados por Intereses Deuda Pública Externa', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de intereses de Deuda Pública Externa no canceladas.', 36, 1),
(177, 65700, 'Gastos Devengados No Pagados por Comisiones Deuda Pública Interna', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de comisiones de Deuda Pública Interna no canceladas.', 36, 1),
(178, 65800, 'Gastos Devengados No Pagados por Comisiones Deuda Pública Externa', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de comisiones de Deuda Pública Externa no canceladas.', 36, 1),
(179, 65900, 'Otros Gastos Devengados No Pagados', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados y no pagados en ejercicios anteriores, por conceptos no incorporados en las partidas anteriores.', 36, 1),
(180, 66100, 'Gastos Devengados No Pagados por Servicios Personales', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados no pagados en ejercicios anteriores, por concepto de servicios personales.', 37, 1),
(181, 66200, 'Gastos Devengados No Pagados por Servicios No Personales, Materiales y Suministros, Activos Reales y Financieros, y Servicio de la Deuda', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados no pagados en ejercicios anteriores por concepto de servicios no personales, materiales y suministros, activos reales y activos financieros, y servicio de la deuda.', 37, 1),
(182, 66300, 'Gastos Devengados No Pagados por Transferencias', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados no pagados en ejercicios anteriores, por concepto de transferencias.', 37, 1),
(183, 66400, 'Gastos Devengados No pagados por Retenciones', 'Asignación de recursos destinados a cubrir obligaciones generadas en ejercicios anteriores por concepto de retenciones no canceladas, en favor de acreedores.', 37, 1),
(184, 66900, 'Otros Gastos No Pagados', 'Asignación de recursos destinados a cubrir obligaciones generadas por gastos devengados no pagados en ejercicios anteriores, por conceptos no incorporados en las partidas anteriores.', 37, 1),
(185, 67100, 'Obligaciones por Afectaciones al Tesoro General de la Nación', '', 38, 1),
(186, 68200, 'Pago de Beneficios Sociales', 'Asignación de recursos para cubrir el pago efectivo realizado por las entidades del sector público a favor de sus servidores públicos, por concepto de beneficios sociales, de acuerdo a la normativa vigente.', 39, 1),
(187, 69100, 'Devolución de Fondos - Fideicomiso de Corto Plazo', 'Asignación de recursos para cubrir la devolución de fondos recibidos en fideicomiso de corto plazo realizados por la institución fiduciaria.', 40, 1),
(188, 69200, 'Devolución de Fondos - Fideicomiso de Largo Plazo', 'Asignación de recursos para cubrir la devolución de fondos recibidos en fideicomiso de largo plazo realizados por la institución fiduciaria.', 40, 1),
(189, 71100, 'Pensiones y Jubilaciones', 'Créditos asignados para gastos por concepto de pensiones y jubilaciones y otros de la misma naturaleza.', 41, 1),
(190, 71200, 'Becas', 'Becas de estudios otorgadas a servidores públicos, estudiantes universitarios y particulares.', 41, 1),
(191, 71300, 'Donaciones, Ayudas Sociales y Premios a Personas', 'Donaciones, ayudas y premios de tipo social, de acuerdo a normativa vigente.', 41, 1),
(192, 71500, 'Subsidios a Personas ó Instituciones Privadas', 'Subsidios a personas ó Instituciones Privadas que realizan actividades de producción agrícola, de acuerdo a normativa vigente.', 41, 1),
(193, 71600, 'Subsidios y Donaciones a Personas e Instituciones Privadas sin Fines de Lucro', 'Subvenciones destinadas a Instituciones privadas sin fines de lucro, a efecto de auxiliar y estimular la actividad que éstas realizan, y otros de acuerdo a normativa vigente.', 41, 1),
(194, 71700, 'Subvenciones Económicas a Empresas', 'Recursos destinados para financiar las operaciones o gastos financieros de empresas del sector privado.', 41, 1),
(195, 71800, 'Pensiones Vitalicias', 'Transferencias a beneméritos de guerra, personajes notables y otras pensiones concedidas de acuerdo a normativa vigente.', 41, 1),
(196, 71900, 'Transferencias por las Compras de Control Tributario', 'Transferencias por concepto de la ejecución de operativos de control, a través de la  modalidad de Compras de Control, que por su naturaleza no pueden ser devueltos a los sujetos pasivos o terceros, los mismos que son transferidos a entidades de beneficencia o asistencia social.', 41, 1),
(197, 72200, 'Transferencias Corrientes a Instituciones Públicas Descentralizadas, Universidades Públicas por Participación en Tributos', 'Transferencias a Instituciones Públicas Descentralizadas, Universidades Públicas por participaciones en tributos, de acuerdo a normativa vigente.', 42, 1),
(198, 72400, 'Transferencias Corrientes al Gobierno Autónomo Departamental por Participación en Tributos', 'Transferencias al Gobierno Departamental por participación en tributos, de acuerdo a normativa vigente.', 42, 1),
(199, 72500, 'Transferencias Corrientes a los Gobiernos Autónomos Municipales e Indígena Originario Campesino por Participación en Tributos', 'Transferencias por participación en tributos, de acuerdo a normativa vigente.', 42, 1),
(200, 73100, 'Transferencias Corrientes al Órgano Ejecutivo del Estado Plurinacional por Subsidios o Subvenciones', '', 43, 1),
(201, 73200, 'Transferencias Corrientes a los Órganos Legislativo, Judicial y Electoral, Entidades de Control y Defensa, Descentralizadas y Universidades por Subsidios o Subvenciones ', '', 43, 1),
(202, 73300, 'Transferencias Corrientes del Fondo Compensatorio Nacional de Salud', 'Transferencias del Ministerio de Salud, a los Gobiernos Autónomos Municipales e Indígena Originario Campesino, a objeto de apoyar el financiamiento de las prestaciones de servicios de salud integral, de acuerdo a normativa vigente.', 43, 1),
(203, 73400, 'Transferencias Corrientes a Entidades Territoriales Autónomas por Subsidios o Subvenciones', '', 43, 1),
(204, 73600, ' Transferencias Corrientes a Instituciones de Seguridad Social por Subsidios o Subvenciones', '', 43, 1),
(205, 73700, 'Transferencias Corrientes a Empresas Públicas Nacionales por Subsidios o Subvenciones', '', 43, 1),
(206, 73800, 'Transferencias Corrientes a Empresas Públicas de las Entidades Territoriales Autónomas por Subsidios o Subvenciones', '', 43, 1),
(207, 74100, 'Transferencias Corrientes a Instituciones Públicas Financieras No Bancarias', '', 44, 1),
(208, 74200, 'Transferencias Corrientes a Instituciones Públicas Financieras Bancarias', '', 44, 1),
(209, 75100, 'Transferencias de Capital a Personas', 'Transferencias a personas naturales que tengan por destino financiar las adquisiciones de equipos, construcciones u otros activos.', 45, 1),
(210, 75200, 'Transferencias de Capital a Instituciones Privadas sin Fines de Lucro', 'Transferencias a Instituciones Privadas sin fines de lucro que tienen por destino financiar la adquisición de equipos, construcciones, inversiones financieras u otros gastos de capital. Incluye transferencias para programas y proyectos de desarrollo económico, productivo y social, de acuerdo a normativa vigente.', 45, 1),
(211, 75300, 'Transferencias de Capital a Empresas Privadas', 'Transferencias a empresas privadas que tengan por destino financiar la adquisición de equipos, construcciones, proveer fondos para inversiones financieras u otros gastos de capital.', 45, 1),
(212, 77100, 'Transferencias de Capital al Órgano Ejecutivo del Estado Plurinacional por Subsidios o Subvenciones', '', 46, 1),
(213, 77200, 'Transferencias de Capital a los Órganos Legislativo, Judicial y Electoral, Entidades de Control y Defensa, Descentralizadas y Universidades por Subsidios o Subvenciones', '', 46, 1),
(214, 77400, ' Transferencias de Capital a las Entidades Territoriales Autónomas por Subsidios o Subvenciones', '', 46, 1),
(215, 77500, 'Transferencias de Capital a los Gobiernos Autónomos Municipales e Indígena Originario Campesino por Subsidios o Subvenciones', '', 46, 1),
(216, 77600, 'Transferencias de Capital a Instituciones de Seguridad Social por Subsidios o Subvenciones', '', 46, 1),
(217, 77700, 'Transferencias de Capital a Empresas Públicas Nacionales por Subsidios o Subvenciones', '', 46, 1),
(218, 77800, 'Transferencias de Capital a Empresas Públicas de las Entidades Territoriales Autónomas por Subsidios o Subvenciones', '', 46, 1),
(219, 78100, 'Transferencias de Capital a Instituciones Públicas Financieras No Bancarias', '', 47, 1),
(220, 78200, 'Transferencias de Capital a Instituciones Públicas Financieras Bancarias', '', 47, 1),
(221, 79100, 'Transferencias Corrientes a Gobiernos Extranjeros y Organismos Internacionales por Cuotas Regulares', 'Transferencias efectuadas a Organismos Internacionales por cuotas establecidas de acuerdo con el carácter de Estado Miembro o por participación en una organización internacional determinada como: PNUD, UNICEF, OIT, CIAT, etc.', 48, 1),
(222, 79200, 'Transferencias Corrientes a Gobiernos Extranjeros y Organismos Internacionales por Cuotas Extraordinarias', 'Transferencias efectuadas a Organismos Internacionales por cuotas extraordinarias acordadas y de acuerdo con el carácter de Estado Miembro. Incluye también, transferencias extraordinarias a gobiernos extranjeros, de acuerdo con convenios establecidos.', 48, 1),
(223, 79300, 'Otras Transferencias Corrientes al Exterior ', 'Se refiere a otras transferencias corrientes efectuadas al exterior, no contempladas en las partidas anteriores, incluye donaciones y ayudas de tipo social en efectivo y/o especie, que no revisten carácter permanente a organismos extranjeros, de acuerdo a normativa vigente.\r\n                                        ', 48, 1),
(224, 79400, 'Transferencias de Capital al Exterior', 'Transferencias que se realizan a favor de gobiernos u organismos del exterior, que tienen por destino financiar gastos de capital, incluye donaciones.', 48, 1);
INSERT INTO `rl_clasificador_tercero` (`id`, `codigo`, `titulo`, `descripcion`, `id_clasificador_segundo`, `modificacion`) VALUES
(225, 79500, 'Transferencias a Organismos Internacionales', 'Transferencias efectuadas a organismos internacionales en territorio nacional en el marco de las Leyes N° 018 de 16 de junio de 2010 “del Órgano Electoral Plurinacional” y N° 1266 de 24 de noviembre de 2019, “de Régimen Excepcional y Transitorio para la Realización de Elecciones Generales” y convenios específicos, que coadyuven en materia de registros civil y electoral; así como en la ejecución de procesos electorales', 48, 1),
(226, 81100, 'Impuesto sobre las Utilidades de las Empresas', 'Créditos destinados al pago de impuestos a las utilidades de las empresas, de acuerdo a normativa vigente. Incluye las utilidades de las empresas mineras. ', 49, 1),
(227, 81200, 'Impuesto a las Transacciones', 'Créditos destinados al pago de impuestos sobre los ingresos brutos devengados durante el período fiscal por el ejercicio de industria, comercio, oficio, negocio, alquiler de bienes, ejecución de obras o prestación de servicios de cualquier índole, sean éstas lucrativas o no, de acuerdo a normativa vigente', 49, 1),
(228, 81300, 'Impuesto al Valor Agregado Mercado Interno', 'Créditos destinados al pago del Impuesto al Valor Agregado (IVA), por concepto de venta de mercancías en general, contratos de obra, servicios técnicos y profesionales, servicios públicos y privados, alquileres y otros tipos de ingresos, realizados con agentes económicos residentes en el país.', 49, 1),
(229, 81400, 'Impuesto al Valor Agregado Importaciones', 'Créditos destinados al pago del Impuesto al Valor Agregado (IVA), por concepto de importación de mercancías en general.', 49, 1),
(230, 81500, 'Impuesto a los Consumos Específicos Mercado Interno', 'Créditos destinados al pago de impuestos por la producción o consumo de bebidas alcohólicas, alcoholes, cigarrillos y tabacos, vehículos automóviles y otras establecidas por norma legal vigente, realizadas en el país.', 49, 1),
(231, 81600, 'Impuesto a los Consumos Específicos Importaciones', 'Créditos destinados al pago de impuestos por la importación de cigarrillos y tabacos, bebida no alcohólicas y alcohólicas, alcoholes sin desnaturalizar y vehículos automóviles.', 49, 1),
(232, 81700, 'Impuesto Especial a los Hidrocarburos y sus Derivados Mercado Interno', 'Créditos destinados a las empresas comercializadoras de hidrocarburos para el pago del impuesto especial a los Hidrocarburos y sus derivados de importaciones', 49, 1),
(233, 81800, 'Impuesto Especial a los Hidrocarburos y sus Derivados Importación ', 'Créditos destinados a las empresas comercializadoras de hidrocarburos para el pago de impuestos especial a los Hidrocarburos y sus derivados de importación.', 49, 1),
(234, 81900, 'Otros Impuestos', 'Créditos destinados a cubrir otros impuestos no detallados anteriormente', 49, 1),
(235, 82100, 'Gravamen Arancelario', 'Créditos destinados al pago del gravamen sobre el valor de las importaciones CIF Frontera o CIF Aduana que ingresen a recintos aduaneros, de acuerdo al medio de transporte utilizado.', 50, 1),
(236, 83100, 'Impuesto a la Propiedad de Bienes', 'Créditos destinados al pago de los impuestos a la propiedad de bienes inmuebles y vehículos automotores situados o registrados en el territorio nacional, recaudados por las municipalidades en cuya jurisdicción se encuentren situados o registrados los mismos, de acuerdo a normativa tributaria vigente.', 51, 1),
(237, 83200, 'Impuesto a las Transferencias onerosas de bienes inmuebles y vehículos automotores', 'Créditos destinados al pago del impuesto que grava a la transferencia de bienes inmuebles y vehículos automotores, de acuerdo a normativa vigente.', 51, 1),
(238, 84100, 'Regalías Mineras', 'Créditos destinados al pago de regalías por la explotación de yacimientos mineros.', 52, 1),
(239, 84200, 'Regalías por Hidrocarburos', 'Créditos destinados al pago de regalías por la explotación de yacimientos petrolíferos.', 52, 1),
(240, 84300, 'Regalías Agropecuarias', 'Créditos destinados al pago de regalías por la explotación de recursos agropecuarios.', 52, 1),
(241, 84900, 'Otras Regalías', 'Créditos destinados al pago de regalías por la explotación de otros recursos no descritos anteriormente', 52, 1),
(242, 85100, 'Tasas', 'Créditos destinados al pago por la prestación efectiva de un servicio público individualizado en el contribuyente, como el arancel de derechos reales, peajes, valores fiscales, servicio civil y otros', 53, 1),
(243, 85200, 'Derechos', 'Créditos destinados al pago por la prestación efectiva de derechos administrativos, como ser matrículas e inscripciones en instituciones públicas y otros.', 53, 1),
(244, 85300, 'Contribuciones por Mejoras', 'Créditos destinados al pago para la ejecución de obras de mejoramiento público.', 53, 1),
(245, 85400, 'Multas', 'Créditos destinados al pago por concepto de penas pecuniarias originadas en el incumplimiento del ordenamiento legal vigente.', 53, 1),
(246, 85500, 'Intereses Penales', 'Créditos destinados al pago de penas pecuniarias debido a la falta de pago o pago atrasado por la entrega de un bien o la prestación de un servicio público.', 53, 1),
(247, 85900, 'Otros', 'Créditos destinados al pago de otros conceptos no clasificados anteriormente, incluye el pago de presentación de planillas salariales al Registro Obligatorio de Empleadores – ROE, y acuotaciones a la ASFI. ', 53, 1),
(248, 86100, 'Patentes', '', 54, 1),
(249, 91100, 'Intereses de Instituciones Públicas Financieras no Bancarias', 'Gastos por intereses ocasionados por las operaciones regulares financieras que realizan las Instituciones Financieras no Bancarias.', 55, 1),
(250, 91200, 'Intereses de Instituciones Públicas Financieras Bancarias', 'Gastos por intereses ocasionados por las operaciones regulares financieras que realizan las Instituciones Financieras Bancarias.', 55, 1),
(251, 94100, 'Indemnización', 'Asignación de recursos destinados a cubrir pagos por concepto de retiros, de acuerdo a normativa vigente.', 56, 1),
(252, 94200, 'Desahucio', 'Asignación de recursos destinados a cubrir pagos por concepto derivado del incumplimiento del preaviso de retiro, de acuerdo a normativa vigente.', 56, 1),
(253, 94300, 'Otros Beneficios Sociales', 'Son otros gastos relacionados con beneficios sociales no contemplados en las partidas anteriores, de acuerdo a normativa vigente.', 56, 1),
(254, 95100, 'Contingencias Judiciales', 'Gastos que se originan en obligaciones legales y debidamente ejecutoriadas. No incluye gastos correspondientes a servicios judiciales.', 57, 1),
(255, 96100, 'Pérdidas en Operaciones Cambiarias', 'Pérdidas en operaciones que se realizan con divisas extranjeras y con mantenimiento de valor, por incremento o disminución del tipo de cambio.', 58, 1),
(256, 96200, 'Devoluciones', 'Comprende gastos por devoluciones en general tales como impuestos, tasas, multas, regalías, patentes, y otros pagados en exceso en gestiones anteriores. Incluye devoluciones por concepto de incapacidad temporal, la devolución de recursos monetizables y no monetizables al organismo financiador o entidad del Sector Público, y otras devoluciones enmarcadas en las actividades de las entidades públicas. No incluye las devoluciones de impuestos clasificados como CEDEIM.', 58, 1),
(257, 96900, 'Otras Pérdidas', 'Incorpora otras pérdidas no consideradas en las partidas anteriores.', 58, 1),
(258, 97100, 'Comisiones por Ventas', 'Apropiación por concepto de comisión en ventas que realizan las instituciones.', 59, 1),
(259, 97200, 'Bonificaciones por Ventas', 'Apropiación por concepto de bonificaciones en ventas que realizan las instituciones en sus operaciones.', 59, 1),
(260, 98100, 'Del Sector Público', 'Apropiaciones para retiros de las instituciones públicas.', 60, 1),
(261, 98200, 'Del Sector Privado', 'Apropiaciones para retiros de las instituciones privadas', 60, 1),
(262, 98300, 'Pago de Dividendos', 'Gastos emergentes de la distribución de utilidades generadas en el periodo anterior a accionistas por participación y aporte de capital en empresas del sector público, de acuerdo a normativa vigente.', 60, 1),
(263, 99100, 'Provisiones para Gastos de Capital', 'Provisiones de recursos para financiar gastos de capital.', 61, 1),
(264, 99200, 'Provisiones para Gastos Corrientes', 'Provisiones de recursos para financiar contingencias y otros gastos corrientes', 61, 1),
(265, 12100, 'gg', 'gg', 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_clasificador_tipo`
--

CREATE TABLE `rl_clasificador_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_clasificador_tipo`
--

INSERT INTO `rl_clasificador_tipo` (`id`, `titulo`, `descripcion`, `estado`) VALUES
(1, 'CLASIFICADOR DE RECURSOS POR RUBROS', 'El Clasificador de Recursos por Rubros, permite identificar el origen de los recursos públicos de las entidades públicas, agrupadas en categorías homogéneas en función a la naturaleza jurídica, actividades económicas y carácter de las transacciones que le dan el origen de los mismos, destinadas a la ejecución de las políticas públicas del Estado y sus instituciones.', 'activo'),
(2, 'CLASIFICADOR POR OBJETO DEL GASTO', 'El Clasificador de Objeto del Gasto, permite identificar los insumos que se requieren para el proceso de producción de bienes, servicios, normas, activos y pasivos financieros, de manera ordenada, sistemática y homogénea, que se utilizan para la prestación de servicios públicos y realización de transferencias, destinadas a la ejecución de las políticas públicas del Estado y sus instituciones públicas, en el marco de la normativa vigente.', 'activo'),
(3, 'CLASIFICADOR DE GASTOS POR FINALIDAD Y FUNCIÓN', 'El Clasificador de Gastos por Finalidad y Función, permite identificar el gasto según la naturaleza de los bienes y servicios que produce y presta el Estado a la población, plasmando la finalidad del gasto compuesta por diferentes funciones que permitirán llegar a un fin, logrando determinar los objetivos generales y los medios a través de los cuales se estiman alcanzar los mismos, constituyéndose como un instrumento fundamental para la toma de decisiones en la asignación de los recursos en la ejecución de las políticas públicas del Estado y sus instituciones públicas', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_configuracion_formulado`
--

CREATE TABLE `rl_configuracion_formulado` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicial` date NOT NULL,
  `fecha_final` date NOT NULL,
  `codigo` char(10) NOT NULL,
  `gestiones_id` bigint(20) UNSIGNED DEFAULT NULL,
  `formulado_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_configuracion_formulado`
--

INSERT INTO `rl_configuracion_formulado` (`id`, `fecha_inicial`, `fecha_final`, `codigo`, `gestiones_id`, `formulado_id`, `estado`) VALUES
(1, '2025-08-18', '2026-08-18', '0140', 6, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_detalleClasiCuarto`
--

CREATE TABLE `rl_detalleClasiCuarto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `cuartoclasificador_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_detalleClasiCuarto`
--

INSERT INTO `rl_detalleClasiCuarto` (`id`, `titulo`, `descripcion`, `estado`, `cuartoclasificador_id`) VALUES
(1, 'Bono de Antigüedad', NULL, 'activo', 2),
(2, 'Vacaciones no Utilizadas', NULL, 'activo', 11),
(3, 'Régimen de Corto Plazo (Salud)', NULL, 'activo', 14),
(4, 'Prima de Riesgo Profesional - Régimen de Largo Plazo', NULL, 'activo', 15),
(5, 'Mantenimiento preventivo y correctivo de fotocopiadora', NULL, 'activo', 22),
(6, 'Sillones ejecutivos', NULL, 'activo', 57),
(7, 'Mampara', NULL, 'activo', 57),
(8, 'Gillotina', NULL, 'activo', 57),
(9, 'impresora', NULL, 'activo', 58),
(10, 'Computadora', NULL, 'activo', 58),
(11, 'Fotocopiadora', NULL, 'activo', 58),
(12, 'Ram', NULL, 'activo', 58),
(13, 'Disco Duro Rigido', NULL, 'activo', 58),
(14, 'Disco Duro Solido', NULL, 'activo', 58),
(15, 'Laptops', NULL, 'activo', 58),
(16, 'Estaciones de trabajo (workstations)', NULL, 'activo', 58),
(17, 'Servidores', NULL, 'activo', 58),
(18, 'Dispositivos móviles', NULL, 'activo', 58),
(19, 'Becas de Estudios Otorgadas a los Estudiantes Universitarios', NULL, 'activo', 94),
(20, 'Mantenimiento de climatizadores de Data Center y equipo electrogeno', NULL, 'activo', 22),
(21, 'Grasa de mecanismos', NULL, 'activo', 48),
(22, 'Alcohol isopropilico', NULL, 'activo', 48),
(23, 'Escritorio en L', NULL, 'activo', 57);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_detalleClasiQuinto`
--

CREATE TABLE `rl_detalleClasiQuinto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `quintoclasificador_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_detalleClasiQuinto`
--

INSERT INTO `rl_detalleClasiQuinto` (`id`, `titulo`, `descripcion`, `estado`, `quintoclasificador_id`) VALUES
(1, 'Aporte Patronal Solidario 3%', NULL, 'activo', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_detalleClasiTercero`
--

CREATE TABLE `rl_detalleClasiTercero` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` varchar(20) NOT NULL,
  `tercerclasificador_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_detalleClasiTercero`
--

INSERT INTO `rl_detalleClasiTercero` (`id`, `titulo`, `descripcion`, `estado`, `tercerclasificador_id`) VALUES
(1, 'Aguinaldos', NULL, 'activo', 4),
(2, 'Asignaciones Familiares', NULL, 'activo', 6),
(3, 'Sueldos', NULL, 'activo', 7),
(4, 'Personal Eventual', NULL, 'activo', 10),
(5, 'Aporte Patronal para Vivienda', NULL, 'activo', 12),
(6, 'Otras Previsiones', NULL, 'activo', 17),
(7, 'Pago de certificados SSL DV (upea.bo)', NULL, 'activo', 23),
(8, 'Dominios institucionales .BO y .EDU.BO', NULL, 'activo', 23),
(9, 'Pago de internet a la empresa  Axes', NULL, 'activo', 23),
(10, 'Pago de internet', NULL, 'activo', 23),
(11, 'Difución  de reglamentos especificos de la universidad', NULL, 'activo', 42),
(12, 'Plan Estrategico Institucional -UPEA', NULL, 'activo', 42),
(13, 'Publicación de Estadistico  -UPEA', NULL, 'activo', 42),
(14, 'Guia de Proyecto de Investigación', NULL, 'activo', 42),
(15, 'Fotocopias, Vales y Anillado de documentos de respaldo para auditoria', NULL, 'activo', 42),
(16, 'Fotocopias ,Vales y Anillado de POAs y otros', NULL, 'activo', 42),
(17, 'Fotocopias ,Vales y Anillado,Empastes de Documentos y otros', NULL, 'activo', 42),
(18, 'Hojas de bon tamaño Carta', NULL, 'activo', 56),
(19, 'Hojas de bon tamaño Oficio', NULL, 'activo', 56),
(20, 'Hojas de bon de colores', NULL, 'activo', 56),
(21, 'hojas de color', NULL, 'activo', 56),
(22, 'hojas resma', NULL, 'activo', 56),
(23, 'Archivador de palanca', NULL, 'activo', 57),
(24, 'Papel Membretado', NULL, 'activo', 57),
(25, 'Folder amarillo', NULL, 'activo', 57),
(26, 'Cuaderno empastado', NULL, 'activo', 57),
(27, 'Cartulina', NULL, 'activo', 57),
(28, 'BOLIGRAFO AZUL', NULL, 'activo', 78),
(29, 'BOLIGRAFO ROJO', NULL, 'activo', 78),
(30, 'PEGAMENTO UHU DE 21 GRAMOS', NULL, 'activo', 78),
(31, 'LAPIZ NEGRO SABONIS', NULL, 'activo', 78),
(32, 'LAPIZ ROJO SABONIS', NULL, 'activo', 78),
(33, 'RESALTADORES MONAMI AMARILLO', NULL, 'activo', 78),
(34, 'GRAPAS MADISON 24/6', NULL, 'activo', 78),
(35, 'CLIP MADISON 33MM', NULL, 'activo', 78),
(36, 'CLIP MADISON 50MM', NULL, 'activo', 78),
(37, 'CLIP BRINDER MEDIANO NEGRO', NULL, 'activo', 78),
(38, 'CLIP BRINDER GRANDE NEGRO', NULL, 'activo', 78),
(39, 'CINTA DE EMBALAJE DE 100 YARDAS', NULL, 'activo', 78),
(40, 'CD 750 MB YOMINCO', NULL, 'activo', 78),
(41, 'PESTAÑAS PLASTICAS DE COLORES', NULL, 'activo', 78),
(42, 'CORRECTOR EN CINTA MADISON', NULL, 'activo', 78),
(43, 'SACAGRAPAS TIPO ALICATE METALICO', NULL, 'activo', 78),
(44, 'Diurex pequeño', NULL, 'activo', 78),
(45, 'Estilete', NULL, 'activo', 78),
(46, 'Regla', NULL, 'activo', 78),
(47, 'Tijera', NULL, 'activo', 78),
(48, 'UHU grande', NULL, 'activo', 78),
(49, 'UHU pequeño', NULL, 'activo', 78),
(50, 'TONER 80 A', NULL, 'activo', 78),
(52, 'Note stick', NULL, 'activo', 78),
(53, 'TONER 32A', NULL, 'activo', 78),
(54, 'TONER 05A', NULL, 'activo', 78),
(55, 'TONER 78A', NULL, 'activo', 78),
(56, 'TONER DE FOTOCOPIADORA GPR-39', NULL, 'activo', 78),
(57, 'Servilletas/toallas humedas', NULL, 'activo', 74),
(58, 'Alcohol gel', NULL, 'activo', 74),
(59, 'Materiales de limpieza', NULL, 'activo', 74),
(60, 'cortapicos', NULL, 'activo', 80),
(61, 'Cable Adaptador SATA a USB', NULL, 'activo', 80),
(62, 'CABLE UTP CATEGORIA 6', NULL, 'activo', 80),
(63, 'CABLEDUCTOS', NULL, 'activo', 69),
(64, 'Camaras de Seguridad', NULL, 'activo', 80),
(65, 'cooler para laptop', NULL, 'activo', 80),
(66, 'Destornillador Electrico', NULL, 'activo', 80),
(67, 'Fuentes de Poder 850 w', NULL, 'activo', 80),
(68, 'JACKS cat 6', NULL, 'activo', 80),
(69, 'Mouse', NULL, 'activo', 80),
(70, 'Pilas AAA alkalinas', NULL, 'activo', 80),
(71, 'Pilas de litio tipo moneda (CR2032)', NULL, 'activo', 80),
(72, 'Portapicos de 6 tomas', NULL, 'activo', 80),
(73, 'RJ-45', NULL, 'activo', 80),
(74, 'Rosetas para JACKS dobles', NULL, 'activo', 80),
(75, 'Rosetas para JACKS simples', NULL, 'activo', 80),
(76, 'Seguidor de linea', NULL, 'activo', 80),
(77, 'Switch de 8 o 16 puertos', NULL, 'activo', 80),
(78, 'Teclado', NULL, 'activo', 80),
(79, 'Monitor', NULL, 'activo', 80),
(80, 'Monito TV', NULL, 'activo', 80),
(81, 'Tornillos', NULL, 'activo', 70),
(82, 'Alicate de RED niquelado', NULL, 'activo', 72),
(83, 'Brocas largas', NULL, 'activo', 72),
(84, 'Herramienta de impacto', NULL, 'activo', 72),
(85, 'Juego de Brocas', NULL, 'activo', 72),
(86, 'juego de puntas para taladro electrico', NULL, 'activo', 72),
(87, 'TESTER POWER SCAN', NULL, 'activo', 72),
(88, 'Silicona', NULL, 'activo', 66),
(89, 'Router Cloud', NULL, 'activo', 94),
(90, 'router  RB952', NULL, 'activo', 94),
(91, 'Fusionadora de fibra optica', NULL, 'activo', 96),
(92, 'Pago de certificados SSL DV (upea.edu.bo)', NULL, 'activo', 23),
(93, 'Marcador de Agua', NULL, 'activo', 78),
(94, 'Tintas para impresora', NULL, 'activo', 78),
(95, 'Libros de Actas', NULL, 'activo', 57),
(96, 'Lapiz negro Faber Castell', NULL, 'activo', 78),
(97, 'Lapiz rojo Faber Castell', NULL, 'activo', 78),
(98, 'DVD', NULL, 'activo', 78),
(99, 'Perforadora', NULL, 'activo', 78),
(100, 'Engrampadora', NULL, 'activo', 78),
(101, 'Sello de recibido', NULL, 'activo', 78),
(102, 'SACAGRAPAS', NULL, 'activo', 78),
(103, 'Borrador', NULL, 'activo', 78),
(104, 'Limpia muebles OLA', NULL, 'activo', 74),
(105, 'Limpia vidrios OLA', NULL, 'activo', 74),
(106, 'Detergente en polvo 1 kilo KLIM', NULL, 'activo', 74),
(107, 'Ambientador en spray SOPOLIO', NULL, 'activo', 74),
(108, 'Esponja', NULL, 'activo', 74),
(109, 'Limpia baños OLA', NULL, 'activo', 74),
(110, 'Franela naranja', NULL, 'activo', 74),
(111, 'Toallas pequeñas 30 x 30', NULL, 'activo', 74),
(112, 'Guantes de Goma para limpieza', NULL, 'activo', 74),
(113, 'Paño plomo para piso', NULL, 'activo', 74),
(114, 'Cera', NULL, 'activo', 74),
(115, 'Biruta para piso', NULL, 'activo', 74),
(116, 'Escoba', NULL, 'activo', 74),
(117, 'Basurero', NULL, 'activo', 74),
(118, 'Tester de chips para impresoras y reseteador', NULL, 'activo', 72),
(119, 'Brochas No 1, 1,5 y 2', NULL, 'activo', 72),
(120, 'Espuma limpiadora o multiuso', NULL, 'activo', 74),
(121, 'Fibra Optica Monomodo 1km con mensajero', NULL, 'activo', 80),
(122, 'Herramientas para fibra optica', NULL, 'activo', 80),
(123, 'OM3 multimodo SC/SC 15M', NULL, 'activo', 80),
(124, 'SC Adaptador Mono-modo Simplex de F/O', NULL, 'activo', 80),
(125, 'SC Conector Fibra Rapida Conexion Drop SC/UPC', NULL, 'activo', 80),
(126, 'Tomacorrientes', NULL, 'activo', 80),
(127, 'Limpiador de circuitos electricos', NULL, 'activo', 74),
(128, 'Destornilladores 5 x 100 mm punta de acero', NULL, 'activo', 72),
(129, 'Pasta termica 30 gramos', NULL, 'activo', 66),
(130, 'Crema termica para procesador', NULL, 'activo', 66),
(131, 'Pasta termica 4 gramos', NULL, 'activo', 66),
(132, 'Precintos de seguridad plasticos', NULL, 'activo', 80),
(133, 'Roseta de FO FTTH SC/APC + 1 Adaptador SC/APC', NULL, 'activo', 80),
(134, 'Crimpeadora Ponchadora de red', NULL, 'activo', 72),
(135, 'Guantes quirurgicos de nitrilo', NULL, 'activo', 66),
(136, 'Cable VGA 3 mts', NULL, 'activo', 80),
(137, 'Conversor de VGA a HDMI', NULL, 'activo', 80),
(138, 'Escalera de 6 peldaños', NULL, 'activo', 81),
(139, 'Cortapicos lineral', NULL, 'activo', 80),
(140, 'Cable USB a tipo B parra impresora', NULL, 'activo', 80),
(141, 'Tornillos y rampluz', NULL, 'activo', 70),
(142, 'Tornillos para RACK (racamuela, arandela, tornillos)', NULL, 'activo', 70),
(143, 'ODF', NULL, 'activo', 80),
(144, 'Juego de alicates', NULL, 'activo', 72),
(145, 'Juego de destornilladores', NULL, 'activo', 72),
(146, 'XPON ONT Router', NULL, 'activo', 94),
(147, 'Cerradura inteligente para puerta de madera', NULL, 'activo', 70);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_financiamiento_tipo`
--

CREATE TABLE `rl_financiamiento_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sigla` varchar(10) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_financiamiento_tipo`
--

INSERT INTO `rl_financiamiento_tipo` (`id`, `sigla`, `codigo`, `descripcion`, `estado`) VALUES
(1, 'TGN', '111', 'TESORO GENERAL DE LA NACIÓN', 'activo'),
(2, 'COP. TRIB.', '113', 'COPARTICIPACIÓN TRIBUTARIA', 'activo'),
(3, 'IDH', '119', 'IMPUESTO DIRECTO A LOS HIDROCARBUROS', 'activo'),
(4, 'REC. PROP.', '230', 'RECURSOS PROPIOS', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_foda_carreras_unidad`
--

CREATE TABLE `rl_foda_carreras_unidad` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `estado` varchar(20) NOT NULL,
  `tipo_foda_id` bigint(20) UNSIGNED NOT NULL,
  `gestion_id` bigint(20) UNSIGNED NOT NULL,
  `UnidadCarrera_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_foda_carreras_unidad`
--

INSERT INTO `rl_foda_carreras_unidad` (`id`, `descripcion`, `estado`, `tipo_foda_id`, `gestion_id`, `UnidadCarrera_id`, `usuario_id`, `creado_el`, `editado_el`) VALUES
(1, 'Personal motivado para implementar nuevas tecnologías de información y comunicación.', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(2, 'Colaboración de personal de las áreas en las diferentes tareas y actividades que realiza la unidad.', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(3, 'Personal capacitado en sus respectivas áreas y de amplia experiencia en el desarrollo de sistemas de información', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(4, 'Conocimientos de los procesos y operaciones universitarias para la optimización de servicios', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(5, 'Sistemas de información integrados en proceso de desarrollo y puestas en producción para los docentes, estudiantes y administrativos de la Universidad.', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(6, 'Utilización de herramientas de Software libre en el desarrollo de los sistemas de información.', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(7, 'Se cuenta con pasantes y estudiantes con proyectos de grado de la carrera de ingeniería de sistemas.', 'activo', 1, 6, 41, 48, '2025-09-11 22:01:17', '2025-09-11 22:01:17'),
(8, 'Creación de sistemas de información para la Universidad de acuerdo a las necesidades presentadas y requeridas', 'activo', 2, 6, 41, 48, '2025-09-11 22:02:01', '2025-09-11 22:02:01'),
(9, 'Digitalización de bibliotecas con creación de repositorios digitales', 'activo', 2, 6, 41, 48, '2025-09-11 22:02:01', '2025-09-11 22:02:01'),
(10, 'Desarrollo nuevas plataformas virtuales de enseñanza para coadyuvar en el proceso de enseñanza aprendizaje de la comunidad universitaria.', 'activo', 2, 6, 41, 48, '2025-09-11 22:02:01', '2025-09-11 22:02:01'),
(11, 'Desarrollo de sistemas de información de tipo gerencial para coadyuvar a la toma de decisiones a las autoridades.', 'activo', 2, 6, 41, 48, '2025-09-11 22:02:01', '2025-09-11 22:02:01'),
(12, 'Dar capacitación de uso de nuevas tecnologías de información y comunicación a la comunidad universitaria y la población de la Ciudad de El Alto.', 'activo', 2, 6, 41, 48, '2025-09-11 22:02:01', '2025-09-11 22:02:01'),
(13, 'Acefalia del personal en el área desarrollo de software, redes, mantenimiento y seguridad de la información.', 'activo', 3, 6, 41, 48, '2025-09-11 22:02:36', '2025-09-11 22:02:36'),
(14, 'Equipamiento insuficiente para la implantación de nuevos servicios para la comunidad universitaria.', 'activo', 3, 6, 41, 48, '2025-09-11 22:02:36', '2025-09-11 22:02:36'),
(15, 'Falta de, material y suministros mínimos para las diferentes áreas de la unidad.', 'activo', 3, 6, 41, 48, '2025-09-11 22:02:36', '2025-09-11 22:02:36'),
(16, 'Infraestructura tecnológica inadecuada para implementar nuevos servicios para la comunidad universitaria', 'activo', 3, 6, 41, 48, '2025-09-11 22:02:36', '2025-09-11 22:02:36'),
(17, 'Falta de procesos administrativos para agilizar la ejecución de proyectos tecnológicos.', 'activo', 3, 6, 41, 48, '2025-09-11 22:02:36', '2025-09-11 22:02:36'),
(18, 'Falta de institucionalización de algunos cargos técnicos', 'activo', 4, 6, 41, 48, '2025-09-11 22:03:02', '2025-09-11 22:03:02'),
(19, 'Rote de personal técnico eventual continuo.', 'activo', 4, 6, 41, 48, '2025-09-11 22:03:02', '2025-09-11 22:03:02'),
(20, 'Falta de servicios de seguridad para la protección de terceros e información en proceso de transacción de cliente-servidor.', 'activo', 4, 6, 41, 48, '2025-09-11 22:03:02', '2025-09-11 22:03:02'),
(21, 'Falta de aprobación de Políticas y normas del SIE por instancias superiores', 'activo', 4, 6, 41, 48, '2025-09-11 22:03:02', '2025-09-11 22:03:02'),
(22, 'Falta de aprobación de Políticas de seguridad por las instancias superiores.', 'activo', 4, 6, 41, 48, '2025-09-11 22:03:02', '2025-09-11 22:03:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_foda_descripcion`
--

CREATE TABLE `rl_foda_descripcion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `id_area_estrategica` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_foda` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_plan` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_formulado_tipo`
--

CREATE TABLE `rl_formulado_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_formulado_tipo`
--

INSERT INTO `rl_formulado_tipo` (`id`, `descripcion`, `estado`) VALUES
(1, 'PRIMER FORMULADO', 'activo'),
(2, 'SEGUNDO REFORMULADO', 'activo'),
(3, 'TERCER REFORMULADO', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_formulario1`
--

CREATE TABLE `rl_formulario1` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `maxima_autoridad` varchar(255) NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `gestion_id` bigint(20) UNSIGNED NOT NULL,
  `configFormulado_id` bigint(20) UNSIGNED NOT NULL,
  `unidadCarrera_id` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_formulario1`
--

INSERT INTO `rl_formulario1` (`id`, `fecha`, `maxima_autoridad`, `usuario_id`, `gestion_id`, `configFormulado_id`, `unidadCarrera_id`, `creado_el`, `editado_el`) VALUES
(1, '2025-09-11', 'Dr. Carlos Condori Titirico', 48, 6, 1, 41, '2025-09-11 16:38:58', '2025-09-11 16:38:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_formulario2`
--

CREATE TABLE `rl_formulario2` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `formulario1_id` bigint(20) UNSIGNED NOT NULL,
  `configFormulado_id` bigint(20) UNSIGNED NOT NULL,
  `indicador_id` bigint(20) UNSIGNED NOT NULL,
  `gestion_id` bigint(20) UNSIGNED NOT NULL,
  `areaestrategica_id` bigint(20) UNSIGNED NOT NULL,
  `unidadCarrera_id` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_formulario2`
--

INSERT INTO `rl_formulario2` (`id`, `codigo`, `formulario1_id`, `configFormulado_id`, `indicador_id`, `gestion_id`, `areaestrategica_id`, `unidadCarrera_id`, `creado_el`, `editado_el`) VALUES
(1, 3, 1, 1, 85, 6, 4, 41, '2025-09-12 19:12:16', '2025-09-15 15:27:38'),
(2, 4, 1, 1, 87, 6, 4, 41, '2025-09-12 19:14:17', '2025-09-15 15:27:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_formulario4`
--

CREATE TABLE `rl_formulario4` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `formulario2_id` bigint(20) UNSIGNED NOT NULL,
  `configFormulado_id` bigint(20) UNSIGNED NOT NULL,
  `unidadCarrera_id` bigint(20) UNSIGNED NOT NULL,
  `areaestrategica_id` bigint(20) UNSIGNED NOT NULL,
  `gestion_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_id` bigint(20) UNSIGNED NOT NULL,
  `categoria_id` bigint(20) UNSIGNED NOT NULL,
  `bnservicio_id` bigint(20) UNSIGNED NOT NULL,
  `primer_semestre` varchar(10) NOT NULL,
  `segundo_semestre` varchar(10) NOT NULL,
  `meta_anual` varchar(10) NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_formulario4`
--

INSERT INTO `rl_formulario4` (`id`, `codigo`, `formulario2_id`, `configFormulado_id`, `unidadCarrera_id`, `areaestrategica_id`, `gestion_id`, `tipo_id`, `categoria_id`, `bnservicio_id`, `primer_semestre`, `segundo_semestre`, `meta_anual`, `creado_el`, `editado_el`) VALUES
(1, 2, 1, 1, 41, 4, 6, 1, 1, 1, '2', '2', '4', '2025-09-15 15:32:42', '2025-09-15 15:32:42'),
(2, 4, 2, 1, 41, 4, 6, 1, 1, 1, '6', '6', '12', '2025-09-15 15:33:28', '2025-09-15 15:33:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_formulario5`
--

CREATE TABLE `rl_formulario5` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formulario4_id` bigint(20) UNSIGNED NOT NULL,
  `operacion_id` bigint(20) UNSIGNED NOT NULL,
  `configFormulado_id` bigint(20) UNSIGNED NOT NULL,
  `unidadCarrera_id` bigint(20) UNSIGNED NOT NULL,
  `areaestrategica_id` bigint(20) UNSIGNED NOT NULL,
  `gestion_id` bigint(20) UNSIGNED NOT NULL,
  `primer_semestre` varchar(10) NOT NULL,
  `segundo_semestre` varchar(10) NOT NULL,
  `total` varchar(10) NOT NULL,
  `desde` date NOT NULL,
  `hasta` date NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_formulario5`
--

INSERT INTO `rl_formulario5` (`id`, `formulario4_id`, `operacion_id`, `configFormulado_id`, `unidadCarrera_id`, `areaestrategica_id`, `gestion_id`, `primer_semestre`, `segundo_semestre`, `total`, `desde`, `hasta`, `creado_el`, `editado_el`) VALUES
(1, 1, 1, 1, 41, 4, 6, '2', '2', '4', '2026-01-20', '2026-12-31', '2025-09-15 15:34:34', '2025-09-15 15:34:34'),
(2, 1, 2, 1, 41, 4, 6, '100', '100', '200', '2026-01-20', '2026-12-31', '2025-09-15 15:35:26', '2025-09-15 15:35:26'),
(3, 1, 3, 1, 41, 4, 6, '2', '2', '6', '2026-01-20', '2026-12-31', '2025-09-15 15:36:04', '2025-09-15 15:36:04'),
(4, 2, 4, 1, 41, 4, 6, '6', '6', '12', '2026-01-20', '2026-12-31', '2025-09-15 15:54:39', '2025-09-15 15:54:39'),
(5, 2, 5, 1, 41, 4, 6, '0', '1', '1', '2026-01-20', '2026-12-31', '2025-09-16 12:57:11', '2025-09-16 12:57:11'),
(6, 2, 6, 1, 41, 4, 6, '0', '0', '0', '2026-01-20', '2026-12-31', '2025-09-16 12:57:50', '2025-09-16 12:57:50'),
(7, 2, 7, 1, 41, 4, 6, '1', '1', '2', '2026-01-20', '2026-12-31', '2025-09-16 12:59:17', '2025-09-16 12:59:17'),
(8, 2, 8, 1, 41, 4, 6, '1', '0', '1', '2026-01-20', '2026-12-31', '2025-09-16 12:59:34', '2025-09-16 12:59:34'),
(9, 2, 9, 1, 41, 4, 6, '0', '0', '0', '2026-01-20', '2026-12-31', '2025-09-16 12:59:50', '2025-09-16 12:59:50'),
(10, 2, 10, 1, 41, 4, 6, '1', '1', '2', '2026-01-20', '2026-12-31', '2025-09-16 13:00:06', '2025-09-16 13:00:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_gestion`
--

CREATE TABLE `rl_gestion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inicio_gestion` year(4) NOT NULL,
  `fin_gestion` year(4) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `estado_eliminacion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_gestion`
--

INSERT INTO `rl_gestion` (`id`, `inicio_gestion`, `fin_gestion`, `estado`, `estado_eliminacion`) VALUES
(1, '2026', '2030', 'activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_gestiones`
--

CREATE TABLE `rl_gestiones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gestion` year(4) NOT NULL,
  `estado` text NOT NULL,
  `id_gestion` bigint(20) UNSIGNED NOT NULL,
  `eliminacion` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_gestiones`
--

INSERT INTO `rl_gestiones` (`id`, `gestion`, `estado`, `id_gestion`, `eliminacion`) VALUES
(6, '2026', 'activo', 1, 1),
(7, '2027', 'activo', 1, 1),
(8, '2028', 'activo', 1, 1),
(9, '2029', 'activo', 1, 1),
(10, '2030', 'activo', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_historial_asignacion_monto`
--

CREATE TABLE `rl_historial_asignacion_monto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asignacionMontof4_id` bigint(20) UNSIGNED NOT NULL,
  `monto` decimal(50,2) UNSIGNED NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_historial_asignacion_monto`
--

INSERT INTO `rl_historial_asignacion_monto` (`id`, `asignacionMontof4_id`, `monto`, `fecha`) VALUES
(1, 1, 109952.00, '2025-09-15'),
(2, 1, 99632.00, '2025-09-15'),
(3, 1, 95891.00, '2025-09-16'),
(4, 1, 92150.00, '2025-09-16'),
(5, 1, 90890.00, '2025-09-16'),
(6, 1, 81040.00, '2025-09-16'),
(7, 1, 79240.00, '2025-09-16'),
(8, 1, 78790.00, '2025-09-16'),
(9, 1, 78640.00, '2025-09-16'),
(10, 1, 77600.00, '2025-09-16'),
(11, 1, 77525.00, '2025-09-16'),
(12, 1, 76565.00, '2025-09-16'),
(13, 1, 76515.00, '2025-09-16'),
(14, 1, 76215.00, '2025-09-16'),
(15, 1, 75765.00, '2025-09-16'),
(16, 1, 75655.00, '2025-09-16'),
(17, 1, 75530.00, '2025-09-16'),
(18, 1, 75350.00, '2025-09-16'),
(19, 1, 75290.00, '2025-09-16'),
(20, 1, 75200.00, '2025-09-16'),
(21, 1, 75070.00, '2025-09-16'),
(22, 1, 74890.00, '2025-09-16'),
(23, 1, 74790.00, '2025-09-16'),
(24, 1, 74720.00, '2025-09-16'),
(25, 1, 74624.00, '2025-09-16'),
(26, 1, 74500.00, '2025-09-16'),
(27, 1, 74400.00, '2025-09-16'),
(28, 1, 74150.00, '2025-09-16'),
(29, 1, 74100.00, '2025-09-16'),
(30, 1, 74040.00, '2025-09-16'),
(31, 1, 73968.00, '2025-09-16'),
(32, 1, 73818.00, '2025-09-16'),
(33, 1, 73693.00, '2025-09-16'),
(34, 1, 73468.00, '2025-09-16'),
(35, 1, 65628.00, '2025-09-16'),
(36, 1, 65603.00, '2025-09-16'),
(37, 1, 65363.00, '2025-09-16'),
(38, 1, 64583.00, '2025-09-16'),
(39, 1, 64453.00, '2025-09-16'),
(40, 1, 64357.00, '2025-09-16'),
(41, 1, 64335.00, '2025-09-16'),
(42, 1, 64175.00, '2025-09-16'),
(43, 1, 64150.00, '2025-09-16'),
(44, 1, 64062.00, '2025-09-16'),
(45, 1, 63992.00, '2025-09-16'),
(46, 1, 63892.00, '2025-09-16'),
(47, 1, 63820.00, '2025-09-16'),
(48, 1, 63772.00, '2025-09-16'),
(49, 1, 63562.00, '2025-09-16'),
(50, 1, 63510.00, '2025-09-16'),
(51, 1, 63480.00, '2025-09-16'),
(52, 1, 63450.00, '2025-09-16'),
(53, 1, 63350.00, '2025-09-16'),
(54, 1, 62500.00, '2025-09-16'),
(55, 1, 62395.00, '2025-09-16'),
(56, 1, 62270.00, '2025-09-16'),
(57, 1, 58670.00, '2025-09-16'),
(58, 1, 56720.00, '2025-09-16'),
(59, 1, 55740.00, '2025-09-16'),
(60, 1, 54990.00, '2025-09-16'),
(61, 1, 54690.00, '2025-09-16'),
(62, 1, 53815.00, '2025-09-16'),
(63, 1, 53375.00, '2025-09-16'),
(64, 1, 53005.00, '2025-09-16'),
(65, 1, 52975.00, '2025-09-16'),
(66, 1, 52675.00, '2025-09-16'),
(67, 1, 52615.00, '2025-09-16'),
(68, 1, 52265.00, '2025-09-16'),
(69, 1, 51965.00, '2025-09-16'),
(70, 1, 51565.00, '2025-09-16'),
(71, 1, 50965.00, '2025-09-16'),
(72, 1, 50781.00, '2025-09-16'),
(73, 1, 50031.00, '2025-09-16'),
(74, 1, 49751.00, '2025-09-16'),
(75, 1, 48351.00, '2025-09-16'),
(76, 1, 47751.00, '2025-09-16'),
(77, 1, 46951.00, '2025-09-16'),
(78, 1, 46321.00, '2025-09-16'),
(79, 1, 45771.00, '2025-09-16'),
(80, 1, 45696.00, '2025-09-16'),
(81, 1, 45306.00, '2025-09-16'),
(82, 1, 45106.00, '2025-09-16'),
(83, 1, 43956.00, '2025-09-16'),
(84, 1, 43746.00, '2025-09-16'),
(85, 1, 43586.00, '2025-09-16'),
(86, 1, 43010.00, '2025-09-16'),
(87, 1, 42610.00, '2025-09-16'),
(88, 1, 41910.00, '2025-09-16'),
(89, 1, 39960.00, '2025-09-16'),
(90, 1, 39690.00, '2025-09-16'),
(91, 1, 39450.00, '2025-09-16'),
(92, 1, 19670.00, '2025-09-16'),
(93, 1, 13670.00, '2025-09-16'),
(94, 1, 11270.00, '2025-09-16'),
(95, 1, 7070.00, '2025-09-16'),
(96, 1, 2720.00, '2025-09-16'),
(97, 1, 0.00, '2025-09-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_historial_caja`
--

CREATE TABLE `rl_historial_caja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `documento_privado` varchar(100) DEFAULT NULL,
  `concepto` varchar(255) NOT NULL,
  `saldo` decimal(50,2) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `caja_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_historial_caja`
--

INSERT INTO `rl_historial_caja` (`id`, `fecha`, `hora`, `documento_privado`, `concepto`, `saldo`, `usuario_id`, `caja_id`) VALUES
(1, '2025-09-15', '11:56:18', '20250915115618.pdf', 'COPARTICIPACIÓN TRIBUTARIA', 109952.00, 48, 1),
(2, '2025-09-15', '11:56:51', NULL, 'Asignacion al indicador del formulario 4, guardand el monto actual que tiene', 0.00, 48, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_indicador`
--

CREATE TABLE `rl_indicador` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_gestion` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_indicador`
--

INSERT INTO `rl_indicador` (`id`, `codigo`, `descripcion`, `estado`, `id_gestion`) VALUES
(1, 1, 'N° de carreras con diseños curriculares actualizados,  innovados y pertinentes', 'activo', 1),
(2, 2, 'Nº de Académicos (docentes) con grado de Doctor', 'activo', 1),
(3, 3, 'N° de Académicos (docentes)  con grado de  Maestría', 'activo', 1),
(4, 4, 'Asignaturas troncales con docentes del área de conocimiento', 'activo', 1),
(5, 5, 'Nº de Docentes que presentan su seguimiento al Desarrollo Curricular', 'activo', 1),
(6, 6, 'Nº de Docentes con evaluación permanente y periódica', 'activo', 1),
(7, 7, 'N° de programas de Formación Continua para docentes en el área de su disciplina', 'activo', 1),
(8, 8, '% en incremento de estudiantes matriculados en las Carreras de la UPEA', 'activo', 1),
(9, 9, 'Nº bachilleres con promedio de excelencia, matriculados en la Universidad', 'activo', 1),
(10, 10, 'Nº de carreras ofertadas por la Universidad', 'activo', 1),
(11, 11, 'Nª de profesionales titulados con Grado Académico de Licenciatura', 'activo', 1),
(12, 12, 'Nª de titulados del nivel Técnico Superior', 'activo', 1),
(13, 13, 'Nº de Sedes desconcentradas en provincia y funcionamiento', 'activo', 1),
(14, 14, 'Nº de Carreras Autoevaluadas', 'activo', 1),
(15, 15, 'Nº de Carreras evaluadas externamente acreditadas a nivel nacional', 'activo', 1),
(16, 16, 'Nº de Carreras Universitarias acreditadas internacionalmente', 'activo', 1),
(17, 17, 'N° de programas de Posgrado presenciales y semipresenciales en funcionamiento', 'activo', 1),
(18, 18, 'Nº de programas de Posgrado con oferta virtual', 'activo', 1),
(19, 19, '%  de titulados a nivel Doctorado con base a inscritos inicialmente', 'activo', 1),
(20, 20, '% de titulados a nivel Maestría con base a inscrtos inicialmente', 'activo', 1),
(21, 21, 'Nº proyectos de equipamiento para los Programas de Posgrado', 'activo', 1),
(22, 22, 'Nº de investigaciones científicas, tecnológicas, sociales y humanísticas en programas de Posgrado', 'activo', 1),
(23, 23, 'Nº de Becas\r\nsocioeconómicas otorgadas anualmente', 'activo', 1),
(24, 24, 'Nº de Becas académicas otorgadas anualmente', 'activo', 1),
(25, 25, '%  de estudiantes atendidos en el Seguro Social Universitario', 'activo', 1),
(26, 26, '% de disminución de Tasa de\r\nabandono', 'activo', 1),
(27, 27, 'Centro de Investigación e Innovación Tecnológica UPEA', 'activo', 1),
(28, 28, 'Incubadora de Innovación, Investigación y desarrollo', 'activo', 1),
(29, 29, 'Nº de Institutos de investigación especializados (obligatorio)', 'activo', 1),
(30, 30, 'Unidad de Transferencia de Resultados de Investigación (UTRI)', 'activo', 1),
(31, 31, 'Nº Sociedades Científicas de Docentes para coadyuvar y promover la investigación científica y académica', 'activo', 1),
(32, 32, 'Sociedades Científicas de Estudiantes para coadyuvar y promover la investigación científica y académica', 'activo', 1),
(33, 33, '% del Presupuesto institucional destinado a proyectos de investigación en la DICyT', 'activo', 1),
(34, 34, '% del Presupuesto institucional destinado al recurso humano de los Institutos de Investigación de Carrera (optativo)', 'activo', 1),
(35, 35, 'N° de Investigadores a medio tiempo', 'activo', 1),
(36, 36, 'N° de investigadores que participan en eventos científicos nacionales  (optativo)', 'activo', 1),
(37, 37, 'N° de estudiantes beneficiados con becas de investigación   (optativo) tomar en cuenta', 'activo', 1),
(38, 38, 'Nº de investigadores que publican artículos en revistas indexadas   (optativo)', 'activo', 1),
(39, 39, 'N° de programas de formación continua en Gestión de la Investigación   (obligatorio)', 'activo', 1),
(40, 40, 'Nº de contratos y convenios nacionales empresa-Estado- universidad   (optativo)', 'activo', 1),
(41, 41, 'Nº de Proyectos de Investigación ejecutados por el Centro de Investigación e Innovación Tecnológica (CIIT)', 'activo', 1),
(42, 42, 'Nº de Proyectos de impacto en Desarrollo Productivo y Social', 'activo', 1),
(43, 43, 'Nº de revistas publicadas anualmente por área del conocimiento con código ISSN  (obligatorio)', 'activo', 1),
(44, 44, 'Nº de libros publicados con depósito legal,  e ISBN (obligatorio)', 'activo', 1),
(45, 45, 'Nº de documentos científicos editados (obligatorio)', 'activo', 1),
(46, 46, 'Sistema de Registro de la Propiedad Intelectual (optativo)', 'activo', 1),
(47, 47, 'Nº de patentes registrados (obligatorio)', 'activo', 1),
(48, 48, 'Nº de Feria Institucional Científica y Tecnología', 'activo', 1),
(49, 49, 'Nº de resultados del proceso de Investigación transferidos a la Sociedad', 'activo', 1),
(50, 50, 'Nº de Feria Científica de Áreas', 'activo', 1),
(51, 51, 'Nº de Feria Científica de Carreras', 'activo', 1),
(52, 52, 'N° de Bibliotecas Especializadas en Investigación física y virtual', 'activo', 1),
(53, 53, 'imprenta Universitaria', 'activo', 1),
(54, 54, 'N° de eventos de análisis, discusión y debate orientados a la formación de políticas públicas organizados', 'activo', 1),
(55, 55, 'Nº de Convenios con Entidades Territoriales Autónomas (Gobernaciones, Municipios y otros)', 'activo', 1),
(56, 56, 'N° de Proyectos de interacción social desarrollados', 'activo', 1),
(57, 57, 'Realización y participación de eventos institucionales de Innovación  e Interacción Social', 'activo', 1),
(58, 58, 'Estrategia de información y comunicación institucional aplicadas  a nivel de actividades de interacción social', 'activo', 1),
(59, 59, 'Nº de medios de comunicación', 'activo', 1),
(60, 60, 'Nº de Programas de orientación profesional y vocacional', 'activo', 1),
(61, 61, 'N° de eventos de interacción social', 'activo', 1),
(62, 62, 'N° de Programas de Extensión de Servicio a la Comunidad', 'activo', 1),
(63, 63, '% de mejoras en los procesos de evaluación para la otorgación de programa de becas a Universitarios (as)', 'activo', 1),
(64, 64, 'N° de programas y eventos culturales desarrollados', 'activo', 1),
(65, 65, 'Nº de Infraestructura (Coliseo Deportivo Universitario) para el desarrollo de las diferentes disciplinas deportivas', 'activo', 1),
(66, 66, '% de equipamiento deportivo para el desarrollo de las diferentes disciplinas deportivas', 'activo', 1),
(67, 67, 'Nº de eventos deportivos desarrollados', 'activo', 1),
(68, 68, 'N°de estudiantes becarios en programas/proyectos de interacción social y extensión universitaria', 'activo', 1),
(69, 69, '% del presupuesto universitario asignado a actividades de interacción social y extensión universitaria', 'activo', 1),
(70, 70, 'Nº de actividades institucionles de gestión ambiental', 'activo', 1),
(71, 71, 'Estrategia de internacionalización', 'activo', 1),
(72, 72, 'N° de convenios con IES del exterior', 'activo', 1),
(73, 73, 'N° participaciones en REDES de IES', 'activo', 1),
(74, 74, 'N° de alianzas estratégicas', 'activo', 1),
(75, 75, 'N° de congresos, seminarios y conferencias internacionales organizadas por la Universidad', 'activo', 1),
(76, 76, 'N° de Docentes de grado y posgrado que participan en programas de movilidad internacional', 'activo', 1),
(77, 77, 'N° de estudiantes de grado y posgrado que participan en programas de movilidad internacional', 'activo', 1),
(78, 78, 'N° de proyectos ejecutados con financiamiento de la cooperación internacional', 'activo', 1),
(79, 79, 'Plan Estratégico Institucional Universitario (PEI) elaborado y en vigencia', 'activo', 1),
(80, 80, 'Nro. de Áreas Académicas que cuentan con Planes de Desarrollo (PDA)', 'activo', 1),
(81, 81, 'Sistema Integral de Seguimiento y Evaluación', 'activo', 1),
(82, 82, 'Nº de informes anuales de seguimiento y evaluación del PEI', 'activo', 1),
(83, 83, 'Nº de Planes de Desarrollo Facultativos elaborados', 'activo', 1),
(84, 84, 'Estructura Organizacional flexible, dinamica e innovadora', 'activo', 1),
(85, 85, 'Sistema Integrado de Gestión, Información y Comunicación (en línea)', 'activo', 1),
(86, 86, '% de cumplimiento de metas del Plan Estratégico Universitario (PEI)', 'activo', 1),
(87, 87, '% Ejecución del POA', 'activo', 1),
(88, 88, '% de Ejecución presupuestaria anual', 'activo', 1),
(89, 89, '% de incremento en la generación de Recursos Propios', 'activo', 1),
(90, 90, '% de ejecución del Proyectos de inversión en Infraestructura física', 'activo', 1),
(91, 91, '% de ejecución de Proyectos de Inversión con recursos IDH', 'activo', 1),
(92, 92, '% de ejecución de Proyectos de Inversión  en equipamiento y otros', 'activo', 1),
(93, 93, 'Nº de Programas de Formación Continua para el Personal Administrativos', 'activo', 1),
(94, 94, 'Nº talleres y/o cursos de motivación y compromiso institucional ejecutados', 'activo', 1),
(95, 95, 'Nº de eventos de fomento al respeto a los derechos humanos, equidad de género y personas con discapacidad', 'activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_matriz_planificacion`
--

CREATE TABLE `rl_matriz_planificacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_area_estrategica` bigint(20) UNSIGNED NOT NULL,
  `id_indicador` bigint(20) UNSIGNED NOT NULL,
  `id_tipo` bigint(20) UNSIGNED NOT NULL,
  `id_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_resultado_producto` bigint(20) UNSIGNED NOT NULL,
  `linea_base` varchar(5) NOT NULL,
  `gestion_1` varchar(5) NOT NULL,
  `gestion_2` varchar(5) NOT NULL,
  `gestion_3` varchar(5) NOT NULL,
  `gestion_4` varchar(5) NOT NULL,
  `gestion_5` varchar(5) NOT NULL,
  `meta_mediano_plazo` varchar(10) NOT NULL,
  `id_programa_proy` bigint(20) UNSIGNED NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_matriz_planificacion`
--

INSERT INTO `rl_matriz_planificacion` (`id`, `codigo`, `id_area_estrategica`, `id_indicador`, `id_tipo`, `id_categoria`, `id_resultado_producto`, `linea_base`, `gestion_1`, `gestion_2`, `gestion_3`, `gestion_4`, `gestion_5`, `meta_mediano_plazo`, `id_programa_proy`, `creado_el`, `editado_el`) VALUES
(1, 1, 1, 1, 1, 1, 1, '8', '-', '-', '-', '4', '6', '10', 1, '2025-09-09 15:54:19', '2025-09-09 20:34:05'),
(2, 2, 1, 2, 1, 1, 2, '20', '-', '-', '-', '10', '12', '22', 2, '2025-09-09 19:45:44', '2025-09-09 19:45:44'),
(3, 2, 1, 3, 1, 1, 3, '30', '-', '-', '-', '120', '120', '240', 3, '2025-09-09 19:49:06', '2025-09-09 19:49:06'),
(4, 2, 1, 4, 1, 2, 4, '0', '-', '-', '-', '70', '70', '70', 4, '2025-09-09 19:50:26', '2025-09-09 19:51:06'),
(5, 2, 1, 5, 1, 2, 5, '0', '-', '-', '-', '80', '80', '80', 5, '2025-09-09 19:52:12', '2025-09-09 19:52:12'),
(6, 2, 1, 6, 1, 2, 6, '0', '-', '-', '-', '90', '90', '90', 6, '2025-09-09 19:53:17', '2025-09-09 19:53:17'),
(7, 2, 1, 7, 1, 2, 7, '6', '-', '-', '-', '2', '2', '4', 7, '2025-09-09 19:54:13', '2025-09-09 19:54:13'),
(8, 3, 1, 8, 2, 4, 9, '5', '-', '-', '-', '5', '5', '5', 8, '2025-09-09 20:07:38', '2025-09-09 20:07:38'),
(9, 3, 1, 9, 2, 4, 10, '200', '-', '-', '-', '200', '200', '200', 9, '2025-09-09 20:08:47', '2025-09-09 20:08:47'),
(10, 3, 1, 10, 1, 4, 11, '37', '-', '-', '-', '37', '37', '37', 10, '2025-09-09 20:10:09', '2025-09-09 20:10:09'),
(11, 3, 1, 11, 1, 4, 12, '1600', '-', '-', '-', '1600', '1600', '3200', 11, '2025-09-09 20:11:18', '2025-09-09 20:17:04'),
(12, 3, 1, 12, 2, 4, 13, '700', '-', '-', '-', '700', '700', '1400', 12, '2025-09-09 20:12:06', '2025-09-09 20:17:18'),
(13, 3, 1, 13, 1, 4, 14, '11', '-', '-', '-', '11', '11', '11', 13, '2025-09-09 20:12:54', '2025-09-09 20:17:43'),
(14, 3, 1, 14, 1, 1, 15, '8', '-', '-', '-', '16', '11', '27', 14, '2025-09-09 20:13:39', '2025-09-09 20:17:59'),
(15, 3, 1, 15, 1, 1, 16, '0', '-', '-', '-', '3', '4', '7', 15, '2025-09-09 20:14:20', '2025-09-09 20:18:18'),
(16, 3, 1, 16, 1, 1, 17, '0', '-', '-', '-', '1', '1', '2', 16, '2025-09-09 20:14:59', '2025-09-09 20:18:57'),
(17, 3, 1, 17, 1, 1, 18, '82', '-', '-', '-', '15', '30', '45', 17, '2025-09-09 20:21:05', '2025-09-09 20:21:05'),
(18, 3, 1, 18, 1, 1, 19, '95', '-', '-', '-', '95', '100', '195', 18, '2025-09-09 20:21:55', '2025-09-09 20:21:55'),
(19, 3, 1, 19, 2, 4, 20, '7', '-', '-', '-', '7', '7', '7', 19, '2025-09-09 20:22:50', '2025-09-09 20:22:50'),
(20, 3, 1, 20, 2, 4, 21, '10', '-', '-', '-', '15', '15', '15', 20, '2025-09-09 20:23:57', '2025-09-09 20:23:57'),
(21, 3, 1, 21, 2, 4, 22, '1', '-', '-', '-', '1', '1', '2', 21, '2025-09-09 20:25:07', '2025-09-09 20:25:07'),
(22, 3, 1, 22, 1, 1, 23, '16', '-', '-', '-', '16', '16', '32', 22, '2025-09-09 20:25:58', '2025-09-09 20:25:58'),
(23, 4, 1, 23, 1, 1, 24, '7328', '-', '-', '-', '7328', '7328', '14476', 23, '2025-09-09 20:29:03', '2025-09-09 20:29:03'),
(24, 4, 1, 24, 1, 1, 25, '1400', '-', '-', '-', '1400', '1400', '2800', 24, '2025-09-09 20:29:50', '2025-09-09 20:29:50'),
(25, 4, 1, 25, 1, 1, 26, '15', '-', '-', '-', '15', '15', '15', 25, '2025-09-09 20:30:59', '2025-09-09 20:30:59'),
(26, 4, 1, 26, 2, 4, 27, '0', '-', '-', '-', '0.0.1', '0.0.1', '0.0.1', 26, '2025-09-09 20:32:46', '2025-09-09 20:32:46'),
(27, 1, 2, 27, 1, 1, 28, '0', '-', '-', '-', '0', '1', '1', 27, '2025-09-09 20:36:33', '2025-09-09 20:36:33'),
(28, 1, 2, 28, 1, 1, 29, '0', '-', '-', '-', '1', '1', '1', 28, '2025-09-09 20:58:42', '2025-09-09 20:58:42'),
(29, 1, 2, 29, 1, 1, 30, '0', '-', '-', '-', '0', '1', '1', 29, '2025-09-09 20:59:26', '2025-09-09 20:59:26'),
(30, 1, 2, 30, 1, 1, 31, '0', '-', '-', '-', '1', '1', '1', 30, '2025-09-09 21:00:10', '2025-09-09 21:00:10'),
(31, 1, 2, 31, 1, 1, 32, '0', '-', '-', '-', '5', '5', '10', 31, '2025-09-09 21:00:55', '2025-09-09 21:00:55'),
(32, 1, 2, 32, 1, 1, 33, '0', '-', '-', '-', '5', '5', '10', 32, '2025-09-09 21:01:39', '2025-09-09 21:01:39'),
(33, 1, 2, 33, 1, 3, 34, '0', '-', '-', '-', '1.9', '2', '2', 33, '2025-09-09 21:04:21', '2025-09-09 21:04:21'),
(34, 1, 2, 34, 1, 3, 35, '0', '-', '-', '-', '1.9', '2', '2', 34, '2025-09-09 21:05:06', '2025-09-09 21:05:06'),
(35, 1, 2, 35, 1, 2, 36, '0', '-', '-', '-', '97', '97', '97', 35, '2025-09-09 21:06:04', '2025-09-09 21:07:37'),
(36, 1, 2, 36, 1, 2, 37, '10', '-', '-', '-', '10', '10', '20', 36, '2025-09-09 21:07:22', '2025-09-09 21:07:22'),
(37, 1, 2, 37, 1, 1, 38, '230', '-', '-', '-', '202', '202', '404', 37, '2025-09-09 21:08:47', '2025-09-09 21:08:47'),
(38, 1, 2, 38, 1, 2, 39, '0', '-', '-', '-', '1', '1', '2', 38, '2025-09-09 21:09:25', '2025-09-09 21:09:25'),
(39, 1, 2, 39, 1, 2, 40, '0', '-', '-', '-', '1', '1', '1', 39, '2025-09-09 21:09:56', '2025-09-09 21:09:56'),
(40, 2, 2, 40, 1, 1, 41, '0', '-', '-', '-', '0', '1', '1', 40, '2025-09-09 21:11:34', '2025-09-09 21:11:34'),
(41, 2, 2, 41, 1, 1, 42, '0', '-', '-', '-', '0', '1', '1', 41, '2025-09-09 21:12:15', '2025-09-09 21:12:15'),
(42, 2, 2, 42, 1, 1, 43, '0', '-', '-', '-', '10', '10', '20', 42, '2025-09-09 21:13:24', '2025-09-09 21:13:24'),
(43, 2, 2, 43, 1, 1, 44, '0', '-', '-', '-', '1', '1', '2', 43, '2025-09-09 21:14:37', '2025-09-09 21:14:37'),
(44, 2, 2, 44, 2, 4, 45, '0', '-', '-', '-', '2', '2', '4', 44, '2025-09-09 21:15:22', '2025-09-09 21:15:22'),
(45, 2, 2, 45, 2, 4, 46, '0', '-', '-', '-', '5', '5', '10', 45, '2025-09-09 21:16:01', '2025-09-09 21:16:01'),
(46, 2, 2, 46, 1, 1, 47, '0', '-', '-', '-', '80', '80', '160', 46, '2025-09-09 21:16:57', '2025-09-09 21:16:57'),
(47, 2, 2, 47, 2, 4, 48, '0', '-', '-', '-', '1', '1', '2', 47, '2025-09-09 21:17:35', '2025-09-09 21:17:35'),
(48, 3, 2, 48, 2, 4, 49, '0', '-', '-', '-', '1', '1', '2', 48, '2025-09-09 21:19:06', '2025-09-09 21:19:06'),
(49, 3, 2, 49, 2, 4, 50, '0', '-', '-', '-', '1', '1', '2', 49, '2025-09-09 21:19:54', '2025-09-09 21:19:54'),
(50, 3, 2, 50, 2, 4, 51, '0', '-', '-', '-', '9', '9', '18', 50, '2025-09-09 21:20:39', '2025-09-09 21:20:39'),
(51, 3, 2, 51, 2, 4, 52, '0', '-', '-', '-', '37', '37', '74', 51, '2025-09-09 21:21:22', '2025-09-09 21:21:22'),
(52, 3, 2, 52, 2, 4, 53, '0', '-', '-', '-', '0', '1', '1', 52, '2025-09-09 21:21:52', '2025-09-09 21:21:52'),
(53, 3, 2, 53, 2, 4, 54, '0', '-', '-', '-', '0', '1', '1', 53, '2025-09-09 21:22:26', '2025-09-09 21:22:26'),
(54, 1, 3, 54, 1, 1, 55, '0', '-', '-', '-', '1', '1', '2', 54, '2025-09-09 21:24:04', '2025-09-09 21:24:04'),
(55, 1, 3, 55, 1, 1, 56, '0', '-', '-', '-', '1', '1', '2', 55, '2025-09-09 21:27:44', '2025-09-09 21:27:44'),
(56, 1, 3, 56, 1, 1, 57, '0', '-', '-', '-', '1', '1', '2', 56, '2025-09-09 21:28:15', '2025-09-09 21:28:15'),
(57, 1, 3, 57, 1, 1, 58, '0', '-', '-', '-', '1', '1', '2', 57, '2025-09-09 21:29:03', '2025-09-09 21:29:03'),
(58, 1, 3, 58, 2, 4, 59, '0', '-', '-', '-', '0', '1', '1', 58, '2025-09-09 21:29:37', '2025-09-09 21:29:37'),
(59, 1, 3, 59, 1, 1, 60, '0', '-', '-', '-', '1', '1', '2', 59, '2025-09-09 21:30:25', '2025-09-09 21:30:25'),
(60, 2, 3, 60, 1, 1, 61, '0', '-', '-', '-', '1', '1', '2', 60, '2025-09-09 21:31:09', '2025-09-09 21:31:09'),
(61, 2, 3, 61, 1, 1, 62, '2', '-', '-', '-', '0', '3', '3', 61, '2025-09-09 21:31:49', '2025-09-09 21:31:49'),
(62, 2, 3, 62, 1, 1, 63, '2', '-', '-', '-', '4', '4', '4', 62, '2025-09-09 21:32:27', '2025-09-09 21:32:27'),
(63, 2, 3, 63, 1, 1, 64, '5', '-', '-', '-', '20', '20', '40', 63, '2025-09-09 21:36:11', '2025-09-09 21:36:11'),
(64, 2, 3, 64, 1, 1, 65, '0', '-', '-', '-', '18', '18', '36', 64, '2025-09-09 21:37:20', '2025-09-09 21:37:20'),
(65, 2, 3, 65, 1, 1, 66, '0', '-', '-', '-', '0', '1', '1', 65, '2025-09-09 21:38:11', '2025-09-09 21:38:11'),
(66, 2, 3, 66, 1, 1, 67, '0', '-', '-', '-', '0', '100', '100', 66, '2025-09-09 21:39:06', '2025-09-09 21:39:06'),
(67, 2, 3, 67, 1, 1, 68, '0', '-', '-', '-', '9', '9', '18', 67, '2025-09-09 21:40:23', '2025-09-09 21:40:23'),
(68, 3, 3, 68, 1, 1, 69, '63', '-', '-', '-', '105', '63', '105', 68, '2025-09-09 21:41:10', '2025-09-09 21:41:10'),
(69, 3, 3, 69, 1, 2, 70, '5', '-', '-', '-', '20', '5', '20', 69, '2025-09-09 21:42:16', '2025-09-09 21:42:16'),
(70, 3, 3, 70, 1, 1, 71, '0', '-', '-', '-', '1', '1', '2', 70, '2025-09-09 21:43:17', '2025-09-09 21:43:17'),
(71, 1, 4, 71, 1, 1, 72, '1', '1', '0', '0', '0', '1', '1', 71, '2025-09-09 21:53:43', '2025-09-09 21:53:43'),
(72, 2, 4, 72, 1, 1, 73, '0', '0', '1', '1', '1', '1', '2', 72, '2025-09-09 21:56:39', '2025-09-09 21:56:39'),
(73, 3, 4, 73, 1, 1, 74, '0', '0', '1', '1', '1', '1', '2', 73, '2025-09-09 21:57:43', '2025-09-09 21:57:43'),
(74, 4, 4, 74, 1, 1, 75, '0', '0', '1', '1', '1', '1', '2', 74, '2025-09-09 21:58:58', '2025-09-09 21:58:58'),
(75, 5, 4, 75, 1, 1, 76, '1', '1', '1', '1', '1', '1', '2', 75, '2025-09-09 21:59:57', '2025-09-09 21:59:57'),
(76, 6, 4, 76, 1, 2, 77, '0', '0', '1', '1', '1', '1', '2', 76, '2025-09-09 22:01:12', '2025-09-09 22:01:12'),
(77, 7, 4, 77, 1, 1, 78, '0', '0', '1', '1', '1', '1', '2', 77, '2025-09-09 22:02:09', '2025-09-09 22:02:09'),
(78, 8, 4, 78, 1, 1, 79, '0', '0', '0', '0', '1', '1', '2', 78, '2025-09-09 22:03:10', '2025-09-09 22:03:10'),
(79, 9, 4, 79, 1, 1, 80, '1', '1', '0', '0', '1', '0', '1', 79, '2025-09-09 22:04:01', '2025-09-09 22:04:01'),
(80, 10, 4, 80, 1, 1, 81, '0', '1', '1', '1', '9', '0', '9', 80, '2025-09-09 22:04:57', '2025-09-09 22:04:57'),
(81, 11, 4, 81, 1, 1, 82, '0', '0', '0', '0', '0', '1', '1', 81, '2025-09-09 22:05:53', '2025-09-09 22:05:53'),
(82, 12, 4, 82, 1, 1, 83, '0', '0', '0', '1', '0', '1', '1', 82, '2025-09-09 22:07:20', '2025-09-09 22:07:20'),
(83, 13, 4, 83, 1, 1, 84, '0', '0', '0', '0', '0', '9', '9', 83, '2025-09-09 22:08:15', '2025-09-09 22:08:15'),
(84, 14, 4, 84, 1, 1, 85, '1', '0', '1', '0', '0', '1', '1', 84, '2025-09-09 22:09:17', '2025-09-09 22:09:17'),
(85, 15, 4, 85, 1, 1, 86, '0', '0', '0', '20', '20', '20', '40', 85, '2025-09-09 22:10:27', '2025-09-09 22:10:27'),
(86, 16, 4, 86, 1, 1, 87, '67', '0', '0', '80', '70', '70', '70', 86, '2025-09-09 22:11:31', '2025-09-09 22:11:31'),
(87, 17, 4, 87, 1, 1, 88, '67', '70', '70', '75', '70', '70', '70', 87, '2025-09-09 22:12:26', '2025-09-09 22:12:26'),
(88, 18, 4, 88, 1, 1, 89, '70', '67', '67', '67', '70', '70', '70', 88, '2025-09-09 22:13:27', '2025-09-09 22:13:27'),
(89, 19, 4, 89, 1, 3, 90, '1', '1', '1', '1', '1', '1', '2', 89, '2025-09-10 00:09:22', '2025-09-10 00:09:22'),
(90, 20, 4, 90, 1, 5, 91, '10', '10', '10', '10', '10', '10', '10', 90, '2025-09-10 00:13:04', '2025-09-10 00:13:04'),
(91, 21, 4, 91, 1, 1, 92, '10', '10', '10', '10', '10', '10', '10', 91, '2025-09-10 00:14:36', '2025-09-10 00:14:36'),
(92, 22, 4, 92, 1, 5, 93, '10', '10', '10', '10', '10', '10', '10', 92, '2025-09-10 00:16:41', '2025-09-10 00:16:41'),
(93, 23, 4, 93, 1, 1, 94, '0', '0', '1', '0', '1', '0', '1', 93, '2025-09-10 00:18:35', '2025-09-10 00:18:35'),
(94, 24, 4, 94, 1, 1, 95, '1', '1', '0', '1', '0', '1', '1', 94, '2025-09-10 00:19:48', '2025-09-10 00:19:48'),
(95, 25, 4, 95, 1, 1, 96, '0', '0', '1', '0', '1', '0', '1', 95, '2025-09-10 00:20:39', '2025-09-10 00:20:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_medida`
--

CREATE TABLE `rl_medida` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_medida`
--

INSERT INTO `rl_medida` (`id`, `nombre`) VALUES
(1, 'Unidad'),
(2, 'Paquete'),
(3, 'Sin requerimiento'),
(4, 'Meses'),
(5, 'Pasaje'),
(6, 'Anual'),
(7, 'Metro'),
(8, 'Caja'),
(9, 'Litro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_medida_bienservicio`
--

CREATE TABLE `rl_medida_bienservicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `formulario5_id` bigint(20) UNSIGNED NOT NULL,
  `medida_id` bigint(20) UNSIGNED NOT NULL,
  `cantidad` varchar(20) DEFAULT NULL,
  `precio_unitario` varchar(50) DEFAULT NULL,
  `total_presupuesto` decimal(50,2) UNSIGNED DEFAULT NULL,
  `total_monto` decimal(50,2) UNSIGNED DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `tipo_financiamiento_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_requerida` date NOT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_medida_bienservicio`
--

INSERT INTO `rl_medida_bienservicio` (`id`, `formulario5_id`, `medida_id`, `cantidad`, `precio_unitario`, `total_presupuesto`, `total_monto`, `descripcion`, `tipo_financiamiento_id`, `fecha_requerida`, `creado_el`, `editado_el`) VALUES
(1, 4, 4, '12', '860.00', 10320.00, 10320.00, NULL, 2, '2026-01-20', '2025-09-15 16:09:15', '2025-09-15 16:09:15'),
(2, 4, 6, '1', '3,741.00', 3741.00, 3741.00, NULL, 2, '2026-01-20', '2025-09-16 13:16:05', '2025-09-16 13:16:05'),
(3, 4, 6, '1', '3,741.00', 3741.00, 3741.00, NULL, 2, '2026-01-20', '2025-09-16 13:16:58', '2025-09-16 13:16:58'),
(4, 4, 6, '1', '1,260.00', 1260.00, 1260.00, NULL, 2, '2026-01-20', '2025-09-16 13:18:02', '2025-09-16 13:18:02'),
(5, 5, 6, '1', '9,850.00', 9850.00, 9850.00, NULL, 2, '2026-01-20', '2025-09-16 13:42:10', '2025-09-16 13:42:10'),
(6, 7, 2, '30000', '0.06', 1800.00, 1800.00, NULL, 2, '2026-01-20', '2025-09-16 13:43:55', '2025-09-16 13:43:55'),
(7, 7, 2, '5000', '0.09', 450.00, 450.00, NULL, 2, '2026-01-20', '2025-09-16 13:53:42', '2025-09-16 13:53:42'),
(8, 7, 2, '500', '0.30', 150.00, 150.00, NULL, 2, '2026-01-20', '2025-09-16 13:54:10', '2025-09-16 13:54:10'),
(9, 7, 1, '40', '26.00', 1040.00, 1040.00, NULL, 2, '2026-01-20', '2025-09-16 13:54:49', '2025-09-16 13:54:49'),
(10, 7, 1, '15', '5', 75.00, 75.00, NULL, 2, '2026-01-20', '2025-09-16 16:08:03', '2025-09-16 16:08:03'),
(11, 7, 1, '8', '120.00', 960.00, 960.00, NULL, 2, '2026-01-20', '2025-09-16 16:08:26', '2025-09-16 16:08:26'),
(12, 7, 1, '5', '10', 50.00, 50.00, NULL, 2, '2026-01-20', '2025-09-16 16:08:49', '2025-09-16 16:08:49'),
(13, 7, 1, '10', '30', 300.00, 300.00, NULL, 2, '2026-01-20', '2025-09-16 16:10:06', '2025-09-16 16:10:06'),
(14, 7, 1, '150', '3', 450.00, 450.00, NULL, 2, '2026-01-20', '2025-09-16 16:10:26', '2025-09-16 16:10:26'),
(15, 7, 1, '50', '2.20', 110.00, 110.00, NULL, 2, '2026-01-20', '2025-09-16 16:10:50', '2025-09-16 16:10:50'),
(16, 7, 1, '50', '2.50', 125.00, 125.00, NULL, 2, '2026-01-20', '2025-09-16 16:11:10', '2025-09-16 16:11:10'),
(17, 7, 1, '30', '6', 180.00, 180.00, NULL, 2, '2026-01-20', '2025-09-16 16:11:29', '2025-09-16 16:11:29'),
(18, 7, 8, '12', '5', 60.00, 60.00, NULL, 2, '2026-01-20', '2025-09-16 16:11:50', '2025-09-16 16:11:50'),
(19, 7, 8, '10', '9', 90.00, 90.00, NULL, 2, '2026-01-20', '2025-09-16 16:12:08', '2025-09-16 16:12:08'),
(20, 7, 8, '10', '13', 130.00, 130.00, NULL, 2, '2026-01-20', '2025-09-16 16:12:31', '2025-09-16 16:12:31'),
(21, 7, 1, '12', '15', 180.00, 180.00, NULL, 2, '2026-01-20', '2025-09-16 16:12:53', '2025-09-16 16:12:53'),
(22, 7, 1, '50', '2', 100.00, 100.00, NULL, 2, '2026-01-20', '2025-09-16 16:13:11', '2025-09-16 16:13:11'),
(23, 7, 1, '10', '7', 70.00, 70.00, NULL, 2, '2026-01-20', '2025-09-16 16:13:27', '2025-09-16 16:13:27'),
(24, 7, 1, '12', '8', 96.00, 96.00, NULL, 2, '2026-01-20', '2025-09-16 16:13:47', '2025-09-16 16:13:47'),
(25, 7, 1, '2', '62', 124.00, 124.00, NULL, 2, '2026-01-20', '2025-09-16 16:14:06', '2025-09-16 16:14:06'),
(26, 7, 1, '2', '50', 100.00, 100.00, NULL, 2, '2026-01-20', '2025-09-16 16:14:25', '2025-09-16 16:14:25'),
(27, 7, 1, '1', '250.00', 250.00, 250.00, NULL, 2, '2026-01-20', '2025-09-16 16:14:52', '2025-09-16 16:14:52'),
(28, 7, 1, '5', '10', 50.00, 50.00, NULL, 2, '2026-01-20', '2025-09-16 16:15:12', '2025-09-16 16:15:12'),
(29, 7, 1, '12', '5', 60.00, 60.00, NULL, 2, '2026-01-20', '2025-09-16 16:15:30', '2025-09-16 16:15:30'),
(30, 7, 1, '12', '6', 72.00, 72.00, NULL, 2, '2026-01-20', '2025-09-16 16:15:45', '2025-09-16 16:15:45'),
(31, 7, 1, '10', '15', 150.00, 150.00, NULL, 2, '2026-01-20', '2025-09-16 16:16:04', '2025-09-16 16:16:04'),
(32, 7, 1, '5', '25', 125.00, 125.00, NULL, 2, '2026-01-20', '2025-09-16 16:17:26', '2025-09-16 16:17:26'),
(33, 7, 1, '15', '15', 225.00, 225.00, NULL, 2, '2026-01-20', '2025-09-16 16:17:45', '2025-09-16 16:17:45'),
(34, 7, 1, '8', '980.00', 7840.00, 7840.00, NULL, 2, '2026-01-20', '2025-09-16 16:18:08', '2025-09-16 16:18:08'),
(35, 7, 1, '5', '5', 25.00, 25.00, NULL, 2, '2026-01-20', '2025-09-16 16:18:26', '2025-09-16 16:18:26'),
(36, 7, 1, '30', '8', 240.00, 240.00, NULL, 2, '2026-01-20', '2025-09-16 16:18:41', '2025-09-16 16:18:41'),
(37, 7, 1, '1', '780.00', 780.00, 780.00, NULL, 2, '2026-01-20', '2025-09-16 16:19:03', '2025-09-16 16:19:03'),
(38, 8, 1, '5', '26', 130.00, 130.00, NULL, 2, '2026-01-20', '2025-09-16 16:20:00', '2025-09-16 16:20:00'),
(39, 8, 1, '4', '24', 96.00, 96.00, NULL, 2, '2026-01-20', '2025-09-16 16:20:23', '2025-09-16 16:20:23'),
(40, 8, 1, '1', '22', 22.00, 22.00, NULL, 2, '2026-01-20', '2025-09-16 16:20:39', '2025-09-16 16:20:39'),
(41, 8, 1, '10', '16', 160.00, 160.00, NULL, 2, '2026-01-20', '2025-09-16 16:20:54', '2025-09-16 16:20:54'),
(42, 8, 1, '5', '5', 25.00, 25.00, NULL, 2, '2026-01-20', '2025-09-16 16:21:12', '2025-09-16 16:21:12'),
(43, 8, 1, '4', '22', 88.00, 88.00, NULL, 2, '2026-01-20', '2025-09-16 16:21:34', '2025-09-16 16:21:34'),
(44, 8, 1, '10', '7', 70.00, 70.00, NULL, 2, '2026-01-20', '2025-09-16 16:21:50', '2025-09-16 16:21:50'),
(45, 8, 1, '10', '10', 100.00, 100.00, NULL, 2, '2026-01-20', '2025-09-16 16:22:09', '2025-09-16 16:22:09'),
(46, 8, 1, '6', '12', 72.00, 72.00, NULL, 2, '2026-01-20', '2025-09-16 16:22:26', '2025-09-16 16:22:26'),
(47, 8, 1, '6', '8', 48.00, 48.00, NULL, 2, '2026-01-20', '2025-09-16 16:22:49', '2025-09-16 16:22:49'),
(48, 8, 1, '6', '35', 210.00, 210.00, NULL, 2, '2026-01-20', '2025-09-16 16:29:59', '2025-09-16 16:29:59'),
(49, 8, 1, '4', '13', 52.00, 52.00, NULL, 2, '2026-01-20', '2025-09-16 16:30:15', '2025-09-16 16:30:15'),
(50, 8, 1, '2', '15', 30.00, 30.00, NULL, 2, '2026-01-20', '2025-09-16 16:30:29', '2025-09-16 16:30:29'),
(51, 8, 1, '2', '15', 30.00, 30.00, NULL, 2, '2026-01-20', '2025-09-16 16:30:46', '2025-09-16 16:30:46'),
(52, 8, 1, '5', '20', 100.00, 100.00, NULL, 2, '2026-01-20', '2025-09-16 16:30:59', '2025-09-16 16:30:59'),
(53, 6, 1, '1', '850.00', 850.00, 850.00, NULL, 2, '2026-01-20', '2025-09-16 16:34:11', '2025-09-16 16:34:11'),
(54, 6, 1, '15', '7', 105.00, 105.00, NULL, 2, '2026-01-20', '2025-09-16 16:34:38', '2025-09-16 16:34:38'),
(55, 6, 1, '5', '25', 125.00, 125.00, NULL, 2, '2026-01-20', '2025-09-16 16:34:53', '2025-09-16 16:34:53'),
(56, 6, 1, '2', '1,800.00', 3600.00, 3600.00, NULL, 2, '2026-01-20', '2025-09-16 16:35:15', '2025-09-16 16:35:15'),
(57, 6, 1, '1', '1,950.00', 1950.00, 1950.00, NULL, 2, '2026-01-20', '2025-09-16 16:35:42', '2025-09-16 16:35:42'),
(58, 6, 1, '1', '980.00', 980.00, 980.00, NULL, 2, '2026-01-20', '2025-09-16 16:36:06', '2025-09-16 16:36:06'),
(59, 6, 1, '5', '150.00', 750.00, 750.00, NULL, 2, '2026-01-20', '2025-09-16 16:36:24', '2025-09-16 16:36:24'),
(60, 6, 1, '15', '20', 300.00, 300.00, NULL, 2, '2026-01-20', '2025-09-16 16:36:39', '2025-09-16 16:36:39'),
(61, 6, 1, '35', '25', 875.00, 875.00, NULL, 2, '2026-01-20', '2025-09-16 16:36:56', '2025-09-16 16:36:56'),
(62, 6, 7, '20', '22', 440.00, 440.00, NULL, 2, '2026-01-20', '2025-09-16 16:37:22', '2025-09-16 16:37:22'),
(63, 6, 1, '2', '185.00', 370.00, 370.00, NULL, 2, '2026-01-20', '2025-09-16 16:37:43', '2025-09-16 16:37:43'),
(64, 6, 1, '6', '5', 30.00, 30.00, NULL, 2, '2026-01-20', '2025-09-16 16:37:59', '2025-09-16 16:37:59'),
(65, 6, 1, '2', '150.00', 300.00, 300.00, NULL, 2, '2026-01-20', '2025-09-16 16:38:17', '2025-09-16 16:38:17'),
(66, 6, 1, '3', '20', 60.00, 60.00, NULL, 2, '2026-01-20', '2025-09-16 16:38:36', '2025-09-16 16:38:36'),
(67, 6, 1, '10', '35', 350.00, 350.00, NULL, 2, '2026-01-20', '2025-09-16 16:38:55', '2025-09-16 16:38:55'),
(68, 6, 1, '5', '60', 300.00, 300.00, NULL, 2, '2026-01-20', '2025-09-16 16:39:14', '2025-09-16 16:39:14'),
(69, 6, 1, '2', '200.00', 400.00, 400.00, NULL, 2, '2026-01-20', '2025-09-16 16:39:34', '2025-09-16 16:39:34'),
(70, 6, 1, '4', '150.00', 600.00, 600.00, NULL, 2, '2026-01-20', '2025-09-16 16:39:56', '2025-09-16 16:39:56'),
(71, 6, 1, '1', '184.00', 184.00, 184.00, NULL, 2, '2026-01-20', '2025-09-16 16:40:15', '2025-09-16 16:40:15'),
(72, 6, 1, '500', '1.50', 750.00, 750.00, NULL, 2, '2026-01-20', '2025-09-16 16:40:32', '2025-09-16 16:40:32'),
(73, 6, 9, '4', '70', 280.00, 280.00, NULL, 2, '2026-01-20', '2025-09-16 16:46:03', '2025-09-16 16:46:03'),
(74, 6, 1, '200', '7', 1400.00, 1400.00, NULL, 2, '2026-01-20', '2025-09-16 16:46:18', '2025-09-16 16:46:18'),
(75, 6, 1, '15', '40', 600.00, 600.00, NULL, 2, '2026-01-20', '2025-09-16 16:46:34', '2025-09-16 16:46:34'),
(76, 6, 1, '10', '80', 800.00, 800.00, NULL, 2, '2026-01-20', '2025-09-16 16:46:46', '2025-09-16 16:46:46'),
(77, 6, 1, '10', '63', 630.00, 630.00, NULL, 2, '2026-01-20', '2025-09-16 16:47:10', '2025-09-16 16:47:10'),
(78, 6, 1, '1', '550.00', 550.00, 550.00, NULL, 2, '2026-01-20', '2025-09-16 16:47:31', '2025-09-16 16:47:31'),
(79, 6, 1, '50', '1.50', 75.00, 75.00, NULL, 2, '2026-01-20', '2025-09-16 16:48:28', '2025-09-16 16:48:28'),
(80, 6, 1, '3', '130.00', 390.00, 390.00, NULL, 2, '2026-01-20', '2025-09-16 16:48:45', '2025-09-16 16:48:45'),
(81, 6, 1, '2', '100.00', 200.00, 200.00, NULL, 2, '2026-01-20', '2025-09-16 16:49:02', '2025-09-16 16:49:02'),
(82, 6, 1, '1', '1,150.00', 1150.00, 1150.00, NULL, 2, '2026-01-20', '2025-09-16 16:49:22', '2025-09-16 16:49:22'),
(83, 6, 1, '3', '70', 210.00, 210.00, NULL, 2, '2026-01-20', '2025-09-16 16:49:38', '2025-09-16 16:49:38'),
(84, 6, 1, '4', '40', 160.00, 160.00, NULL, 2, '2026-01-20', '2025-09-16 16:49:54', '2025-09-16 16:49:54'),
(85, 6, 1, '24', '24', 576.00, 576.00, NULL, 2, '2026-01-20', '2025-09-16 16:50:11', '2025-09-16 16:50:11'),
(86, 6, 1, '100', '4', 400.00, 400.00, NULL, 2, '2026-01-20', '2025-09-16 16:50:36', '2025-09-16 16:50:36'),
(87, 6, 1, '100', '7', 700.00, 700.00, NULL, 2, '2026-01-20', '2025-09-16 16:50:53', '2025-09-16 16:50:53'),
(88, 6, 1, '2', '975.00', 1950.00, 1950.00, NULL, 2, '2026-01-20', '2025-09-16 16:51:13', '2025-09-16 16:51:13'),
(89, 6, 1, '1', '270.00', 270.00, 270.00, NULL, 2, '2026-01-20', '2025-09-16 16:51:28', '2025-09-16 16:51:28'),
(90, 6, 1, '1', '240.00', 240.00, 240.00, NULL, 2, '2026-01-20', '2025-09-16 16:51:46', '2025-09-16 16:51:46'),
(91, 10, 1, '1', '19,780.00', 19780.00, 19780.00, NULL, 2, '2026-01-20', '2025-09-16 16:52:34', '2025-09-16 16:52:34'),
(92, 10, 1, '1', '6,000.00', 6000.00, 6000.00, NULL, 2, '2026-01-20', '2025-09-16 16:53:00', '2025-09-16 16:53:00'),
(93, 10, 1, '1', '2,400.00', 2400.00, 2400.00, NULL, 2, '2026-01-20', '2025-09-16 16:53:20', '2025-09-16 16:53:20'),
(94, 10, 1, '2', '2,100.00', 4200.00, 4200.00, NULL, 2, '2026-01-20', '2025-09-16 16:53:39', '2025-09-16 16:53:39'),
(95, 10, 1, '1', '4,350.00', 4350.00, 4350.00, NULL, 2, '2026-01-20', '2025-09-16 16:54:02', '2025-09-16 16:54:02'),
(96, 10, 1, '4', '680.00', 2720.00, 2720.00, NULL, 2, '2026-01-20', '2025-09-16 16:54:24', '2025-09-16 16:54:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_objetivo_estrategico`
--

CREATE TABLE `rl_objetivo_estrategico` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `id_politica_desarrollo` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_objetivo_estrategico`
--

INSERT INTO `rl_objetivo_estrategico` (`id`, `codigo`, `descripcion`, `id_politica_desarrollo`) VALUES
(1, 1, 'Desarrollar una Gestión Curricular diversificada para una formación integral, flexible y de calidad y pertinencia social', 1),
(2, 2, 'Mejorar el desempeño docente a través de una formación y actualización continua de los académicos en el campo pedagógico y de las disciplinas', 2),
(3, 3, 'Desarrollar programas de Formación Profesional de Gradi con calidad, regularidad y pertienencia social en las diferentes áreas de la ciencia', 3),
(4, 4, 'Asegurar la calidad académica de los programas profesionales de Grado', 3),
(5, 5, 'Desarrollar Programas de Formación Posgradual de excelencia articulados al Grado y y que respondan con calidad y pertinencia a las demandas  y necesidad de la sociedad', 3),
(6, 6, 'Optimizar la otorgación de becas a los estudiantes para premiar a los mejores y para dotar de condiciones a estudiantes de escasos recursos economcos', 4),
(7, 7, 'Mejorar el rendimiento academico de los estudiantes universitarios de grado', 4),
(8, 1, 'Fortalecer la planificacion y estructura organizacional del proceso de investigacion', 6),
(9, 2, 'Asegurar el soporte financiero para el desarrollo del proceso de investigación', 6),
(10, 3, 'Fortalecer los recursos humanos para el desarrollo del proceso de investigación', 6),
(11, 4, 'Desarrollar procesos de investigación de impacto socioeconomico y de reconocimiento internacional', 7),
(12, 5, 'Desarrollar proyectos de investigación estratégicos de alto impacto a partir de las demandas regionales y nacionales que contribuyan al desarrollo economico y social sustentable', 7),
(13, 6, 'Desarrollar una red nacional de información, registro y difusion científica y tecnológica', 8),
(14, 1, 'Desarrollar eventos, convenios y proyectos de interacción social', 9),
(15, 2, 'Fortalecer la difusión y transferencia de conocimientos, hacia los sectores urbanos y rurales para mejorar su calidad de vida', 9),
(16, 3, 'Desarrollar programas de servicio a la comunidad', 10),
(17, 4, 'Fomentar la creación artística y la actividad cultural en la Universidad, en el marco de un proceso de interacción con la sociedad', 10),
(18, 5, 'Promover la actividad deportiva en la comunidad universitaria  con sentido de integración con la sociedad', 10),
(19, 6, 'Asegurar los recursos humanos para la interacción social y la extensión universitaria', 11),
(20, 7, 'Promover una cultura de gestión ambiental', 11),
(21, 27, '27', 12),
(22, 28, '28', 39),
(23, 29, '29', 40),
(24, 30, '30', 41),
(25, 31, '31', 42),
(26, 32, '32', 43),
(27, 33, '33', 44),
(28, 34, '34', 45),
(29, 35, '35', 46),
(30, 36, '36', 47),
(31, 1, 'Fortalecer el desarrollo de una cultura de planificación, de control de gestión y de evaluación Universitaria', 48),
(32, 1, 'Implementar los Sistemas de Gestion por Resultados y Gestion de la Calidad para la mejora continua de las Universidades', 49),
(33, 1, 'Fortalecer la infraestructura fisica y el equipamiento para pontenciar el desarrollo institucional', 50),
(34, 1, 'Lograr mayores niveles de eficacia, eficiencia y de sostenibilidad financiera', 51);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_objetivo_estrategico_sub`
--

CREATE TABLE `rl_objetivo_estrategico_sub` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `id_politica_desarrollo` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_objetivo_estrategico_sub`
--

INSERT INTO `rl_objetivo_estrategico_sub` (`id`, `codigo`, `descripcion`, `id_politica_desarrollo`) VALUES
(1, 1, 'Desarrollar una Gestión Curricular diversificada para una formación integral, flexible de calidad y pertinencia social', 5),
(2, 2, 'Mejorar el desempeño docente a través de una formación y actualización continua de los académicos en el campo pedagógico y de las disciplinas', 13),
(3, 3, 'Formar profesionales de grado en diferentes disciplinas del conocimiento con calidad y pertinencia social', 14),
(4, 4, 'Optimizar la formación académica de profesionales a través de la calidad educativa en las Carreras de Grado', 15),
(5, 5, 'Desarrollar programas de Posgrado con calidad académica en diversas disciplinas que respondan las necesidadesl del entorno social', 16),
(6, 6, 'Fortalecer las lineas de investigacion científicas, tecnológicas, sociales y humanísticas de posgrado en todos los programas.', 17),
(7, 7, 'Administrar la otorgación de becas a los estudiantes para impulsar la permanencia y dotar de condiciones a estudiantes de escasos recursos económicos.', 18),
(8, 8, 'Mejorar el rendimiento academico de los estudiantes universitarios de grado', 19),
(9, 20, 'Fortalecer el relacionamiento y la cooperación internacional de la Universidad con organismos y universidades del exterior', 33),
(10, 21, 'Asegurar la movilidad docente, estudiantil y administrativa para optimizar el aprendizaje institucional, el intercambio de buenas prácticas y la ejecución de proyectos con la cooperación internacional, en el marco del desarrollo académico, investigativo y la interacción', 33),
(11, 22, 'Fortalecer el desarrollo de una cultura de planificación, de control de gestión y de evaluación Universitaria', 34),
(12, 23, 'Implementar los Sistemas de Gestión por Resultados y Gestión de la Calidad para la mejora continua de la Universidad', 35),
(13, 24, 'Usar eficientemente las tecnologías de información y comunicación para el soporte a los procesos académicos y administrativos, y el desarrollo de la educación virtual', 35),
(14, 26, 'Lograr mayores niveles de eficacia, eficiencia y de sostenibilidad financiera', 36),
(15, 27, 'Fortalecer la infraestructura física y el equipamiento para potenciar el desarrollo institucional', 36),
(16, 28, 'Potenciar las capacidades de las autoridades, el personal docente, los investigadores y los administrativos de la Universidad', 37),
(17, 29, 'Fomentar el respeto a los derechos humanos, la equidad de género, y a las personas con discapacidad', 38),
(18, 1, 'Planificar y consolidar la estructura del proceso de investigación', 20),
(19, 2, 'Gestionar recursos económicos que garanticen los procesos de investigación', 21),
(20, 3, 'Capacitar y fortalecer el recurso humano en los procesos de investigación', 22),
(21, 4, 'Desarrollar procesos de investigación de impacto socio economico y reconocimiento internacional', 23),
(22, 5, 'Desarrollar proyectos de investigación estratégicos de alto impacto a partir de las demandas regionales y nacionales que contribuyan al desarrollo economico y social sustentable', 24),
(23, 6, 'Desarrollar una red nacional de información, registro y difusion científica y tecnológica', 25),
(24, 1, 'Fomentar el relacionamiento entre Universidad y sociedad a través de eventos, convenios y proyectos de interacción social', 26),
(25, 2, 'Optimizar la comunicación y difusión oportuna de las actividades universitarias internas y externas', 27),
(26, 3, 'Contribuir al desarrollo social, economico y cultural a nivel local, departamental y nacional, priorizando necesidades de los sectores vulnerables en el entorno de la Universidad', 28),
(27, 4, 'Fomentar el desarrollo de actividades culturales, deportivas y arstisticas en el marco de un proceso de interacción con la sociedad', 29),
(28, 5, 'Promover la actividad deportiva en la comunidad universitaria', 30),
(29, 6, 'Asegurar los recursos humanos para la interacción social y la extensión universitaria', 31),
(30, 7, 'Promover una cultura de gestión ambiental', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_objetivo_institucional`
--

CREATE TABLE `rl_objetivo_institucional` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `id_objetivo_estrategico_sub` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_objetivo_institucional`
--

INSERT INTO `rl_objetivo_institucional` (`id`, `codigo`, `descripcion`, `id_objetivo_estrategico_sub`) VALUES
(1, 1, 'Desarrollar una Gestión Curricular diversificada para una formación integral, flexible de calidad y pertinencia social', 1),
(2, 8, 'Mejorar el rendimiento academico de los estudiantes universitarios de grado', 8),
(3, 2, 'Mejorar el desempeño docente a través de una formación y actualización continua de los académicos en el campo pedagógico y de las disciplinas', 2),
(4, 3, 'Formar profesionales de grado en diferentes disciplinas del conocimiento con calidad y pertinencia social', 3),
(5, 4, 'Optimizar la formación académica de profesionales a través de la calidad educativa en las Carreras de Grado', 4),
(6, 5, 'Desarrollar programas de Posgrado con calidad académica en diversas disciplinas que respondan las necesidadesl del entorno social', 5),
(7, 6, 'Fortalecer las lineas de investigacion científicas, tecnológicas, sociales y humanísticas de posgrado en todos los programas.', 6),
(8, 7, 'Administrar la otorgación de becas a los estudiantes para impulsar la permanencia y dotar de condiciones a estudiantes de escasos recursos económicos.', 7),
(9, 1, 'Fortalecer el relacionamiento y la cooperación internacional de la Universidad con organismos y universidades del exterior', 9),
(10, 2, 'Aumentar la movilidad de docentes y estudiantes de la UPEA, que permita fortalecer la ejecuciónde proyectos academicos con la cooperación internacional, en el marco del desarrollo académico, investigativo y la interacción', 10),
(11, 3, 'Fortalecer el desarrollo de una cultura de planificación, de control de gestión y de evaluación Universitaria', 11),
(12, 4, 'Implementar los Sistemas de Gestión por Resultados para la mejora continua de la Universidad', 12),
(13, 5, 'Usar eficientemente las tecnologías de información y comunicación para el soporte a los procesos académicos y administrativos, y el desarrollo de la educación virtual', 13),
(14, 6, 'Lograr mayores niveles de eficacia, eficiencia y de sostenibilidad financiera', 14),
(15, 7, 'Fortalecer la infraestructura física y el equipamiento para potenciar el desarrollo institucional', 15),
(16, 8, 'Potenciar las capacidades del Personal Administrativo', 16),
(17, 9, 'Fomentar el respeto a los derechos humanos, la equidad de género, y a las personas con discapacidad', 17),
(18, 1, 'Planificar y consolidar la estructura del proceso de investigación', 18),
(19, 2, 'Gestionar recursos económicos que garanticen los procesos de investigación', 19),
(20, 3, 'Capacitar y fortalecer el recurso humano en los procesos de investigación', 20),
(21, 4, 'Desarrollar procesos de investigación de impacto socio economico y reconocimiento internacional', 21),
(22, 5, 'Desarrollar proyectos de investigación estratégicos de alto impacto a partir de las demandas regionales y nacionales que contribuyan al desarrollo economico y social sustentable', 22),
(23, 6, 'Desarrollar una red nacional de información, registro y difusion científica y tecnológica', 23),
(24, 7, 'Promover una cultura de gestión ambiental', 30),
(25, 1, 'Fomentar el relacionamiento entre Universidad y sociedad a través de eventos, convenios y proyectos de interacción social', 24),
(26, 2, 'Optimizar la comunicación y difusión oportuna de las actividades universitarias internas y externas', 25),
(27, 3, 'Contribuir al desarrollo social, economico y cultural a nivel local, departamental y nacional, priorizando necesidades de los sectores vulnerables en el entorno de la Universidad', 26),
(28, 4, 'Fomentar el desarrollo de actividades culturales, deportivas y arstisticas en el marco de un proceso de interacción con la sociedad', 27),
(29, 5, 'Promover la actividad deportiva en la comunidad universitaria', 28),
(30, 6, 'Asegurar los recursos humanos para la interacción social y la extensión universitaria', 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_operaciones`
--

CREATE TABLE `rl_operaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `area_estrategica_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_operacion_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_operaciones`
--

INSERT INTO `rl_operaciones` (`id`, `descripcion`, `area_estrategica_id`, `tipo_operacion_id`) VALUES
(1, 'Gestionar, depurar y organizar la información institucional, asegurando precisión, disponibilidad y acceso oportuno para los usuarios.', 4, 1),
(2, 'Atender, resolver y dar seguimiento a problemas técnicos, garantizando disponibilidad, funcionalidad de los sistemas y satisfacción del usuario.', 4, 1),
(3, 'Planificar, implementar y dar seguimiento a programas de capacitación en sistemas de información, asegurando actualización de conocimientos y habilidades del personal.', 4, 1),
(4, 'Gestionar el pago oportuno de los servicios básicos', 4, 1),
(5, 'Gestionar el pago oportuno de los servicios de mantenimiento de vehículos, equipos y maquinarias', 4, 1),
(6, 'Gestionar el pago oportuno de equipos y cables de comunicación, herramientas, y ensumos para mantenimiento y asistencia técnica en hardware y software en redes de computadoras y otros', 4, 1),
(7, 'Gestionar el pago oportuno de materiales de escritorio, suministros e insumos necesarios', 4, 1),
(8, 'Gestionar el pago oportuno de materiales de limpieza necesarios para el funcionamiento y mantenimiento de las oficinas', 4, 1),
(9, 'Gestionar el pago oportuno de combustible para los vehículos de la universidad, asegurando la disponibilidad para las operaciones institucionales', 4, 1),
(10, 'Gestionar el pago oportuno de enseres, mobiliarios y equipos necesarios para el funcionamiento eficiente de las oficinas', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_partida_tipo`
--

CREATE TABLE `rl_partida_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_partida_tipo`
--

INSERT INTO `rl_partida_tipo` (`id`, `descripcion`, `estado`) VALUES
(1, 'PRIMERA PARTIDA', 'activo'),
(2, 'SEGUNDA PARTIDA', 'activo'),
(4, 'TERCERA PARTIDA', 'activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_politica_de_desarrollo`
--

CREATE TABLE `rl_politica_de_desarrollo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `id_area_estrategica` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_plan` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_politica_de_desarrollo`
--

INSERT INTO `rl_politica_de_desarrollo` (`id`, `codigo`, `descripcion`, `id_area_estrategica`, `id_tipo_plan`) VALUES
(1, 1, 'Mejoramiento continuo de la Educación Superior con base a las nuevas tendencias y exigencias del contexto', 1, 1),
(2, 2, 'Desarrollo docente para elevar la calidad del proceso enseñanza aprendizaje', 1, 1),
(3, 3, 'Incremento del capital humano nacional mediante aseguramiento de la calidad de la Formación profesional de Grado y Posgrado', 1, 1),
(4, 4, 'Fortalecimiento del bienestar estudiantil para dotar a los universitarios de condiciones de estudio y equipados', 1, 1),
(5, 1, 'Desarrollar una Gestión Curricular diversificada para una formación integral, flexible de calidad y pertinencia social', 1, 2),
(6, 1, 'Optimizar la planificación y organización del proceso de investigación', 2, 1),
(7, 2, 'Optimizar la generacion, la transferecia y la difusion de nuevos conocimientos para el desarrollo del Estado Plurinacional de Bolivia', 2, 1),
(8, 3, 'Difundir los resultados de los procesos de investigacion, desarrollo tecnologico e innovación para el aprovechamiento de la sociedad', 2, 1),
(9, 1, 'Fortalecimiento de la vinculación de la Universidad con la sociedad, medante la interacción social  y extensión universitaria, buscando una correspondencia entre sus productos y servicios, con las necesidades, problemas y demandas de la sociedad', 3, 1),
(10, 2, 'Desarrollo de la cultura y el deporte en la comunidad universitaria para la formación integral de las personas y la sociedad', 3, 1),
(11, 3, 'Fortalecimiento de la gestión de la interacción Social y Extensión Universitaria en cada uno de los Decanatos de la Universidad', 3, 1),
(12, 20, '20', 4, 1),
(13, 2, 'Mejorar el desempeño docente a través de una formación y actualización continua de los académicos en el campo pedagógico y de las disciplinas', 1, 2),
(14, 3, 'Formar profesionales de grado en diferentes disciplinas del conocimiento con calidad y pertinencia social', 1, 2),
(15, 4, 'Optimizar la formación académica de profesionales a través de la calidad educativa en las Carreras de Grado', 1, 2),
(16, 5, 'Desarrollar programas de Posgrado con calidad académica en diversas disciplinas que respondan las necesidadesl del entorno social', 1, 2),
(17, 5, 'Fortalecer las lineas de investigacion científicas, tecnológicas, sociales y humanísticas de posgrado en todos los programas.', 1, 2),
(18, 7, 'Administrar la otorgación de becas a los estudiantes para impulsar la permanencia y dotar de condiciones a estudiantes de escasos recursos económicos.', 1, 2),
(19, 8, 'Mejorar el rendimiento academico de los estudiantes universitarios de grado', 1, 2),
(20, 1, 'Planificar y consolidar la estructura del proceso de investigación', 2, 2),
(21, 2, 'Gestionar recursos económicos que garanticen los procesos de investigación', 2, 2),
(22, 3, 'Capacitar y fortalecer el recurso humano en los procesos de investigación', 2, 2),
(23, 4, 'Desarrollar procesos de investigación de impacto socio economico y reconocimiento internacional', 2, 2),
(24, 5, 'Desarrollar proyectos de investigación estratégicos de alto impacto a partir de las demandas regionales y nacionales que contribuyan al desarrollo economico y social sustentable', 2, 2),
(25, 6, 'Desarrollar una red nacional de información, registro y difusion científica y tecnológica', 2, 2),
(26, 1, 'Fomentar el relacionamiento entre Universidad y sociedad a través de eventos, convenios y proyectos de interacción social', 3, 2),
(27, 2, 'Optimizar la comunicación y difusión oportuna de las actividades universitarias internas y externas', 3, 2),
(28, 3, 'Contribuir al desarrollo social, economico y cultural a nivel local, departamental y nacional, priorizando necesidades de los sectores vulnerables en el entorno de la Universidad', 3, 2),
(29, 4, 'Fomentar el desarrollo de actividades culturales, deportivas y arstisticas en el marco de un proceso de interacción con la sociedad', 3, 2),
(30, 5, 'Promover la actividad deportiva en la comunidad universitaria', 3, 2),
(31, 6, 'Asegurar los recursos humanos para la interacción social y la extensión universitaria', 3, 2),
(32, 7, 'Promover una cultura de gestión ambiental', 3, 2),
(33, 1, 'Internacionalizar la Universidad para reposicionarla en estándares mundiales', 4, 2),
(34, 2, 'Fortalecer la gestión académica, administrati va, financiera y legal de la Universidad en el marco de la Autonomía universitaria y la normativa nacional vigente', 4, 2),
(35, 3, 'Modernizar los sistemas de gestión universitaria para potenciar el desarrollo institucional\r\ny el desarrollo de una cultura de la Transparencia y de Rendición de Cuentas a la sociedad', 4, 2),
(36, 4, 'Fortalecer los resultados de la gestión institucional, financiera, la infraestruct ura física y el equipamiento para potenciar el desarrollo', 4, 2),
(37, 5, 'Fortalecer la gestión del talento humano para el desarrollo del personal académico, investigativo y administrativo de la Universidad', 4, 2),
(38, 6, 'Promover una Universidad Inclusiva, de Equidad y respeto a los derechos humanos', 4, 2),
(39, 21, '21', 4, 1),
(40, 22, '22', 4, 1),
(41, 23, '23', 4, 1),
(42, 24, '24', 4, 1),
(43, 25, '25', 4, 1),
(44, 26, '26', 4, 1),
(45, 27, '27', 4, 1),
(46, 28, '28', 4, 1),
(47, 29, '29', 4, 1),
(48, 2, 'Fortalecer el desarrollo de una cultura de planificación, de control de gestión y de evaluación Universitaria', 4, 1),
(49, 3, 'Implementar los Sistemas de Gestion por Resultados y Gestion de la Calidad para la mejora continua de las Universidades', 4, 1),
(50, 4, 'Fortalecer la infraestructura fisica y el equipamiento para pontenciar el desarrollo institucional', 4, 1),
(51, 1, 'Lograr mayores niveles de eficacia, eficiencia y de sostenibilidad financiera', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_programa_proy_acc_est`
--

CREATE TABLE `rl_programa_proy_acc_est` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` text NOT NULL,
  `id_tipo_prog_acc` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_programa_proy_acc_est`
--

INSERT INTO `rl_programa_proy_acc_est` (`id`, `descripcion`, `id_tipo_prog_acc`) VALUES
(1, '-', 1),
(2, '-', 1),
(3, '-', 1),
(4, '-', 1),
(5, '-', 1),
(6, '-', 1),
(7, '-', 1),
(8, '-', 1),
(9, '-', 1),
(10, '-', 1),
(11, '-', 1),
(12, '-', 1),
(13, '-', 1),
(14, '-', 1),
(15, '-', 1),
(16, '-', 1),
(17, '-', 1),
(18, '-', 1),
(19, '-', 1),
(20, '-', 1),
(21, '-', 1),
(22, '-', 1),
(23, '-', 1),
(24, '-', 1),
(25, '-', 1),
(26, '-', 1),
(27, '-', 1),
(28, '-', 1),
(29, '-', 1),
(30, '-', 1),
(31, '-', 1),
(32, '-', 1),
(33, '-', 1),
(34, '-', 1),
(35, '-', 1),
(36, '-', 1),
(37, '-', 1),
(38, '-', 1),
(39, '-', 1),
(40, '-', 1),
(41, '-', 1),
(42, '-', 1),
(43, '-', 1),
(44, '-', 1),
(45, '-', 1),
(46, '-', 1),
(47, '-', 1),
(48, '-', 1),
(49, '-', 1),
(50, '-', 1),
(51, '-', 1),
(52, '-', 1),
(53, '-', 1),
(54, '-', 1),
(55, '-', 1),
(56, '-', 1),
(57, '-', 1),
(58, '-', 1),
(59, '-', 1),
(60, '-', 1),
(61, '-', 1),
(62, '-', 1),
(63, '-', 1),
(64, '-', 1),
(65, '-', 1),
(66, '-', 1),
(67, '-', 1),
(68, '-', 1),
(69, '-', 1),
(70, '-', 1),
(71, 'Elaboración y aprobación de la estratégia de internacionalización.', 1),
(72, 'Elaboración y aprobación de la estratégia de internacionalización.', 1),
(73, 'Gestión para el ingreso a las REDES de IES por áreas del conocimiento cientifico', 1),
(74, 'Gestión para la suscripción de alianzas estratégicas', 1),
(75, 'Gestión de congreso, seminarios y conferencias internacionales organizados por la Universidad', 1),
(76, 'Gestión para el programa de movilidad institucional para docentes de grado y posgrado', 1),
(77, 'Gestión para el programa de movilidad internacional para estudiantes de grado y posgrado', 1),
(78, 'Gestión para la suscripción de convenios de cooperación internacional y ejecuión de proyectos con financiamiento internacional', 1),
(79, 'Elaboración y aprobación del Plan Estratégico Institucional', 1),
(80, 'Elaboración y aprobación del plan de desarrollo de Áreas', 1),
(81, 'Gestión para el Sistema Integrado de Seguimiento y Evaluación', 1),
(82, 'Elaboración de informes anuales de seguimiento y evaluación del PEI', 1),
(83, 'Elaboración de Planes de Desarrollo Facultativos', 1),
(84, 'Realización del análisis, rediseño e implantación de la estructura organizacional de acuerdo al RE-SOA vigente', 1),
(85, 'Programa de fortalecimiento del sistema de gestión, información y comunicación integrado (en linea)', 1),
(86, 'Seguimiento periodico al cumplmiento de metas del PEI', 1),
(87, 'Gestión para el cumplimiento de los objetivos', 1),
(88, 'Gestión para la ejecución presupuestaria anual', 1),
(89, 'Gestión para el programa de generación de Recursos Propios', 1),
(90, 'Ejecución de Proyectos de inversión en infraestructura física', 1),
(91, 'Ejecución de Proyectos de Inversión con recursos IDH', 1),
(92, 'Ejecución de Proyectos  de inversión en equipamiento y otros', 1),
(93, 'Gestión para los Programas de Formación Continua para el Personal Administrativo', 1),
(94, 'Gestión para la realización de talleres y/o cursos de motivación y compromiso institucional', 1),
(95, 'Gestión para la realización de eventos de fomento al respeto a los derechos humanos, equidad de género y personas con discapacidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_resultado_producto`
--

CREATE TABLE `rl_resultado_producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `codigo` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_resultado_producto`
--

INSERT INTO `rl_resultado_producto` (`id`, `codigo`, `descripcion`) VALUES
(1, 1, 'Carreras con diseños curriculares actualizados, innovados y  pertinentes'),
(2, 1, 'Académicos (Docentes) con grado de Doctor'),
(3, 1, 'Académicos (docentes) con grado de Maestría y/o Especialidad'),
(4, 1, '70% de  asignaturas troncales con docentes del àrea de conocimiento'),
(5, 1, '80% de Docentes que presentan su informe de Desarrollo Curricular'),
(6, 1, '90% de Docentes con evaluación permanente y periódica'),
(7, 1, 'Programas de Formación Continua para docentes en el área de su disciplina'),
(8, 1, 'Incremento de estudiantes matriculados en las 37 Carreras de la Universidad'),
(9, 1, 'Incremento de estudiantes matriculados en las 37 Carreras de la Universidad'),
(10, 1, 'Bachilleres matriculados con promedio de excelencia'),
(11, 1, 'Carreras ofertadas por la Universidad'),
(12, 1, 'Nº de titulados a nivel Licenciatura en diferentes Carreras de la Universidad'),
(13, 1, 'Nª de titulados a nivel Técnico Superior en Carreras que tienen aprobado como parte de su Malla Curricular'),
(14, 1, 'Nª de Sedes desconcentradas en funcionamiento'),
(15, 1, '27 Carreras Autoevaluadas'),
(16, 1, '7 Carreras evaluadas externamente y acreditadas a nivel nacional'),
(17, 1, '2 Carreras universitarias acreditadas internacionalmente'),
(18, 1, 'Programas de posgrado presenciales y semipresenciales en funcionamiento anualmente'),
(19, 1, 'Programas de Posgrado con oferta virtual'),
(20, 1, '7%  de titulados con Grado Académico de Doctorado'),
(21, 1, '15%  de titulados con Grado Académico de Maestría'),
(22, 1, '2  Proyectos de equipamiento para los Programas de Posgrado'),
(23, 1, '32 investigaciones científicas, tecnológicas, sociales y humanísticas en programas de Posgrado publicadas'),
(24, 1, '7238 becas socioecnomicas otorgadas anualmente a las Carreras'),
(25, 1, '1400 becas academicas otorgadas anualmente'),
(26, 1, '15% de estudiantes atendidos anualmente en el Seguro Social Universitario'),
(27, 1, '% de disminución de la tasa de abandono'),
(28, 1, '1 Centro de Investigación e Innovación Tecnológica UPEA equipado (Laboratorio Químico Ambiental)'),
(29, 1, '1 Incubadora de Innovación, Investigación y desarrollo'),
(30, 1, '1 instituto de investigación especializados (Laboratorio Nacional de Salud y Soberanía Alimentaria, biodiversidad y cambio climático)'),
(31, 1, '1 Unidad de Transferencia de Resultados de Investigación implantada'),
(32, 1, '10 Sociedades Científicas de Docentes en funcionamiento para coadyuvar y promover la investigación científica y académica'),
(33, 1, '10 sociedades Científicas de Estudiantes en funcionamiento para coadyuvar y promover la investigación científica y académica'),
(34, 1, 'Presupuesto institucional destinado a Proyectos de investigación'),
(35, 1, '% del Presupuesto institucional destinado a la investigación'),
(36, 1, '97 investigadores a medio tiempo al año'),
(37, 1, '10 investigadores que participan en eventos científicos nacionales por año'),
(38, 1, '202 estudiantes beneficiados con becas de investigación'),
(39, 1, '2 docentes investigadores que publican artículos en revistas indexadas'),
(40, 1, 'Unidad de Capacitación y Formación continua de DICyT UPEA.'),
(41, 1, 'Contratos y convenios nacionales empresa-Estado- universidad'),
(42, 1, '1 proyectos de Investigación ejecutados por el Centro de Investigación e Innovación Tecnológica (CIIT)'),
(43, 1, '20 proyectos de impacto en Desarrollo Productivo y Social'),
(44, 1, '2 revistas publicadas anualmente por área del conocimiento con código ISSN'),
(45, 1, '4 libros publicados con depósito legal, SBN'),
(46, 1, '10 documentos científicos editados'),
(47, 1, '160 Registros de Propiedad Intelectual en SENAPI'),
(48, 1, '2 patentes registrados'),
(49, 1, '1 Feria Institucional Científica y Tecnológica por año'),
(50, 1, '1 resultados del proceso de Investigación transferidos a la Sociedad por año'),
(51, 1, '9 Ferias Institucionales Científicas de Áreas por año'),
(52, 1, '37 ferias Cienficas de Carreras por año'),
(53, 1, '1 bibliotecas Especializadas en Investigación física y virtual'),
(54, 1, '1 imprenta Universitaria'),
(55, 1, '2 Eventos de análisis, discusión y debate orientados a la formación de políticas públicas organizados'),
(56, 1, '2 Convenios suscritos  con Entidades Territoriales'),
(57, 1, '2 Proyectos de interacción social desarrollados'),
(58, 1, 'Realización y/o participación en eventos institucionales de Innovación e Interacción Social'),
(59, 1, 'Estrategia de información y comunicación institucional aplicada en actividades de interacción social'),
(60, 1, '2 medios de comunicación institucional en funcionamiento por año que difunden actividades institucionales de la UPEA'),
(61, 1, 'Programas de orientacion profesional y vocacional desarrollado anualmente'),
(62, 1, 'Eventos institucionales de interacción social (actividades socioculturales de Sedes Académicas)'),
(63, 1, 'Servicios prestados a la sociedad (Centro Infantil, Seguro Social Universitario, Consultorios Comunitarios, Juridicos, etc.) anualmente'),
(64, 1, '40% de actualización de reglamentos y adecuación de métodos de selección y evaluación de benficios de los programas de becas'),
(65, 1, '18 Programas y eventos culturales desarrollados anualmente'),
(66, 1, '1 Infraestructura (Coliseo Deportivo Universitario)'),
(67, 1, '100% de equipamiento deportivo para diferentes disciplinas'),
(68, 1, 'Eventos deportivos desarrollados en diferentes disciplinas por Decanato y/o por Carreras anualmente'),
(69, 1, 'Estudiantes universitarios  (as) con becas en programas/proyectos de interacción social y extensión universitaria anualmente'),
(70, 1, '% del presupuesto total IDH asignado a actividades de interacción social y extensión universitaria anualmente'),
(71, 1, 'Actividades institucional de gestión ambiental anualmente'),
(72, 1, 'Estrategia de internacionalización'),
(73, 1, '4 convenios con IES del exterior'),
(74, 1, '4 participaciones en REDES de IES'),
(75, 1, '4 alianzas estratégicas'),
(76, 1, '5 congresos, seminarios y conferencias internacionales organizadas por la Universidad'),
(77, 1, '4 Docentes de grado y posgrado que participan en programas de movilidad internacional'),
(78, 1, '4 de estudiantes de grado y posgrado que participan en programas de movilidad internacional'),
(79, 1, '2 proyectos ejecutados con financiamiento de la cooperación internacional'),
(80, 1, 'Plan Estratégico Institucional Universitario (PEI) elaborado y en vigencia'),
(81, 1, '9 Áreas que cuentan con Planes de Desarrollo (PDA)'),
(82, 1, 'Sistema Integral de Seguimiento y Evaluación diseñado y en vigencia'),
(83, 1, '2 informes de seguimiento y evaluación del PEI'),
(84, 1, '9 Planes de Desarrollo Facultativos de Áreas Académicas'),
(85, 1, 'Estructura Organizacional flexible, dinamica e innovadora'),
(86, 1, 'Sistema Integrado de Gestión, Información y Comunicación (en línea)'),
(87, 1, '80% de cumplimiento de metas del Plan Estratégico Universitario (PEI)'),
(88, 1, '75% Ejecución del POA'),
(89, 1, '67% de Ejecución presupuestaria anual'),
(90, 1, '5% de incremento en la generación de Recursos Propios'),
(91, 1, '10% de ejecución de Proyectos de inversión en Infraestructura física'),
(92, 1, '10% de ejecución de Proyectos de Inversión con recursos IDH'),
(93, 1, '10% de ejecución de Proyectos de Inversión en Equipamiento y otros'),
(94, 1, '2 de Programas de Formación Continua para el Personal Administrativos'),
(95, 1, '3 talleres y/o cursos de motivación y compromiso institucional ejecutados'),
(96, 1, '2 eventos de fomento al respeto a los derechos humanos, equidad de género y personas con discapacidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo`
--

CREATE TABLE `rl_tipo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo`
--

INSERT INTO `rl_tipo` (`id`, `nombre`) VALUES
(1, 'GESTIÓN'),
(2, 'RESULTADO'),
(3, 'PROCESO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo_carrera`
--

CREATE TABLE `rl_tipo_carrera` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo_carrera`
--

INSERT INTO `rl_tipo_carrera` (`id`, `nombre`) VALUES
(3, 'AREAS'),
(1, 'CARRERAS'),
(2, 'UNIDADES ADMINISTRATIVAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo_foda`
--

CREATE TABLE `rl_tipo_foda` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo_foda`
--

INSERT INTO `rl_tipo_foda` (`id`, `nombre`) VALUES
(4, 'AMENAZAS'),
(3, 'DEBILIDADES'),
(1, 'FORTALEZAS'),
(2, 'OPORTUNIDADES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo_operacion`
--

CREATE TABLE `rl_tipo_operacion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo_operacion`
--

INSERT INTO `rl_tipo_operacion` (`id`, `nombre`) VALUES
(1, 'Funcionamiento'),
(2, 'Producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo_plan`
--

CREATE TABLE `rl_tipo_plan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo_plan`
--

INSERT INTO `rl_tipo_plan` (`id`, `nombre`) VALUES
(1, 'PDU'),
(2, 'PEI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_tipo_programa_acc`
--

CREATE TABLE `rl_tipo_programa_acc` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_tipo_programa_acc`
--

INSERT INTO `rl_tipo_programa_acc` (`id`, `nombre`) VALUES
(1, 'Programa'),
(2, 'Proyecto'),
(3, 'Acción Estratégica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rl_unidad_carrera`
--

CREATE TABLE `rl_unidad_carrera` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `id_tipo_carrera` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rl_unidad_carrera`
--

INSERT INTO `rl_unidad_carrera` (`id`, `nombre_completo`, `estado`, `id_tipo_carrera`) VALUES
(1, 'CARRERA DE INGENIERIA DE SISTEMAS', 'activo', 1),
(2, 'CARRERA DE DERECHO', 'activo', 1),
(3, 'CARRERA DE CIENCIAS DE LA EDUCACION', 'activo', 1),
(4, 'CARRERA DE PALVULARIA', 'activo', 1),
(5, 'CARRERA DE ODONTOLOGÍA', 'activo', 1),
(6, 'CARRERA DE ENFERMERÍA', 'activo', 1),
(7, 'CARRERA DE NUTRICIÓN Y DIETÉTICA', 'activo', 1),
(8, 'CARRERA DE TECNOLOGÍA EN LABORATORIO DENTAL', 'activo', 1),
(9, 'CARRERA DE INGENIERÍA ELECTRÓNICA', 'activo', 1),
(10, 'CARRERA DE INGENIERÍA ELÉCTRICA', 'activo', 1),
(11, 'CARRERA DE INGENIERÍA EN PRODUCCIÓN EMPRESARIAL', 'activo', 1),
(12, 'CARRERA DE INGENIERÍA AUTOTRÓNICA', 'activo', 1),
(13, 'CARRERA DE INGENIERÍA TEXTIL', 'activo', 1),
(14, 'CARRERA DE INGENIERÍA AMBIENTAL', 'activo', 1),
(15, 'CARRERA DE ECONOMÍA', 'activo', 1),
(16, 'CARRERA DE CONTADURÍA PÚBLICA', 'activo', 1),
(17, 'CARRERA DE ADMINISTRACIÓN DE EMPRESAS', 'activo', 1),
(18, 'CARRERA DE GESTIÓN TURÍSTICA Y HOTELERA ', 'activo', 1),
(19, 'CARRERA DE COMERCIO INTERNACIONAL', 'activo', 1),
(20, 'CARRERA DE MEDICINA VETERINARIA Y ZOOTECNIA', 'activo', 1),
(21, 'CARRERA DE INGENIERÍA EN ZOOTECNIA E INDUSTRIA PECUARIA', 'activo', 1),
(22, 'CARRERA DE INGENIERÍA AGRONÓMICA', 'activo', 1),
(23, 'CARRERA DE SOCIOLOGÍA ', 'activo', 1),
(24, 'CARRERA DE TRABAJO SOCIAL', 'activo', 1),
(25, 'CARRERA DE CIENCIAS DE LA COMUNICACIÓN SOCIAL', 'activo', 1),
(26, 'CARRERA DE PSICOLOGÍA', 'activo', 1),
(27, 'CARRERA DE CIENCIAS DEL DESARROLLO', 'activo', 1),
(28, 'CARRERA DE HISTORIA', 'activo', 1),
(29, 'CARRERA DE LINGÜÍSTICA E IDIOMAS', 'activo', 1),
(30, 'CARRERA DE PSICOMOTRICIDAD Y DEPORTES', 'activo', 1),
(31, 'CARRERA DE ARQUITECTURA ', 'activo', 1),
(32, 'CARRERA DE ARTES PLÁSTICAS', 'activo', 1),
(33, 'CARRERA DE INGENIERÍA DE GAS Y PETROQUÍMICA', 'activo', 1),
(34, 'CARRERA DE INGENIERÍA CIVIL', 'activo', 1),
(35, 'CARRERA DE CIENCIAS POLÍTICAS', 'activo', 1),
(36, 'RECTORADO', 'activo', 2),
(37, 'VICERRECTORADO', 'activo', 2),
(38, 'SECRETARÍA ACADÉMICA', 'activo', 2),
(39, 'DECANATOS DE ÁREA Y CARRERA', 'activo', 2),
(40, 'DIRECCIÓN DE POSGRADO', 'activo', 2),
(41, 'UNIDAD DE TECNOLOGIAS DE INFORMACION Y COMUNICACIONES (UTIC)', 'activo', 2),
(42, 'DIRECCIÓN DE ASESORIA JURÍDICA', 'activo', 2),
(43, 'DIRECCIÓN ADMINISTRATIVA FINANCIERA (DAF)', 'activo', 2),
(44, 'UNIDAD DEL SEGURO SOCIAL UNIVERSITARIO', 'activo', 2),
(45, 'INSTITUTOS DE INVESTIGACIÓN', 'activo', 2),
(46, 'UNIDAD DE DESARROLLO ESTRATÉGICO Y PLANIFICACIÓN', 'activo', 2),
(47, 'CARRERAS', 'activo', 2),
(48, 'DIRECCIÓN DE INVESTIGACIÓN,CIENCIA Y TECNOLOGÍA', 'activo', 2),
(49, 'DIRECCIÓN DE INTERACCIÓN SOCIAL, BIENESTAR ESTUDIANTI, DEPORTES Y CULTURA (DISBEDC)', 'activo', 2),
(50, 'UNIDAD DE RELACIONES INTERNACIONALES', 'activo', 2),
(51, 'TV UPEA, RADIO UPEA', 'activo', 2),
(52, 'DECANATURAS', 'activo', 2),
(53, 'UNIDAD DE PRESUPUESTOS', 'activo', 2),
(54, 'ÁREA CIENCIAS DE LA SALUD', 'activo', 3),
(55, 'ÁREA INGENIERÍA DESARROLLO TECNOLÓGICO PRODUCTIVO', 'activo', 3),
(56, 'ÁREA CIENCIAS ECONÓMICAS, FINANCIERAS Y ADMINISTRATIVAS', 'activo', 3),
(57, 'ÁREA CIENCIAS AGRÍCOLAS, PECUARIAS Y RECURSOS NATURALES', 'activo', 3),
(58, 'ÁREA CIENCIAS SOCIALES', 'activo', 3),
(59, 'ÁREA CIENCIAS DE LA EDUCACIÓN', 'activo', 3),
(60, 'ÁREA CIENCIAS Y ARTES DEL HÁBITAT', 'activo', 3),
(61, 'ÁREA CIENCIA Y TECNOLOGÍA', 'activo', 3),
(62, 'ÁREA DE ESTOMATOLOGÍA', 'activo', 3),
(63, 'CARRERA TECNOLOGÍA EN MECÁNICA DENTAL', 'activo', 1),
(64, 'CARRERA DE MEDICINA', 'activo', 1),
(65, 'DIRECCIÓN DE INFRAESTRUCTURA', 'activo', 2),
(66, 'DIRECCIÓN DE RECURSOS HUMANOS', 'activo', 2),
(67, 'HONORABLE CONSEJO UNIVERSITARIO (HCU)', 'activo', 2),
(68, 'UNIDADES ADMINISTRATIVAS', 'activo', 2),
(69, 'UNIDAD DE TESORO UNIVERSITARIO', 'activo', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administrador', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25'),
(2, 'tecnico', 'web', '2023-06-02 19:04:25', '2023-06-03 19:06:42'),
(4, 'usuario', 'web', '2023-06-02 19:04:25', '2023-06-02 19:04:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(38, 1),
(39, 1),
(40, 1),
(1, 2),
(6, 2),
(10, 2),
(15, 2),
(16, 2),
(17, 2),
(19, 2),
(21, 2),
(23, 2),
(25, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(38, 2),
(39, 2),
(40, 2),
(1, 4),
(34, 4),
(35, 4),
(39, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tri_areas_estrategicas`
--

CREATE TABLE `tri_areas_estrategicas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accion` varchar(255) NOT NULL,
  `id_area_estrategica` bigint(20) UNSIGNED NOT NULL,
  `ant_codigo_area_estrategica` int(11) NOT NULL,
  `ant_descripcion` text NOT NULL,
  `ant_estado` varchar(255) NOT NULL,
  `ant_id_usuario` bigint(20) UNSIGNED NOT NULL,
  `ant_id_gestion` bigint(20) UNSIGNED NOT NULL,
  `nuevo_codigo_area_estrategica` int(11) DEFAULT NULL,
  `nuevo_descripcion` text DEFAULT NULL,
  `nuevo_estado` varchar(255) DEFAULT NULL,
  `nuevo_id_usuario` bigint(20) UNSIGNED DEFAULT NULL,
  `nuevo_id_gestion` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ci_persona` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `celular` varchar(30) DEFAULT NULL,
  `perfil` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `creado_el` timestamp NULL DEFAULT NULL,
  `editado_el` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `id_unidad_carrera` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `ci_persona`, `nombre`, `apellido`, `usuario`, `password`, `estado`, `celular`, `perfil`, `email`, `remember_token`, `creado_el`, `editado_el`, `deleted_at`, `id_unidad_carrera`) VALUES
(1, '10028685', 'Rodrigo', 'Lecoña', '10028685', '$2y$10$N4e5t4UZB7IxDruWu2rmM.wk5o.p428nAzYcHkqyJZMz0yZVEHZMO', 'activo', '63259224', NULL, 'rodrigolecona03@gmail.com', 'Po7HafCoWvLs8TcP1afyhIV2pmn6rdO3vgKVNXzShVI61RUDYOSdK2K19jPj', '2023-06-02 19:04:25', '2024-08-14 18:40:25', NULL, NULL),
(3, '12345678', 'David Carlos', 'Mamani', '12345678', '$2y$10$OaPc17BdqP/aSK7J6pNty.jQY0KWMGAu9Z3DHzsY857quJUIck0qC', 'activo', '78758567', NULL, 'usuario1@gmail.com', 'yFJ5ZUQfL0boRidsZYd77EOpQsOWw0KD9lB1XEpy17DhtANEhQjr2JEw7DcR', '2023-06-02 19:04:26', '2024-08-14 18:37:10', NULL, 1),
(4, '10028684', 'Antonio', 'Lopez', '10028684', '$2y$10$a72bHmOqN3iV8d2AtY//iuY0Tpq7NYFgNHfxe.I/Lf1beX8Et9HxO', 'activo', '78758567', NULL, 'usuario2@gmail.com', 'pa3JHwsdnKSGObjNgPnqnzsqnHl3x4brZuKqE6vvM03OjoBrfyFtKtJTESuP', '2023-06-02 19:04:26', '2023-06-24 15:12:42', NULL, 48),
(5, '00000', 'Me', 'La pelas', 'Us_00000', '$2y$10$LJQuIc/qiM4Oa98/0SjU0.5WtPiwNjHippD8k5hbTf8CJrJlUC53m', 'activo', NULL, NULL, 'hola@cdnc', 'TE9H2r6Lku', '2023-06-07 21:54:44', '2023-06-07 21:55:04', '2023-06-07 21:55:04', NULL),
(6, '87654321', 'Juan Regis', 'Muñes', 'regis', '$2y$10$JIh/SzV2ANw0yBe3jI6AHe.PKUym7yTSr7bsV5X3q9rDbwOwGEcHG', 'activo', NULL, NULL, 'regis@gmail.com', 'VE77hcMwaS22wkqZehlkKWK9dWCmf2SCttDaz2ARPxu91pieqGBmPBUtZPY7', '2023-06-12 19:47:14', '2023-06-12 19:47:14', NULL, NULL),
(7, '4807896', 'CARLOS', 'CONDORI TITIRICO', 'CARLOS_4807896', '$2y$10$meBWfDK6wMvRIr33C21NHu6bA.dMYLDxdAZOU6oXqCb4i3yxdOxv6', 'activo', NULL, NULL, 'carlos.condori@gmail.com', 'TUEPIqSLPR', '2023-06-30 02:29:45', '2023-06-30 02:29:45', NULL, 36),
(8, '6005765', 'EFRAIN', 'CHAMBI VARGAS', 'EFRAIN_6005765', '$2y$10$kOzpIEnaUOuJGJ1nNdDB5.3kWngm47pKPjm6eJjnHM3vAK4rU3oRu', 'activo', NULL, NULL, 'efrain.chambi@gmail.com', 'F9ngHsplh4utgIif336niK0wFbvUB3fZWn67H5kJ7QN2BJujL1hk6boRRlXk', '2023-06-30 02:30:39', '2023-06-30 02:30:39', NULL, 37),
(9, '4982774', 'TEODOSIA NICOLASA', 'TANCARA CALLECUSI', 'Teodosia_4982774', '$2y$10$/a.aFqhoPwCZ19l69JXG5uX7xZ38B7QeKiFrgRyaYlO2cQoJturvu', 'activo', NULL, NULL, 'teodosia.nicolasa@gmail.com', 'EfN9vU8K6c', '2023-06-30 02:39:46', '2023-06-30 02:39:46', NULL, 29),
(10, '5995789', 'JHONNY SANTOS', 'ROJAS ROQUE', 'Jhonny_5995789', '$2y$10$sTNG8IeyrC2NTzDKutfnq.cOPO0pbIjffwDXqN4/8X1zMcjQ06t7i', 'activo', NULL, NULL, 'jhonny.santos@gmail.com', 'uAp0qVdi3kJN0GQe0aYZDPY4MXHxDVnqpmB21mTVkh5J4uJmf2LtIEjIhbwy', '2023-06-30 02:41:14', '2023-06-30 02:41:14', NULL, 64),
(11, '4299127', 'RODOLFO EFRAIN', 'BERDEJA OVIDIO', 'Rodolfo_4299127', '$2y$10$6Z9wzFVUTLEr/ChxXlusaOKYkDA1sbgRoaexosLoWQ.AiWUFDftze', 'activo', NULL, NULL, 'rodolfo.efrain@gmail.com', 'TNDiepqkoU', '2023-06-30 02:42:45', '2023-06-30 02:42:45', NULL, 20),
(12, '3536013', 'LUIS FERNANDO', 'SOTO GONZALES', 'Luis_3536013', '$2y$10$P0m/QxzJk15G9t8.BL91guGJ55CragfTNEjZUUAxU48Y6Uu8dOTDu', 'activo', NULL, NULL, 'luis.fernando@gmail.com', 'aQYFLj4pQR', '2023-06-30 04:23:18', '2024-02-14 01:16:54', NULL, 5),
(13, '4253557', 'AURELIO', 'CHURA', 'David_4253557', '$2y$10$imNm.SoQct9LLGc29y9wDuagTpLj7M2mb69wkTsHZXDYG5tTRRbcC', 'activo', NULL, NULL, 'aurelio.chura@gmail.com', 'l43uCWZ2j1', '2023-06-30 04:24:16', '2024-12-18 13:45:52', NULL, 23),
(14, '5950269', 'ROSIO LILIAN', 'CALLISAYA TINTAYA', 'Rosio_5950269', '$2y$10$m3GRj0uP/2DcGANd6UNQ5.QZMurK2deQcXtypBjlclcIS9b8kU5CC', 'activo', NULL, NULL, 'rosio.lilian@gmail.com', 'Pt6Iq6or7j', '2023-06-30 04:27:14', '2023-06-30 04:27:14', NULL, 24),
(15, '2118121', 'HUGO', 'FLORES QUISPE', 'Hugo_2118121', '$2y$10$s05sEstvqpGg7gxqGfNev.umVh5XPwaCDKTP.lGrvfn.7LoZIH0oq', 'activo', NULL, NULL, 'hugo.flores@gmail.com', 'X91ZzJCIi6', '2023-06-30 04:30:12', '2023-06-30 04:30:12', NULL, 28),
(16, '6144513', 'JUAN REGIS', 'MUÑES SIRPA', 'Regis_6144513', '$2y$10$g0MgOPM6OTWnXL1H8P0YeuqtCkp02yMqgeQXVwVmsCI0ShDzyTVGy', 'activo', NULL, NULL, 'juan.regis@gmail.com', 'zvzm3wCgMZBUqmxpAwzkE52HTXa6kW6YbLwzXO44PeN9WiIHgngaky5kIguL', '2023-06-30 04:35:32', '2023-06-30 17:36:40', NULL, 41),
(17, '4886420', 'DAVID CARLOS', 'MAMANI QUISPE', 'David_4886420', '$2y$10$fsgAVJS0lW44KuylMi40SuyGf/kKTYUhopfLh2mEBH/yvY1wG0zmG', 'activo', NULL, NULL, 'david.carlos@gmail.com', 'uUbMii44Ymz1SLhI4UqxHEvG1VBjpX9ekT0iROTmeyshr40G7d8GA7RMyTjG', '2023-06-30 14:22:01', '2023-06-30 14:22:01', NULL, 1),
(18, '6744713', 'RODRIGO DAVID', 'LUNA QUISBERT', 'Rodrigo_6744713', '$2y$10$qrthQjbwc5fxr9Xdxi2bvuSI6xFMIMU7IjF1US6pdpH4j8somjbRi', 'activo', NULL, NULL, 'rodrigo.david@gmail.com', 'TpNHJRNPHA', '2023-06-30 14:23:16', '2023-06-30 14:23:16', NULL, 15),
(19, '3328697', 'JONNY HENRRY', 'YAMPARA BLANCO', 'Jonny_3328697', '$2y$10$qDYXvNC8/3Cy4VNZbT8speqiQabtR6X5TJyV4YNnlKTs5zjl.y29W', 'activo', NULL, NULL, 'jonny.henrry@gmail.com', 'Dfochr1nnU', '2023-06-30 14:24:31', '2023-06-30 14:24:31', NULL, 13),
(20, '4244182', 'SANTOS', 'POMA AGUIRRE', 'Santos_4244182', '$2y$10$aHlcW5QS/k.Odiu1AnviDezeJIluqKSxt9mIsNnPDOQW3F4OtW4r.', 'activo', NULL, NULL, 'santos@gmail.com', 'ONQL28IFXj', '2023-06-30 14:25:19', '2023-06-30 14:25:19', NULL, 17),
(21, '4960580', 'HELEN JAQUELINE', 'CHAVEZ CHOQUERIBE', 'Helen_4960580', '$2y$10$vaOEC6AI1sppY/4ZX7l6BeLrFBHRtpm9TK75eoPYXv8hAmX5.guDq', 'activo', NULL, NULL, 'helen.jaqueline@gmail.com', 'KxdUJFGqXD', '2023-06-30 14:26:19', '2023-06-30 14:26:19', NULL, 7),
(22, '5013677', 'JOSE LUIS', 'BERRIOS SORUCO', 'Jose_5013677', '$2y$10$jTtZY0d.M4YcRt87valwIOZz.3jB9p12W2qWR7LoHsBR84uQxMeGC', 'activo', NULL, NULL, 'jose.luis@gmail.com', '9lLFOQ5yPk', '2023-06-30 14:27:31', '2023-06-30 14:27:31', NULL, 14),
(23, '6775626', 'ISMAEL', 'CANAVIRI QUISPE', 'Ismael_6775626', '$2y$10$zqCJtch79F6aCGvYDciOO.mPwQLwyn3eNXvH1pShotmrfAa422my.', 'activo', NULL, NULL, 'ismael@gmail.com', 'mHwA17USo9', '2023-06-30 14:28:20', '2024-12-18 13:44:47', NULL, 27),
(24, '4892710', 'ELIO LUIS', 'PEREZ VALERO', 'Elio_4892710', '$2y$10$SKP.zRapcoPMYLQ1KQd7Y.SmrnMptsXNP08bNb5cPkxIEbMATOsHK', 'activo', NULL, NULL, 'elio.luis@gmail.com', 'RyyPJfdMxatGe4cf5zIycfUyTLCNbzj8cNcOr8AESPKZg40l8mUxOqth2hyx', '2023-06-30 14:29:07', '2023-06-30 14:29:07', NULL, 4),
(25, '7060182', 'MARTHA GIMENA', 'MAMANI MAMANI', 'Martha_7060182', '$2y$10$cdLgmCurow49E9glurxk6.oGo0ck5L2wQdrfRT/1Z2Z9Ho8hDGydG', 'activo', NULL, NULL, 'martha.gimena@gmail.com', 'VVuZiFhKWZ', '2023-06-30 14:30:06', '2023-06-30 14:30:06', NULL, 25),
(26, '4846239', 'ANIBAL JOSE', 'PINTADO CHAMBI', 'Anibal_4846239', '$2y$10$.IR04WmRvhbCceMIE5K7/uU5JHAcawrfZ1qCUrj4bhgsa5pjYflVG', 'activo', NULL, NULL, 'anibal.jose@gmail.com', 'EZ9VnCwmYn', '2023-06-30 14:32:33', '2023-06-30 14:32:33', NULL, 35),
(27, '2694310', 'CLARIBEL IRIS', 'ARANDIA TORREZ', 'Claribel_2694310', '$2y$10$XjBvzGp6IZLiRrxcAVgqb.u98N8dH4blMrFKCeVi28Z3PyT84CE2W', 'activo', NULL, NULL, 'claribel.iris@gmail.com', 'p4S27ik6G3', '2023-06-30 14:33:31', '2023-06-30 14:33:31', NULL, 32),
(28, '4770862', 'JACQUELINE ANTONIETA', 'TICONA SIÑANI', 'Jacqueline_4770862', '$2y$10$GfLOyixYGQ9z4wu8jOqtXO/r8JAJTRDw/3HY.KwW9SwZN4b8n2PSK', 'activo', NULL, NULL, 'jacquelin.antonieta@gmail.com', 'o931nDmywa', '2023-06-30 14:34:35', '2023-06-30 14:34:35', NULL, 26),
(29, '6008347', 'GERMAN', 'BRAVO CHOQUE', 'German_6008347', '$2y$10$YJD7htCyqKUMShxU6j/doOgsWBHgdUfvgUzGM5d2MsY0KQ1hFi0TS', 'activo', NULL, NULL, 'german@gmail.com', 'dBy0fPj4dj', '2023-06-30 14:35:26', '2023-06-30 14:35:26', NULL, 10),
(30, '2140144', 'RODOLFO FREDY', 'CATUNTA NACHO', 'Rodolfo_2140144', '$2y$10$uUCyzYRWpe..teyClJJS2en9DAnCJ7G7CcTDeEdk/oH5SiBOw707q', 'activo', NULL, NULL, 'rodolfo.fredy@gmail.com', 'sDOD7Jyl6h', '2023-06-30 14:36:25', '2023-06-30 14:36:25', NULL, 16),
(31, '4924904', 'ROSA', 'VERASTEGUI ONTIVEROS', 'Rosa_4924904', '$2y$10$ihIUGKCzWvldQbycMb/YkOw2xGOR/4IW6LLd/nmknMYY.O3lZcBh6', 'activo', NULL, NULL, 'rosa@gmail.com', 'qO0LQ8PA2i', '2023-06-30 14:37:29', '2023-06-30 14:37:29', NULL, 19),
(32, '3389589', 'JORGE', 'CALLISAYA QUISPE', 'Jorge_3389589', '$2y$10$O8qh/Amu95zCSck3tDqtCOoVZUsT.q8RF2ugntymGIkG.tK4j.Qem', 'activo', NULL, NULL, 'jorge@gmail.com', 'W2GLLzkPKa', '2023-06-30 14:38:20', '2023-06-30 14:38:20', NULL, 2),
(33, '4962868', 'BEATRIZ', 'CONDORI CACHACA', 'Beatriz_4962868', '$2y$10$vC4hzkiN7Pf5EIiC9kbtTOkKoF/hcVQLpgLzyNrCUMTT5ttTyuHZG', 'activo', NULL, NULL, 'Beatriz@gmail.com', 'oLYKoqufSr', '2023-06-30 14:39:18', '2023-06-30 14:39:18', NULL, 6),
(34, '6052642', 'DANIEL', 'CONDORI GUARACHI', 'Daniel_6052642', '$2y$10$H9jR1V1Io7VNWhLgppkcbu4yePknCmVFejTYXn4cAjQikJi10lZPq', 'activo', NULL, NULL, 'daniel@gmail.com', 'y4J9Mv82Mm', '2023-06-30 14:40:04', '2023-06-30 14:40:04', NULL, 22),
(35, '4894380', 'FERNANDO', 'QUISPE SUCA', 'Fernando_4894380', '$2y$10$pmjJipL4XYTCtWzvoMsCCeGOJxLumEnUk2aNQyJIw0Dv4tpwD7QH6', 'activo', NULL, NULL, 'fernando@gmail.com', 'Ek0jIDfGm3', '2023-06-30 14:41:03', '2023-06-30 14:41:03', NULL, 9),
(36, '4978561', 'RIGO RIGOBERTO', 'SANCHEZ QUISBERT', 'Rigo_4978561', '$2y$10$9TJkje2bn5CFgNu8NtDXleeHNa.a0Xha8V2FtBRcjFZlgFibXgSVm', 'activo', NULL, NULL, 'digo.rigoberto@gmail.com', 'oUtVkzjjWP', '2023-06-30 14:41:56', '2023-06-30 14:41:56', NULL, 30),
(37, '4763898', 'ALBERTO', 'RAMIREZ PAREDES', 'Alberto_4763898', '$2y$10$RCuX6JtkE2b3frbZ7zvv8eVoLg5QBYGM/TWa24k0WI98JQe3Ok2B.', 'activo', NULL, NULL, 'alverto@gmail.com', 'FffvCWPUtSW8P2fIKvUko0ZZMxOcwu2gxeG0x2X14AM1ofBaVZP3jOER0cU1', '2023-06-30 14:42:54', '2023-06-30 14:42:54', NULL, 8),
(38, '3416615', 'VICTOR EDWIN', 'CAMPOS UGARTE', 'Victor_3416615', '$2y$10$Y5ju1m6wkA0kruyi/zpoXeCFv4TmkB0IXh9sjEF9nmHUKAzgERFO6', 'activo', NULL, NULL, 'victor.edwin@gmail.com', '28n4DUjred', '2023-06-30 14:44:12', '2023-06-30 14:44:12', NULL, 50),
(39, '3512077', 'VLADIMIR GROVER', 'VEGA GONZALES', 'Vladimir_3512077', '$2y$10$qQVP3zoXvdVAVLppHyT3cOp8LSFdABsbTbxd7gSpJkx03HByZjyP2', 'activo', NULL, NULL, 'vladimir.grover@gmail.com', 'ZcKQrDl3DP', '2023-06-30 14:47:05', '2023-06-30 14:47:05', NULL, 40),
(40, '123456789', 'SANTOS', 'POMA AGUIRRE', 'Us_123456789', '$2y$10$ZOmDJSnXjAMwRHYJZdXW5uN7EPeCLGwuROoTsUGBd/1MV52u0fmGi', 'activo', NULL, NULL, 'usuario5@gmail.com', 'RvKyZxA68JCwbeg8xDXt0XuEfrhheyrZxPDB1QbTSx6j7LrfxVvyQHqTFdpo', '2023-07-04 18:34:44', '2023-07-04 21:47:17', '2023-07-04 21:47:17', NULL),
(41, '87654322', 'JUAN', 'MUÑEZ', 'DAVID_87654322', '$2y$10$zMZWYP294MEmdV5ez75FUedLcPkgq.GSEhbgkeZf/ekhmbRb8jPDS', 'activo', NULL, NULL, 'prueba@gmail.com', 'm037pN1qun', '2023-07-21 23:39:14', '2023-07-21 23:49:57', '2023-07-21 23:49:57', NULL),
(45, '48078961', 'JORGE', 'CHAMBI', 'JORGE_48078961', '$2y$10$QJ6gahaewir6VlPr.OBmeO9DhSekrI18dcPQjDzeVtoYMZIeG0aC.', 'activo', NULL, NULL, 'admin2@gmail.com', 'Uhnehmjj4kDTCOjOfBFUn7w6IYi8QYVztORMierQuAhn01mFA1HKh0gjmzdh', '2023-07-25 22:16:12', '2023-07-25 22:16:12', NULL, NULL),
(46, '9876543', 'Marcelo', 'Rivas', '9876543', '$2y$10$FHlz9E/rEN/3NK4HQrseu.lC0FuOs8gwZd9UDtM6mv9h7P6MNgfFa', 'activo', NULL, NULL, 'user2@gmail.com', 'k7bJ7HXijdi0oJS2e6eGas70SC4MqZhMvCsHwcFqVhx2eQBXVcvOhiE53rbs', '2023-08-09 22:06:35', '2023-10-03 19:46:50', NULL, NULL),
(47, '6878067', 'JHONNY', 'APAZA', '6878067', '$2y$10$W/grFhaiptpLn5/zejksSu4HUGEq/CBfVSS8m34Jhi1rep1u2xKQ.', 'activo', NULL, NULL, 'jhonnyapaza@gmail.com', 'aSsDD6WEGzBI7FrA1Gkm4R6XEuKJzzwMgxCLFF0jUZYU8GqEhmyoOGJzCIE3', '2023-11-16 14:22:29', '2023-11-16 14:22:29', NULL, 1),
(48, '123456', 'SIE', 'PRUEBAS', 'sie', '$2y$10$WiTti3zTLwlFll2N9hwpeOBSA0YTVhjGGg9YkCPzDJr/nY7nhmGqe', 'activo', NULL, NULL, 'pruebas.sie@upea.bo', 'jgCW90usH5aP4fK0PxYXpOXNQYb2ZCj89M30O4VTVFpAtVEvYllpdGgLKQQp', '2023-11-16 14:32:19', '2023-11-16 14:32:19', NULL, 41),
(49, '12345', 'Sie2', 'Prueba2', 'sie2', '$2y$10$WiTti3zTLwlFll2N9hwpeOBSA0YTVhjGGg9YkCPzDJr/nY7nhmGqe', 'activo', NULL, NULL, 'camin2002.531@gmail.com', 'kjXeWDGNCZ', '2023-11-27 13:58:24', '2025-10-06 21:38:54', NULL, 46),
(50, '10077835', 'GARY', 'APAZA MAMANI', 'gary', '$2y$10$K7o8doNMe2KnPDZaIprJZezDJb2jfwaJzmjQVHTGqBc.qhsQgEwXu', 'activo', '65640518', NULL, 'gary7apaza@gmail.com', 'r9SRBMID28scfnuTwKIvYClpaortGcIhMHVqGxiisXB1XVXgb4yBNpiBdbvJ', '2023-12-08 18:57:29', '2024-05-10 18:45:25', NULL, 41),
(51, '9933303', 'Marcos', 'Berrios', '9933303', '$2y$10$TCWiwL5/I5oNaBaNgZciYuaNTZyUwZmbyJRwJ0yWE6SymTJcAHr42', 'activo', NULL, NULL, 'marcosberriosal@gmail.com', 'CdkfSXSbGLNrWylDVMkFMC86CoPL8UWjD71weuI6ndZ8wNNnvyJB5JEprKQ5', '2024-04-04 14:41:46', '2024-07-04 17:59:12', NULL, 1),
(53, '4744660', 'Rosmeri', 'Cossio', '4744660', '$2y$10$10GZzAunJv4cJtzP.376GOFUSz596ltdpCWUsEBBuIvYRB1HEyoAi', 'activo', NULL, NULL, 'Rosmery@gmail.com', 'u9xzkaX0drYOTKXMJfxnNknKw1LJrTb9hDeuZzza01NLFaKje5s1swS5IHih', '2024-08-21 13:24:53', '2024-12-17 20:32:24', NULL, NULL),
(54, '6020074', 'Gimena', 'Siñani', 'Us_6020074', '$2y$10$QI5Ya36QPFwfB5OuDhzubu8i3iuCdHGuagXBqRNkbYTB/oUk.JnUi', 'activo', NULL, NULL, 'gimena@gmail.com', 'fGqgFEKOBMon697E02WoDnUej3WA5zY7na9k5ilgeX0ruTJcwW7PDIj4cI5A', '2024-12-17 20:37:09', '2024-12-17 20:37:09', NULL, NULL),
(55, '3746401', 'Wilson rene', 'Gonzales', 'Us_3746401', '$2y$10$MGQ7JDSy6Adi7wpyNUADv.uIV56XBdHpzqWv9NNR48DMyiNbzlLzi', 'activo', NULL, NULL, 'wilson@wilson.com', 'pA3oB3iMKt', '2025-07-01 16:21:43', '2025-07-01 16:21:43', NULL, 41),
(61, '1234567', 'Sie3', 'Prueba3', 'sie3', '$2y$10$5CZtLjwc70bg1XYan0001OzsNrhOpwAx4ycdg8OyF6sLyZOR7TpJa', 'activo', NULL, NULL, 'geco.yak77@gmail.com', 'u9QduMJjju', '2025-10-06 21:38:34', '2025-10-06 21:38:34', NULL, 53);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areaestrategica_formulario1`
--
ALTER TABLE `areaestrategica_formulario1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areaestrategica_formulario1_areestrategica_id_foreign` (`areEstrategica_id`),
  ADD KEY `areaestrategica_formulario1_formulario1_id_foreign` (`formulario1_id`);

--
-- Indices de la tabla `confor_clasprim_partipo`
--
ALTER TABLE `confor_clasprim_partipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `confor_clasprim_partipo_partida_tid_foreign` (`partida_tid`),
  ADD KEY `confor_clasprim_partipo_clasificador_pid_foreign` (`clasificador_pid`),
  ADD KEY `confor_clasprim_partipo_configuracion_fid_foreign` (`configuracion_fid`);

--
-- Indices de la tabla `formulario2_objEstrategico`
--
ALTER TABLE `formulario2_objEstrategico`
  ADD KEY `formulario2_objestrategico_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `formulario2_objestrategico_objetivoestrategico_id_foreign` (`objetivoEstrategico_id`);

--
-- Indices de la tabla `formulario2_objEstrategico_sub`
--
ALTER TABLE `formulario2_objEstrategico_sub`
  ADD KEY `formulario2_objestrategico_sub_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `formulario2_objestrategico_sub_objestrategico_id_foreign` (`objEstrategico_id`);

--
-- Indices de la tabla `formulario2_objInstitucional`
--
ALTER TABLE `formulario2_objInstitucional`
  ADD KEY `formulario2_objinstitucional_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `formulario2_objinstitucional_objinstitucional_id_foreign` (`objInstitucional_id`);

--
-- Indices de la tabla `formulario2_politicaDesarrollo_pdu`
--
ALTER TABLE `formulario2_politicaDesarrollo_pdu`
  ADD KEY `formulario2_politicadesarrollo_pdu_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `formulario2_politicadesarrollo_pdu_politicadesarrollo_id_foreign` (`politicaDesarrollo_id`);

--
-- Indices de la tabla `formulario2_politicaDesarrollo_pei`
--
ALTER TABLE `formulario2_politicaDesarrollo_pei`
  ADD KEY `formulario2_politicadesarrollo_pei_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `formulario2_politicadesarrollo_pei_politicadesarrollo_id_foreign` (`politicaDesarrollo_id`);

--
-- Indices de la tabla `formulario4_unidad_res`
--
ALTER TABLE `formulario4_unidad_res`
  ADD KEY `formulario4_unidad_res_formulario4_id_foreign` (`formulario4_id`),
  ADD KEY `formulario4_unidad_res_unidad_id_foreign` (`unidad_id`);

--
-- Indices de la tabla `fut`
--
ALTER TABLE `fut`
  ADD PRIMARY KEY (`id_fut`),
  ADD KEY `id_configuracion_formulado` (`id_configuracion_formulado`);

--
-- Indices de la tabla `fut_movimiento`
--
ALTER TABLE `fut_movimiento`
  ADD PRIMARY KEY (`id_fut_mov`),
  ADD KEY `id_fut_pp` (`id_fut_pp`);

--
-- Indices de la tabla `fut_partidas_presupuestarias`
--
ALTER TABLE `fut_partidas_presupuestarias`
  ADD PRIMARY KEY (`id_fut_pp`),
  ADD KEY `id_fut` (`id_fut`);

--
-- Indices de la tabla `matriz_objetivo_estrategico`
--
ALTER TABLE `matriz_objetivo_estrategico`
  ADD KEY `matriz_objetivo_estrategico_matriz_id_foreign` (`matriz_id`),
  ADD KEY `matriz_objetivo_estrategico_objetivo_estrategico_id_foreign` (`objetivo_estrategico_id`);

--
-- Indices de la tabla `matriz_objetivo_estrategico_sub`
--
ALTER TABLE `matriz_objetivo_estrategico_sub`
  ADD KEY `matriz_objetivo_estrategico_sub_matriz_id_foreign` (`matriz_id`),
  ADD KEY `matriz_objetivo_estrategico_sub_obj_estrategico_sub_id_foreign` (`obj_estrategico_sub_id`);

--
-- Indices de la tabla `matriz_objetivo_institucional`
--
ALTER TABLE `matriz_objetivo_institucional`
  ADD KEY `matriz_objetivo_institucional_matriz_id_foreign` (`matriz_id`),
  ADD KEY `matriz_objetivo_institucional_obj_institucional_id_foreign` (`obj_institucional_id`);

--
-- Indices de la tabla `matriz_politica_desarrollo_pdu`
--
ALTER TABLE `matriz_politica_desarrollo_pdu`
  ADD KEY `matriz_politica_desarrollo_pdu_matriz_id_foreign` (`matriz_id`),
  ADD KEY `matriz_politica_desarrollo_pdu_politica_desarrollo_pdu_foreign` (`politica_desarrollo_pdu`);

--
-- Indices de la tabla `matriz_politica_desarrollo_pei`
--
ALTER TABLE `matriz_politica_desarrollo_pei`
  ADD KEY `matriz_politica_desarrollo_pei_matriz_id_foreign` (`matriz_id`),
  ADD KEY `matriz_politica_desarrollo_pei_politica_desarrollo_pei_foreign` (`politica_desarrollo_pei`);

--
-- Indices de la tabla `matriz_unidad_inv`
--
ALTER TABLE `matriz_unidad_inv`
  ADD KEY `matriz_unidad_inv_matriz_id_inv_foreign` (`matriz_id_inv`),
  ADD KEY `matriz_unidad_inv_unidad_id_inv_foreign` (`unidad_id_inv`);

--
-- Indices de la tabla `matriz_unidad_res`
--
ALTER TABLE `matriz_unidad_res`
  ADD KEY `matriz_unidad_res_matriz_id_res_foreign` (`matriz_id_res`),
  ADD KEY `matriz_unidad_res_unidad_id_res_foreign` (`unidad_id_res`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indices de la tabla `mot`
--
ALTER TABLE `mot`
  ADD PRIMARY KEY (`id_mot`),
  ADD KEY `id_configuracion_formulado` (`id_configuracion_formulado`);

--
-- Indices de la tabla `mot_movimiento`
--
ALTER TABLE `mot_movimiento`
  ADD PRIMARY KEY (`id_mot_mov`),
  ADD KEY `id_mot_pp` (`id_mot_pp`);

--
-- Indices de la tabla `mot_partidas_presupuestarias`
--
ALTER TABLE `mot_partidas_presupuestarias`
  ADD PRIMARY KEY (`id_mot_pp`),
  ADD KEY `id_mot` (`id_mot`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `rl_areas_estrategicas`
--
ALTER TABLE `rl_areas_estrategicas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_areas_estrategicas_id_gestion_foreign` (`id_gestion`);

--
-- Indices de la tabla `rl_articulacion_pdes`
--
ALTER TABLE `rl_articulacion_pdes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_articulacion_pdes_id_gestion_unique` (`id_gestion`);

--
-- Indices de la tabla `rl_asignacion_monto_form4`
--
ALTER TABLE `rl_asignacion_monto_form4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_asignacion_monto_form4_formulario4_id_foreign` (`formulario4_id`),
  ADD KEY `rl_asignacion_monto_form4_financiamiento_tipo_id_foreign` (`financiamiento_tipo_id`);

--
-- Indices de la tabla `rl_bienservicio`
--
ALTER TABLE `rl_bienservicio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_caja`
--
ALTER TABLE `rl_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_caja_gestiones_id_foreign` (`gestiones_id`),
  ADD KEY `rl_caja_unidad_carrera_id_foreign` (`unidad_carrera_id`),
  ADD KEY `rl_caja_financiamiento_tipo_id_foreign` (`financiamiento_tipo_id`);

--
-- Indices de la tabla `rl_categoria`
--
ALTER TABLE `rl_categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_clasificador_cuarto`
--
ALTER TABLE `rl_clasificador_cuarto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_clasificador_cuarto_id_clasificador_tercero_foreign` (`id_clasificador_tercero`);

--
-- Indices de la tabla `rl_clasificador_primero`
--
ALTER TABLE `rl_clasificador_primero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_clasificador_primero_id_clasificador_tipo_foreign` (`id_clasificador_tipo`);

--
-- Indices de la tabla `rl_clasificador_quinto`
--
ALTER TABLE `rl_clasificador_quinto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_clasificador_quinto_id_clasificador_cuarto_foreign` (`id_clasificador_cuarto`);

--
-- Indices de la tabla `rl_clasificador_segundo`
--
ALTER TABLE `rl_clasificador_segundo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_clasificador_segundo_id_clasificador_primero_foreign` (`id_clasificador_primero`);

--
-- Indices de la tabla `rl_clasificador_tercero`
--
ALTER TABLE `rl_clasificador_tercero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_clasificador_tercero_id_clasificador_segundo_foreign` (`id_clasificador_segundo`);

--
-- Indices de la tabla `rl_clasificador_tipo`
--
ALTER TABLE `rl_clasificador_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_clasificador_tipo_titulo_unique` (`titulo`);

--
-- Indices de la tabla `rl_configuracion_formulado`
--
ALTER TABLE `rl_configuracion_formulado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_configuracion_formulado_gestiones_id_foreign` (`gestiones_id`),
  ADD KEY `rl_configuracion_formulado_formulado_id_foreign` (`formulado_id`);

--
-- Indices de la tabla `rl_detalleClasiCuarto`
--
ALTER TABLE `rl_detalleClasiCuarto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_detalleclasicuarto_cuartoclasificador_id_foreign` (`cuartoclasificador_id`);

--
-- Indices de la tabla `rl_detalleClasiQuinto`
--
ALTER TABLE `rl_detalleClasiQuinto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_detalleclasiquinto_quintoclasificador_id_foreign` (`quintoclasificador_id`);

--
-- Indices de la tabla `rl_detalleClasiTercero`
--
ALTER TABLE `rl_detalleClasiTercero`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_detalleclasitercero_tercerclasificador_id_foreign` (`tercerclasificador_id`);

--
-- Indices de la tabla `rl_financiamiento_tipo`
--
ALTER TABLE `rl_financiamiento_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_financiamiento_tipo_sigla_unique` (`sigla`),
  ADD UNIQUE KEY `rl_financiamiento_tipo_codigo_unique` (`codigo`);

--
-- Indices de la tabla `rl_foda_carreras_unidad`
--
ALTER TABLE `rl_foda_carreras_unidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_foda_carreras_unidad_tipo_foda_id_foreign` (`tipo_foda_id`),
  ADD KEY `rl_foda_carreras_unidad_gestion_id_foreign` (`gestion_id`);

--
-- Indices de la tabla `rl_foda_descripcion`
--
ALTER TABLE `rl_foda_descripcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_foda_descripcion_id_area_estrategica_foreign` (`id_area_estrategica`),
  ADD KEY `rl_foda_descripcion_id_tipo_foda_foreign` (`id_tipo_foda`),
  ADD KEY `rl_foda_descripcion_id_tipo_plan_foreign` (`id_tipo_plan`);

--
-- Indices de la tabla `rl_formulado_tipo`
--
ALTER TABLE `rl_formulado_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_formulado_tipo_descripcion_unique` (`descripcion`);

--
-- Indices de la tabla `rl_formulario1`
--
ALTER TABLE `rl_formulario1`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_formulario1_configformulado_id_foreign` (`configFormulado_id`);

--
-- Indices de la tabla `rl_formulario2`
--
ALTER TABLE `rl_formulario2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_formulario2_formulario1_id_foreign` (`formulario1_id`),
  ADD KEY `rl_formulario2_indicador_id_foreign` (`indicador_id`);

--
-- Indices de la tabla `rl_formulario4`
--
ALTER TABLE `rl_formulario4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_formulario4_formulario2_id_foreign` (`formulario2_id`),
  ADD KEY `rl_formulario4_tipo_id_foreign` (`tipo_id`),
  ADD KEY `rl_formulario4_categoria_id_foreign` (`categoria_id`),
  ADD KEY `rl_formulario4_bnservicio_id_foreign` (`bnservicio_id`);

--
-- Indices de la tabla `rl_formulario5`
--
ALTER TABLE `rl_formulario5`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_formulario5_formulario4_id_foreign` (`formulario4_id`),
  ADD KEY `rl_formulario5_operacion_id_foreign` (`operacion_id`);

--
-- Indices de la tabla `rl_gestion`
--
ALTER TABLE `rl_gestion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_gestion_inicio_gestion_unique` (`inicio_gestion`),
  ADD UNIQUE KEY `rl_gestion_fin_gestion_unique` (`fin_gestion`);

--
-- Indices de la tabla `rl_gestiones`
--
ALTER TABLE `rl_gestiones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_gestiones_id_gestion_foreign` (`id_gestion`);

--
-- Indices de la tabla `rl_historial_asignacion_monto`
--
ALTER TABLE `rl_historial_asignacion_monto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_historial_asignacion_monto_asignacionmontof4_id_foreign` (`asignacionMontof4_id`);

--
-- Indices de la tabla `rl_historial_caja`
--
ALTER TABLE `rl_historial_caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_historial_caja_caja_id_foreign` (`caja_id`);

--
-- Indices de la tabla `rl_indicador`
--
ALTER TABLE `rl_indicador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_indicador_id_gestion_foreign` (`id_gestion`);

--
-- Indices de la tabla `rl_matriz_planificacion`
--
ALTER TABLE `rl_matriz_planificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_matriz_planificacion_id_indicador_foreign` (`id_indicador`),
  ADD KEY `rl_matriz_planificacion_id_tipo_foreign` (`id_tipo`),
  ADD KEY `rl_matriz_planificacion_id_categoria_foreign` (`id_categoria`),
  ADD KEY `rl_matriz_planificacion_id_resultado_producto_foreign` (`id_resultado_producto`),
  ADD KEY `rl_matriz_planificacion_id_programa_proy_foreign` (`id_programa_proy`),
  ADD KEY `rl_matriz_planificacion_id_area_estrategica_foreign` (`id_area_estrategica`);

--
-- Indices de la tabla `rl_medida`
--
ALTER TABLE `rl_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_medida_bienservicio`
--
ALTER TABLE `rl_medida_bienservicio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_medida_bienservicio_formulario5_id_foreign` (`formulario5_id`),
  ADD KEY `rl_medida_bienservicio_medida_id_foreign` (`medida_id`),
  ADD KEY `rl_medida_bienservicio_tipo_financiamiento_id_foreign` (`tipo_financiamiento_id`);

--
-- Indices de la tabla `rl_objetivo_estrategico`
--
ALTER TABLE `rl_objetivo_estrategico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_objetivo_estrategico_id_politica_desarrollo_foreign` (`id_politica_desarrollo`);

--
-- Indices de la tabla `rl_objetivo_estrategico_sub`
--
ALTER TABLE `rl_objetivo_estrategico_sub`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_objetivo_estrategico_sub_id_politica_desarrollo_foreign` (`id_politica_desarrollo`);

--
-- Indices de la tabla `rl_objetivo_institucional`
--
ALTER TABLE `rl_objetivo_institucional`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_objetivo_institucional_id_objetivo_estrategico_sub_foreign` (`id_objetivo_estrategico_sub`);

--
-- Indices de la tabla `rl_operaciones`
--
ALTER TABLE `rl_operaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_operaciones_tipo_operacion_id_foreign` (`tipo_operacion_id`),
  ADD KEY `rl_operaciones_area_estrategica_id_foreign` (`area_estrategica_id`);

--
-- Indices de la tabla `rl_partida_tipo`
--
ALTER TABLE `rl_partida_tipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_partida_tipo_descripcion_unique` (`descripcion`);

--
-- Indices de la tabla `rl_politica_de_desarrollo`
--
ALTER TABLE `rl_politica_de_desarrollo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_politica_de_desarrollo_id_area_estrategica_foreign` (`id_area_estrategica`),
  ADD KEY `rl_politica_de_desarrollo_id_tipo_plan_foreign` (`id_tipo_plan`);

--
-- Indices de la tabla `rl_programa_proy_acc_est`
--
ALTER TABLE `rl_programa_proy_acc_est`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rl_programa_proy_acc_est_id_tipo_prog_acc_foreign` (`id_tipo_prog_acc`);

--
-- Indices de la tabla `rl_resultado_producto`
--
ALTER TABLE `rl_resultado_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_tipo`
--
ALTER TABLE `rl_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_tipo_carrera`
--
ALTER TABLE `rl_tipo_carrera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_tipo_carrera_nombre_unique` (`nombre`);

--
-- Indices de la tabla `rl_tipo_foda`
--
ALTER TABLE `rl_tipo_foda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_tipo_foda_nombre_unique` (`nombre`);

--
-- Indices de la tabla `rl_tipo_operacion`
--
ALTER TABLE `rl_tipo_operacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_tipo_plan`
--
ALTER TABLE `rl_tipo_plan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_tipo_plan_nombre_unique` (`nombre`);

--
-- Indices de la tabla `rl_tipo_programa_acc`
--
ALTER TABLE `rl_tipo_programa_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rl_unidad_carrera`
--
ALTER TABLE `rl_unidad_carrera`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rl_unidad_carrera_nombre_completo_unique` (`nombre_completo`),
  ADD KEY `rl_unidad_carrera_id_tipo_carrera_foreign` (`id_tipo_carrera`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indices de la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indices de la tabla `tri_areas_estrategicas`
--
ALTER TABLE `tri_areas_estrategicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_ci_persona_unique` (`ci_persona`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areaestrategica_formulario1`
--
ALTER TABLE `areaestrategica_formulario1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `confor_clasprim_partipo`
--
ALTER TABLE `confor_clasprim_partipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `fut`
--
ALTER TABLE `fut`
  MODIFY `id_fut` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fut_movimiento`
--
ALTER TABLE `fut_movimiento`
  MODIFY `id_fut_mov` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fut_partidas_presupuestarias`
--
ALTER TABLE `fut_partidas_presupuestarias`
  MODIFY `id_fut_pp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `mot`
--
ALTER TABLE `mot`
  MODIFY `id_mot` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mot_movimiento`
--
ALTER TABLE `mot_movimiento`
  MODIFY `id_mot_mov` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mot_partidas_presupuestarias`
--
ALTER TABLE `mot_partidas_presupuestarias`
  MODIFY `id_mot_pp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rl_areas_estrategicas`
--
ALTER TABLE `rl_areas_estrategicas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rl_articulacion_pdes`
--
ALTER TABLE `rl_articulacion_pdes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_asignacion_monto_form4`
--
ALTER TABLE `rl_asignacion_monto_form4`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_bienservicio`
--
ALTER TABLE `rl_bienservicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_caja`
--
ALTER TABLE `rl_caja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_categoria`
--
ALTER TABLE `rl_categoria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_cuarto`
--
ALTER TABLE `rl_clasificador_cuarto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_primero`
--
ALTER TABLE `rl_clasificador_primero`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_quinto`
--
ALTER TABLE `rl_clasificador_quinto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_segundo`
--
ALTER TABLE `rl_clasificador_segundo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_tercero`
--
ALTER TABLE `rl_clasificador_tercero`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT de la tabla `rl_clasificador_tipo`
--
ALTER TABLE `rl_clasificador_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_configuracion_formulado`
--
ALTER TABLE `rl_configuracion_formulado`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_detalleClasiCuarto`
--
ALTER TABLE `rl_detalleClasiCuarto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `rl_detalleClasiQuinto`
--
ALTER TABLE `rl_detalleClasiQuinto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_detalleClasiTercero`
--
ALTER TABLE `rl_detalleClasiTercero`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT de la tabla `rl_financiamiento_tipo`
--
ALTER TABLE `rl_financiamiento_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rl_foda_carreras_unidad`
--
ALTER TABLE `rl_foda_carreras_unidad`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `rl_foda_descripcion`
--
ALTER TABLE `rl_foda_descripcion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rl_formulado_tipo`
--
ALTER TABLE `rl_formulado_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_formulario1`
--
ALTER TABLE `rl_formulario1`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_formulario2`
--
ALTER TABLE `rl_formulario2`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rl_formulario4`
--
ALTER TABLE `rl_formulario4`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rl_formulario5`
--
ALTER TABLE `rl_formulario5`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rl_gestion`
--
ALTER TABLE `rl_gestion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `rl_gestiones`
--
ALTER TABLE `rl_gestiones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rl_historial_asignacion_monto`
--
ALTER TABLE `rl_historial_asignacion_monto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `rl_historial_caja`
--
ALTER TABLE `rl_historial_caja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rl_indicador`
--
ALTER TABLE `rl_indicador`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `rl_matriz_planificacion`
--
ALTER TABLE `rl_matriz_planificacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `rl_medida`
--
ALTER TABLE `rl_medida`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `rl_medida_bienservicio`
--
ALTER TABLE `rl_medida_bienservicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `rl_objetivo_estrategico`
--
ALTER TABLE `rl_objetivo_estrategico`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `rl_objetivo_estrategico_sub`
--
ALTER TABLE `rl_objetivo_estrategico_sub`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `rl_objetivo_institucional`
--
ALTER TABLE `rl_objetivo_institucional`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `rl_operaciones`
--
ALTER TABLE `rl_operaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rl_partida_tipo`
--
ALTER TABLE `rl_partida_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rl_politica_de_desarrollo`
--
ALTER TABLE `rl_politica_de_desarrollo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `rl_programa_proy_acc_est`
--
ALTER TABLE `rl_programa_proy_acc_est`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `rl_resultado_producto`
--
ALTER TABLE `rl_resultado_producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT de la tabla `rl_tipo`
--
ALTER TABLE `rl_tipo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_tipo_carrera`
--
ALTER TABLE `rl_tipo_carrera`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_tipo_foda`
--
ALTER TABLE `rl_tipo_foda`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rl_tipo_operacion`
--
ALTER TABLE `rl_tipo_operacion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rl_tipo_plan`
--
ALTER TABLE `rl_tipo_plan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rl_tipo_programa_acc`
--
ALTER TABLE `rl_tipo_programa_acc`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rl_unidad_carrera`
--
ALTER TABLE `rl_unidad_carrera`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tri_areas_estrategicas`
--
ALTER TABLE `tri_areas_estrategicas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areaestrategica_formulario1`
--
ALTER TABLE `areaestrategica_formulario1`
  ADD CONSTRAINT `areaestrategica_formulario1_areestrategica_id_foreign` FOREIGN KEY (`areEstrategica_id`) REFERENCES `rl_areas_estrategicas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `areaestrategica_formulario1_formulario1_id_foreign` FOREIGN KEY (`formulario1_id`) REFERENCES `rl_formulario1` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `confor_clasprim_partipo`
--
ALTER TABLE `confor_clasprim_partipo`
  ADD CONSTRAINT `confor_clasprim_partipo_clasificador_pid_foreign` FOREIGN KEY (`clasificador_pid`) REFERENCES `rl_clasificador_primero` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `confor_clasprim_partipo_configuracion_fid_foreign` FOREIGN KEY (`configuracion_fid`) REFERENCES `rl_configuracion_formulado` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `confor_clasprim_partipo_partida_tid_foreign` FOREIGN KEY (`partida_tid`) REFERENCES `rl_partida_tipo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario2_objEstrategico`
--
ALTER TABLE `formulario2_objEstrategico`
  ADD CONSTRAINT `formulario2_objestrategico_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario2_objestrategico_objetivoestrategico_id_foreign` FOREIGN KEY (`objetivoEstrategico_id`) REFERENCES `rl_objetivo_estrategico` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario2_objEstrategico_sub`
--
ALTER TABLE `formulario2_objEstrategico_sub`
  ADD CONSTRAINT `formulario2_objestrategico_sub_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario2_objestrategico_sub_objestrategico_id_foreign` FOREIGN KEY (`objEstrategico_id`) REFERENCES `rl_objetivo_estrategico_sub` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario2_objInstitucional`
--
ALTER TABLE `formulario2_objInstitucional`
  ADD CONSTRAINT `formulario2_objinstitucional_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario2_objinstitucional_objinstitucional_id_foreign` FOREIGN KEY (`objInstitucional_id`) REFERENCES `rl_objetivo_institucional` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario2_politicaDesarrollo_pdu`
--
ALTER TABLE `formulario2_politicaDesarrollo_pdu`
  ADD CONSTRAINT `formulario2_politicadesarrollo_pdu_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario2_politicadesarrollo_pdu_politicadesarrollo_id_foreign` FOREIGN KEY (`politicaDesarrollo_id`) REFERENCES `rl_politica_de_desarrollo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario2_politicaDesarrollo_pei`
--
ALTER TABLE `formulario2_politicaDesarrollo_pei`
  ADD CONSTRAINT `formulario2_politicadesarrollo_pei_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario2_politicadesarrollo_pei_politicadesarrollo_id_foreign` FOREIGN KEY (`politicaDesarrollo_id`) REFERENCES `rl_politica_de_desarrollo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `formulario4_unidad_res`
--
ALTER TABLE `formulario4_unidad_res`
  ADD CONSTRAINT `formulario4_unidad_res_formulario4_id_foreign` FOREIGN KEY (`formulario4_id`) REFERENCES `rl_formulario4` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `formulario4_unidad_res_unidad_id_foreign` FOREIGN KEY (`unidad_id`) REFERENCES `rl_unidad_carrera` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fut_movimiento`
--
ALTER TABLE `fut_movimiento`
  ADD CONSTRAINT `fk_fut_mov_pp` FOREIGN KEY (`id_fut_pp`) REFERENCES `fut_partidas_presupuestarias` (`id_fut_pp`);

--
-- Filtros para la tabla `fut_partidas_presupuestarias`
--
ALTER TABLE `fut_partidas_presupuestarias`
  ADD CONSTRAINT `fk_fut_pp` FOREIGN KEY (`id_fut`) REFERENCES `fut` (`id_fut`);

--
-- Filtros para la tabla `matriz_objetivo_estrategico`
--
ALTER TABLE `matriz_objetivo_estrategico`
  ADD CONSTRAINT `matriz_objetivo_estrategico_matriz_id_foreign` FOREIGN KEY (`matriz_id`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_objetivo_estrategico_objetivo_estrategico_id_foreign` FOREIGN KEY (`objetivo_estrategico_id`) REFERENCES `rl_objetivo_estrategico` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_objetivo_estrategico_sub`
--
ALTER TABLE `matriz_objetivo_estrategico_sub`
  ADD CONSTRAINT `matriz_objetivo_estrategico_sub_matriz_id_foreign` FOREIGN KEY (`matriz_id`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_objetivo_estrategico_sub_obj_estrategico_sub_id_foreign` FOREIGN KEY (`obj_estrategico_sub_id`) REFERENCES `rl_objetivo_estrategico_sub` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_objetivo_institucional`
--
ALTER TABLE `matriz_objetivo_institucional`
  ADD CONSTRAINT `matriz_objetivo_institucional_matriz_id_foreign` FOREIGN KEY (`matriz_id`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_objetivo_institucional_obj_institucional_id_foreign` FOREIGN KEY (`obj_institucional_id`) REFERENCES `rl_objetivo_institucional` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_politica_desarrollo_pdu`
--
ALTER TABLE `matriz_politica_desarrollo_pdu`
  ADD CONSTRAINT `matriz_politica_desarrollo_pdu_matriz_id_foreign` FOREIGN KEY (`matriz_id`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_politica_desarrollo_pdu_politica_desarrollo_pdu_foreign` FOREIGN KEY (`politica_desarrollo_pdu`) REFERENCES `rl_politica_de_desarrollo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_politica_desarrollo_pei`
--
ALTER TABLE `matriz_politica_desarrollo_pei`
  ADD CONSTRAINT `matriz_politica_desarrollo_pei_matriz_id_foreign` FOREIGN KEY (`matriz_id`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_politica_desarrollo_pei_politica_desarrollo_pei_foreign` FOREIGN KEY (`politica_desarrollo_pei`) REFERENCES `rl_politica_de_desarrollo` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_unidad_inv`
--
ALTER TABLE `matriz_unidad_inv`
  ADD CONSTRAINT `matriz_unidad_inv_matriz_id_inv_foreign` FOREIGN KEY (`matriz_id_inv`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_unidad_inv_unidad_id_inv_foreign` FOREIGN KEY (`unidad_id_inv`) REFERENCES `rl_unidad_carrera` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `matriz_unidad_res`
--
ALTER TABLE `matriz_unidad_res`
  ADD CONSTRAINT `matriz_unidad_res_matriz_id_res_foreign` FOREIGN KEY (`matriz_id_res`) REFERENCES `rl_matriz_planificacion` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `matriz_unidad_res_unidad_id_res_foreign` FOREIGN KEY (`unidad_id_res`) REFERENCES `rl_unidad_carrera` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_model_id_foreign` FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mot`
--
ALTER TABLE `mot`
  ADD CONSTRAINT `mot_ibfk_1` FOREIGN KEY (`id_configuracion_formulado`) REFERENCES `rl_configuracion_formulado` (`id`);

--
-- Filtros para la tabla `mot_movimiento`
--
ALTER TABLE `mot_movimiento`
  ADD CONSTRAINT `fk_mot_mov_pp` FOREIGN KEY (`id_mot_pp`) REFERENCES `mot_partidas_presupuestarias` (`id_mot_pp`);

--
-- Filtros para la tabla `mot_partidas_presupuestarias`
--
ALTER TABLE `mot_partidas_presupuestarias`
  ADD CONSTRAINT `fk_mot_pp` FOREIGN KEY (`id_mot`) REFERENCES `mot` (`id_mot`);

--
-- Filtros para la tabla `rl_areas_estrategicas`
--
ALTER TABLE `rl_areas_estrategicas`
  ADD CONSTRAINT `rl_areas_estrategicas_id_gestion_foreign` FOREIGN KEY (`id_gestion`) REFERENCES `rl_gestion` (`id`);

--
-- Filtros para la tabla `rl_articulacion_pdes`
--
ALTER TABLE `rl_articulacion_pdes`
  ADD CONSTRAINT `rl_articulacion_pdes_id_gestion_foreign` FOREIGN KEY (`id_gestion`) REFERENCES `rl_gestion` (`id`);

--
-- Filtros para la tabla `rl_asignacion_monto_form4`
--
ALTER TABLE `rl_asignacion_monto_form4`
  ADD CONSTRAINT `rl_asignacion_monto_form4_financiamiento_tipo_id_foreign` FOREIGN KEY (`financiamiento_tipo_id`) REFERENCES `rl_financiamiento_tipo` (`id`),
  ADD CONSTRAINT `rl_asignacion_monto_form4_formulario4_id_foreign` FOREIGN KEY (`formulario4_id`) REFERENCES `rl_formulario4` (`id`);

--
-- Filtros para la tabla `rl_caja`
--
ALTER TABLE `rl_caja`
  ADD CONSTRAINT `rl_caja_financiamiento_tipo_id_foreign` FOREIGN KEY (`financiamiento_tipo_id`) REFERENCES `rl_financiamiento_tipo` (`id`),
  ADD CONSTRAINT `rl_caja_gestiones_id_foreign` FOREIGN KEY (`gestiones_id`) REFERENCES `rl_gestiones` (`id`),
  ADD CONSTRAINT `rl_caja_unidad_carrera_id_foreign` FOREIGN KEY (`unidad_carrera_id`) REFERENCES `rl_unidad_carrera` (`id`);

--
-- Filtros para la tabla `rl_clasificador_cuarto`
--
ALTER TABLE `rl_clasificador_cuarto`
  ADD CONSTRAINT `rl_clasificador_cuarto_id_clasificador_tercero_foreign` FOREIGN KEY (`id_clasificador_tercero`) REFERENCES `rl_clasificador_tercero` (`id`);

--
-- Filtros para la tabla `rl_clasificador_primero`
--
ALTER TABLE `rl_clasificador_primero`
  ADD CONSTRAINT `rl_clasificador_primero_id_clasificador_tipo_foreign` FOREIGN KEY (`id_clasificador_tipo`) REFERENCES `rl_clasificador_tipo` (`id`);

--
-- Filtros para la tabla `rl_clasificador_quinto`
--
ALTER TABLE `rl_clasificador_quinto`
  ADD CONSTRAINT `rl_clasificador_quinto_id_clasificador_cuarto_foreign` FOREIGN KEY (`id_clasificador_cuarto`) REFERENCES `rl_clasificador_cuarto` (`id`);

--
-- Filtros para la tabla `rl_clasificador_segundo`
--
ALTER TABLE `rl_clasificador_segundo`
  ADD CONSTRAINT `rl_clasificador_segundo_id_clasificador_primero_foreign` FOREIGN KEY (`id_clasificador_primero`) REFERENCES `rl_clasificador_primero` (`id`);

--
-- Filtros para la tabla `rl_clasificador_tercero`
--
ALTER TABLE `rl_clasificador_tercero`
  ADD CONSTRAINT `rl_clasificador_tercero_id_clasificador_segundo_foreign` FOREIGN KEY (`id_clasificador_segundo`) REFERENCES `rl_clasificador_segundo` (`id`);

--
-- Filtros para la tabla `rl_configuracion_formulado`
--
ALTER TABLE `rl_configuracion_formulado`
  ADD CONSTRAINT `rl_configuracion_formulado_formulado_id_foreign` FOREIGN KEY (`formulado_id`) REFERENCES `rl_formulado_tipo` (`id`),
  ADD CONSTRAINT `rl_configuracion_formulado_gestiones_id_foreign` FOREIGN KEY (`gestiones_id`) REFERENCES `rl_gestiones` (`id`);

--
-- Filtros para la tabla `rl_detalleClasiCuarto`
--
ALTER TABLE `rl_detalleClasiCuarto`
  ADD CONSTRAINT `rl_detalleclasicuarto_cuartoclasificador_id_foreign` FOREIGN KEY (`cuartoclasificador_id`) REFERENCES `rl_clasificador_cuarto` (`id`);

--
-- Filtros para la tabla `rl_detalleClasiQuinto`
--
ALTER TABLE `rl_detalleClasiQuinto`
  ADD CONSTRAINT `rl_detalleclasiquinto_quintoclasificador_id_foreign` FOREIGN KEY (`quintoclasificador_id`) REFERENCES `rl_clasificador_quinto` (`id`);

--
-- Filtros para la tabla `rl_detalleClasiTercero`
--
ALTER TABLE `rl_detalleClasiTercero`
  ADD CONSTRAINT `rl_detalleclasitercero_tercerclasificador_id_foreign` FOREIGN KEY (`tercerclasificador_id`) REFERENCES `rl_clasificador_tercero` (`id`);

--
-- Filtros para la tabla `rl_foda_carreras_unidad`
--
ALTER TABLE `rl_foda_carreras_unidad`
  ADD CONSTRAINT `rl_foda_carreras_unidad_gestion_id_foreign` FOREIGN KEY (`gestion_id`) REFERENCES `rl_gestiones` (`id`),
  ADD CONSTRAINT `rl_foda_carreras_unidad_tipo_foda_id_foreign` FOREIGN KEY (`tipo_foda_id`) REFERENCES `rl_tipo_foda` (`id`);

--
-- Filtros para la tabla `rl_foda_descripcion`
--
ALTER TABLE `rl_foda_descripcion`
  ADD CONSTRAINT `rl_foda_descripcion_id_area_estrategica_foreign` FOREIGN KEY (`id_area_estrategica`) REFERENCES `rl_areas_estrategicas` (`id`),
  ADD CONSTRAINT `rl_foda_descripcion_id_tipo_foda_foreign` FOREIGN KEY (`id_tipo_foda`) REFERENCES `rl_tipo_foda` (`id`),
  ADD CONSTRAINT `rl_foda_descripcion_id_tipo_plan_foreign` FOREIGN KEY (`id_tipo_plan`) REFERENCES `rl_tipo_plan` (`id`);

--
-- Filtros para la tabla `rl_formulario1`
--
ALTER TABLE `rl_formulario1`
  ADD CONSTRAINT `rl_formulario1_configformulado_id_foreign` FOREIGN KEY (`configFormulado_id`) REFERENCES `rl_configuracion_formulado` (`id`);

--
-- Filtros para la tabla `rl_formulario2`
--
ALTER TABLE `rl_formulario2`
  ADD CONSTRAINT `rl_formulario2_formulario1_id_foreign` FOREIGN KEY (`formulario1_id`) REFERENCES `rl_formulario1` (`id`),
  ADD CONSTRAINT `rl_formulario2_indicador_id_foreign` FOREIGN KEY (`indicador_id`) REFERENCES `rl_indicador` (`id`);

--
-- Filtros para la tabla `rl_formulario4`
--
ALTER TABLE `rl_formulario4`
  ADD CONSTRAINT `rl_formulario4_bnservicio_id_foreign` FOREIGN KEY (`bnservicio_id`) REFERENCES `rl_bienservicio` (`id`),
  ADD CONSTRAINT `rl_formulario4_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `rl_categoria` (`id`),
  ADD CONSTRAINT `rl_formulario4_formulario2_id_foreign` FOREIGN KEY (`formulario2_id`) REFERENCES `rl_formulario2` (`id`),
  ADD CONSTRAINT `rl_formulario4_tipo_id_foreign` FOREIGN KEY (`tipo_id`) REFERENCES `rl_tipo` (`id`);

--
-- Filtros para la tabla `rl_formulario5`
--
ALTER TABLE `rl_formulario5`
  ADD CONSTRAINT `rl_formulario5_formulario4_id_foreign` FOREIGN KEY (`formulario4_id`) REFERENCES `rl_formulario4` (`id`),
  ADD CONSTRAINT `rl_formulario5_operacion_id_foreign` FOREIGN KEY (`operacion_id`) REFERENCES `rl_operaciones` (`id`);

--
-- Filtros para la tabla `rl_gestiones`
--
ALTER TABLE `rl_gestiones`
  ADD CONSTRAINT `rl_gestiones_id_gestion_foreign` FOREIGN KEY (`id_gestion`) REFERENCES `rl_gestion` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rl_historial_asignacion_monto`
--
ALTER TABLE `rl_historial_asignacion_monto`
  ADD CONSTRAINT `rl_historial_asignacion_monto_asignacionmontof4_id_foreign` FOREIGN KEY (`asignacionMontof4_id`) REFERENCES `rl_asignacion_monto_form4` (`id`);

--
-- Filtros para la tabla `rl_historial_caja`
--
ALTER TABLE `rl_historial_caja`
  ADD CONSTRAINT `rl_historial_caja_caja_id_foreign` FOREIGN KEY (`caja_id`) REFERENCES `rl_caja` (`id`);

--
-- Filtros para la tabla `rl_indicador`
--
ALTER TABLE `rl_indicador`
  ADD CONSTRAINT `rl_indicador_id_gestion_foreign` FOREIGN KEY (`id_gestion`) REFERENCES `rl_gestion` (`id`);

--
-- Filtros para la tabla `rl_matriz_planificacion`
--
ALTER TABLE `rl_matriz_planificacion`
  ADD CONSTRAINT `rl_matriz_planificacion_id_area_estrategica_foreign` FOREIGN KEY (`id_area_estrategica`) REFERENCES `rl_areas_estrategicas` (`id`),
  ADD CONSTRAINT `rl_matriz_planificacion_id_categoria_foreign` FOREIGN KEY (`id_categoria`) REFERENCES `rl_categoria` (`id`),
  ADD CONSTRAINT `rl_matriz_planificacion_id_indicador_foreign` FOREIGN KEY (`id_indicador`) REFERENCES `rl_indicador` (`id`),
  ADD CONSTRAINT `rl_matriz_planificacion_id_programa_proy_foreign` FOREIGN KEY (`id_programa_proy`) REFERENCES `rl_programa_proy_acc_est` (`id`),
  ADD CONSTRAINT `rl_matriz_planificacion_id_resultado_producto_foreign` FOREIGN KEY (`id_resultado_producto`) REFERENCES `rl_resultado_producto` (`id`),
  ADD CONSTRAINT `rl_matriz_planificacion_id_tipo_foreign` FOREIGN KEY (`id_tipo`) REFERENCES `rl_tipo` (`id`);

--
-- Filtros para la tabla `rl_medida_bienservicio`
--
ALTER TABLE `rl_medida_bienservicio`
  ADD CONSTRAINT `rl_medida_bienservicio_formulario5_id_foreign` FOREIGN KEY (`formulario5_id`) REFERENCES `rl_formulario5` (`id`),
  ADD CONSTRAINT `rl_medida_bienservicio_medida_id_foreign` FOREIGN KEY (`medida_id`) REFERENCES `rl_medida` (`id`),
  ADD CONSTRAINT `rl_medida_bienservicio_tipo_financiamiento_id_foreign` FOREIGN KEY (`tipo_financiamiento_id`) REFERENCES `rl_financiamiento_tipo` (`id`);

--
-- Filtros para la tabla `rl_objetivo_estrategico`
--
ALTER TABLE `rl_objetivo_estrategico`
  ADD CONSTRAINT `rl_objetivo_estrategico_id_politica_desarrollo_foreign` FOREIGN KEY (`id_politica_desarrollo`) REFERENCES `rl_politica_de_desarrollo` (`id`);

--
-- Filtros para la tabla `rl_objetivo_estrategico_sub`
--
ALTER TABLE `rl_objetivo_estrategico_sub`
  ADD CONSTRAINT `rl_objetivo_estrategico_sub_id_politica_desarrollo_foreign` FOREIGN KEY (`id_politica_desarrollo`) REFERENCES `rl_politica_de_desarrollo` (`id`);

--
-- Filtros para la tabla `rl_objetivo_institucional`
--
ALTER TABLE `rl_objetivo_institucional`
  ADD CONSTRAINT `rl_objetivo_institucional_id_objetivo_estrategico_sub_foreign` FOREIGN KEY (`id_objetivo_estrategico_sub`) REFERENCES `rl_objetivo_estrategico_sub` (`id`);

--
-- Filtros para la tabla `rl_operaciones`
--
ALTER TABLE `rl_operaciones`
  ADD CONSTRAINT `rl_operaciones_area_estrategica_id_foreign` FOREIGN KEY (`area_estrategica_id`) REFERENCES `rl_areas_estrategicas` (`id`),
  ADD CONSTRAINT `rl_operaciones_tipo_operacion_id_foreign` FOREIGN KEY (`tipo_operacion_id`) REFERENCES `rl_tipo_operacion` (`id`);

--
-- Filtros para la tabla `rl_politica_de_desarrollo`
--
ALTER TABLE `rl_politica_de_desarrollo`
  ADD CONSTRAINT `rl_politica_de_desarrollo_id_area_estrategica_foreign` FOREIGN KEY (`id_area_estrategica`) REFERENCES `rl_areas_estrategicas` (`id`),
  ADD CONSTRAINT `rl_politica_de_desarrollo_id_tipo_plan_foreign` FOREIGN KEY (`id_tipo_plan`) REFERENCES `rl_tipo_plan` (`id`);

--
-- Filtros para la tabla `rl_programa_proy_acc_est`
--
ALTER TABLE `rl_programa_proy_acc_est`
  ADD CONSTRAINT `rl_programa_proy_acc_est_id_tipo_prog_acc_foreign` FOREIGN KEY (`id_tipo_prog_acc`) REFERENCES `rl_tipo_programa_acc` (`id`);

--
-- Filtros para la tabla `rl_unidad_carrera`
--
ALTER TABLE `rl_unidad_carrera`
  ADD CONSTRAINT `rl_unidad_carrera_id_tipo_carrera_foreign` FOREIGN KEY (`id_tipo_carrera`) REFERENCES `rl_tipo_carrera` (`id`);

--
-- Filtros para la tabla `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
