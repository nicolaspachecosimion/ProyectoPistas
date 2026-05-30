<?php
// Localizamos la sesión actual del administrador
session_start(); 

// Borramos todas las variables guardadas (como el nombre y el rol)
session_unset(); 

// Destruimos la sesión para que nadie pueda volver atrás
session_destroy(); 

// Redirigimos específicamente al login de esta misma carpeta
header("Location: login.php");
exit();
?>