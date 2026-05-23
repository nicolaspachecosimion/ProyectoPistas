<?php
include 'conexion.php';
$mensaje = "";
$paso = 1; // Esta variable controla qué pantalla mostramos (1 = pedir email, 2 = pedir contraseña, 3 = éxito)
$email_validado = "";

// Si se ha enviado algún formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // CASO A: El usuario acaba de enviar el Email
    if (isset($_POST['btn_verificar'])) {
        $email = $_POST['email'];

        // Comprobamos si el correo existe
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            $paso = 2; // Pasamos a la pantalla de cambiar contraseña
            $email_validado = $email; // Guardamos el email para saber a quién cambiarle la clave
        } else {
            $mensaje = "<p style='color: #e74c3c; font-weight: bold; margin-bottom: 15px;'>No hemos encontrado ninguna cuenta con ese correo.</p>";
        }
    } 
    // El usuario acaba de enviar la Nueva Contraseña
    elseif (isset($_POST['btn_cambiar'])) {
        $email_oculto = $_POST['email_oculto'];
        $nueva_password = $_POST['nueva_password'];

        // Actualizamos la contraseña en la base de datos
        $sql_update = "UPDATE usuarios SET password = '$nueva_password' WHERE email = '$email_oculto'";
        
        if ($conexion->query($sql_update) === TRUE) {
            $paso = 3; // Pasamos a la pantalla de éxito
        } else {
            $mensaje = "<p style='color: #e74c3c; font-weight: bold; margin-bottom: 15px;'>Error al cambiar la contraseña.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - San Isidro</title>
    <link rel="stylesheet" href="../css/recuperar.css">
</head>
<body>

    <div class="caja-recuperar">
        <div class="caja-logo">
            <img src="../img/logo.png" alt="Logo Reserva Pista San Isidro" class="logo">
        </div>

        <h2>Recuperar Contraseña</h2>
        
        <?php echo $mensaje; ?>

        <?php if ($paso == 1): ?>
            <p class="subtitulo">Introduce tu email para verificar tu cuenta.</p>
            <form action="recuperar.php" method="POST">
                <div class="inputs">
                    <label for="email">Email registrado:</label>
                    <input type="email" id="email" name="email" required placeholder="tu@email.com">
                </div>
                <button type="submit" name="btn_verificar" class="btn-recuperar">Comprobar Correo</button>
                
                <div class="links">
                    <p>¿Recordaste tu contraseña? <a href="login.php">Vuelve al Login</a></p>
                </div>
            </form>
        <?php endif; ?>


        <?php if ($paso == 2): ?>
            <p class="subtitulo" style="color: #2ecc71; font-weight: bold;">¡Cuenta encontrada!</p>
            <form action="recuperar.php" method="POST">
                
                <input type="hidden" name="email_oculto" value="<?php echo $email_validado; ?>">

                <div class="inputs">
                    <label for="nueva_password">Introduzca su nueva contraseña:</label>
                    <input type="password" id="nueva_password" name="nueva_password" required placeholder="Nueva contraseña segura">
                </div>
                <button type="submit" name="btn_cambiar" class="btn-recuperar">Guardar y Cambiar</button>
            </form>
        <?php endif; ?>


        <?php if ($paso == 3): ?>
            <div style="padding: 20px 0;">
                <h3 style="color: #2ecc71; margin-bottom: 15px;">✅ ¡Contraseña actualizada!</h3>
                <p style="margin-bottom: 25px;">Ya puedes entrar a tu cuenta con tu nueva clave.</p>
                <a href="login.php" class="btn-recuperar" style="text-decoration: none; display: inline-block; padding: 12px 20px;">Ir a Iniciar Sesión</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>