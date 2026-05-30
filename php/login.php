<?php
session_start();

include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recoger los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar si existe un usuario con ese email y esa contraseña
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
    $resultado = $conexion->query($sql);

    // num_rows cuenta cuántos resultados nos ha devuelto la base de datos
    // Si devuelve 1, significa que encontró al usuario y los datos son correctos
    if ($resultado->num_rows == 1) {
        
        // Sacamos los datos de ese usuario de la base de datos
        $usuario = $resultado->fetch_assoc();
        
        // Guardamos sus datos
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        
        // Lo redirigimos a la página principal
        header("Location: principal.php"); 
        exit(); 
        
    } else {
        // Si no devuelve 1, o el correo no existe o la contraseña está mal
        $mensaje = "<p style='color: #e74c3c; text-align: center; margin-bottom: 15px; font-weight: bold;'>Correo o contraseña incorrectos.</p>";
    }
    
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pistas Deportivas San Isidro</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>

    <div class="caja-login">
        <div class="caja-logo">
            <img src="../img/logo.png" alt="Logo Reserva Pista San Isidro" class="logo">
        </div>

        <h2>Acceso a Pistas Deportivas</h2>

        <?php echo $mensaje; ?>
        
        <form action="login.php" method="POST">
            <div class="inputs">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Ingrese su email">
            </div>

            <div class="inputs">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">
            </div>

            <button type="submit" class="btn-sesion">Iniciar Sesión</button>
            
            <div class="links">
                <a href="recuperar.php">¿Olvidaste tu contraseña?</a>
                <span class="separator">|</span>
                <a href="registro.php">Regístrate aquí</a>
            </div>
        </form>
    </div>

</body>
</html>
