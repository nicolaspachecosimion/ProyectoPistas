<?php
// Nos unimos a la sesión activa para poder manipularla
session_start();

// Vaciamos todas las variables de sesión (borramos el id_usuario y el nombre)
session_unset();

// Quitamos la sesión por completo
session_destroy();

// Lo mandamos de vuelta al login
header("Location: login.php");
exit();
?>