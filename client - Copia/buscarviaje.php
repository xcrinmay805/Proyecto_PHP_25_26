<?php
require_once 'funcionesBD.php';
$conn = conexionBD();

$ciudades = $conn->query("SELECT idciudad, nombre FROM city");

$idorigen = $_GET['idorigen'] ?? '';
$iddestino = $_GET['iddestino'] ?? '';
$fecha = $_GET['fecha'] ?? '';

$sql = "SELECT t.*, c1.nombre AS origen, c2.nombre AS destino
        FROM trip t
        JOIN city c1 ON t.idorigen = c1.idciudad
        JOIN city c2 ON t.iddestino = c2.idciudad
        WHERE 1=1";

if($idorigen != '') $sql .= " AND t.idorigen=$idorigen";
if($iddestino != '') $sql .= " AND t.iddestino=$iddestino";
if($fecha != '') $sql .= " AND DATE(t.fechasalida)='$fecha'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Viaje</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Buscar Viaje</h2>

    <form method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Origen</label>
            <select name="idorigen" class="form-select">
                <option value="">Todos</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>" <?= $idorigen==$c['idciudad']?'selected':'' ?>><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label>Destino</label>
            <select name="iddestino" class="form-select">
                <option value="">Todos</option>
                <?php foreach($ciudades as $c): ?>
                    <option value="<?= $c['idciudad'] ?>" <?= $iddestino==$c['idciudad']?'selected':'' ?>><?= $c['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label>Fecha salida</label>
            <input type="date" name="fecha" class="form-control" value="<?= $fecha ?>">
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Salida</th>
            <th>Regreso</th>
            <th>Duración</th>
            <th>Precio</th>
            <th>Coche/Hotel</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php while($v = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $v['idviaje'] ?></td>
                <td><?= $v['origen'] ?></td>
                <td><?= $v['destino'] ?></td>
                <td><?= $v['fechasalida'] ?></td>
                <td><?= $v['fecharegreso'] ?></td>
                <td><?= $v['duracion'] ?></td>
                <td><?= $v['preciobase'] ?></td>
                <td><?= $v['cocheHotel'] ? 'Sí' : 'No' ?></td>
                <td>
                    <a href="modificarviaje.php?id=<?= $v['idviaje'] ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="borrarviaje.php?id=<?= $v['idviaje'] ?>" class="btn btn-danger btn-sm">Borrar</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="altaviaje.php" class="btn btn-success">Agregar Nuevo Viaje</a>
</div>
</body>
</html>
