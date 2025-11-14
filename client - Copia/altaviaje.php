<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

// Traer ciudades para los select de origen y destino
$sql = "SELECT idciudad, nombre FROM city";
$resultado = mysqli_query($conexion, $sql);

$ciudades = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $ciudades[] = $fila;
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idorigen = $_POST['idorigen'];
    $iddestino = $_POST['iddestino'];
    $fechasalida = $_POST['fechasalida'];
    $fecharegreso = $_POST['fecharegreso'];
    $duracion = $_POST['duracion'];
    $preciobase = $_POST['preciobase'];
    $cocheHotel = isset($_POST['cocheHotel']) ? 1 : 0;

    $sql = "INSERT INTO trip (idorigen, iddestino, fechasalida, fecharegreso, duracion, preciobase, cocheHotel)
            VALUES ('$idorigen', '$iddestino', '$fechasalida', '$fecharegreso', '$duracion', '$preciobase', '$cocheHotel')";

    if (mysqli_query($conexion, $sql)) {
        $mensaje = "<div class='alert alert-success text-center mt-3'>✅ Viaje agregado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>❌ Error al agregar viaje: " . mysqli_error($conexion) . "</div>";
    }
}

include_once("cabecera.html");
?>

<div class="container mt-4">
    <h2>Alta de Viaje</h2>
    <?php if(isset($mensaje)) echo $mensaje; ?>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label for="idorigen" class="form-label">Origen</label>
            <select name="idorigen" id="idorigen" class="form-select" required>
                <option value="">Seleccione origen</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="iddestino" class="form-label">Destino</label>
            <select name="iddestino" id="iddestino" class="form-select" required>
                <option value="">Seleccione destino</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fechasalida" class="form-label">Fecha de salida</label>
            <input type="datetime-local" name="fechasalida" id="fechasalida" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecharegreso" class="form-label">Fecha de regreso</label>
            <input type="datetime-local" name="fecharegreso" id="fecharegreso" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="duracion" class="form-label">Duración (días)</label>
            <input type="number" name="duracion" id="duracion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="preciobase" class="form-label">Precio base</label>
            <input type="number" step="0.01" name="preciobase" id="preciobase" class="form-control" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="cocheHotel" id="cocheHotel" class="form-check-input" value="1">
            <label class="form-check-label" for="cocheHotel">Incluye coche/hotel</label>
        </div>

        <button type="submit" class="btn btn-primary">Agregar Viaje</button>
    </form>
</div>
