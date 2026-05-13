<?php
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];

    if ($password !== $confirmar_password) {
        $mensaje = "<p style='color: #e74c3c; text-align: center; margin-bottom: 15px; font-weight: bold;'>Las contraseñas no coinciden.</p>";
    } else {
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
        
        if ($conexion->query($sql) === TRUE) {
            $mensaje = "<p style='color: #2ecc71; text-align: center; margin-bottom: 15px; font-weight: bold;'>¡Registro exitoso! Ya puedes <a href='login.php'>iniciar sesión</a>.</p>";
        } else {
            $mensaje = "<p style='color: #e74c3c; text-align: center; margin-bottom: 15px; font-weight: bold;'>Error: " . $conexion->error . "</p>";
        }
    }
    $conexion->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Pistas Deportivas San Isidro</title>
    <link rel="stylesheet" href="../css/registro.css">
</head>
<body>

    <div class="caja-registro">
        <div class="caja-logo">
            <img src="../img/logo.png" alt="Logo Reserva Pista San Isidro" class="logo">
        </div>

        <h2>Crea tu Cuenta</h2>
        <p class="subtitulo">Únete al club y empieza a reservar tus pistas.</p>

        <?php echo $mensaje; ?>
        
        <form action="registro.php" method="POST">   

            <div class="inputs">
                <label for="nombre">Nombre Completo:</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ej: Juan Pérez">
            </div>

            <div class="inputs">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="tu@email.com">
            </div>

            <div class="inputs">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required placeholder="Crea una contraseña segura">
            </div>

            <div class="inputs">
                <label for="confirm_password">Repetir Contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password" required placeholder="Vuelve a escribir la contraseña">
            </div>

            <div class="checkbox-terminos">
                <input type="checkbox" id="terminos" name="terminos" required>
                <label for="terminos">He leído y acepto los <a href="#">Términos y Condiciones</a> del club.</label>
            </div>

            <button type="submit" class="btn-registro">Completar Registro</button>
            
            <div class="links">
                <p>¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión aquí</a></p>
            </div>
        </form>
    </div>

</body>
</html>