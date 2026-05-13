<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$base_datos = "pistas_san_isidro";

$conexion = new mysqli($servidor, $usuario, $password, $base_datos);

// Comprobar si hay algún error
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>