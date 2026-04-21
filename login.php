<?php
session_start();
include("conexion.php");

$correo = $_POST['email'];
$password = $_POST['password'];

// Buscar usuario
$stmt = $conexion->prepare("
    SELECT u.idUsuario, u.nombre, u.correo, u.`contraseña`, r.nombreRol 
    FROM usuarios u
    INNER JOIN roles r ON u.idRol = r.idRol
    WHERE u.correo = ?
");

$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){

    $user = $result->fetch_assoc();

    // Verificar contraseña
    if(password_verify($password, $user['contraseña'])){

        // Guardar sesión
        $_SESSION['idUsuario'] = $user['idUsuario'];
        $_SESSION['nombre'] = $user['nombre'];
        $_SESSION['rol'] = $user['nombreRol'];

        // Redirección por rol
        switch($user['nombreRol']){
            case 'admin':
                header("Location: ../html/admin.php");
                break;

            case 'dentista':
                header("Location: ../html/dentista.php");
                break;

            case 'recepcionista':
                header("Location: ../html/recepcion.php");
                break;

            case 'paciente':
                header("Location: ../html/paciente.php");
                break;

            default:
                echo "Rol no válido";
        }

    }else{
    header("Location: ../html/inicioSesion.php?error=Contraseña_incorrecta");
    exit();
    }

}else{
    header("Location: ../html/inicioSesion.php?error=usuario_no encontrado");
    exit();
}
?>