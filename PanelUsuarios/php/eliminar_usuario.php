<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);

    $consulta = "DELETE FROM usuarios WHERE id_usuario = '$id'";

    if (mysqli_query($conexion, $consulta)) {
        header("Location: panel.php");
    } else {
        echo "<script>alert('Error al eliminar el usuario: " . mysqli_error($conexion) . "'); window.location.href='panel.php';</script>";
    }
} else {
    header("Location: panel.php");
}

mysqli_close($conexion);
?>