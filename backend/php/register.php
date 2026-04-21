<?php
include("conexion.php");

//  Validar que existan datos
if(!isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['telefono'], $_POST['fechaNacimiento'])){
    header("Location: ../html/inicioSesion.php?error=Datos_incompletos");
    exit();
}

$nombre = trim($_POST['name']);
$correo = trim($_POST['email']);
$password = $_POST['password'];
$telefono = trim($_POST['telefono']);
$fechaNacimiento = $_POST['fechaNacimiento'];

if(empty($nombre) || empty($correo) || empty($password) || empty($telefono) || empty($fechaNacimiento)){
    header("Location: ../html/inicioSesion.php?error=campos_vacios");
    exit();
}

if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
    header("Location: ../html/inicioSesion.php?error=Correo_invalido");
    exit();
}


if(strlen($password) < 6){
    header("Location: ../html/inicioSesion.php?error=Contraseña_corta");
    exit();
}

$check = $conexion->prepare("SELECT idUsuario FROM usuarios WHERE correo = ?");
$check->bind_param("s", $correo);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    header("Location: ../html/inicioSesion.php?error=El_correo_ya_ha_sido_registrado");
    exit();
}

//  Obtener idRol de paciente
$rolQuery = $conexion->prepare("SELECT idRol FROM roles WHERE nombreRol = 'paciente'");
$rolQuery->execute();
$rolResult = $rolQuery->get_result();
$rol = $rolResult->fetch_assoc();
$idRol = $rol['idRol'];

//  Hash de contraseña
$hash = password_hash($password, PASSWORD_DEFAULT);

//  Insertar usuario
$stmt = $conexion->prepare("
    INSERT INTO usuarios (nombre, correo, `contraseña`, idRol)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("sssi", $nombre, $correo, $hash, $idRol);

if($stmt->execute()){
    $idUsuario = $conexion->insert_id;
    
    // Insertar en pacientes
    $stmt_paciente = $conexion->prepare("
        INSERT INTO pacientes (idUsuario, telefono, fechaNacimiento)
        VALUES (?, ?, ?)
    ");
    $stmt_paciente->bind_param("iss", $idUsuario, $telefono, $fechaNacimiento);
    
    if($stmt_paciente->execute()){
        header("Location: ../html/inicioSesion.php?success=Cuenta_creada_correctamente");
    } else {
        $conexion->query("DELETE FROM usuarios WHERE idUsuario = $idUsuario");
        header("Location: ../html/inicioSesion.php?error=Error_al_registrar_paciente");
    }
} else {
    header("Location: ../html/inicioSesion.php?error=Error_al_registrar");
}
?>
