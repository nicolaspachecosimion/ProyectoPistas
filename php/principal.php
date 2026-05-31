<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    // Redirige al login
    header("Location: login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - Pistas San Isidro</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/principal.css">
</head>
<body>

    <?php include '../html/nav.html'; ?>

    <div class="hero-inicio">
        <div class="hero-texto">
            <h2>¡Hola, <?php echo $nombre_usuario; ?>!</h2>
            <h2>Vive el Deporte en San Isidro</h2>
            <p>Reserva tus pistas y compite con los mejores</p>
        </div>
    </div>

    <main class="contenido">
        <section class="seccion-deportes">
            <h1>Selecciona un Deporte</h1>
            <p>Elige la disciplina para consultar disponibilidad de pistas y horarios.</p>

            <div class="caja-deportes">
                
                <div class="tarjeta-deporte">
                    <div class="imagen-deporte">
                        <img src="../img/reserva-pista-futbol.jpg" alt="Fútbol San Isidro">
                    </div>
                    <div class="info-deporte">
                        <h3>Fútbol</h3>
                        <p>Campos de césped artificial de última generación</p>
                        <a href="futbol.php" class="btn-reservar">Ver Pistas</a>
                    </div>
                </div>

                <div class="tarjeta-deporte">
                    <div class="imagen-deporte">
                        <img src="../img/reserva-pista-padel.jpg" alt="Pádel San Isidro">
                    </div>
                    <div class="info-deporte">
                        <h3>Pádel</h3>
                        <p>Muro y Cristal de última generación</p>
                        <a href="padel.php" class="btn-reservar">Ver Pistas</a>
                    </div>
                </div>

                <div class="tarjeta-deporte">
                    <div class="imagen-deporte">
                        <img src="../img/reserva-pista-tenis.jpg" alt="Tenis San Isidro">
                    </div>
                    <div class="info-deporte">
                        <h3>Tenis</h3>
                        <p>Tierra batida y superficies rápidas</p>
                        <a href="tenis.php" class="btn-reservar">Ver Pistas</a>
                    </div>
                </div>

                <div class="tarjeta-deporte">
                    <div class="imagen-deporte">
                        <img src="../img/reserva-pista-baloncesto.jpg" alt="Baloncesto San Isidro">
                    </div>
                    <div class="info-deporte">
                        <h3>Baloncesto</h3>
                        <p>Pabellón cubierto y canastas exteriores</p>
                        <a href="baloncesto.php" class="btn-reservar">Ver Pistas</a>
                    </div>
                </div>

                <div class="tarjeta-deporte">
                    <div class="imagen-deporte">
                        <img src="../img/reserva-pista-natacion.jpg" alt="Natación San Isidro">
                    </div>
                    <div class="info-deporte">
                        <h3>Natación</h3>
                        <p>Piscina olímpica y clases dirigidas</p>
                        <a href="natacion.php" class="btn-reservar">Ver Pistas</a>
                    </div>
                </div>

            </div>
        </section>
        <section class="sobre-nosotros">
            <div class="texto-nosotros">
                <h2>Mucho más que pistas deportivas</h2>
                <p>En el Polideportivo San Isidro nos preocupamos por tu experiencia completa. Descubre todo lo que nuestras instalaciones tienen para ofrecerte antes y después de tu partido.</p>
            </div>

            <div class="grid-servicios">
                
                <div class="tarjeta-servicio">
                    <div class="foto-servicio-caja">
                        <img src="../img/vestuarios.jpg" alt="Vestuarios del Polideportivo San Isidro" class="foto-servicio">
                    </div>
                    <h3>Vestuarios Premium</h3>
                    <p>Taquillas individuales, duchas amplias con agua caliente y secadores a tu completa disposición.</p>
                </div>
                
                <div class="tarjeta-servicio">
                    <div class="foto-servicio-caja">
                        <img src="../img/cafeteria.jpg" alt="Cafetería y terraza del club" class="foto-servicio">
                    </div>
                    <h3>Cafetería y Terraza</h3>
                    <p>El mejor lugar para el tercer tiempo. Disfruta de nuestras tapas, menús y refrescos con vistas a las pistas.</p>
                </div>
                
                <div class="tarjeta-servicio">
                    <div class="foto-servicio-caja">
                        <img src="../img/parking.jpeg" alt="Parking gratuito exclusivo para socios" class="foto-servicio">
                    </div>
                    <h3>Parking Gratuito</h3>
                    <p>Amplio aparcamiento vigilado y exclusivo para socios y usuarios del club. Llegar y jugar, sin estrés.</p>
                </div>
                
            </div>
        </section>        
    </main>

    <?php include '../html/footer.html'; ?>

</body>
</html>