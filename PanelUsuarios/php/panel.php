<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include('conexion.php');

$busqueda = isset($_GET['busqueda']) ? mysqli_real_escape_string($conexion, $_GET['busqueda']) : '';
$registros_por_pagina = 5; 
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) { $pagina_actual = 1; }

$filtro_sql = "";
if (!empty($busqueda)) {
    $filtro_sql = " WHERE nombre LIKE '%$busqueda%' OR email LIKE '%$busqueda%'";
}

$sql_total = "SELECT COUNT(*) AS total FROM usuarios" . $filtro_sql;
$resultado_total = mysqli_query($conexion, $sql_total);
$fila_total = mysqli_fetch_assoc($resultado_total);
$total_registros = $fila_total['total'];

$total_paginas = ceil($total_registros / $registros_por_pagina);

if ($pagina_actual > $total_paginas && $total_paginas > 0) {
    $pagina_actual = $total_paginas;
}

$inicio = ($pagina_actual - 1) * $registros_por_pagina;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios - San Isidro</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/panel.css">
</head>
<body class="panel-body">

    <div class="panel-container">
        <div class="panel-header">
            <h2>Panel de Usuarios (Hola, <?php echo $_SESSION['usuario']; ?>)</h2>
            <a href="add_usuario.php" class="btn btn-add">+ Añadir Nuevo Usuario</a>
        </div>

        <div class="buscador-container">
            <form action="panel.php" method="GET" class="form-busqueda">
                <input type="text" name="busqueda" placeholder="Buscar por nombre o email..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit" class="btn btn-principal btn-buscar">Buscar</button>
                <?php 
                    if(!empty($busqueda)) {
                        echo '<a href="panel.php" class="btn btn-secundario">Limpiar</a>';
                    }
                ?>
            </form>
        </div>

        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Tipo Socio</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $consulta = "SELECT * FROM usuarios" . $filtro_sql . " LIMIT $inicio, $registros_por_pagina";
                    $resultado = mysqli_query($conexion, $consulta);

                    if (mysqli_num_rows($resultado) > 0) {
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $fila['id_usuario'] . "</td>";
                            echo "<td>" . $fila['nombre'] . "</td>";
                            echo "<td>" . $fila['email'] . "</td>";
                            echo "<td>" . ($fila['telefono'] ? $fila['telefono'] : '-') . "</td>";
                            echo "<td>" . $fila['tipo_socio'] . "</td>";
                            
                            if($fila['rol'] == 'Administrador') {
                                echo "<td><strong class='texto-admin'>" . $fila['rol'] . "</strong></td>";
                            } else {
                                echo "<td>" . $fila['rol'] . "</td>";
                            }
                            
                            echo "<td class='acciones'>";
                            echo "<a href='modificar_usuario.php?id=" . $fila['id_usuario'] . "' class='btn btn-update'>Modificar</a>";
                            echo "<a href='eliminar_usuario.php?id=" . $fila['id_usuario'] . "' onclick=\"return confirm('¿Estás seguro de que quieres eliminar a este usuario?');\" class='btn btn-delete'>Eliminar</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='texto-centrado'>No se encontraron resultados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_paginas > 1): ?>
            <div class="paginacion">
                <?php if ($pagina_actual > 1): ?>
                    <a href="panel.php?pagina=<?php echo $pagina_actual - 1; ?>&busqueda=<?php echo $busqueda; ?>" class="btn btn-secundario">&laquo; Anterior</a>
                <?php endif; ?>

                <span class="info-paginacion">
                    Página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
                </span>

                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="panel.php?pagina=<?php echo $pagina_actual + 1; ?>&busqueda=<?php echo $busqueda; ?>" class="btn btn-secundario">Siguiente &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="contenedor-cerrar-sesion">
            <a href="cerrar_sesion.php" class="btn btn-cerrar_sesion">Cerrar Sesión</a>
        </div>
    </div>

</body>
</html>