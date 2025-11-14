<?php
require_once 'funcionesViajes.php';
require_once 'funcionesBD.php';

$conn = conexionBD();
$ciudades = $conn->query("SELECT idciudad, nombre FROM city");
$conn->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    altaViaje($_POST['idorigen'], $_POST['iddestino'], $_POST['fechasalida'], $_POST['fecharegreso'], $_POST['duracion'], $_POST['preciobase'], $_POST['cocheHotel']);
    $mensaje = "Viaje agregado correctamente";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Viaje</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Alta de Viaje</h2>
    <?php if(isset($mensaje)) echo "<div class='alert alert-success'>$mensaje</div>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Origen</label>
            <select name="idorigen" class="form-select" required>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Destino</label>
            <select name="iddestino" class="form-select" required>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>"><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Fecha de salida</label>
            <input type="datetime-local" name="fechasalida" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha de regreso</label>
            <input type="datetime-local" name="fecharegreso" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Duración (días)</label>
            <input type="number" name="duracion" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Precio base</label>
            <input type="number" step="0.01" name="preciobase" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Incluye coche/hotel</label>
            <select name="cocheHotel" class="form-select">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Agregar</button>
    </form>
</div>
</body>
</html>
