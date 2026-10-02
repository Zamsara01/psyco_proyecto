<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

class ControllerSuperusuario extends Controller
{
    private function requireSuperusuario(bool $jsonResponse = false): void
    {
        $this->requireAuth('superusuario', $jsonResponse);
    }

    private function logAuditoria(int $idUsuarioActor, string $accion) {
        $pdo = Database::getInstance();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $stmt = $pdo->prepare("INSERT INTO auditoria_contrasenas (id_usuario, ip_address) VALUES (?, ?)");
        $stmt->execute([$idUsuarioActor, $ip]);
    }

    public function index(): void
    {
        $this->redirect('superusuario/usuarios');
    }

    // =========================================================================
    // 1. USUARIOS
    // =========================================================================
    public function usuarios(): void
    {
        $this->requireSuperusuario();
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();

        $perPage = 12;
        $q = trim($_GET['q'] ?? '');
        $like = '%' . $q . '%';
        $tab = $_GET['tab'] ?? 'psicologos';

        if ($tab === 'psicologos') {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM psicologos p JOIN usuario u ON p.id_usuario = u.id_usuario WHERE u.nombre LIKE ? OR u.correo_electronico LIKE ?");
            $totalStmt->execute([$like, $like]);
            $total = (int)$totalStmt->fetchColumn();
            $totalPaginas = max(1, ceil($total / $perPage));
            $offset = ($page - 1) * $perPage;
            $stmt = $pdo->prepare("SELECT p.id_psicologo, u.nombre, u.correo_electronico, u.estado, u.fecha_registro, e.nombre as especialidad, p.id_usuario FROM psicologos p JOIN usuario u ON p.id_usuario = u.id_usuario LEFT JOIN especialidades e ON p.id_especialidad=e.id_especialidad WHERE u.nombre LIKE ? OR u.correo_electronico LIKE ? ORDER BY u.fecha_registro DESC LIMIT ? OFFSET ?");
            $stmt->execute([$like, $like, $perPage, $offset]);
            $psicologos = $stmt->fetchAll();
            $pacientes = [];
            $totalPagPsico = $totalPaginas; $totalPagPac = 1;
            $pagePsico = $page; $pagePac = 1;
            $totalPsico = $total; $totalPac = 0;
        } else {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM usuario u JOIN roles r ON u.id_rol = r.id_rol WHERE r.nombre = 'paciente' AND (u.nombre LIKE ? OR u.correo_electronico LIKE ?)");
            $totalStmt->execute([$like, $like]);
            $total = (int)$totalStmt->fetchColumn();
            $totalPaginas = max(1, ceil($total / $perPage));
            $offset = ($page - 1) * $perPage;
            $stmt = $pdo->prepare("SELECT u.*, p.grado FROM usuario u JOIN roles r ON u.id_rol = r.id_rol JOIN paciente p ON u.id_usuario = p.id_usuario WHERE r.nombre = 'paciente' AND (u.nombre LIKE ? OR u.correo_electronico LIKE ?) ORDER BY u.fecha_registro DESC LIMIT ? OFFSET ?");
            $stmt->execute([$like, $like, $perPage, $offset]);
            $pacientes = $stmt->fetchAll();
            $psicologos = [];
            $totalPagPsico = 1; $totalPagPac = $totalPaginas;
            $pagePsico = 1; $pagePac = $page;
            $totalPsico = 0; $totalPac = $total;
        }

        $especialidades = $pdo->query("SELECT * FROM especialidades ORDER BY nombre")->fetchAll();

        $this->layout = 'tailwind';
        $this->render('pages/superadmin/usuarios', compact(
            'psicologos','pacientes','especialidades','q','tab',
            'totalPagPsico','totalPagPac','pagePsico','pagePac','totalPsico','totalPac'
        ));
    }

    public function crearPsicologo(): void
    {
        $this->requireSuperusuario(true);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';
        $idEsp = (int)($_POST['id_especialidad'] ?? 0);

        if (!$nombre || !$correo || !$password || !$idEsp) { echo json_encode(['ok'=>false,'error'=>'Datos incompletos']); exit; }
        
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE correo_electronico = ?");
        $stmt->execute([$correo]);
        if ($stmt->fetchColumn() > 0) { echo json_encode(['ok'=>false,'error'=>'El correo ya existe']); exit; }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $rolStmt = $pdo->prepare("SELECT id_rol FROM roles WHERE nombre = 'psicologo'");
        $rolStmt->execute();
        $idRol = (int) $rolStmt->fetchColumn();

        $stmt = $pdo->prepare("INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol, estado) VALUES (?, ?, ?, ?, 'activo')");
        if ($stmt->execute([$nombre, $correo, $hash, $idRol])) {
            $idU = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO psicologos (id_psicologo, id_especialidad, id_usuario) VALUES (NULL, ?, ?)")->execute([$idEsp, $idU]);
            echo json_encode(['ok'=>true]);
        } else echo json_encode(['ok'=>false,'error'=>'Error de BD']);
    }

    public function crearPaciente(): void
    {
        $this->requireSuperusuario(true);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';
        $grado = $_POST['grado'] ?? null;

        if (!$nombre || !$correo || !$password) { echo json_encode(['ok'=>false,'error'=>'Datos incompletos']); exit; }

        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE correo_electronico = ?");
        $stmt->execute([$correo]);
        if ($stmt->fetchColumn() > 0) { echo json_encode(['ok'=>false,'error'=>'El correo ya existe']); exit; }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        $rolStmt = $pdo->prepare("SELECT id_rol FROM roles WHERE nombre = 'paciente'");
        $rolStmt->execute();
        $idRol = (int) $rolStmt->fetchColumn();

        $stmt = $pdo->prepare("INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol, estado) VALUES (?, ?, ?, ?, 'activo')");
        if ($stmt->execute([$nombre, $correo, $hash, $idRol])) {
            $idU = $pdo->lastInsertId();
            $pdo->prepare("INSERT INTO paciente (id_usuario, grado) VALUES (?, ?)")->execute([$idU, $grado]);
            echo json_encode(['ok'=>true]);
        } else echo json_encode(['ok'=>false,'error'=>'Error de BD']);
    }

    public function toggleEstadoUser(): void
    {
        $this->requireSuperusuario(true);
        $id = (int)($_POST['id'] ?? 0); // Este ID ahora es id_usuario en la vista de superadmin
        $estado = $_POST['estado'] ?? 'activo';
        
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $stmt = $pdo->prepare("UPDATE usuario SET estado = ? WHERE id_usuario = ?");
        if ($stmt->execute([$estado, $id])) echo json_encode(['ok'=>true]);
        else echo json_encode(['ok'=>false,'error'=>'Error']);
    }

    public function editarUser(): void
    {
        $this->requireSuperusuario(true);
        $id = (int)($_POST['id'] ?? 0); // id_usuario
        $nombre = $_POST['nombre'] ?? '';
        $correo = $_POST['correo'] ?? '';
        $pass = $_POST['password'] ?? '';

        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        if ($pass) {
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE usuario SET nombre = ?, correo_electronico = ?, contrasena = ? WHERE id_usuario = ?");
            $stmt->execute([$nombre, $correo, $hash, $id]);
            $this->logAuditoria((int)$_SESSION['user']['id_usuario'], 'Cambio de contraseña desde edición superadmin a usuario '.$id);
        } else {
            $stmt = $pdo->prepare("UPDATE usuario SET nombre = ?, correo_electronico = ? WHERE id_usuario = ?");
            $stmt->execute([$nombre, $correo, $id]);
        }
        echo json_encode(['ok'=>true]);
    }

    public function inhabilitarTodosPacientes(): void
    {
        $this->requireSuperusuario(true);
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        $pdo->exec("UPDATE usuario u JOIN roles r ON u.id_rol = r.id_rol SET u.estado = 'inactivo' WHERE r.nombre = 'paciente'");
        echo json_encode(['ok'=>true]);
    }

    // =========================================================================
    // 2. CITAS Y RECURSOS
    // =========================================================================
    public function citasRecursos(): void
    {
        $this->requireSuperusuario();
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();

        $perPage = 15;
        $q = trim($_GET['q'] ?? '');
        $like = '%' . $q . '%';
        $tab = $_GET['tab'] ?? 'citas';

        if ($tab === 'citas') {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM citas c JOIN psicologos p ON c.id_psicologo=p.id_psicologo JOIN usuario up ON p.id_usuario = up.id_usuario JOIN paciente pac ON c.id_paciente = pac.id_paciente JOIN usuario u ON pac.id_usuario=u.id_usuario WHERE up.nombre LIKE ? OR u.nombre LIKE ? OR c.estado LIKE ? OR c.fecha LIKE ?");
            $totalStmt->execute([$like, $like, $like, $like]);
            $total = (int)$totalStmt->fetchColumn();
            $totalPagCitas = max(1, ceil($total / $perPage));
            $offset = ($page - 1) * $perPage;
            $stmt = $pdo->prepare("SELECT c.*, up.nombre as psico, u.nombre as pac FROM citas c JOIN psicologos p ON c.id_psicologo=p.id_psicologo JOIN usuario up ON p.id_usuario = up.id_usuario JOIN paciente pac ON c.id_paciente = pac.id_paciente JOIN usuario u ON pac.id_usuario=u.id_usuario WHERE up.nombre LIKE ? OR u.nombre LIKE ? OR c.estado LIKE ? OR c.fecha LIKE ? ORDER BY c.fecha DESC, c.hora DESC LIMIT ? OFFSET ?");
            $stmt->execute([$like, $like, $like, $like, $perPage, $offset]);
            $citas = $stmt->fetchAll();
            $recursos = [];
            $pageCitas = $page; $pageRecursos = 1;
            $totalPagRecursos = 1; $totalCitas = $total; $totalRecursos = 0;
        } else {
            $page = max(1, (int)($_GET['page'] ?? 1));
            $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM recursos_acompanamiento r JOIN psicologos p ON r.id_psicologo=p.id_psicologo JOIN usuario up ON p.id_usuario = up.id_usuario WHERE r.titulo LIKE ? OR up.nombre LIKE ? OR r.tipo LIKE ?");
            $totalStmt->execute([$like, $like, $like]);
            $total = (int)$totalStmt->fetchColumn();
            $totalPagRecursos = max(1, ceil($total / $perPage));
            $offset = ($page - 1) * $perPage;
            $stmt = $pdo->prepare("SELECT r.*, up.nombre as psico FROM recursos_acompanamiento r JOIN psicologos p ON r.id_psicologo=p.id_psicologo JOIN usuario up ON p.id_usuario = up.id_usuario WHERE r.titulo LIKE ? OR up.nombre LIKE ? OR r.tipo LIKE ? ORDER BY r.fecha_creacion DESC LIMIT ? OFFSET ?");
            $stmt->execute([$like, $like, $like, $perPage, $offset]);
            $recursos = $stmt->fetchAll();
            $citas = [];
            $pageCitas = 1; $pageRecursos = $page;
            $totalPagCitas = 1; $totalCitas = 0; $totalRecursos = $total;
        }

        $this->layout = 'tailwind';
        $this->render('pages/superadmin/citas_recursos', compact(
            'citas','recursos','q','tab',
            'totalPagCitas','totalPagRecursos','pageCitas','pageRecursos','totalCitas','totalRecursos'
        ));
    }

    public function toggleCita(): void
    {
        $this->requireSuperusuario(true);
        $id = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? 'cancelada';
        
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE citas SET estado = ? WHERE id_cita = ?");
        $stmt->execute([$estado, $id]);
        echo json_encode(['ok'=>true]);
    }
    
    public function cancelarTodasCitas(): void
    {
        $this->requireSuperusuario(true);
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        $pdo->exec("UPDATE citas SET estado = 'cancelada' WHERE estado = 'pendiente'");
        echo json_encode(['ok'=>true]);
    }

    public function toggleRecurso(): void
    {
        $this->requireSuperusuario(true);
        $id = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? 'inactivo';
        
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("UPDATE recursos_acompanamiento SET estado = ? WHERE id_recurso = ?");
        $stmt->execute([$estado, $id]);
        echo json_encode(['ok'=>true]);
    }

    public function inhabilitarTodosRecursos(): void
    {
        $this->requireSuperusuario(true);
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        $pdo->exec("UPDATE recursos_acompanamiento SET estado = 'inactivo'");
        echo json_encode(['ok'=>true]);
    }

    // =========================================================================
    // 3. CODIGOS OTP
    // =========================================================================
    public function codigos(): void
    {
        $this->requireSuperusuario();
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();

        $perPage = 20;
        $q = trim($_GET['q'] ?? '');
        $like = '%' . $q . '%';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM otp_codes WHERE email LIKE ? OR status LIKE ? OR type LIKE ?");
        $totalStmt->execute([$like, $like, $like]);
        $totalRegistros = (int)$totalStmt->fetchColumn();
        $totalPaginas = max(1, ceil($totalRegistros / $perPage));
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("SELECT * FROM otp_codes WHERE email LIKE ? OR status LIKE ? OR type LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$like, $like, $like, $perPage, $offset]);
        $codigos = $stmt->fetchAll();

        $this->layout = 'tailwind';
        $this->render('pages/superadmin/codigos', compact('codigos','q','page','totalPaginas','totalRegistros'));
    }

    // =========================================================================
    // 4. AUDITORIA
    // =========================================================================
    public function auditoria(): void
    {
        $this->requireSuperusuario();
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();

        $perPage = 20;
        $q = trim($_GET['q'] ?? '');
        $like = '%' . $q . '%';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $totalStmt = $pdo->prepare("SELECT COUNT(*) FROM auditoria_contrasenas a LEFT JOIN usuario u ON a.id_usuario = u.id_usuario WHERE u.correo_electronico LIKE ? OR a.ip_address LIKE ?");
        $totalStmt->execute([$like, $like]);
        $totalRegistros = (int)$totalStmt->fetchColumn();
        $totalPaginas = max(1, ceil($totalRegistros / $perPage));
        $offset = ($page - 1) * $perPage;
        $stmt = $pdo->prepare("SELECT a.*, u.correo_electronico as entidad_email, r.nombre as entidad_tipo FROM auditoria_contrasenas a LEFT JOIN usuario u ON a.id_usuario = u.id_usuario LEFT JOIN roles r ON u.id_rol = r.id_rol WHERE u.correo_electronico LIKE ? OR a.ip_address LIKE ? ORDER BY a.fecha DESC LIMIT ? OFFSET ?");
        $stmt->execute([$like, $like, $perPage, $offset]);
        $auditoria = $stmt->fetchAll();

        $this->layout = 'tailwind';
        $this->render('pages/superadmin/auditoria', compact('auditoria','q','page','totalPaginas','totalRegistros'));
    }

    // =========================================================================
    // 5. IMPORTACIONES
    // =========================================================================
    public function importaciones(): void
    {
        $this->requireSuperusuario();
        $this->layout = 'tailwind';
        $this->render('pages/superadmin/importaciones');
    }

    public function procesarImportacion(): void
    {
        $this->requireSuperusuario(true);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;
        
        $tipo = $_POST['tipo'] ?? ''; // 'pacientes' o 'psicologos'
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['ok'=>false,'error'=>'Falta archivo']); exit;
        }

        $tmpPath = $_FILES['archivo']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
        
        if ($ext !== 'csv' && $ext !== 'txt') {
            echo json_encode(['ok'=>false,'error'=>'Solo CSV o TXT']); exit;
        }

        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $handle = fopen($tmpPath, "r");
        $count = 0;
        
        // Asume formato simple: nombre, correo, contrasena
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($data) < 3) continue;
            $nombre = trim($data[0]);
            $correo = trim($data[1]);
            $pass = trim($data[2]);
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            
            try {
                if ($tipo === 'psicologos') {
                    $rolStmt = $pdo->prepare("SELECT id_rol FROM roles WHERE nombre = 'psicologo'");
                    $rolStmt->execute();
                    $idRol = (int) $rolStmt->fetchColumn();
                    $stmt = $pdo->prepare("INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nombre, $correo, $hash, $idRol]);
                    $idU = $pdo->lastInsertId();
                    $pdo->prepare("INSERT INTO psicologos (id_especialidad, id_usuario) VALUES (1, ?)")->execute([$idU]);
                } else {
                    $rolStmt = $pdo->prepare("SELECT id_rol FROM roles WHERE nombre = 'paciente'");
                    $rolStmt->execute();
                    $idRol = (int) $rolStmt->fetchColumn();
                    $stmt = $pdo->prepare("INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$nombre, $correo, $hash, $idRol]);
                    $idU = $pdo->lastInsertId();
                    $pdo->prepare("INSERT INTO paciente (id_usuario) VALUES (?)")->execute([$idU]);
                }
                $count++;
            } catch (Exception $e) { } // ignorar duplicados
        }
        fclose($handle);

        echo json_encode(['ok'=>true, 'mensaje'=>"$count registros importados"]);
    }

    // =========================================================================
    // 6. EXPORTACIONES
    // =========================================================================
    public function exportaciones(): void
    {
        $this->requireSuperusuario();
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $camposPacientes = $this->getColumnNames($pdo, 'usuario');
        $camposPsicologos = $this->getColumnNames($pdo, 'usuario');

        $this->layout = 'tailwind';
        $this->render('pages/superadmin/exportaciones', [
            'camposPacientes' => $camposPacientes,
            'camposPsicologos' => $camposPsicologos
        ]);
    }

    public function procesarExportacion(): void
    {
        $this->requireSuperusuario();
        $tipo = $_POST['tipo'] ?? 'pacientes';
        $campos = $_POST['campos'] ?? []; // array de nombres de columnas
        
        if (empty($campos)) {
            die("No seleccionaste ningún campo");
        }
        
        require_once dirname(__DIR__, 2) . '/core/Database.php';
        $pdo = Database::getInstance();
        
        $tabla = 'usuario';
        
        // Saneamos campos para seguridad
        $validColumns = $this->getColumnNames($pdo, $tabla);
        $selectCols = [];
        foreach ($campos as $c) {
            if (in_array($c, $validColumns)) $selectCols[] = $c;
        }
        
        if (empty($selectCols)) die("Campos inválidos");
        
        $sql = "SELECT " . implode(", ", $selectCols) . " FROM $tabla";
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="export_'.$tipo.'.csv"');
        
        $out = fopen('php://output', 'w');
        fputcsv($out, $selectCols);
        foreach ($rows as $row) {
            fputcsv($out, $row);
        }
        fclose($out);
        exit;
    }
    
    private function getColumnNames(PDO $pdo, string $table): array
    {
        $stmt = $pdo->query("DESCRIBE $table");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
