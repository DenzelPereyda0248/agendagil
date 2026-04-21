<?php
include("conexion.php");

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

// Validaciones
if (empty($token) || empty($password) || empty($confirm)) {
    header('Location: reset.php?token=' . urlencode($token) . '&error=Todos los campos son obligatorios');
    exit();
}

if ($password !== $confirm) {
    header('Location: reset.php?token=' . urlencode($token) . '&error=Las contraseñas no coinciden');
    exit();
}

if (strlen($password) < 6) {
    header('Location: reset.php?token=' . urlencode($token) . '&error=La contraseña debe tener mínimo 6 caracteres');
    exit();
}

if (!preg_match('/\d/', $password)) {
    header('Location: reset.php?token=' . urlencode($token) . '&error=La contraseña debe incluir al menos un número');
    exit();
}

if (!preg_match('/[A-Z]/', $password)) {
    header('Location: reset.php?token=' . urlencode($token) . '&error=La contraseña debe incluir al menos una letra mayúscula');
    exit();
}

// Hash
$hash = password_hash($password, PASSWORD_DEFAULT);

// Update
$stmt = $conexion->prepare("
    UPDATE usuarios 
    SET `contraseña` = ?, reset_token = NULL, token_expira = NULL
    WHERE reset_token = ?
");

$stmt->bind_param("ss", $hash, $token);

if($stmt->execute()){
    header("Location: http://localhost/SsitemaAgendagil/html/inicioSesion.php?success=Contrasena_actualizada");
exit();
}else{
    header("Location: reset.php?token=$token&error=Error al actualizar");
}
