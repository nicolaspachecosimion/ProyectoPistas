<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

$id = mysqli_real_escape_string($conexion, $_POST['id_usuario']);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email = mysqli_real_escape_string($conexion, $_POST['email']);
$password = mysqli_real_escape_string($conexion, $_POST['password']);
$telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
$tipo_socio = mysqli_real_escape_string($conexion, $_POST['tipo_socio']);
$rol = mysqli_real_escape_string($conexion, $_POST['rol']);

if (empty($password)) {
    $consulta = "UPDATE usuarios SET nombre='$nombre', email='$email', telefono='$telefono', tipo_socio='$tipo_socio', rol='$rol' WHERE id_usuario='$id'";
} else {
    $consulta = "UPDATE usuarios SET nombre='$nombre', email='$email', password='$password', telefono='$telefono', tipo_socio='$tipo_socio', rol='$rol' WHERE id_usuario='$id'";
}

if (mysqli_query($conexion, $consulta)) {
    header("Location: panel.php");
} else {
    echo "<script>alert('Error al actualizar los datos.'); window.location.href='modificar_usuario.php?id=$id';</script>";
}

mysqli_close($conexion);
?>