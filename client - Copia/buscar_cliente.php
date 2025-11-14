<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();


$mensaje = "";



if (isset($_GET['txtNombreCliente']) && !empty(trim($_GET['txtNombreCliente']))) {

    $nombre = trim($_GET['txtNombreCliente']);


    
    $sql = "SELECT idcliente, nombre, telefono, email, activo, fecharegistro 
            FROM client 
            WHERE nombre LIKE '%$nombre%' 
            ORDER BY idcliente ASC;";



    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
    

        $mensaje .= "<h2 class='text-center'>Resultados de la búsqueda</h2>";
        $mensaje .= "<table class='table table-striped mt-4'>";
        $mensaje .= "<thead><tr>
                        <th>IDCLIENTE</th>
                        <th>NOMBRE</th>
                        <th>TELÉFONO</th>
                        <th>EMAIL</th>
                        <th>ACTIVO</th>
                        <th>FECHA REGISTRO</th>
                    </tr></thead><tbody>";



        while ($fila = mysqli_fetch_assoc($resultado)) {
            $mensaje .= "<tr>";
            $mensaje .= "<td>" . $fila['idcliente'] . "</td>";
            $mensaje .= "<td>" . $fila['nombre'] . "</td>";
            $mensaje .= "<td>" . $fila['telefono'] . "</td>";
            $mensaje .= "<td>" . $fila['email'] . "</td>";
            $mensaje .= "<td>" . ($fila['activo'] ? 'Sí' : 'No') . "</td>";
            $mensaje .= "<td>" . $fila['fecharegistro'] . "</td>";
        



            $mensaje .= "</tr>";
        
        }

        $mensaje .= "</tbody></table>";
        


    } else {
    
        $mensaje = "<div class='alert alert-warning text-center mt-3'>  No se encontraron clientes con ese nombre.</div>";
    }
} elseif (isset($_GET['txtNombreCliente'])) {

    $mensaje = "<div class='alert alert-danger text-center mt-3'> Por favor, ingresa un nombre para buscar.</div>";
}


mysqli_close($conexion);

include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="buscar_cliente.php" name="frmBuscarCliente" id="frmBuscarCliente" method="get">
            <fieldset>
                <legend>Buscar un Cliente</legend>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombreCliente">Cliente</label>
                    <div class="col-xs-4">
                        <input id="txtNombreCliente" name="txtNombreCliente" placeholder="Nombre del Cliente" class="form-control input-md" type="text">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnAceptarBuscarCliente" name="btnAceptarBuscarCliente" class="btn btn-primary" value="Buscar" />
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
