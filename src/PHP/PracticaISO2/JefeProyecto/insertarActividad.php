<?php session_start();

$IterNext = $_GET['INext'];
$nombre = $_GET['nombreA'];
$rol = $_GET['rolA'];
$duracion= $_GET['duracion'];
$primeraI = $_GET['primeraI'];

if ($primeraI != -1){
    $IterNext = $primeraI;
}
include_once('../Persistencia/conexion.php');
        $conexion = new conexion();

        //Insertamos la actividad en cuestion
         $result1= mysql_query("INSERT INTO Actividad VALUES(NULL,'"
                    . $IterNext."','"
                    . utf8_decode($nombre). "','"
                    . $duracion ."',NULL,NULL,'"
                    . utf8_decode($rol) ."')");

     
         $result2 = mysql_query("SELECT nombre FROM Actividad WHERE\n"
            . "Iteracion_idIteracion = \"".$IterNext. "\"");

        $totEmp2 = mysql_num_rows($result2);
        if ($totEmp2 >0) {
            $actividades= "<br/><b>Actividades asignadas:</b><br/>";
            while ($rowEmp2 = mysql_fetch_assoc($result2)) {
                $actividades = $actividades . "&nbsp; <i>".$rowEmp2['nombre']."</i><br/>"; }
        }

//
        

        
            echo  utf8_encode($actividades);
        $conexion->cerrarConexion();

?>
