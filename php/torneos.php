<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';
$id_usuario = $_SESSION['id_usuario'];

// Obtener la lista de torneos a los que YA está apuntado este usuario
$sql_mis_torneos = "SELECT id_torneo FROM inscripciones_torneos WHERE id_usuario = '$id_usuario'";
$resultado_mis_torneos = $conexion->query($sql_mis_torneos);

$torneos_inscritos = [];
while($fila = $resultado_mis_torneos->fetch_assoc()) {
    $torneos_inscritos[] = $fila['id_torneo'];
}

// Obtener todos los torneos disponibles
$sql = "SELECT t.*, d.nombre AS nombre_deporte 
        FROM torneos t 
        INNER JOIN deportes d ON t.id_deporte = d.id_deporte 
        WHERE t.fecha_inicio >= CURDATE() 
        ORDER BY t.fecha_inicio ASC";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneos y Competiciones - San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/torneos.css">
</head>
<body>

    <div id="inicio-pagina"></div>
    
    <?php include '../html/nav.html'; ?> 

    <header class="hero-torneos">
        <div class="hero-contenido">
            <h1>🏆 Torneos y Competiciones</h1>
            <p>Demuestra tu nivel. Inscríbete en nuestros próximos campeonatos y compite por grandes premios.</p>
        </div>
    </header>

    <main class="contenido-principal">
        
        <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'inscrito_ok'): ?>
            <div class="alerta-exito">
                ¡Enhorabuena! Te has inscrito correctamente en el torneo.
            </div>
        <?php elseif(isset($_GET['mensaje']) && $_GET['mensaje'] == 'cancelado_ok'): ?>
            <div class="alerta-cancelado">
                Tu inscripción ha sido cancelada. Esperamos verte en el próximo torneo.
            </div>
        <?php endif; ?>

        <div class="grid-torneos">
            
            <?php if ($resultado->num_rows > 0): ?>
                <?php while($torneo = $resultado->fetch_assoc()): ?>
                    
                    <div class="tarjeta-torneo">
                        <div class="cabecera-tarjeta">
                            <h2><?php echo htmlspecialchars($torneo['nombre']); ?></h2>
                            <p class="deporte-tag"><?php echo htmlspecialchars($torneo['nombre_deporte']); ?></p>
                        </div>
                        
                        <div class="cuerpo-tarjeta">
                            <ul>
                                <li><strong>📅 Fechas:</strong> <?php echo date('d/m/Y', strtotime($torneo['fecha_inicio'])); ?> - <?php echo date('d/m/Y', strtotime($torneo['fecha_fin'])); ?></li>
                                <li><strong>⚙️ Formato:</strong> <?php echo htmlspecialchars($torneo['formato']); ?></li>
                                <li><strong>💶 Precio:</strong> <?php echo $torneo['precio']; ?> €</li>
                            </ul>
                        </div>
                        
                        <div class="pie-tarjeta">
                            <?php if (in_array($torneo['id_torneo'], $torneos_inscritos)): ?>
                                <button class="btn-inscrito" disabled>✅ Ya estás inscrito</button>
                                
                                <form action="cancelar_inscripcion.php" method="POST" class="formulario-cancelar">
                                    <input type="hidden" name="id_torneo" value="<?php echo $torneo['id_torneo']; ?>">
                                    <button type="submit" class="btn-cancelar-torneo">Cancelar Inscripción</button>
                                </form>

                            <?php else: ?>
                                <form action="inscripcion_pago.php" method="POST">
                                    <input type="hidden" name="id_torneo" value="<?php echo $torneo['id_torneo']; ?>">
                                    <button type="submit" class="btn-inscribir">Inscribirse Ahora</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endwhile; ?>
            <?php else: ?>
                
                <div class="mensaje-vacio">
                    <h3>No hay torneos programados actualmente.</h3>
                    <p>¡Vuelve a revisar en unos días!</p>
                </div>

            <?php endif; ?>

        </div>
    </main>

    <?php include '../html/footer.html'; ?>

</body>
</html>
<?php $conexion->close(); ?>