<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombreAntiguo = trim($_POST['txtNombreAntiguo']);
    $nuevoNombre = trim($_POST['txtNuevoNombre']);
    $telefono = trim($_POST['txtTelefono']);
    $email = trim($_POST['txtEmail']);
    $activo = isset($_POST['chkActivo']) ? 1 : 0;

    
    if (empty($nombreAntiguo)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'> Debes introducir el nombre actual del cliente.</div>";
    } else {
        
        $sqlCheck = "SELECT * FROM client WHERE nombre = '$nombreAntiguo'";
        $resultado = mysqli_query($conexion, $sqlCheck);

        if (mysqli_num_rows($resultado) == 0) {
            $mensaje = "<div class='alert alert-warning text-center mt-3'> No se encontró ningún cliente con el nombre '$nombreAntiguo'.</div>";
        } else {
            
            $sqlUpdate = "
                UPDATE client
                SET 
                    nombre = '$nuevoNombre',
                    telefono = '$telefono',
                    email = '$email',
                    activo = $activo
                WHERE nombre = '$nombreAntiguo';
            ";

            if (mysqli_query($conexion, $sqlUpdate)) {
                $mensaje = "<div class='alert alert-success text-center mt-3'> Cliente actualizado correctamente.</div>";
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
    <h2 class="text-center mb-4">Modificar Cliente</h2>

    <form action="modificar_cliente.php" method="post" class="mx-auto" style="max-width: 600px;">
        
        <div class="form-group mb-3">
            <label for="txtNombreAntiguo">Nombre actual del cliente:</label>
            <input type="text" id="txtNombreAntiguo" name="txtNombreAntiguo"
                class="form-control" placeholder="Introduce el nombre actual del cliente" required>
        </div>

        <hr>

        
        <div class="form-group mb-3">
            <label for="txtNuevoNombre">Nuevo nombre:</label>
            <input type="text" id="txtNuevoNombre" name="txtNuevoNombre"
                class="form-control" placeholder="Nuevo nombre del cliente" required>
        </div>

        <div class="form-group mb-3">
            <label for="txtTelefono">Nuevo teléfono:</label>
            <input type="text" id="txtTelefono" name="txtTelefono"
                class="form-control" placeholder="Nuevo teléfono" required>
        </div>

        <div class="form-group mb-3">
            <label for="txtEmail">Nuevo correo electrónico:</label>
            <input type="email" id="txtEmail" name="txtEmail"
                class="form-control" placeholder="Nuevo correo electrónico" required>
        </div>

        <div class="form-group mb-4">
            <label for="chkActivo">¿Activo?</label>
            <input type="checkbox" id="chkActivo" name="chkActivo" value="1">
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Cliente</button>
        </div>
    </form>


    <?php echo $mensaje; ?>
</div>

</body>

</html>