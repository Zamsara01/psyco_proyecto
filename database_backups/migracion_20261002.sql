-- Desactivar temporalmente validaciones de llaves foráneas para facilitar la refactorización
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Crear tabla unificada `usuario`
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `rol` enum('paciente','psicologo','superusuario') NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `google_id` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(512) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_electronico` (`correo_electronico`),
  UNIQUE KEY `google_id` (`google_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Crear tabla `paciente`
CREATE TABLE IF NOT EXISTS `paciente` (
  `id_paciente` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `grado` enum('6','7','8','9','10','11') DEFAULT NULL,
  `acepta_politica` enum('si','no') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id_paciente`),
  UNIQUE KEY `uk_paciente_usuario` (`id_usuario`),
  CONSTRAINT `fk_paciente_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Migrar pacientes (desde `usuarios` a `usuario` y `paciente`)
INSERT INTO `usuario` (
  `id_usuario`, `nombre`, `correo_electronico`, `contrasena`, 
  `estado`, `rol`, `fecha_registro`, `google_id`, `avatar_url`, `email_verified_at`
)
SELECT 
  `id_usuario`, `nombre`, `correo_electronico`, `contrasena`, 
  `estado`, 'paciente', `fecha_registro`, `google_id`, `avatar_url`, 
  IF(`verificado` = 1, IFNULL(`email_verified_at`, current_timestamp()), `email_verified_at`)
FROM `usuarios`;

INSERT INTO `paciente` (`id_usuario`, `grado`, `acepta_politica`)
SELECT `id_usuario`, `grado`, `acepta_politica` FROM `usuarios`;

-- Migrar acudientes
INSERT IGNORE INTO `datos_acudiente` (`id_usuario`, `nombre`, `cedula`, `relacion`, `correo`)
SELECT `id_usuario`, `acudiente_nombre`, `acudiente_cedula`, `acudiente_relacion`, `acudiente_correo`
FROM `usuarios`
WHERE `acudiente_nombre` IS NOT NULL AND `acudiente_nombre` != '';

-- 4. Migrar psicólogos
ALTER TABLE `psicologos` ADD COLUMN `id_usuario` int(11) DEFAULT NULL AFTER `id_psicologo`;

INSERT INTO `usuario` (`nombre`, `correo_electronico`, `contrasena`, `estado`, `rol`, `fecha_registro`, `avatar_url`)
SELECT `nombre`, `correo_electronico`, `contrasena`, `estado`, 'psicologo', `fecha_registro`, `foto_perfil`
FROM `psicologos`;

UPDATE `psicologos` p
JOIN `usuario` u ON p.correo_electronico = u.correo_electronico
SET p.id_usuario = u.id_usuario;

ALTER TABLE `psicologos` ADD CONSTRAINT `fk_psicologo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;
ALTER TABLE `psicologos` DROP COLUMN `nombre`;
ALTER TABLE `psicologos` DROP COLUMN `estado`;
ALTER TABLE `psicologos` DROP COLUMN `fecha_registro`;
ALTER TABLE `psicologos` DROP COLUMN `correo_electronico`;
ALTER TABLE `psicologos` DROP COLUMN `contrasena`;

-- 5. Migrar superusuarios
ALTER TABLE `superusuarios` ADD COLUMN `id_usuario` int(11) DEFAULT NULL AFTER `id_superusuario`;

INSERT INTO `usuario` (`nombre`, `correo_electronico`, `contrasena`, `estado`, `rol`, `fecha_registro`)
SELECT `nombre`, `correo_electronico`, `contrasena`, `estado`, 'superusuario', `fecha_registro`
FROM `superusuarios`;

UPDATE `superusuarios` s
JOIN `usuario` u ON s.correo_electronico = u.correo_electronico
SET s.id_usuario = u.id_usuario;

ALTER TABLE `superusuarios` ADD CONSTRAINT `fk_superusuario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;
ALTER TABLE `superusuarios` DROP COLUMN `nombre`;
ALTER TABLE `superusuarios` DROP COLUMN `estado`;
ALTER TABLE `superusuarios` DROP COLUMN `fecha_registro`;
ALTER TABLE `superusuarios` DROP COLUMN `correo_electronico`;
ALTER TABLE `superusuarios` DROP COLUMN `contrasena`;

-- 6. Ajustar Recordatorios y Citas
ALTER TABLE `recordatorios` ADD COLUMN `tipo` enum('24h','1h') DEFAULT NULL AFTER `id_cita`;
ALTER TABLE `recordatorios` MODIFY COLUMN `mensaje` text DEFAULT NULL;

ALTER TABLE `citas` DROP COLUMN `recordatorio_24h`;
ALTER TABLE `citas` DROP COLUMN `recordatorio_1h`;

-- 7. Disponibilidad Psicologos
ALTER TABLE `disponibilidad_psicologos` DROP COLUMN `jornada`;

-- 8. Notas paciente
ALTER TABLE `notas_paciente` ADD COLUMN `id_cita` int(11) DEFAULT NULL AFTER `id_usuario`;
ALTER TABLE `notas_paciente` ADD CONSTRAINT `fk_notas_cita` FOREIGN KEY (`id_cita`) REFERENCES `citas` (`id_cita`) ON DELETE SET NULL;

-- 9. Auditoria contrasenas
ALTER TABLE `auditoria_contrasenas` ADD COLUMN `id_usuario` int(11) DEFAULT NULL AFTER `id_auditoria`;

UPDATE `auditoria_contrasenas` a
JOIN `usuario` u ON a.entidad_email = u.correo_electronico
SET a.id_usuario = u.id_usuario;

ALTER TABLE `auditoria_contrasenas` DROP COLUMN `entidad_tipo`;
ALTER TABLE `auditoria_contrasenas` DROP COLUMN `entidad_email`;
ALTER TABLE `auditoria_contrasenas` ADD CONSTRAINT `fk_auditoria_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

-- 10. OTP codes
ALTER TABLE `otp_codes` ADD COLUMN `id_usuario` int(11) DEFAULT NULL AFTER `id`;
UPDATE `otp_codes` o
JOIN `usuario` u ON o.email = u.correo_electronico
SET o.id_usuario = u.id_usuario;

-- 11. Ajustar claves foráneas
ALTER TABLE `citas` DROP FOREIGN KEY `fk_citas_usuario`;
ALTER TABLE `citas` ADD CONSTRAINT `fk_citas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

ALTER TABLE `datos_acudiente` DROP FOREIGN KEY `datos_acudiente_ibfk_1`;
ALTER TABLE `datos_acudiente` ADD CONSTRAINT `fk_datos_acudiente_paciente` FOREIGN KEY (`id_usuario`) REFERENCES `paciente` (`id_usuario`) ON DELETE CASCADE;

ALTER TABLE `notas_paciente` DROP FOREIGN KEY `notas_paciente_ibfk_2`;
ALTER TABLE `notas_paciente` ADD CONSTRAINT `fk_notas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

ALTER TABLE `recursos_acompanamiento` DROP FOREIGN KEY `recursos_acompanamiento_ibfk_2`;
ALTER TABLE `recursos_acompanamiento` ADD CONSTRAINT `fk_recursos_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

-- 12. ELIMINAR tabla antigua
DROP TABLE `usuarios`;

SET FOREIGN_KEY_CHECKS = 1;
