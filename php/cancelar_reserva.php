<?php
session_start();
// Si no está logueado, lo echamos
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

// Comprobamos que llegamos aquí pulsando el botón rojo y nos trae un ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_reserva'])) {
    
    $id_reserva = $_POST['id_reserva'];
    $id_usuario = $_SESSION['id_usuario']; // El usuario que ha iniciado sesión

    // BORRADO SEGURO: Borramos la reserva SOLO si pertenece a este usuario
    $sql_delete = "DELETE FROM reservas WHERE id_reserva = '$id_reserva' AND id_usuario = '$id_usuario'";

    if ($conexion->query($sql_delete) === TRUE) {
        // Si se borra con éxito, lo devolvemos a la página de reservas
        // Le pasamos un aviso por la URL (?mensaje=borrado) por si luego quieres mostrar un mensajito verde
        header("Location: mis-reservas.php?mensaje=borrado");
        exit();
    } else {
        echo "Error al cancelar la reserva: " . $conexion->error;
    }
} else {
    // Si alguien intenta entrar a la URL directamente sin pulsar el botón
    header("Location: mis-reservas.php");
    exit();
}

$conexion->close();
?>