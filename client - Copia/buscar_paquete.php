<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();


$mensaje = "";



if (isset($_GET['txtNombre']) && !empty(trim($_GET['txtNombre']))) {
    $nombre = trim($_GET['txtNombre']);


    
   $sql = "SELECT idpaquete, nombrepaquete, descripcion, preciopaquete, incluyehotel, idviaje, contratacion, idcliente 
            FROM package WHERE nombrepaquete LIKE '%$nombre%'
            ORDER BY idpaquete ASC;";




    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
    

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
    
        $mensaje = "<div class='alert alert-warning text-center mt-3'>  No se encontraron paquetes con ese nombre.</div>";
    }
} elseif (isset($_GET['txtNombre'])) {

    $mensaje = "<div class='alert alert-danger text-center mt-3'> Por favor, ingresa un nombre para buscar.</div>";
}


mysqli_close($conexion);

include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="buscar_paquete.php" name="frmBuscarPaquete" id="frmBuscarPaquete" method="get">
            <fieldset>
                <legend>Buscar un Paquete</legend>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Paquete</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del Paquete" class="form-control input-md" type="text">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnAceptarBuscarPaquete" name="btnAceptarBuscarPaquete" class="btn btn-primary" value="Buscar" />
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