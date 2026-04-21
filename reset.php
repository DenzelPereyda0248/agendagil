<?php
include("conexion.php");

$error = "";

if(!isset($_GET['token'])){
    $error = "Token no válido";
}else{

    $token = $_GET['token'];

    $stmt = $conexion->prepare("
        SELECT * FROM usuarios 
        WHERE reset_token = ? AND token_expira > NOW()
    ");

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 0){
        $error = "Token inválido o expirado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="../js/login.js" defer></script>
<title>Reset</title>
</head>
<body>

<div class="container">

    <div class="form-container login">
        <?php if(isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <form id="resetForm" action="update_password.php" method="POST">

            <h2>Nueva Contraseña</h2>

            <?php if($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8'); ?>">

<div class="password-container">
    <input id="password" type="password" name="password" placeholder="Nueva contraseña" required pattern="(?=.*[A-Z])(?=.*\d).{6,}" title="Mínimo 6 caracteres, al menos una mayúscula y un número">
    <i class="fa-solid fa-eye toggle-password"></i>
</div>

<div class="password-container">
    <input id="confirm" type="password" name="confirm" placeholder="Confirmar contraseña" required>
    <i class="fa-solid fa-eye toggle-password"></i>
</div>

            <button>Cambiar contraseña</button>

        </form>
    </div>

    <div class="overlay">
        <div class="overlay-panel">
            <h2>Seguridad</h2>
            <p>Actualiza tu contraseña de forma segura</p>
        </div>
    </div>

</div>

<script>
    const resetForm = document.getElementById('resetForm');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('confirm');

    function showResetError(message) {
        let errorElement = document.querySelector('#resetForm .error');
        if (!errorElement) {
            errorElement = document.createElement('p');
            errorElement.className = 'error';
            resetForm.insertBefore(errorElement, resetForm.firstChild);
        }
        errorElement.textContent = message;
    }

    function clearResetError() {
        const errorElement = document.querySelector('#resetForm .error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    function validateResetMatch() {
        const password = passwordInput.value.trim();
        const confirm = confirmInput.value.trim();

        if (password.length === 0 || confirm.length === 0) {
            clearResetError();
            return true;
        }

        if (password !== confirm) {
            showResetError('Las contraseñas no coinciden');
            return false;
        }

        clearResetError();
        return true;
    }

    passwordInput.addEventListener('input', validateResetMatch);
    confirmInput.addEventListener('input', validateResetMatch);

    resetForm.addEventListener('submit', function(event) {
        const password = passwordInput.value.trim();
        const confirm = confirmInput.value.trim();
        const validPattern = /^(?=.*[A-Z])(?=.*\d).{6,}$/;

        if (!validateResetMatch()) {
            event.preventDefault();
            return;
        }

        if (password !== confirm) {
            event.preventDefault();
            showResetError('Las contraseñas no coinciden');
            return;
        }

        if (!validPattern.test(password)) {
            event.preventDefault();
            showResetError('La contraseña debe tener mínimo 6 caracteres, incluir un número y una mayúscula');
            return;
        }
    });

    document.querySelectorAll('#resetForm .password-container').forEach(container => {
        const input = container.querySelector('input');
        const icon = container.querySelector('.toggle-password');

        if (!input || !icon) return;

        icon.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
</body>
</html>