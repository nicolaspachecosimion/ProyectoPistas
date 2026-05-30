<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $consulta = "SELECT * FROM usuarios WHERE id_usuario = '$id'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
    } else {
        header("Location: panel.php");
        exit();
    }
} else {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario - San Isidro</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/modificar.css"> 
</head>
<body class="edit-user-body">

    <div class="form-container">
        <a href="panel.php" class="btn btn-secundario margin-bottom-20">← Volver al panel</a>
        <h2>Modificar Usuario</h2>
        
        <form action="actualizar_usuario.php" method="POST">
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">

            <div class="form-group">
                <label for="id_visible">ID de Usuario</label>
                <input type="text" id="id_visible" value="<?php echo $usuario['id_usuario']; ?>" disabled>
            </div>

            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Dejar en blanco para mantener la actual">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
            </div>

            <div class="form-group">
                <label for="tipo_socio">Tipo de Socio</label>
                <select id="tipo_socio" name="tipo_socio" required>
                    <option value="Estandar" <?php if($usuario['tipo_socio'] == 'Estandar') echo 'selected'; ?>>Estandar</option>
                    <option value="Premium" <?php if($usuario['tipo_socio'] == 'Premium') echo 'selected'; ?>>Premium</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rol">Rol del Usuario</label>
                <select id="rol" name="rol" required>
                    <option value="Usuario" <?php if($usuario['rol'] == 'Usuario') echo 'selected'; ?>>Usuario</option>
                    <option value="Administrador" <?php if($usuario['rol'] == 'Administrador') echo 'selected'; ?>>Administrador</option>
                </select>
            </div>

            <button type="submit" class="btn btn-update btn-formulario">Actualizar Datos</button>
        </form>
    </div>

</body>
</html>