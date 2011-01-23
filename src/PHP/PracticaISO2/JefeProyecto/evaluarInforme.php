<?php

$idInf = $_GET['idInf'];
$e1 = $_GET['e'];

if ($e1 == 0) {
    $estado = 'Aceptado';
} else if ($e1 == 1) {
    $estado = 'Cancelado';
}

include_once('../Persistencia/conexion.php');
$conexion = new conexion();

$result = mysql_query("UPDATE InformeTareas SET estado='"
        .$estado
        ."' WHERE idInformeTareas="
        .$idInf);

$conexion->cerrarConexion();

?>