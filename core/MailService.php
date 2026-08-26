<?php
require_once __DIR__ . '/EnvLoader.php';
require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService 
{
    private PHPMailer $mail;
    private ?RecordatorioModel $recordatorioModel = null;

    public function __construct() 
    {
        $this->mail = new PHPMailer(true);
        
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com'; 
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['SMTP_USER'] ?? 'tucorreo@gmail.com'; 
        $this->mail->Password   = $_ENV['SMTP_PASS'] ?? 'tu_app_password'; 
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        
        $this->mail->setFrom('no-reply@psycoapp.com', 'PsycoApp');
    }

    public function setRecordatorioModel(RecordatorioModel $model): void
    {
        $this->recordatorioModel = $model;
    }

    public function sendOtpEmail(string $toEmail, string $nombreUsuario, string $codigo): bool 
    {
        try {
            $this->mail->addAddress($toEmail, $nombreUsuario);
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Tu codigo de verificacion de PsycoApp';
            
            $this->mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                    <h2 style='color: #4A90E2;'>Hola {$nombreUsuario},</h2>
                    <p>Gracias por registrarte. Para completar tu registro, por favor ingresa el siguiente código de verificación:</p>
                    <div style='background-color: #f4f4f4; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;'>
                        <span style='font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #333;'>{$codigo}</span>
                    </div>
                    <p style='color: #888; font-size: 12px;'>Este código expirará en 10 minutos. Si no solicitaste este registro, ignora este correo.</p>
                </div>
            ";
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log('[MailService] Error enviando correo: ' . $this->mail->ErrorInfo);
            return false;
        }
    }

    public function sendRecordatorioEstudiante(
        string $toEmail,
        string $nombreEstudiante,
        string $nombrePsicologo,
        string $fecha,
        string $hora,
        string $especialidad,
        int $idCita = 0
    ): bool {
        $asunto = 'Recordatorio: Tu cita de mañana en PsycoApp';
        $cuerpo = $this->getRecordatorioEstudianteBody($nombreEstudiante, $nombrePsicologo, $fecha, $hora, $especialidad);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombreEstudiante, $asunto, $cuerpo);
    }

    private function getRecordatorioEstudianteBody(string $nombreEstudiante, string $nombrePsicologo, string $fecha, string $hora, string $especialidad): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #4A90E2;'>Hola {$nombreEstudiante},</h2>
                <p>Te recordamos que tienes una cita programada para <strong>mañana</strong>:</p>
                
                <div style='background-color: #f0f7ff; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #4A90E2;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👩‍⚕️ Psicólogo/a:</strong> {$nombrePsicologo}</p>
                    <p style='margin: 8px 0;'><strong>🎯 Especialidad:</strong> {$especialidad}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    Por favor, llega con 5 minutos de anticipación. Si necesitas cancelar o reagendar, 
                    hazlo con al menos 24 horas de antelación desde tu panel de citas.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    Este es un recordatorio automático de PsycoApp.<br>
                    No respondas a este correo.
                </p>
            </div>
        ";
    }

    public function sendRecordatorioPsicologo(
        string $toEmail,
        string $nombrePsicologo,
        string $nombreEstudiante,
        string $fecha,
        string $hora,
        string $motivoConsulta,
        int $idCita = 0
    ): bool {
        $asunto = 'Recordatorio: Cita programada para mañana';
        $cuerpo = $this->getRecordatorioPsicologoBody($nombrePsicologo, $nombreEstudiante, $fecha, $hora, $motivoConsulta);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombrePsicologo, $asunto, $cuerpo);
    }

    private function getRecordatorioPsicologoBody(string $nombrePsicologo, string $nombreEstudiante, string $fecha, string $hora, string $motivoConsulta): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #2E7D32;'>Hola {$nombrePsicologo},</h2>
                <p>Tienes una cita programada para <strong>mañana</strong>:</p>
                
                <div style='background-color: #f1f8e9; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2E7D32;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👤 Paciente:</strong> {$nombreEstudiante}</p>
                    <p style='margin: 8px 0;'><strong>📝 Motivo:</strong> {$motivoConsulta}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    Revisa tus notas y prepara la sesión. Puedes ver el historial completo 
                    desde tu panel de psicóloga.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    Recordatorio automático de PsycoApp.
                </p>
            </div>
        ";
    }

    public function sendConfirmacionCitaEstudiante(
        string $toEmail,
        string $nombreEstudiante,
        string $nombrePsicologo,
        string $fecha,
        string $hora,
        string $especialidad,
        int $idCita = 0
    ): bool {
        $asunto = 'Confirmación: Tu cita ha sido agendada en PsycoApp';
        $cuerpo = $this->getConfirmacionCitaEstudianteBody($nombreEstudiante, $nombrePsicologo, $fecha, $hora, $especialidad);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombreEstudiante, $asunto, $cuerpo);
    }

    private function getConfirmacionCitaEstudianteBody(string $nombreEstudiante, string $nombrePsicologo, string $fecha, string $hora, string $especialidad): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #4A90E2;'>¡Hola {$nombreEstudiante}!</h2>
                <p>Tu cita ha sido <strong>confirmada</strong> exitosamente:</p>
                
                <div style='background-color: #e8f5e9; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #4CAF50;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👩‍⚕️ Psicólogo/a:</strong> {$nombrePsicologo}</p>
                    <p style='margin: 8px 0;'><strong>🎯 Especialidad:</strong> {$especialidad}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    <strong>Recordatorios automáticos:</strong><br>
                    • Recibirás un recordatorio 1 día antes<br>
                    • Recibirás otro recordatorio 1 hora antes
                </p>
                
                <p style='color: #666; font-size: 14px;'>
                    Si necesitas cancelar o reagendar, hazlo con al menos 24 horas 
                    de antelación desde tu panel de citas.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    PsycoApp - Tu bienestar mental
                </p>
            </div>
        ";
    }

    public function sendConfirmacionCitaPsicologo(
        string $toEmail,
        string $nombrePsicologo,
        string $nombreEstudiante,
        string $fecha,
        string $hora,
        string $motivoConsulta,
        int $idCita = 0
    ): bool {
        $asunto = 'Nueva cita agendada en tu agenda';
        $cuerpo = $this->getConfirmacionCitaPsicologoBody($nombrePsicologo, $nombreEstudiante, $fecha, $hora, $motivoConsulta);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombrePsicologo, $asunto, $cuerpo);
    }

    private function getConfirmacionCitaPsicologoBody(string $nombrePsicologo, string $nombreEstudiante, string $fecha, string $hora, string $motivoConsulta): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #2E7D32;'>Hola {$nombrePsicologo},</h2>
                <p>Se ha agendado una <strong>nueva cita</strong> en tu agenda:</p>
                
                <div style='background-color: #f1f8e9; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #2E7D32;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👤 Paciente:</strong> {$nombreEstudiante}</p>
                    <p style='margin: 8px 0;'><strong>📝 Motivo:</strong> {$motivoConsulta}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    La cita aparecerá en tu panel. Recibirás recordatorios automáticos 
                    1 día antes y 1 hora antes de la sesión.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    PsycoApp - Panel de psicóloga
                </p>
            </div>
        ";
    }

    public function sendRecordatorio1HoraEstudiante(
        string $toEmail,
        string $nombreEstudiante,
        string $nombrePsicologo,
        string $fecha,
        string $hora,
        string $especialidad,
        int $idCita = 0
    ): bool {
        $asunto = '⏰ Recordatorio: Tu cita es en 1 hora';
        $cuerpo = $this->getRecordatorio1HoraEstudianteBody($nombreEstudiante, $nombrePsicologo, $fecha, $hora, $especialidad);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombreEstudiante, $asunto, $cuerpo);
    }

    private function getRecordatorio1HoraEstudianteBody(string $nombreEstudiante, string $nombrePsicologo, string $fecha, string $hora, string $especialidad): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #FF9800;'>⏰ Hola {$nombreEstudiante},</h2>
                <p>Tu cita comienza en <strong>1 hora</strong>:</p>
                
                <div style='background-color: #fff3e0; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #FF9800;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👩‍⚕️ Psicólogo/a:</strong> {$nombrePsicologo}</p>
                    <p style='margin: 8px 0;'><strong>🎯 Especialidad:</strong> {$especialidad}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    Prepárate para tu sesión. Asegúrate de tener buena conexión 
                    si es videollamada, o de llegar con tiempo si es presencial.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    Recordatorio automático de PsycoApp (1 hora antes)
                </p>
            </div>
        ";
    }

    public function sendRecordatorio1HoraPsicologo(
        string $toEmail,
        string $nombrePsicologo,
        string $nombreEstudiante,
        string $fecha,
        string $hora,
        string $motivoConsulta,
        int $idCita = 0
    ): bool {
        $asunto = '⏰ Recordatorio: Cita en 1 hora';
        $cuerpo = $this->getRecordatorio1HoraPsicologoBody($nombrePsicologo, $nombreEstudiante, $fecha, $hora, $motivoConsulta);
        return $this->enviarYRegistrar($idCita, $toEmail, $nombrePsicologo, $asunto, $cuerpo);
    }

    private function getRecordatorio1HoraPsicologoBody(string $nombrePsicologo, string $nombreEstudiante, string $fecha, string $hora, string $motivoConsulta): string
    {
        $fechaFormateada = date('d/m/Y', strtotime($fecha));
        $horaFormateada = date('H:i', strtotime($hora));
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #FF9800;'>⏰ Hola {$nombrePsicologo},</h2>
                <p>Tienes una cita que comienza en <strong>1 hora</strong>:</p>
                
                <div style='background-color: #fff3e0; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #FF9800;'>
                    <p style='margin: 8px 0;'><strong>📅 Fecha:</strong> {$fechaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>🕐 Hora:</strong> {$horaFormateada}</p>
                    <p style='margin: 8px 0;'><strong>👤 Paciente:</strong> {$nombreEstudiante}</p>
                    <p style='margin: 8px 0;'><strong>📝 Motivo:</strong> {$motivoConsulta}</p>
                </div>
                
                <p style='color: #666; font-size: 14px;'>
                    Prepara tus notas y materiales para la sesión.
                </p>
                
                <hr style='margin: 20px 0; border-color: #e0e0e0;'>
                <p style='color: #888; font-size: 12px; text-align: center;'>
                    Recordatorio automático de PsycoApp (1 hora antes)
                </p>
            </div>
        ";
    }

    /**
     * Envía email y registra en BD si hay modelo configurado
     */
    private function enviarYRegistrar(int $idCita, string $toEmail, string $nombre, string $asunto, string $cuerpo): bool
    {
        try {
            $this->mail->addAddress($toEmail, $nombre);
            $this->mail->isHTML(true);
            $this->mail->Subject = $asunto;
            $this->mail->Body = $cuerpo;
            
            $this->mail->send();
            $this->mail->clearAddresses();
            
            // Registrar en BD si hay modelo y id_cita
            if ($this->recordatorioModel && $idCita > 0) {
                $idRecordatorio = $this->recordatorioModel->crearRecordatorio($idCita, $cuerpo, date('Y-m-d H:i:s'));
                $this->recordatorioModel->marcarEnviado($idRecordatorio);
            }
            
            return true;
        } catch (Exception $e) {
            error_log('[MailService] Error enviando correo: ' . $this->mail->ErrorInfo);
            $this->mail->clearAddresses();
            
            // Registrar fallo en BD
            if ($this->recordatorioModel && $idCita > 0) {
                $idRecordatorio = $this->recordatorioModel->crearRecordatorio($idCita, $cuerpo, date('Y-m-d H:i:s'));
                $this->recordatorioModel->marcarFallido($idRecordatorio);
            }
            
            return false;
        }
    }
}