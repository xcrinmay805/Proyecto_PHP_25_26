<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

if (isset($_GET['btnBuscar'])) {
    $criterio = trim($_GET['txtCriterio'] ?? "");
    $preciomin = trim($_GET['txtPrecioMin'] ?? "");
    $preciomax = trim($_GET['txtPrecioMax'] ?? "");

    // Si no hay ningún criterio
    if (empty($criterio) && empty($preciomin) && empty($preciomax)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>Por favor, introduce al menos un criterio de búsqueda.</div>";
    } else {
        $criterioSQL = mysqli_real_escape_string($conexion, $criterio);
        $preciominSQL = is_numeric($preciomin) ? $preciomin : 0;
        $preciomaxSQL = is_numeric($preciomax) ? $preciomax : 999999;

        $sql = "SELECT t.idviaje, c1.nombre AS origen, c2.nombre AS destino, t.fechasalida, t.fecharegreso, t.duracion, t.preciobase, t.cocheHotel
                FROM trip t
                JOIN city c1 ON t.idorigen = c1.idciudad
                JOIN city c2 ON t.iddestino = c2.idciudad
                WHERE (c1.nombre LIKE '%$criterioSQL%' OR c2.nombre LIKE '%$criterioSQL%')
                AND t.preciobase BETWEEN '$preciominSQL' AND '$preciomaxSQL'
                ORDER BY t.idviaje ASC";

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            $mensaje .= "<h2 class='text-center mt-3'>Resultados de la búsqueda</h2>";
            $mensaje .= "<table class='table table-striped mt-4'>";
            $mensaje .= "<thead><tr>
                            <th>ID VIAJE</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th>FECHA SALIDA</th>
                            <th>FECHA REGRESO</th>
                            <th>DURACIÓN</th>
                            <th>PRECIO BASE</th>
                            <th>COCHE/HOTEL</th>
                        </tr></thead><tbody>";

            while ($fila = mysqli_fetch_assoc($resultado)) {
                $mensaje .= "<tr>";
                $mensaje .= "<td>" . $fila['idviaje'] . "</td>";
                $mensaje .= "<td>" . htmlspecialchars($fila['origen']) . "</td>";
                $mensaje .= "<td>" . htmlspecialchars($fila['destino']) . "</td>";
                $mensaje .= "<td>" . $fila['fechasalida'] . "</td>";
                $mensaje .= "<td>" . $fila['fecharegreso'] . "</td>";
                $mensaje .= "<td>" . $fila['duracion'] . "</td>";
                $mensaje .= "<td>" . number_format($fila['preciobase'],2) . "</td>";
                $mensaje .= "<td>" . ($fila['cocheHotel'] ? 'Sí' : 'No') . "</td>";
                $mensaje .= "</tr>";
            }

            $mensaje .= "</tbody></table>";
        } else {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>No se encontraron viajes con esos criterios.</div>";
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="listar_viajes_criterio.php" method="get">
            <fieldset>
                <legend>Listado de viajes según criterios</legend>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtCriterio">Ciudad (origen o destino)</label>
                    <div class="col-xs-4">
                        <input id="txtCriterio" name="txtCriterio" placeholder="Introduce ciudad" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtPrecioMin">Precio mínimo (€)</label>
                    <div class="col-xs-4">
                        <input id="txtPrecioMin" name="txtPrecioMin" placeholder="0" class="form-control input-md" type="number" step="0.01">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtPrecioMax">Precio máximo (€)</label>
                    <div class="col-xs-4">
                        <input id="txtPrecioMax" name="txtPrecioMax" placeholder="9999" class="form-control input-md" type="number" step="0.01">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-primary" value="Buscar" />
                    </div>
                </div>
            </fieldset>
        </form>

        <div class="col-12 mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</div>
</body>
</html>
