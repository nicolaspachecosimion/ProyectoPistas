<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_torneo'])) {
    
    $id_torneo = $_POST['id_torneo'];
    $id_usuario = $_SESSION['id_usuario'];

    // Comprobamos si ya está inscrito
    $sql_check = "SELECT * FROM inscripciones_torneos WHERE id_torneo = '$id_torneo' AND id_usuario = '$id_usuario'";
    $resultado_check = $conexion->query($sql_check);

    if ($resultado_check->num_rows > 0) {
        // Ya está apuntado
        header("Location: torneos.php?mensaje=ya_inscrito");
        exit();
    } else {
        // Lo inscribimos
        $sql_insert = "INSERT INTO inscripciones_torneos (id_torneo, id_usuario) VALUES ('$id_torneo', '$id_usuario')";
        
        if ($conexion->query($sql_insert) === TRUE) {
            // Lo mandamos de vuelta a torneos
            header("Location: torneos.php?mensaje=inscrito_ok");
            exit();
        } else {
            echo "Error al inscribirse: " . $conexion->error;
        }
    }
} else {
    header("Location: torneos.php");
    exit();
}
$conexion->close();
?>