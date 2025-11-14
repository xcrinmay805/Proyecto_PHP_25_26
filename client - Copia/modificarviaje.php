<?php
require_once 'funcionesViajes.php';
require_once 'funcionesBD.php';

$conn = conexionBD();
$ciudades = $conn->query("SELECT idciudad, nombre FROM city");
$conn->close();

if(isset($_GET['id'])) {
    $viaje = buscarViaje($_GET['id']);
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    modificarViaje($_POST['id'], $_POST['idorigen'], $_POST['iddestino'], $_POST['fechasalida'], $_POST['fecharegreso'], $_POST['duracion'], $_POST['preciobase'], $_POST['cocheHotel']);
    header('Location: listaviajes.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Viaje</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Modificar Viaje</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $viaje['idviaje'] ?>">
        <div class="mb-3">
            <label>Origen</label>
            <select name="idorigen" class="form-select" required>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>" <?= $viaje['idorigen']==$c['idciudad']?'selected':'' ?>><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Destino</label>
            <select name="iddestino" class="form-select" required>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>" <?= $viaje['iddestino']==$c['idciudad']?'selected':'' ?>><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Fecha de salida</label>
            <input type="datetime-local" name="fechasalida" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($viaje['fechasalida'])) ?>" required>
        </div>
        <div class="mb-3">
            <label>Fecha de regreso</label>
            <input type="datetime-local" name="fecharegreso" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($viaje['fecharegreso'])) ?>" required>
        </div>
        <div class="mb-3">
            <label>Duración (días)</label>
            <input type="number" name="duracion" class="form-control" value="<?= $viaje['duracion'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Precio base</label>
            <input type="number" step="0.01" name="preciobase" class="form-control" value="<?= $viaje['preciobase'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Incluye coche/hotel</label>
            <select name="cocheHotel" class="form-select">
                <option value="1" <?= $viaje['cocheHotel'] ? 'selected' : '' ?>>Sí</option>
                <option value="0" <?= !$viaje['cocheHotel'] ? 'selected' : '' ?>>No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
</body>
</html>
