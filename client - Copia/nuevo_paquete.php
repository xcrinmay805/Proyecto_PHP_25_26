<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$sql1 = "SELECT idcliente ,nombre FROM client;";
$sql2 = "SELECT v.idviaje ,c1.nombre AS origen, c2.nombre AS destino FROM trip v
    INNER JOIN city c1 ON v.idorigen = c1.idciudad  INNER JOIN city c2 ON v.iddestino = c2.idciudad;";

$resultado = mysqli_query($conexion, $sql1);
$resultado2 = mysqli_query($conexion, $sql2);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['txtNombre'];
    $descripcion= $_POST['txtDescripcion'];
    $precio = $_POST['txtPrecio'];
    $hotel = isset($_POST['chkHotel']) ? 1 : 0;
    $idcliente = $_POST['lstUsu'];
    $idviaje = $_POST['lstViaje'];

    
    $sql = "INSERT INTO package (nombrepaquete, descripcion, preciopaquete, incluyehotel, idviaje, contratacion, idcliente)
        VALUES ('$nombre', '$descripcion', '$precio', '$hotel', '$idviaje', NOW(), '$idcliente')";


    if (mysqli_query($conexion, $sql)) {
        echo "<div class='alert alert-success text-center'>✅ Paquete agregado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>❌ Error al agregar paquete: " . mysqli_error($conexion) . "</div>";
    }
}

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $options .= " <option value='" . $fila["idcliente"] . "'>" . $fila["nombre"] . "</option>";
}
$options2 = "";
while ($fila2 = mysqli_fetch_assoc($resultado2)) {
    $options2 .= " <option value='" . $fila2["idviaje"] . "'>" . $fila2["origen"] . "-" . $fila2["destino"]. "</option>";
}

include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="nuevo_paquete.php" name="frmNuevoPaquete" id="frmNuevoPaquete" method="post">
            <fieldset>
                <legend>Nuevo paquete</legend>

            
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del paquete" class="form-control input-md" maxlength="100" type="text" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtDescripcion">Descripción</label>
                    <div class="col-xs-4">
                        <input id="txtTelefono" name="txtDescripcion" placeholder="Información" class="form-control input-md" type="text" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtPrecio">Precio</label>
                    <div class="col-xs-4">
                        <input id="txtEmail" name="txtPrecio" placeholder="00.00" class="form-control input-md" type="number" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="chkHotel">Hotel incluido</label>
                    <div class="col-xs-4">
                        <input id="chkHotel" name="chkHotel" type="checkbox" value="1">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-xs-4 control-label" for="lstUsu">Cliente que reserva</label>
                    <div class="col-xs-4">
                        
                        <select name="lstUsu" id="lstUsu" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-xs-4 control-label" for="lstViaje">Viaje incluido</label>
                    <div class="col-xs-4">
                        
                        <select name="lstViaje" id="lstViaje" class="form-select" aria-label="Default select example">
                            <?php echo $options2; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnAceptarAltaCliente" name="btnAceptarAltaCliente" class="btn btn-primary" value="Guardar Paquete" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
