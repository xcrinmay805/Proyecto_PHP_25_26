<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();

$mensaje = "";


if (isset($_GET['btnBuscar'])) {

    
    $nombre = trim($_GET['txtNombre'] ?? "");
    $telefono = trim($_GET['txtTelefono'] ?? "");
    $email = trim($_GET['txtEmail'] ?? "");
    $soloActivos = isset($_GET['chkActivo']) ? 1 : null;

    
    if (empty($nombre) && empty($telefono) && empty($email) && $soloActivos === null) {
        $mensaje = "<div class='alert alert-danger text-center mt-3'>Por favor, introduce al menos un criterio de búsqueda.</div>";
    } else {

        
        $sql = "SELECT idcliente, nombre, telefono, email, activo, fecharegistro 
                FROM client 
                WHERE 1=1";

        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE '%" . mysqli_real_escape_string($conexion, $nombre) . "%'";
        }
        if (!empty($telefono)) {
            $sql .= " AND telefono LIKE '%" . mysqli_real_escape_string($conexion, $telefono) . "%'";
        }
        if (!empty($email)) {
            $sql .= " AND email LIKE '%" . mysqli_real_escape_string($conexion, $email) . "%'";
        }
        if ($soloActivos !== null) {
            $sql .= " AND activo = 1";
        }

        $sql .= " ORDER BY idcliente ASC;";

        
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            
            $mensaje .= "<h2>Resultados de la búsqueda</h2>";
            $mensaje .= "<table class='table table-striped mt-4'>";
            $mensaje .= "<thead><tr>
                            <th>IDCLIENTE</th>
                            <th>NOMBRE</th>
                            <th>TELÉFONO</th>
                            <th>EMAIL</th>
                            <th>ACTIVO</th>
                            <th>FECHA REGISTRO</th>
                        </tr></thead><tbody>";

            while ($fila = mysqli_fetch_assoc($resultado)) {
                $mensaje .= "<tr>";
                $mensaje .= "<td>" . $fila['idcliente'] . "</td>";
                $mensaje .= "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                $mensaje .= "<td>" . htmlspecialchars($fila['telefono']) . "</td>";
                $mensaje .= "<td>" . htmlspecialchars($fila['email']) . "</td>";
                $mensaje .= "<td>" . ($fila['activo'] ? 'Sí' : 'No') . "</td>";
                $mensaje .= "<td>" . $fila['fecharegistro'] . "</td>";

                

                $mensaje .= "</tr>";
            }

            $mensaje .= "</tbody></table>";

        } else {
            $mensaje = "<div class='alert alert-warning text-center mt-3'>No se encontraron clientes con esos criterios.</div>";
        }
    }
}

mysqli_close($conexion);
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="lista_segun_criterio.php" name="frmBuscarCliente" id="frmBuscarCliente" method="get">
            <fieldset>
                <legend>Listado según criterios</legend>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtNombre">Nombre contiene:</label>
                    <div class="col-xs-4">
                        <input id="txtNombre" name="txtNombre" placeholder="Nombre del Cliente" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtTelefono">Teléfono contiene:</label>
                    <div class="col-xs-4">
                        <input id="txtTelefono" name="txtTelefono" placeholder="Teléfono del Cliente" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="col-xs-4 control-label" for="txtEmail">Correo contiene:</label>
                    <div class="col-xs-4">
                        <input id="txtEmail" name="txtEmail" placeholder="Correo del Cliente" class="form-control input-md" type="text">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="col-xs-4">
                        <label><input type="checkbox" name="chkActivo" value="1"> Solo clientes activos</label>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="col-xs-4 col-xs-offset-4">
                        <input type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-primary" value="Buscar" />
                    </div>
                </div>
            </fieldset>
        </form>

        
        <div class="col-12 mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</div>
</body>
</html>
