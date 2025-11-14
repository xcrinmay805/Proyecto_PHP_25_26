<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

// Consulta todos los viajes y traemos nombres de ciudad
$sql = "SELECT t.idviaje, c1.nombre AS origen, c2.nombre AS destino, t.fechasalida, t.fecharegreso, t.duracion, t.preciobase, t.cocheHotel
        FROM trip t
        JOIN city c1 ON t.idorigen = c1.idciudad
        JOIN city c2 ON t.iddestino = c2.idciudad
        ORDER BY t.idviaje ASC";

$resultado = mysqli_query($conexion, $sql);

include_once("cabecera.html");
?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Listado de Viajes</h2>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha Salida</th>
                <th>Fecha Regreso</th>
                <th>Duración (días)</th>
                <th>Precio Base (€)</th>
                <th>Coche/Hotel</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($resultado) > 0): ?>
                <?php while($viaje = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= $viaje['idviaje'] ?></td>
                        <td><?= $viaje['origen'] ?></td>
                        <td><?= $viaje['destino'] ?></td>
                        <td><?= $viaje['fechasalida'] ?></td>
                        <td><?= $viaje['fecharegreso'] ?></td>
                        <td><?= $viaje['duracion'] ?></td>
                        <td><?= number_format($viaje['preciobase'], 2) ?></td>
                        <td><?= $viaje['cocheHotel'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <a href="modificarviaje.php?id=<?= $viaje['idviaje'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="borrarviaje.php?id=<?= $viaje['idviaje'] ?>" class="btn btn-danger btn-sm">Borrar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">No hay viajes registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center">
        <a href="altaviaje.php" class="btn btn-success">Agregar Nuevo Viaje</a>
    </div>
</div>
