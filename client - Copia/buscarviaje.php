<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

// Si se envió el formulario
if (isset($_GET['txtCiudad']) && !empty(trim($_GET['txtCiudad']))) {
    $ciudad = trim($_GET['txtCiudad']);

    // Buscar viajes donde el origen o destino contenga el texto ingresado
    $sql = "SELECT t.idviaje, c1.nombre AS origen, c2.nombre AS destino, t.fechasalida, t.fecharegreso, t.duracion, t.preciobase, t.cocheHotel
            FROM trip t
            JOIN city c1 ON t.idorigen = c1.idciudad
            JOIN city c2 ON t.iddestino = c2.idciudad
            WHERE c1.nombre LIKE '%$ciudad%' OR c2.nombre LIKE '%$ciudad%'
            ORDER BY t.idviaje ASC";

    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $mensaje .= "<h2 class='text-center'>Resultados de la búsqueda</h2>";
        $mensaje .= "<table class='table table-striped mt-4'>";
        $mensaje .= "<thead><tr>
                        <th>ID</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Fecha Salida</th>
                        <th>Fecha Regreso</th>
                        <th>Duración</th>
                        <th>Precio Base (€)</th>
                        <th>Coche/Hotel</th>
                    </tr></thead><tbody>";

        while ($viaje = mysqli_fetch_assoc($resultado)) {
            $mensaje .= "<tr>";
            $mensaje .= "<td>" . $viaje['idviaje'] . "</td>";
            $mensaje .= "<td>" . $viaje['origen'] . "</td>";
            $mensaje .= "<td>" . $viaje['destino'] . "</td>";
            $mensaje .= "<td>" . $viaje['fechasalida'] . "</td>";
            $mensaje .= "<td>" . $viaje['fecharegreso'] . "</td>";
            $mensaje .= "<td>" . $viaje['duracion'] . "</td>";
            $mensaje .= "<td>" . number_format($viaje['preciobase'], 2) . "</td>";
            $mensaje .= "<td>" . ($viaje['cocheHotel'] ? 'Sí' : 'No') . "</td>";
            $mensaje .= "</tr>";
        }

        $mensaje .= "</tbody></table>";
    } else {
        $mensaje = "<div class='alert alert-warning text-center mt-3'>⚠️ No se encontraron viajes para esa ciudad.</div>";
    }
} elseif (isset($_GET['txtCiudad'])) {
    $mensaje = "<div class='alert alert-danger text-center mt-3'>Por favor, ingresa un nombre de ciudad para buscar.</div>";
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="buscarviaje.php" name="frmBuscarViaje" id="frmBuscarViaje" method="get">
            <fieldset>
                <legend>Buscar un Viaje</legend>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtCiudad">Ciudad (origen o destino)</label>
                    <div class="col-xs-4">
                        <input id="txtCiudad" name="txtCiudad" placeholder="Nombre de la ciudad" class="form-control input-md" type="text">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnAceptarBuscarViaje" name="btnAceptarBuscarViaje" class="btn btn-primary" value="Buscar" />
                    </div>
                </div>
            </fieldset>
        </form>

        <div class="col-12 mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</div>
