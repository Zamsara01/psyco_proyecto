CREATE TABLE `auditoria_contrasenas` (
  `id_auditoria` int(11) NOT NULL AUTO_INCREMENT,
  `entidad_tipo` enum('paciente','psicologo','superusuario') NOT NULL,
  `entidad_email` varchar(100) NOT NULL,
  `realizado_por` varchar(150) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_auditoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_psicologo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `duracion_minutos` int(11) NOT NULL DEFAULT 60,
  `hora_inicio_real` timestamp NULL DEFAULT NULL,
  `estado` enum('pendiente','en proceso','completada','cancelada') NOT NULL DEFAULT 'pendiente',
  `asistio` tinyint(1) DEFAULT NULL,
  `motivo_consulta` text DEFAULT NULL,
  `notas_sesion` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `recordatorio_24h` tinyint(1) DEFAULT 0,
  `recordatorio_1h` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_cita`),
  KEY `fk_citas_usuario` (`id_usuario`),
  KEY `fk_citas_psicologo` (`id_psicologo`),
  CONSTRAINT `fk_citas_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`),
  CONSTRAINT `fk_citas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `datos_acudiente` (
  `id_acudiente` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `relacion` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_acudiente`),
  UNIQUE KEY `uk_usuario` (`id_usuario`),
  CONSTRAINT `datos_acudiente_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `disponibilidad_psicologos` (
  `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT,
  `id_psicologo` int(11) NOT NULL,
  `dia_semana` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `jornada` varchar(20) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_disponibilidad`),
  KEY `fk_disp_psicologo` (`id_psicologo`),
  CONSTRAINT `fk_disp_psicologo` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `especialidades` (
  `id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `notas_paciente` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `id_psicologo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_nota`),
  KEY `id_psicologo` (`id_psicologo`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `notas_paciente_ibfk_1` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE,
  CONSTRAINT `notas_paciente_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `otp_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `code_hash` varchar(64) NOT NULL COMMENT 'SHA-256 hash del código OTP',
  `type` enum('register','login_psicologa') NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT 'Intentos de verificación',
  `status` enum('active','used','expired','blocked') NOT NULL DEFAULT 'active',
  `expires_at` datetime NOT NULL COMMENT 'Expiración: created_at + 7 minutos',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_email_status` (`email`,`status`),
  KEY `idx_expires` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `psicologos` (
  `id_psicologo` int(11) NOT NULL AUTO_INCREMENT,
  `id_especialidad` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  PRIMARY KEY (`id_psicologo`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  KEY `fk_psicologo_especialidad` (`id_especialidad`),
  CONSTRAINT `fk_psicologo_especialidad` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `recordatorios` (
  `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT,
  `id_cita` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_programada` datetime NOT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `canal` enum('correo','whatsapp') NOT NULL DEFAULT 'correo',
  `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id_recordatorio`),
  KEY `fk_recordatorios_cita` (`id_cita`),
  CONSTRAINT `fk_recordatorios_cita` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `recursos_acompanamiento` (
  `id_recurso` int(11) NOT NULL AUTO_INCREMENT,
  `id_psicologo` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `tipo` enum('video','mensaje','imagen') NOT NULL DEFAULT 'video',
  `url_video` varchar(512) DEFAULT NULL,
  `imagen_ruta` varchar(512) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  PRIMARY KEY (`id_recurso`),
  KEY `id_psicologo` (`id_psicologo`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `recursos_acompanamiento_ibfk_1` FOREIGN KEY (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE,
  CONSTRAINT `recursos_acompanamiento_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `superusuarios` (
  `id_superusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_registro` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_superusuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `grado` enum('6','7','8','9','10','11') DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL COMMENT 'Hash bcrypt de la contraseña; NULL para usuarios OAuth',
  `acepta_politica` enum('si','no') NOT NULL DEFAULT 'no',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `email_verified_at` datetime DEFAULT NULL COMMENT 'Timestamp de verificación OTP; NULL = email no verificado',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `acudiente_nombre` text DEFAULT NULL,
  `acudiente_cedula` text DEFAULT NULL,
  `acudiente_relacion` text DEFAULT NULL,
  `acudiente_correo` text DEFAULT NULL,
  `observaciones_psicologicas` text DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(512) DEFAULT NULL COMMENT 'URL de la foto de perfil de Google',
  `verificado` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  UNIQUE KEY `uk_google_id` (`google_id`),
  UNIQUE KEY `idx_google_id` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

