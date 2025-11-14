<?php
require_once 'funcionesViajes.php';
$viajes = listarViajes();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Viajes</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Lista de Viajes</h2>
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
        <?php foreach($viajes as $v): ?>
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
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="altaviaje.php" class="btn btn-success">Agregar Nuevo Viaje</a>
</div>
</body>
</html>
