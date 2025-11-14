<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();


$mensaje = "";



    $sql = "SELECT idcliente, nombre, telefono, email, activo, fecharegistro 
            FROM client;";



    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        
    

        $mensaje .= "<h2 class='text-center'>Lista de Clientes</h2>";
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
            $mensaje .= "<td>" . $fila['nombre'] . "</td>";
            $mensaje .= "<td>" . $fila['telefono'] . "</td>";
            $mensaje .= "<td>" . $fila['email'] . "</td>";
            $mensaje .= "<td>" . ($fila['activo'] ? 'Sí' : 'No') . "</td>";
            $mensaje .= "<td>" . $fila['fecharegistro'] . "</td>";
            


            $mensaje .= "</tr>";
            
        }

        $mensaje .= "</tbody></table>";
    


    }

mysqli_close($conexion);

include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
    
        <div class="col-12 mt-4">
            <?php echo $mensaje; ?>
        </div>
    </div>
</div>
</body>
</html>