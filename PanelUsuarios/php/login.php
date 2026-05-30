<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Administración</title>
    <link rel="stylesheet" href="../css/estilos.css?v=1">
    <link rel="stylesheet" href="../css/login.css?v=1">
</head>
<body class="login-body">

    <div class="login-container">
        <h2>Acceso Administrador</h2>
        <form action="validar_login.php" method="POST">
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="admin@miweb.com" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-principal">Iniciar Sesión</button>
        </form>
    </div>

</body>
</html>