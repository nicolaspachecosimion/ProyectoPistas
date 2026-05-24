<?php
session_start();
// Si no está logueado, fuera de aquí
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

// Comprobamos que nos llegan los datos obligatorios de la reserva
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_pista']) && isset($_POST['fecha']) && isset($_POST['hora'])) {
    
    $id_usuario = $_SESSION['id_usuario'];
    $id_pista = $_POST['id_pista'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    
    // Insertamos la reserva en la base de datos (por defecto el estado será 'Confirmada')
    $sql_insert = "INSERT INTO reservas (id_usuario, id_pista, fecha, hora) 
                   VALUES ('$id_usuario', '$id_pista', '$fecha', '$hora')";
                   
    if ($conexion->query($sql_insert) === TRUE) {
        // Redirigimos a la pantalla de éxito que tenías en HTML
        header("Location: ../html/pista-reservada.html");
        exit();
    } else {
        // Si hay un error (por ejemplo, por la restricción UNIQUE que evita duplicados)
        echo "Error al procesar la reserva o la pista ya ha sido ocupada en este instante: " . $conexion->error;
    }
} else {
    // Si intentan entrar a este archivo de forma directa sin enviar el formulario
    header("Location: principal.php");
    exit();
}

$conexion->close();
?>