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

    public function __construct() 
    {
        $this->mail = new PHPMailer(true);
        
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com'; 
        $this->mail->SMTPAuth   = true;
        // Se espera que EnvLoader haya cargado el .env
        $this->mail->Username   = $_ENV['SMTP_USER'] ?? 'tucorreo@gmail.com'; 
        $this->mail->Password   = $_ENV['SMTP_PASS'] ?? 'tu_app_password'; 
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;
        
        $this->mail->setFrom('no-reply@psycoapp.com', 'PsycoApp');
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

    /**
     * Envía un correo genérico con asunto y cuerpo HTML.
     */
    public function sendEmail(string $toEmail, string $nombreUsuario, string $subject, string $bodyHtml): bool 
    {
        try {
            $this->mail->clearAddresses(); // Limpiar direcciones anteriores por si acaso
            $this->mail->addAddress($toEmail, $nombreUsuario);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $bodyHtml;
            
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            error_log('[MailService] Error enviando correo genérico: ' . $this->mail->ErrorInfo);
            return false;
        }
    }
}
