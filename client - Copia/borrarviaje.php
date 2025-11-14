<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idviaje = trim($_POST['idviaje']);

    if (empty($idviaje)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Debes introducir el ID del viaje.</div>";
    } else {
        // Comprobar si el viaje existe
        $sqlCheck = "SELECT * FROM trip WHERE idviaje = '$idviaje'";
        $resultado = mysqli_query($conexion, $sqlCheck);

        if (!$resultado) {
            $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error en la consulta: " . mysqli_error($conexion) . "</div>";
        } elseif (mysqli_num_rows($resultado) == 0) {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>⚠️ No se encontró ningún viaje con ID '$idviaje'.</div>";
        } else {
            // Borrar viaje
            $sqlDelete = "DELETE FROM trip WHERE idviaje = '$idviaje' LIMIT 1";
            if (mysqli_query($conexion, $sqlDelete)) {
                $mensaje = "<div class='alert alert-success text-center mt-3'>✅ Viaje con ID '$idviaje' borrado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error al borrar viaje: " . mysqli_error($conexion) . "</div>";
            }
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Borrar Viaje</h2>

    <form action="borrarviaje.php" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="form-group mb-3">
            <label for="idviaje">ID del viaje:</label>
            <input type="number" id="idviaje" name="idviaje"
                class="form-control" placeholder="Introduce el ID del viaje a borrar" required>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Borrar Viaje</button>
        </div>
    </form>

    <?php echo $mensaje; ?>
</div>

</body>
</html>
