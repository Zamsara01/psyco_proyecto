import subprocess
import sys

MYSQL = r"C:\xampp\mysql\bin\mysql.exe"
DB = "psyco_intento"

# Sentencias SQL separadas
statements = [
    "SET NAMES utf8mb4",
    "SET FOREIGN_KEY_CHECKS=0",

    # especialidades
    """CREATE TABLE IF NOT EXISTS `especialidades` (
      `id_especialidad` int(11) NOT NULL AUTO_INCREMENT,
      `nombre` varchar(100) NOT NULL,
      `descripcion` text DEFAULT NULL,
      PRIMARY KEY (`id_especialidad`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    "INSERT IGNORE INTO `especialidades` VALUES (1,'Psicologia clinica',NULL),(2,'Orientacion educativa',NULL),(3,'Psicologia infantil y adolescente',NULL)",

    # psicologos
    """CREATE TABLE IF NOT EXISTS `psicologos` (
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
      KEY `fk_psicologo_especialidad` (`id_especialidad`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    """INSERT IGNORE INTO `psicologos` VALUES
      (1,1,'Dra. Elena Vargas','3001234567',NULL,'activo','2026-06-03 21:02:55','elena@psyco.com','$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
      (2,2,'Dr. Ricardo Mena','3007654321',NULL,'activo','2026-06-03 21:02:55','ricardo@psyco.com','$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
      (3,3,'Dra. Sofia Castro','3109876543',NULL,'activo','2026-06-03 21:02:55','sofia@psyco.com','$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa'),
      (4,1,'Dr. Luis Herrera','3201239876',NULL,'activo','2026-06-03 21:02:55','luis@psyco.com','$2y$10$amDwp4g0YnsCbA5YE/uay.rnMmCAnfGV.Xc0s3SaBBDnTpYryPVqa')""",

    # usuarios
    """CREATE TABLE IF NOT EXISTS `usuarios` (
      `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
      `grado` enum('6','7','8','9','10','11') DEFAULT NULL,
      `nombre` varchar(100) NOT NULL,
      `correo_electronico` varchar(100) NOT NULL,
      `contrasena` varchar(255) DEFAULT NULL,
      `acepta_politica` enum('si','no') NOT NULL DEFAULT 'no',
      `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
      `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
      `acudiente_nombre` text DEFAULT NULL,
      `acudiente_cedula` text DEFAULT NULL,
      `acudiente_relacion` text DEFAULT NULL,
      `acudiente_correo` text DEFAULT NULL,
      `google_id` varchar(100) DEFAULT NULL,
      `avatar_url` varchar(512) DEFAULT NULL,
      PRIMARY KEY (`id_usuario`),
      UNIQUE KEY `correo_electronico` (`correo_electronico`),
      UNIQUE KEY `uk_google_id` (`google_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    """INSERT IGNORE INTO `usuarios` (`id_usuario`,`grado`,`nombre`,`correo_electronico`,`contrasena`,`acepta_politica`,`estado`,`fecha_registro`,`acudiente_nombre`,`acudiente_cedula`,`acudiente_relacion`,`acudiente_correo`,`google_id`,`avatar_url`) VALUES
(1,'8','David Bedoya Zuluaga','pepito1234@gmail.com','$2y$10$j5ciKLa3LHomxSTgEUOV7.MS5K6ROBoXuJe5IJkO398h6ZuprUviu','no','activo','2026-06-03 18:11:08',NULL,NULL,NULL,NULL,NULL,NULL),
(2,'6','Valentina Torres','valentina.torres@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(3,'7','Santiago Gomez','santiago.gomez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(4,'8','Isabella Ramirez','isabella.ramirez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(5,'9','Sebastian Lopez','sebastian.lopez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(6,'10','Camila Martinez','camila.martinez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(7,'11','Mateo Rodriguez','mateo.rodriguez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(8,'6','Luciana Hernandez','luciana.hernandez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(9,'7','Nicolas Garcia','nicolas.garcia@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(10,'8','Sofia Vargas','sofia.vargas@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(11,'9','Diego Morales','diego.morales@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(12,'10','Mariana Jimenez','mariana.jimenez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(13,'11','Alejandro Perez','alejandro.perez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(14,'6','Gabriela Sanchez','gabriela.sanchez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(15,'7','Andres Castro','andres.castro@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(16,'8','Daniela Ruiz','daniela.ruiz@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(17,'9','Felipe Flores','felipe.flores@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(18,'10','Natalia Cruz','natalia.cruz@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(19,'11','Julian Torres','julian.torres@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(20,'6','Valeria Moreno','valeria.moreno@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(21,'7','Samuel Ortiz','samuel.ortiz@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(22,'8','Melissa Gutierrez','melissa.gutierrez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(23,'9','Tomas Herrera','tomas.herrera@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(24,'10','Laura Medina','laura.medina@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(25,'11','Ricardo Aguilar','ricardo.aguilar@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(26,'6','Paola Reyes','paola.reyes@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(27,'7','Emilio Vega','emilio.vega@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(28,'8','Carolina Rios','carolina.rios@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(29,'9','Javier Sandoval','javier.sandoval@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(30,'10','Ana Delgado','ana.delgado@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(31,'11','Pablo Mendoza','pablo.mendoza@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(32,'6','Adriana Rojas','adriana.rojas@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(33,'7','Cristian Navarro','cristian.navarro@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(34,'8','Lorena Espinoza','lorena.espinoza@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(35,'9','Esteban Fuentes','esteban.fuentes@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(36,'10','Veronica Paredes','veronica.paredes@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(37,'11','Mauricio Silva','mauricio.silva@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(38,'6','Alejandra Ibanez','alejandra.ibanez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(39,'7','Hernan Cabrera','hernan.cabrera@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(40,'8','Pilar Guerrero','pilar.guerrero@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(41,'9','Rodrigo Campos','rodrigo.campos@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(42,'10','Monica Pena','monica.pena@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(43,'11','Gustavo Bravo','gustavo.bravo@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(44,'6','Diana Lozano','diana.lozano@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(45,'7','Ivan Contreras','ivan.contreras@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(46,'8','Rebeca Acosta','rebeca.acosta@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(47,'9','Leonel Miranda','leonel.miranda@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(48,'10','Ximena Pacheco','ximena.pacheco@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(49,'11','Arturo Dominguez','arturo.dominguez@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(50,'6','Fernanda Varela','fernanda.varela@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','si','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(51,'7','Oswaldo Figueroa','oswaldo.figueroa@estudiante.com','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','no','activo','2026-06-03 21:53:14',NULL,NULL,NULL,NULL,NULL,NULL),
(52,'10','pepito lopez munoz','aguaconpimienta1234@gmail.com','$2y$10$BpUV0ZYVzoGSQJSjgUzdkOLemKTbqPnMqwaw3P0lMqYZF0s87PyQi','no','activo','2026-06-04 16:57:48',NULL,NULL,NULL,NULL,NULL,NULL),
(53,'11','rodrigo di paul','frtghbggtyh@gmail.com','$2y$10$RlU2ZSbU.wF5a1R8wPoOl.eW.trFib/4gRhcq26lDJPDSuuPn6mB2','no','activo','2026-06-04 17:47:31',NULL,NULL,NULL,NULL,NULL,NULL)""",

    # opciones_chatbot
    """CREATE TABLE IF NOT EXISTS `opciones_chatbot` (
      `id_opcion` int(11) NOT NULL AUTO_INCREMENT,
      `id_opcion_padre` int(11) DEFAULT NULL,
      `texto_opcion` varchar(255) NOT NULL,
      `respuesta` text DEFAULT NULL,
      `orden` int(11) NOT NULL DEFAULT 0,
      `activo` tinyint(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id_opcion`)
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    """INSERT IGNORE INTO `opciones_chatbot` VALUES
      (1,NULL,'Agendar una cita','Selecciona una de las siguientes opciones para agendar tu cita.',1,1),
      (2,NULL,'Ver mis citas','Aqui puedes consultar el estado de tus citas.',2,1),
      (3,NULL,'Cancelar una cita','Selecciona la cita que deseas cancelar.',3,1),
      (4,NULL,'Informacion y contacto','Para mas informacion comunicarte con orientacion.',4,1)""",

    # chatbot_interacciones
    """CREATE TABLE IF NOT EXISTS `chatbot_interacciones` (
      `id_interaccion` int(11) NOT NULL AUTO_INCREMENT,
      `id_usuario` int(11) NOT NULL,
      `id_opcion` int(11) NOT NULL,
      `id_sesion` varchar(64) NOT NULL,
      `respuesta` text DEFAULT NULL,
      `fecha_hora` datetime NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id_interaccion`),
      KEY `fk_interaccion_usuario` (`id_usuario`),
      KEY `fk_interaccion_opcion` (`id_opcion`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    # citas
    """CREATE TABLE IF NOT EXISTS `citas` (
      `id_cita` int(11) NOT NULL AUTO_INCREMENT,
      `id_usuario` int(11) NOT NULL,
      `id_psicologo` int(11) NOT NULL,
      `fecha` date NOT NULL,
      `hora` time NOT NULL,
      `duracion_minutos` int(11) NOT NULL DEFAULT 60,
      `estado` enum('pendiente','en proceso','completada','cancelada') NOT NULL DEFAULT 'pendiente',
      `motivo_consulta` text DEFAULT NULL,
      `notas_sesion` text DEFAULT NULL,
      `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id_cita`),
      KEY `fk_citas_usuario` (`id_usuario`),
      KEY `fk_citas_psicologo` (`id_psicologo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    """INSERT IGNORE INTO `citas` (`id_cita`,`id_usuario`,`id_psicologo`,`fecha`,`hora`,`duracion_minutos`,`estado`,`motivo_consulta`,`notas_sesion`,`fecha_creacion`) VALUES
(1,1,1,'2026-06-10','09:00:00',60,'pendiente','Ansiedad escolar y dificultades de concentracion',NULL,'2026-06-03 21:53:14'),
(2,2,2,'2026-06-10','10:00:00',60,'pendiente','Problemas de adaptacion social',NULL,'2026-06-03 21:53:14'),
(3,3,3,'2026-06-10','11:00:00',60,'completada','Seguimiento rendimiento academico',NULL,'2026-06-03 21:53:14'),
(4,4,1,'2026-06-11','09:00:00',60,'pendiente','Manejo de emociones',NULL,'2026-06-03 21:53:14'),
(5,5,2,'2026-06-11','10:00:00',60,'cancelada','Bullying reportado por docente',NULL,'2026-06-03 21:53:14'),
(6,6,3,'2026-06-11','11:00:00',60,'pendiente','Duelo familiar reciente',NULL,'2026-06-03 21:53:14'),
(7,7,1,'2026-06-12','09:00:00',60,'completada','Primera valoracion psicologica',NULL,'2026-06-03 21:53:14'),
(8,8,2,'2026-06-12','10:00:00',60,'pendiente','Dificultades de aprendizaje',NULL,'2026-06-03 21:53:14'),
(9,9,3,'2026-06-12','11:00:00',60,'pendiente','Estres por examenes',NULL,'2026-06-03 21:53:14'),
(10,10,1,'2026-06-13','09:00:00',60,'completada','Seguimiento trimestral',NULL,'2026-06-03 21:53:14')""",

    # disponibilidad_psicologos
    """CREATE TABLE IF NOT EXISTS `disponibilidad_psicologos` (
      `id_disponibilidad` int(11) NOT NULL AUTO_INCREMENT,
      `id_psicologo` int(11) NOT NULL,
      `dia_semana` varchar(20) NOT NULL,
      `hora_inicio` time NOT NULL,
      `hora_fin` time NOT NULL,
      `activo` tinyint(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id_disponibilidad`),
      KEY `fk_disp_psicologo` (`id_psicologo`)
    ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    """INSERT IGNORE INTO `disponibilidad_psicologos` VALUES
(1,1,'Lunes','08:00:00','12:00:00',1),(2,1,'Lunes','14:00:00','18:00:00',1),
(3,1,'Martes','08:00:00','12:00:00',1),(4,1,'Martes','14:00:00','18:00:00',1),
(5,1,'Miercoles','08:00:00','12:00:00',1),(6,1,'Miercoles','14:00:00','18:00:00',1),
(7,1,'Jueves','08:00:00','12:00:00',1),(8,1,'Jueves','14:00:00','18:00:00',1),
(9,1,'Viernes','08:00:00','12:00:00',1),(10,1,'Viernes','14:00:00','18:00:00',1),
(11,2,'Lunes','09:00:00','13:00:00',1),(12,2,'Lunes','15:00:00','19:00:00',1),
(13,2,'Miercoles','09:00:00','13:00:00',1),(14,2,'Miercoles','15:00:00','19:00:00',1),
(15,2,'Viernes','09:00:00','13:00:00',1),(16,2,'Viernes','15:00:00','19:00:00',1),
(17,3,'Martes','08:00:00','12:00:00',1),(18,3,'Martes','13:00:00','16:00:00',1),
(19,3,'Jueves','08:00:00','12:00:00',1),(20,3,'Jueves','13:00:00','16:00:00',1),
(21,4,'Lunes','10:00:00','14:00:00',1),(22,4,'Lunes','15:00:00','18:00:00',1),
(23,4,'Martes','10:00:00','14:00:00',1),(24,4,'Martes','15:00:00','18:00:00',1),
(25,4,'Miercoles','10:00:00','14:00:00',1),(26,4,'Miercoles','15:00:00','18:00:00',1),
(27,4,'Jueves','10:00:00','14:00:00',1),(28,4,'Jueves','15:00:00','18:00:00',1),
(29,4,'Viernes','10:00:00','14:00:00',1),(30,4,'Viernes','15:00:00','18:00:00',1)""",

    # recordatorios
    """CREATE TABLE IF NOT EXISTS `recordatorios` (
      `id_recordatorio` int(11) NOT NULL AUTO_INCREMENT,
      `id_cita` int(11) NOT NULL,
      `mensaje` text NOT NULL,
      `fecha_programada` datetime NOT NULL,
      `fecha_envio` datetime DEFAULT NULL,
      `canal` enum('correo','whatsapp') NOT NULL DEFAULT 'correo',
      `estado_envio` enum('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
      PRIMARY KEY (`id_recordatorio`),
      KEY `fk_recordatorios_cita` (`id_cita`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    # notas_paciente
    """CREATE TABLE IF NOT EXISTS `notas_paciente` (
      `id_nota` int(11) NOT NULL AUTO_INCREMENT,
      `id_psicologo` int(11) NOT NULL,
      `id_usuario` int(11) NOT NULL,
      `titulo` varchar(255) NOT NULL,
      `contenido` text NOT NULL,
      `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id_nota`),
      KEY `fk_nota_psicologo` (`id_psicologo`),
      KEY `fk_nota_usuario` (`id_usuario`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    # recursos_acompanamiento
    """CREATE TABLE IF NOT EXISTS `recursos_acompanamiento` (
      `id_recurso` int(11) NOT NULL AUTO_INCREMENT,
      `id_psicologo` int(11) NOT NULL,
      `id_usuario` int(11) NOT NULL,
      `titulo` varchar(255) NOT NULL,
      `url_video` varchar(512) NOT NULL,
      `descripcion` text DEFAULT NULL,
      `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id_recurso`),
      KEY `fk_recurso_psicologo` (`id_psicologo`),
      KEY `fk_recurso_usuario` (`id_usuario`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    # otp_codes
    """CREATE TABLE IF NOT EXISTS `otp_codes` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `correo_electronico` varchar(100) NOT NULL,
      `codigo` varchar(10) NOT NULL,
      `tipo` varchar(50) NOT NULL DEFAULT 'register',
      `expira_en` datetime NOT NULL,
      `usado` tinyint(1) NOT NULL DEFAULT 0,
      `created_at` datetime NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`id`),
      KEY `idx_correo_tipo` (`correo_electronico`,`tipo`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci""",

    # Foreign keys (after all tables exist)
    "ALTER TABLE `psicologos` ADD CONSTRAINT `fk_psicologo_especialidad` FOREIGN KEY IF NOT EXISTS (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`)",
    "ALTER TABLE `citas` ADD CONSTRAINT `fk_citas_usuario` FOREIGN KEY IF NOT EXISTS (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)",
    "ALTER TABLE `citas` ADD CONSTRAINT `fk_citas_psicologo` FOREIGN KEY IF NOT EXISTS (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`)",
    "ALTER TABLE `chatbot_interacciones` ADD CONSTRAINT `fk_interaccion_usuario` FOREIGN KEY IF NOT EXISTS (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)",
    "ALTER TABLE `chatbot_interacciones` ADD CONSTRAINT `fk_interaccion_opcion` FOREIGN KEY IF NOT EXISTS (`id_opcion`) REFERENCES `opciones_chatbot` (`id_opcion`)",
    "ALTER TABLE `disponibilidad_psicologos` ADD CONSTRAINT `fk_disp_psicologo` FOREIGN KEY IF NOT EXISTS (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`)",
    "ALTER TABLE `recordatorios` ADD CONSTRAINT `fk_recordatorios_cita` FOREIGN KEY IF NOT EXISTS (`id_cita`) REFERENCES `citas` (`id_cita`)",
    "ALTER TABLE `notas_paciente` ADD CONSTRAINT `fk_nota_psicologo` FOREIGN KEY IF NOT EXISTS (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE",
    "ALTER TABLE `notas_paciente` ADD CONSTRAINT `fk_nota_usuario` FOREIGN KEY IF NOT EXISTS (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE",
    "ALTER TABLE `recursos_acompanamiento` ADD CONSTRAINT `fk_recurso_psicologo` FOREIGN KEY IF NOT EXISTS (`id_psicologo`) REFERENCES `psicologos` (`id_psicologo`) ON DELETE CASCADE",
    "ALTER TABLE `recursos_acompanamiento` ADD CONSTRAINT `fk_recurso_usuario` FOREIGN KEY IF NOT EXISTS (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE",

    "SET FOREIGN_KEY_CHECKS=1",
]

errors = []
for i, stmt in enumerate(statements):
    result = subprocess.run(
        [MYSQL, "-u", "root", DB, "-e", stmt],
        capture_output=True, text=True
    )
    if result.returncode != 0:
        print(f"[ERROR] Statement {i}: {result.stderr.strip()[:200]}")
        errors.append((i, result.stderr.strip()))
    else:
        print(f"[OK]    Statement {i}")

if errors:
    print(f"\n{len(errors)} error(s) found.")
    sys.exit(1)
else:
    print("\nAll statements executed successfully!")
    sys.exit(0)
