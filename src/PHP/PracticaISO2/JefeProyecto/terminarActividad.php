<?php session_start();

$idAct = $_GET['idAct'];

include_once('../Persistencia/conexion.php');
$conexion = new conexion();

$fecha_actual=date("Y-m-d");

$result = mysql_query("UPDATE Actividad SET fechaFin='"
        .$fecha_actual
        ."' WHERE idActividad="
        .$idAct);
$totEmp = mysql_num_rows($result);

$conexion->cerrarConexion();


?>
