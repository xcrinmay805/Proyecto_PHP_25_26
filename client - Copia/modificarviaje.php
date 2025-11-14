<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idviaje = trim($_POST['idviaje']);
    $idorigen = $_POST['idorigen'];
    $iddestino = $_POST['iddestino'];
    $fechasalida = $_POST['fechasalida'];
    $fecharegreso = $_POST['fecharegreso'];
    $duracion = $_POST['duracion'];
    $preciobase = $_POST['preciobase'];
    $cocheHotel = isset($_POST['cocheHotel']) ? 1 : 0;

    if (empty($idviaje)) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Debes introducir el ID del viaje a modificar.</div>";
    } else {
        // Comprobar si existe el viaje
        $sqlCheck = "SELECT * FROM trip WHERE idviaje = '$idviaje'";
        $resultado = mysqli_query($conexion, $sqlCheck);

        if (mysqli_num_rows($resultado) == 0) {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>⚠️ No se encontró ningún viaje con ID '$idviaje'.</div>";
        } else {
            // Actualizar el viaje
            $sqlUpdate = "
                UPDATE trip
                SET 
                    idorigen = '$idorigen',
                    iddestino = '$iddestino',
                    fechasalida = '$fechasalida',
                    fecharegreso = '$fecharegreso',
                    duracion = '$duracion',
                    preciobase = '$preciobase',
                    cocheHotel = '$cocheHotel'
                WHERE idviaje = '$idviaje';
            ";

            if (mysqli_query($conexion, $sqlUpdate)) {
                $mensaje = "<div class='alert alert-success text-center mt-3'>✅ Viaje actualizado correctamente.</div>";
            } else {
                $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error al actualizar: " . mysqli_error($conexion) . "</div>";
            }
        }
    }
}

// Traer ciudades para los select de origen y destino
$sql = "SELECT idciudad, nombre FROM city";
$resultadoCiudades = mysqli_query($conexion, $sql);
$ciudades = [];
while ($fila = mysqli_fetch_assoc($resultadoCiudades)) {
    $ciudades[] = $fila;
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Modificar Viaje</h2>

    <form action="modificarviaje.php" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="form-group mb-3">
            <label for="idviaje">ID del viaje a modificar:</label>
            <input type="number" id="idviaje" name="idviaje" class="form-control" placeholder="Introduce el ID del viaje" required>
        </div>

        <hr>

        <div class="form-group mb-3">
            <label for="idorigen">Origen:</label>
            <select id="idorigen" name="idorigen" class="form-select" required>
                <option value="">Seleccione origen</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="iddestino">Destino:</label>
            <select id="iddestino" name="iddestino" class="form-select" required>
                <option value="">Seleccione destino</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="fechasalida">Fecha de salida:</label>
            <input type="datetime-local" id="fechasalida" name="fechasalida" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="fecharegreso">Fecha de regreso:</label>
            <input type="datetime-local" id="fecharegreso" name="fecharegreso" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="duracion">Duración (días):</label>
            <input type="number" id="duracion" name="duracion" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="preciobase">Precio base (€):</label>
            <input type="number" step="0.01" id="preciobase" name="preciobase" class="form-control" required>
        </div>

        <div class="form-group mb-4 form-check">
            <input type="checkbox" id="cocheHotel" name="cocheHotel" class="form-check-input" value="1">
            <label class="form-check-label" for="cocheHotel">Incluye coche/hotel</label>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">Modificar Viaje</button>
        </div>
    </form>

    <?php echo $mensaje; ?>
</div>
