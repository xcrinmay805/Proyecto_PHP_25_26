<?php
require_once("funcionesBD.php");
$conexion = obtenerConexion();


$mensaje = "";



    $sql = "SELECT idpaquete, nombrepaquete, descripcion, preciopaquete, incluyehotel, idviaje, contratacion, idcliente 
            FROM package;";



    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        
    

        $mensaje .= "<h2 class='text-center'>Lista de Paquetes</h2>";
        $mensaje .= "<table class='table table-striped mt-4'>";
        $mensaje .= "<thead><tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCION</th>
                        <th>PRECIO</th>
                        <th>HOTEL INCLUIDO</th>
                        <th>ID VIAJE</th>
                        <th>CONTRATACION</th>
                        <th>ID CLIENTE</th>
                    </tr></thead><tbody>";



        while ($fila = mysqli_fetch_assoc($resultado)) {
            $mensaje .= "<tr>";
            $mensaje .= "<td>" . $fila['idpaquete'] . "</td>";
            $mensaje .= "<td>" . $fila['nombrepaquete'] . "</td>";
            $mensaje .= "<td>" . $fila['descripcion'] . "</td>";
            $mensaje .= "<td>" . $fila['preciopaquete'] . "</td>";
            $mensaje .= "<td>" . ($fila['incluyehotel'] ? 'Sí' : 'No') . "</td>";
            $mensaje .= "<td>" . $fila['idviaje'] . "</td>";
            $mensaje .= "<td>" . $fila['contratacion'] . "</td>";
            $mensaje .= "<td>" . $fila['idcliente'] . "</td>";
            


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