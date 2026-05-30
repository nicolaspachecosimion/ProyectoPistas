<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

$nombre     = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email      = mysqli_real_escape_string($conexion, $_POST['email']);
$password   = mysqli_real_escape_string($conexion, $_POST['password']);
$telefono   = mysqli_real_escape_string($conexion, $_POST['telefono']);
$tipo_socio = mysqli_real_escape_string($conexion, $_POST['tipo_socio']);
$rol        = mysqli_real_escape_string($conexion, $_POST['rol']);

$consulta = "INSERT INTO usuarios (nombre, email, password, telefono, tipo_socio, rol) 
             VALUES ('$nombre', '$email', '$password', '$telefono', '$tipo_socio', '$rol')";

if (mysqli_query($conexion, $consulta)) {
    header("Location: panel.php");
} else {
    echo "<script>alert('Error al guardar: El correo electrónico ya podría estar registrado.'); window.location.href='add_usuario.php';</script>";
}

mysqli_close($conexion);
?>