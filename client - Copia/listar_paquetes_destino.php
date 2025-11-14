<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

$sql2 = "SELECT idciudad, nombre FROM city;";
$resultado2 = mysqli_query($conexion, $sql2);

$options = " <option value=''>-- Seleccione --</option> ";
while ($fila = mysqli_fetch_assoc($resultado2)) {
    $options .= " <option value='" . $fila["idciudad"] . "'>" . $fila["nombre"] . "</option>";
}

if (isset($_GET['btnBuscar'])) {

    
    $nombre = trim($_GET['txtNombre'] ?? "");
    $origen = trim($_GET['lsOrigen'] ?? "");
    $destino = trim($_GET['lsDestino'] ?? "");
    $soloActivos = isset($_GET['chkHotel']) ? 1 : null;

    
    if (empty($nombre) && empty($origen) && empty($destino) && $soloActivos === null) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>Por favor, introduce al menos un criterio de búsqueda.</div>";
    } else {

        
        $sql = "SELECT p.idpaquete, p.nombrepaquete, p.descripcion, p.preciopaquete, p.incluyehotel, p.idviaje, p.contratacion, p.idcliente, t.idorigen, t.iddestino
                FROM package p INNER JOIN trip t ON p.idviaje = t.idviaje
                WHERE 1=1";

        if (!empty($nombre)) {
            $sql .= " AND p.nombrepaquete LIKE '%" . mysqli_real_escape_string($conexion, $nombre) . "%'";
        }
        if (!empty($origen)) {
            $sql .= " AND t.idorigen LIKE '%" . mysqli_real_escape_string($conexion, $origen) . "%'";
        }
        if (!empty($destino)) {
            $sql .= " AND t.iddestino LIKE '%" . mysqli_real_escape_string($conexion, $destino) . "%'";
        }
        if ($soloActivos !== null) {
            $sql .= " AND p.incluyehotel = 1";
        }

        $sql .= " ORDER BY p.idpaquete ASC;";

        
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            
            $mensaje .= "<h2 class='text-center'>Lista de Paquetes</h2>";
            $mensaje .= "<table class='table table-striped mt-4'>";
            $mensaje .= "<thead><tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCION</th>
                        <th>PRECIO</th>
                        <th>HOTEL INCLUIDO</th>
                        <th>ID VIAJE</th>
                        <th>CONTRATACION</th>
                        <th>ID CLIENTE</th>
                    </tr></thead><tbody>";

            while ($fila = mysqli_fetch_assoc($resultado)) {
                $mensaje .= "<tr>";
                $mensaje .= "<td>" . $fila['idpaquete'] . "</td>";
                $mensaje .= "<td>" . $fila['nombrepaquete'] . "</td>";
                $mensaje .= "<td>" . $fila['descripcion'] . "</td>";
                $mensaje .= "<td>" . $fila['preciopaquete'] . "</td>";
                $mensaje .= "<td>" . ($fila['incluyehotel'] ? 'Sí' : 'No') . "</td>";
                $mensaje .= "<td>" . $fila['idviaje'] . "</td>";
                $mensaje .= "<td>" . $fila['contratacion'] . "</td>";
                $mensaje .= "<td>" . $fila['idcliente'] . "</td>";
                

                $mensaje .= "</tr>";
            }

            $mensaje .= "</tbody></table>";

        } else {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>No se encontraron paquetes con esos criterios.</div>";
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="listar_paquetes_destino.php" name="frmBuscarPaquete" id="frmBuscarPaquete" method="get">
            <fieldset>
                <legend>Listado de paquetes por destino</legend>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre contiene:</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del Paquete" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="lsOrigen">Origen:</label>
                    <div class="col-xs-4">
                        
                        <select name="lsOrigen" id="lsOrigen" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="lsDestino">Destino:</label>
                    <div class="col-xs-4">
                        
                        <select name="lsDestino" id="lsDestino" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="col-xs-4">
                        <label><input type="checkbox" name="chkHotel" value="1"> Solo paquetes con hotel incluido</label>
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
