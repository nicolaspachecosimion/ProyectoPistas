<?php
$servidor = "localhost";
$usuario  = "root";
$password = "";
$base_datos = "pistas_san_isidro";

// Crear la conexión
$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

// Verificar si la conexión falló
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configurar caracteres a UTF-8
mysqli_set_charset($conexion, "utf8");
?>