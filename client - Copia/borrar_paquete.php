<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['txtNombre']);

    
    if (empty($nombre)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Debes introducir el nombre del paquete.</div>";
    } else {
        
        $sqlCheck = "SELECT * FROM package WHERE nombrepaquete = '$nombre'";
        $resultado = mysqli_query($conexion, $sqlCheck);

        
        if (!$resultado) {
            $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error en la consulta: " . mysqli_error($conexion) . "</div>";
        } 
        
        elseif (mysqli_num_rows($resultado) == 0) {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>⚠️ No se encontró ningún paquete con el nombre '$nombre'.</div>";
        } 
        else {
            
            $sqlDelete = "DELETE FROM package WHERE nombrepaquete = '$nombre' LIMIT 1"; 

            
            if (mysqli_query($conexion, $sqlDelete)) {
                $mensaje = "<div class='alert alert-success text-center mt-3'>✅ Paquete '$nombre' borrado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error al borrar: " . mysqli_error($conexion) . "</div>";
            }
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>


<div class="container mt-4">
    <h2 class="text-center mb-4">Borrar Paquete</h2>

    <form action="borrar_paquete.php" method="post" class="mx-auto" style="max-width: 600px;">
        
        <div class="form-group mb-3">
            <label for="txtNombre">Nombre del Paquete:</label>
            <input type="text" id="txtNombre" name="txtNombre"
                class="form-control" placeholder="Introduce el nombre del paquete a borrar" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Borrar Paquete</button>
        </div>
    </form>

    <?php echo $mensaje; ?>
</div>

</body>

</html>