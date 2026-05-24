<?php
// 1. Proteger la página con la sesión
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
$id_usuario = $_SESSION['id_usuario'];

// 2. Consulta avanzada con JOIN para traer los nombres del deporte y de la pista
$sql = "SELECT r.id_reserva, r.fecha, r.hora, r.estado, p.nombre AS pista_nombre, d.nombre AS deporte_nombre 
        FROM reservas r
        INNER JOIN pistas p ON r.id_pista = p.id_pista
        INNER JOIN deportes d ON p.id_deporte = d.id_deporte
        WHERE r.id_usuario = '$id_usuario'
        ORDER BY r.fecha ASC, r.hora ASC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas - Pistas San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/mis-reservas.css?v=2">
</head>
<body>

    <?php include '../html/nav.html'; ?>

    <main class="contenido-reservas">
        <div class="cabecera-reservas">
            <h1>Mis Reservas</h1>
            <p>Gestiona tus próximas pistas y revisa tu historial.</p>
        </div>

        <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'borrado'): ?>
            <div class="alerta-borrado">
                La reserva ha sido cancelada correctamente y la pista vuelve a estar libre.
            </div>
        <?php endif; ?>

        <div class="panel-reservas">
            
            <?php if ($resultado->num_rows > 0): ?>
                
                <?php while ($reserva = $resultado->fetch_assoc()): ?>
                    
                    <div class="tarjeta-reserva activa">
                        <div class="estado-reserva"><?php echo htmlspecialchars($reserva['estado']); ?></div>
                        
                        <div class="datos-reserva">
                            <div class="dato">
                                <span class="icono"></span>
                                <div>
                                    <strong>Deporte</strong>
                                    <p><?php echo htmlspecialchars($reserva['deporte_nombre']); ?></p>
                                </div>
                            </div>
                            <div class="dato">
                                <span class="icono"></span>
                                <div>
                                    <strong>Fecha</strong>
                                    <p><?php echo date('d-m-Y', strtotime($reserva['fecha'])); ?></p>
                                </div>
                            </div>
                            <div class="dato">
                                <span class="icono"></span>
                                <div>
                                    <strong>Hora</strong>
                                    <p><?php echo substr($reserva['hora'], 0, 5); ?> hs</p>
                                </div>
                            </div>
                            <div class="dato">
                                <span class="icono"></span>
                                <div>
                                    <strong>Pista</strong>
                                    <p><?php echo htmlspecialchars($reserva['pista_nombre']); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="acciones-reserva">
                            <form action="cancelar_reserva.php" method="POST">
                                <input type="hidden" name="id_reserva" value="<?php echo $reserva['id_reserva']; ?>">
                                <button type="submit" class="btn-secundario">Cancelar Reserva</button>
                            </form>
                        </div>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                
                <div class="mensaje-no-reservas" style="text-align: center; padding: 40px; color: #666;">
                    <p style="font-size: 18px; font-weight: bold;">No tienes ninguna pista reservada actualmente.</p>
                    <p style="margin-top: 10px;">¡Anímate a reservar tu primera pista desde el panel de inicio!</p>
                </div>

            <?php endif; ?>

        </div>
    </main>

    <?php include '../html/footer.html'; ?>

</body>
</html>
<?php $conexion->close(); ?>