<?php
include('conexion.php');
session_start();

$email = $_POST['correo']; 
$password = $_POST['password'];

$consulta = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    
    // Comprobar la columna rol y quitar los espacios con trim()
    if (trim($usuario['rol']) == 'Administrador') {
        $_SESSION['usuario'] = $usuario['nombre']; 
        header("Location: panel.php");
    } else {
        $rol_que_ha_leido = $usuario['rol'];
        echo "<script>alert('Acceso denegado. El sistema lee que tu rol es: [$rol_que_ha_leido]. Necesitas ser Administrador.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Correo o contraseña incorrectos.'); window.location.href='login.php';</script>";
}

mysqli_free_result($resultado);
mysqli_close($conexion);
?>