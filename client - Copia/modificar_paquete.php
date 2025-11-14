<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

$sql1 = "SELECT idcliente ,nombre FROM client;";
$sql2 = "SELECT v.idviaje ,c1.nombre AS origen, c2.nombre AS destino FROM trip v
    INNER JOIN city c1 ON v.idorigen = c1.idciudad  INNER JOIN city c2 ON v.iddestino = c2.idciudad;";

$resultado = mysqli_query($conexion, $sql1);
$resultado2 = mysqli_query($conexion, $sql2);

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $options .= " <option value='" . $fila["idcliente"] . "'>" . $fila["nombre"] . "</option>";
}
$options2 = "";
while ($fila2 = mysqli_fetch_assoc($resultado2)) {
    $options2 .= " <option value='" . $fila2["idviaje"] . "'>" . $fila2["origen"] . "-" . $fila2["destino"]. "</option>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreAntiguo = trim($_POST['txtNombreAntiguo']);
    $nuevoNombre = trim($_POST['txtNuevoNombre']);
    $nuevaDescripcion = trim($_POST['txtDescripcion']);
    $nuevoPrecio = trim($_POST['txtPrecio']);
    $hotel = isset($_POST['chkHotel']) ? 1 : 0;
    $idcliente = $_POST['lstUsu'];
    $idviaje = $_POST['lstViaje'];

    
    if (empty($nombreAntiguo)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'> Debes introducir el nombre actual del paquete.</div>";
    } else {
        
        $sqlCheck = "SELECT * FROM package WHERE nombrepaquete = '$nombreAntiguo'";
        $resultado3 = mysqli_query($conexion, $sqlCheck);

        if (mysqli_num_rows($resultado3) == 0) {
            $mensaje = "<div class='alert alert-warning text-center mt-3'> No se encontró ningún paquete con el nombre '$nombreAntiguo'.</div>";
        } else {
            
            $sqlUpdate = "
                UPDATE package
                SET 
                    nombrepaquete = '$nuevoNombre',
                    descripcion = '$nuevaDescripcion',
                    preciopaquete = '$nuevoPrecio',
                    incluyehotel = $hotel,
                    idviaje = '$idviaje',
                    contratacion = NOW(),
                    idcliente = '$idcliente'
                WHERE nombrepaquete = '$nombreAntiguo';
            ";

            if (mysqli_query($conexion, $sqlUpdate)) {
                $mensaje = "<div class='alert alert-success text-center mt-3'> Paquete actualizado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger text-center mt-3'> Error al actualizar: " . mysqli_error($conexion) . "</div>";
            }
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Modificar Paquete</h2>

    <form action="modificar_paquete.php" method="post" class="mx-auto" style="max-width: 600px;">
        
        <div class="form-group mb-3">
            <label for="txtNombreAntiguo">Nombre actual del paquete:</label>
            <input type="text" id="txtNombreAntiguo" name="txtNombreAntiguo"
                class="form-control" placeholder="Introduce el nombre actual del paquete" required>
        </div>

        <hr>

        
        <div class="form-group mb-3">
            <label for="txtNuevoNombre">Nuevo nombre:</label>
            <input type="text" id="txtNuevoNombre" name="txtNuevoNombre"
                class="form-control" placeholder="Nuevo nombre del paquete" required>
        </div>

        <div class="form-group mb-3">
            <label for="txtTelefono">Nueva Descripción:</label>
            <input type="text" id="txtDescripcion" name="txtDescripcion"
                class="form-control" placeholder="Nueva descripcion" required>
        </div>

        <div class="form-group mb-3">
            <label for="txtEmail">Nuevo precio:</label>
            <input type="number" id="txtPrecio" name="txtPrecio"
                class="form-control" placeholder="00.00" required>
        </div>

        <div class="form-group mb-4">
            <label for="chkActivo">¿Incluye hotel?</label>
            <input type="checkbox" id="chkActivo" name="chkHotel" value="1">
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

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Paquete</button>
        </div>
    </form>


    <?php echo $mensaje; ?>
</div>

</body>

</html>