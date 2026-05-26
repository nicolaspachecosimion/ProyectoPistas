<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
include 'conexion.php';

// Si llegamos aquí desde torneos.php con un POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_torneo'])) {
    $id_torneo = $_POST['id_torneo'];
    $id_usuario = $_SESSION['id_usuario'];

    // 1. Por seguridad: Comprobamos que no esté ya inscrito
    $sql_check = "SELECT * FROM inscripciones_torneos WHERE id_torneo = '$id_torneo' AND id_usuario = '$id_usuario'";
    $resultado_check = $conexion->query($sql_check);
    if ($resultado_check->num_rows > 0) {
        header("Location: torneos.php?mensaje=ya_inscrito");
        exit();
    }

    // 2. Sacamos los datos reales del torneo para mostrarlos en el resumen
    $sql_torneo = "SELECT t.*, d.nombre AS nombre_deporte 
                   FROM torneos t 
                   INNER JOIN deportes d ON t.id_deporte = d.id_deporte 
                   WHERE t.id_torneo = '$id_torneo'";
    $resultado_torneo = $conexion->query($sql_torneo);
    
    if($resultado_torneo->num_rows == 0){
        header("Location: torneos.php");
        exit();
    }
    $torneo = $resultado_torneo->fetch_assoc();

} else {
    // Si alguien entra escribiendo la URL sin haber hecho clic en un torneo
    header("Location: torneos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Inscripción - San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/pago.css"> </head>
<body>

    <?php include '../html/nav.html'; ?> 
    
    <header class="hero-pago">
        <div class="hero-contenido">
            <h1>Finalizar Inscripción</h1>
            <p>Completa tus datos y realiza el pago seguro para confirmar tu plaza.</p>
        </div>
    </header>

    <main class="contenido-principal contenedor-pago">
        <div class="grid-pago">
            
            <div class="tarjeta-resumen">
                <h3>Resumen del Torneo</h3>
                <h2><?php echo htmlspecialchars($torneo['nombre']); ?></h2>
                <p class="deporte-tag"><?php echo htmlspecialchars($torneo['nombre_deporte']); ?></p>
                
                <ul class="lista-resumen">
                    <li><span>Inicio:</span> <strong><?php echo date('d/m/Y', strtotime($torneo['fecha_inicio'])); ?></strong></li>
                    <li><span>Fin:</span> <strong><?php echo date('d/m/Y', strtotime($torneo['fecha_fin'])); ?></strong></li>
                    <li><span>Formato:</span> <strong><?php echo htmlspecialchars($torneo['formato']); ?></strong></li>
                </ul>
                
                <div class="total-pago">
                    <span>Total a Pagar:</span>
                    <span class="precio-final"><?php echo $torneo['precio']; ?> €</span>
                </div>
            </div>

            <div class="tarjeta-formulario">
                <h3>Datos de Inscripción</h3>
                
                <form action="procesar_inscripcion.php" method="POST" class="formulario-pago">
                    <input type="hidden" name="id_torneo" value="<?php echo $torneo['id_torneo']; ?>">
                    
                    <div class="grupo-input">
                        <label for="nombre_equipo">Nombre del Equipo o Pareja</label>
                        <input type="text" id="nombre_equipo" name="nombre_equipo" required placeholder="Ej: Los Galácticos">
                    </div>

                    <hr class="separador">
                    
                    <h4>💳 Tarjeta de Crédito / Débito (Pasarela Simulada)</h4>
                    
                    <div class="grupo-input">
                        <label for="titular">Titular de la tarjeta</label>
                        <input type="text" id="titular" required placeholder="Nombre completo">
                    </div>
                    
                    <div class="grupo-input">
                        <label for="numero_tarjeta">Número de la tarjeta</label>
                        <input type="text" id="numero_tarjeta" required placeholder="0000 0000 0000 0000" pattern="\d{16}" title="Debe contener 16 números seguidos">
                    </div>
                    
                    <div class="fila-input">
                        <div class="grupo-input">
                            <label for="caducidad">Caducidad (MM/AA)</label>
                            <input type="text" id="caducidad" required placeholder="12/28" pattern="\d{2}/\d{2}" title="Formato: MM/AA">
                        </div>
                        <div class="grupo-input">
                            <label for="cvv">CVV</label>
                            <input type="text" id="cvv" required placeholder="123" pattern="\d{3}" title="Tres números detrás de su tarjeta">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-pagar">Confirmar y Pagar</button>
                </form>
            </div>

        </div>
    </main>

    <?php include '../html/footer.html'; ?>

</body>
</html>