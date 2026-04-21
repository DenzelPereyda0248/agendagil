<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>AgendaÁgil - Login</title>
<link rel='stylesheet' type='text/css' media='screen' href='../css/login.css'>
<script src="../js/login.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container" id="container">

    <!-- REGISTRO -->
    <div class="form-container register">
        <p id="registerError" class="error"></p>
        <form action="../php/register.php" method="POST">
            <h2>Crear Cuenta</h2>
            <input type="text" name="name" placeholder="Nombre completo" required>
            <input type="email" name="email" placeholder="Correo" required>
            <input type="tel" name="telefono" placeholder="Teléfono" required>
            <input type="date" name="fechaNacimiento" placeholder="Fecha de nacimiento" required>

            <div class="password-container">
    <input type="password" name="password" placeholder="Contraseña" required pattern="(?=.*[A-Z])(?=.*\d).{6,}" title="Mínimo 6 caracteres, al menos una mayúscula y un número">
    <i class="fa-solid fa-eye toggle-password"></i>

<div><small class="password-hint">
    Mínimo 6 caracteres, una mayúscula y un número
</small>
</div>
</div>
            <button>Registrarse</button>
        </form>
    </div>

    <!-- LOGIN -->
    <div class="form-container login">
                <p id="errorMessage" class="error"></p>
                <p id="successMessage" class="success"></p>
        <form action="../php/login.php" method="POST">
            <h2>Iniciar Sesión</h2>
            <input type="email" name="email" placeholder="Correo" required>
            <div class="password-container">
    <input type="password" name="password" placeholder="Contraseña" required>
    <i class="fa-solid fa-eye toggle-password"></i>
</div>
            <a href="#" id="showRecover">¿Olvidaste tu contraseña?</a>
            <button>Iniciar Sesión</button>
        </form>
    </div>

    <!-- RECUPERAR -->
    <div class="form-container recover">
        <form action="../php/recovery.php" method="POST">
            <h2>Recuperar</h2>
            <input type="email" name="email" placeholder="Correo" required>
            <button>Enviar código</button>
        </form>
    </div>

    <div class="overlay">
        <div class="overlay-panel">
            <h2 id="panelTitle">¡Bienvenido!</h2>
            <p id="panelText">Inicia sesión para continuar</p>

            <button id="btnLogin">Iniciar Sesión</button>
            <button id="btnRegister">Registrarse</button>
            <button id="btnRecover">Recuperar</button>
        </div>
    </div>

</div>

</body>


</html>


