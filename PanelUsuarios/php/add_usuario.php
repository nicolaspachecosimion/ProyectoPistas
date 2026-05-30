<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Usuario - San Isidro</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/add_usuario.css">
</head>
<body class="add-user-body">

    <div class="form-container">
        <a href="panel.php" class="btn btn-secundario margin-bottom-20">← Volver al panel</a>
        <h2>Añadir Nuevo Usuario</h2>
        
        <form action="guardar_usuario.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="ejemplo@miweb.com" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Asigna una contraseña" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" placeholder="Ej: 600123456">
            </div>

            <div class="form-group">
                <label for="tipo_socio">Tipo de Socio</label>
                <select id="tipo_socio" name="tipo_socio" required>
                    <option value="Estandar">Estandar</option>
                    <option value="Premium">Premium</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rol">Rol del Sistema</label>
                <select id="rol" name="rol" required>
                    <option value="Usuario">Usuario</option>
                    <option value="Administrador">Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-add btn-formulario">Guardar Usuario</button>
        </form>
    </div>

</body>
</html>