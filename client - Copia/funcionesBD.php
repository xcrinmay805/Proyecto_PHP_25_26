<?php
function obtenerConexion() {
    
    mysqli_report(MYSQLI_REPORT_OFF);

    $conexion = new mysqli("db", "root", "test", "Viajes","3306");
    
    mysqli_set_charset($conexion, 'utf8');

    return $conexion;
}
