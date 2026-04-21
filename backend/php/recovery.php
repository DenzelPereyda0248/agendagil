<?php
include("conexion.php");

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

$correo = trim($_POST['email'] ?? '');

if (empty($correo)) {
    header("Location: ../html/inicioSesion.php?error=Correo_no_ingresado");
    exit();
}

// Verificar usuario
$stmt = $conexion->prepare("SELECT idUsuario FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    header("Location: ../html/inicioSesion.php?error=Correo_no_existe");
    exit();
}

// Generar token
$token = bin2hex(random_bytes(32));
$expira = date("Y-m-d H:i:s", strtotime("+15 minutes"));

// Guardar token
$update = $conexion->prepare("
    UPDATE usuarios 
    SET reset_token = ?, token_expira = ? 
    WHERE correo = ?
");

$update->bind_param("sss", $token, $expira, $correo);
$update->execute();

// Enlace
$link = "http://localhost/SsitemaAgendagil/php/reset.php?token=$token";
// Enviar correo
$mail = new PHPMailer(true);

try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'denzelmorantes5@gmail.com';
    $mail->Password = 'esft exaq epcb wdwe';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('denzelmorantes5@gmail.com', 'AgendaÁgil');
    $mail->addAddress($correo);

    $mail->isHTML(true);
    $mail->Subject = 'Recuperacion de password';
    $mail->Body = "
        <h2>Recuperar contraseña de goldentooth</h2>
        <p>Haz clic en el siguiente enlace:</p>
        <a href='$link'>Restablecer contraseña</a>
        <p>Este enlace expira en 15 minutos.</p>
    ";

    $mail->send();
    header("Location: ../html/inicioSesion.php?success=Correo_enviado_correctamente");
exit();

}catch(Exception $e){
    echo "Error al enviar correo: {$mail->ErrorInfo}";
}
?>
