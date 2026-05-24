<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Obtener las pistas de Pádel (id_deporte = 2)
$sql_pistas = "SELECT * FROM pistas WHERE id_deporte = 2";
$resultado_pistas = $conexion->query($sql_pistas);

$fecha_seleccionada = "";
$pista_seleccionada = "";
$horas_reservadas = [];

// Buscador de disponibilidad
if (isset($_GET['fecha']) && isset($_GET['pista'])) {
    $fecha_seleccionada = $_GET['fecha'];
    $pista_seleccionada = $_GET['pista'];
    
    $sql_reservas = "SELECT hora FROM reservas WHERE fecha = '$fecha_seleccionada' AND id_pista = '$pista_seleccionada'";
    $resultado_reservas = $conexion->query($sql_reservas);
    
    while ($fila = $resultado_reservas->fetch_assoc()) {
        $horas_reservadas[] = substr($fila['hora'], 0, 5);
    }
}

$horario_club = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Pádel - San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/padel.css">
</head>
<body>

    <?php include '../html/nav.html'; ?>

    <header class="hero-deporte-base hero-padel">
        <h1>Pistas de Pádel</h1>
        <p>Pistas de cristal panorámicas y de muro para tus partidos más intensos.</p>
    </header>

    <main class="contenido-deporte">
        
        <section class="reserva-futura" style="margin-top: 40px;">
            <h2>Buscador de Disponibilidad</h2>
            <p>Selecciona la pista y el día en el que quieres jugar.</p>
            
            <form action="padel.php" method="GET" class="formulario-fecha">
                <div class="grupo-form">
                    <label for="fecha">Día:</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fecha_seleccionada); ?>" required min="<?php echo date('Y-m-d'); ?>"> 
                </div>
                
                <div class="grupo-form">
                    <label for="pista">Pista:</label>
                    <select id="pista" name="pista" required>
                        <option value="">Selecciona una pista...</option>
                        <?php while($pista = $resultado_pistas->fetch_assoc()): ?>
                            <option value="<?php echo $pista['id_pista']; ?>" <?php if($pista_seleccionada == $pista['id_pista']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($pista['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn-buscar">Ver Horarios Libres</button>
            </form>
        </section>

        <?php if ($fecha_seleccionada != ""): ?>
        <section class="reserva-semana" style="margin-top: 40px;">
            <div class="cabecera-horas">
                <h2>Horarios para el <?php echo date('d-m-Y', strtotime($fecha_seleccionada)); ?></h2>
                <div class="leyenda">
                    <div class="leyenda-item"><span class="caja-color color-disponible"></span> Disponible</div>
                    <div class="leyenda-item"><span class="caja-color color-ocupado"></span> Completo</div>
                </div>
            </div>

            <div class="grid-horarios-limpio">
                <?php foreach ($horario_club as $hora): ?>
                    <?php if (in_array($hora, $horas_reservadas)): ?>
                        <div class="tarjeta-hora ocupada">
                            <span class="texto-hora"><?php echo $hora; ?></span>
                            <span class="texto-estado">No disponible</span>
                        </div>
                    <?php else: ?>
                        <form action="procesar_reserva.php" method="POST" class="tarjeta-hora libre">
                            <input type="hidden" name="fecha" value="<?php echo $fecha_seleccionada; ?>">
                            <input type="hidden" name="id_pista" value="<?php echo $pista_seleccionada; ?>">
                            <input type="hidden" name="hora" value="<?php echo $hora; ?>">
                            <span class="texto-hora"><?php echo $hora; ?></span>
                            <button type="submit" class="btn-hora-reservar">Reservar</button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php include '../html/footer.html'; ?>

</body>
</html>