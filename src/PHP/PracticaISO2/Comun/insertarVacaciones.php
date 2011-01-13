<?php session_start();

$fechaInicio = $_GET['fechaIni'];
$duracion= $_GET['duracion'];
$duracion=($duracion * 7)-1;
$fechaFin= date("Y-m-d", strtotime("$fechaInicio + $duracion days"));


include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        $result1= mysql_query("INSERT INTO Vacaciones VALUES(NULL,'"
                    . $fechaInicio."','"
                    . $fechaFin."','"
                    . $_SESSION['dni']. "')");
        
        echo $fechaInicio ." ". $duracion . " ". ($duracion * 7). " ".$fechaFin;
         $conexion->cerrarConexion();

?>
