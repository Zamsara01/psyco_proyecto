-- ============================================================
--  Parche: Soporte Google OAuth en la tabla `usuarios`
--  Ejecutar UNA SOLA VEZ en tu base de datos MySQL/MariaDB
-- ============================================================

-- 1. Columna para el identificador único de Google (campo "sub")
ALTER TABLE `usuarios`
    ADD COLUMN IF NOT EXISTS `google_id`  VARCHAR(128)  NULL DEFAULT NULL
        COMMENT 'Google OAuth subject ID (campo sub del perfil)'
        AFTER `contrasena`;

-- 2. Columna para la URL del avatar de Google
ALTER TABLE `usuarios`
    ADD COLUMN IF NOT EXISTS `avatar_url` VARCHAR(512)  NULL DEFAULT NULL
        COMMENT 'URL de la foto de perfil de Google'
        AFTER `google_id`;

-- 3. Índice único en google_id para búsquedas rápidas y evitar duplicados
-- (saltamos si ya existe para poder re-ejecutar el script con seguridad)
ALTER TABLE `usuarios`
    ADD UNIQUE INDEX IF NOT EXISTS `idx_google_id` (`google_id`);

-- 4. Permitir contrasena vacía (los usuarios OAuth no tienen contraseña local)
--    Cambia de NOT NULL a NULL si la columna ya era NOT NULL
-- NOTA: Ajusta el tipo de dato si tu columna usa un tipo diferente.
ALTER TABLE `usuarios`
    MODIFY COLUMN `contrasena` VARCHAR(255) NULL DEFAULT NULL
        COMMENT 'Hash bcrypt de la contraseña; NULL para usuarios OAuth';

-- ============================================================
--  Verificar resultado
-- ============================================================
DESCRIBE `usuarios`;
