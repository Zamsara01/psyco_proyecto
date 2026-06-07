-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2026 a las 05:11:22
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
-- Base de datos: `psyco_intento`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatbot_interacciones`
--

CREATE TABLE `chatbot_interacciones` (
  `id_interaccion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `id_sesion` varchar(64) NOT NULL,
  `respuesta` text DEFAULT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_psicologo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `duracion_minutos` int(11) NOT NULL DEFAULT 60,
  `estado` enum('pendiente','en proceso','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `motivo_consulta` text DEFAULT NULL,
  `notas_sesion` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `id_usuario`, `id_psicologo`, `fecha`, `hora`, `duracion_minutos`, `estado`, `motivo_consulta`, `notas_sesion`, `fecha_creacion`) VALUES
(1, 1, 1, '2026-06-10', '09:00:00', 60, 'pendiente', 'Ansiedad escolar y dificultades de concentración', NULL, '2026-06-03 21:53:14'),
(2, 2, 2, '2026-06-10', '10:00:00', 60, 'pendiente', 'Problemas de adaptación social', NULL, '2026-06-03 21:53:14'),
(3, 3, 3, '2026-06-10', '11:00:00', 60, 'completada', 'Seguimiento rendimiento académico', NULL, '2026-06-03 21:53:14'),
(4, 4, 1, '2026-06-11', '09:00:00', 60, 'pendiente', 'Manejo de emociones', NULL, '2026-06-03 21:53:14'),
(5, 5, 2, '2026-06-11', '10:00:00', 60, 'cancelada', 'Bullying reportado por docente', NULL, '2026-06-03 21:53:14'),
(6, 6, 3, '2026-06-11', '11:00:00', 60, 'pendiente', 'Duelo familiar reciente', NULL, '2026-06-03 21:53:14'),
(7, 7, 1, '2026-06-12', '09:00:00', 60, 'completada', 'Primera valoración psicológica', NULL, '2026-06-03 21:53:14'),
(8, 8, 2, '2026-06-12', '10:00:00', 60, 'pendiente', 'Dificultades de aprendizaje', NULL, '2026-06-03 21:53:14'),
(9, 9, 3, '2026-06-12', '11:00:00', 60, 'pendiente', 'Estrés por exámenes', NULL, '2026-06-03 21:53:14'),
(10, 10, 1, '2026-06-13', '09:00:00', 60, 'completada', 'Seguimiento trimestral', NULL, '2026-06-03 21:53:14'),
(11, 11, 2, '2026-06-13', '10:00:00', 60, 'pendiente', 'Problemas de autoestima', NULL, '2026-06-03 21:53:14'),
(12, 12, 3, '2026-06-13', '11:00:00', 60, 'cancelada', 'Conflictos con compañeros', NULL, '2026-06-03 21:53:14'),
(13, 13, 1, '2026-06-16', '09:00:00', 60, 'pendiente', 'Ansiedad ante exposiciones orales', NULL, '2026-06-03 21:53:14'),
(14, 14, 2, '2026-06-16', '10:00:00', 60, 'pendiente', 'Dificultad para hacer amigos', NULL, '2026-06-03 21:53:14'),
(15, 15, 3, '2026-06-16', '11:00:00', 60, 'completada', 'Seguimiento mensual', NULL, '2026-06-03 21:53:14'),
(16, 16, 1, '2026-06-17', '09:00:00', 60, 'pendiente', 'Bajo rendimiento académico', NULL, '2026-06-03 21:53:14'),
(17, 17, 2, '2026-06-17', '10:00:00', 60, 'pendiente', 'Problemas de conducta en clase', NULL, '2026-06-03 21:53:14'),
(18, 18, 3, '2026-06-17', '11:00:00', 60, 'pendiente', 'Apoyo emocional post-pandemia', NULL, '2026-06-03 21:53:14'),
(19, 19, 1, '2026-06-18', '09:00:00', 60, 'cancelada', 'Orientación vocacional', NULL, '2026-06-03 21:53:14'),
(20, 20, 2, '2026-06-18', '10:00:00', 60, 'pendiente', 'Manejo de ira', NULL, '2026-06-03 21:53:14'),
(21, 21, 3, '2026-06-18', '11:00:00', 60, 'completada', 'Primera valoración psicológica', NULL, '2026-06-03 21:53:14'),
(22, 22, 1, '2026-06-19', '09:00:00', 60, 'pendiente', 'Depresión leve reportada por padres', NULL, '2026-06-03 21:53:14'),
(23, 23, 2, '2026-06-19', '10:00:00', 60, 'pendiente', 'Dificultades de concentración', NULL, '2026-06-03 21:53:14'),
(24, 24, 3, '2026-06-19', '11:00:00', 60, 'pendiente', 'Estrés familiar', NULL, '2026-06-03 21:53:14'),
(25, 25, 1, '2026-06-20', '09:00:00', 60, 'completada', 'Seguimiento semestral', NULL, '2026-06-03 21:53:14'),
(26, 26, 2, '2026-06-20', '10:00:00', 60, 'pendiente', 'Problemas de sueño', NULL, '2026-06-03 21:53:14'),
(27, 27, 3, '2026-06-20', '11:00:00', 60, 'pendiente', 'Ansiedad generalizada', NULL, '2026-06-03 21:53:14'),
(28, 28, 1, '2026-06-23', '09:00:00', 60, 'pendiente', 'Dificultades de lectura', NULL, '2026-06-03 21:53:14'),
(29, 29, 2, '2026-06-23', '10:00:00', 60, 'cancelada', 'Conflicto con docente', NULL, '2026-06-03 21:53:14'),
(30, 30, 3, '2026-06-23', '11:00:00', 60, 'pendiente', 'Apoyo emocional', NULL, '2026-06-03 21:53:14'),
(31, 31, 1, '2026-06-24', '09:00:00', 60, 'pendiente', 'Seguimiento mensual', NULL, '2026-06-03 21:53:14'),
(32, 32, 2, '2026-06-24', '10:00:00', 60, 'completada', 'Orientación a padres', NULL, '2026-06-03 21:53:14'),
(33, 33, 3, '2026-06-24', '11:00:00', 60, 'pendiente', 'Primer acercamiento', NULL, '2026-06-03 21:53:14'),
(34, 34, 1, '2026-06-25', '09:00:00', 60, 'pendiente', 'Manejo de emociones', NULL, '2026-06-03 21:53:14'),
(35, 35, 2, '2026-06-25', '10:00:00', 60, 'pendiente', 'Ansiedad escolar', NULL, '2026-06-03 21:53:14'),
(36, 36, 3, '2026-06-25', '11:00:00', 60, 'cancelada', 'Problemas familiares', NULL, '2026-06-03 21:53:14'),
(37, 37, 1, '2026-06-26', '09:00:00', 60, 'completada', 'Seguimiento semanal', NULL, '2026-06-03 21:53:14'),
(38, 38, 2, '2026-06-26', '10:00:00', 60, 'pendiente', 'Dificultades sociales', NULL, '2026-06-03 21:53:14'),
(39, 39, 3, '2026-06-26', '11:00:00', 60, 'pendiente', 'Estrés académico', NULL, '2026-06-03 21:53:14'),
(40, 40, 1, '2026-06-27', '09:00:00', 60, 'pendiente', 'Primer acercamiento', NULL, '2026-06-03 21:53:14'),
(41, 41, 2, '2026-06-27', '10:00:00', 60, 'pendiente', 'Seguimiento trimestral', NULL, '2026-06-03 21:53:14'),
(42, 42, 3, '2026-06-27', '11:00:00', 60, 'completada', 'Ansiedad ante pruebas', NULL, '2026-06-03 21:53:14'),
(43, 43, 1, '2026-06-30', '09:00:00', 60, 'pendiente', 'Problemas de autoestima', NULL, '2026-06-03 21:53:14'),
(44, 44, 2, '2026-06-30', '10:00:00', 60, 'cancelada', 'Duelo por mascota', NULL, '2026-06-03 21:53:14'),
(45, 45, 3, '2026-06-30', '11:00:00', 60, 'pendiente', 'Apoyo emocional', NULL, '2026-06-03 21:53:14'),
(46, 46, 1, '2026-07-01', '09:00:00', 60, 'pendiente', 'Orientación vocacional', NULL, '2026-06-03 21:53:14'),
(47, 47, 2, '2026-07-01', '10:00:00', 60, 'pendiente', 'Conflictos entre pares', NULL, '2026-06-03 21:53:14'),
(48, 48, 3, '2026-07-01', '11:00:00', 60, 'completada', 'Seguimiento mensual', NULL, '2026-06-03 21:53:14'),
(49, 49, 1, '2026-07-02', '09:00:00', 60, 'pendiente', 'Ansiedad generalizada', NULL, '2026-06-03 21:53:14'),
(50, 50, 2, '2026-07-02', '10:00:00', 60, 'pendiente', 'Primer acercamiento', NULL, '2026-06-03 21:53:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad_psicologos`
--

CREATE TABLE `disponibilidad_psicologos` (
  `id_disponibilidad` int(11) NOT NULL,
  `id_psicologo` int(11) NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `disponibilidad_psicologos`
--

INSERT INTO `disponibilidad_psicologos` (`id_disponibilidad`, `id_psicologo`, `dia_semana`, `hora_inicio`, `hora_fin`, `activo`) VALUES
(1, 1, 'Lunes', '08:00:00', '12:00:00', 1),
(2, 1, 'Lunes', '14:00:00', '18:00:00', 1),
(3, 1, 'Martes', '08:00:00', '12:00:00', 1),
(4, 1, 'Martes', '14:00:00', '18:00:00', 1),
(5, 1, 'Miércoles', '08:00:00', '12:00:00', 1),
(6, 1, 'Miércoles', '14:00:00', '18:00:00', 1),
(7, 1, 'Jueves', '08:00:00', '12:00:00', 1),
(8, 1, 'Jueves', '14:00:00', '18:00:00', 1),
(9, 1, 'Viernes', '08:00:00', '12:00:00', 1),
(10, 1, 'Viernes', '14:00:00', '18:00:00', 1),
(11, 2, 'Lunes', '09:00:00', '13:00:00', 1),
(12, 2, 'Lunes', '15:00:00', '19:00:00', 1),
(13, 2, 'Miércoles', '09:00:00', '13:00:00', 1),
(14, 2, 'Miércoles', '15:00:00', '19:00:00', 1),
(15, 2, 'Viernes', '09:00:00', '13:00:00', 1),
(16, 2, 'Viernes', '15:00:00', '19:00:00', 1),
(17, 3, 'Martes', '08:00:00', '12:00:00', 1),
(18, 3, 'Martes', '13:00:00', '16:00:00', 1),
(19, 3, 'Jueves', '08:00:00', '12:00:00', 1),
(20, 3, 'Jueves', '13:00:00', '16:00:00', 1),
(21, 4, 'Lunes', '10:00:00', '14:00:00', 1),
(22, 4, 'Lunes', '15:00:00', '18:00:00', 1),
(23, 4, 'Martes', '10:00:00', '14:00:00', 1),
(24, 4, 'Martes', '15:00:00', '18:00:00', 1),
(25, 4, 'Miércoles', '10:00:00', '14:00:00', 1),
(26, 4, 'Miércoles', '15:00:00', '18:00:00', 1),
(27, 4, 'Jueves', '10:00:00', '14:00:00', 1),
(28, 4, 'Jueves', '15:00:00', '18:00:00', 1),
(29, 4, 'Viernes', '10:00:00', '14:00:00', 1),
(30, 4, 'Viernes', '15:00:00', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id_especialidad`, `nombre`, `descripcion`) VALUES
(1, 'Psicología clínica', NULL),
(2, 'Orientación educativa', NULL),
(3, 'Psicología infantil y adolescente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_chatbot`
--

CREATE TABLE `opciones_chatbot` (
  `id_opcion` int(11) NOT NULL,
  `id_opcion_padre` int(11) DEFAULT NULL,
  `texto_opcion` varchar(255) NOT NULL,
  `respuesta` text DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opciones_chatbot`
--

INSERT INTO `opciones_chatbot` (`id_opcion`, `id_opcion_padre`, `texto_opcion`, `respuesta`, `orden`, `activo`) VALUES
(1, NULL, 'Agendar una cita', 'Selecciona una de las siguientes opciones para agendar tu cita.', 1, 1),
(2, NULL, 'Ver mis citas', 'Aquí puedes consultar el estado de tus citas.', 2, 1),
(3, NULL, 'Cancelar una cita', 'Selecciona la cita que deseas cancelar.', 3, 1),
(4, NULL, 'Información y contacto', 'Para más información comunícate con orientación.', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psicologos`
--

CREATE TABLE `psicologos` (
  `id_psicologo` int(11) NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `psicologos`
--

INSERT INTO `psicologos` (`id_psicologo`, `id_especialidad`, `nombre`, `telefono`, `foto_perfil`, `estado`, `fecha_registro`, `correo_electronico`, `contrasena`) VALUES
(1, 1, 'Dra. Elena Vargas', '3001234567', NULL, 'activo', '2026-06-03 21:02:55', 'elena@psyco.com', '$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
(2, 2, 'Dr. Ricardo Mena', '3007654321', NULL, 'activo', '2026-06-03 21:02:55', 'ricardo@psyco.com', '$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
(3, 3, 'Dra. Sofía Castro', '3109876543', NULL, 'activo', '2026-06-03 21:02:55', 'sofia@psyco.com', '$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
(4, 1, 'Dr. Luis Herrera', '3201239876', NULL, 'activo', '2026-06-03 21:02:55', 'luis@psyco.com', '$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recordatorios`
--

CREATE TABLE `recordatorios` (
  `id_recordatorio` int(11) NOT NULL,
  `id_cita` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_programada` datetime NOT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `canal` enum('correo','whatsapp') NOT NULL DEFAULT 'correo',
  `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `grado` enum('6','7','8','9','10','11') DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL COMMENT 'Hash bcrypt de la contraseña; NULL para usuarios OAuth',
  `acepta_politica` enum('si','no') NOT NULL DEFAULT 'no',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `acudiente_nombre` text NOT NULL,
  `acudiente_cedula` text NOT NULL,
  `acudiente_relacion` text NOT NULL,
  `acudiente_telefono` text DEFAULT NULL,
  `acudiente_correo` text DEFAULT NULL,
  `acudiente_direccion` text DEFAULT NULL,
  `observaciones_psicologicas` text DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(512) DEFAULT NULL COMMENT 'URL de la foto de perfil de Google'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `grado`, `nombre`, `correo_electronico`, `contrasena`, `acepta_politica`, `estado`, `fecha_registro`, `acudiente_nombre`, `acudiente_cedula`, `acudiente_relacion`, `acudiente_telefono`, `acudiente_correo`, `acudiente_direccion`, `observaciones_psicologicas`, `google_id`, `avatar_url`) VALUES
(1, '8', 'David Bedoya Zuluaga', 'pepito1234@gmail.com', '$2y$10$j5ciKLa3LHomxSTgEUOV7.MS5K6ROBoXuJe5IJkO398h6ZuprUviu', 'no', 'activo', '2026-06-03 18:11:08', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '6', 'Valentina Torres', 'valentina.torres@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Carlos Torres', '12345678', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '7', 'Santiago Gómez', 'santiago.gomez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(4, '8', 'Isabella Ramírez', 'isabella.ramirez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Ana Ramírez', '23456789', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(5, '9', 'Sebastián López', 'sebastian.lopez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(6, '10', 'Camila Martínez', 'camila.martinez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Luis Martínez', '34567890', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(7, '11', 'Mateo Rodríguez', 'mateo.rodriguez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(8, '6', 'Luciana Hernández', 'luciana.hernandez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Rosa Hernández', '45678901', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(9, '7', 'Nicolás García', 'nicolas.garcia@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(10, '8', 'Sofía Vargas', 'sofia.vargas@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Jorge Vargas', '56789012', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(11, '9', 'Diego Morales', 'diego.morales@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(12, '10', 'Mariana Jiménez', 'mariana.jimenez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Pedro Jiménez', '67890123', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(13, '11', 'Alejandro Pérez', 'alejandro.perez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(14, '6', 'Gabriela Sánchez', 'gabriela.sanchez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'María Sánchez', '78901234', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(15, '7', 'Andrés Castro', 'andres.castro@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(16, '8', 'Daniela Ruiz', 'daniela.ruiz@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Fernando Ruiz', '89012345', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(17, '9', 'Felipe Flores', 'felipe.flores@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(18, '10', 'Natalia Cruz', 'natalia.cruz@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Roberto Cruz', '90123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(19, '11', 'Julián Torres', 'julian.torres@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(20, '6', 'Valeria Moreno', 'valeria.moreno@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Gloria Moreno', '01234567', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(21, '7', 'Samuel Ortiz', 'samuel.ortiz@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(22, '8', 'Melissa Gutiérrez', 'melissa.gutierrez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Hugo Gutiérrez', '11234567', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(23, '9', 'Tomás Herrera', 'tomas.herrera@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(24, '10', 'Laura Medina', 'laura.medina@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Álvaro Medina', '22345678', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(25, '11', 'Ricardo Aguilar', 'ricardo.aguilar@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(26, '6', 'Paola Reyes', 'paola.reyes@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Claudia Reyes', '33456789', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(27, '7', 'Emilio Vega', 'emilio.vega@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(28, '8', 'Carolina Ríos', 'carolina.rios@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Mauricio Ríos', '44567890', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(29, '9', 'Javier Sandoval', 'javier.sandoval@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(30, '10', 'Ana Delgado', 'ana.delgado@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Ernesto Delgado', '55678901', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(31, '11', 'Pablo Mendoza', 'pablo.mendoza@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(32, '6', 'Adriana Rojas', 'adriana.rojas@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Beatriz Rojas', '66789012', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(33, '7', 'Cristian Navarro', 'cristian.navarro@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(34, '8', 'Lorena Espinoza', 'lorena.espinoza@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Rodrigo Espinoza', '77890123', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(35, '9', 'Esteban Fuentes', 'esteban.fuentes@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(36, '10', 'Verónica Paredes', 'veronica.paredes@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Gustavo Paredes', '88901234', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(37, '11', 'Mauricio Silva', 'mauricio.silva@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(38, '6', 'Alejandra Ibáñez', 'alejandra.ibanez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Patricia Ibáñez', '99012345', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(39, '7', 'Hernán Cabrera', 'hernan.cabrera@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(40, '8', 'Pilar Guerrero', 'pilar.guerrero@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Francisco Guerrero', '10123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(41, '9', 'Rodrigo Campos', 'rodrigo.campos@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(42, '10', 'Mónica Peña', 'monica.pena@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Jaime Peña', '20123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(43, '11', 'Gustavo Bravo', 'gustavo.bravo@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(44, '6', 'Diana Lozano', 'diana.lozano@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Héctor Lozano', '30123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(45, '7', 'Iván Contreras', 'ivan.contreras@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(46, '8', 'Rebeca Acosta', 'rebeca.acosta@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Silvia Acosta', '40123456', 'madre', NULL, NULL, NULL, NULL, NULL, NULL),
(47, '9', 'Leonel Miranda', 'leonel.miranda@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(48, '10', 'Ximena Pacheco', 'ximena.pacheco@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Omar Pacheco', '50123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(49, '11', 'Arturo Domínguez', 'arturo.dominguez@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(50, '6', 'Fernanda Varela', 'fernanda.varela@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'si', 'activo', '2026-06-03 21:53:14', 'Raúl Varela', '60123456', 'padre', NULL, NULL, NULL, NULL, NULL, NULL),
(51, '7', 'Oswaldo Figueroa', 'oswaldo.figueroa@estudiante.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'no', 'activo', '2026-06-03 21:53:14', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(52, '10', 'pepito lopez muñoz', 'aguaconpimienta1234@gmail.com', '$2y$10$BpUV0ZYVzoGSQJSjgUzdkOLemKTbqPnMqwaw3P0lMqYZF0s87PyQi', 'no', 'activo', '2026-06-04 16:57:48', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(53, '11', 'rodrigo di paul', 'frtghbggtyh@gmail.com', '$2y$10$RlU2ZSbU.wF5a1R8wPoOl.eW.trFib/4gRhcq26lDJPDSuuPn6mB2', 'no', 'activo', '2026-06-04 17:47:31', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `chatbot_interacciones`
--
ALTER TABLE `chatbot_interacciones`
  ADD PRIMARY KEY (`id_interaccion`),
  ADD KEY `fk_interaccion_usuario` (`id_usuario`),
  ADD KEY `fk_interaccion_opcion` (`id_opcion`);

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `fk_citas_usuario` (`id_usuario`),
  ADD KEY `fk_citas_psicologo` (`id_psicologo`);

--
-- Indices de la tabla `disponibilidad_psicologos`
--
ALTER TABLE `disponibilidad_psicologos`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD KEY `fk_disp_psicologo` (`id_psicologo`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indices de la tabla `opciones_chatbot`
--
ALTER TABLE `opciones_chatbot`
  ADD PRIMARY KEY (`id_opcion`),
  ADD KEY `fk_opcion_padre` (`id_opcion_padre`);

--
-- Indices de la tabla `psicologos`
--
ALTER TABLE `psicologos`
  ADD PRIMARY KEY (`id_psicologo`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD KEY `fk_psicologo_especialidad` (`id_especialidad`);

--
-- Indices de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD PRIMARY KEY (`id_recordatorio`),
  ADD KEY `fk_recordatorios_cita` (`id_cita`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`),
  ADD UNIQUE KEY `uk_google_id` (`google_id`),
  ADD UNIQUE KEY `idx_google_id` (`google_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `chatbot_interacciones`
--
ALTER TABLE `chatbot_interacciones`
  MODIFY `id_interaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_psicologos`
--
ALTER TABLE `disponibilidad_psicologos`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id_especialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `opciones_chatbot`
--
ALTER TABLE `opciones_chatbot`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `psicologos`
--
ALTER TABLE `psicologos`
  MODIFY `id_psicologo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chatbot_interacciones`
--
ALTER TABLE `chatbot_interacciones`
  ADD CONSTRAINT `fk_interaccion_opcion` FOREIGN KEY (`id_opcion`) REFERENCES `opciones_chatbot` (`id_opcion`),
  ADD CONSTRAINT `fk_interaccion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`),
  ADD CONSTRAINT `fk_citas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `disponibilidad_psicologos`
--
ALTER TABLE `disponibilidad_psicologos`
  ADD CONSTRAINT `fk_disp_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`);

--
-- Filtros para la tabla `psicologos`
--
ALTER TABLE `psicologos`
  ADD CONSTRAINT `fk_psicologo_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`);

--
-- Filtros para la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  ADD CONSTRAINT `fk_recordatorios_cita` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`);

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `notas_paciente`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `notas_paciente` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `id_psicologo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_nota`),
  KEY `fk_nota_psicologo` (`id_psicologo`),
  KEY `fk_nota_usuario` (`id_usuario`),
  CONSTRAINT `fk_nota_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE,
  CONSTRAINT `fk_nota_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `recursos_acompanamiento`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `recursos_acompanamiento` (
  `id_recurso` int(11) NOT NULL AUTO_INCREMENT,
  `id_psicologo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `url_video` varchar(512) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_recurso`),
  KEY `fk_recurso_psicologo` (`id_psicologo`),
  KEY `fk_recurso_usuario` (`id_usuario`),
  CONSTRAINT `fk_recurso_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE,
  CONSTRAINT `fk_recurso_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

