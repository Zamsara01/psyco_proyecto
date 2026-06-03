-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-06-2026 a las 01:08:05
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
  `estado` enum('pendiente','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `motivo_consulta` text DEFAULT NULL,
  `notas_sesion` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `contrasena` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD UNIQUE KEY `correo_electronico` (`correo_electronico`);

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
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `disponibilidad_psicologos`
--
ALTER TABLE `disponibilidad_psicologos`
  MODIFY `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_psicologo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recordatorios`
--
ALTER TABLE `recordatorios`
  MODIFY `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
