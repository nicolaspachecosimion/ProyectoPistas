<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Comprobamos que nos llega el ID del torneo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_torneo'])) {
    
    $id_torneo = $_POST['id_torneo'];
    $id_usuario = $_SESSION['id_usuario'];

    // BORRADO SEGURO: Borramos de la tabla de inscripciones
    $sql_delete = "DELETE FROM inscripciones_torneos WHERE id_torneo = '$id_torneo' AND id_usuario = '$id_usuario'";

    if ($conexion->query($sql_delete) === TRUE) {
        // Éxito: devolvemos a torneos con el mensaje de cancelación
        header("Location: torneos.php?mensaje=cancelado_ok");
        exit();
    } else {
        echo "Error al cancelar la inscripción: " . $conexion->error;
    }
} else {
    // Si entran por URL sin pulsar botón
    header("Location: torneos.php");
    exit();
}

$conexion->close();
?>