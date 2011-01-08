<?php session_start();

$nombre = $_GET['nombre'];
$url = $_GET['url'];
$comm = $_GET['comm'];

include_once('../Persistencia/conexion.php');
        $conexion = new conexion();
//editamos la tupla artefacto
        $result6= mysql_query("UPDATE Artefacto SET nombre ='"
             . utf8_decode($nombre) . "', url='"
             . utf8_decode($url) . "', comentarios='"
             . utf8_decode($comm) . "'"
             . " WHERE Actividad_idActividad ='"
                 . $_SESSION['ActividadEscogida'] ."'");






//echo $FaseNext ."--". $numIt;
$conexion->cerrarConexion();

?>
