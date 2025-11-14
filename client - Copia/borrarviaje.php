<?php
require_once 'funcionesViajes.php';
if (isset($_GET['id'])) {
    borrarViaje($_GET['id']);
}
header('Location: listaviajes.php');
exit;
?>
