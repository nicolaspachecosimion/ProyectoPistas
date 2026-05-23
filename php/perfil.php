<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
$id_usuario = $_SESSION['id_usuario'];
$mensaje = "";

// 1. Guardar cambios en la Base de Datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $deporte_fav = $_POST['deporte_fav'];

    $sql_update = "UPDATE usuarios SET 
                    nombre = '$nombre', 
                    telefono = '$telefono', 
                    deporte_fav = '$deporte_fav'
                  WHERE id_usuario = '$id_usuario'";

    if ($conexion->query($sql_update) === TRUE) {
        // Usamos solo clases CSS, nada de estilos en línea
        $mensaje = "<div class='mensaje-alerta exito'>¡Perfil actualizado con éxito!</div>";
        $_SESSION['nombre'] = $nombre;
    } else {
        $mensaje = "<div class='mensaje-alerta error'>Error: " . $conexion->error . "</div>";
    }
}

// 2. Extraer datos del usuario actual
$sql_usuario = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
$resultado = $conexion->query($sql_usuario);
$datos_user = $resultado->fetch_assoc();

// 3. Extraer estadísticas reales (Preparado para cuando creemos las tablas)
// Por ahora las forzamos a 0 para que no dé error la consulta
$total_reservas = 0; 
/* Futura consulta: 
$sql_res = "SELECT COUNT(*) as total FROM reservas WHERE id_usuario = '$id_usuario'";
... */

$total_torneos = 0;
/* Futura consulta: 
$sql_tor = "SELECT COUNT(*) as total FROM torneos_inscripciones WHERE id_usuario = '$id_usuario'";
... */

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>

    <div id="inicio-pagina"></div>
    
    <nav class="caja-nav"> 
        <div class="nav-logo">
            <a href="principal.php">
                <img src="../img/logo.png" alt="Logo San Isidro" class="logo-nav">
            </a>
        </div>
        <ul class="nav-links">
            <li><a href="principal.php">Inicio</a></li> 
            <li><a href="../html/mis-reservas.html">Mis Reservas</a></li>
            <li><a href="../html/torneos.html">Torneos</a></li>
            <li><a href="perfil.php" class="activo">Perfil</a></li>
            <li><a href="logout.php" class="btn-salir">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <main class="contenido-perfil">
        
        <div class="cabecera-perfil">
            <h1>Mi Perfil</h1>
            <p>Gestiona tus datos personales y preferencias de la cuenta.</p>
        </div>

        <div class="grid-perfil">
            
            <aside class="tarjeta-usuario">
                <div class="avatar-caja">
                    <img src="../img/avatar-defecto.png" alt="Foto de perfil" class="avatar">
                    <button class="btn-cambiar-foto">Cambiar Foto</button>
                </div>
                
                <div class="info-usuario-resumen">
                    <h3><?php echo htmlspecialchars($datos_user['nombre']); ?></h3>
                    <p class="tipo-socio">Socio <?php echo htmlspecialchars($datos_user['tipo_socio']); ?></p>
                    
                    <ul class="estadisticas">
                        <li><strong><?php echo $total_reservas; ?></strong> Reservas hechas</li>
                        <li><strong><?php echo $total_torneos; ?></strong> Torneos jugados</li>
                    </ul>
                </div>
            </aside>

            <section class="formularios-perfil">
                
                <div class="caja-formulario">
                    <h2>Datos Personales</h2>
                    
                    <?php echo $mensaje; ?>

                    <form action="perfil.php" method="POST" class="form-editar">
                        <div class="grupo-input">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($datos_user['nombre']); ?>" required>
                        </div>
                        
                        <div class="grupo-input">
                            <label for="email">Correo Electrónico (No modificable)</label>
                            <input type="email" id="email" value="<?php echo htmlspecialchars($datos_user['email']); ?>" disabled>
                        </div>

                        <div class="grupo-input">
                            <label for="telefono">Teléfono</label>
                            <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($datos_user['telefono']); ?>">
                        </div>

                        <div class="grupo-input">
                            <label for="deporte-fav">Deporte Favorito</label>
                            <select id="deporte-fav" name="deporte_fav">
                                <option value="padel" <?php if($datos_user['deporte_fav'] == 'padel') echo 'selected'; ?>>Pádel</option>
                                <option value="futbol" <?php if($datos_user['deporte_fav'] == 'futbol') echo 'selected'; ?>>Fútbol</option>
                                <option value="tenis" <?php if($datos_user['deporte_fav'] == 'tenis') echo 'selected'; ?>>Tenis</option>
                                <option value="natacion" <?php if($datos_user['deporte_fav'] == 'natacion') echo 'selected'; ?>>Natación</option>
                                <option value="baloncesto" <?php if($datos_user['deporte_fav'] == 'baloncesto') echo 'selected'; ?>>Baloncesto</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-guardar">Guardar Cambios</button>
                    </form>
                </div>

                <div class="caja-formulario form-seguridad">
                    <h2>Seguridad</h2>
                    <form action="#" class="form-editar">
                        <div class="grupo-input">
                            <label for="pass-actual">Contraseña Actual</label>
                            <input type="password" id="pass-actual" placeholder="Ingresa tu contraseña actual">
                        </div>
                        
                        <div class="grupo-input">
                            <label for="pass-nueva">Nueva Contraseña</label>
                            <input type="password" id="pass-nueva" placeholder="Escribe tu nueva contraseña">
                        </div>

                        <button type="button" class="btn-guardar btn-secundario">Actualizar Contraseña</button>
                    </form>
                </div>

            </section>

        </div>

    </main>

    <footer class="pie-pagina">
        <div class="caja-footer">
            <div class="columna-footer">
                <a href="principal.php">
                    <img src="../img/logo.png" alt="Logo San Isidro" class="logo-footer">
                </a>
                <p>El mejor club deportivo para disfrutar, competir y mejorar tu nivel en instalaciones de primera calidad.</p>
            </div>
            <div class="columna-footer">
                <h4>Enlaces Rápidos</h4>
                <ul>
                    <li><a href="principal.php">Inicio</a></li>
                    <li><a href="../html/mis-reservas.html">Mis Reservas</a></li>
                    <li><a href="../html/torneos.html">Torneos</a></li>
                    <li><a href="perfil.php">Perfil</a></li>
                </ul>
            </div>
            <div class="columna-footer">
                <h4>Contacto</h4>
                <p>📍 Calle Rda. Palmeras, 123</p>
                <p>📞 600 123 456</p>
                <p>✉️ info@sanisidro.com</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2026 Pistas Deportivas San Isidro. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>
</html>