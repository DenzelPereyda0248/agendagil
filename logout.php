<?php
session_start();
session_destroy();
header("Location: ../html/inicioSesion.php");
exit();
?>