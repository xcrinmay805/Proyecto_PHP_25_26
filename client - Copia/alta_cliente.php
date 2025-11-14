<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$sql = "SELECT idcliente ,nombre FROM client;";

$resultado = mysqli_query($conexion, $sql);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['txtNombre'];
    $telefono = $_POST['txtTelefono'];
    $email = $_POST['txtEmail'];
    $activo = isset($_POST['chkActivo']) ? 1 : 0;

    
    $sql = "INSERT INTO client (nombre, telefono, email, activo, fecharegistro)
        VALUES ('$nombre', '$telefono', '$email', '$activo', NOW())";


    if (mysqli_query($conexion, $sql)) {
        echo "<div class='alert alert-success text-center'>✅ Cliente agregado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>❌ Error al agregar cliente: " . mysqli_error($conexion) . "</div>";
    }
}

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $options .= " <option value='" . $fila["idcliente"] . "'>" . $fila["nombre"] . "</option>";
}
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="alta_cliente.php" name="frmAltaCliente" id="frmAltaCliente" method="post">
            <fieldset>
                <legend>Alta de cliente</legend>

            
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del cliente" class="form-control input-md" maxlength="100" type="text" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtTelefono">Teléfono</label>
                    <div class="col-xs-4">
                        <input id="txtTelefono" name="txtTelefono" placeholder="Teléfono" class="form-control input-md" type="number" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtEmail">Email</label>
                    <div class="col-xs-4">
                        <input id="txtEmail" name="txtEmail" placeholder="Correo electrónico" class="form-control input-md" type="email" required>
                    </div>
                </div>

                
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="chkActivo"> ¿Eres Vip?</label>
                    <div class="col-xs-4">
                        <input id="chkActivo" name="chkActivo" type="checkbox" value="1">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-xs-4 control-label" for="lstUsu">Lista usuario</label>
                    <div class="col-xs-4">
                        
                        <select name="lstUsu" id="lstUsu" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                
                <div class="form-group">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnAceptarAltaCliente" name="btnAceptarAltaCliente" class="btn btn-primary" value="Guardar Cliente" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>
